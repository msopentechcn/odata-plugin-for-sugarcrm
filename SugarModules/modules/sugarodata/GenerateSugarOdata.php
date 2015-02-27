<?php

global $db, $current_user, $mod_strings;

if (!is_admin($current_user)) {
    sugar_die("Unauthorized access to administration.");
}

//begin
echo $mod_strings['LBL_CREATING_ODATA'] . "<br>\n";
ob_flush();

//check SugarOData
$query = "select tablename from sugarodata where deleted = 0";
$result = $db->query($query);


//rebuild OData class source
$classfile = $_SERVER['DOCUMENT_ROOT'] . "/odata/services/IDataServiceQueryProvider2 Implementation/SugarCRM/newclass.php";
$file = @fopen($classfile, "w+");
$c = '';
$tables = array();
while ($row = $db->fetchByAssoc($result)) {
    $tables[] = $row['tablename'];
    $c .= generateclass($classfile, $row['tablename'], $file);
}

@fwrite($file, $c);
@fclose($file);   
echo $mod_strings['LBL_DONE']."<br>\n";
if(!empty($tables)) {
    echo $mod_strings['LBL_ODATA_LIST']."<br>\n";
    foreach($tables as $k => $val) {
        echo "<a href='http://".$_SERVER['HTTP_HOST'].'/odata/SugarCRM2.svc/'.ucfirst($val)."' target='_blank'>http://".$_SERVER['HTTP_HOST'].'/odata/SugarCRM2.svc/'.ucfirst($val)."</a><br>\n";
    }
}

//generate class
function generateclass($filename, $table, $file) {
    global $db;
    $key = '';

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

?>
