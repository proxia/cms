<?php
//$post = var_export($_POST,true);echo($post);EXIT;
;
if(!isset($_POST['go']))$_POST['go'] = false;
if(!isset($_POST['delete']))$_POST['delete'] = false;
if(!isset($_POST['qu_topic']))$_POST['qu_topic'] = false;
if(!isset($_POST['delete_topic']))$_POST['delete_topic'] = false;
if(!isset($_POST['add_menu_id']))$_POST['add_menu_id'] = false;
if(!isset($_POST['add_category_id']))$_POST['add_category_id'] = false;
if(!isset($_POST['remove_menu_id']))$_POST['remove_menu_id'] = false;
if(!isset($_POST['remove_category_id']))$_POST['remove_category_id'] = false;
if(!isset($_POST['add_attachment']))$_POST['add_attachment'] = false;
if(!isset($_POST['remove_attachment']))$_POST['remove_attachment'] = false;
if(!isset($_POST['rename_attachment']))$_POST['rename_attachment'] = false;
if(!isset($_POST['update_attachment']))$_POST['update_attachment'] = false;
if(!isset($_POST['attach_update']))$_POST['attach_update'] = false;
if(!isset($_POST['move_down_in_gallery']))$_POST['move_down_in_gallery'] = false;
if(!isset($_POST['move_up_in_gallery']))$_POST['move_up_in_gallery'] = false;

try
{
	ini_set("include_path",ini_get('include_path').PATH_SEPARATOR.realpath('../../'));

 	require_once("smarty/Smarty.class.php");

	include ("themes/default/scripts/classes/sort_gallery_save_handler.php");

	//$GLOBALS['project_folder']="/www";

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

//
//	##############################################
//	# login
//	if(isset($_SESSION['user'])){
//		$u = CMS_UserLogin::getSingleton();
//
//		if($_SESSION['user']['type'] == CMS_UserLogin::ADMIN_USER){
//
//			$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQLI);
//			var_dump(CN_SqlDatabase::DRIVER_MYSQLI);exit;
//
//			include("../../../../../admin/dblogin.php");
//
////			$data->setServer("localhost");
////			$data->setUser("dproxia2");
////			$data->setPassword("uPqb9VRr");
//
//			$data->setDataSource("proxia");
//			$data->open();
//
//			$u->setUserType(CMS_UserLogin::ADMIN_USER);
//			$u->autoLogin();
//		}
//		elseif($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER){
//			$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQLI);
//
//			if (!isset($GLOBALS['project_config']))
//				$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);
//
//			$data->setUser($GLOBALS['project_config']->getSqlUser());
//			$data->setPassword($GLOBALS['project_config']->getSqlPassword());
//			$data->setDataSource($GLOBALS['project_config']->getSqlDsn());
//			$data->open();
//
//			$u->setUserType(CMS_UserLogin::REGULAR_USER);
//			$u->autoLogin();
//		}
//
//		CN_SqlDatabase::removeDatabase();
//	}
//
//	##############################################
//
//	$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);

//	include ("/admin/scripts/functions.php");

//	$path = "/config";

//	 //  START DB
//	if (!isset($GLOBALS['project_config']))
//		$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);
//
//	$data->setUser($GLOBALS['project_config']->getSqlUser());
//	$data->setPassword($GLOBALS['project_config']->getSqlPassword());
//
//	$data->setDataSource($_SESSION['user']['dsn']);
//	$data->open();

//	$GLOBALS["config_all"] = CN_Config::loadFromFile($path."/config.xml");
//	var_dump($GLOBALS['config_all']);exit;
//	$user_detail = CMS_UserLogin::getSingleton()->getUser();

//	// LANGUAGE LOCAL
//	$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
//	$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();
//
//	$user_detail = CMS_UserLogin::getSingleton()->getUser();
//	$GLOBALS['localLanguage'] = $user_detail->getConfigValue('default_local_language');
//	if (!$GLOBALS['localLanguage'])
//		$GLOBALS['localLanguage'] = getConfig('proxia','default_local_language');
//
//	$GLOBALS['LanguageListLocal'] = array();
//	foreach ($GLOBALS['LanguageList'] as $value){
//		if ($value['local_visibility']){
//			$a[$value['code']] = $value;
//			$GLOBALS['LanguageListLocal'] = array_merge($GLOBALS['LanguageListLocal'],$a);
//		}
//	}
//	$smarty->assign("LanguageListLocal",$GLOBALS['LanguageListLocal']);
//
//	$GLOBALS['localLanguageDefault'] = getConfig('proxia','default_local_language');
//	$smarty->assign("localLanguageDefault",$GLOBALS['localLanguageDefault']);
//
//
//	$GLOBALS['user_login_type'] = $_SESSION['user']['type'];
//	$GLOBALS['user_login'] = CMS_UserLogin::getSingleton()->getUser();
//
//	$prefered_language = $GLOBALS['user_login']->getConfigValue('prefered_language');
//	CN_Application::getSingleton()->setLanguage($prefered_language);
//
//	$GLOBALS['user_login_type'] = $_SESSION['user']['type'];
//	$smarty->assign("user_login_type",$GLOBALS['user_login_type']);

//	$smarty->assign("privilege_access",CMS_Privileges::ACCESS_PRIVILEGE);
//	$smarty->assign("privilege_view",CMS_Privileges::VIEW_PRIVILEGE);
//	$smarty->assign("privilege_add",CMS_Privileges::ADD_PRIVILEGE);
//	$smarty->assign("privilege_delete",CMS_Privileges::DELETE_PRIVILEGE);
//	$smarty->assign("privilege_update",CMS_Privileges::UPDATE_PRIVILEGE);
//	$smarty->assign("privilege_restore",CMS_Privileges::RESTORE_PRIVILEGE);
//
//	$GLOBALS['user_login'] = CMS_UserLogin::getSingleton()->getUser();
//	$smarty->assign("user_login",$GLOBALS['user_login']);
//
//	$smarty->assign("regular_user",CMS_UserLogin::REGULAR_USER);
//	$smarty->assign("admin_user",CMS_UserLogin::ADMIN_USER);

	if(!isset($_POST['goAjax']))$_POST['goAjax'] = false;


	####################################################################################################


	if(($_POST['section'] == 'new') || ($_POST['section'] == 'edit')):	

		if (is_Array($_POST['row_id'])){

			// PRESMERUJE NA UPDATE
			if($_POST['go']==3){
				$ignore = array ("mcmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				$link = urlPost($ignore);
				Header("Location: /admin/?mcmd=3&module=CMS_Gallery$link");
				exit;
			}

			if((!isset($_POST['f_authorId']))&&($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER))
				$_POST['f_authorId'] = $_SESSION['user']['id'];

			foreach ($_POST['row_id'] as $name => $id){
				$gallery = $id === '0' ? new CMS_Gallery() : new CMS_Gallery($id);
				$gallery->setContextLanguage($GLOBALS['localLanguage']);

				foreach($_POST as $column_name => $value){

					if(strpos($column_name, 'f_') !== FALSE){

						$column_name = str_replace('f_', '', $column_name);

						$function = 'set'.ucfirst($column_name);

						$gallery->$function($value);
					}
				}// END FOREACH F_


				$gallery->save();
				$new_id = $gallery->getId();
				if($_POST['delete']==1){
					$gallery->delete();
				}

				if ($_POST['add_menu_id']){
					$menu = new CMS_Menu($_POST['add_menu_id']);
					$menu->addItem($gallery);
				}

				if ($_POST['remove_menu_id']){
					$menu = new CMS_Menu($_POST['remove_menu_id']);
					$menu->removeItem($gallery);
				}

				if ($_POST['add_category_id']){
					$category_parent = new CMS_Category($_POST['add_category_id']);
					$category_parent->addItem($gallery);
				}

				if ($_POST['remove_category_id']){
					$category_parent = new CMS_Category($_POST['remove_category_id']);
					$category_parent->removeItem($gallery);
				}



			}// END FOREACH POST'ROW_ID'

		}// END IF is_array $_POST['row_id']

	endif;


	if($_POST['section'] == 'foto'):

		if (is_Array($_POST['row_id'])){

			// PRESMERUJE NA UPDATE
			if($_POST['go']==3){
				$ignore = array ("mcmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				$link = urlPost($ignore);
				Header("Location: /admin/?mcmd=3&module=CMS_Gallery$link");
				exit;
			}
			if ((!$_POST['move_down_in_gallery']) && (!$_POST['move_up_in_gallery'])){
				foreach ($_POST['row_id'] as $name => $id){
					$gallery = $id === '0' ? new CMS_Gallery() : new CMS_Gallery($id);
					$gallery->setContextLanguage($GLOBALS['localLanguage']);

					if ($_POST['add_attachment'] == 1){
						$priloha = new CMS_Attachment();
						$priloha->setContextLanguage($GLOBALS['localLanguage']);
					}

					foreach($_POST as $column_name => $value){

						if(strpos($column_name, 'f_') !== FALSE){

							$column_name = str_replace('f_', '', $column_name);

							$function = 'set'.ucfirst($column_name);

							$gallery->$function($value);
						}
					}// END FOREACH F_

					if ($_POST['add_attachment'] == 1){
						foreach($_POST as $column_name => $value){

							if(strpos($column_name, 'p__') !== FALSE){

								$column_name = str_replace('p__', '', $column_name);

								$function = 'set'.ucfirst($column_name);
								$priloha->$function($value);
							}
						}

					} // end foreach post'row_id'

					if ($_POST['add_attachment'] == 1){

						$priloha->save();

						$new_id_attach = $priloha->getId();
						$gallery->addAttachment($priloha);
					}

					// upravy priloh start

					if (($_POST['update_attachment'])&&($_POST['attach_update'])){
						$pole_lang = Array(0=>'');
						foreach($_POST as $column_name => $value){
							if(strpos($column_name, 'language_visibility') !== FALSE){
								$pole_lang[] = substr($column_name,19);
							}
						}

						foreach ($gallery->getAttachments() as $value){
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
					// upravy priloh end

					$gallery->save();
					$new_id = $gallery->getId();
				}

			}
			if (($_POST['move_down_in_gallery']) || ($_POST['move_up_in_gallery'])){
				foreach ($_POST['row_id'] as $name => $id){
					$attach = $id === '0' ? new CMS_Attachment() : new CMS_Attachment($id);

					if ($_POST['move_down_in_gallery'])
						$attach->moveDownInCategory();

					if ($_POST['move_up_in_gallery'])
						$attach->moveUpInCategory();

				}

			}

			Header("Location: /admin/?mcmd=4&module=CMS_Gallery&row_id[]=".$_POST['row_id'][0]);
			exit;
		}
	endif;
	if($_POST['section'] == 'massFiles'):

		$gallery_id = $_POST["gallery_id"];
		if(isset($_POST["files"]))
		{
			$gallery =  new CMS_Gallery($gallery_id);
			$files = explode("|",$_POST["files"]);

			foreach($files as $file)
			{

				$file = trim($file);
				if($file == '')
					continue;
				$pos = strrpos($file, ".");
				$ext = "";
				if ($pos === false)
					;
				else
					$ext = substr($file,$pos+1);
				// len obrazky
				if(strtolower($ext) != 'jpg' && strtolower($ext) != 'jpeg' && strtolower($ext) != 'gif'  && strtolower($ext) != 'png')
					continue;
				$pos2 = strrpos($file, "/");
				if ($pos2 === false)
					$pos2 = 1;

				$filename = substr($file,$pos2+1);
				$title = substr($file,$pos2+1,$pos-$pos2-1);

				$priloha = new CMS_Attachment();
				$priloha->setContextLanguage($GLOBALS['localLanguage']);
				$priloha -> setTitle($title);
				$priloha -> setFile($file);
				$priloha->save();
				$gallery->addAttachment($priloha);
			}
		}
		Header("Location: /admin/?mcmd=4&module=CMS_Gallery&row_id[]=".$gallery_id);
		exit;

	endif;

	if($_POST['goAjax'] == 1)
	{
		switch($_REQUEST['section'])
		{

		###########################################################################################################
		################################################  GALLERY ################################################
		###########################################################################################################

		case 'gallery_languages':{

			$gallery = new CMS_Gallery($_POST['row_id'][0]);

			foreach ($GLOBALS['LanguageList'] as $value)
			{
				$code = $value['code'];

				$local_visibility = $value['local_visibility'];

				if ($local_visibility)
				{
					$valname = "a_languageIsVisible".$code;

					if(!isset($_POST[$valname]))
						$_POST[$valname] = 0;

					$gallery->setContextLanguage($code);

					$gallery->setLanguageIsVisible($_POST[$valname]);
				}
			}
			$gallery->save();

			// priprava na vypis zoznamu jazykovych nastaveni
			$GLOBALS["smarty"]->assign("gallery_detail",$gallery);

			// vypis zoznamu jazykovych nastaveni
			$GLOBALS["smarty"]->display("ajax/gallery_edit_language_versions.tpl");

		}
		break;

		################################################################################################
		case 'gallery_bindmenu':{

			$gallery = new CMS_Gallery($_POST['row_id'][0]);

			if ($_POST['remove_menu_id'])
			{
				$menu = new CMS_Menu($_POST['remove_menu_id']);
				$menu->removeItem($gallery);
			}

			if ($_POST['add_menu_id'])
			{
				$menu = new CMS_Menu($_POST['add_menu_id']);
				if(!$menu->itemExists($gallery))
					$menu->addItem($gallery);
			}

			// nacitanie menu pre gallery
			$menu_list_vektor = $gallery->getMenuList();
			$menu_list_array = array();

			foreach($menu_list_vektor as $menu_item)
			{
				$menu_item->setContextLanguage($_SESSION['localLanguage']);
				if(trim($menu_item->getTitle()) == "")
				{
					$menu_item->setContextLanguage($GLOBALS['localLanguageDefault']);
					$menu_list_array[] = array("title"=>"[".$menu_item->getTitle()."]","id"=>$menu_item->getId());
				}
				else
				{
					$menu_list_array[] = array("title"=>$menu_item->getTitle(),"id"=>$menu_item->getId());
				}

			}

			$GLOBALS["smarty"]->assign("gallery_detail",$gallery);
			$GLOBALS["smarty"]->assign("menu_list_items",$menu_list_array);
			$GLOBALS["smarty"]->assign("count_menu_items",count($menu_list_array));
			// vypis
			$GLOBALS["smarty"]->display("ajax/gallery_edit_bindmenu.tpl");

		}
		break;


		case 'gallery_bindcategory':{

			$gallery = new CMS_Gallery($_POST['row_id'][0]);

			if ($_POST['add_category_id'])
			{
					$category = new CMS_Category($_POST['add_category_id']);
					if(!$category->itemExists($gallery))
						$category->addItem($gallery);
			}

			if ($_POST['remove_category_id'])
			{
					$category = new CMS_Category($_POST['remove_category_id']);
					$category->removeItem($gallery);
			}

			// nacitanie listu kategorii kde je namapovany gallery
			$event_parents_vektor = $gallery->getParents();
			$category_list_array = array();

			foreach($event_parents_vektor as $category_item)
			{
				$category_item->setContextLanguage($_SESSION['localLanguage']);
				if(trim($category_item->getTitle()) == "")
				{
					$category_item->setContextLanguage($GLOBALS['localLanguageDefault']);
					$category_list_array[] = array("title"=>"[".$category_item->getTitle()."]","id"=>$category_item->getId());
				}
				else
				{
					$category_list_array[] = array("title"=>$category_item->getTitle(),"id"=>$category_item->getId());
				}

			}
			$GLOBALS["smarty"]->assign("gallery_detail",$gallery);
			$GLOBALS["smarty"]->assign("category_list_items",$category_list_array);
			$GLOBALS["smarty"]->assign("count_category_items",count($category_list_array));
			// vypis
			$GLOBALS["smarty"]->display("ajax/gallery_edit_bindcategory.tpl");

		}
		break;

		// sort attachments in gallery
		case 'sort_items':
		{
			$entity = null;
			if($_POST["entity_type"] == CMS_Gallery::ENTITY_ID)
				$entity = new CMS_Gallery($_POST["entity_id"]);

			if(!is_null($entity))
			{
				$sort_table = new CMS_SortTable();
				$sort_table->setParentEntity($entity);

				if($_POST["entity_type"] == CMS_Gallery::ENTITY_ID)
					$sortHandler = new SortGallerySaveHandler();

				$sort_table->setSaveHandler($sortHandler);
				foreach ( $_POST["item"] as $item )
				{
					list($sub_entity_type,$sub_entity_id) = explode("_",$item);
					$sort_item = new CMS_SortTable_Item();

					## polozky tem.celku
					if($sub_entity_type == CMS_Attachment::ENTITY_ID)
						$sort_item->data = new CMS_Attachment($sub_entity_id);

					if(!is_null($sort_item->data))
						$sort_table->addItem($sort_item);
				}
				$sort_table->save();
			}
		}

		}
		exit;
	}
	############################################################################################################


	if ($_POST['go'] == 'foto') {
			Header("Location: /admin/?mcmd=4&module=CMS_Gallery&row_id[]=".$_POST['row_id'][0]);
			exit;
		}

	if ($_POST['go'] == 'edit') {
			$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: /admin/?mcmd=3&module=CMS_Gallery&row_id[]=$new_id$link");
			exit;
		}

	Header("Location: /admin/?module=CMS_Gallery&mcmd=1");
	exit;

}
catch(CN_Exception $e){
	echo $e->displayDetails();
}
?>
