<?php

global $db, $current_user;

if (!is_admin($current_user)) {
    sugar_die("Unauthorized access to administration.");
}

//begin
echo "Creating SugarCRM OData.<br>\n";
ob_flush();

//check SugarOData
$query = "select name from suga_sugarodata where deleted = 0";
$result = $db->query($query);


//rebuild OData class source
$classfile = "custom/odata/services/IDataServiceQueryProvider2 Implementation/SugarCRM/newclass.php";
$file = fopen($classfile, "w+");
$c = '';
$tables = array();
while ($row = $db->fetchByAssoc($result)) {
    $tables[] = $row['name'];
    $c .= generateclass($classfile, $row['name'], $file);
}

fwrite($file, $c);
fclose($file);
echo "Done.<br>\n";
if(!empty($tables)) {
    echo "OData Table<br>\n";
    foreach($tables as $k => $val) {
        echo "<a href='http://".$_SERVER['HTTP_HOST'].'/custom/odata/SugarCRM2.svc/'.ucfirst($val)."' target='_blank'>http://".$_SERVER['HTTP_HOST'].'/custom/odata/SugarCRM2.svc/'.ucfirst($val)."</a><br>\n";
    }
}

//generate class
function generateclass($filename, $table, $file) {
    global $db;
    $key = '';
    $c = '';

    $contents = @fread($file, filesize($filename));
    if(strlen($contents) > 0) {
        $c .= $contents;
    } 
    $c .= "<?php

class $table
{

";

    $sql = "SHOW COLUMNS FROM $table;";
    $result = $db->query($sql);

    while ($row = $db->fetchRow($result)) {
        $col = $row['Field'];
        if ($col != $key) {
            $c.= "public $$col;";
        }
    }

    $c.= "
}
?>
";
    return $c;
}

