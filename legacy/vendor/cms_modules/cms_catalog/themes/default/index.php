<?php
try{

	$GLOBALS['tmpfiles_path'] ="tmp/";

	include($GLOBALS['smarty']->get_template_vars('path_relative')."themes/default/scripts/functions.php");

	if (!isset($GLOBALS['project_config']))
			$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);



	switch ($_GET["mcmd"]) {
		// list catalog *************************************************************************************
		case "1":{

			setReturnPoint();

			//$_SESSION['currentCatalog'] = null;
			$catalog_list = new CMS_Catalog_list();
			$catalog_list->execute();
			$GLOBALS["smarty"]->assign("catalog_list",$catalog_list);
			$GLOBALS["smarty"]->display("catalog_list.tpl");
		}
		break;
		//************************************************************************************************

		// new catalog ***********************************************************************************
		case "2":{
			$GLOBALS["smarty"]->display("catalog_new.tpl");
		}
		break;
		//*************************************************************************************************

		// edit catalog ************************************************************************************
		case "3":{
			// nastavenie zobrazenia uvodneho bloku

			if(!isset($_GET['showtable']))$_GET['showtable'] = 0;
			require_once("cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("Informácie"), "item1");
			$item1->setTabStyle('cool_style');

			$item2 = new Apycom_TabItem(tr("Jazykové verzie"), "item2");
			$item2->setTabStyle('cool_style');

			$item3 = new Apycom_TabItem(tr("Priradenie k menu"), "item3");
			$item3->setTabStyle('cool_style');

			$item4 = new Apycom_TabItem(tr("Priradenie ku kategórii"), "item4");
			$item4->setTabStyle('cool_style');

			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);
			$t->setBlankImage('themes/default/images/blank.gif');
			$t->setItemBeforeImageNormal('/admin/images/tabs/tab01_before_n2.gif');
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
			$t->addTabItem($item4);

			$t->setSelectedItem($_GET['showtable']);
			$s = $t->render();

			$GLOBALS["smarty"]->assign("menu",$s);

			$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
			$catalog->execute();
			$GLOBALS["smarty"]->assign("detail_catalog",$catalog);

			// nacitanie listu menu
			$menu = new CMS_MenuList();
			$menu->addCondition("is_trash", 0);
			$menu->execute();
			$GLOBALS["smarty"]->assign("menu_list",$menu);

			// nacitanie listu menu kde je mapovana fotogaleria
			$menu_parents = $catalog->getMenuList();
			$GLOBALS["smarty"]->assign("menu_list_items",$menu_parents);

			// nacitanie listu kategorii kde je mapovana fotogaleria
			$category_parents = $catalog->getParents();
			$GLOBALS["smarty"]->assign("category_list_items",$category_parents);


			$GLOBALS["smarty"]->display("catalog_edit.tpl");
		}
		break;
		//*************************************************************************************************

		// list branch *************************************************************************************
		case "4":{

			setReturnPoint();

			$zdroj['catalog'] = $_SESSION['currentCatalog'];

			$zdroj['start'] = $_GET['start'] ? $_GET['start'] : 0;
			if ($_GET['s_category']){
				$zdroj['adr'] = $_GET['s_category'];
				$zdroj['catalog'] = null;
			}

			if(is_null($GLOBALS["perpage"]))
				 $GLOBALS["perpage"] = 20;

			$validRangeFrom = $zdroj['start'];
			$validRangeTo = $zdroj['start']+$GLOBALS["perpage"];
			$zdroj['valid_range_from'] = $validRangeFrom;
			$zdroj['valid_range_to'] = $validRangeTo;
			$countRowsAll = 0;
			$countRows = 0;

			$branch_list = getBranchListCascade($zdroj,$countRows,$countRowsAll);

			$GLOBALS["countAllRows"] = $countRowsAll;
			$GLOBALS["countRows"] = count($branch_list);

			$GLOBALS["smarty"]->assign("branch_list",$branch_list);

			$GLOBALS["smarty"]->display("branch_list.tpl");
		}
		break;
		//************************************************************************************************


		// new branch ***********************************************************************************
		case "5":{

			$GLOBALS["smarty"]->display("branch_new.tpl");
		}
		break;
		//*************************************************************************************************

		// edit branch ************************************************************************************
		case "6":{

			$mod = CMS_Module::addModule('CMS_Gallery');
			$mod->utilise();

			$gallery_all = new CMS_GalleryList();
			$gallery_all->execute();
			$GLOBALS["smarty"]->assign("gallery_list",$gallery_all);

			// nastavenie zobrazenia uvodneho bloku

			if(!isset($_GET['showtable']))$_GET['showtable'] = 0;
			require_once("cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("Informácie"), "item1");
			$item1->setTabStyle('cool_style');

			$item2 = new Apycom_TabItem(tr("Priradenie"), "item2");
			$item2->setTabStyle('cool_style');

			$item3 = new Apycom_TabItem(tr("Jazykové verzie"), "item3");
			$item3->setTabStyle('cool_style');

			$item4 = new Apycom_TabItem(tr("Galérie"), "item4");
			$item4->setTabStyle('cool_style');

			$item5 = new Apycom_TabItem(tr("Atribúty"), "item5");
			$item5->setTabStyle('cool_style');

			$item6 = new Apycom_TabItem(tr("Prílohy"), "item6");
			$item6->setTabStyle('cool_style');

			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);

			$t->setBlankImage('themes/default/images/blank.gif');

			$t->setItemBeforeImageNormal('/admin/images/tabs/tab01_before_n2.gif');
			$t->setItemBeforeImageHover('/admin/images/tabs/tab01_before_o2.gif');
			$t->setItemBeforeImageSelected('/admin/images/tabs/tab01_before_s.gif');

			$t->setItemAfterImageNormal('/admin/images/tabs/tab01_after_n2.gif');
			$t->setItemAfterImageHover('/admin/images/tabs/tab01_after_o2.gif');
			$t->setItemAfterImageSelected('/admin/images/tabs/tab01_after_s.gif');

			$t->setItemBackgroundImageNormal('/admin/images/tabs/tab01_back_n2.gif');
			$t->setItemBackgroundImageHover('/admin/images/tabs/tab01_back_o2.gif');
			$t->setItemBackgroundImageSelected('/admin/images/tabs/tab01_back_s.gif');

			$t->addTabItem($item1);
			$t->addTabItem($item2);
			$t->addTabItem($item4);
			$t->addTabItem($item3,2);
			$t->addTabItem($item5);
			$t->addTabItem($item6);

			$t->setSelectedItem($_GET['showtable']);

			$GLOBALS["smarty"]->assign("menu2",$t->render());

			if(!isset($_GET['showtable']))$_GET['showtable'] = 1;
			$GLOBALS["smarty"]->assign("showtable",$_GET['showtable']);

			$branch = new CMS_Catalog_branch($_REQUEST['row_id'][0]);
			$branch->execute();
			$GLOBALS["smarty"]->assign("category_detail",$branch);

			# all galleries
			$gallery_branch_list = $branch->getGalleries();
			$GLOBALS["smarty"]->assign("gallery_branch_list",$gallery_branch_list);

			# all attributes
			$attribut_list = new CMS_Catalog_AttributeDefinitionList();
			$attribut_list->setTableName('`catalog_attributes_definition`,`catalog_attributes_definition_lang`');
			$attribut_list->addCondition('id','attribute_definition_id');
			$attribut_list->addCondition("catalog_id", $_SESSION['currentCatalog']);
			$attribut_list->addCondition("language","'{$GLOBALS['localLanguage']}'");
			$attribut_list->setSortBy("title");
			$attribut_list->execute();
			$GLOBALS["smarty"]->assign("attribut_list",$attribut_list);

			# attributes for current branch
			$attribut_branch_list = $branch->getAttributes();

			foreach ($attribut_branch_list as $attribut){

				$attribut_ = new CMS_Catalog_AttributeDefinition($attribut->getAttributeDefinitionId());

				$attribut_->setContextLanguage($GLOBALS['localLanguage']);
				$defaultView = 0;
				if ($attribut_->getTitle() == ''){
					$attribut_->setContextLanguage($GLOBALS['localLanguageDefault']);
					$defaultView = 1;
				}
				$return = '';

				if ($defaultView == 1)
					$return .= $GLOBALS['defaultViewStartTag'];

				$return .= $attribut_->getTitle();

				if ($defaultView == 1)
					$return .= $GLOBALS['defaultViewEndTag'];

				$attribut_branch_list_title[$attribut->getAttributeDefinitionId()] = $return;
			}

			$GLOBALS["smarty"]->assign("attribut_branch_list_title",$attribut_branch_list_title);
			$GLOBALS["smarty"]->assign("attribut_branch_list",$attribut_branch_list);


			$GLOBALS["smarty"]->display("branch_edit.tpl");
		}
		break;
		//*************************************************************************************************

		// list atributs *************************************************************************************
		case "7":{

			setReturnPoint();

			$attribut_list = new CMS_Catalog_AttributeDefinitionList();
			$attribut_list->addCondition("catalog_id", $_SESSION['currentCatalog']);
			$attribut_list->execute();
			$GLOBALS["smarty"]->assign("attribut_list",$attribut_list);

			$GLOBALS["smarty"]->display("attribut_list.tpl");
		}
		break;
		//************************************************************************************************

		// new atribut ***********************************************************************************
		case "8":{
			$GLOBALS["smarty"]->display("attribut_new.tpl");
		}
		break;
		//*************************************************************************************************

		// edit atribut ************************************************************************************
		case "9":{

			$attribut = new CMS_Catalog_AttributeDefinition($_REQUEST['row_id'][0]);
			$attribut->execute();
			$GLOBALS["smarty"]->assign("detail_attribut",$attribut);
			$GLOBALS["smarty"]->display("attribut_edit.tpl");
		}
		break;
		//*************************************************************************************************

		// list products *************************************************************************************
		case "10":{

			setReturnPoint();

			$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
			$product_list = $catalog->getAllProducts($_GET['start'],$GLOBALS["perpage"],false);
			$product_list -> addCondition("(`id` IN (SELECT `product_id` FROM `catalog_products_lang` WHERE (`catalog_id` = {$_SESSION['currentCatalog']})AND ((`title` like '%{$_GET['s_string']}%') OR (`description` like '%{$_GET['s_string']}%') OR (`description_extended` like '%{$_GET['s_string']}%') )) OR (`code` like '%{$_GET['s_string']}%'))",NULL,NULL,TRUE);
			$product_list -> execute();

			if (($_GET['s_category'] > 0) && ($_GET['s_category'] != 'nofilter')){
				$branch = new CMS_Catalog_Branch($_GET['s_category']);
				$product_list = $branch->getItems(CMS_Catalog_Product::ENTITY_ID, false, $_GET['start'],$GLOBALS["perpage"],false);
				$product_list->setSortBy('order');
				$product_list -> execute();

			}

			if ($_GET['s_category'] == -1){
				//echo "jj";exit;
				$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
				$product_list = $catalog->getFreeProducts($_GET['start'],$GLOBALS["perpage"],false);
				//$product_list -> setTableName('catalog_products,catalog_products_lang');
				//$product_list -> addCondition("`product_id` = `id` AND (`title` like '%{$_GET['s_string']}%') OR (`description` like '%{$_GET['s_string']}%') OR (`description_extended` like '%{$_GET['s_string']}%') OR (`code` like '%{$_GET['s_string']}%')",NULL,NULL,TRUE);
				//$product_list -> addCondition("(`id` IN (SELECT `product_id` FROM `catalog_products_lang` WHERE `product_id` = `id` AND (`title` like '%{$_GET['s_string']}%') OR (`description` like '%{$_GET['s_string']}%') OR (`description_extended` like '%{$_GET['s_string']}%') )) OR (`code` like '%{$_GET['s_string']}%')",NULL,NULL,TRUE);
				if ($_GET['s_string'])
					$product_list -> addCondition("(`id` IN (SELECT `product_id` FROM `catalog_products_lang` WHERE (`title` like '%{$_GET['s_string']}%') OR (`description` like '%{$_GET['s_string']}%') OR (`description_extended` like '%{$_GET['s_string']}%') )) OR (`code` like '%{$_GET['s_string']}%')",NULL,NULL,TRUE);
				$product_list -> execute();
			}

			$GLOBALS["smarty"]->assign("s_string",$_GET['s_string']);

			$GLOBALS["smarty"]->assign("product_list",$product_list);

			$GLOBALS["smarty"]->display("product_list.tpl");
		}
		break;
		//************************************************************************************************

		// new product ***********************************************************************************
		case "11":{
			$GLOBALS["smarty"]->display("product_new.tpl");
		}
		break;
		//*************************************************************************************************

		// edit product ************************************************************************************
		case "12":{
			$mod = CMS_Module::addModule('CMS_Gallery');
			$mod->utilise();

			$gallery_all = new CMS_GalleryList();
			$gallery_all->execute();
			$GLOBALS["smarty"]->assign("gallery_list",$gallery_all);

			// nastavenie zobrazenia uvodneho bloku
			if(!isset($_GET['showtable']))$_GET['showtable'] = 0;
			require_once("cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("Info"), "item1");
			$item1->setTabStyle('cool_style');


			$item2 = new Apycom_TabItem(tr("Atribúty"), "item2");
			$item2->setTabStyle('cool_style');

			$item3 = new Apycom_TabItem(tr("Priradenia"), "item3");
			$item3->setTabStyle('cool_style');

			$item4 = new Apycom_TabItem(tr("Jazykové verzie"), "item4");
			$item4->setTabStyle('cool_style');

			$item5 = new Apycom_TabItem(tr("Galérie"), "item5");
			$item5->setTabStyle('cool_style');

			$item6 = new Apycom_TabItem(tr("Cena"), "item6");
			$item6->setTabStyle('cool_style');

			$item7 = new Apycom_TabItem(tr("Prílohy"), "item7");
			$item7->setTabStyle('cool_style');

			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);
			$t->setBlankImage('/admin/images/blank.gif');
			$t->setItemBeforeImageNormal('/admin/images/tabs/tab01_before_n2.gif');
			$t->setItemBeforeImageHover('/admin/images/tabs/tab01_before_o2.gif');
			$t->setItemBeforeImageSelected('/admin/images/tabs/tab01_before_s.gif');

			$t->setItemAfterImageNormal('/admin/images/tabs/tab01_after_n2.gif');
			$t->setItemAfterImageHover('/admin/images/tabs/tab01_after_o2.gif');
			$t->setItemAfterImageSelected('/admin/images/tabs/tab01_after_s.gif');

			$t->setItemBackgroundImageNormal('/admin/images/tabs/tab01_back_n2.gif');
			$t->setItemBackgroundImageHover('/admin/images/tabs/tab01_back_o2.gif');
			$t->setItemBackgroundImageSelected('/admin/images/tabs/tab01_back_s.gif');

			$t->addTabItem($item1);
			$t->addTabItem($item2);
			$t->addTabItem($item3,2);
			$t->addTabItem($item4);
			$t->addTabItem($item5);
			$t->addTabItem($item6,2);
			$t->addTabItem($item7);

			$t->setSelectedItem($_GET['showtable']);
			$s = $t->render();

			$GLOBALS["smarty"]->assign("menu",$s);

			// zoznam skupin
			$groups = new CMS_GroupList();
			$groups->setTableName('groups,groups_lang');
			$groups->addCondition('`id` = `group_id` AND `language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
			$groups->addCondition("is_published",1);
			$groups->execute();

			$GLOBALS["smarty"]->assign("group_list",$groups);


			$attribut_list = new CMS_Catalog_AttributeDefinitionList();
			$attribut_list->setTableName('`catalog_attributes_definition`,`catalog_attributes_definition_lang`');
			$attribut_list->addCondition('id','attribute_definition_id');
			$attribut_list->addCondition("catalog_id", $_SESSION['currentCatalog']);
			$attribut_list->addCondition("language","'{$GLOBALS['localLanguage']}'");
			$attribut_list->setSortBy("title");
			$attribut_list->execute();
			$GLOBALS["smarty"]->assign("attribut_list",$attribut_list);

			require_once ('scripts/calendar.php');
			$GLOBALS["calendar"] = new DHTML_Calendar('scripts/calendar/', 'sk-utf8', 'calendar-win2k-2', false);
			$GLOBALS["calendar"]->load_files();

			$product = new CMS_Catalog_Product($_REQUEST['row_id'][0]);
			$product->execute();

			$GLOBALS["smarty"]->assign("detail_product",$product);

			// nacitanie listu kategorii kde je namapovany produkt
			$category_list_items = $product->getParents();
			$GLOBALS["smarty"]->assign("category_list_items",$category_list_items);
			//echo"<pre>";var_dump($category_list_items);exit;

			//zoznam cien
			$price_list = $product->getPriceList();
			$GLOBALS["smarty"]->assign("price_list",$price_list);

			$attribut_product_list = $product->getAttributes(null,null,false);
			$attribut_product_list->setSortBy('order');
			$attribut_product_list->execute();

			foreach ($attribut_product_list as $attribut){

				$attribut_ = new CMS_Catalog_AttributeDefinition($attribut->getAttributeDefinitionId());

				$attribut_->setContextLanguage($GLOBALS['localLanguage']);
				$defaultView = 0;
				if ($attribut_->getTitle() == ''){
					$attribut_->setContextLanguage($GLOBALS['localLanguageDefault']);
					$defaultView = 1;
				}
				$return = '';

				if ($defaultView == 1)
					$return .= $GLOBALS['defaultViewStartTag'];

				$return .= $attribut_->getTitle();

				if ($defaultView == 1)
					$return .= $GLOBALS['defaultViewEndTag'];

				$attribut_product_list_title[$attribut->getAttributeDefinitionId()] = $return;
			}

			$GLOBALS["smarty"]->assign("attribut_product_list_title",$attribut_product_list_title);
			$GLOBALS["smarty"]->assign("attribut_product_list",$attribut_product_list);

			$gallery_list_product = $product->getGalleries();
			$gallery_list_product->removeCondition('usable_by');
			$gallery_list_product->execute();

			$GLOBALS["smarty"]->assign("gallery_list_product",$gallery_list_product);

			$GLOBALS["smarty"]->display("product_edit.tpl");
		}
		break;
		//*************************************************************************************************


	// map one atribut to more product ***********************************************************************************
		case "13":{
			setReturnPoint(1);

			$attribut = new CMS_Catalog_AttributeDefinition($_REQUEST['row_id'][0]);
			$attribut->execute();
			$GLOBALS["smarty"]->assign("detail_attribut",$attribut);

			$product_list = new CMS_Catalog_ProductList();
			$product_list->addCondition("catalog_id", $_SESSION['currentCatalog']);
			$product_list->execute();

			if (($_GET['filter_branch']) && ($_GET['filter_branch'] != 'nofilter')){
				$branch = new CMS_Catalog_Branch($_GET['filter_branch']);
				$product_list = $branch->getItems(CMS_Catalog_Product::ENTITY_ID, false, $_GET['start'],$GLOBALS["perpage"]);
			}
			$GLOBALS["smarty"]->assign("product_list",$product_list);

			$GLOBALS["smarty"]->display("map_atribut_product.tpl");
		}
		break;
		//*************************************************************************************************


		// unmap one atribut to more product ***********************************************************************************
		case "14":{
			setReturnPoint(1);

			$attribut = new CMS_Catalog_AttributeDefinition($_REQUEST['row_id'][0]);
			$GLOBALS["smarty"]->assign("detail_attribut",$attribut);

			$product_list = $attribut->getProducts();

			$GLOBALS["smarty"]->assign("product_list",$product_list);

			$GLOBALS["smarty"]->display("unmap_atribut_product.tpl");
		}
		break;
		//*************************************************************************************************


		// map one product to more attribut ***********************************************************************************
		case "15":{
			setReturnPoint(1);

			$product = new CMS_Catalog_Product($_REQUEST['row_id'][0]);
			$product->execute();
			$GLOBALS["smarty"]->assign("detail_product",$product);

			$attribut_list = new CMS_Catalog_AttributeDefinitionList();
			$attribut_list->addCondition("catalog_id", $_SESSION['currentCatalog']);
			$attribut_list->execute();

			$GLOBALS["smarty"]->assign("attribut_list",$attribut_list);

			$GLOBALS["smarty"]->display("map_product_atribut.tpl");
		}
		break;
		//*************************************************************************************************


		// unmap one product to more attribut ***********************************************************************************
		case "16":{
			setReturnPoint(1);

			$product = new CMS_Catalog_Product($_REQUEST['row_id'][0]);
			$product->execute();
			$GLOBALS["smarty"]->assign("detail_product",$product);

			$attribut_list = $product->getAttributes();

			foreach ($attribut_list as $attribut){

				$attribut_ = new CMS_Catalog_AttributeDefinition($attribut->getAttributeDefinitionId());

				$attribut_->setContextLanguage($GLOBALS['localLanguage']);
				$defaultView = 0;
				if ($attribut_->getTitle() == ''){
					$attribut_->setContextLanguage($GLOBALS['localLanguageDefault']);
					$defaultView = 1;
				}
				$return = '';

				if ($defaultView == 1)
					$return .= $GLOBALS['defaultViewStartTag'];

				$return .= $attribut_->getTitle();

				if ($defaultView == 1)
					$return .= $GLOBALS['defaultViewEndTag'];

				$attribut_product_list_title[$attribut->getAttributeDefinitionId()] = $return;
			}

			$GLOBALS["smarty"]->assign("attribut_product_list_title",$attribut_product_list_title);


			$GLOBALS["smarty"]->assign("attribut_list",$attribut_list);

			$GLOBALS["smarty"]->display("unmap_product_atribut.tpl");
		}
		break;
		//*************************************************************************************************


		// setup list pre products *************************************************************************************
		case "17":{
			setReturnPoint(1);

			if($_GET['setup_type'])
				$GLOBALS["smarty"]->assign("setup_type",$_GET['setup_type']);
			else
				exit;

			$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
			$product_list = $catalog->getAllProducts($_GET['start'],$GLOBALS["perpage"],false);
			if(isset($_GET['s_string']) )
				$product_list -> addCondition("( `id` IN (SELECT `product_id` FROM `catalog_products_lang` WHERE (`title` like '%{$_GET['s_string']}%') OR (`description` like '%{$_GET['s_string']}%') OR (`description_extended` like '%{$_GET['s_string']}%') ) OR (`code` like '%{$_GET['s_string']}%') )",NULL,NULL,TRUE);

			$product_list -> execute();

			if ($_GET['s_category'] > 0){
				$branch = new CMS_Catalog_Branch($_GET['s_category']);
				$product_list = $branch->getItems(CMS_Catalog_Product::ENTITY_ID, false, $_GET['start'],$GLOBALS["perpage"]);
			}

			if ($_GET['s_category'] == -1){
				$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
				$product_list = $catalog->getFreeProducts($_GET['start'],$GLOBALS["perpage"],false);
				$product_list -> addCondition("(`id` IN (SELECT `product_id` FROM `catalog_products_lang` WHERE (`title` like '%{$_GET['s_string']}%') OR (`description` like '%{$_GET['s_string']}%') OR (`description_extended` like '%{$_GET['s_string']}%') ) OR (`code` like '%{$_GET['s_string']}%') )",NULL,NULL,TRUE);
				$product_list -> execute();
			}

			require_once ('scripts/calendar.php');
			$GLOBALS["calendar"] = new DHTML_Calendar('/admin/scripts/calendar/', 'sk-utf8', 'calendar-win2k-2', false);
			$GLOBALS["calendar"]->load_files();

			$GLOBALS["smarty"]->assign("product_list",$product_list);
			if(isset($_GET['currency']))
				$GLOBALS["smarty"]->assign("price_currency",$_GET['currency']);

			if($_GET['setup_type'] == "price")
			{
				// zoznam skupin
				$groups = new CMS_GroupList();
				$groups->setTableName('groups,groups_lang');
				$groups->addCondition('`id` = `group_id` AND `language` = \''.$GLOBALS['localLanguage'].'\'',null,null,true);
				$groups->addCondition("is_published",1);
				$groups->execute();
				$GLOBALS["smarty"]->assign("group_list",$groups);

				if(isset($_GET['group']) && strlen($_GET['group']) > 0)
					$GLOBALS["smarty"]->assign("selected_group",$_GET['group']);
			}
			$GLOBALS["smarty"]->display("product_list_setup.tpl");
		}
		break;
		//************************************************************************************************

		// tree branch *************************************************************************************
		case "18":{

			setReturnPoint();

			$zdroj['catalog'] = $_SESSION['currentCatalog'];

			$zdroj['start'] = $_GET['start'] ? $_GET['start'] : 0;

			if ($_GET['s_category']){
				$zdroj['adr'] = $_GET['s_category'];
				$zdroj['catalog'] = null;
			}
			if(is_null($GLOBALS["perpage"]))
				 $GLOBALS["perpage"] = 20;

			$validRangeFrom = $zdroj['start'];
			$validRangeTo = $zdroj['start']+$GLOBALS["perpage"];
			$zdroj['valid_range_from'] = $validRangeFrom;
			$zdroj['valid_range_to'] = $validRangeTo;
			$countRowsAll = 0;
			$countRows = 0;

			$branch_list = getBranchListCascade($zdroj,$countRows,$countRowsAll);

			$GLOBALS["countAllRows"] = $countRowsAll;
			$GLOBALS["countRows"] = count($branch_list);

			$GLOBALS["smarty"]->assign("branch_list",$branch_list);

			$GLOBALS["smarty"]->display("branch_tree.tpl");
		}
		break;
		//************************************************************************************************


		// language list branch *************************************************************************************
		case "19":{
			setReturnPoint(1);
			$zdroj['start'] = $_GET['start'] ? $_GET['start'] : 0;

			$zdroj['catalog'] = $_SESSION['currentCatalog'];

			$validRangeFrom = $zdroj['start'];
			$validRangeTo = $zdroj['start']+99999;

			$zdroj['valid_range_from'] = $validRangeFrom;
			$zdroj['valid_range_to'] = $validRangeTo;

			if ($_GET['s_category']){
				$zdroj['adr'] = $_GET['s_category'];
				$zdroj['catalog'] = null;
			}
			$countRowsAll = 0;
			$countRows = 0;

			$b = getBranchListCascade($zdroj,$countRows,$countRowsAll);
			$GLOBALS["smarty"]->assign("branch_list",$b);

			$GLOBALS["smarty"]->display("branch_list_language.tpl");
		}
		break;
		//************************************************************************************************


		// map one branch to more product ***********************************************************************************
		case "20":{
			setReturnPoint(1);
			$branch = new CMS_Catalog_branch($_REQUEST['row_id'][0]);
			$branch->execute();
			$GLOBALS["smarty"]->assign("detail_branch",$branch);

			$product_list = new CMS_Catalog_ProductList();
			$product_list->execute();
			if ($_GET['filter_branch'] == 'nofilter'){
				$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
				$product_list = $catalog->getAllProducts($_GET['start'],$GLOBALS["perpage"],false);
				$product_entity_id = CMS_Catalog_Product::ENTITY_ID;
				$product_list -> addCondition("`id` NOT IN (SELECT `item_id` FROM `categories_bindings` WHERE `category_id` = {$_REQUEST['row_id'][0]} AND `item_type` = $product_entity_id)",NULL,NULL,TRUE);
				$product_list->execute();
			}
			if (($_GET['filter_branch'] > 0) && ($_GET['filter_branch'] != 'nofilter')) {

				$branch = new CMS_Catalog_Branch($_GET['filter_branch']);
				//exit;
				$product_list = $branch->getItems(CMS_Catalog_Product::ENTITY_ID, false, $_GET['start'],$GLOBALS["perpage"],false);
				$product_entity_id = CMS_Catalog_Product::ENTITY_ID;
				//$product_list -> addCondition("`id` NOT IN (SELECT `item_id` FROM `categories_bindings` WHERE `category_id` = {$_REQUEST['row_id'][0]} AND `item_type` = $product_entity_id)",NULL,NULL,TRUE);
				$product_list->execute();

			}

			if ($_GET['filter_branch'] == -1){
				$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
				$product_list = $catalog->getFreeProducts($_GET['start'],$GLOBALS["perpage"]);
			}

			$GLOBALS["smarty"]->assign("product_list",$product_list);

			$GLOBALS["smarty"]->display("map_branch_products.tpl");
		}
		break;
		//*************************************************************************************************




		// unmap one branch to more product ***********************************************************************************
		case "21":{
			setReturnPoint(1);
			$branch = new CMS_Catalog_branch($_REQUEST['row_id'][0]);
			$branch->execute();
			$GLOBALS["smarty"]->assign("detail_branch",$branch);

			$branch = new CMS_Catalog_Branch($_REQUEST['row_id'][0]);
			$product_list = $branch->getItems(CMS_Catalog_Product::ENTITY_ID, false, $_GET['start'],$GLOBALS["perpage"],true);

			$GLOBALS["smarty"]->assign("product_list",$product_list);

			$GLOBALS["smarty"]->display("unmap_branch_product.tpl");
		}
		break;
		//*************************************************************************************************

		// list all in selected catalog *************************************************************************************
		case "22":{

			setReturnPoint();

			$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
			$catalog->execute();
			$GLOBALS["smarty"]->assign("detail_catalog",$catalog);

			$zdroj['start'] = $_GET['start'] ? $_GET['start'] : 0;

			$zdroj['catalog'] = $_SESSION['currentCatalog'];

			$validRangeFrom = $zdroj['start'];
			$validRangeTo = $zdroj['start']+99999;

			$zdroj['valid_range_from'] = $validRangeFrom;
			$zdroj['valid_range_to'] = $validRangeTo;

			$countRowsAll = 0;
			$countRows = 0;

			$st = microtime(true);
			$GLOBALS["smarty"]->assign("branch_list",getBranchListCascade($zdroj,$countRows,$countRowsAll));
			echo round(microtime(true) - $st, 4);
			$GLOBALS["smarty"]->display("catalog_all_list.tpl");
		}
		break;
		//************************************************************************************************

		// list group of atributes *************************************************************************************
		case "23":{

			setReturnPoint();

			$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
			$attribute_group_list = $catalog->getItems(CMS_Catalog_AttributeGroup::ENTITY_ID);

			$GLOBALS["smarty"]->assign("attribute_group_list",$attribute_group_list);

			$GLOBALS["smarty"]->display("attribute_group_list.tpl");
		}
		break;
		//************************************************************************************************

		// new group of atributes ***********************************************************************************
		case "24":{
			$GLOBALS["smarty"]->display("attribute_group_new.tpl");
		}
		break;
		//*************************************************************************************************

		// edit group of atributes ************************************************************************************
		case "25":{
			setReturnPoint();
			if(!isset($_GET['showtable']))$_GET['showtable'] = 0;
			require_once("cms_classes/apycom_tabs.php");

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("Atribúty"), "item1");
			$item1->setTabStyle('cool_style');


			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);

			$t->setBlankImage('/admin/images/blank.gif');

			$t->setItemBeforeImageNormal('/admin/images/tabs/tab01_before_n2.gif');
			$t->setItemBeforeImageHover('/admin/images/tabs/tab01_before_o2.gif');
			$t->setItemBeforeImageSelected('/admin/images/tabs/tab01_before_s.gif');

			$t->setItemAfterImageNormal('/admin/images/tabs/tab01_after_n2.gif');
			$t->setItemAfterImageHover('/admin/images/tabs/tab01_after_o2.gif');
			$t->setItemAfterImageSelected('/admin/images/tabs/tab01_after_s.gif');

			$t->setItemBackgroundImageNormal('/admin/images/tabs/tab01_back_n2.gif');
			$t->setItemBackgroundImageHover('/admin/images/tabs/tab01_back_o2.gif');
			$t->setItemBackgroundImageSelected('/admin/images/tabs/tab01_back_s.gif');

			$t->addTabItem($item1);

			$t->setSelectedItem($_GET['showtable']);

			$GLOBALS["smarty"]->assign("menu2",$t->render());

			if(!isset($_GET['showtable']))$_GET['showtable'] = 1;
			$GLOBALS["smarty"]->assign("showtable",$_GET['showtable']);

			# all attributes
			$attribut_list = new CMS_Catalog_AttributeDefinitionList();
			$attribut_list->setTableName('`catalog_attributes_definition`,`catalog_attributes_definition_lang`');
			$attribut_list->addCondition('id','attribute_definition_id');
			$attribut_list->addCondition("catalog_id", $_SESSION['currentCatalog']);
			$attribut_list->addCondition("language","'{$GLOBALS['localLanguage']}'");
			$attribut_list->setSortBy("title");
			$attribut_list->execute();
			$GLOBALS["smarty"]->assign("attribut_list",$attribut_list);

			$attribut = new CMS_Catalog_AttributeGroup($_REQUEST['row_id'][0]);
			$attribut->execute();
			$GLOBALS["smarty"]->assign("detail_attribut",$attribut);


			# attributes for current branch
			$attribut_branch_list = $attribut->getAttributes();

			foreach ($attribut_branch_list as $attribut){

				$attribut_ = new CMS_Catalog_AttributeDefinition($attribut->getAttributeDefinitionId());

				$attribut_->setContextLanguage($GLOBALS['localLanguage']);
				$defaultView = 0;
				if ($attribut_->getTitle() == ''){
					$attribut_->setContextLanguage($GLOBALS['localLanguageDefault']);
					$defaultView = 1;
				}
				$return = '';

				if ($defaultView == 1)
					$return .= $GLOBALS['defaultViewStartTag'];

				$return .= $attribut_->getTitle();

				if ($defaultView == 1)
					$return .= $GLOBALS['defaultViewEndTag'];

				$attribut_branch_list_title[$attribut->getAttributeDefinitionId()] = $return;
			}

			$GLOBALS["smarty"]->assign("attribut_branch_list_title",$attribut_branch_list_title);
			$GLOBALS["smarty"]->assign("attribut_branch_list",$attribut_branch_list);


			$GLOBALS["smarty"]->display("attribute_group_edit.tpl");
		}
		break;

		//*************************************************************************************************
		//sortovanie poloziek  catalog->branches *********************************************************************************
		case "26":{
			if(isset($_SESSION['currentCatalog']))
			{
				$catalog = new CMS_Catalog($_SESSION['currentCatalog']);

				$GLOBALS["smarty"]->assign("parent_id",$_SESSION['currentCatalog']);
				$GLOBALS["smarty"]->assign("entity_type",CMS_Catalog::ENTITY_ID);

				$sort_table = new CMS_SortTable();
				$items = $catalog->getChildren(null,null,false);
				$items->setSortBy('order');
				$items->execute();
				foreach ( $items as $item )
				{
						$sort_item = new CMS_SortTable_Item();
						$sort_item->data	= $item;
						$item->setContextLanguage($GLOBALS['localLanguage']);
						$sort_item->column_1 = $item->getTitle();
						//$sort_item->column_2 = $item->getLanguageIsVisible();
						//$sort_item->column_3 = $item->getId();
						$sort_table->addItem($sort_item);
				}

				$assigns = array
				(
					'section_title' => tr('Katalóg \''.$catalog->getTitle().'\' / Zmena poradia kategórií'),
					'sort_table_items' => $sort_table->getItems()
				);

				$GLOBALS["smarty"]->assign($assigns);
				//var_dump($assigns);
				$GLOBALS["smarty"]->display("Proxia:default.sort_table_catalog_branch");
			}
		}
		break;

		//*************************************************************************************************
		//sortovanie poloziek  branch->branches *********************************************************************************
		case "27":{
			if(isset($_REQUEST['row_id'][0]))
			{
				$branch = new CMS_Catalog_Branch($_REQUEST['row_id'][0]);

				$GLOBALS["smarty"]->assign("parent_id",$_REQUEST['row_id'][0]);
				$GLOBALS["smarty"]->assign("entity_type",CMS_Catalog_Branch::ENTITY_ID);

				$sort_table = new CMS_SortTable();
				$items = $branch->getItems(CMS_Catalog_Branch::ENTITY_ID,true,null,null,false);
				$items->setSortBy('order');
				$items->execute();
				foreach ( $items as $item )
				{
						$sort_item = new CMS_SortTable_Item();
						$sort_item->data	= $item;
						$item->setContextLanguage($GLOBALS['localLanguage']);
						$sort_item->column_1 = $item->getTitle();
						//$sort_item->column_2 = $item->getLanguageIsVisible();
						//$sort_item->column_3 = $item->getId();
						$sort_table->addItem($sort_item);
				}

				$assigns = array
				(
					'section_title' => tr('Kategória \''.$branch->getTitle().'\' / Zmena poradia kategórií'),
					'sort_table_items' => $sort_table->getItems()
				);

				$GLOBALS["smarty"]->assign($assigns);
				//var_dump($assigns);
				$GLOBALS["smarty"]->display("Proxia:default.sort_table_catalog_branches_to_branch.tpl");
			}
		}
		break;

		//*************************************************************************************************
		//sortovanie poloziek  branch->products *********************************************************************************
		case "28":{
			if(isset($_REQUEST['row_id'][0]))
			{
				$branch = new CMS_Catalog_Branch($_REQUEST['row_id'][0]);

				$GLOBALS["smarty"]->assign("parent_id",$_REQUEST['row_id'][0]);
				$GLOBALS["smarty"]->assign("entity_type",CMS_Catalog_Branch::ENTITY_ID);

				$sort_table = new CMS_SortTable();
				$branch->setContextLanguage($GLOBALS['localLanguage']);

				$items = $branch->getItems(CMS_Catalog_Product::ENTITY_ID,true,null,null,false);
				$items->setSortBy('order');
				$items->execute();
				foreach ( $items as $item )
				{
						$sort_item = new CMS_SortTable_Item();
						$sort_item->data	= $item;
						$item->setContextLanguage($GLOBALS['localLanguage']);
						$sort_item->column_1 = $item->getCode()." : ".$item->getTitle();
						//$sort_item->column_2 = $item->getLanguageIsVisible();
						//$sort_item->column_3 = $item->getId();
						$sort_table->addItem($sort_item);
				}

				$assigns = array
				(
					'section_title' => tr('Kategória \''.$branch->getTitle().'\' / Zmena poradia produktov'),
					'sort_table_items' => $sort_table->getItems()
				);

				$GLOBALS["smarty"]->assign($assigns);
				//var_dump($assigns);
				$GLOBALS["smarty"]->display("Proxia:default.sort_table_catalog_products_to_branch.tpl");
			}
		}
		break;
		// import stock 1 *********************************************************************************
		case "29":{

			if ( (isset($_GET['unlink_file']))  && (file_exists($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_stock_'.$_GET['unlink_file'].'.txt')) )
				unlink($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_stock_'.$_GET['unlink_file'].'.txt');

			$GLOBALS["smarty"]->display("import_stock_1.tpl");

		}
		break;
		//*************************************************************************************************

		// import stock 2 *********************************************************************************
		case "30":{

			if(isset($_GET['time_mark']))
			{
				$handle = fopen("/vendor/cms_modules/cms_catalog/".$GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_stock_'.$_GET['time_mark'].'.txt', 'r');
				$array_delimiter = array('\t',';',',','§');

				$num_row = 0;
				$import = array();

				while(($data = fgetcsv($handle, 1000, $array_delimiter[$_GET['delimiter']])) !== false)
				{

					$num_row++;
					$keyWords = array();

					if(is_array($data))
					{
						foreach ($data as $num_item => $value)
						{

							$value = str_replace("\"", "&quote;", $value);
							$value = str_replace("'", "&appos;", $value);
							//$value = str_replace(",", "&comma;", $value);

							$value = trim($value);

							if ($num_item == 0) {
								$import[$num_row][1] = $value;
							}

							if ($num_item == 1) {
								$import[$num_row][2] = $value;
							}

						}
					}

				}


				fclose($handle);


				$GLOBALS['time_mark'] = $_GET['time_mark'];

				$GLOBALS["smarty"]->assign("import",$import);
				$GLOBALS["smarty"]->assign("delimiter",$_GET['delimiter']);
				$GLOBALS["smarty"]->assign("time_mark",$_GET['time_mark']);

				$GLOBALS["smarty"]->display("import_stock_2.tpl");

			} else {
			  $GLOBALS["smarty"]->display("import_stock_1.tpl");
			}

		}
		break;

		// import PNEUDT 1 *********************************************************************************
		case "101":{

			if ( (isset($_GET['unlink_file']))  && (file_exists($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['unlink_file'].'.txt')) )
				unlink($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['unlink_file'].'.txt');

			$GLOBALS["smarty"]->display("import_products_PNEUDT_1.tpl");

		}
		break;
		//*************************************************************************************************

		// import PNEUDT 2 *********************************************************************************
		case "102":{

			if(isset($_GET['time_mark']))
			{
				$handle = fopen("/vendor/cms_modules/cms_catalog/".$GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['time_mark'].'.txt', 'r');
				$array_delimiter = array('\t',';',',','§');

				$num_row = 0;
				$import = array();

				while(($data = fgetcsv($handle, 1000, $array_delimiter[$_GET['delimiter']])) !== false)
				{

					$num_row++;
					$keyWords = array();

					if(is_array($data))
					{
						foreach ($data as $num_item => $value)
						{

							$value = str_replace("\"", "&quote;", $value);
							$value = str_replace("'", "&appos;", $value);
							//$value = str_replace(",", "&comma;", $value);

							$value = trim($value);
							$import[$num_row][$num_item] = $value;
// 							if ($num_item == 0) {
// 								$import[$num_row][1] = $value;
// 							}
//
// 							if ($num_item == 1) {
// 								$import[$num_row][2] = $value;
// 							}

						}
					}

				}

				fclose($handle);

				$GLOBALS['time_mark'] = $_GET['time_mark'];

				$GLOBALS["smarty"]->assign("import",$import);
				$GLOBALS["smarty"]->assign("delimiter",$_GET['delimiter']);
				$GLOBALS["smarty"]->assign("time_mark",$_GET['time_mark']);

				$GLOBALS["smarty"]->display("import_products_PNEUDT_2.tpl");

			} else {
			  $GLOBALS["smarty"]->display("import_products_PNEUDT_1.tpl");
			}

		}
		break;

		// import PPRESS 1 *********************************************************************************
		case "103":{

			if ( (isset($_GET['unlink_file']))  && (file_exists($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['unlink_file'].'.txt')) )
				unlink($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['unlink_file'].'.txt');

			$GLOBALS["smarty"]->display("import_products_PPRESS_1.tpl");

		}
		break;
		//*************************************************************************************************

		// import PPRESS 2 *********************************************************************************
		case "104":{

			if(isset($_GET['time_mark']))
			{
				$handle = fopen("/vendor/cms_modules/cms_catalog/".$GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['time_mark'].'.txt', 'r');
				$array_delimiter = array('\t',';',',','§');

				$num_row = 0;
				$import = array();

				while(($data = fgetcsv($handle, 1000, $array_delimiter[$_GET['delimiter']])) !== false)
				{

					$num_row++;
					$keyWords = array();

					if(is_array($data))
					{
						foreach ($data as $num_item => $value)
						{

							$value = str_replace("\"", "&quote;", $value);
							$value = str_replace("'", "&appos;", $value);
							//$value = str_replace(",", "&comma;", $value);

							$value = trim($value);
							$import[$num_row][$num_item] = $value;
// 							if ($num_item == 0) {
// 								$import[$num_row][1] = $value;
// 							}
//
// 							if ($num_item == 1) {
// 								$import[$num_row][2] = $value;
// 							}

						}
					}

				}

				fclose($handle);

				$GLOBALS['time_mark'] = $_GET['time_mark'];

				$GLOBALS["smarty"]->assign("import",$import);
				$GLOBALS["smarty"]->assign("delimiter",$_GET['delimiter']);
				$GLOBALS["smarty"]->assign("time_mark",$_GET['time_mark']);

				$GLOBALS["smarty"]->display("import_products_PPRESS_2.tpl");

			} else {
			  $GLOBALS["smarty"]->display("import_products_PPRESS_1.tpl");
			}

		}
		break;

		// import AMI 1 *********************************************************************************
		case "105":{

			if ( (isset($_GET['unlink_file']))  && (file_exists($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['unlink_file'].'.txt')) )
				unlink($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['unlink_file'].'.txt');

			$GLOBALS["smarty"]->display("import_products_AMI_1.tpl");

		}
		break;
		//*************************************************************************************************

		// import AMI 2 *********************************************************************************
		case "106":{

			if(isset($_GET['time_mark']))
			{
				$handle = fopen("/vendor/cms_modules/cms_catalog/".$GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['time_mark'].'.txt', 'r');
				$array_delimiter = array('\t',';',',','§');

				$num_row = 0;
				$valid_num_row = 0;
				$import = array();

				// igonorvacie riadky a stlpce...
				$ignore_rows = 0;
				$ignore_cols = array(0,1,2,10,11,12,14,15,16,17,22,23);//24a  25 navyse...
				$max_preview_rows = 150;
				while(($data = fgetcsv($handle, 1000, $array_delimiter[$_GET['delimiter']])) !== false)
				{
					$num_row++;
					$keyWords = array();

 					if($num_row <= $ignore_rows || ($valid_num_row+1) > $max_preview_rows) // ignorovat riadky
 						continue;

					$valid_num_row++;

					if(is_array($data))
					{

						$valid_num_item = 0;

						foreach ($data as $num_item => $value)
						{

							if(in_array($num_item,$ignore_cols)) // ignorovat stlpce
								continue;

							$value = str_replace("\"", "&quote;", $value);
							$value = str_replace("'", "&appos;", $value);
							//$value = str_replace(",", "&comma;", $value);

							$value = trim($value);
							$import[$valid_num_row][$valid_num_item] = $value;
// 							if ($num_item == 0) {
// 								$import[$num_row][1] = $value;
// 							}
//
// 							if ($num_item == 1) {
// 								$import[$num_row][2] = $value;
// 							}
							$valid_num_item++;
						}
					}

				}

				fclose($handle);

				$GLOBALS['time_mark'] = $_GET['time_mark'];

				$GLOBALS["smarty"]->assign("import",$import);
				$GLOBALS["smarty"]->assign("delimiter",$_GET['delimiter']);
				$GLOBALS["smarty"]->assign("time_mark",$_GET['time_mark']);

				$GLOBALS["smarty"]->display("import_products_AMI_2.tpl");

			} else {
			  $GLOBALS["smarty"]->display("import_products_AMI_1.tpl");
			}

		}
		break;


		// import PNEUDT DUSE 1 *********************************************************************************
		case "107":{

			if ( (isset($_GET['unlink_file']))  && (file_exists($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['unlink_file'].'.txt')) )
				unlink($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['unlink_file'].'.txt');

			$GLOBALS["smarty"]->display("import_products_PNEUDT_duse_1.tpl");

		}
		break;
		//*************************************************************************************************

		// import PNEUDT DUSE 2 *********************************************************************************
		case "108":{

			if(isset($_GET['time_mark']))
			{
				$handle = fopen("/vendor/cms_modules/cms_catalog/".$GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['time_mark'].'.txt', 'r');
				$array_delimiter = array('\t',';',',','§');

				$num_row = 0;
				$import = array();

				while(($data = fgetcsv($handle, 1000, $array_delimiter[$_GET['delimiter']])) !== false)
				{

					$num_row++;
					$keyWords = array();

					if(is_array($data))
					{
						foreach ($data as $num_item => $value)
						{

							$value = str_replace("\"", "&quote;", $value);
							$value = str_replace("'", "&appos;", $value);
							//$value = str_replace(",", "&comma;", $value);

							$value = trim($value);
							$import[$num_row][$num_item] = $value;

						}
					}

				}

				fclose($handle);

				$GLOBALS['time_mark'] = $_GET['time_mark'];

				$GLOBALS["smarty"]->assign("import",$import);
				$GLOBALS["smarty"]->assign("delimiter",$_GET['delimiter']);
				$GLOBALS["smarty"]->assign("time_mark",$_GET['time_mark']);

				$GLOBALS["smarty"]->display("import_products_PNEUDT_duse_2.tpl");

			} else {
			  $GLOBALS["smarty"]->display("import_products_PNEUDT_duse_1.tpl");
			}

		}
		break;

		// import PNEUDT DISKY 1 *********************************************************************************
		case "109":{

			if ( (isset($_GET['unlink_file']))  && (file_exists($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['unlink_file'].'.txt')) )
				unlink($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['unlink_file'].'.txt');

			$GLOBALS["smarty"]->display("import_products_PNEUDT_disky_1.tpl");

		}
		break;
		//*************************************************************************************************

		// import PNEUDT DISKY 2 *********************************************************************************
		case "110":{

			if(isset($_GET['time_mark']))
			{
				$handle = fopen("/vendor/cms_modules/cms_catalog/".$GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['time_mark'].'.txt', 'r');
				$array_delimiter = array('\t',';',',','§');

				$num_row = 0;
				$import = array();

				while(($data = fgetcsv($handle, 1000, $array_delimiter[$_GET['delimiter']])) !== false)
				{

					$num_row++;
					$keyWords = array();

					if(is_array($data))
					{
						foreach ($data as $num_item => $value)
						{

							$value = str_replace("\"", "&quote;", $value);
							$value = str_replace("'", "&appos;", $value);
							//$value = str_replace(",", "&comma;", $value);

							$value = trim($value);
							$import[$num_row][$num_item] = $value;

						}
					}

				}

				fclose($handle);

				$GLOBALS['time_mark'] = $_GET['time_mark'];

				$GLOBALS["smarty"]->assign("import",$import);
				$GLOBALS["smarty"]->assign("delimiter",$_GET['delimiter']);
				$GLOBALS["smarty"]->assign("time_mark",$_GET['time_mark']);

				$GLOBALS["smarty"]->display("import_products_PNEUDT_disky_2.tpl");

			} else {
			  $GLOBALS["smarty"]->display("import_products_PNEUDT_disky_1.tpl");
			}

		}
		break;
		//*************************************************************************************************
		
		// import REWAN 1 *********************************************************************************
		case "111":
		{

			if ( (isset($_GET['unlink_file']))  && (file_exists($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['unlink_file'].'.txt')) )
				unlink($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['unlink_file'].'.txt');

			$GLOBALS["smarty"]->display("import_products_REWAN_1.tpl");

		}
		break;
		//*************************************************************************************************

		// import REWAN 2 *********************************************************************************
		case "112":
		{

			if(isset($_GET['time_mark']))
			{
				$handle = fopen("/vendor/cms_modules/cms_catalog/".$GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_GET['time_mark'].'.txt', 'r');
				$array_delimiter = array('\t',';',',','§');

				$num_row = 0;
				$import = array();

				while(($data = fgetcsv($handle, 1000, $array_delimiter[$_GET['delimiter']])) !== false)
				{

					$num_row++;
					$keyWords = array();

					if(is_array($data))
					{
						foreach ($data as $num_item => $value)
						{

							$value = str_replace("\"", "&quote;", $value);
							$value = str_replace("'", "&appos;", $value);
							//$value = str_replace(",", "&comma;", $value);

							$value = trim($value);
							$import[$num_row][$num_item] = $value;
// 							if ($num_item == 0) {
// 								$import[$num_row][1] = $value;
// 							}
//
// 							if ($num_item == 1) {
// 								$import[$num_row][2] = $value;
// 							}

						}
					}

				}

				fclose($handle);

				$GLOBALS['time_mark'] = $_GET['time_mark'];

				$GLOBALS["smarty"]->assign("import",$import);
				$GLOBALS["smarty"]->assign("delimiter",$_GET['delimiter']);
				$GLOBALS["smarty"]->assign("time_mark",$_GET['time_mark']);

				$GLOBALS["smarty"]->display("import_products_REWAN_2.tpl");

			} else {
			  $GLOBALS["smarty"]->display("import_products_REWAN_1.tpl");
			}

		}
		break;		
	}
}
catch(CN_Exception $e){
	echo $e->displayDetails();
}
?>
