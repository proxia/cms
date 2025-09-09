<?php
try{
	include_once($GLOBALS['smarty']->get_template_vars('path_relative')."themes/default/scripts/functions.php");
	switch ($_GET["mcmd"]) {
		// list galerie *********************************************************************************
		case "1":{
			setReturnPoint();
			$start = $_GET['start'] ? $_GET['start'] : 0;
			$limit = $_GET['setPerPage'] ? $_GET['setPerPage'] : $GLOBALS["perpage"];
			$gallery_all = new CMS_GalleryList($start,$limit);
			$gallery_all->execute();
			$GLOBALS["smarty"]->assign("gallery_list",$gallery_all);
			$GLOBALS["smarty"]->display("list.tpl");
		}
		break;
		//*************************************************************************************************

		// nova galeria *********************************************************************************
		case "2":{
			$GLOBALS["smarty"]->display("new.tpl");
		}
		break;
		//*************************************************************************************************

		// update galerie *********************************************************************************
		case "3":{
			// nastavenie zobrazenia uvodneho bloku
			if(!isset($_GET['showtable']))
				$_GET['showtable'] = 0;

			require_once("cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');
			$item1 = new Apycom_TabItem(tr("Informácie"), "item1");
			$item1->setTabStyle('cool_style');
			$item2 = new Apycom_TabItem(tr("Priradenie k menu"), "item2");
			$item2->setTabStyle('cool_style');
			$item3 = new Apycom_TabItem(tr("Priradenie ku kategórii"), "item3");
			$item3->setTabStyle('cool_style');
			$item4 = new Apycom_TabItem(tr("Jazykové verzie"), "item4");
			$item4->setTabStyle('cool_style');

			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);
			$t->setBlankImage('images/blank.gif');
			$t->setItemBeforeImageNormal('images/tabs/tab01_before_n2.gif');
			$t->setItemBeforeImageHover('images/tabs/tab01_before_o2.gif');
			$t->setItemBeforeImageSelected('images/tabs/tab01_before_s.gif');

			$t->setItemAfterImageNormal('images/tabs/tab01_after_n2.gif');
			$t->setItemAfterImageHover('images/tabs/tab01_after_o2.gif');
			$t->setItemAfterImageSelected('images/tabs/tab01_after_s.gif');

			$t->setItemBackgroundImageNormal('images/tabs/tab01_back_n2.gif');
			$t->setItemBackgroundImageHover('images/tabs/tab01_back_o2.gif');
			$t->setItemBackgroundImageSelected('images/tabs/tab01_back_s.gif');


			$t->addTabItem($item1);
			$t->addTabItem($item2);
			$t->addTabItem($item3);
			$t->addTabItem($item4,2);

			$t->setSelectedItem($_GET['showtable']);
			$s = $t->render();
			$GLOBALS["smarty"]->assign("menu",$s);


			$gallery = new CMS_Gallery($_REQUEST['row_id'][0]);

			$gallery->execute();

			// nacitanie listu menu
			$menu = new CMS_MenuList();
			$menu->addCondition("is_trash", 0);
			$menu->execute();
			$GLOBALS["smarty"]->assign("menu_list",$menu);

			// nacitanie listu menu kde je mapovana fotogaleria
			$menu_list_vektor = $gallery->getMenuList();
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
			$GLOBALS["smarty"]->assign("count_menu_items",count($menu_list_array));

			// nacitanie listu kategorii kde je mapovana fotogaleria
			$event_parents_vektor = $gallery->getParents();
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
			$GLOBALS["smarty"]->assign("count_category_items",count($category_list_array));

			if(!isset($_GET['showtable']))$_GET['showtable'] = 1;
			$GLOBALS["smarty"]->assign("showtable",$_GET['showtable']);

			$GLOBALS["smarty"]->assign("gallery_detail",$gallery);
			$GLOBALS["smarty"]->display("edit.tpl");
		}
		break;
		//*************************************************************************************************

		// foto *********************************************************************************
		case "4":{
			$gallery = new CMS_Gallery($_REQUEST['row_id'][0]);

			$gallery->execute();

			// nacitanie listu priloch
			$attach = $gallery->getAttachments();
			$GLOBALS["smarty"]->assign("attach_list",$attach);

			$GLOBALS["smarty"]->assign("gallery_detail",$gallery);
			$GLOBALS["smarty"]->display("foto.tpl");
		}
		break;
		//*************************************************************************************************

		//sortovanie obrazkov v galerii *********************************************************************************
		case "5":{
			if(isset($_REQUEST['row_id'][0]))
			{
				$gallery = new CMS_Gallery($_REQUEST['row_id'][0]);

				$GLOBALS["smarty"]->assign("parent_id",$_REQUEST['row_id'][0]);
				$GLOBALS["smarty"]->assign("entity_type",CMS_Gallery::ENTITY_ID);

				$sort_table = new CMS_SortTable();
				$items = $gallery->getAttachments();
				foreach ( $items as $item )
				{
						$sort_item = new CMS_SortTable_Item();
						$path = $item->getFile();
						$sort_item->data	= $item;
						$item->setContextLanguage($GLOBALS['localLanguage']);
						$sort_item->thumbnail = "img.php?path={$path}&w=80";
						$sort_item->column_1 = $item->getTitle();
						//$sort_item->column_2 = $item->getLanguageIsVisible();
						//$sort_item->column_3 = $item->getId();
						$sort_table->addItem($sort_item);
				}

				$assigns = array
				(
					'section_title' => tr('Galéria / Zmena poradia'),
					'sort_table_items' => $sort_table->getItems()
				);

				$GLOBALS["smarty"]->assign($assigns);

				$GLOBALS["smarty"]->display("Proxia:default.sort_table");
			}
		}
		break;

		// mass attach to gallery
		case "999":{
			if ($_GET['m_directory'] === false){
				if ((isset ($_SESSION['last_m_directory'])) && ($_SESSION['last_m_directory'] != ''))
					$_GET['m_directory'] = $_SESSION['last_m_directory'];
				else{
					$_GET['m_directory']="/";
					$_SESSION['last_m_directory'] = $_GET['m_directory'];
				}
			}

			else{
				if (($_GET['m_directory'] == '')||($_GET['m_directory'] === false))
					$_GET['m_directory']="/";
				else
					$_SESSION['last_m_directory'] = $_GET['m_directory'];

			}


			if (($_GET['m_directory'] == '')||($_GET['m_directory'] === false))
				$_GET['m_directory']="/";

			$_SESSION['last_m_directory'] = $_GET['m_directory'];

			$directory = urldecode ($_GET['m_directory']);
			$GLOBALS["smarty"]->assign("media_list",getDirectoryList($directory));
			$GLOBALS["smarty"]->assign("m_directory",$_GET['m_directory']);
			$GLOBALS["smarty"]->assign("form_name",$_GET['form_name']);
			$GLOBALS["smarty"]->assign("form_text_name",$_GET['form_text_name']);
			if(isset($_GET['form_text_title']))
				$GLOBALS["smarty"]->assign("form_text_title",$_GET['form_text_title']);
			else
				$GLOBALS["smarty"]->assign("form_text_title","no_support");

			if(isset($_GET['media_path_output']))
				$GLOBALS["smarty"]->assign("media_path_output",$_GET['media_path_output']);
			else
				$GLOBALS["smarty"]->assign("media_path_output","no_support");

			$GLOBALS["smarty"]->display("media_list_mass_paste.tpl");
		}
		break;
		case "998":
		{
			$GLOBALS["smarty"]->display("preview.tpl");
		}
 		break;


	}
}
catch(CN_Exception $e){
	echo $e->displayDetails();
}
?>
