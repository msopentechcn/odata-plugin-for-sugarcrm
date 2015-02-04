<?php
//get table name
global $db;
$query = "show tables";
$result = $db->query($query);
$table = array();
while ($row = $db->fetchByAssoc($result)) {
    $tables[] = $row['Tables_in_'.$db->connectOptions['db_name']];
}
//$tbs = implode(',', $tables);
$tb = '';
if(!empty($tables)) {
    $tb .= "<select >"; 
    foreach($tables as $v) {
        $tb .= '<option>'.$v.'</option>';
    }
    $tb .= "</select>"; 
}

$module_name = 'sugarodata';
$viewdefs [$module_name] = array(
    'EditView' =>
    array(
        'templateMeta' =>
        array(
            'maxColumns' => '2',
            'widths' =>
            array(
                0 =>
                array(
                    'label' => '10',
                    'field' => '30',
                ),
                1 =>
                array(
                    'label' => '10',
                    'field' => '30',
                ),
            ),
        ),
        'panels' =>
        array(
            'default' =>
            array(
                0 =>
                array(
                    0 =>
                    array(
                        'name' => 'tablename',
                        'label' => 'LBL_TABLENAME',
                    ),
                    1 =>
                    array(
                        'name' => 'LBL_TABLENAME_LIST',
                        'label' => 'You can save your table name in this list:'.$tb,
                    ),                    
                ),
            ),
        ),
    ),
);
?>
