<?php

$module_name = 'sugarodata';
$searchdefs[$module_name] = array(
    'templateMeta' => array(
        'maxColumns' => '3',
        'widths' => array('label' => '10', 'field' => '30'),
    ),
    'layout' => array(
        'basic_search' => array(
            'tablename',
        ),
        'advanced_search' => array(
            'tablename',
        ),
    ),
);
?>
