<?php

$admin_option_defs = array();
$admin_option_defs['SugarodataAdmin'] = array(
    'Sugarodata', 'LBL_SUGARODATA_ADMIN', 'LBL_SUGARODATA_ADMIN_DESCRIPTION', 'index.php?entryPoint=generateOData'
);

// Loop through the menus and add to the Users group
$tmp_menu_set = false;
foreach ($admin_group_header as $key => $values) {
    if ($values[0] == 'LBL_USERS_TITLE') {
        if ($sugar_config['sugar_version'] < 5.2)
            $admin_group_header[$key][3]['SugarodataAdmin'] = $admin_option_defs['SugarodataAdmin'];
        else
            $admin_group_header[$key][3]['Administration']['SugarodataAdmin'] = $admin_option_defs['SugarodataAdmin'];
        $tmp_menu_set = true;
    }
}

// Else create new group
if (!$tmp_menu_set) {
    if ($sugar_config['sugar_version'] < 5.2) {
        $admin_group_header[] = array('SUGARODATA_ADMIN_TITLE', '', false, $admin_option_defs, 'SUGARODATA_ADMIN_DESC');
    } else {
        $admin_group_header[] = array('SUGARODATA_ADMIN_TITLE', '', false, array('Administration' => $admin_option_defs), 'SUGARODATA_ADMIN_DESC');
    }
}