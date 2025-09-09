<?php
if(!isset($_POST['go']))$_POST['go'] = false;
if(!isset($_POST['delete']))$_POST['delete'] = false;

try{
	
	ini_set("include_path",ini_get('include_path').PATH_SEPARATOR.realpath('../../'));
	
	$GLOBALS['project_folder']="/_sub";
	
	##############################################
	# login
	
	if(isset($_SESSION['user'])){
		$u = CMS_UserLogin::getSingleton();
		
		if($_SESSION['user']['type'] == CMS_UserLogin::ADMIN_USER){
			$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);
			
			include("admin/dblogin.php");
			
			$data->setDataSource("proxia");
			$data->open();
			
			$u->setUserType(CMS_UserLogin::ADMIN_USER);
			$u->autoLogin();
		}
		elseif($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER){
			$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);
			
			if (!isset($GLOBALS['project_config']))
				$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);
				
			$data->setUser($GLOBALS['project_config']->getSqlUser());
			$data->setPassword($GLOBALS['project_config']->getSqlPassword());
			$data->setDataSource($GLOBALS['project_config']->getSqlDsn());
			$data->open();
	
			$u->setUserType(CMS_UserLogin::REGULAR_USER);
			$u->autoLogin();
		}
		
		CN_SqlDatabase::removeDatabase();
	}
	
	##############################################
	
	$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);
	
	include ("admin/themes/{$GLOBALS['current_theme']}/scripts/functions.php");
	
	$path = "../../".$GLOBALS['project_folder']."/".$_SESSION['user']['name']."/config";
 	
	//  START DB
	if (!isset($GLOBALS['project_config']))
		$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);
	
	$data->setUser($GLOBALS['project_config']->getSqlUser());
	$data->setPassword($GLOBALS['project_config']->getSqlPassword());
	
	$data->setDataSource($_SESSION['user']['dsn']);
	$data->open();
	
	####################################################################################################
	CN_ClassLoader::getSingleton()->addSearchPath('classes/');
	$module_detail = CMS_Module::addModule('CMS_Company');
	$module_detail->utilise();
	$GLOBALS["config_all"] = CN_Config::loadFromFile($path."/config.xml");
	
	// LANGUAGE LOCAL
	$user_detail = CMS_UserLogin::getSingleton()->getUser();
	$GLOBALS['localLanguage'] = $user_detail->getConfigValue('default_local_language');
	if (!$GLOBALS['localLanguage'])
		$GLOBALS['localLanguage'] = getConfig('proxia','default_local_language');
	
	if (is_Array($_POST['row_id'])){
		
		// PRESMERUJE NA UPDATE COMPANY
		if($_POST['go']==3){
			$ignore = array ("mcmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: ../../admin/?mcmd=3&module=CMS_Company$link");
			exit;
		}
		
		foreach ($_POST['row_id'] as $name => $id){
			$company = $id === '0' ? new CMS_Company() : new CMS_Company($id);
			$company->setContextLanguage($GLOBALS['localLanguage']);
			
			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'c_') !== FALSE){
					$column_name = str_replace('c_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$company->$function($value);
				}
			}// END FOREACH F_
			
			$company->save();
			$company->purgeUsers();
			
			if(!isset($_POST['firmusers']))
				$_POST['firmusers'] = array ();
			
			foreach ($_POST['firmusers'] as $value){
				$company->addUser(new CMS_User($value));
			}
			
			
			$new_id = $company->getId();
			
			if($_POST['delete']==1){
				$company->delete();
			}
			
		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']
	
	
	############################################################################################################
	
	if ($_POST['go'] == 'list') {
		Header("Location: ../../admin/?mcmd=1&module=CMS_Company");
		exit;
	}
	
	if ($_POST['go'] == 'edit') {
		$ignore = array ("row_id","mcmd","c_officialName","c_description","c_phone","c_fax","c_cell","c_email","c_street","c_city","c_zip","c_country","c_ico","c_dic","go","delete");
		$link = urlPost($ignore);
		Header("Location: ../../admin/?mcmd=3&module=CMS_Company&row_id[]=$new_id$link");
		exit;
	}
	
	Header("Location: ../../admin/?module=CMS_Company&mcmd=1");
	exit;
	
	
}
catch(CN_Exception $e){
	echo $e->displayDetails();
}
?>
