<?php

use cms_modules\cms_event_calendar\classes\CMS_EventCalendar_Event;
use cms_modules\cms_gallery\classes\CMS_Gallery;

if(!isset($_REQUEST['showtable']))$_REQUEST['showtable'] = false;

try{

	ini_set("include_path",ini_get('include_path').PATH_SEPARATOR.realpath('../'));

	require_once("scripts/functions.php");
 	require_once("smarty/Smarty.class.php");

	$GLOBALS['project_folder']="/www";

	$smarty = new Smarty();

	$smarty->register_resource('Proxia', array(
												'Proxia_getTemplate',
												'Proxia_getTimestamp',
												'Proxia_isSecure',
												'Proxia_isTrusted'
											));

	$smarty->plugins_dir[] = '../smarty_plugins';

	$smarty->template_dir = "../templates/templates";
	$smarty->compile_dir = "../templates/templates_c";
	$smarty->cache_dir = "../templates/cache";
	$smarty->config_dir = "../templates/configs";

	// language settings
	$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
	$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();

	$GLOBALS['LanguageListLocal'] = array();
	foreach ($GLOBALS['LanguageList'] as $value){
		if ($value['local_visibility']){
			$a[$value['code']] = $value;
			$GLOBALS['LanguageListLocal'] = array_merge($GLOBALS['LanguageListLocal'],$a);
		}
	}
	$smarty->assign("LanguageListLocal",$GLOBALS['LanguageListLocal']);
	$smarty->assign("LanguageList",$GLOBALS['LanguageList']);
	$smarty->assign("localLanguage",$_SESSION['localLanguage']);
	$GLOBALS['localLanguageDefault'] = getConfig('proxia','default_local_language');
	$smarty->assign("localLanguageDefault",$GLOBALS['localLanguageDefault']);

	// nastavenie vyznacenia zobrazenia default jazyka ak nie je naplneny prave pozadovany zobrazovany jazyk obsahu
	$GLOBALS['defaultViewStartTag'] = '[';
	$GLOBALS['defaultViewEndTag'] = ']';

	$smarty->assign("defaultViewStartTag",$GLOBALS['defaultViewStartTag']);
	$smarty->assign("defaultViewEndTag",$GLOBALS['defaultViewEndTag']);

	// NASTAVENIE PREMENNYCH PRE PRAVA   ######################################################################

	$GLOBALS['user_login_type'] = $_SESSION['user']['type'];
	$smarty->assign("user_login_type",$GLOBALS['user_login_type']);

	$smarty->assign("privilege_access",CMS_Privileges::ACCESS_PRIVILEGE);
	$smarty->assign("privilege_view",CMS_Privileges::VIEW_PRIVILEGE);
	$smarty->assign("privilege_add",CMS_Privileges::ADD_PRIVILEGE);
	$smarty->assign("privilege_delete",CMS_Privileges::DELETE_PRIVILEGE);
	$smarty->assign("privilege_update",CMS_Privileges::UPDATE_PRIVILEGE);
	$smarty->assign("privilege_restore",CMS_Privileges::RESTORE_PRIVILEGE);

	$GLOBALS['user_login'] = CMS_UserLogin::getSingleton()->getUser();
	$smarty->assign("user_login",$GLOBALS['user_login']);

	$smarty->assign("regular_user",CMS_UserLogin::REGULAR_USER);
	$smarty->assign("admin_user",CMS_UserLogin::ADMIN_USER);

	$GLOBALS["smarty"] = $smarty;

	if(!isset($_POST['goIn']))$_POST['goIn'] = false;
	if(!isset($_POST['section']))$_POST['section'] = false;

	$prefered_language = $GLOBALS['user_login']->getConfigValue('prefered_language');
	CN_Application::getSingleton()->setLanguage($prefered_language);



	switch($_REQUEST['section'])
	{

	###########################################################################################################
	################################################  ARTICLE ################################################
	###########################################################################################################

	case 'article_attachments':{

		$article = new CMS_Article($_POST['row_id'][0]);

		if ($_POST['goIn'] == 'insert')
		{
			$priloha = new CMS_Attachment();
			$priloha->setContextLanguage($GLOBALS['localLanguage']);

			$priloha->setTitle($_POST['p__title']);
			$priloha->setFile($_POST['p__file']);

			$priloha->save();
			$article->addAttachment($priloha);
		}


		if ($_POST['goIn'] == 'update' && isset($_POST['update_atachment_id']))
		{
			$priloha = new CMS_Attachment($_POST['update_atachment_id']);
			$priloha->setContextLanguage($GLOBALS['localLanguage']);
			$visibility = (isset($_POST['language_visibility']) && $_POST['language_visibility'] == 1) ? 1 : 0;
			$priloha->setLanguageIsVisible($visibility);
			$title = $_POST['p__title'.$_POST['update_atachment_id']];
			$priloha->setTitle($title);
			$priloha->save();
		}


		if ($_POST['goIn'] == 'delete')
		{

			if ((isset($_POST['attach_delete'])) && ($_POST['attach_delete'] > 0))
			{
				$priloha = new CMS_Attachment($_POST['attach_delete']);
				$article->removeAttachment($priloha);
			}
		}


		// priprava na vypis zoznamu priloh
		$attach = $article->getAttachments();
		$attach_array = array();
		foreach($attach as $attachment)
		{
			$attachment->setContextLanguage($_SESSION['localLanguage']);
			$path = "{$GLOBALS['config']['mediadir']}/".$attachment->getFile();
			if (is_file($path)){
				$name = basename($path);
				$size = stat($path);
			}
			if(trim($attachment->getTitle()) == "")
			{
				$attachment->setContextLanguage($GLOBALS['localLanguageDefault']);
				$attach_array[] = array("title"=>"[".$attachment->getTitle()."]","id"=>$attachment->getId(),"size"=>round($size['size']/1024),"name"=>$name,"path"=>$path,"languageisvisible"=>$attachment->getLanguageIsVisible());
			}
			else
			{
				$attach_array[] = array("title"=>$attachment->getTitle(),"id"=>$attachment->getId(),"size"=>round($size['size']/1024),"name"=>$name,"path"=>$path,"languageisvisible"=>$attachment->getLanguageIsVisible());
			}

		}
		//var_dump($attach_array);
		$GLOBALS["smarty"]->assign("attachments_list",$attach_array);
		$GLOBALS["smarty"]->assign("count_attach_list",count($attach_array));
		$GLOBALS["smarty"]->assign("article_detail",$article);

		// vypis zoznamu priloh
		$GLOBALS["smarty"]->display("ajax/article_edit_zoznam_priloh.tpl");

	}
	break;

	################################################################################################
	# section languages
	################################################################################################


	case 'article_languages':{

		$article = new CMS_Article($_POST['row_id'][0]);

		foreach ($GLOBALS['LanguageList'] as $value)
		{
			$code = $value['code'];

			$local_visibility = $value['local_visibility'];

			if ($local_visibility)
			{
				$valname = "a_languageIsVisible".$code;

				if(!isset($_POST[$valname]))
					$_POST[$valname] = 0;

				$article->setContextLanguage($code);

				$article->setLanguageIsVisible($_POST[$valname]);
			}
		}
		$article->save();

		// priprava na vypis zoznamu jazykovych nastaveni
		$GLOBALS["smarty"]->assign("article_detail",$article);

		// vypis zoznamu jazykovych nastaveni
		$GLOBALS["smarty"]->display("ajax/article_edit_language_versions.tpl");

	}
	break;

	################################################################################################
	# section seo
	################################################################################################


	case 'article_seo':{

		$article = new CMS_Article($_POST['row_id'][0]);

		$article->setContextLanguage($GLOBALS['localLanguage']);

		$seo_title = $_POST['seo__title'];
		$seo_description = $_POST['seo__description'];

		$article->setSeoTitle($seo_title);
		$article->setSeoDescription($seo_description);
		$article->save();

		// priprava na vypis zoznamu jazykovych nastaveni
		//$GLOBALS["smarty"]->assign("article_detail",$article);

		// vypis zoznamu jazykovych nastaveni
		echo "<div style='margin:8px;text-align:center;font-size:1.4em;'>OK - Zapísané</div>";

	}
	break;
	################################################################################################
	case 'article_bindmenu':{

		$article = new CMS_Article($_POST['row_id'][0]);

		if ($_POST['remove_menu_id'])
		{
			$menu = new CMS_Menu($_POST['remove_menu_id']);
			$menu->removeItem($article);
		}

		if ($_POST['add_menu_id'])
		{
			$menu = new CMS_Menu($_POST['add_menu_id']);
			if(!$menu->itemExists($article))
				$menu->addItem($article);
		}

		// nacitanie menu pre clanok
		$menu_list_vektor = $article->getMenuList();
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

		$GLOBALS["smarty"]->assign("article_detail",$article);
		$GLOBALS["smarty"]->assign("menu_list_items",$menu_list_array);
		$GLOBALS["smarty"]->assign("count_menu_items",count($menu_list_array));
		// vypis
		$GLOBALS["smarty"]->display("ajax/article_edit_bindmenu.tpl");

	}
	break;

	case 'article_bindcategory':{

		$article = new CMS_Article($_POST['row_id'][0]);

		if ($_POST['add_category_id'])
		{
				$category = new CMS_Category($_POST['add_category_id']);
				if(!$category->itemExists($article))
					$category->addItem($article);
		}

		if ($_POST['remove_category_id'])
		{
				$category = new CMS_Category($_POST['remove_category_id']);
				$category->removeItem($article);
		}

		// nacitanie listu kategorii kde je namapovany clanok
		$article_parents_vektor = $article->getParents();
		$category_list_array = array();

		foreach($article_parents_vektor as $category_item)
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
		$GLOBALS["smarty"]->assign("article_detail",$article);
		$GLOBALS["smarty"]->assign("category_list_items",$category_list_array);
		$GLOBALS["smarty"]->assign("count_category_items",count($category_list_array));
		// vypis
		$GLOBALS["smarty"]->display("ajax/article_edit_bindcategory.tpl");

	}
	break;

	case 'article_bindgallery':{

		$article = new CMS_Article($_POST['row_id'][0]);

		if ($_POST['map_gallery']){
			$mod = CMS_Module::addModule('cms_modules\cms_gallery\classes\CMS_Gallery');
			$mod->utilise();
			$gallery = new CMS_Gallery($_POST['map_gallery']);
			$article->addGallery($gallery);

		}

		if ($_POST['unmap_gallery']){
			$mod = CMS_Module::addModule('cms_modules\cms_gallery\classes\CMS_Gallery');
			$mod->utilise();
			$article->removeGallery(new CMS_Gallery($_POST['unmap_gallery']));
		}

		$gallery_list_article = $article->getGalleries();
		//$gallery_list_article->execute();
		$gallery_list_array = array();

		foreach($gallery_list_article as $gallery_item)
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
		$GLOBALS["smarty"]->assign("article_detail",$article);
		$GLOBALS["smarty"]->assign("gallery_list_items",$gallery_list_array);
		$GLOBALS["smarty"]->assign("count_gallery_items",count($gallery_list_array));
		// vypis
		$GLOBALS["smarty"]->display("ajax/article_edit_bindgallery.tpl");

	}
	break;

	case 'article_bindevent':{

		$article = new CMS_Article($_POST['row_id'][0]);

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

		$event_list_article = $article->getEvents();
		$event_list_array = array();

		foreach($event_list_article as $event_item)
		{
			$event_item->setContextLanguage($_SESSION['localLanguage']);
			if(trim($event_item->getTitle()) == "")
			{
				$event_item->setContextLanguage($GLOBALS['localLanguageDefault']);
				$event_list_array[] = array("title"=>"[".$event_item->getTitle()."]","id"=>$event_item->getId());
			}
			else
			{
				$event_list_array[] = array("title"=>$event_item->getTitle(),"id"=>$event_item->getId());
			}

		}
		$GLOBALS["smarty"]->assign("article_detail",$article);
		$GLOBALS["smarty"]->assign("event_list_items",$event_list_array);
		$GLOBALS["smarty"]->assign("count_event_items",count($event_list_array));
		// vypis
		$GLOBALS["smarty"]->display("ajax/article_edit_bindevent.tpl");

	}
	break;

	###########################################################################################################
	################################################  CATEGORY ################################################
	###########################################################################################################

	case 'category_bindmenu':{

		$category = new CMS_Category($_POST['row_id'][0]);

		if ($_POST['remove_menu_id'])
		{
			$menu = new CMS_Menu($_POST['remove_menu_id']);
			$menu->removeItem($category);
		}

		if ($_POST['add_menu_id'])
		{
			$menu = new CMS_Menu($_POST['add_menu_id']);
			if(!$menu->itemExists($category))
				$menu->addItem($category);
		}

		// nacitanie menu pre clanok
		$menu_list_vektor = $category->getMenuList();
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

		$GLOBALS["smarty"]->assign("category_detail",$category);
		$GLOBALS["smarty"]->assign("menu_list_items",$menu_list_array);
		$GLOBALS["smarty"]->assign("count_menu_items",count($menu_list_array));
		// vypis
		$GLOBALS["smarty"]->display("ajax/category_edit_bindmenu.tpl");

	}
	break;

	case 'category_bindcategory':{

		$category = new CMS_Category($_POST['row_id'][0]);

		if ($_POST['add_category_id']>0)
		{
			$category_parent = new CMS_Category($_POST['add_category_id']);
			if($category->hasParent()){
					$category->getParent()->removeItem($category);
					$category_parent->addItem($category);
				}
			else
				$category_parent->addItem($category);
		}

		if ($_POST['goIn'] == 'delete')
		{
			if($category->hasParent())
					$category->getParent()->removeItem($category);
		}

		$parent_category = array();
		$parentCategory = $category->getParent();
		if(!is_null($parentCategory))
		{	$parentCategory->setContextLanguage($_SESSION['localLanguage']);
			if(trim($parentCategory->getTitle()) == "")
			{
				$parentCategory->setContextLanguage($GLOBALS['localLanguageDefault']);
				$parent_category = array("title"=>"[".$parentCategory->getTitle()."]","id"=>$parentCategory->getId());
			}
			else
			{
				$parent_category = array("title"=>$parentCategory->getTitle(),"id"=>$parentCategory->getId());
			}
		}
		$GLOBALS["smarty"]->assign("parent_category",$parent_category);
		$GLOBALS["smarty"]->assign("parent_category_id",is_null($parentCategory) ? false :$parentCategory->getId());
		$GLOBALS["smarty"]->assign("category_detail",$category);
		// vypis
		$GLOBALS["smarty"]->display("ajax/category_edit_bindcategory.tpl");

	}
	break;

	case 'category_languages':{

		$category = new CMS_Category($_POST['row_id'][0]);

		foreach ($GLOBALS['LanguageList'] as $value)
		{
			$code = $value['code'];

			$local_visibility = $value['local_visibility'];

			if ($local_visibility)
			{
				$valname = "a_languageIsVisible".$code;

				if(!isset($_POST[$valname]))
					$_POST[$valname] = 0;

				$category->setContextLanguage($code);

				$category->setLanguageIsVisible($_POST[$valname]);
			}
		}
		$category->save();

		// priprava na vypis zoznamu jazykovych nastaveni
		$GLOBALS["smarty"]->assign("category_detail",$category);

		// vypis zoznamu jazykovych nastaveni
		$GLOBALS["smarty"]->display("ajax/category_edit_language_versions.tpl");

	}
	break;

	case 'category_icon_languages':{

		$category = new CMS_Category($_POST['row_id'][0]);

		foreach ($GLOBALS['LanguageList'] as $value)
		{
			$code = $value['code'];

			$local_visibility = $value['local_visibility'];

			if ($local_visibility)
			{
				$valname = "a_languageIcons".$code;
				if(!isset($_POST[$valname]))
					$_POST[$valname] = "";

				$category->setContextLanguage($code);

				$category->setLocalizedImage($_POST[$valname]);
			}
		}
		$category->save();

		// priprava na vypis zoznamu jazykovych nastaveni
		$GLOBALS["smarty"]->assign("category_detail",$category);

		// vypis zoznamu jazykovych nastaveni
		$GLOBALS["smarty"]->display("ajax/category_edit_language_icons.tpl");

	}
	break;


	###########################################################################################################
	################################################  WEBLINK ################################################
	###########################################################################################################

	case 'weblink_bindmenu':{

		$weblink = new CMS_Weblink($_POST['row_id'][0]);

		if ($_POST['remove_menu_id'])
		{
			$menu = new CMS_Menu($_POST['remove_menu_id']);
			$menu->removeItem($weblink);
		}

		if ($_POST['add_menu_id'])
		{
			$menu = new CMS_Menu($_POST['add_menu_id']);
			if(!$menu->itemExists($weblink))
				$menu->addItem($weblink);
		}

		// nacitanie menu pre clanok
		$menu_list_vektor = $weblink->getMenuList();
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

		$GLOBALS["smarty"]->assign("weblink_detail",$weblink);
		$GLOBALS["smarty"]->assign("menu_list_items",$menu_list_array);
		$GLOBALS["smarty"]->assign("count_menu_items",count($menu_list_array));
		// vypis
		$GLOBALS["smarty"]->display("ajax/weblink_edit_bindmenu.tpl");

	}
	break;

	case 'weblink_bindcategory':{

		$weblink = new CMS_Weblink($_POST['row_id'][0]);

		if ($_POST['add_category_id'])
		{
				$category = new CMS_Category($_POST['add_category_id']);
				if(!$category->itemExists($weblink))
					$category->addItem($weblink);
		}

		if ($_POST['remove_category_id'])
		{
				$category = new CMS_Category($_POST['remove_category_id']);
				$category->removeItem($weblink);
		}

		// nacitanie listu kategorii kde je namapovany clanok
		$weblink_parents_vektor = $weblink->getParents();
		$category_list_array = array();

		foreach($weblink_parents_vektor as $category_item)
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
		$GLOBALS["smarty"]->assign("weblink_detail",$weblink);
		$GLOBALS["smarty"]->assign("category_list_items",$category_list_array);
		$GLOBALS["smarty"]->assign("count_category_items",count($category_list_array));
		// vypis
		$GLOBALS["smarty"]->display("ajax/weblink_edit_bindcategory.tpl");

	}
	break;

	case 'weblink_languages':{

		$weblink = new CMS_Weblink($_POST['row_id'][0]);

		foreach ($GLOBALS['LanguageList'] as $value)
		{
			$code = $value['code'];

			$local_visibility = $value['local_visibility'];

			if ($local_visibility)
			{
				$valname = "a_languageIsVisible".$code;

				if(!isset($_POST[$valname]))
					$_POST[$valname] = 0;

				$weblink->setContextLanguage($code);

				$weblink->setLanguageIsVisible($_POST[$valname]);
			}
		}
		$weblink->save();

		// priprava na vypis zoznamu jazykovych nastaveni
		$GLOBALS["smarty"]->assign("weblink_detail",$weblink);

		// vypis zoznamu jazykovych nastaveni
		$GLOBALS["smarty"]->display("ajax/weblink_edit_language_versions.tpl");

	}
	break;

	default:
		; // throw;

	}
}
catch(CN_Exception $e){
	if (CN_Application::getSingleton()->getDebug() === true)
		echo $e->displayDetails();
}
?>
