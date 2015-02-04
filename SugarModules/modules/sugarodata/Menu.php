<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

global $mod_strings, $app_strings, $sugar_config, $current_user;

if (is_admin($current_user))
    $module_menu[] = Array("index.php?module=sugarodata&action=EditView&return_module=sugarodata&return_action=DetailView", $mod_strings['LNK_NEW_RECORD'], "CreateSugarodata");
    $module_menu[] = Array("index.php?module=sugarodata&action=index&return_module=sugarodata&return_action=DetailView", $mod_strings['LNK_LIST'], "Sugarodata");

if (is_admin($current_user)) {
	$module_menu[]=Array("index.php?module=sugarodata&action=GenerateSugarOdata", $mod_strings['LNK_GENETATE'],"Generate");
}
