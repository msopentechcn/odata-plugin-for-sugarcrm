<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

$module_name = 'sugarodata';
$subpanel_layout = array(
    'top_buttons' => array(
        array('widget_class' => 'SubPanelTopCreateButton'),
        array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => $module_name),
    ),
    'where' => '',
    'list_fields' => array(
//        'id' => array(
//            'vname' => 'LBL_ID',
//            'widget_class' => 'SubPanelDetailViewLink',
//            'width' => '45%',
//        ),
        'tablename' => array(
            'vname' => 'LBL_TABLENAME',
            'width' => '90%',
        ),
        'edit_button' => array(
            'widget_class' => 'SubPanelEditButton',
            'module' => $module_name,
            'width' => '4%',
        ),
        'remove_button' => array(
            'widget_class' => 'SubPanelRemoveButton',
            'module' => $module_name,
            'width' => '5%',
        ),
    ),
);
?>
