<?php

use cms_modules\cms_catalog\classes\CMS_Catalog;
use cms_modules\cms_event_calendar\classes\CMS_EventCalendar_Event;
use cms_modules\cms_gallery\classes\CMS_Gallery;

require_once '__init__.php';

// kontrola na vyprsanie session ak by zlyhal JS countdown
if(!isset($_SESSION['user']) && !isset($_POST['login_form'])){
	Header("Location: ./?cmd=logout");
	exit;
}

try{

if(!isset($_POST['section']))$_POST['section'] = false;
if(!isset($_POST['add_menu_id']))$_POST['add_menu_id'] = false;
if(!isset($_POST['add_category_id']))$_POST['add_category_id'] = false;
if(!isset($_POST['remove_menu_id']))$_POST['remove_menu_id'] = false;
if(!isset($_POST['remove_category_id']))$_POST['remove_category_id'] = false;
if(!isset($_POST['restore']))$_POST['restore'] = false;
if(!isset($_POST['delete']))$_POST['delete'] = false;
if(!isset($_POST['trash']))$_POST['trash'] = false;
if(!isset($_POST['move_down']))$_POST['move_down'] = false;
if(!isset($_POST['move_up']))$_POST['move_up'] = false;
if(!isset($_POST['move_down_in_menu']))$_POST['move_down_in_menu'] = false;
if(!isset($_POST['move_up_in_menu']))$_POST['move_up_in_menu'] = false;
if(!isset($_POST['move_top_in_menu']))$_POST['move_top_in_menu'] = false;
if(!isset($_POST['move_bottom_in_menu']))$_POST['move_bottom_in_menu'] = false;
if(!isset($_POST['move_down_in_category']))$_POST['move_down_in_category'] = false;
if(!isset($_POST['move_up_in_category']))$_POST['move_up_in_category'] = false;
if(!isset($_POST['move_top_in_category']))$_POST['move_top_in_category'] = false;
if(!isset($_POST['move_bottom_in_category']))$_POST['move_bottom_in_category'] = false;
if(!isset($_POST['move_down_in_frontpage']))$_POST['move_down_in_frontpage'] = false;
if(!isset($_POST['move_up_in_frontpage']))$_POST['move_up_in_frontpage'] = false;
if(!isset($_POST['move_bottom_in_frontpage']))$_POST['move_bottom_in_frontpage'] = false;
if(!isset($_POST['move_top_in_frontpage']))$_POST['move_top_in_frontpage'] = false;
if(!isset($_POST['act']))$_POST['act'] = false;
if(!isset($_POST['go']))$_POST['go'] = false;
if(!isset($_POST['s_category']))$_POST['s_category'] = false;
if(!isset($_POST['frontpage']))$_POST['frontpage'] = false;
if(!isset($_POST['new_folder_name']))$_POST['new_folder_name'] = false;
if(!isset($_POST['fileinfolder']))$_POST['fileinfolder'] = false;
if(!isset($_POST['row_id']))$_POST['row_id'] = false;
if(!isset($_POST['unnews']))$_POST['unnews'] = false;
if(!isset($_POST['unfrontpage']))$_POST['unfrontpage'] = false;
if(!isset($_POST['add_attachment']))$_POST['add_attachment'] = false;
if(!isset($_POST['remove_attachment']))$_POST['remove_attachment'] = false;
if(!isset($_POST['rename_attachment']))$_POST['rename_attachment'] = false;
if(!isset($_POST['update_attachment']))$_POST['update_attachment'] = false;
if(!isset($_POST['attach_update']))$_POST['attach_update'] = false;
if(!isset($_POST['update']))$_POST['update'] = false;
if(!isset($_POST['f_isFlashNews']) && ($_POST['update'] == 1) )$_POST['f_isFlashNews'] = false;
if((!isset($_POST['f_password'])) && ($_POST['section'] == 'user'))$_POST['f_password'] = false;
if(!isset($_POST['start']))$_POST['start'] = 0;
if(!isset($_POST['language_visibility']))$_POST['language_visibility'] = 0;
if(!isset($_POST['language_icons']))$_POST['language_icons'] = false;
if(!isset($_POST['login_form']))$_POST['login_form'] = false;
if(!isset($_POST['map_gallery']))$_POST['map_gallery'] = false;
if(!isset($_POST['unmap_gallery']))$_POST['unmap_gallery'] = false;
if(!isset($_POST['map_event']))$_POST['map_event'] = false;
if(!isset($_POST['unmap_event']))$_POST['unmap_event'] = false;

require_once ("scripts/class.php");
require_once ("scripts/config.php");

require_once ("scripts/classes/media_mass_upload.php");

if($_POST['login_form']){
try{
	 if (!$_POST['site_name'])
	{
    	$u = CMS_UserLogin::getSingleton();
    	$u->setUserType(CMS_UserLogin::ADMIN_USER);

    	$u->autoLogin();
    }
    else
	{

      	if (!isset($GLOBALS['project_config']))
			$GLOBALS['project_config']= new CMS_ProjectConfig($_POST['site_name']);

    	$u = CMS_UserLogin::getSingleton();
    	$u->setUserType(CMS_UserLogin::REGULAR_USER);
    	$u->autoLogin();
    }

    if ($_POST['login'] && $_POST['heslo'])
    		$u->login($_POST['login'],$_POST['heslo']);


    if (($_POST['site_name']) && ($u->isuserLogedIn() === true)){
    	$user_detail = new CMS_User($_SESSION['user']['id']);
    	if (!$user_detail->getIsEditor())
    		$u->logout();
    	else{
    		if (!$user_detail->getIsEnabled())
    			$u->logout();
    	}
    }

	if (isset ($_SESSION['user']['id']) && ($_POST['site_name']))
	    $_SESSION['user']['name'] = $_POST['site_name'];

   if($_POST['site_name'])
		Header("Location: ./?site_name={$_POST['site_name']}");
	else
		Header("Location: ./");
	exit;
}
catch(CN_Exception $e){

			if($e->getCode() == E_WARNING)
{
				if(isset($_POST['site_name']))
					$site_name = "&site_name={$_POST['site_name']}";
				else
					$site_name = null;

				$message = $e->getMessage();

				Header("Location: ../?message=".$message.$site_name);
}
			else
			{
				echo $e->displayDetails();
			}
	}
}

##############################################
# login

if(isset($_SESSION['user']))
{
	$u = CMS_UserLogin::getSingleton();

	if($_SESSION['user']['type'] == CMS_UserLogin::ADMIN_USER)
	{
		$u->setUserType(CMS_UserLogin::ADMIN_USER);
		$u->autoLogin();
	}
	elseif($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER)
	{
		if (!isset($GLOBALS['project_config']))
			$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);

		$u->setUserType(CMS_UserLogin::REGULAR_USER);
		$u->autoLogin();
	}
}
else
{
	if($_POST['site_name'])
		Header("Location: ./?site_name={$_POST['site_name']}");
	else
		Header("Location: ./");
	exit;
}

##############################################

$GLOBALS['project_folder']="/www";

 //  START DB
if (!isset($GLOBALS['project_config']))
	$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);


$GLOBALS["config_all"] = CN_Config::loadFromFile("../config/config.xml");


$user_detail = CMS_UserLogin::getSingleton()->getUser();

$GLOBALS['localLanguage'] = $user_detail->getConfigValue('default_local_language');
if (!$GLOBALS['localLanguage'])
	$GLOBALS['localLanguage'] = getConfig('proxia','default_local_language');

####################################################################################################


if(!isset($_POST['goAjax']))$_POST['goAjax'] = false;

if ($_POST['goAjax'] == 1)
{
	require('ajax.php');
	exit;
}


switch($_POST['section'])
{
	################################################################################################
	# section category
	################################################################################################

	case 'category':{

		if (is_Array($_POST['row_id'])){

			// PRESMERUJE NA UPDATE CATEGORY
			if($_POST['go']==3){
					$ignore = array ("cmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
					$link = urlPost($ignore);

					Header("Location: ./?cmd=3$link");
					exit;
				}


			if((!isset($_POST['f_authorId']))&&($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER))
				$_POST['f_authorId'] = $_SESSION['user']['id'];

			if((!isset($_POST['f_isPublished'])) && ($_POST['go']=="edit"))$_POST['f_isPublished'] = 0;
			if((!isset($_POST['f_languageIsVisible'])) && ($_POST['act']=="update") && ($_POST['language_visibility']==1))$_POST['f_languageIsVisible'] = 0;

			foreach ($_POST['row_id'] as $name => $id){

					$category = null;

					if($id === '0')
					{
						checkLimitAlert(CMS_Category::ENTITY_ID);
						$category = new CMS_Category();
						$_POST['language_visibility'] = 1;
						$_POST["a_languageIsVisible".$GLOBALS['localLanguage']] = 1;
					}
					else
						$category =  new CMS_Category($id);


					$category->setContextLanguage($GLOBALS['localLanguage']);

					foreach($_POST as $column_name => $value){

							if(strpos($column_name, 'f_') !== FALSE){
									// pre groups
									if($column_name == "f_access_groups"){
										$value = serialize($value);
									}
									$column_name = str_replace('f_', '', $column_name);

									$function = 'set'.ucfirst($column_name);

									$category->$function($value);
								}

							if(($column_name == "clone") && ($value == 1)){
									$clone_category = clone($category);
									$title =  'copy_'.$category->getTitle();
									$clone_category->setTitle($title);
									$clone_category->save();
								}

						}// END FOREACH F_

					$category->save();

					$new_id = $category->getId();

					if ($_POST['trash'] == 1){
							$category->discard();
						}

					if ($_POST['move_down_in_category'] == 1){
							$category->moveDownInCategory();
						}

					if ($_POST['move_up_in_category'] == 1){
							$category->moveUpInCategory();
						}

					if ($_POST['move_top_in_category'] == 1){
							$category->moveToTopInCategory($_POST['s_category']);
						}

					if ($_POST['move_bottom_in_category'] == 1){
							$category->moveToBottomInCategory($_POST['s_category']);
						}

					if ($_POST['move_bottom_in_menu'] == 1){
							$category->moveToBottomInMenu($_POST['s_category']);
						}

					if ($_POST['move_top_in_menu'] == 1){
							$category->moveToTopInMenu($_POST['s_category']);
						}

					if ($_POST['move_down_in_menu'] == 1){
							$category->moveDownInMenu($_POST['s_category']);
						}

					if ($_POST['move_up_in_menu'] == 1){
							$category->moveUpInMenu($_POST['s_category']);
						}

				}// END FOREACH ROW_ID

			if ($_POST['add_menu_id']){
					$menu = new CMS_Menu($_POST['add_menu_id']);
					$menu->addItem($category);
				}

			if ($_POST['remove_menu_id']){
					$menu = new CMS_Menu($_POST['remove_menu_id']);
					$menu->removeItem($category);
				}

			if ($_POST['add_category_id']>0){
					$category_parent = new CMS_Category($_POST['add_category_id']);
					if($category->hasParent()){
							$category->getParent()->removeItem($category);
							$category_parent->addItem($category);
						}
					else
						$category_parent->addItem($category);
				}

			if ($_POST['add_category_id']==-1){
					$category_parent = new CMS_Category($_POST['add_category_id']);
					if($category->hasParent())
							$category->getParent()->removeItem($category);
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
								$category->setContextLanguage($code);
								$function = 'set'.ucfirst($column_name);

								$category->setLanguageIsVisible($_POST[$valname]);
							}
						}
						$category->save();
					}
			if ($_POST['language_icons']==1){
						$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
						$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();
						foreach ($GLOBALS['LanguageList'] as $value){

							$code = $value['code'];
							$local_visibility = $value['local_visibility'];
							if ($local_visibility) {
								$valname = "a_languageIcons".$code;
								if(!isset($_POST[$valname]))$_POST[$valname] = "";
								$category->setContextLanguage($code);
								$function = 'set'.ucfirst($column_name);
								$category->setLocalizedImage($_POST[$valname]);
								//$category->setLanguageIsVisible($_POST[$valname]);
							}
						}
						$category->save();
					}

			}// END IF $_POST['row_id']

		setHistory($category,'edit');

		if ($_POST['go'] == 'list') {
				Header("Location: ./?".getReturnParameter());
				exit;
			}

		if ($_POST['go'] == 'edit') {
				$ignore = array ("row_id","cmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				$link = urlPost($ignore);
				Header("Location: ./?cmd=3&row_id[]=$new_id$link");
				exit;
			}

		Header("Location: ./?".getReturnParameter());
		exit;
	}
	break;// END SECTION CATEGORY



	################################################################################################
	# section setup category visibility
	################################################################################################

	case 'category_visibility':{
		if (is_Array($_POST['row_id'])){


		foreach ($_POST['row_id'] as $name => $id){
			$category = $id === '0' ? new CMS_Category() : new CMS_Category($id);
			$category->setContextLanguage($GLOBALS['localLanguage']);

			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'f_') !== FALSE){
					$column_name = str_replace('f_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$category->$function($value);
				}
			}// END FOREACH F_

				if(!isset($_POST['visibility'][$id]))
					$_POST['visibility'][$id] = 0;

				$category->setIsPublished($_POST['visibility'][$id]);

			$category->save();

			$new_id = $category->getId();


				$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
				$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();

				foreach ($GLOBALS['LanguageList'] as $value){

					$code = $value['code'];
					$local_visibility = $value['local_visibility'];

					if ($local_visibility) {
						$valname = "a_languageIsVisible".$code;

						if(!isset($_POST[$valname][$id]))
							$_POST[$valname][$id] = 0;

						$category->setContextLanguage($code);

						$category->setLanguageIsVisible($_POST[$valname][$id]);
					}
				}
			$category->save();


		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']



		Header("Location: ./?".getReturnParameter());
		exit;
	}
	break;// END SECTION CATEGORY SETUP VISIBILITY


	################################################################################################
	# section setup category access
	################################################################################################

	case 'category_access':{
		if (is_Array($_POST['row_id'])){


		foreach ($_POST['row_id'] as $name => $id){
			$category = $id === '0' ? new CMS_Category() : new CMS_Category($id);
			$category->setContextLanguage($GLOBALS['localLanguage']);

			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'f_') !== FALSE){
					$column_name = str_replace('f_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$category->$function($value);
				}
			}// END FOREACH F_

				if(!isset($_POST['access'][$id]))
					$_POST['access'][$id] = 0;

				$category->setAccess($_POST['access'][$id]);

			$category->save();


		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']



		Header("Location: ./?".getReturnParameter());
		exit;
	}
	break;// END SECTION CATEGORY SETUP ACCESS



	################################################################################################
	# section gallery
	################################################################################################

	case 'gallery':{
	$mod = CMS_Module::addModule('cms_modules\cms_gallery\classes\CMS_Gallery');
	$mod->utilise();

		if (is_Array($_POST['row_id'])){


			if((!isset($_POST['f_authorId']))&&($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER))
				$_POST['f_authorId'] = $_SESSION['user']['id'];

			if((!isset($_POST['f_languageIsVisible'])) && ($_POST['act']=="update") && ($_POST['language_visibility']==1))$_POST['f_languageIsVisible'] = 0;

			foreach ($_POST['row_id'] as $name => $id){

					$category = null;

					if($id === '0')
					{
						$category = new CMS_Gallery();
						$_POST['language_visibility'] = 1;
						$_POST["a_languageIsVisible".$GLOBALS['localLanguage']] = 1;
					}
					else
						$category =  new CMS_Gallery($id);


					$category->setContextLanguage($GLOBALS['localLanguage']);

					foreach($_POST as $column_name => $value){

							if(strpos($column_name, 'f_') !== FALSE){

									$column_name = str_replace('f_', '', $column_name);

									$function = 'set'.ucfirst($column_name);

									$category->$function($value);
								}

							if(($column_name == "clone") && ($value == 1)){
									$clone_category = clone($category);
									$title =  'copy_'.$category->getTitle();
									$clone_category->setTitle($title);
									$clone_category->save();
								}

						}// END FOREACH F_

					$category->save();

					$new_id = $category->getId();

					if ($_POST['trash'] == 1){
							$category->discard();
						}

					if ($_POST['move_down_in_category'] == 1){
							$category->moveDownInCategory();
						}

					if ($_POST['move_up_in_category'] == 1){
							$category->moveUpInCategory();
						}

					if ($_POST['move_down_in_menu'] == 1){
							$category->moveDownInMenu($_POST['s_category']);
						}

					if ($_POST['move_up_in_menu'] == 1){
							$category->moveUpInMenu($_POST['s_category']);
						}

					if ($_POST['move_top_in_category'] == 1){
							$category->moveToTopInCategory($_POST['s_category']);
						}

					if ($_POST['move_bottom_in_category'] == 1){
							$category->moveToBottomInCategory($_POST['s_category']);
						}

					if ($_POST['move_bottom_in_menu'] == 1){
							$category->moveToBottomInMenu($_POST['s_category']);
						}

					if ($_POST['move_top_in_menu'] == 1){
							$category->moveToTopInMenu($_POST['s_category']);
						}
				}// END FOREACH ROW_ID

			if ($_POST['add_menu_id']){
					$menu = new CMS_Menu($_POST['add_menu_id']);
					$menu->addItem($category);
				}

			if ($_POST['remove_menu_id']){
					$menu = new CMS_Menu($_POST['remove_menu_id']);
					$menu->removeItem($category);
				}

			if ($_POST['add_category_id']>0){
					$category_parent = new CMS_Category($_POST['add_category_id']);
					if($category->hasParent()){
							$category->getParent()->removeItem($category);
							$category_parent->addItem($category);
						}
					else
						$category_parent->addItem($category);
				}

			if ($_POST['add_category_id']==-1){
					$category_parent = new CMS_Category($_POST['add_category_id']);
					if($category->hasParent())
							$category->getParent()->removeItem($category);
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
								$category->setContextLanguage($code);
								$function = 'set'.ucfirst($column_name);

								$category->setLanguageIsVisible($_POST[$valname]);
							}
						}
						$category->save();
					}
			if ($_POST['language_icons']==1){
						$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
						$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();
						foreach ($GLOBALS['LanguageList'] as $value){

							$code = $value['code'];
							$local_visibility = $value['local_visibility'];
							if ($local_visibility) {
								$valname = "a_languageIcons".$code;
								if(!isset($_POST[$valname]))$_POST[$valname] = "";
								$category->setContextLanguage($code);
								$function = 'set'.ucfirst($column_name);
								$category->setLocalizedImage($_POST[$valname]);
								//$category->setLanguageIsVisible($_POST[$valname]);
							}
						}
						$category->save();
					}

			}// END IF $_POST['row_id']

		if ($_POST['go'] == 'list') {
				Header("Location: ./?".getReturnParameter());
				exit;
			}

		if ($_POST['go'] == 'edit') {
				$ignore = array ("row_id","cmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				$link = urlPost($ignore);
				Header("Location: ./?cmd=3&row_id[]=$new_id$link");
				exit;
			}

		Header("Location: ./?".getReturnParameter());
		exit;
	}
	break;// END SECTION GALLERY



	case 'catalog':{
		$mod = CMS_Module::addModule('cms_modules\cms_catalog\classes\CMS_Catalog');
		$mod->utilise();

		if (is_Array($_POST['row_id'])){


		foreach ($_POST['row_id'] as $name => $id){
			$catalog = $id === '0' ? new CMS_Catalog() : new CMS_Catalog($id);
			$catalog->setContextLanguage($GLOBALS['localLanguage']);


			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'f_') !== FALSE){
					$column_name = str_replace('f_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$catalog->$function($value);
				}
			}// END FOREACH F_

			$catalog->save();

			if ($_POST['language_visibility']==1){

				$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
				$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();

				foreach ($GLOBALS['LanguageList'] as $value){

					$code = $value['code'];
					$local_visibility = $value['local_visibility'];

					if ($local_visibility) {
						$valname = "a_languageIsVisible".$code;

						if(!isset($_POST[$valname])){
							$_POST[$valname] = 0;
						}
						$catalog->setContextLanguage($code);
						//echo $code;
						$catalog->setLanguageIsVisible($_POST[$valname]);
						//echo "-".$_POST[$valname];
					}
				}
			$catalog->save();
			}


			$new_id = $catalog->getId();

			if($_POST['delete']==1){
				$catalog->delete();
			}

			if ($_POST['add_menu_id']){
				$menu = new CMS_Menu($_POST['add_menu_id']);
				$menu->addItem($catalog);
			}

			if ($_POST['remove_menu_id']){
				$menu = new CMS_Menu($_POST['remove_menu_id']);
				$menu->removeItem($catalog);
			}

			if ($_POST['add_category_id']){
				$category_parent = new CMS_Category($_POST['add_category_id']);
				$category_parent->addItem($catalog);
			}

			if ($_POST['remove_category_id']){
				$category_parent = new CMS_Category($_POST['remove_category_id']);
				$category_parent->removeItem($catalog);
			}

			if ($_POST['move_down_in_category'] == 1){
					$catalog->moveDownInCategory();
				}

			if ($_POST['move_up_in_category'] == 1){
					$catalog->moveUpInCategory();
				}

			if ($_POST['move_down_in_menu'] == 1){
					$catalog->moveDownInMenu($_POST['s_category']);
				}

			if ($_POST['move_up_in_menu'] == 1){
					$catalog->moveUpInMenu($_POST['s_category']);
				}

					if ($_POST['move_top_in_category'] == 1){
							$catalog->moveToTopInCategory($_POST['s_category']);
						}

					if ($_POST['move_bottom_in_category'] == 1){
							$catalog->moveToBottomInCategory($_POST['s_category']);
						}

					if ($_POST['move_bottom_in_menu'] == 1){
							$catalog->moveToBottomInMenu($_POST['s_category']);
						}

					if ($_POST['move_top_in_menu'] == 1){
							$catalog->moveToTopInMenu($_POST['s_category']);
						}
		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']



		Header("Location: ./?".getReturnParameter());
		exit;




		}
	break;// END SECTION CATALOG



	case 'eventcalendar_event':{
		$mod = CMS_Module::addModule('CMS_EventCalendar');
		$mod->utilise();

		if (is_Array($_POST['row_id'])){


		foreach ($_POST['row_id'] as $name => $id){
			$event = $id === '0' ? new CMS_EventCalendar_Event() : new CMS_EventCalendar_Event($id);
			$event->setContextLanguage($GLOBALS['localLanguage']);

			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'f_') !== FALSE){
					$column_name = str_replace('f_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$event->$function($value);
				}
			}// END FOREACH F_

			$event->save();

			if ($_POST['language_visibility']==1){

				$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
				$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();

				foreach ($GLOBALS['LanguageList'] as $value){

					$code = $value['code'];
					$local_visibility = $value['local_visibility'];

					if ($local_visibility) {
						$valname = "a_languageIsVisible".$code;

						if(!isset($_POST[$valname])){
							$_POST[$valname] = 0;
						}
						$event->setContextLanguage($code);
						//echo $code;
						$event->setLanguageIsVisible($_POST[$valname]);
						//echo "-".$_POST[$valname];
					}
				}
			$event->save();
			}


			$new_id = $event->getId();

			if($_POST['delete']==1){
				$event->delete();
			}

			if ($_POST['add_menu_id']){
				$menu = new CMS_Menu($_POST['add_menu_id']);
				$menu->addItem($event);
			}

			if ($_POST['remove_menu_id']){
				$menu = new CMS_Menu($_POST['remove_menu_id']);
				$menu->removeItem($event);
			}

			if ($_POST['add_category_id']){
				$category_parent = new CMS_Category($_POST['add_category_id']);
				$category_parent->addItem($event);
			}

			if ($_POST['remove_category_id']){
				$category_parent = new CMS_Category($_POST['remove_category_id']);
				$category_parent->removeItem($event);
			}

			if ($_POST['move_down_in_category'] == 1){
					$event->moveDownInCategory();
				}

			if ($_POST['move_up_in_category'] == 1){
					$event->moveUpInCategory();
				}

			if ($_POST['move_down_in_menu'] == 1){
					$event->moveDownInMenu($_POST['s_category']);
				}

			if ($_POST['move_up_in_menu'] == 1){
					$event->moveUpInMenu($_POST['s_category']);
				}
					if ($_POST['move_top_in_category'] == 1){
							$event->moveToTopInCategory($_POST['s_category']);
						}

					if ($_POST['move_bottom_in_category'] == 1){
							$event->moveToBottomInCategory($_POST['s_category']);
						}

					if ($_POST['move_bottom_in_menu'] == 1){
							$event->moveToBottomInMenu($_POST['s_category']);
						}

					if ($_POST['move_top_in_menu'] == 1){
							$event->moveToTopInMenu($_POST['s_category']);
						}

		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']



		Header("Location: ./?".getReturnParameter());
		exit;




		}
	break;// END SECTION EVENT



	################################################################################################
	# section menu
	################################################################################################

	case 'menu':{

		if (is_Array($_POST['row_id'])){
				if($_POST['go']==6){
						$ignore = array ("cmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_name","f_title","f_description","f_isPublished");
						$link = urlPost($ignore);
						Header("Location: ./?cmd=6$link");
						exit;
					}


		foreach ($_POST['row_id'] as $name => $id){
				$menu = $id === '0' ? new CMS_Menu() : new CMS_Menu($id);

				if($id === '0')
					checkLimitAlert(CMS_Menu::ENTITY_ID);

				$menu->setContextLanguage($GLOBALS['localLanguage']);

				foreach($_POST as $column_name => $value){
						if(strpos($column_name, 'f_') !== FALSE){
								$column_name = str_replace('f_', '', $column_name);

								$function = 'set'.ucfirst($column_name);

								$menu->$function($value);
							}


						if(($column_name == "trash") && ($value == 1)){
								$menu->discard();
							}

					}
				$menu->save();
				$new_id = $menu->getId();

			}

			}

		setHistory($menu,'edit');

		if ($_POST['go'] == 'list') {
				Header("Location: ./?".getReturnParameter());
				exit;
			}

		if ($_POST['go'] == 'edit') {
				$ignore = array ("cmd","row_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_name","f_description","f_isPublished");
				$link = urlPost($ignore);
				Header("Location: ./?cmd=6&row_id[]=$new_id$link");
				exit;
			}

		Header("Location: ./?".getReturnParameter());
		exit;
	}
	break;// END SECTION MENU



	################################################################################################
	# section article
	################################################################################################

	case 'article':{

		if (is_Array($_POST['row_id'])){
				if($_POST['go']==9){
						$ignore = array ("cmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
						$link = urlPost($ignore);
						Header("Location: ./?cmd=9$link");
						exit;
					}

		if((!isset($_POST['f_isPublished'])) && ($_POST['act']=="update"))$_POST['f_isPublished'] = 0;
		if((!isset($_POST['f_frontpage_show_full_version'])) && ($_POST['act']=="update"))$_POST['f_frontpage_show_full_version'] = 0;
		if((!isset($_POST['f_languageIsVisible'])) && ($_POST['act']=="update") && ($_POST['language_visibility']==1))$_POST['f_languageIsVisible'] = 0;
		if((!isset($_POST['f_isNews'])) && ($_POST['act']=="update"))$_POST['f_isNews'] = 0;
		if (isset($_POST['f_expiration'])){
			if($_POST['f_expiration']=='')$_POST['f_expiration'] = null;
		}


		foreach ($_POST['row_id'] as $name => $id){

				$article = null;

				 if($id === '0')
				 {
					checkLimitAlert(CMS_Article::ENTITY_ID);

				 	$article = new CMS_Article();
				 	$_POST['language_visibility'] = 1;
				 	$_POST["a_languageIsVisible".$GLOBALS['localLanguage']] = 1;
				 }
				 else
				 	$article = new CMS_Article($id);

				if((!isset($_POST['f_authorId']))&&($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER)&&($id === '0'))
						$_POST['f_authorId'] = $_SESSION['user']['id'];


				$article->setContextLanguage($GLOBALS['localLanguage']);
				if ($_POST['add_attachment'] == 1){
											$priloha = new CMS_Attachment();
											$priloha->setContextLanguage($GLOBALS['localLanguage']);
											}
				foreach($_POST as $column_name => $value){
						if(strpos($column_name, 'f_') !== FALSE){
								// pre groups
								if($column_name == "f_access_groups"){
									$value = serialize($value);
								}
								$column_name2 = str_replace('f_', '', $column_name);

								$function = 'set'.ucfirst($column_name2);

								$article->$function($value);
							}

						if(($column_name == "clone") && ($value == 1)){
								$clone_article = clone($article);
								$title =  'copy_'.$article->getTitle();
								$clone_article->setTitle($title);
								$clone_article->save();
							}

						if(($column_name == "archive") && ($value == 1)){
								$article->archive();
							}

						if(($column_name == "unarchive") && ($value == 1)){
								$article->unarchive();
							}

						if(($column_name == "unnews") && ($value == 1)){
								$article->setIsNews(0);
							}

						if(($column_name == "trash") && ($value == 1)){
								$article->discard();
							}


						if ($_POST['add_attachment'] == 1){


								if(strpos($column_name, 'p__') !== FALSE){

										$column_name = str_replace('p__', '', $column_name);

										$function = 'set'.ucfirst($column_name);
											$priloha->$function($value);
											}

								}


					}

				if ($_POST['add_attachment'] == 1){
						$priloha->save();
						$new_id_attach = $priloha->getId();
						$article->addAttachment($priloha);
					}

				// upravy priloh start

				if (($_POST['update_attachment'])&&($_POST['attach_update'])){
					$pole_lang = Array(0=>'');
					foreach($_POST as $column_name => $value){
						if(strpos($column_name, 'language_visibility') !== FALSE){
							$pole_lang[] = substr($column_name,19);
						}
					}
					foreach ($article->getAttachments() as $value){
						$priloha = new CMS_Attachment($value->getId());
						$priloha->setContextLanguage($GLOBALS['localLanguage']);

						if (array_search($value->getId(),$pole_lang)== TRUE)
							$priloha -> setLanguageIsVisible(1);
						else
							$priloha -> setLanguageIsVisible(0);

						foreach($_POST as $column_name => $value2){
							if(strpos($column_name, 'p__title') !== FALSE){
								$title_id = substr($column_name,8);
								if (substr($column_name,8) == $value->getId()){
									$priloha -> setTitle($_POST['p__title'.$value->getId()]);
								}
							}
						}

						$priloha->save();
					}
				}

				if (($_POST['update_attachment'])&&(!$_POST['attach_update'])){
					foreach($_POST as $column_name => $value2){
						if(strpos($column_name, 'attach_delete') !== FALSE){
							$attach_delete_char = substr($column_name,13);
							$cut = substr($attach_delete_char,-2);
							$attach_delete_id = str_replace($cut,"",$attach_delete_char);

							if ($attach_delete_id > 0){
								$priloha = new CMS_Attachment($attach_delete_id);
								$priloha->delete();
							}
						}
					}
				}
				/*
				if ($_POST['remove_attachment'] > 0){
						$priloha = new CMS_Attachment($_POST['remove_attachment']);
						$priloha->delete();
						//$article->removeAttachment($priloha);
					}
				if ($_POST['rename_attachment'] > 0){

						$priloha = new CMS_Attachment($_POST['rename_attachment']);
						$priloha->setContextLanguage($GLOBALS['localLanguage']);
						$priloha -> setTitle($_POST['p__title']);
						$priloha -> setLanguageIsVisible($_POST['language_visibility']);
						$priloha->save();
					}
					*/
				// upravy priloh end

			if ($_POST['map_gallery']){
				$mod = CMS_Module::addModule('cms_modules\cms_gallery\classes\CMS_Gallery');
				$mod->utilise();

				$article->addGallery(new CMS_Gallery($_POST['map_gallery']));

			}

			if ($_POST['unmap_gallery']){
				$mod = CMS_Module::addModule('cms_modules\cms_gallery\classes\CMS_Gallery');
				$mod->utilise();

				$article->removeGallery(new CMS_Gallery($_POST['unmap_gallery']));
			}

			if ($_POST['map_event']){
				$mod = CMS_Module::addModule('CMS_EventCalendar');
				$mod->utilise();

				$article->addEvent(new CMS_EventCalendar_Event($_POST['map_event']));

			}

			if ($_POST['unmap_event']){
				$mod = CMS_Module::addModule('CMS_EventCalendar');
				$mod->utilise();

				$article->removeEvent(new CMS_EventCalendar_Event($_POST['unmap_event']));
			}

				$article->save();

						if ($_POST['move_down_in_category'] == 2){
								$article->moveDownInCategory($_POST['s_category']);
							}

						if ($_POST['move_up_in_category'] == 2){
								$article->moveUpInCategory($_POST['s_category']);
							}

						if ($_POST['move_down_in_menu'] == 2){
								$article->moveDownInMenu($_POST['s_category']);
							}

						if ($_POST['move_up_in_menu'] == 2){
								$article->moveUpInMenu($_POST['s_category']);
							}

						if ($_POST['move_top_in_category'] == 2){
							$article->moveToTopInCategory($_POST['s_category']);
						}

						if ($_POST['move_bottom_in_category'] == 2){
								$article->moveToBottomInCategory($_POST['s_category']);
							}

						if ($_POST['move_bottom_in_menu'] == 2){
								$article->moveToBottomInMenu($_POST['s_category']);
							}

						if ($_POST['move_top_in_menu'] == 2){
								$article->moveToTopInMenu($_POST['s_category']);
							}

						if ($_POST['move_down_in_frontpage'] == 1){
								$frontpage = CMS_Frontpage::getSingleton();
								$frontpage->moveDown($article);
							}

						if ($_POST['move_up_in_frontpage'] == 1){
								$frontpage = CMS_Frontpage::getSingleton();
								$frontpage->moveUp($article);
							}

						if ($_POST['move_bottom_in_frontpage'] == 1){
								$frontpage = CMS_Frontpage::getSingleton();
								$frontpage->moveToBottom($article);
							}

						if ($_POST['move_top_in_frontpage'] == 1){
								$frontpage = CMS_Frontpage::getSingleton();
								$frontpage->moveToTop($article);
							}

				if ($_POST['add_menu_id']){
						$menu = new CMS_Menu($_POST['add_menu_id']);
						$menu->addItem($article);
					}

				if ($_POST['remove_menu_id']){
						$menu = new CMS_Menu($_POST['remove_menu_id']);
						$menu->removeItem($article);
					}

				if ($_POST['add_category_id']){
						//echo $_POST['add_category_id']; exit;
						$category = new CMS_Category($_POST['add_category_id']);
						$category->addItem($article);
					}

				if ($_POST['remove_category_id']){
						$category = new CMS_Category($_POST['remove_category_id']);
						$category->removeItem($article);
					}

				if ($_POST['frontpage']){
						$frontpage = CMS_Frontpage::getSingleton();
						if (!$frontpage->itemExists($article))
								$frontpage->addItem($article);
					}

				if ((!$_POST['frontpage']) && ($_POST['act']=='update')){
						$frontpage = CMS_Frontpage::getSingleton();
						$frontpage->removeItem($article);
					}

				if ($_POST['unfrontpage']==1){
						$frontpage = CMS_Frontpage::getSingleton();
						$frontpage->removeItem($article);
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
								$article->setContextLanguage($code);
								$function = 'set'.ucfirst($column_name);

								$article->setLanguageIsVisible($_POST[$valname]);
							}
						}
						$article->save();
					}

				$new_id = $article->getId();

			}

			}

		setHistory($article,'edit');

		if ($_POST['go'] == 'list') {
				Header("Location: ./?".getReturnParameter());
				exit;
			}

		if ($_POST['go'] == 'edit') {
				$ignore = array ("cmd","row_id[]","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished","f_text");
				$link = urlPost($ignore);
				Header("Location: ./?cmd=9&row_id[]=$new_id$link");
				exit;
			}

		Header("Location: ./?".getReturnParameter());
		exit;
	}
	break;// END SECTION ARTICLE

	################################################################################################
	# section setup article visibility
	################################################################################################

	case 'article_visibility':{

		if (is_Array($_POST['row_id'])){


		foreach ($_POST['row_id'] as $name => $id)
		{
			$article = $id === '0' ? new CMS_Article() : new CMS_Article($id);
			$article->setContextLanguage($GLOBALS['localLanguage']);

			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'f_') !== FALSE){
					$column_name = str_replace('f_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$article->$function($value);
				}
			}// END FOREACH F_

				if(!isset($_POST['visibility'][$id]))
					$_POST['visibility'][$id] = 0;

				$article->setIsPublished($_POST['visibility'][$id]);

			$article->save();

			$new_id = $article->getId();


				$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
				$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();

				foreach ($GLOBALS['LanguageList'] as $value){

					$code = $value['code'];
					$local_visibility = $value['local_visibility'];

					if ($local_visibility) {
						$valname = "a_languageIsVisible".$code;

						if(!isset($_POST[$valname][$id]))
							$_POST[$valname][$id] = 0;

						$article->setContextLanguage($code);

						$article->setLanguageIsVisible($_POST[$valname][$id]);
					}
				}
			$article->save();


		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']


		Header("Location: ./?".getReturnParameter());
		exit;
	}
	break;// END SECTION ARTICLE SETUP VISIBILITY


	################################################################################################
	# section setup article access
	################################################################################################

	case 'article_access':{
		if (is_Array($_POST['row_id'])){


		foreach ($_POST['row_id'] as $name => $id){
			$article = $id === '0' ? new CMS_Article() : new CMS_Article($id);
			$article->setContextLanguage($GLOBALS['localLanguage']);

			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'f_') !== FALSE){
					$column_name = str_replace('f_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$article->$function($value);
				}
			}// END FOREACH F_

				if(!isset($_POST['access'][$id]))
					$_POST['access'][$id] = 0;

				$article->setAccess($_POST['access'][$id]);

			$article->save();


		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']



		Header("Location: ./?".getReturnParameter());
		exit;
	}
	break;// END SECTION ARTICLE SETUP ACCESS



	################################################################################################
	# section setup article expire
	################################################################################################

	case 'article_expire':{
		if (is_Array($_POST['row_id'])){


		foreach ($_POST['row_id'] as $name => $id){
			$article = $id === '0' ? new CMS_Article() : new CMS_Article($id);
			$article->setContextLanguage($GLOBALS['localLanguage']);

			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'f_') !== FALSE){
					$column_name = str_replace('f_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$article->$function($value);
				}
			}// END FOREACH F_

				if(!isset($_POST['expire'][$id]))
					$_POST['expire'][$id] = 0;

				$article->setExpiration($_POST['expire'][$id]);

			$article->save();


		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']



		Header("Location: ./?".getReturnParameter());
		exit;
	}
	break;// END SECTION ARTICLE SETUP EXPIRATION

	################################################################################################
	# section trash
	################################################################################################

	case 'trash':{

		foreach ($_POST['row_id'] as $name => $id){

				if (($_POST['restore'] == 1) && ($_POST['act'] == "category")){
						$trash = new CMS_Category($id);
						$trash->restore();
					}

				if (($_POST['delete'] == 1) && ($_POST['act'] == "category")){
						$category = new CMS_Category($id);
						$category->delete();
					}

				if (($_POST['restore'] == 1) && ($_POST['act'] == "article")){
						$trash = new CMS_Article($id);
						$trash->restore();
					}

				if (($_POST['delete'] == 1) && ($_POST['act'] == "article")){
						$article = new CMS_Article($id);
						$article->delete();
					}

				if (($_POST['restore'] == 1) && ($_POST['act'] == "menu")){
						$trash = new CMS_Menu($id);
						$trash->restore();
					}

				if (($_POST['delete'] == 1) && ($_POST['act'] == "menu")){
						$menu = new CMS_Menu($id);
						$menu->delete();
					}

				if (($_POST['restore'] == 1) && ($_POST['act'] == "weblink")){
						$trash = new CMS_Weblink($id);
						$trash->restore();
					}

				if (($_POST['delete'] == 1) && ($_POST['act'] == "weblink")){
						$weblink = new CMS_Weblink($id);
						$weblink->delete();
					}
			}

		Header("Location: ./?".getReturnParameter()."&showtable=".$_POST['showtable']);
		exit;
	}
	break;// END SECTION TRASH



	################################################################################################
	# section weblink
	################################################################################################

	case 'weblink':{

		if (is_Array($_POST['row_id'])){

			// PRESMERUJE NA UPDATE WEBLINK
			if($_POST['go']==14){
					$ignore = array ("cmd","action_type","action_value","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
					$link = urlPost($ignore);
					Header("Location: ./?cmd=14$link");
					exit;
				}

			if((!isset($_POST['f_isPublished'])) && ($_POST['act']=="update"))$_POST['f_isPublished'] = 0;
			if((!isset($_POST['f_languageIsVisible'])) && ($_POST['act']=="update") && ($_POST['language_visibility']==1))$_POST['f_languageIsVisible'] = 0;

			foreach ($_POST['row_id'] as $name => $id){

					$weblink = null;

				 	if($id === '0')
				 	{
				 		$weblink = new CMS_Weblink();
				 		$_POST['language_visibility'] = 1;
						$_POST["a_languageIsVisible".$GLOBALS['localLanguage']] = 1;
				 	}
				 	else
				 		$weblink = new CMS_Weblink($id);

					$weblink->setContextLanguage($GLOBALS['localLanguage']);

					foreach($_POST as $column_name => $value){

							if(strpos($column_name, 'f_') !== FALSE){
									// pre groups
									if($column_name == "f_access_groups"){
										$value = serialize($value);
									}
									$column_name = str_replace('f_', '', $column_name);

									$function = 'set'.ucfirst($column_name);

									$weblink->$function($value);
								}

							if(($column_name == "clone") && ($value == 1)){
									$clone_weblink = clone($weblink);
									$title =  'copy_'.$category->getTitle();
									$clone_weblink->setTitle($title);
									$clone_weblink->save();
								}

						}// END FOREACH F_

					$weblink->save();

					$new_id = $weblink->getId();

					if ($_POST['trash'] == 1){
							$weblink->discard();
						}

					if ($_POST['move_down_in_category'] == 5){
							$weblink->moveDownInCategory($_POST['s_category']);
						}

					if ($_POST['move_up_in_category'] == 5){
							$weblink->moveUpInCategory($_POST['s_category']);
							}

					if ($_POST['move_down_in_menu'] == 5){
							$weblink->moveDownInMenu($_POST['s_category']);
						}

					if ($_POST['move_up_in_menu'] == 5){
							$weblink->moveUpInMenu($_POST['s_category']);
						}

					if ($_POST['move_top_in_category'] == 5){
							$weblink->moveToTopInCategory($_POST['s_category']);
						}

					if ($_POST['move_bottom_in_category'] == 5){
							$weblink->moveToBottomInCategory($_POST['s_category']);
						}

					if ($_POST['move_bottom_in_menu'] == 5){
							$weblink->moveToBottomInMenu($_POST['s_category']);
						}

					if ($_POST['move_top_in_menu'] == 5){
							$weblink->moveToTopInMenu($_POST['s_category']);
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
								$weblink->setContextLanguage($code);
								$function = 'set'.ucfirst($column_name);

								$weblink->setLanguageIsVisible($_POST[$valname]);
							}
						}
						$weblink->save();
					}


				}// END FOREACH ROW_ID

			if ($_POST['add_menu_id']){
					$menu = new CMS_Menu($_POST['add_menu_id']);
					$menu->addItem($weblink);
				}

			if ($_POST['remove_menu_id']){
					$menu = new CMS_Menu($_POST['remove_menu_id']);
					$menu->removeItem($weblink);
				}

			if ($_POST['add_category_id']){
					$category = new CMS_Category($_POST['add_category_id']);
					$category->addItem($weblink);
				}

			if ($_POST['remove_category_id']){
					$category = new CMS_Category($_POST['remove_category_id']);
					$category->removeItem($weblink);
				}

		}// END IF $_POST['row_id']

		setHistory($weblink,'edit');

		if ($_POST['go'] == 'list') {
				Header("Location: ./?".getReturnParameter());
				exit;
			}

		if ($_POST['go'] == 'edit') {
				$ignore = array ("row_id","cmd","f_parent_id","action_type","action_value","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				$link = urlPost($ignore);
				Header("Location: ./?cmd=14&row_id[]=$new_id$link");
				exit;
			}

		Header("Location: ./?".getReturnParameter());
		exit;
	}
	break;// END SECTION WEBLINK


	################################################################################################
	# section user
	################################################################################################

	case 'user':{

		if (is_Array($_POST['row_id'])){

			// PRESMERUJE NA UPDATE user
			if($_POST['go']==18){
					$ignore = array ("cmd","action_type","action_value","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
					$link = urlPost($ignore);
					Header("Location: ./?cmd=18$link");
					exit;
				}

			if($_POST['f_password']=="")unset ($_POST['f_password']);

			foreach ($_POST['row_id'] as $name => $id){

				$user_class_name = 'CMS_User';

#########################################################################################
# ext user ##############################################################################

				$file = $GLOBALS['cms_root'].'www/'.$_SESSION['user']['name'].'/cms_classes/cms_user_ext.php';

				if(file_exists($file))
				{
					CN_ClassLoader::getSingleton()->addSearchPath($GLOBALS['cms_root'].'www/'.$_SESSION['user']['name'].'/cms_classes/');

					$user_class_name = 'CMS_UserExt';
				}

#########################################################################################


					$user_detail = $id === '0' ? new $user_class_name() : new $user_class_name($id);
					$user_detail->setContextLanguage($GLOBALS['localLanguage']);
					if(!isset($_POST['f_login']))$_POST['f_login'] = false;
					if ($_POST['f_login']){
						if ($id === '0'){
							if(number_login_name($_POST['f_login']) > 0){
								$message = urlencode(tr('Prihlasovacie meno už existuje, zvoľte si iné.'));
								Header("Location: ./?cmd=17&message=$message");
								exit;
							}
						}

						elseif ($id > 0){
							if(number_login_name($_POST['f_login'],$id) > 0){
								$message = urlencode(tr('Prihlasovacie meno už existuje, zvoľte si iné.'));
								Header("Location: ./?cmd=18&row_id[]=$id&message=$message");
								exit;
							}
						}
					}
					if (!$_POST['f_login'])
						unset ($_POST['f_login']);

					foreach($_POST as $column_name => $value){

							if(strpos($column_name, 'f_') !== FALSE){


									$column_name = str_replace('f_', '', $column_name);

									if($column_name == "password"){
											$value = md5($value);
										}

									$function = 'set'.ucfirst($column_name);

									$user_detail->$function($value);
								}

						}// END FOREACH F_

					$user_detail->save();
					$new_id = $user_detail->getId();

#########################################################################################
# privileges ############################################################################

					if(isset($_POST['privileges']))
					{
						if(is_null($_POST['privileges']))
							$_POST['privileges'] = array();

						#################################################################

						$user_detail->revokeAllPrivileges();

						foreach($_POST['privileges'] as $logic_entity_id => $privileges)
							$user_detail->grantPrivileges($logic_entity_id, array_sum($privileges));
					}

#########################################################################################
# category provileges ###################################################################

					if(isset($_POST['category_privileges']))
					{

						if(is_null($_POST['category_privileges']))
							$_POST['category_privileges'] = array();

						#################################################################

						$category_list = new CMS_CategoryList();
						$category_list->execute();

						foreach($category_list as $category)
						{
							$editors = strlen($category->getEditors()) > 0 ? unserialize($category->getEditors()) : array();

							if(in_array($user_detail->getId(),$editors))
								unset($editors[array_search($user_detail->getId(), $editors)]);

							$category->setEditors(serialize($editors));
							$category->save();
						}

						foreach($_POST['category_privileges'] as $id)
						{
							$category = new CMS_Category($id);

							$editors = strlen($category->getEditors()) > 0 ? unserialize($category->getEditors()) : array();

							if(!in_array($user_detail->getId(), $editors))
								$editors[] = $user_detail->getId();

							$category->setEditors(serialize($editors));
							$category->save();
						}
					}

#########################################################################################
# article provileges ####################################################################

					if(isset($_POST['article_privileges']))
					{
						if(is_null($_POST['article_privileges']) || $_POST['article_privileges'] == "null")
							$_POST['article_privileges'] = array();

						#################################################################

						$article_list = new CMS_ArticleList();
						$article_list->addCondition('is_trash', 0);
						$article_list->addCondition('is_archive', 0);
						$article_list->execute();

						foreach($article_list as $article)
						{
							$editors = strlen($article->getEditors()) > 0 ? unserialize($article->getEditors()) : array();

							if(in_array($user_detail->getId(),$editors))
								unset($editors[array_search($user_detail->getId(), $editors)]);

							$article->setEditors(serialize($editors));
							$article->save();
						}

						foreach($_POST['article_privileges'] as $id)
						{
							$article = new CMS_Article($id);

							$editors = strlen($article->getEditors()) > 0 ? unserialize($article->getEditors()) : array();

							if(!in_array($user_detail->getId(), $editors))
								$editors[] = $user_detail->getId();

							$article->setEditors(serialize($editors));
							$article->save();
						}
					}

#########################################################################################
# menu provileges #######################################################################

					if(isset($_POST['menu_privileges']))
					{
						if(is_null($_POST['menu_privileges']) ||  $_POST['menu_privileges'] == "null")
							$_POST['menu_privileges'] = array();

						#################################################################

						$menu_list = new CMS_MenuList();
						$menu_list->addCondition('is_trash', 0);
						$menu_list->execute();

						foreach($menu_list as $menu)
						{
							$editors = strlen($menu->getEditors()) > 0 ? unserialize($menu->getEditors()) : array();

							if(in_array($user_detail->getId(),$editors))
								unset($editors[array_search($user_detail->getId(), $editors)]);

							$menu->setEditors(serialize($editors));
							$menu->save();
						}

						foreach($_POST['menu_privileges'] as $id)
						{
							$menu = new CMS_Menu($id);

							$editors = strlen($menu->getEditors()) > 0 ? unserialize($menu->getEditors()) : array();

							if(!in_array($user_detail->getId(), $editors))
								$editors[] = $user_detail->getId();

							$menu->setEditors(serialize($editors));
							$menu->save();
						}
					}

#########################################################################################

				}// END FOREACH ROW_ID



		}// END IF $_POST['row_id']

		if ($_POST['go'] == 'list') {
				$ignore = array ("row_id","cmd","f_parent_id","action_type","action_value","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				$link = urlPost($ignore);
				Header("Location: ./?".getReturnParameter());
				exit;
			}

		if ($_POST['go'] == 'edit') {
				$ignore = array ("row_id","cmd","f_parent_id","action_type","action_value","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				$link = urlPost($ignore);
				Header("Location: ./?cmd=18&row_id[]=$new_id$link");
				exit;
			}



		Header("Location: ./?".getReturnParameter());
		exit;
	}
	break;// END SECTION USERS


    ################################################################################################
	# section language
	################################################################################################

	case 'language':{

		if (is_Array($_POST['row_id'])){

			// PRESMERUJE NA UPDATE user
			if($_POST['go']==21){
					$ignore = array ("cmd","action_type","action_value","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
					$link = urlPost($ignore);
					Header("Location: ./?cmd=21$link");
					exit;
				}

			foreach ($_POST['row_id'] as $name => $id){
					$lang = new CMS_Languages();

					if ($_POST['act'] == 'add') {
							$code = $_POST['code'];
							$lang_list_iso = CN_IsoCodes::getSingleton()->getList(CN_IsoCodes::LIST_ISO_639);
							foreach ($lang_list_iso as $value){
									if ($value['iso_639_1_code'] == $code){
											$nativeName = $value['name'];
										}
								}
							$lang->addLanguage($code, $nativeName);
							//$_POST['code'] = $code;
						}

					foreach($_POST as $column_name => $value){

							if(strpos($column_name, 'f_') !== FALSE){

									$column_name = str_replace('f_', '', $column_name);
									$lang->setValue($id, $column_name, $value);
								}

						}// END FOREACH F_

					$new_id = $_POST['row_id'][0];
				}// END FOREACH ROW_ID



		}// END IF $_POST['row_id']

		if ($_POST['go'] == 'list') {
				Header("Location: ./?cmd=19");
				exit;
			}

		if ($_POST['go'] == 'edit') {
				$ignore = array ("row_id","cmd","f_parent_id","action_type","action_value","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				$link = urlPost($ignore);
				Header("Location: ./?cmd=21&row_id[]=$new_id$link");
				exit;
			}

		Header("Location: ./?cmd=".$_POST['cmd']);
		exit;
	}
	break;// END SECTION LANGUAGe


	################################################################################################
	# section options
	################################################################################################

	case 'option':{
		$options = CN_Config::loadFromFile("../config/config.xml");

		$current_section = $options->getSection($_POST['sec_name']);
		foreach($current_section as $key => $value){

			if(($value['type'] == 'bool') && (!isset($_POST['f_'.$value['name']])) ){
					$_POST['f_'.$value['name']] = 'false';
				}
		}// END FOREACH F_


		foreach($_POST as $column_name => $value){
			if(strpos($column_name, 'f_') !== FALSE){

					$column_name = str_replace('f_', '', $column_name);

					$options->setValue($_POST['sec_name'], $column_name, $value);
				}

		}// END FOREACH F_
		$options->save();
		Header("Location: ./?cmd=".$_POST['cmd']."&showtable=".$_POST['showtable']);
		exit;
	}
	break;// END SECTION OPTIONS



	################################################################################################
	# section folder
	################################################################################################

	case 'media':{
		if ($_POST['new_folder_name']){
				$_POST['new_folder_name'] = utf2ascii($_POST['new_folder_name']);
				$newfolder = $GLOBALS['config']['mediadir'].$_POST['infolder'].$_POST['new_folder_name'];

				//FTP Hostname
				$ftp_server = "127.0.0.1";
				$ftp_username = "";
				$ftp_userpassword = "";

				if (!is_dir($newfolder) )
				{
					$ftp = 1;
					if (function_exists('ftp_connect')){
						if(ftp_connect($ftp_server)){
							$conn_id = ftp_connect($ftp_server);
							$ftp = 1;
						}
						else
							$ftp = 0;
					}
					else
						$ftp = 0;
					//$conn_id = ftp_connect($ftp_server) or ($ftp = 0);
$ftp = 0;
					if($ftp == 1)

						//login to the server
						if (@ftp_login($conn_id, $ftp_username, $ftp_userpassword)) {
							$ftp = 1;
						} else {
							$ftp = 0;
						}


					if($ftp == 1){
						$base_path = realpath(dirname($newfolder));
						$newfolder = substr($base_path, 20) . '/' . $_POST['new_folder_name'];

						// try to create the directory $dir
						if (ftp_mkdir($conn_id, $newfolder)) {
						// echo "successfully created $newfolder\n";
						} else {
						//echo "There was a problem while creating $dir\n";
						}

						if (ftp_chmod($conn_id,0777, $newfolder)) {
						// echo "successfully chmod $newfolder\n";
						} else {
						//echo "There was a problem while creating chmod $dir\n";
						}

						//close the FTP connection
						ftp_close($conn_id);

					}
					else{
							if(!is_dir($newfolder))
							{
								@mkdir($newfolder);
								@chmod($newfolder, 0770);
							}
					}
				}

				$new_folder = substr($_POST['infolder'], stripos($_POST['infolder'],'mediafiles')+10);

				if ($_POST['go'] == 'list') {
						Header("Location: ./?cmd=26&m_directory=".$new_folder);
						exit;
					}

				if ($_POST['go'] == 'edit') {
						Header("Location: ./?cmd=".$_POST['cmd']);
						exit;
					}

			}

		if ($_POST['fileinfolder']){
				$targetPath = $_POST['fileinfolder'];

				if (str_starts_with($_POST['fileinfolder'], $GLOBALS['config']['mediadir'])) {
					$targetPath = str_replace($GLOBALS['config']['mediadir'], '', $targetPath);
				}

				foreach ($_FILES as $file => $value) {
					$_FILES[$file]['name'] =  utf2ascii($_FILES[$file]['name']);
				}

				if(!($_POST['zip'] ?? null))
				{
					$upload = new CN_FileUpload();
					$upload -> setTargetDirectory("{$GLOBALS['config']['mediadir']}/$targetPath");
					$upload -> setMaxSize(getConfig('proxia','upload_max_size'));
					$upload -> upload();
					Header("Location: ./?cmd=26");
					exit;
				}else{
					//$project_folder = "..".$GLOBALS['project_folder']."/".$_SESSION['user']['name'];
					$dir = urlencode(str_replace("..".$GLOBALS['project_folder']."/".$_SESSION['user']['name']."/mediafiles","",$_POST['fileinfolder']));
					$media = new MediaMassUpload($_POST['fileinfolder']);
					$media->uploadMassFile();
					Header("Location: ./?cmd=26&m_directory=$dir");
					exit;
				}
			}


		if (is_Array($_POST['row_id']))
		{
			foreach ($_POST['row_id'] as $name => $namefile)
			{
				if ($_POST['delete'] == 1)
				{
					$namefile = str_replace('..', '', $namefile);

					$path = "{$GLOBALS['config']['mediadir']}/$namefile";
								//var_dump($path,is_dir($path));exit;
					if (is_dir($path))
					{
						@rmdir($path);
					}
					elseif(is_file($namefile))
					{
						@unlink ($path);
						CMS_Attachment::deleteByFileName($namefile);
						$name_file = basename($path);
						$name_dir = dirname ($path);
						@unlink ($name_dir."/_thumbs/_".$name_file);
						@rmdir($name_dir."/_thumbs");
					}
				}



			}// END FOREACH ROW_ID
		}

		Header("Location: ./?cmd=".$_POST['cmd']);
		exit;
	}
	break;// END SECTION FOLDER

	################################################################################################
	# section groups
	################################################################################################

	case 'groups':{

		if (is_Array($_POST['row_id'])){

			// PRESMERUJE NA UPDATE GROUP
			if($_POST['go']==9){
					$ignore = array ("cmd","section","action_type","action_value","go","act","f_title","f_description","f_isPublished");
					$link = urlPost($ignore);

					Header("Location: ./?cmd=35$link");
					exit;
				}

			if((!isset($_POST['f_isPublished'])) && ($_POST['act']=="update"))$_POST['f_isPublished'] = 0;
			if((!isset($_POST['f_languageIsVisible'])) && ($_POST['act']=="update") && ($_POST['language_visibility']==1))$_POST['f_languageIsVisible'] = 0;

			foreach ($_POST['row_id'] as $name => $id){

					$group = null;

				 	if($id === '0')
				 	{
				 		$group = new CMS_Group();
				 		$_POST['language_visibility'] = 1;
						$_POST["a_languageIsVisible".$GLOBALS['localLanguage']] = 1;
				 	}
				 	else
				 		$group = new CMS_Group($id);

					$group->setContextLanguage($GLOBALS['localLanguage']);

					foreach($_POST as $column_name => $value){

							if(strpos($column_name, 'f_') !== FALSE){

									$column_name = str_replace('f_', '', $column_name);

									$function = 'set'.ucfirst($column_name);

									$group->$function($value);
								}

						}// END FOREACH F_

					$group->save();

					$new_id = $group->getId();
					if ($_POST['language_visibility']==1){
						$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
						$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();
						foreach ($GLOBALS['LanguageList'] as $value){

							$code = $value['code'];
							$local_visibility = $value['local_visibility'];
							if ($local_visibility) {
								$valname = "a_languageIsVisible".$code;
								if(!isset($_POST[$valname]))$_POST[$valname] = 0;
								$group->setContextLanguage($code);
								$function = 'set'.ucfirst($column_name);
								$group->setLanguageIsVisible($_POST[$valname]);
							}
						}
						$group->save();
					}
					if ($_POST['delete'] == 1){
							$group->delete();
						}

					if(isset($_POST['users']) or isset($_POST['grp_users'])){
						// vymaze najskor vsetkych priradenych
						$mappedUsers = $group->getUsers();
						foreach ($mappedUsers as $user_detail){
								$group->removeUser($user_detail);
						}
					}
					if(isset($_POST['grp_users'])){
							// priradi novych nastavenych
						 foreach ($_POST['grp_users'] as $user_id){
						 			$group->addUser(new CMS_User($user_id));
						 }
				 	}
				}// END FOREACH ROW_ID

		}// END IF $_POST['row_id']

		if ($_POST['go'] == 'list') {
				Header("Location: ./?cmd=33");
				exit;
			}

		if ($_POST['go'] == 'edit') {
				$ignore = array ("row_id","cmd","action_type","action_value","go","act","f_title","f_description","f_isPublished");
				$link = urlPost($ignore);

				Header("Location: ./?cmd=35&row_id[]=$new_id$link");
				exit;
			}

		Header("Location: ./?cmd=".$_POST['cmd']);
		exit;
	}
	break;// END SECTION GROUPS


	################################################################################################
	# section setup frontpage language visibility
	################################################################################################

	case 'frontpage_language_visibility':{

			 	$article = new CMS_Article($_POST['row_id'][0]);

				$article->setContextLanguage($_POST['frontpage_language']);
				$article->setFrontpage_language_is_visible($_POST['frontpage_language_is_visible']);
				$article->save();

		Header("Location: ./?".getReturnParameter());
		exit;
	}
	break;// END frontpage language visibility

	default:
		; // throw;
}
}
catch(CN_Exception $e){
	if($e->getCode() == E_USER_ERROR){
		$message = urlencode($e->getMessage());
		Header("Location: ./?message=".$message);
	}
	else
		echo $e->displayDetails();
}
?>
