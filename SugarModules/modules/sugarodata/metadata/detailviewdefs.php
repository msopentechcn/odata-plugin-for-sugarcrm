<?php

$module_name = 'sugarodata';
$viewdefs [$module_name] = array(
    'DetailView' =>
    array(
        'templateMeta' =>
        array(
            'form' =>
            array(
                'buttons' =>
                array(
                    0 => 'EDIT',
                    1 => 'DUPLICATE',
                    2 => 'DELETE',
                ),
            ),
            'maxColumns' => '1',
            'widths' =>
            array(
                0 =>
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
                        'tablename' => 'tablename',
                        'label' => 'LBL_TABLENAME',
                    ),
                ),

            ),
        ),
    ),
);
?>
