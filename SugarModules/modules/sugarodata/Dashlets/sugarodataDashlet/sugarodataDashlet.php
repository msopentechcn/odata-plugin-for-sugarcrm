<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/sugarodata/sugarodata.php');

class sugarodataDashlet extends DashletGeneric { 
    function sugarodataDashlet($id, $def = null) {
		global $current_user, $app_strings;
		require('modules/sugarodata/metadata/dashletviewdefs.php');

        parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'sugarodata');

        $this->searchFields = $dashletData['sugarodataDashlet']['searchFields'];
        $this->columns = $dashletData['sugarodataDashlet']['columns'];

        $this->seedBean = new sugarodata();        
    }
}
