<?php

class sugarodata extends Basic {
	var $new_schema = true;
	var $module_dir = 'sugarodata';
	var $object_name = 'sugarodata';
	var $table_name = 'sugarodata';
	var $importable = true;
		var $id;
		var $tablename;
	
	function sugarodata(){	
		global $current_user;

		if ($_REQUEST['action'] == 'EditView' && $_REQUEST['module'] == 'sugarodata' && !is_admin($current_user))
			header("Location: index.php?module=sugarodata&action=no_access");
//		if ($_REQUEST['action'] == 'Delete' && $_REQUEST['module'] == 'sugarodata' && !is_admin($current_user))
//			header("Location: index.php?module=sugarodata&action=no_access");

		parent::Basic();
	}

	function bean_implements($interface){
		switch($interface){
			case 'ACL': return true;
		}
		return false;
	}
}
?>
