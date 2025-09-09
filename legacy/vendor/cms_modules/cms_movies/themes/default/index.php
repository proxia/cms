<?php
try{

include($GLOBALS['smarty']->get_template_vars(path_relative)."themes/default/scripts/functions.php");
switch ($_GET["mcmd"]) {
	// list *********************************************************************************
	case "1":{
			$all = new CMS_Movies_List();
			$all->execute();
			$GLOBALS["smarty"]->assign("movies_list",$all);
			$GLOBALS["smarty"]->display("list.tpl");
		}
	break;
	//*************************************************************************************************

	// new *********************************************************************************
	case "2":{
		require_once ('themes/default/scripts/calendar.php');
			$GLOBALS["calendar"] = new DHTML_Calendar('themes/default/scripts/calendar/', 'sk-utf8', 'calendar-win2k-2', false);
			$GLOBALS["calendar"]->load_files();
			$GLOBALS["smarty"]->display("new.tpl");
		}
	break;
	//*************************************************************************************************

	// update *********************************************************************************
	case "3":{
		require_once ('themes/default/scripts/calendar.php');
		$GLOBALS["calendar"] = new DHTML_Calendar('themes/default/scripts/calendar/', 'sk-utf8', 'calendar-win2k-2', false);
			$GLOBALS["calendar"]->load_files();
			// nastavenie zobrazenia uvodneho bloku
			if(!isset($_GET['showtable']))$_GET['showtable'] = 0;
			require_once("cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("Informácie"), "item1");
			$item1->setTabStyle('cool_style');

			$item2 = new Apycom_TabItem(tr("Fotogaléria"), "item2");
			$item2->setTabStyle('cool_style');

			$item3 = new Apycom_TabItem(tr("Jazyková viditeľnosť"), "item3");
			$item3->setTabStyle('cool_style');
/*
			$item4 = new Apycom_TabItem(tr("Priradenie k menu"), "item4");
			$item4->setTabStyle('cool_style');

			$item5 = new Apycom_TabItem(tr("Priradenie ku kategórii"), "item5");
			$item5->setTabStyle('cool_style');*/

			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);
			$t->setBlankImage('themes/default/images/blank.gif');
			$t->setItemBeforeImageNormal('themes/default/images/tabs/tab01_before_n2.gif');
			$t->setItemBeforeImageHover('themes/default/images/tabs/tab01_before_o2.gif');
			$t->setItemBeforeImageSelected('themes/default/images/tabs/tab01_before_s.gif');

			$t->setItemAfterImageNormal('themes/default/images/tabs/tab01_after_n2.gif');
			$t->setItemAfterImageHover('themes/default/images/tabs/tab01_after_o2.gif');
			$t->setItemAfterImageSelected('themes/default/images/tabs/tab01_after_s.gif');

			$t->setItemBackgroundImageNormal('themes/default/images/tabs/tab01_back_n2.gif');
			$t->setItemBackgroundImageHover('themes/default/images/tabs/tab01_back_o2.gif');
			$t->setItemBackgroundImageSelected('themes/default/images/tabs/tab01_back_s.gif');


			$t->addTabItem($item1);
			$t->addTabItem($item2);
			$t->addTabItem($item3);
// 			$t->addTabItem($item4,2);
// 			$t->addTabItem($item5);

			$t->setSelectedItem($_GET['showtable']);
			$s = $t->render();
			$GLOBALS["smarty"]->assign("menu",$s);
			if(!isset($_GET['showtable']))$_GET['showtable'] = 1;
			$GLOBALS["smarty"]->assign("showtable",$_GET['showtable']);
			$detail = new CMS_Movies($_REQUEST['row_id'][0]);
			//$detail->execute();
			$GLOBALS["smarty"]->assign("detail_movie",$detail);

			$mod = CMS_Module::addModule('CMS_Gallery');
			$mod->utilise();

			$gallery_all = new CMS_GalleryList();
			$gallery_all->execute();
			$GLOBALS["smarty"]->assign("gallery_list",$gallery_all);

			$gallery_list_event = $detail->getGalleries();
			$gallery_list_array = array();

			foreach($gallery_list_event as $gallery_item)
			{
				$gallery_item->setContextLanguage($GLOBALS['localLanguage']);
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
			
			$GLOBALS["smarty"]->assign("gallery_list_items",$gallery_list_array);
			$GLOBALS["smarty"]->assign("count_gallery_items",count($gallery_list_array));
/*
			// nacitanie listu menu
			$menu = new CMS_MenuList();
			$menu->addCondition("is_trash", 0);
			$menu->execute();
			$GLOBALS["smarty"]->assign("menu_list",$menu);

			// nacitanie listu kategorii kde je namapovany event
			$event_parents_vektor = $detail->getParentCategories();
			$category_list_array = array();

			foreach($event_parents_vektor as $category_item)
			{
				$category_item->setContextLanguage($GLOBALS['localLanguage']);
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
			$GLOBALS["smarty"]->assign("category_list_items",$category_list_array);
			$GLOBALS["smarty"]->assign("count_category_items",count($category_list_array));*/

/*
			// nacitanie menu pre event
			$menu_list_vektor = $detail->getParentMenus();
			$menu_list_array = array();

			foreach($menu_list_vektor as $menu_item)
			{
				$menu_item->setContextLanguage($GLOBALS['localLanguage']);
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

			$GLOBALS["smarty"]->assign("menu_list_items",$menu_list_array);
			$GLOBALS["smarty"]->assign("count_menu_items",count($menu_list_array));*/

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