<?php
try{
error_reporting(1);

//include($GLOBALS['smarty']->get_template_vars(path_relative)."themes/default/scripts/functions.php");

switch ($_GET["mcmd"]) {
	// list banner's *********************************************************************************
	case "1":{
			$banner_all = new CMS_BannerManager_BannerList();
			$banner_all->execute();
			$GLOBALS["smarty"]->assign("banner_list",$banner_all);
			$GLOBALS["smarty"]->display("list.tpl");
		}
	break;
	//*************************************************************************************************
	
	// new banner *********************************************************************************
	case "2":{		
		require_once ('themes/default/scripts/calendar.php');
			$GLOBALS["calendar"] = new DHTML_Calendar('themes/default/scripts/calendar/', 'sk-utf8', 'calendar-win2k-2', false);
			$GLOBALS["calendar"]->load_files();	
			$GLOBALS["smarty"]->display("new.tpl");
		}
	break;
	//*************************************************************************************************
	
	// update banner *********************************************************************************
	case "3":{
		require_once ('themes/default/scripts/calendar.php');
		$GLOBALS["calendar"] = new DHTML_Calendar('themes/default/scripts/calendar/', 'sk-utf8', 'calendar-win2k-2', false);
			$GLOBALS["calendar"]->load_files();
			
			$banner = new CMS_BannerManager_Banner($_REQUEST['row_id'][0]);
			$banner->execute();
			$GLOBALS["smarty"]->assign("detail_banner",$banner);
			$GLOBALS["smarty"]->display("edit.tpl");
		}
	break;
	//*************************************************************************************************
	
	}		
}
catch(CN_Exception $e){
			echo $e->getMessage();
			echo $e->displayDetails();
	}

?>