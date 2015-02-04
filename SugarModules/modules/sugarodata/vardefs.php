<?php

$dictionary['sugarodata'] = array(
    'table' => 'sugarodata',
    'audited' => false,
    'fields' => array(
        'id' =>
        array(
            'name' => 'id',
            'vname' => 'LBL_SUGARODATA_ID',
            'type' => 'int',
            'len' => '10',
        ),
        'tablename' =>
        array(
            'name' => 'tablename',
            'vname' => 'LBL_SUGARODATA_TABLENAME',
            'type' => 'varchar',
            'len' => '30'
        ),
    ),
    'relationships' => array(
    ),
    'optimistic_lock' => true,
);
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('sugarodata', 'sugarodata', array('basic'));
