<?php
try{

include($GLOBALS['smarty']->get_template_vars(path_relative)."themes/default/scripts/functions.php");
switch ($_GET["mcmd"]) {
	// list company's *********************************************************************************
	case "1":{
			$company_all = new CMS_Company_CompanyList();
			$company_all->execute();
			$GLOBALS["smarty"]->assign("company_list",$company_all);
			$GLOBALS["smarty"]->display("list.tpl");
		}
	break;
	//*************************************************************************************************
	
	// new company *********************************************************************************
	case "2":{
			$users = new CMS_UserList();
			$users -> execute();
			
			$GLOBALS["smarty"]->assign("user_list",$users);
			
			$GLOBALS["smarty"]->display("new.tpl");
		}
	break;
	//*************************************************************************************************
	
	// update company *********************************************************************************
	case "3":{
			$company = new CMS_Company($_REQUEST['row_id'][0]);
			$company->execute();
			
			$users = new CMS_UserList();
			$users -> execute();
			
			$GLOBALS["smarty"]->assign("user_list",$users);
			
			$firmusers = $company->getUsers($offset=null, $limit=null, $execute=true);
				
			$GLOBALS["smarty"]->assign("user_firm_list",$firmusers);
			
			
			
			$GLOBALS["smarty"]->assign("detail_company",$company);
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