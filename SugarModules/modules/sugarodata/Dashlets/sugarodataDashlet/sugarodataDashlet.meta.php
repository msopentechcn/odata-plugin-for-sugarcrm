<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');


global $app_strings;

$dashletMeta['teamDashlet'] = array('module' => 'sugarodata',
    'title' => translate('LBL_HOMEPAGE_TITLE', 'sugarodata'),
    'description' => 'A customizable view into sugarodata',
    'icon' => 'themes/default/images/icon_sugarodata_32.gif',
    'category' => 'Module Views');
