<?php

try{
$GLOBALS["smarty"]->assign("time",date("Y-m-d H:i:s"));

switch ($_REQUEST["cmd"]) {
	// list kategorii *********************************************************************************
	case "1":{
		if (($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
				setReturnPoint();
                $category_all = [];
				$GLOBALS["smarty"]->assign("category_list_all",$category_all);
				$pager = TRUE;
				$category_filter_foreach = new CMS_CategoryList($_GET['start'],$GLOBALS["perpage"]);
				$category_filter_foreach->addCondition("is_trash", 0);
				if ($_GET['s_author'])
					$category_filter_foreach->addCondition("author_id", $_GET['s_author']);
				$category_filter_foreach->addCondition("usable_by",CMS_Entity::ENTITY_UNIVERSAL);

				if ($_GET['order']){

					if ($GLOBALS['sortby']=='title'){
						$category_filter_foreach->setTableName('categories,categories_lang');

						$category_filter_foreach->addCondition('`id` = `category_id` AND `language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
						$category_filter_foreach->setSortBy('title');
					}

					if ($GLOBALS['sortby']=='visibility')
						$category_filter_foreach->setSortBy('is_published');

					if ($GLOBALS['sortby']=='id')
						$category_filter_foreach->setSortBy('id');

					if ($GLOBALS['sortby']=='date')
						$category_filter_foreach->setSortBy('creation');

					$category_filter_foreach->setSortDirection($GLOBALS['direction']);
				}

				$category_filter_foreach->execute();

				// filter
				if(!isset($_GET['s_category']))
						$_GET['s_category'] = 0;

				if($_GET['s_category'] != 0){
						$category_filter = new CMS_Category($_GET['s_category']);
						$category_filter_foreach = $category_filter->getChildren();
						$pager = FALSE;
					}

				$GLOBALS["smarty"]->assign("s_category",$_GET['s_category']);

				//echo($category_filter_foreach_vektor);
				//exit;
				$table = new TPL_List();
				$table->setColumn('NUMBER');

			if($_GET['setup_type'] == 'visibility'){
				$table->setColumn('CHECKBOX','header_properties');
				$table->setColumn('CHECKBOX','list_properties');
				$table->setColumn('CHECKBOX','checked',TRUE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','check_editor_privilege',TRUE);
				$table->setColumn('CHECKBOX','check_editor_privilege_cascade',FALSE);

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('ID');

				$table->setColumn('SETUP_VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('SETUP_VISIBILITY','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('SETUP_VISIBILITY','check_editor_privilege',TRUE);
				$table->setColumn('SETUP_VISIBILITY','check_editor_privilege_cascade',FALSE);

				$table->setColumn('SETUP_TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('SETUP_TRANSLATION','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('SETUP_TRANSLATION','check_editor_privilege',TRUE);
				$table->setColumn('SETUP_TRANSLATION','check_editor_privilege_cascade',FALSE);

			}
			elseif($_GET['setup_type'] == 'access'){
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','check_editor_privilege',TRUE);
				$table->setColumn('CHECKBOX','check_editor_privilege_cascade',FALSE);
				$table->setColumn('CHECKBOX','checked',TRUE);

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('ID');

				$table->setColumn('SETUP_ACCESS');

			}
			else{


				if (getConfig('proxia','columns_display') == 'full'){

					$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
					$table->setColumn('CHECKBOX','check_editor_privilege',TRUE);
					$table->setColumn('CHECKBOX','check_editor_privilege_cascade',FALSE);

					$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
					$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('TITLE','check_editor_privilege',TRUE);
					$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

					if($_GET['s_category'] != 0)
						$table->setColumn('TITLE','orderby',FALSE);

					$table->setColumn('UNMAP_CATEGORY');

					$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
					$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('TRANSLATION','check_editor_privilege',TRUE);
					$table->setColumn('TRANSLATION','check_editor_privilege_cascade',FALSE);


					$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');
					if($_GET['s_category'] != 0)
						$table->setColumn('VISIBILITY','orderby',FALSE);

					//$table->setColumn('ID');
					$table->setColumn('PARENT_MENU');
					$table->setColumn('PARENT_CATEGORY');
					$table->setColumn('ACCESS');
					$table->setColumn('AUTHOR');
					$table->setColumn('DATE');
					if($_GET['s_category'] != 0)
						$table->setColumn('DATE','orderby',FALSE);
				}
				elseif (getConfig('proxia','columns_display') == 'simple'){

					$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
					$table->setColumn('CHECKBOX','check_editor_privilege',FALSE);

					$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
					$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('TITLE','check_editor_privilege',FALSE);
					if($_GET['s_category'] != 0)
						$table->setColumn('TITLE','orderby',FALSE);

					$table->setColumn('UNMAP_CATEGORY');

					$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
					$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('TRANSLATION','check_editor_privilege',FALSE);

					$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');
					if($_GET['s_category'] != 0)
						$table->setColumn('VISIBILITY','orderby',FALSE);

					//$table->setColumn('ID');
					/*
					$table->setColumn('PARENT_MENU');
					$table->setColumn('PARENT_CATEGORY');
					$table->setColumn('ACCESS');
					$table->setColumn('AUTHOR');
					*/

					$table->setColumn('DATE');
					if($_GET['s_category'] != 0)
						$table->setColumn('DATE','orderby',FALSE);
				}

				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::RESTORE_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','check_editor_privilege',TRUE);
				$table->setColumn('BINDINGS_CATEGORY','check_editor_privilege_cascade',FALSE);

			}
				$table->setPower($category_filter_foreach);

				$GLOBALS["smarty"]->assign("pager",$pager);

				$GLOBALS["smarty"]->assign("table",$table);

				$GLOBALS["smarty"]->assign("s_author",$_GET['s_author']);

				$GLOBALS["smarty"]->assign("setup_type",$_GET['setup_type']);

				$GLOBALS["smarty"]->assign("category_list_filter",$category_filter_foreach);

				$GLOBALS["smarty"]->display("category_list.tpl");
		}
	}
	break;
	//*************************************************************************************************


	// nova kategoria *********************************************************************************
	case "2":{
			if (($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER))
				$GLOBALS["smarty"]->display("category_new.tpl");
		}
	break;
	//*************************************************************************************************


	// edit kategorie *********************************************************************************
	case "3":{
		if (($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::VIEW_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			// nastavenie zobrazenia uvodneho bloku
				if(!isset($_GET['showtable']))$_GET['showtable'] = 0;
				require_once("vendor/cms_classes/apycom_tabs.php");

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

	    		$item5 = new Apycom_TabItem(tr("Ikony jazykových verzií"), "item5");
				$item5->setTabStyle('cool_style');

				$t = new Apycom_Tabs();
				$t->registerTabStyle($st);
				$t->setBlankImage('images/blank.gif');
				$t->setItemBeforeImageNormal('/images/tabs/tab01_before_n2.gif');
				$t->setItemBeforeImageHover('/images/tabs/tab01_before_o2.gif');
				$t->setItemBeforeImageSelected('/images/tabs/tab01_before_s.gif');

				$t->setItemAfterImageNormal('/images/tabs/tab01_after_n2.gif');
				$t->setItemAfterImageHover('/images/tabs/tab01_after_o2.gif');
				$t->setItemAfterImageSelected('/images/tabs/tab01_after_s.gif');

				$t->setItemBackgroundImageNormal('/images/tabs/tab01_back_n2.gif');
				$t->setItemBackgroundImageHover('/images/tabs/tab01_back_o2.gif');
				$t->setItemBackgroundImageSelected('/images/tabs/tab01_back_s.gif');


				$t->addTabItem($item1);
				$t->addTabItem($item2);
				$t->addTabItem($item3);
				$t->addTabItem($item4,2);
				$t->addTabItem($item5);

				$t->setSelectedItem($_GET['showtable']);
				$s = $t->render();
				$GLOBALS["smarty"]->assign("menu",$s);

				$category_detail = new CMS_Category($_REQUEST['row_id'][0]);
				$GLOBALS["smarty"]->assign("category_detail",$category_detail);

				// nacitanie listu free (nemapovanych) kategorii
				$category = new CMS_CategoryList();
				$category->getFreeCategories();
				$category->execute();
				$GLOBALS["smarty"]->assign("category_free_list",$category);

				// nacitanie listu menu
				$menu = new CMS_MenuList();
				$menu->addCondition("is_trash", 0);
				$menu->execute();
				$GLOBALS["smarty"]->assign("menu_list",$menu);

				// zoznam skupin
				$groups = new CMS_GroupList();
				$groups->setTableName('groups,groups_lang');
				$groups->addCondition('`id` = `group_id` AND `language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
				$groups->addCondition("is_published",1);
				$groups->execute();
				$GLOBALS["smarty"]->assign("group_list",$groups);

				$parent_category = array();
				$parentCategory = $category_detail->getParent();
				if(!is_null($parentCategory))
				{	$parentCategory->setContextLanguage($GLOBALS['localLanguage']);
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

				// nacitanie listu menu kde je mapovana kategoria
				$menu_list_vektor = $category_detail->getMenuList();
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
				$GLOBALS["smarty"]->assign("menu_list_items",$menu_list_array);
				$GLOBALS["smarty"]->assign("count_menu_items",count($menu_list_array));

				if(!isset($_GET['showtable']))$_GET['showtable'] = 1;
				$GLOBALS["smarty"]->assign("showtable",$_GET['showtable']);

				setHistory($category_detail,'view');

				// zobrazenie editovanej kategorie
				$GLOBALS["smarty"]->display("category_edit.tpl");
		}
	}
	break;
	//*************************************************************************************************


	// list menus manager *****************************************************************************
	case "4":{
		if (($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			setReturnPoint();
			$menu = new CMS_MenuList();
			$menu->addCondition("is_trash", 0);

			if ($_GET['order']){

				if ($GLOBALS['sortby']=='title'){
					$menu->setTableName('menus,menus_lang');
					$menu->addCondition('`id` = `menu_id`',null,null,true);
					$menu->setSortBy('title');
				}


				$menu->setSortDirection($GLOBALS['direction']);
			}

			$menu->execute();

			$table = new TPL_List();

			$table->setColumn('NUMBER');

		//	$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
		//	$table->setColumn('CHECKBOX','check_editor_privilege',TRUE);

			$table->setColumn('CHECKBOX','header_properties');
			$table->setColumn('CHECKBOX','list_properties');
			$table->setColumn('CHECKBOX','checked',TRUE);
			$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
			$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
			$table->setColumn('CHECKBOX','check_editor_privilege',TRUE);
			$table->setColumn('CHECKBOX','check_editor_privilege_cascade',FALSE);

			$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
			$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
			$table->setColumn('TITLE','href','./?cmd=6&row_id[]=<ID>');
			$table->setColumn('TITLE','check_editor_privilege',TRUE);
			$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

			$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
			$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);

			$table->setColumn('BINDINGS_MENU','privileges',CMS_Privileges::VIEW_PRIVILEGE);
			$table->setColumn('BINDINGS_MENU','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
			$table->setColumn('BINDINGS_MENU','privileges',CMS_Privileges::RESTORE_PRIVILEGE);
			$table->setColumn('BINDINGS_MENU','privileges',CMS_Privileges::DELETE_PRIVILEGE);



			$table->setPower($menu);

			$GLOBALS["smarty"]->assign("table",$table);

			$GLOBALS["smarty"]->assign("menu",$menu);

			$GLOBALS["smarty"]->display("menu_list.tpl");
		}
	}
	break;
	//**************************************************************************************************


	// new menu manager ********************************************************************************
	case "5":{
		if (($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER))
			$GLOBALS["smarty"]->display("menu_new.tpl");
		}
	break;
	//**************************************************************************************************


	// edit menu manager *******************************************************************************
	case "6":{
		if (($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::VIEW_PRIVILEGE) === true) ||($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::UPDATE_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			$menu_detail = new CMS_Menu($_REQUEST['row_id'][0]);

			$GLOBALS["smarty"]->assign("menu_detail",$menu_detail);
			setHistory($menu_detail,'view');
			$GLOBALS["smarty"]->display("menu_edit.tpl");
		}
	}
	break;
	//**************************************************************************************************

	// list articles manager ***************************************************************************
	case "7":{
		if (($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			// macitanie listu kategorii
			setReturnPoint();
			$category = new CMS_CategoryList();
			$category->addCondition("is_trash", 0);
			$category->execute();

			$GLOBALS["smarty"]->assign("category_list",$category);

			$article = new CMS_ArticleList($_GET['start'],$GLOBALS["perpage"]);
			$article->addCondition("is_archive", 0);
			$article->addCondition("is_trash", 0);
			$article->addCondition("usable_by",CMS_Entity::ENTITY_UNIVERSAL);
			if ($_GET['s_author'])
				$article->addCondition("author_id", $_GET['s_author']);

			if ($_GET['order']){

				if ($GLOBALS['sortby']=='title'){
					$article->setTableName('articles,articles_lang');

					$article->addCondition('`id` = `article_id` AND `language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
					$article->setSortBy('title');
				}

				if ($GLOBALS['sortby']=='visibility')
					$article->setSortBy('is_published');

				if ($GLOBALS['sortby']=='id')
					$article->setSortBy('id');

				if ($GLOBALS['sortby']=='date')
					$article->setSortBy('creation');

				$article->setSortDirection($GLOBALS['direction']);
			}

			$article->execute();



			if($_REQUEST['s_category'] != 0){
					$category_filter = new CMS_Category($_REQUEST['s_category']);
					$article = $category_filter->getItems(CMS_Entity::ENTITY_ARTICLE, false, $_GET['start'], $GLOBALS["perpage"], false);

					if ($_GET['order']){

						if ($GLOBALS['sortby']=='title'){
							$article->setTableName('categories_bindings,articles,articles_lang');
							$article->addCondition('`id` = `article_id` AND `language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
							$article->setSortBy('title');
						}

						if ($GLOBALS['sortby']=='visibility'){
							$article->setTableName('categories_bindings,articles');
							$article->addCondition('`id` = `item_id`',null,null,true);
							$article->setSortBy('is_published');
						}

						if ($GLOBALS['sortby']=='id'){
							$article->setTableName('categories_bindings,articles');
							$article->addCondition('`id` = `item_id`',null,null,true);
							$article->setSortBy('id');
						}

						if ($GLOBALS['sortby']=='date'){
							$article->setTableName('categories_bindings,articles');
							$article->addCondition('`id` = `item_id`',null,null,true);
							$article->setSortBy('creation');
						}

						$article->setSortDirection($GLOBALS['direction']);
					}

					$article->execute();
				}

			if($_GET['q']){
				$article = CMS_Article::fulltextSearch($_GET['q'], $_GET['start'], $GLOBALS["perpage"],FALSE, $language, FALSE);

				if ($_GET['order']){

					if ($GLOBALS['sortby']=='title'){
						$article->setTableName('articles,articles_lang');
						$article->addCondition('`id` = `article_id` AND `language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
						$article->setSortBy('title');
					}

					if ($GLOBALS['sortby']=='visibility')
						$article->setSortBy('is_published');

					if ($GLOBALS['sortby']=='id')
						$article->setSortBy('id');

					if ($GLOBALS['sortby']=='date')
						$article->setSortBy('creation');

					$article->setSortDirection($GLOBALS['direction']);
				}

				$article->execute();

				$GLOBALS["smarty"]->assign("q",$_GET['q']);
				$GLOBALS["smarty"]->assign("qs",1);
				$GLOBALS["smarty"]->assign("p_totalRecordCount",0);
			}



			$table = new TPL_List();

			$table->setColumn('NUMBER');
			if($_GET['setup_type'] == 'visibility'){

				$table->setColumn('CHECKBOX','header_properties');
				$table->setColumn('CHECKBOX','list_properties');
				$table->setColumn('CHECKBOX','checked',TRUE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','check_editor_privilege',TRUE);
				$table->setColumn('CHECKBOX','check_editor_privilege_cascade',FALSE);


				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('ID');

				$table->setColumn('SETUP_VISIBILITY');
				$table->setColumn('SETUP_VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('SETUP_VISIBILITY','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('SETUP_VISIBILITY','check_editor_privilege',TRUE);
				$table->setColumn('SETUP_VISIBILITY','check_editor_privilege_cascade',FALSE);

				$table->setColumn('SETUP_TRANSLATION');
				$table->setColumn('SETUP_TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('SETUP_TRANSLATION','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('SETUP_TRANSLATION','check_editor_privilege',TRUE);
				$table->setColumn('SETUP_TRANSLATION','check_editor_privilege_cascade',FALSE);

			}
			elseif($_GET['setup_type'] == 'access'){
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','checked',TRUE);
				$table->setColumn('CHECKBOX','check_editor_privilege',TRUE);
				$table->setColumn('CHECKBOX','check_editor_privilege_cascade',FALSE);

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('ID');

			//	$table->setColumn('SETUP_ACCESS');
				$table->setColumn('SETUP_ACCESS','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('SETUP_ACCESS','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('SETUP_ACCESS','check_editor_privilege',TRUE);
				$table->setColumn('SETUP_ACCESS','check_editor_privilege_cascade',FALSE);

			}
			elseif($_GET['setup_type'] == 'expire'){

				require_once ('scripts/calendar.php');
				$GLOBALS["calendar"] = new DHTML_Calendar('scripts/calendar/', 'sk-utf8', 'calendar-win2k-2', false);
				$GLOBALS["calendar"]->load_files();

				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','check_editor_privilege',TRUE);
				$table->setColumn('CHECKBOX','check_editor_privilege_cascade',FALSE);
				$table->setColumn('CHECKBOX','checked',TRUE);

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('ID');

			//	$table->setColumn('SETUP_EXPIRE');
				$table->setColumn('SETUP_EXPIRE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('SETUP_EXPIRE','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('SETUP_EXPIRE','check_editor_privilege',TRUE);
				$table->setColumn('SETUP_EXPIRE','check_editor_privilege_cascade',FALSE);

			}
			else{
				if (getConfig('proxia','columns_display') == 'full'){

					$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
					$table->setColumn('CHECKBOX','check_editor_privilege',TRUE);
					$table->setColumn('CHECKBOX','check_editor_privilege_cascade',FALSE);

					$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
					$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('TITLE','check_editor_privilege',TRUE);
					$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

					$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
					$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('TRANSLATION','check_editor_privilege',TRUE);
					$table->setColumn('TRANSLATION','check_editor_privilege_cascade',FALSE);

					$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');

					$table->setColumn('VALIDITY');

					//$table->setColumn('ID');

					$table->setColumn('FRONTPAGE');

					$table->setColumn('NEWS');

					$table->setColumn('PARENT_MENU');

					$table->setColumn('PARENT_CATEGORY');

					$table->setColumn('AUTHOR');

					$table->setColumn('ACCESS');

					$table->setColumn('DATE');
				}
				elseif (getConfig('proxia','columns_display') == 'simple'){

					$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
					$table->setColumn('CHECKBOX','check_editor_privilege',TRUE);
					$table->setColumn('CHECKBOX','check_editor_privilege_cascade',FALSE);

					$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
					$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('TITLE','check_editor_privilege',TRUE);
					$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

					$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
					$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('TRANSLATION','check_editor_privilege',TRUE);
					$table->setColumn('TRANSLATION','check_editor_privilege_cascade',FALSE);


					$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
					$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');

					$table->setColumn('VALIDITY');

					//$table->setColumn('ID');

					$table->setColumn('FRONTPAGE');

					//$table->setColumn('NEWS');

					//$table->setColumn('PARENT_MENU');

					//$table->setColumn('PARENT_CATEGORY');

					//$table->setColumn('AUTHOR');

					//$table->setColumn('ACCESS');

					$table->setColumn('DATE');
				}
			}

			$table->setPower($article);

			$GLOBALS["smarty"]->assign("table",$table);

			$GLOBALS["smarty"]->assign("article_list",$article);

			$GLOBALS["smarty"]->assign("setup_type",$_GET['setup_type']);

			$GLOBALS["smarty"]->assign("s_author",$_GET['s_author']);

			$GLOBALS["smarty"]->display("article_list.tpl");
		}
	}
	break;
	//**************************************************************************************************


	// new article *************************************************************************************
	case "8":{
		if (($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			// macitanie listu menu
			$menu = new CMS_MenuList();
			$menu->addCondition("is_trash", 0);
			$menu->execute();
			$GLOBALS["smarty"]->assign("menu_list",$menu);

			// macitanie listu kategorii
			$category = new CMS_CategoryList();
			$category->addCondition("is_trash",0);
			$category->addCondition("usable_by",CMS_Entity::ENTITY_UNIVERSAL);
			$category->execute();
			$GLOBALS["smarty"]->assign("category_list",$category);

			$GLOBALS["smarty"]->display("article_new.tpl");
		}
	}
	break;
	//**************************`************************************************************************



	// edit article ************************************************************************************
	case "9":{
		if (($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::VIEW_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			// nastavenie zobrazenia uvodneho bloku
			if(!isset($_GET['showtable']))$_GET['showtable'] = 0;
			require_once("vendor/cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("Info"), "item1");
			$item1->setTabStyle('cool_style');


			$item2 = new Apycom_TabItem(tr("Priradiť k menu"), "item2");
			$item2->setTabStyle('cool_style');

			$item3 = new Apycom_TabItem(tr("Priradiť ku kategórii"), "item3");
			$item3->setTabStyle('cool_style');

			$item4 = new Apycom_TabItem(tr("Prílohy"), "item4");
			$item4->setTabStyle('cool_style');

			$item5 = new Apycom_TabItem(tr("Jazykové verzie"), "item5");
			$item5->setTabStyle('cool_style');

			if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('cms_modules\cms_gallery\classes\CMS_Gallery')){
				$item6 = new Apycom_TabItem(tr("Priradiť fotogalériu"), "item6");
				$item6->setTabStyle('cool_style');
			}

			if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_EventCalendar')){
				$item7 = new Apycom_TabItem(tr("Priradiť podujatie"), "item7");
				$item7->setTabStyle('cool_style');
			}


			$item8 = new Apycom_TabItem(tr("Aktivity editorov"), "item8");
			$item8->setTabStyle('cool_style');

			if(CMS_ProjectConfig::getSingleton()->isSeoArticle()){
				$item9 = new Apycom_TabItem(tr("Podpora SEO"), "item9");
				$item9->setTabStyle('cool_style');
			}

			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);
			$t->setBlankImage('images/blank.gif');
			$t->setItemBeforeImageNormal('/images/tabs/tab01_before_n2.gif');
			$t->setItemBeforeImageHover('/images/tabs/tab01_before_o2.gif');
			$t->setItemBeforeImageSelected('/images/tabs/tab01_before_s.gif');

			$t->setItemAfterImageNormal('/images/tabs/tab01_after_n2.gif');
			$t->setItemAfterImageHover('/images/tabs/tab01_after_o2.gif');
			$t->setItemAfterImageSelected('/images/tabs/tab01_after_s.gif');

			$t->setItemBackgroundImageNormal('/images/tabs/tab01_back_n2.gif');
			$t->setItemBackgroundImageHover('/images/tabs/tab01_back_o2.gif');
			$t->setItemBackgroundImageSelected('/images/tabs/tab01_back_s.gif');

			$t->addTabItem($item1);
			$t->addTabItem($item4);
			$t->addTabItem($item2,2);
			$t->addTabItem($item3);
			$t->addTabItem($item5,2);
			$t->addTabItem($item8);

			$isEnabledGallery = false;
			if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('cms_modules\cms_gallery\classes\CMS_Gallery')){
				$t->addTabItem($item6,2);
				$isEnabledGallery = true;
				}

			if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_EventCalendar')){
				if($isEnabledGallery)
					$t->addTabItem($item7);
				else
					$t->addTabItem($item7,2);
				}

			if(CMS_ProjectConfig::getSingleton()->isSeoArticle()){
				$t->addTabItem($item9);
			}


			$t->setSelectedItem($_GET['showtable']);
			$s = $t->render();

			$GLOBALS["smarty"]->assign("menu",$s);

			$article_detail = new CMS_Article($_REQUEST['row_id'][0]);
			$GLOBALS["smarty"]->assign("article_detail",$article_detail);
			try
			{
				//var_dump($article_detail);exit;
				//$GLOBALS["smarty"]->assign("article_seo_title",$article_detail->getSeoTitle());
				//$GLOBALS["smarty"]->assign("article_seo_description",$article_detail->getSeoDescription());
			}
			catch(Exception $e)
			{
				$message = $e->getMessage();
			}

			// zistenie frontpage

			$frontpage = CMS_Frontpage::getSingleton();
			if($frontpage->itemExists($article_detail))
					$is_frontpage = 1;
				else
					$is_frontpage = 0;

			$GLOBALS["smarty"]->assign("is_frontpage",$is_frontpage);

			// nacitanie listu kategorii
			$category = new CMS_CategoryList();
			$category->execute();
			$GLOBALS["smarty"]->assign("category_list",$category);

			// nacitanie listu priloch
			$attach = $article_detail->getAttachments();
			$attach_array = array();
			foreach($attach as $attachment)
			{
				$attachment->setContextLanguage($GLOBALS['localLanguage']);
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
			//var_dump($attach);
			//exit;
			$GLOBALS["smarty"]->assign("attachments_list",$attach_array);
			$GLOBALS["smarty"]->assign("count_attach_list",count($attach_array));

			if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('cms_modules\cms_gallery\classes\CMS_Gallery')){
				// nacitanie listu galerii
				$gallery_list_article = $article_detail->getGalleries();
//				$gallery_list_article->execute();
				$gallery_list_array = array();

				foreach($gallery_list_article as $gallery_item)
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

				$gallery_all = new CMS_GalleryList();
				$gallery_all->execute();
				$GLOBALS["smarty"]->assign("gallery_list",$gallery_all);
			}

			if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_EventCalendar')){
				// nacitanie listu udalosti
				$event_list_article = $article_detail->getEvents();
				$event_list_array = array();
				foreach($event_list_article as $event_item)
				{
					$event_item->setContextLanguage($GLOBALS['localLanguage']);
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
				$GLOBALS["smarty"]->assign("event_list_items",$event_list_array);
				$GLOBALS["smarty"]->assign("count_event_items",count($event_list_array));

				// kde je priradeny clanok a event
				$event_all = new CMS_EventCalendar_EventList();
				$event_all->execute();
				$GLOBALS["smarty"]->assign("event_list",$event_all);
			}

			// nacitanie listu kategorii kde je namapovany clanok
			$article_parents_vektor = $article_detail->getParents();

			$category_list_array = array();

			foreach($article_parents_vektor as $category_item)
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

			// nacitanie listu menu
			$menu = new CMS_MenuList();
			$menu->addCondition("is_trash", 0);
			$menu->execute();
			$GLOBALS["smarty"]->assign("menu_list",$menu);

			// zoznam skupin
			$groups = new CMS_GroupList();
			$groups->setTableName('groups,groups_lang');
			$groups->addCondition('`id` = `group_id` AND `language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
			$groups->addCondition("is_published",1);
			$groups->execute();
			$GLOBALS["smarty"]->assign("group_list",$groups);


			// nacitanie listu menu kde je mapovany clanok
			$article_detail = new CMS_Article($_REQUEST['row_id'][0]);
			$menu_list_vektor = $article_detail->getMenuList();
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

			$GLOBALS["smarty"]->assign("start",$_GET['start']);
			// nastavenie zobrazenia uvodneho bloku
			if(!isset($_GET['showtable']))$_GET['showtable'] = 1;
			$GLOBALS["smarty"]->assign("showtable",$_GET['showtable']);

			require_once ('scripts/calendar.php');
			$GLOBALS["calendar"] = new DHTML_Calendar('/calendar/', 'sk-utf8', 'calendar-win2k-2', false);
			$GLOBALS["calendar"]->load_files();

			setHistory($article_detail,'view');

			//nastavenie activity users
					$update_authors = unserialize($article_detail->getUpdateAuthors());
					$toHtml = "<table cellpadding='4'>";
					$pocetEditorov = count($update_authors);
					for($k=$pocetEditorov-1;$k>=0;$k--){
							$pocetUdajov = count($update_authors[$k]);
							$toHtml .= "<tr><td >";
							if($update_authors[$k]["user_type"]==2){
								$userDetail = new CMS_User($update_authors[$k]["user_id"]);
								if($userDetail->getId() != null){
									$toHtml .= $userDetail->getFirstname()." ".$userDetail->getFamilyname();
								}else{
									$toHtml .= tr("Deleted editor");
								}
							}else{
									$toHtml .= tr("Administrátor");
							}
							//$phpDate = date_create($update_authors[$k]["date"]);
							$toHtml .= "</td>";
							$toHtml .= "<td >";
							$create_date = strtotime($update_authors[$k]["date"]);
							$toHtml .= " :: ".date("d.m.Y H:i:s",$create_date);
							$toHtml .= "</td></tr>";
					}
					$toHtml .= "</table>";
			$articleAuthor = new CMS_User($article_detail->getAuthor_id());

			$GLOBALS["smarty"]->assign("article_author",$articleAuthor);
			$GLOBALS["smarty"]->assign("activity_editors",$toHtml);

			// zobrazenie editovaneho clanku
			$GLOBALS["smarty"]->display("article_edit.tpl");
		}
	}
	break;
	//***********************************************************************************************

	// list trash manager ***************************************************************************
	case "10":{
		if (($GLOBALS['user_login']->checkPrivilege(2, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			// nastavenie zobrazenia uvodneho bloku
			setReturnPoint();

			if(!isset($_GET['showtable']))$_GET['showtable'] = 0;
			require_once("vendor/cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("Kategórie"), "javascript:ukaz(0,4)");
			$item1->setTabStyle('cool_style');


			$item2 = new Apycom_TabItem(tr("Články"), "javascript:ukaz(1,4)");
			$item2->setTabStyle('cool_style');

			$item3 = new Apycom_TabItem(tr("Menu"), "javascript:ukaz(2,4)");
			$item3->setTabStyle('cool_style');

			$item4 = new Apycom_TabItem(tr("Odkazy"), "javascript:ukaz(3,4)");
			$item4->setTabStyle('cool_style');


			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);
			$t->setBlankImage('images/blank.gif');


			$t->setItemBeforeImageNormal('/images/tabs/tab01_before_n2.gif');
			$t->setItemBeforeImageHover('/images/tabs/tab01_before_o2.gif');
			$t->setItemBeforeImageSelected('/images/tabs/tab01_before_s.gif');

			$t->setItemAfterImageNormal('/images/tabs/tab01_after_n2.gif');
			$t->setItemAfterImageHover('/images/tabs/tab01_after_o2.gif');
			$t->setItemAfterImageSelected('/images/tabs/tab01_after_s.gif');

			$t->setItemBackgroundImageNormal('/images/tabs/tab01_back_n2.gif');
			$t->setItemBackgroundImageHover('/images/tabs/tab01_back_o2.gif');
			$t->setItemBackgroundImageSelected('/images/tabs/tab01_back_s.gif');

			$t->addTabItem($item1);
			$t->addTabItem($item2);
			$t->addTabItem($item3);
			$t->addTabItem($item4);
			$t->setSelectedItem($_GET['showtable']);
			$s = $t->render();

			$trash = CMS_Trash::getSingleton();
			$GLOBALS["smarty"]->assign("trash_menu",$s);

			$GLOBALS["smarty"]->assign("trash_category_list",$trash->getCategoryList());

			$GLOBALS["smarty"]->assign("trash_article_list",$trash->getArticleList());

			$GLOBALS["smarty"]->assign("trash_menu_list",$trash->getMenuList());

			$GLOBALS["smarty"]->assign("trash_weblink_list",$trash->getWeblinkList());

			$GLOBALS["smarty"]->assign("showtable",$_GET['showtable']);


			$GLOBALS["smarty"]->display("trash_list.tpl");
		}
	}
	break;
	//**************************************************************************************************

	// list archive manager ****************************************************************************
	case "11":{
		if (($GLOBALS['user_login']->checkPrivilege(3, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			setReturnPoint();
			$archive = new CMS_ArticleList($_GET['start'],$GLOBALS["perpage"]);
			$archive->addCondition("is_archive", 1);
			$archive->addCondition("is_trash", 0);
			if ($_GET['order']){

				if ($GLOBALS['sortby']=='title'){
					$archive->setTableName('articles,articles_lang');
					$archive->addCondition('`id` = `article_id` AND `language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
					$archive->setSortBy('title');
				}

				if ($GLOBALS['sortby']=='visibility')
					$archive->setSortBy('is_published');

				if ($GLOBALS['sortby']=='id')
					$archive->setSortBy('id');

				if ($GLOBALS['sortby']=='date')
					$archive->setSortBy('creation');

				$archive->setSortDirection($GLOBALS['direction']);
			}
			$archive->execute();

			$table = new TPL_List();
			if (getConfig('proxia','columns_display') == 'full'){
				$table->setColumn('NUMBER');

				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','check_editor_privilege',FALSE);

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TRANSLATION','check_editor_privilege',FALSE);

				$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');

				$table->setColumn('VALIDITY');
				//$table->setColumn('ID');


				$table->setColumn('PARENT_MENU');
				$table->setColumn('PARENT_CATEGORY');
				$table->setColumn('AUTHOR');
				$table->setColumn('ACCESS');
				$table->setColumn('DATE');
			}elseif (getConfig('proxia','columns_display') == 'simple'){
				$table->setColumn('NUMBER');

				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','check_editor_privilege',FALSE);

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TRANSLATION','check_editor_privilege',FALSE);

				$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');

				//$table->setColumn('VALIDITY');
				//$table->setColumn('ID');


				//$table->setColumn('PARENT_MENU');
				//$table->setColumn('PARENT_CATEGORY');
				//$table->setColumn('AUTHOR');
				//$table->setColumn('ACCESS');
				$table->setColumn('DATE');
			}
			$table->setPower($archive);

			$GLOBALS["smarty"]->assign("table",$table);

			$GLOBALS["smarty"]->assign("archive_list",$archive);
			$GLOBALS["smarty"]->display("archive_list.tpl");
		}
	}
	break;
	//**************************************************************************************************

	// list weblinks ***********************************************************************************
	case "12":{
		if (($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			setReturnPoint();
			$category_all = new CMS_CategoryList();
			$category_all->addCondition("is_trash", 0);
			//$category_all->setSortBy('order');
			//$category_all->setSortDirection('DESC');
			//$category_all->setSortBy('order');
			//$category_all->setSortDirection('DESC');
			$category_all->execute();
			$GLOBALS["smarty"]->assign("category_list_all",$category_all);
			$weblink = new CMS_WeblinkList();
			$weblink->addCondition("is_trash", 0);
			//$weblink->setSortBy('order');
			//$weblink->setSortDirection('DESC');

			if ($_GET['order']){

				if ($GLOBALS['sortby']=='title'){
					$weblink->setTableName('weblinks,weblinks_lang');

					$weblink->addCondition('`id` = `weblink_id` AND `language` = \''.$GLOBALS['localLanguage'].'\' GROUP BY `id`',null,null,true);
					$weblink->setSortBy('title');
				}

				if ($GLOBALS['sortby']=='visibility'){
					$weblink->setSortBy('is_published');
				}

				if ($GLOBALS['sortby']=='id'){
					$weblink->setSortBy('id');
				}

				if ($GLOBALS['sortby']=='date'){
					$weblink->setSortBy('creation');
				}

				$weblink->setSortDirection($GLOBALS['direction']);
			}

			$weblink->execute();

			if($_REQUEST['s_category'] != 0){
					$category_filter = new CMS_Category($_REQUEST['s_category']);
					$weblink = $category_filter->getItems(CMS_Entity::ENTITY_WEBLINK, FALSE,NULL,NULL,FALSE);

					if ($_GET['order']){

						if ($GLOBALS['sortby']=='title'){
							$weblink->setTableName('categories_bindings,weblinks,weblinks_lang');
							$weblink->addCondition('`id` = `item_id` AND `id` = `weblink_id` AND `language` = \''.$GLOBALS['localLanguage'].'\' GROUP BY `id`',null,null,true);
							$weblink->setSortBy('title');
						}

						if ($GLOBALS['sortby']=='visibility'){
							$weblink->setTableName('categories_bindings,weblinks');
							$weblink->addCondition('`id` = `item_id`',null,null,true);
							$weblink->setSortBy('is_published');
						}

						if ($GLOBALS['sortby']=='id'){
							$weblink->setTableName('categories_bindings,weblinks');
							$weblink->addCondition('`id` = `item_id`',null,null,true);
							$weblink->setSortBy('id');
						}

						if ($GLOBALS['sortby']=='date'){
							$weblink->setTableName('categories_bindings,weblinks');
							$weblink->addCondition('`id` = `item_id`',null,null,true);
							$weblink->setSortBy('creation');
						}

						$weblink->setSortDirection($GLOBALS['direction']);
					}
					$weblink->execute();
				}

			$GLOBALS["smarty"]->assign("weblink_list",$weblink);

			$table = new TPL_List();
			if (getConfig('proxia','columns_display') == 'full'){
				$table->setColumn('NUMBER');

				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','check_editor_privilege',FALSE);

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TRANSLATION','check_editor_privilege',FALSE);

				$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');

				//$table->setColumn('ID');


				$table->setColumn('PARENT_MENU');
				$table->setColumn('PARENT_CATEGORY');
				$table->setColumn('AUTHOR');
				$table->setColumn('ACCESS');
				$table->setColumn('DATE');
			}elseif (getConfig('proxia','columns_display') == 'simple'){
				$table->setColumn('NUMBER');

				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','check_editor_privilege',FALSE);

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TRANSLATION','check_editor_privilege',FALSE);

				$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');

				//$table->setColumn('ID');


				//$table->setColumn('PARENT_MENU');
				//$table->setColumn('PARENT_CATEGORY');
				//$table->setColumn('AUTHOR');
				//$table->setColumn('ACCESS');
				$table->setColumn('DATE');
			}
			$table->setPower($weblink);

			$GLOBALS["smarty"]->assign("table",$table);

			$GLOBALS["smarty"]->display("weblink_list.tpl");
		}
	}
	break;
	//*************************************************************************************************

	// nova weblinka **********************************************************************************
	case "13":{
		if (($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER))
			$GLOBALS["smarty"]->display("weblink_new.tpl");
		}
	break;
	//*************************************************************************************************


	// edit weblink *********************************************************************************
	case "14":{
		if (($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::VIEW_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){

			// nastavenie zobrazenia uvodneho bloku
			if(!isset($_REQUEST['showtable']))$_REQUEST['showtable'] = 0;
			require_once("vendor/cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("Info"), "blok1");
			$item1->setTabStyle('cool_style');


			$item2 = new Apycom_TabItem(tr("Priradiť k menu"), "blok2");
			$item2->setTabStyle('cool_style');

			$item3 = new Apycom_TabItem(tr("Priradiť ku kategórii"), "blok3");
			$item3->setTabStyle('cool_style');

			$item4 = new Apycom_TabItem(tr("Jazykové verzie"), "item4");
			$item4->setTabStyle('cool_style');

    		//	$item5 = new Apycom_TabItem(tr("Ikony jazykov�ch verzi�"), "item5");
			//	$item5->setTabStyle('cool_style');

			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);
			$t->setBlankImage('images/blank.gif');
			$t->setItemBeforeImageNormal('/images/tabs/tab01_before_n2.gif');
			$t->setItemBeforeImageHover('/images/tabs/tab01_before_o2.gif');
			$t->setItemBeforeImageSelected('/images/tabs/tab01_before_s.gif');

			$t->setItemAfterImageNormal('/images/tabs/tab01_after_n2.gif');
			$t->setItemAfterImageHover('/images/tabs/tab01_after_o2.gif');
			$t->setItemAfterImageSelected('/images/tabs/tab01_after_s.gif');

			$t->setItemBackgroundImageNormal('/images/tabs/tab01_back_n2.gif');
			$t->setItemBackgroundImageHover('/images/tabs/tab01_back_o2.gif');
			$t->setItemBackgroundImageSelected('/images/tabs/tab01_back_s.gif');

			$t->addTabItem($item1);
			$t->addTabItem($item2);
			$t->addTabItem($item3);
			$t->addTabItem($item4,2);
			//$t->addTabItem($item5);
			$t->setSelectedItem($_REQUEST['showtable']);
			$s = $t->render();

			$GLOBALS["smarty"]->assign("menu",$s);

			$weblink_detail = new CMS_Weblink($_REQUEST['row_id'][0]);
			$GLOBALS["smarty"]->assign("weblink_detail",$weblink_detail);
			//echo $weblink_detail;exit;

			// nacitanie listu kategorii
			$category = new CMS_CategoryList();
			$category->addCondition("is_trash", 0);
			$category->execute();
			$GLOBALS["smarty"]->assign("category_list",$category);

			// nacitanie listu menu
			$menu = new CMS_MenuList();
			$menu->addCondition("is_trash", 0);
			$menu->execute();
			$GLOBALS["smarty"]->assign("menu_list",$menu);

			// zoznam skupin
			$groups = new CMS_GroupList();
			$groups->setTableName('groups,groups_lang');
			$groups->addCondition('`id` = `group_id` AND `language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
			$groups->addCondition("is_published",1);
			$groups->execute();
			$GLOBALS["smarty"]->assign("group_list",$groups);

			// nacitanie menu pre clanok
			$menu_list_vektor = $weblink_detail->getMenuList();
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

			// nacitanie listu kategorii kde je namapovany odkaz
			$weblink_parents_vektor = $weblink_detail->getParents();
			$category_list_array = array();

			foreach($weblink_parents_vektor as $category_item)
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

			setHistory($weblink_detail,'view');

			// zobrazenie editovanej kategorie
			$GLOBALS["smarty"]->display("weblink_edit.tpl");
		}
	}
	break;
	//*************************************************************************************************



	// list frontpage manager *************************************************************************
	case "15":{
		if (($GLOBALS['user_login']->checkPrivilege(50002, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			setReturnPoint();
			$frontpage = CMS_Frontpage::getSingleton();

			$frontpage_list = $frontpage->getItems();

			$table = new TPL_List();

			if (getConfig('proxia','columns_display') == 'full'){
				$table->setColumn('NUMBER');

				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','check_editor_privilege',FALSE);

				$table->setColumn('TITLE','orderby',FALSE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TRANSLATION','check_editor_privilege',FALSE);

				$table->setColumn('VISIBILITY','orderby',FALSE);
				$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');

				$table->setColumn('ORDER','orderby',FALSE);
				$table->setColumn('ORDER','href_up','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_up_in_frontpage\',1,\'box<INCREMENT>\')');
				$table->setColumn('ORDER','href_down','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_down_in_frontpage\',1,\'box<INCREMENT>\')');
				$table->setColumn('ORDER','href_top','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_top_in_frontpage\',1,\'box<INCREMENT>\')');
				$table->setColumn('ORDER','href_bottom','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_bottom_in_frontpage\',1,\'box<INCREMENT>\')');
				$table->setColumn('ORDER','privileges',CMS_Privileges::UPDATE_PRIVILEGE);

				$table->setColumn('VALIDITY');
				//$table->setColumn('ID','orderby',FALSE);

				$table->setColumn('FRONTPAGE_LANGUAGE_VISIBILITY','orderby',FALSE);
				$table->setColumn('FRONTPAGE_LANGUAGE_VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);

			//	$table->setColumn('PARENT_MENU');
			//	$table->setColumn('PARENT_CATEGORY');
			//	$table->setColumn('AUTHOR');
				$table->setColumn('ACCESS');
			//	$table->setColumn('DATE','orderby',FALSE);
			}elseif (getConfig('proxia','columns_display') == 'simple'){
				$table->setColumn('NUMBER');

				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','check_editor_privilege',FALSE);

				$table->setColumn('TITLE','orderby',FALSE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TRANSLATION','check_editor_privilege',FALSE);

				$table->setColumn('VISIBILITY','orderby',FALSE);
				$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');

				$table->setColumn('ORDER','orderby',FALSE);
				$table->setColumn('ORDER','href_up','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_up_in_frontpage\',1,\'box<INCREMENT>\')');
				$table->setColumn('ORDER','href_down','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_down_in_frontpage\',1,\'box<INCREMENT>\')');
				$table->setColumn('ORDER','href_top','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_top_in_frontpage\',1,\'box<INCREMENT>\')');
				$table->setColumn('ORDER','href_bottom','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_bottom_in_frontpage\',1,\'box<INCREMENT>\')');
				//$table->setColumn('VALIDITY');
				//$table->setColumn('ID','orderby',FALSE);


				//$table->setColumn('PARENT_MENU');
				//$table->setColumn('PARENT_CATEGORY');
				//$table->setColumn('AUTHOR');
				//$table->setColumn('ACCESS');
				$table->setColumn('DATE','orderby',FALSE);
			}
			$table->setPower($frontpage_list);

			$GLOBALS["smarty"]->assign("table",$table);

			$GLOBALS["smarty"]->assign("frontpage_list",$frontpage_list);
			$GLOBALS["smarty"]->display("frontpage_list.tpl");
		}
	}
	break;
	//**************************************************************************************************



	// list users *************************************************************************
	case "16":{
			setReturnPoint();
			// nastavenie zobrazenia uvodneho bloku
			if(!isset($_REQUEST['showtable']))$_REQUEST['showtable'] = 0;
			require_once("vendor/cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("Registrovaní používatelia"), "javascript:ukaz(0,2)");
			$item1->setTabStyle('cool_style');


			$item2 = new Apycom_TabItem(tr("Editori"), "javascript:ukaz(1,2)");
			$item2->setTabStyle('cool_style');

			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);
			$t->setBlankImage('images/blank.gif');
			$t->setItemBeforeImageNormal('/images/tabs/tab01_before_n2.gif');
			$t->setItemBeforeImageHover('/images/tabs/tab01_before_o2.gif');
			$t->setItemBeforeImageSelected('/images/tabs/tab01_before_s.gif');

			$t->setItemAfterImageNormal('/images/tabs/tab01_after_n2.gif');
			$t->setItemAfterImageHover('/images/tabs/tab01_after_o2.gif');
			$t->setItemAfterImageSelected('/images/tabs/tab01_after_s.gif');

			$t->setItemBackgroundImageNormal('/images/tabs/tab01_back_n2.gif');
			$t->setItemBackgroundImageHover('/images/tabs/tab01_back_o2.gif');
			$t->setItemBackgroundImageSelected('/images/tabs/tab01_back_s.gif');

			$t->addTabItem($item1);
			$t->addTabItem($item2);

			$t->setSelectedItem($_REQUEST['showtable']);
			$s = $t->render();

			############################################################################################

			$normal_users = new CMS_UserList();
			$normal_users->addCondition('is_editor', 0);
			$normal_users->execute();

			$editor_users = new CMS_UserList();
			$editor_users->addCondition('is_editor', 1);

			if($GLOBALS['user_login_type'] == CMS_UserLogin::REGULAR_USER)
				$editor_users->addCondition('id', $GLOBALS['user_login']->getId());

			$editor_users->execute();

			############################################################################################

			$GLOBALS["smarty"]->assign("tabs", $s);

  			 $GLOBALS["smarty"]->assign("showtable",$_REQUEST['showtable']);
			$GLOBALS["smarty"]->assign("normal_user_list",$normal_users);
			$GLOBALS["smarty"]->assign("editor_user_list",$editor_users);

			$GLOBALS["smarty"]->display("user_list.tpl");
	}
	break;
	//**************************************************************************************************



	// new users *************************************************************************
	case "17":{
		if (($GLOBALS['user_login']->checkPrivilege(8, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER))
			$GLOBALS["smarty"]->display("user_new.tpl");
	}
	break;
	//**************************************************************************************************



	// edit users *************************************************************************
	case "18":{
				// nastavenie zobrazenia uvodneho bloku
			if(!isset($_GET['showtable']))$_GET['showtable'] = 0;
			require_once("vendor/cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("Detail používateľa"), "javascript:ukaz(0,5)");
			$item1->setTabStyle('cool_style');

			if($GLOBALS['user_login_type'] == CMS_Userlogin::ADMIN_USER)
			{
				$item2 = new Apycom_TabItem(tr("Práva"), "javascript:ukaz(1,5)");
				$item2->setTabStyle('cool_style');

				$item3 = new Apycom_TabItem(tr("Práva na kategórie"), "javascript:ukaz(2,5)");
				$item3->setTabStyle('cool_style');

				$item4 = new Apycom_TabItem(tr("Práva na články"), "javascript:ukaz(3,5)");
				$item4->setTabStyle('cool_style');

				$item5 = new Apycom_TabItem(tr("Práva na menu"), "javascript:ukaz(4,5)");
				$item5->setTabStyle('cool_style');
			}

			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);
			$t->setBlankImage('images/blank.gif');
			$t->setItemBeforeImageNormal('/images/tabs/tab01_before_n2.gif');
			$t->setItemBeforeImageHover('/images/tabs/tab01_before_o2.gif');
			$t->setItemBeforeImageSelected('/images/tabs/tab01_before_s.gif');

			$t->setItemAfterImageNormal('/images/tabs/tab01_after_n2.gif');
			$t->setItemAfterImageHover('/images/tabs/tab01_after_o2.gif');
			$t->setItemAfterImageSelected('/images/tabs/tab01_after_s.gif');

			$t->setItemBackgroundImageNormal('/images/tabs/tab01_back_n2.gif');
			$t->setItemBackgroundImageHover('/images/tabs/tab01_back_o2.gif');
			$t->setItemBackgroundImageSelected('/images/tabs/tab01_back_s.gif');

			$t->addTabItem($item1);

			if($GLOBALS['user_login_type'] == CMS_Userlogin::ADMIN_USER)
			{
				$t->addTabItem($item2);
				$t->addTabItem($item3);
				$t->addTabItem($item4);
				$t->addTabItem($item5);
			}

			$t->setSelectedItem($_GET['showtable']);
			$s = $t->render();

			$GLOBALS["smarty"]->assign("menu",$s);


			$user_detail = new CMS_User($_REQUEST['row_id'][0]);

			$GLOBALS["smarty"]->assign("user_detail",$user_detail);
      		$GLOBALS["smarty"]->assign("showtable",$_GET['showtable']);
			###########################################################################################
			# privileges

			$GLOBALS["smarty"]->assign('privileges_view', CMS_Privileges::VIEW_PRIVILEGE);
			$GLOBALS["smarty"]->assign('privileges_add', CMS_Privileges::ADD_PRIVILEGE);
			$GLOBALS["smarty"]->assign('privileges_delete', CMS_Privileges::DELETE_PRIVILEGE);
			$GLOBALS["smarty"]->assign('privileges_update', CMS_Privileges::UPDATE_PRIVILEGE);
			$GLOBALS["smarty"]->assign('privileges_restore', CMS_Privileges::RESTORE_PRIVILEGE);
			$GLOBALS["smarty"]->assign('privileges_access', CMS_Privileges::ACCESS_PRIVILEGE);

			$logic_entities = CMS_LogicEntity::getSingleton()->getLogicEntities('core');
			$set_privileges = $user_detail->getPrivileges();

			 // uprava zoznamu entit, pridava sa novy index ak user ma nastavene nejake prava na entitu //
			foreach($set_privileges as $id => $privileges)
			{
				if(strlen($id) >= 5)
				{
					foreach($logic_entities as $logic_entity)
					{
						if(isset($logic_entity['subentities']))
						{
							if(isset($logic_entity['subentities'][$id]))
								$logic_entities[$logic_entity['id']]['subentities'][$id]['set_privileges'] = $privileges;
						}
					}
				}
				elseif(isset($logic_entities[$id]))
					$logic_entities[$id]['set_privileges'] = $privileges;
			}

			$GLOBALS["smarty"]->assign('privileges_core', $logic_entities);

			###########################################################################################

			$module_list_to_pass = array();
			$module_list = CMS_ProjectConfig::getSingleton()->getAvailableModules();

			foreach($module_list as $module)
			{
				$logic_entities = CMS_LogicEntity::getSingleton()->getLogicEntities($module);

				 // uprava zoznamu entit, pridava sa novy index ak user ma nastavene nejake prava na entitu //
				foreach($set_privileges as $id => $privileges)
				{
					if(strlen($id) >= 5)
					{
						foreach($logic_entities as $logic_entity)
						{
							if(isset($logic_entity['subentities']))
							{
								if(isset($logic_entity['subentities'][$id]))
									$logic_entities[$logic_entity['id']]['subentities'][$id]['set_privileges'] = $privileges;
							}
						}
					}
					elseif(isset($logic_entities[$id]))
						$logic_entities[$id]['set_privileges'] = $privileges;
				}

				#######################################################################################

				if(count($logic_entities) > 0) // pre moduly ktore nemaju ziadne logicke entity
					$module_list_to_pass[str_replace('CMS_', '', $module)] = $logic_entities;
			}
/*echo '<pre>';
			print_r($module_list_to_pass);exit;*/

			$GLOBALS["smarty"]->assign('privileges_modules', $module_list_to_pass);

			###########################################################################################
			# category privileges

			require("vendor/cms_classes/apycom_tree_menu.php");

			$s = new Apycom_TreeItemStyle('menu_style');
			$s->setOption('tfontStyle', 'bold Verdana');
			$s->setOption('tfontColor', '#000000, #ffffff');
			$s->setOption('titemBackColor', '#e0e0e0,#6699ff');

			$s1 = new Apycom_TreeItemStyle('no_show_style');//nepouziva sa
			$s1->setOption('titemBackColor', '#ff6666,#ff6666');

			$GLOBALS["cp_tm"] = new Apycom_TreeMenu();
			$GLOBALS["cp_tm"]->setSaveState(true);

			$GLOBALS["cp_tm"]->setWidth("'50%'");
			$GLOBALS["cp_tm"]->setExpandPolicy(Apycom_TreeMenu::EXPAND_POLICY_ON_ICON_CLICK);
			$GLOBALS["cp_tm"]->setCloseExpandedItem(false);
			$GLOBALS["cp_tm"]->setExpandItems(false);
			$GLOBALS["cp_tm"]->setFontColorHover('#000000');
			$GLOBALS["cp_tm"]->setItemBackgroundColorHover('#99ccff');
			$GLOBALS["cp_tm"]->setItemBackgroundColorNormal('#e8effd');
			$GLOBALS["cp_tm"]->setBorderColor('#ffffff');
			$GLOBALS["cp_tm"]->setBorderWidth(2);
			//$GLOBALS["cp_tm"]->setGlobalImgPrefix("images/");
			$GLOBALS["cp_tm"]->setBackgroundImage("images/back1.gif");
			$GLOBALS["cp_tm"]->setBlankImage('images/blank.gif');
			$GLOBALS["cp_tm"]->setIconExpandedNormal('images/expandbtn2.gif');
			$GLOBALS["cp_tm"]->setIconExpandedHover('images/expandbtn2.gif');
			$GLOBALS["cp_tm"]->setIconExpandedExpanded('images/collapsebtn2.gif');
			$GLOBALS["cp_tm"]->setXpEnable(false);
			$GLOBALS["cp_tm"]->setXpIconExpandNormal('images/xpexpand1.gif');
			$GLOBALS["cp_tm"]->setXpIconExpandHover('images/xpexpand1.gif');
			$GLOBALS["cp_tm"]->setXpIconCollapsedNormal('images/xpcollapse2.gif');
			$GLOBALS["cp_tm"]->setXpIconCollapsedHover('images/xpcollapse2.gif');
			$GLOBALS["cp_tm"]->setShowMenuLines(true);
			$GLOBALS["cp_tm"]->setLineImageHorizontal("images/vpoint.gif");
			$GLOBALS["cp_tm"]->setLineImageVertical("images/hpoint.gif");
			$GLOBALS["cp_tm"]->setLineImageCorner("images/cpoint.gif");

			$GLOBALS["cp_tm"]->registerItemStyle($s);
			$GLOBALS["cp_tm"]->registerItemStyle($s1);
			$GLOBALS["cp_tm"]->setPosition(Apycom_TreeMenu::POSITION_RELATIVE);

			###########################################################################################

			$GLOBALS['current_user'] = $user_detail;

			buildTree();

			$tree_menu = $GLOBALS["cp_tm"]->render();

			$GLOBALS["smarty"]->assign('tree_menu', $tree_menu);

			###########################################################################################
			# article privileges ######################################################################

			$article_list = array();

			$raw_article_list = new CMS_ArticleList();
			$raw_article_list->addCondition('is_trash', 0);
			$raw_article_list->addCondition('is_archive', 0);
			$raw_article_list->addCondition('usable_by', CMS_Entity::ENTITY_UNIVERSAL);
			$raw_article_list->execute();

			foreach($raw_article_list as $article)
			{
				$editors = strlen($article->getEditors()) > 0 ? unserialize($article->getEditors()) : array();

				$privilege_set = in_array($user_detail->getId(), $editors);

				$article_list[] = array('article_object' => $article, 'privilege_set' => $privilege_set);
			}

			$GLOBALS["smarty"]->assign('privileges_article_list', $article_list);

			###########################################################################################
			# menu privileges #########################################################################

			$menu_list = array();

			$raw_menu_list = new CMS_MenuList();
			$raw_menu_list->addCondition('is_trash', 0);
			$raw_menu_list->execute();

			foreach($raw_menu_list as $menu)
			{
				$editors = strlen($menu->getEditors()) > 0 ? unserialize($menu->getEditors()) : array();

				$privilege_set = in_array($user_detail->getId(), $editors);

				$menu_list[] = array('menu_object' => $menu, 'privilege_set' => $privilege_set);
			}

			$GLOBALS["smarty"]->assign('privileges_menu_list', $menu_list);

			###########################################################################################

			$GLOBALS["smarty"]->display("user_edit.tpl");

	}
	break;
	//**************************************************************************************************

	// list language *************************************************************************
	case "19":{
		setReturnPoint();
			$language_vektor = CMS_Languages::getSingleton();
			$language_list = $language_vektor->getList();

      $enableLanguages = array_flip(CMS_ProjectConfig::getSingleton()->getAvailableTranslations());

      $language_list_enable = array_intersect_key($language_list,$enableLanguages);

      if (count($language_list) < count($enableLanguages))
        $GLOBALS["show_add_lang"] = true;
      else
        $GLOBALS["show_add_lang"] = false;

			$GLOBALS["smarty"]->assign("language_list",$language_list_enable);
			$GLOBALS["smarty"]->display("language_list.tpl");
		}
	break;
	//**************************************************************************************************

	// new language *************************************************************************
	case "20":{
		if (($GLOBALS['user_login']->checkPrivilege(4, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			$lang_list_iso = CN_IsoCodes::getSingleton()->getList(CN_IsoCodes::LIST_ISO_639);
     		$GLOBALS["smarty"]->assign("lang_list_iso",$lang_list_iso);
			$GLOBALS["smarty"]->display("language_new.tpl");
		}
	}
	break;
	//**************************************************************************************************


	// edit language *************************************************************************
	case "21":{
			if (($GLOBALS['user_login']->checkPrivilege(4, CMS_Privileges::UPDATE_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			$language_vektor = CMS_Languages::getSingleton();
			$GLOBALS["smarty"]->assign("language_list",$language_vektor->getList());
			$GLOBALS["smarty"]->assign("language_code",$_REQUEST['row_id'][0]);
			$lang_list_iso = CN_IsoCodes::getSingleton()->getList(CN_IsoCodes::LIST_ISO_639);
			$GLOBALS["smarty"]->assign("lang_list_iso",$lang_list_iso);
			$GLOBALS["smarty"]->display("language_edit.tpl");
		}
	}
	break;
	//**************************************************************************************************

	// list kategorii mapovanie *********************************************************************************
	case "22":{
		if (($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			setReturnPoint();
			$category_all = new CMS_CategoryList();
			//$category->setOffset(0);
			//$category->setLimit(1);
			$category_all->addCondition("is_trash", 0);
			//$category_all->setSortBy('order');
			//$category_all->setSortDirection('DESC');
			$category_all->execute();

			$GLOBALS["smarty"]->assign("category_list_all",$category_all);

			$category_filter_foreach = new CMS_CategoryList();
			$category_filter_foreach->addCondition("is_trash", 0);
			$category_filter_foreach->execute();

			// filter
			if(!isset($_REQUEST['s_category']))
					$_REQUEST['s_category'] = 0;

			if($_REQUEST['s_category'] != 0){
					$category_filter = new CMS_Category($_REQUEST['s_category']);
					$category_filter_foreach = $category_filter->getItems();
					//$category_filter_foreach_vektor->setSortBy('order');
					//$category_filter_foreach_vektor->setSortDirection('DESC');
					//$category_filter_foreach = new CN_VectorIterator($category_filter_foreach_vektor);
				}

			$GLOBALS["smarty"]->assign("s_category",$_REQUEST['s_category']);

			$table = new TPL_List();

			if (getConfig('proxia','columns_display') == 'full'){

				$table->setColumn('NUMBER');
				$table->setColumn('CHECKBOX','header_properties','style="display:none"');
				$table->setColumn('CHECKBOX','list_properties','style="display:none"');
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);

				$table->setColumn('ENTITY_FLAG');

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','orderby',FALSE);

				$table->setColumn('UNMAP_CATEGORY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);

				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);

				$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('VISIBILITY','orderby',FALSE);

				$table->setColumn('VALIDITY');

				$table->setColumn('ORDER','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('ORDER','orderby',FALSE);
				$table->setColumn('ORDER','href_up','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_up_in_category\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')');
				$table->setColumn('ORDER','href_down','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_down_in_category\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')');
				$table->setColumn('ORDER','href_top','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_top_in_category\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')');
				$table->setColumn('ORDER','href_bottom','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_bottom_in_category\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')');

				//$table->setColumn('ID','orderby',FALSE);

				$table->setColumn('DATE','orderby',FALSE);
				$table->setColumn('DATE','date_format','j.n.Y');

				$table->setColumn('ACCESS');
				$table->setColumn('PARENT_MENU');
				$table->setColumn('PARENT_CATEGORY');

				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::RESTORE_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('ENTITY_NAME');
			}elseif (getConfig('proxia','columns_display') == 'simple'){
				$table->setColumn('NUMBER');

				$table->setColumn('CHECKBOX','header_properties','style="display:none"');
				$table->setColumn('CHECKBOX','list_properties','style="display:none"');

				$table->setColumn('ENTITY_FLAG');

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','orderby',FALSE);

				$table->setColumn('UNMAP_CATEGORY');

				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);

				$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('VISIBILITY','orderby',FALSE);

				//$table->setColumn('VALIDITY');

				$table->setColumn('ORDER','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('ORDER','orderby',FALSE);
				$table->setColumn('ORDER','href_up','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_up_in_category\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')');
				$table->setColumn('ORDER','href_down','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_down_in_category\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')');
				$table->setColumn('ORDER','href_top','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_top_in_category\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')');
				$table->setColumn('ORDER','href_bottom','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_bottom_in_category\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')');

				//$table->setColumn('ID','orderby',FALSE);

				$table->setColumn('DATE','orderby',FALSE);
				$table->setColumn('DATE','date_format','j.n.Y');

				//$table->setColumn('ACCESS');
				//$table->setColumn('PARENT_MENU');
				//$table->setColumn('PARENT_CATEGORY');

				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::RESTORE_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('ENTITY_NAME');
			}

			$table->setPower($category_filter_foreach);

			$GLOBALS["smarty"]->assign("table",$table);

			$GLOBALS["smarty"]->assign("category_list_filter",$category_filter_foreach);

			$GLOBALS["smarty"]->display("category_list_map.tpl");
		}
	}
	break;
	//*************************************************************************************************

	// list menus manager mapovanie *****************************************************************************
	case "23":{
		if (($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			setReturnPoint();
			$category_filter_foreach = new CMS_CategoryList();
			$category_filter_foreach->addCondition("is_trash", 0);
			$category_filter_foreach->execute();

			// filter
			if(!isset($_REQUEST['s_category']))
				$_REQUEST['s_category'] = 0;

			if($_REQUEST['s_category'] != 0){
				$category_filter = new CMS_Menu($_REQUEST['s_category']);
				$category_filter_foreach = $category_filter->getItems();

				$current_menu = new CMS_Menu($_REQUEST['s_category']);

			}

			$GLOBALS["smarty"]->assign("s_category",$_REQUEST['s_category']);
			$GLOBALS["smarty"]->assign("category_list_filter",$category_filter_foreach);


			$menu = new CMS_MenuList();
			$menu->addCondition("is_trash", 0);
			$menu->execute();



			$table = new TPL_List();
			if (getConfig('proxia','columns_display') == 'full'){
				$table->setColumn('NUMBER');

				$table->setColumn('CHECKBOX','header_properties','style="display:none"');
				$table->setColumn('CHECKBOX','list_properties','style="display:none"');
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);

				$table->setColumn('ENTITY_FLAG');

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','orderby',FALSE);

				$table->setColumn('UNMAP_MENU','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('UNMAP_MENU','check_editor_privilege',TRUE);
				$table->setColumn('UNMAP_MENU','check_editor_privilege_cascade',FALSE);

				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);

				$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('VISIBILITY','orderby',FALSE);

				$table->setColumn('VALIDITY');

				$table->setColumn('ORDER','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('ORDER','orderby',FALSE);

				//$table->setColumn('ID','orderby',FALSE);

				$table->setColumn('DATE','orderby',FALSE);
				$table->setColumn('DATE','date_format','j.n.Y');

				$table->setColumn('PARENT_MENU','title','Nadradanene<br>menu');
				$table->setColumn('PARENT_CATEGORY');
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::RESTORE_PRIVILEGE);
				$table->setColumn('BINDINGS_CATEGORY','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('ACCESS');
				$table->setColumn('ENTITY_NAME');
			}elseif (getConfig('proxia','columns_display') == 'simple'){
				$table->setColumn('NUMBER');

				$table->setColumn('CHECKBOX','header_properties','style="display:none"');
				$table->setColumn('CHECKBOX','list_properties','style="display:none"');
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);

				$table->setColumn('ENTITY_FLAG');

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','orderby',FALSE);

				$table->setColumn('UNMAP_MENU');

				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);

				$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('VISIBILITY','orderby',FALSE);

				//$table->setColumn('VALIDITY');

				$table->setColumn('ORDER','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('ORDER','orderby',FALSE);

				//$table->setColumn('ID','orderby',FALSE);

				$table->setColumn('DATE','orderby',FALSE);
				$table->setColumn('DATE','date_format','j.n.Y');

				//$table->setColumn('PARENT_MENU','title','Nadradanene<br>menu');
				//$table->setColumn('PARENT_CATEGORY');
				//$table->setColumn('ACCESS');
				$table->setColumn('ENTITY_NAME');
			}
			$table->setPower($category_filter_foreach);
			//$table->setPropertyShowIsTrash(FALSE);
//			echo $table->getPropertyShowIsTrash

			$GLOBALS["smarty"]->assign("table",$table);
			$GLOBALS["smarty"]->assign("current_menu",$current_menu);
			$GLOBALS["smarty"]->assign("menu_list",$menu);
			$GLOBALS["smarty"]->display("menu_list_map.tpl");
		}
	}
	break;
	//**************************************************************************************************


	// list news manager *************************************************************************
	case "24":{
		if (($GLOBALS['user_login']->checkPrivilege(50001, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			setReturnPoint();
			$article = new CMS_ArticleList($_GET['start'],$GLOBALS["perpage"]);
			$article->addCondition("is_archive", 0);
			$article->addCondition("is_trash", 0);
			$article->addCondition("is_news", 1);

			if ($_GET['order']){

				if ($GLOBALS['sortby']=='title'){
					$article->setTableName('articles,articles_lang');
					$article->addCondition('`id` = `article_id` AND `language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
					$article->setSortBy('title');
				}

				if ($GLOBALS['sortby']=='visibility')
					$article->setSortBy('is_published');

				if ($GLOBALS['sortby']=='id')
					$article->setSortBy('id');

				if ($GLOBALS['sortby']=='date')
					$article->setSortBy('creation');

				$article->setSortDirection($GLOBALS['direction']);
			}

			$article->execute();

			$table = new TPL_List();
			if (getConfig('proxia','columns_display') == 'full'){
				$table->setColumn('NUMBER');

				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','check_editor_privilege',FALSE);

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TRANSLATION','check_editor_privilege',FALSE);

				$table->setColumn('FLASH_NEWS','privileges',CMS_Privileges::UPDATE_PRIVILEGE);

				$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');

				$table->setColumn('VALIDITY');
				//$table->setColumn('ID');


				$table->setColumn('PARENT_MENU');
				$table->setColumn('PARENT_CATEGORY');
				$table->setColumn('AUTHOR');
				$table->setColumn('ACCESS');
				$table->setColumn('DATE');
			}elseif (getConfig('proxia','columns_display') == 'simple'){
				$table->setColumn('NUMBER');

				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
				$table->setColumn('CHECKBOX','check_editor_privilege',FALSE);

				$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TITLE','check_editor_privilege',TRUE);
				$table->setColumn('TITLE','check_editor_privilege_cascade',FALSE);

				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
				$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('TRANSLATION','check_editor_privilege',FALSE);

				$table->setColumn('FLASH_NEWS','privileges',CMS_Privileges::UPDATE_PRIVILEGE);

				$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
				$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');

				//$table->setColumn('VALIDITY');
				//$table->setColumn('ID');


				//$table->setColumn('PARENT_MENU');
				//$table->setColumn('PARENT_CATEGORY');
				//$table->setColumn('AUTHOR');
				//$table->setColumn('ACCESS');
				$table->setColumn('DATE');
			}
			$table->setPower($article);

			$GLOBALS["smarty"]->assign("table",$table);

			$GLOBALS["smarty"]->assign("news_list",$article);
			$GLOBALS["smarty"]->display("news_list.tpl");
		}
	}
	break;
	//**************************************************************************************************


	// list options manager *************************************************************************
	case "25":{
	if ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER){
			setReturnPoint();
			$all_global_options = CN_Config::loadFromFile("../config/config.xml")->getAll();;

			//$mod_list = CMS_Module::getAvailableModules();
			//print_r($all_global_options);

			//$options_vektor = CMS_Options::getSingleton();

			if(!isset($_GET['showtable']))$_GET['showtable'] = 0;
			require_once("vendor/cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("General"), "javascript:ukaz(0,3)");
			$item1->setTabStyle('cool_style');


			$item2 = new Apycom_TabItem(tr("Site"), "javascript:ukaz(1,3)");
			$item2->setTabStyle('cool_style');

			$item3 = new Apycom_TabItem(tr("Proxia"), "javascript:ukaz(2,3)");
			$item3->setTabStyle('cool_style');


			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);

			$t->setBlankImage('images/blank.gif');

			$t->setItemBeforeImageNormal('/images/tabs/tab01_before_n2.gif');
			$t->setItemBeforeImageHover('/images/tabs/tab01_before_o2.gif');
			$t->setItemBeforeImageSelected('/images/tabs/tab01_before_s.gif');

			$t->setItemAfterImageNormal('/images/tabs/tab01_after_n2.gif');
			$t->setItemAfterImageHover('/images/tabs/tab01_after_o2.gif');
			$t->setItemAfterImageSelected('/images/tabs/tab01_after_s.gif');

			$t->setItemBackgroundImageNormal('/images/tabs/tab01_back_n2.gif');
			$t->setItemBackgroundImageHover('/images/tabs/tab01_back_o2.gif');
			$t->setItemBackgroundImageSelected('/images/tabs/tab01_back_s.gif');

			$t->addTabItem($item1);
			$t->addTabItem($item2);
			$t->addTabItem($item3);

			$t->setSelectedItem($_GET['showtable']);
			$s = $t->render();

			$GLOBALS["smarty"]->assign("menu",$s);

			$GLOBALS["smarty"]->assign("showtable",$_GET['showtable']);
			$GLOBALS["smarty"]->assign("options_list",$all_global_options);
			$GLOBALS["smarty"]->display("options_list.tpl");
    }
	}
	break;
	//**************************************************************************************************

	// list media manager *************************************************************************
	case "26":{
			setReturnPoint();
			if (!$_GET['m_directory']) $_GET['m_directory']="/";
			$directory = urldecode ($_GET['m_directory']);

			if (strpos($directory, '..') !== false){
				$directory = '/';
				$_GET['m_directory']='/';
			}

			$path = "{$GLOBALS['config']['mediadir']}/$directory";

			if (!is_dir($path)){
				$directory = '/';
				$_GET['m_directory']='/';
			}

			$GLOBALS["smarty"]->assign("media_list",getDirectoryList($directory));
			$GLOBALS["smarty"]->assign("m_directory",$_GET['m_directory']);
			$GLOBALS["smarty"]->display("media_list.tpl");
		}
	break;
	//**************************************************************************************************

	// nahranie noveho adresara *************************************************************************
	case "27":{
			if (!$_GET['m_directory']) $_GET['m_directory']="/";
			$directory = urldecode ($_GET['m_directory']);
			$GLOBALS["smarty"]->assign("m_directory",$directory);

			$GLOBALS["smarty"]->display("media_new_folder.tpl");
		}
	break;
	//**************************************************************************************************

	// nahranie noveho suboru *************************************************************************
	case "28":{
			if (!$_GET['m_directory']) $_GET['m_directory']="/";
			$directory = urldecode ($_GET['m_directory']);
			$GLOBALS["smarty"]->assign("m_directory",$directory);
			if ($_GET['zip'] ?? null)
				$GLOBALS["smarty"]->display("media_new_files_zip.tpl");
			else
				$GLOBALS["smarty"]->display("media_new_file.tpl");
		}
	break;

	// client info *************************************************************************
	case "31":{
		if ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER){

			$quantum_articles = $GLOBALS['project_config']->getQuantumForEntity('CMS_Article');
			if ($quantum_articles == -1)
				 $quantum_articles = tr('neobmedzené');
			$GLOBALS["smarty"]->assign("quantum_articles",$quantum_articles);

			$quantum_categories = $GLOBALS['project_config']->getQuantumForEntity('CMS_Category');
			if ($quantum_categories == -1)
				 $quantum_categories = tr('neobmedzené');
			$GLOBALS["smarty"]->assign("quantum_categories",$quantum_categories);

			$quantum_menus = $GLOBALS['project_config']->getQuantumForEntity('CMS_Menu');
			if ($quantum_menus == -1)
				 $quantum_menus = tr('neobmedzené');
			$GLOBALS["smarty"]->assign("quantum_menus",$quantum_menus);

			$GLOBALS["smarty"]->assign("project_name",$GLOBALS['project_config']->getName());
			$GLOBALS["smarty"]->assign("client_info",$GLOBALS['project_config']->getClientInfo());
			$GLOBALS["smarty"]->assign("licence_info",$GLOBALS['project_config']->getLicenseInfo());

			$GLOBALS["smarty"]->assign("current_quantum_articles",getQuantumForEntity(CMS_Article::ENTITY_ID));
			$GLOBALS["smarty"]->assign("current_quantum_categories",getQuantumForEntity(CMS_Category::ENTITY_ID));
			$GLOBALS["smarty"]->assign("current_quantum_menus",getQuantumForEntity(CMS_Menu::ENTITY_ID));

			$GLOBALS["smarty"]->display("client_info.tpl");
		}
	}
	break;
	//**************************************************************************************************

	// nahranie skupin pouzivatelov *************************************************************************
	case "33":{
			setReturnPoint();
			$groups = new CMS_GroupList(null,null,true);
			$groups->setTableName('groups,groups_lang');
			$groups->addCondition('`id` = `group_id` AND `language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
			if ($_GET['order']){

				if ($GLOBALS['sortby']=='title'){
					$groups->setSortBy('title');
				}
				if ($GLOBALS['sortby']=='name'){
					$groups->setSortBy('name');
				}
				if ($GLOBALS['sortby']=='visibility')
					$groups->setSortBy('is_published');

				if ($GLOBALS['sortby']=='id')
					$groups->setSortBy('id');

				if ($GLOBALS['sortby']=='date')
					$groups->setSortBy('creation');

				$groups->setSortDirection($GLOBALS['direction']);
			}
			$groups->execute();


			$GLOBALS["smarty"]->assign("groups",$groups);
			//print_r($groups);
			$table = new TPL_List();
			//$table->setColumn('NUMBER');
			$table->setColumn('ID');
			$table->setColumn('ID','orderby',FALSE);

			$table->setColumn('CHECKBOX','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
			$table->setColumn('CHECKBOX','privileges',CMS_Privileges::DELETE_PRIVILEGE);
			$table->setColumn('CHECKBOX','check_editor_privilege',FALSE);

			$table->setColumn('NAME','orderby',TRUE);
			$table->setColumn('NAME','privileges',CMS_Privileges::VIEW_PRIVILEGE);
			$table->setColumn('NAME','privileges',CMS_Privileges::UPDATE_PRIVILEGE);


			$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
			$table->setColumn('TITLE','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
			$table->setColumn('TITLE','check_editor_privilege',true);
			$table->setColumn('TITLE','orderby',TRUE);

			$table->setColumn('TRANSLATION','privileges',CMS_Privileges::VIEW_PRIVILEGE);
			$table->setColumn('TRANSLATION','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
			$table->setColumn('TRANSLATION','check_editor_privilege',FALSE);

			$table->setColumn('VISIBILITY','privileges',CMS_Privileges::UPDATE_PRIVILEGE);
			$table->setColumn('VISIBILITY','href','javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')');
			$table->setColumn('VISIBILITY','orderby',TRUE);

			$table->setColumn('DATE');
			$table->setColumn('DATE','orderby',TRUE);

			$table->setPower($groups);

			$GLOBALS["smarty"]->assign("table",$table);


			$GLOBALS["smarty"]->display("group_list.tpl");
		}
	break;

	// NOVA SKUPINA /groups/ *************************************************************************
	case "34":{
		if (($GLOBALS['user_login']->checkPrivilege(12, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER))
			$GLOBALS["smarty"]->display("group_new.tpl");
		}
	break;

	// edit group *********************************************************************************
	case "35":{
		if (($GLOBALS['user_login']->checkPrivilege(12, CMS_Privileges::VIEW_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
			// nastavenie zobrazenia uvodneho bloku
				if(!isset($_GET['showtable']))$_GET['showtable'] = 0;
				require_once("vendor/cms_classes/apycom_tabs.php");

				$st = new Apycom_TabStyle('cool_style');
				$st->setOption('bfontStyle', '10px Verdana');
				$st->setOption('bfontColor', '#000000');

				$item1 = new Apycom_TabItem(tr("Informácie"), "item1");
				$item1->setTabStyle('cool_style');

				$item2 = new Apycom_TabItem(tr("Jazykové verzie"), "item2");
				$item2->setTabStyle('cool_style');


				$t = new Apycom_Tabs();
				$t->registerTabStyle($st);
				$t->setBlankImage('images/blank.gif');
				$t->setItemBeforeImageNormal('/images/tabs/tab01_before_n2.gif');
				$t->setItemBeforeImageHover('/images/tabs/tab01_before_o2.gif');
				$t->setItemBeforeImageSelected('/images/tabs/tab01_before_s.gif');

				$t->setItemAfterImageNormal('/images/tabs/tab01_after_n2.gif');
				$t->setItemAfterImageHover('/images/tabs/tab01_after_o2.gif');
				$t->setItemAfterImageSelected('/images/tabs/tab01_after_s.gif');

				$t->setItemBackgroundImageNormal('/images/tabs/tab01_back_n2.gif');
				$t->setItemBackgroundImageHover('/images/tabs/tab01_back_o2.gif');
				$t->setItemBackgroundImageSelected('/images/tabs/tab01_back_s.gif');

				$t->addTabItem($item1);
				$t->addTabItem($item2);


				$t->setSelectedItem($_GET['showtable']);
				$s = $t->render();
				$GLOBALS["smarty"]->assign("menu",$s);

				$group_detail = new CMS_Group($_REQUEST['row_id'][0]);

				$GLOBALS["smarty"]->assign("group_detail",$group_detail);


				$GLOBALS["smarty"]->assign("showtable",$_GET['showtable']);

				$users = new CMS_UserList();
				$users->addCondition("`id` not in (select user_id from users_bindings where group_id=".$_REQUEST['row_id'][0].")", null,null,true);
				$users -> execute();

				$GLOBALS["smarty"]->assign("user_list",$users);

				// zobrazenie editovanej skupiny
				$GLOBALS["smarty"]->display("group_edit.tpl");
		}
	}
	break;
	//*************************************************************************************************
	// Aktivity pouzivatelov *****************************************************************************
	case "36":{

			setReturnPoint();
			if ($_GET['s_author']){
					$user = new CMS_User($_GET['s_author']);
					$ownedArticles = $user->getArticlesChangedByUser();
					$ownedArticles->execute();
					$GLOBALS["smarty"]->assign("s_author",$_REQUEST['s_author']);
					$GLOBALS["smarty"]->assign("user",$user);
					$GLOBALS["smarty"]->assign("ownedArticles",$ownedArticles);
			}

			// zoznam editovanych clankov pre usera
			$table = new TPL_List();


		//	$table->setColumn('NUMBER');

			$table->setColumn('TITLE','privileges',CMS_Privileges::VIEW_PRIVILEGE);
			$table->setColumn('TITLE','orderby',FALSE);
			$table->setColumn('TITLE','list_wordwrap',50);

			$table->setColumn('VISIBILITY');
			$table->setColumn('VISIBILITY','orderby',FALSE);
			$table->setColumn('VISIBILITY','onclick',FALSE);

			$table->setColumn('VALIDITY');

			$table->setColumn('UPDATE_EDITOR','list_properties',"style='background-color:#e0e0e0;text-align:right;'");

			$table->setColumn('DATE','title','Dátum vytvorenia');
			$table->setColumn('DATE','orderby',FALSE);
			$table->setColumn('DATE','date_format','j.n.Y H:i:s');
			$table->setColumn('DATE','list_properties',"style='text-align:center;background-color:#ffffcc;'");

			$table->setColumn('AUTHOR','list_properties',"style='text-align:center;background-color:#ffffcc;'");

			$table->setColumn('PARENT_MENU','title','Nadradanené<br>menu');
			$table->setColumn('PARENT_CATEGORY');
		//	$table->setColumn('BINDINGS_CATEGORY');
		//	$table->setColumn('ACCESS');

			$table->setPower($ownedArticles);

			$GLOBALS["smarty"]->assign("table",$table);

			$GLOBALS["smarty"]->assign("editor_user_list",$editor_users);
			$GLOBALS["smarty"]->display("user_activity_list.tpl");

	}
	break;
	//**************************************************************************************************
	// tracking používateľov
	case "37":{
		//	setReturnPoint();
			if ($_GET['s_author']){
					$user = new CMS_User($_GET['s_author']);
					$loginReports = $user->getLoginHistory("login_time desc");

					$GLOBALS["smarty"]->assign("s_author",$_REQUEST['s_author']);
					$GLOBALS["smarty"]->assign("user",$user);
					$GLOBALS["smarty"]->assign("loginReports",$loginReports);
			}

			$GLOBALS["smarty"]->display("user_login_list.tpl");

	}
	break;
	//**************************************************************************************************
	//********* INTRO ***************************************************************************
	default:{

  			/* NAJNOVSIE CLANKY */
  		$article_recent = new CMS_ArticleList(0,10);
  		$article_recent->addCondition("is_archive", 0);
  		$article_recent->addCondition("is_trash", 0);
	    //	$article_recent->addCondition("is_published", 1);

      //	if($GLOBALS["u"]->isuserLogedIn() === false)
  		$article_recent->addCondition("access", CMS::ACCESS_PUBLIC);

  		$article_recent->addCondition("usable_by",CMS_Entity::ENTITY_UNIVERSAL);

      ################### EXPIRATION ###################################
  	   //	$article_recent->addCondition("expiration", "now()",">=");
  		$article_recent->setSortBy('creation');
  		$article_recent->setSortDirection('DESC');
  		$article_recent->execute();


      /* NAJCITANEJSIE */
      $statistics_most_viewed = new CMS_Statistics();
      $statistics_list_vektor = $statistics_most_viewed->getMostViewed(CMS_Entity::ENTITY_ARTICLE,10,true);
      //$statistics_list = new CN_VectorIterator($statistics_list_vektor);
      //var_dump($statistics_list_vektor);exit;

      // najnovsie registrovani pouzivatelia
      $registeredUsers = new CMS_UserList(0,20);
      $registeredUsers->setSortBy('creation');
      $registeredUsers->setSortDirection('DESC');
      $registeredUsers->execute();

        			/* moje CLANKY */
      if($GLOBALS['user_login_type'] == CMS_UserLogin::REGULAR_USER){
  		$article_my = new CMS_ArticleList();
  		$article_my->addCondition("is_archive", 0);
  		$article_my->addCondition("is_trash", 0);


  		$article_my->addCondition("author_id", $GLOBALS['user_login']->getId());

	    //	$article_recent->addCondition("is_published", 1);

      //	if($GLOBALS["u"]->isuserLogedIn() === false)
  		$article_my->addCondition("access", CMS::ACCESS_PUBLIC);

  		$article_my->addCondition("usable_by",CMS_Entity::ENTITY_UNIVERSAL);

      ################### EXPIRATION ###################################
  	   //	$article_recent->addCondition("expiration", "now()",">=");
  		$article_my->setSortBy('creation');
  		$article_my->setSortDirection('DESC');
  		$article_my->execute();
      }


      // nastavenie tabs
			$_GET['showtable'] = 0;
			//require_once("cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("najčítanejsie"), "item1");
			$item1->setTabStyle('cool_style');


			$item2 = new Apycom_TabItem(tr("najnovšie"), "item2");
			$item2->setTabStyle('cool_style');


			$item3 = new Apycom_TabItem(tr("noví používatelia"), "item3");
			$item3->setTabStyle('cool_style');

			if($GLOBALS['user_login_type'] == CMS_UserLogin::REGULAR_USER){
				$item4 = new Apycom_TabItem(tr("moje články"), "item4");
				$item4->setTabStyle('cool_style');
			}

			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);
			$t->setBlankImage('images/blank.gif');
			$t->setItemBeforeImageNormal('/images/tabs/tab01_before_n2.gif');
			$t->setItemBeforeImageHover('/images/tabs/tab01_before_o2.gif');
			$t->setItemBeforeImageSelected('/images/tabs/tab01_before_s.gif');

			$t->setItemAfterImageNormal('/images/tabs/tab01_after_n2.gif');
			$t->setItemAfterImageHover('/images/tabs/tab01_after_o2.gif');
			$t->setItemAfterImageSelected('/images/tabs/tab01_after_s.gif');

			$t->setItemBackgroundImageNormal('/images/tabs/tab01_back_n2.gif');
			$t->setItemBackgroundImageHover('/images/tabs/tab01_back_o2.gif');
			$t->setItemBackgroundImageSelected('/images/tabs/tab01_back_s.gif');

			$t->addTabItem($item1);
			$t->addTabItem($item2);
			$t->addTabItem($item3);

			if($GLOBALS['user_login_type'] == CMS_UserLogin::REGULAR_USER)
				$t->addTabItem($item4);

			$t->setSelectedItem($_GET['showtable']);
			$tabs = $t->render();
			$GLOBALS["smarty"]->assign("tabs",$tabs);
			$GLOBALS["smarty"]->assign("localLanguage",$GLOBALS['localLanguage']);
			$GLOBALS["smarty"]->assign("article_recent",$article_recent);
			$GLOBALS["smarty"]->assign("statistics_list_vektor",$statistics_list_vektor);
			$GLOBALS["smarty"]->assign("registered_users",$registeredUsers);
			$GLOBALS["smarty"]->assign("article_my",$article_my ?? null);
			$GLOBALS["smarty"]->display("intro.tpl");

		}
	break;

	}
}
catch(CN_Exception $e){
			echo $e->getMessage();
			echo $e->displayDetails();
	}
?>
