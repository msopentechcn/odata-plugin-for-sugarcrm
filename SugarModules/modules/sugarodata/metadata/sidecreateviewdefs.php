<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

global $mod_strings;
$module_name = 'sugarodata';
$viewdefs[$module_name]['SideQuickCreate'] = array(
    'templateMeta' => array('form' => array('buttons' => array('SAVE'),
            'button_location' => 'bottom',
            'headerTpl' => 'include/EditView/header.tpl',
            'footerTpl' => 'include/EditView/footer.tpl',
        ),
        'maxColumns' => '1',
        'panelClass' => 'none',
        'labelsOnTop' => true,
        'widths' => array(
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' => array(
        'DEFAULT' =>
        array(
//            array(
//                array('name' => 'id', 'displayParams' => array('required' => true, 'size' => 20)),
//            ),
            array(
                array('name' => 'tablename', 'displayParams' => array('rows' => 3, 'cols' => 20)),
            ),
        ),
    )
);
?>
