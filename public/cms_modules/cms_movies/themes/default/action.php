<?php
if(!isset($_POST['go']))$_POST['go'] = false;
if(!isset($_POST['delete']))$_POST['delete'] = false;
if(!isset($_POST['section']))$_POST['section'] = false;
if(!isset($_POST['map_gallery']))$_POST['map_gallery'] = false;
if(!isset($_POST['unmap_gallery']))$_POST['unmap_gallery'] = false;
if(!isset($_POST['language_visibility']))$_POST['language_visibility'] = false;
if(!isset($_POST['add_menu_id']))$_POST['add_menu_id'] = false;
if(!isset($_POST['remove_menu_id']))$_POST['remove_menu_id'] = false;
if(!isset($_POST['add_category_id']))$_POST['add_category_id'] = false;
if(!isset($_POST['remove_category_id']))$_POST['remove_category_id'] = false;

try{


	ini_set("include_path",ini_get('include_path').PATH_SEPARATOR.realpath('../../'));
 	require_once("smarty/Smarty.class.php");

	$GLOBALS['project_folder']="/www";

	$smarty = new Smarty();
	$smarty->register_resource('Proxia', array(
												'Proxia_getTemplate',
												'Proxia_getTimestamp',
												'Proxia_isSecure',
												'Proxia_isTrusted'
											));

	$smarty->plugins_dir[] = 'themes/default/smarty_plugins';

	$smarty->template_dir = "themes/default/templates/templates";
	$smarty->compile_dir = "themes/default/templates/templates_c";
	$smarty->cache_dir = "themes/default/templates/cache";
	$smarty->config_dir = "themes/default/templates/configs";

	$GLOBALS["smarty"] = $smarty;

	if(!isset($_POST['goIn']))$_POST['goIn'] = false;
	if(!isset($_POST['section']))$_POST['section'] = false;

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
	$module_detail = CMS_Module::addModule('CMS_EventCalendar');
	$module_detail->utilise();
	$GLOBALS["config_all"] = CN_Config::loadFromFile($path."/config.xml");

	// LANGUAGE LOCAL
	$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
	$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();

	$user_detail = CMS_UserLogin::getSingleton()->getUser();
	$GLOBALS['localLanguage'] = $user_detail->getConfigValue('default_local_language');
	if (!$GLOBALS['localLanguage'])
		$GLOBALS['localLanguage'] = getConfig('proxia','default_local_language');

	$GLOBALS['localLanguageDefault'] = getConfig('proxia','default_local_language');
	$smarty->assign("localLanguageDefault",$GLOBALS['localLanguageDefault']);

	$GLOBALS['LanguageListLocal'] = array();
	foreach ($GLOBALS['LanguageList'] as $value){
		if ($value['local_visibility']){
			$a[$value['code']] = $value;
			$GLOBALS['LanguageListLocal'] = array_merge($GLOBALS['LanguageListLocal'],$a);
		}
	}
	$smarty->assign("LanguageListLocal",$GLOBALS['LanguageListLocal']);

	$mod = CMS_Module::addModule('CMS_Gallery');
	$mod->utilise();

	$GLOBALS['user_login_type'] = $_SESSION['user']['type'];
	$GLOBALS['user_login'] = CMS_UserLogin::getSingleton()->getUser();

	$prefered_language = $GLOBALS['user_login']->getConfigValue('prefered_language');
	CN_Application::getSingleton()->setLanguage($prefered_language);

	if(!isset($_POST['goAjax']))$_POST['goAjax'] = false;

	if (is_Array($_POST['row_id']) && $_POST['goAjax'] == false){

		// PRESMERUJE NA UPDATE COMPANY
		if($_POST['go']==3){
			$ignore = array ("mcmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: ../../admin/?mcmd=3&module=CMS_Movies$link");
			exit;
		}

		if ($_POST['section'] == 'update'){
			if($_POST['c_valid_from']=='')$_POST['c_valid_from'] = null;
			//if($_POST['c_valid_to']=='')$_POST['c_valid_to'] = null;
			if($_POST['c_real_date_start']=='')$_POST['c_real_date_start'] = null;
			//if($_POST['c_real_date_end']=='')$_POST['c_real_date_end'] = null;
			
			$_POST['c_image'] = $_POST['f_image'];
			$_POST['c_video'] = $_POST['f_video'];
			
			if($_POST['c_image']=='')$_POST['f_image'] = '';
			if($_POST['c_video']=='')$_POST['f_video'] = null;
			if(!isset($_POST['c_isPublished']))$_POST['c_isPublished'] = 0;
		}

		foreach ($_POST['row_id'] as $name => $id){
			$movie = $id === '0' ? new CMS_Movies() : new CMS_Movies($id);
			$movie->setContextLanguage($GLOBALS['localLanguage']);

			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'c_') !== FALSE){
					$column_name = str_replace('c_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					if( $column_name == "price")
						$movie->$function(1*$value);
					else
						$movie->$function($value);
				}
			}// END FOREACH F_

			$movie->save();

			$new_id = $movie->getId();

			if($_POST['delete']==1){
				$movie->delete();
			}

			if ($_POST['map_gallery']){
				$mod = CMS_Module::addModule('CMS_Gallery');
				$mod->utilise();

				$movie->addGallery(new CMS_Gallery($_POST['map_gallery']));

			}
			
			
			if ($_POST['unmap_gallery']){
				$mod = CMS_Module::addModule('CMS_Gallery');
				$mod->utilise();

				$movie->removeGallery(new CMS_Gallery($_POST['unmap_gallery']));

			}

			if ($_POST['language_visibility']==1){
						$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
						$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();
						foreach ($GLOBALS['LanguageList'] as $value){

							$code = $value['code'];
							$local_visibility = $value['local_visibility'];
							if ($local_visibility) {
								$valname = "a_languageIsVisible".$code;
								if(!isset($_POST[$valname]))$_POST[$valname] = 0;
								$movie->setContextLanguage($code);
								$function = 'set'.ucfirst($column_name);

								$movie->setLanguageIsVisible($_POST[$valname]);
							}
						}
						$movie->save();
					}

		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']

	if($_POST['goAjax'] == 1)
	{
		switch($_REQUEST['section'])
		{

		###########################################################################################################
		################################################  EVENT ################################################
		###########################################################################################################

		case 'movie_bindgallery':{
			$movie = new CMS_Movies($_POST['row_id'][0]);

			if ($_POST['map_gallery'] && $_POST['map_gallery'] != "0"){
				$mod = CMS_Module::addModule('CMS_Gallery');
				$mod->utilise();
				$gallery = new CMS_Gallery($_POST['map_gallery']);
				$movie->addGallery($gallery);
			}

			if ($_POST['unmap_gallery']){
				$mod = CMS_Module::addModule('CMS_Gallery');
				$mod->utilise();
				$movie->removeGallery(new CMS_Gallery($_POST['unmap_gallery']));
			}

			$gallery_list_event = $movie->getGalleries();
			$gallery_list_array = array();

			foreach($gallery_list_event as $gallery_item)
			{
				$gallery_item->setContextLanguage($_SESSION['localLanguage']);
				if(trim($gallery_item->getTitle()) == "")
				{
					$gallery_item->setContextLanguage($GLOBALS['localLanguageDefault']);
					$gallery_list_array[] = array("title"=>"[".$gallery_item->getTitle()."]","id"=>$gallery_item->getId());
				}
				else
				{
					$gallery_list_array[] = array("title"=>$gallery_item->getTitle(),"id"=>$gallery_item->getId());
				}
			}
			$GLOBALS["smarty"]->assign("detail_movie",$movie);
			$GLOBALS["smarty"]->assign("gallery_list_items",$gallery_list_array);
			$GLOBALS["smarty"]->assign("count_gallery_items",count($gallery_list_array));
			$GLOBALS["smarty"]->display("ajax/movie_edit_bindgallery.tpl");
		}
		break;

		case 'movie_languages':{

			$movie = new CMS_Movies($_POST['row_id'][0]);

			foreach ($GLOBALS['LanguageList'] as $value)
			{
				$code = $value['code'];

				$local_visibility = $value['local_visibility'];

				if ($local_visibility)
				{
					$valname = "a_languageIsVisible".$code;

					if(!isset($_POST[$valname]))
						$_POST[$valname] = 0;

					$movie->setContextLanguage($code);

					$movie->setLanguageIsVisible($_POST[$valname]);
				}
			}
			$movie->save();

			// priprava na vypis zoznamu jazykovych nastaveni
			$GLOBALS["smarty"]->assign("detail_movie",$movie);

			// vypis zoznamu jazykovych nastaveni
			$GLOBALS["smarty"]->display("ajax/movie_edit_language_versions.tpl");

		}
		break;


		}
		exit;
	}
	############################################################################################################

	if ($_POST['go'] == 'list') {
		Header("Location: ../../admin/?mcmd=1&module=CMS_Movies");
		exit;
	}

	if ($_POST['go'] == 'edit') {
		$ignore = array ("row_id","mcmd","c_officialName","c_description","c_phone","c_fax","c_cell","c_email","c_street","c_city","c_zip","c_country","c_ico","c_dic","go","delete");
		$link = urlPost($ignore);
		Header("Location: ../../admin/?mcmd=3&module=CMS_Movies&row_id[]=$new_id$link");
		exit;
	}

	Header("Location: ../../admin/?module=CMS_Movies&mcmd=1");
	exit;


}
catch(CN_Exception $e){
	echo $e->displayDetails();
}
?>

