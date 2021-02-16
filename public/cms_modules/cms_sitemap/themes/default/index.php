<?php
try{
switch ($_GET["mcmd"]) {
	// list of site map *********************************************************************************
	case "1":{

			include($GLOBALS['smarty']->get_template_vars('path_relative')."themes/default/scripts/treeSite.php");
		}
	break;
	//*************************************************************************************************

	}		
}
catch(CN_Exception $e){
			echo $e->getMessage();
			echo $e->displayDetails();
	}

