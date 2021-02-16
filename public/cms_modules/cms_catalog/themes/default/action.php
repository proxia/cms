<?php
//var_dump($_POST);EXIT;

if(!isset($_POST['go']))$_POST['go'] = false;
if(!isset($_POST['delete']))$_POST['delete'] = false;
if(!isset($_POST['add_attribut_id']))$_POST['add_attribut_id'] = false;
if(!isset($_POST['remove_attribut_id']))$_POST['remove_attribut_id'] = false;
if(!isset($_POST['update_attribut']))$_POST['update_attribut'] = false;
if(!isset($_POST['filter_branch']))$_POST['filter_branch'] = false;
if(!isset($_POST['map_to_branch']))$_POST['map_to_branch'] = false;
if(!isset($_POST['unmap_to_branch']))$_POST['unmap_to_branch'] = false;
if(!isset($_POST['language_visibility']))$_POST['language_visibility'] = false;
if(!isset($_POST['unmap_gallery']))$_POST['unmap_gallery'] = false;
if(!isset($_POST['map_gallery']))$_POST['map_gallery'] = false;
if(!isset($_POST['add_menu_id']))$_POST['add_menu_id'] = false;
if(!isset($_POST['add_category_id']))$_POST['add_category_id'] = false;
if(!isset($_POST['remove_menu_id']))$_POST['remove_menu_id'] = false;
if(!isset($_POST['remove_category_id']))$_POST['remove_category_id'] = false;
if(!isset($_POST['act']))$_POST['act'] = false;
if(!isset($_POST['price']))$_POST['price'] = false;
if(!isset($_POST['move_down_in_category']))$_POST['move_down_in_category'] = false;
if(!isset($_POST['move_up_in_category']))$_POST['move_up_in_category'] = false;
if(!isset($_POST['move_down_attribut']))$_POST['move_down_attribut'] = false;
if(!isset($_POST['move_up_attribut']))$_POST['move_up_attribut'] = false;
if(!isset($_POST['move_bottom_in_category']))$_POST['move_bottom_in_category'] = false;
if(!isset($_POST['move_top_in_category']))$_POST['move_top_in_category'] = false;
if(!isset($_POST['move_bottom_attribut']))$_POST['move_bottom_attribut'] = false;
if(!isset($_POST['move_top_attribut']))$_POST['move_top_attribut'] = false;
if(!isset($_POST['showtable']))$_POST['showtable'] = 0;
if(!isset($_POST['row_id']))$_POST['row_id'] = false;
if(!isset($_POST['currency']))$_POST['currency'] = false;
if(!isset($_POST['status']))$_POST['status'] = false;
if(!isset($_POST['add_attachment']))$_POST['add_attachment'] = false;
if(!isset($_POST['remove_attachment']))$_POST['remove_attachment'] = false;
if(!isset($_POST['remove_price_id']))$_POST['remove_price_id'] = array();
if(!isset($_POST['publish_price_id']))$_POST['publish_price_id'] = array();
if(!isset($_POST['rename_attachment']))$_POST['rename_attachment'] = false;
if(!isset($_POST['update_attachment']))$_POST['update_attachment'] = false;
if(!isset($_POST['attach_update']))$_POST['attach_update'] = false;
if(!isset($_POST['localLanguage']))$_POST['localLanguage'] = "sk";

try
{
	ini_set("include_path",ini_get('include_path').PATH_SEPARATOR.realpath('../../'));

	$GLOBALS['project_folder']="/_sub";

	include ("themes/default/scripts/classes/sort_catalog_branches_save_handler.php");
	include ("themes/default/scripts/classes/sort_catalog_branches_to_branch_save_handler.php");
	include ("themes/default/scripts/classes/sort_catalog_products_to_branch_save_handler.php");

	include ("themes/default/scripts/classes/import.php");
//
//	##############################################
//	# login
//
//	if(isset($_SESSION['user'])){
//		$u = CMS_UserLogin::getSingleton();
//
//		if($_SESSION['user']['type'] == CMS_UserLogin::ADMIN_USER){
//			$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);
//
//			include("admin/dblogin.php");
//
//			$data->setDataSource("proxia");
//			$data->open();
//
//			$u->setUserType(CMS_UserLogin::ADMIN_USER);
//			$u->autoLogin();
//		}
//		elseif($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER){
//			$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);
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
//
	include ("../../../admin/scripts/functions.php");
	$path = "/config";
//
//	//  START DB
	if (!isset($GLOBALS['project_config']))
		$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);
//
//	$data->setUser($GLOBALS['project_config']->getSqlUser());
//	$data->setPassword($GLOBALS['project_config']->getSqlPassword());
//
//	$data->setDataSource($_SESSION['user']['dsn']);
//	$data->open();
//
//	var_dump($path."/config.xml");
//	$GLOBALS["config_all"] = CN_Config::loadFromFile($path."/config.xml");
//
	//$user_detail = CMS_UserLogin::getSingleton()->getUser();
//
	//$GLOBALS['localLanguage'] = $user_detail->getConfigValue('default_local_language');
//
	if (!isset($GLOBALS['localLanguage']))
		$GLOBALS['localLanguage'] = "sk";//getConfig('proxia','default_local_language');

	####################################################################################################
	// preload modulov
	####################################################################################################

	if($GLOBALS['project_config']->checkModuleAvailability('CMS_Gallery')){
		$mod = CMS_Module::addModule('CMS_Gallery');
		$mod->utilise();
	}

	####################################################################################################
	####################################################################################################

switch($_POST['section'])
{
	################################################################################################
	# section catalog
	################################################################################################

	case 'catalog':{

		if (is_Array($_POST['row_id'])){

		// PRESMERUJE NA UPDATE CATALOG
		if($_POST['go']==3){
			$ignore = array ("mcmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: /admin/?mcmd=3&module=CMS_Catalog$link");
			exit;
		}

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


		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']


	if ($_POST['go'] == 'list') {
		Header("Location: /admin/?".getReturnParameter());
		exit;
	}

	if ($_POST['go'] == 'edit') {
		$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
		$link = urlPost($ignore);
		Header("Location: /admin/?mcmd=3&module=CMS_Catalog&row_id[]=$new_id$link");
		exit;
	}


		}
	break;// END SECTION CATALOG



	case 'branch':{
		// presmerovanie pri mapovani
		if (is_Array($_POST['filter_branch'])){
			foreach ($_POST['filter_branch'] as $key => $value){
				if ($value != ''){
					Header("Location: /admin/?mcmd=20&module=CMS_Catalog&row_id[]=".$_POST['row_id'][0]."&filter_branch=".$value);
					exit;
				}
			}
		}


		if (is_Array($_POST['row_id'])){

		// PRESMERUJE NA UPDATE BRANCH
		if($_POST['go']==6){
			$ignore = array ("mcmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: /admin/?mcmd=6&module=CMS_Catalog$link");
			exit;
		}

		if(!isset($_POST['f_isPublished']) && $_POST['status']=="update") $_POST['f_isPublished'] = 0;

		foreach ($_POST['row_id'] as $name => $id){
			$branch = $id === '0' ? new CMS_Catalog_branch() : new CMS_Catalog_branch($id);
			$branch->setContextLanguage($GLOBALS['localLanguage']);

			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'f_') !== FALSE){
					$column_name = str_replace('f_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$branch->$function($value);
				}
			}// END FOREACH F_

			$branch->save();

			if ($_POST['map_to_branch']){

				if ($_POST['map_to_branch'] == -1){

					$category_parent = new CMS_Catalog_Branch($id);
					$catalog_parent = new CMS_Catalog($_SESSION['currentCatalog']);
					$catalog_parent->removeBranch($branch);

					if($branch->hasParent()){
						$branch->getParent()->removeItem($category_parent);

					}

					$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
					$catalog->addBranch($branch);
				}
				else{
					//$parent = new CMS_Catalog_Branch($_POST['map_to_branch']);
					//$parent->addItem($branch);
					$catalog_parent = new CMS_Catalog($_SESSION['currentCatalog']);
					$catalog_parent->removeBranch($branch);

					$category_parent = new CMS_Catalog_Branch($_POST['map_to_branch']);

					if($branch->hasParent()){
							$branch->getParent()->removeItem($branch);
							$category_parent->addItem($branch);

						}
					else
						$category_parent->addItem($branch);

				}

			}

			if ($_POST['language_visibility']==1){

				$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
				$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();

				foreach ($GLOBALS['LanguageList'] as $value){

					$code = $value['code'];
					$local_visibility = $value['local_visibility'];

					if ($local_visibility) {
						$valname = "a_languageIsVisible".$code;

						if(!isset($_POST[$valname]))
							$_POST[$valname] = 0;

						$branch->setContextLanguage($code);
						$function = 'set'.ucfirst($column_name);

						$branch->setLanguageIsVisible($_POST[$valname]);
					}
				}
			$branch->save();
			}

			$new_id = $branch->getId();

			if ($_POST['map_gallery']){
				$mod = CMS_Module::addModule('CMS_Gallery');
				$mod->utilise();

				$branch->addGallery(new CMS_Gallery($_POST['map_gallery']));

			}

			if ($_POST['unmap_gallery']){
				$mod = CMS_Module::addModule('CMS_Gallery');
				$mod->utilise();

				$branch->removeGallery(new CMS_Gallery($_POST['unmap_gallery']));

			}

			if($_POST['add_attribut_id']){

				$branch->addAttribute(new CMS_Catalog_AttributeDefinition($_POST['add_attribut_id']));

			}

			if (is_Array($_POST['remove_attribut_id'])){

				foreach ($_POST['remove_attribut_id'] as $value){
					$branch->removeAttribute(new CMS_Catalog_AttributeDefinition($value));
				}

			}

			if($_POST['delete']==1){
				$branch->delete();
			}

			if ($_POST['move_down_in_category'] > 0){
				$branch->moveDownInCategory();
			}

			if ($_POST['move_up_in_category'] > 0){
				$branch->moveUpInCategory();
			}

			if ($_POST['move_bottom_in_category'] > 0){
				$branch->moveToBottomInCategory();
			}

			if ($_POST['move_top_in_category'] > 0){
				$branch->moveToTopInCategory();
			}
		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']

	if ($_POST['go'] == 'list') {
		Header("Location: /admin/?".getReturnParameter());
		exit;
	}

	if ($_POST['go'] == 'edit') {
		$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
		$link = urlPost($ignore);
		Header("Location: /admin/?mcmd=6&module=CMS_Catalog&row_id[]=$new_id$link");
		exit;
	}

		}
	break;// END SECTION BRANCH


	case 'mapbranchtoproducts':{

		if (is_Array($_POST['row_id'])){

			$branch = new CMS_Catalog_branch($_POST['branch_id']);

			foreach ($_POST['row_id'] as $name => $id){

				$branch->addItem(new CMS_Catalog_Product($id));

			}// END FOREACH ROW_ID

		}// END IF $_POST['row_id']

		Header("Location: /admin/?mcmd=4&module=CMS_Catalog");
		exit;

	}
	break;// END SECTION MAP BRANCH TO PRODUCTS

	case 'unmapbranchtoproducts':{

		if (is_Array($_POST['row_id'])){

			$branch = new CMS_Catalog_branch($_POST['branch_id']);

			foreach ($_POST['row_id'] as $name => $id){

				$branch->removeItem(new CMS_Catalog_Product($id));

			}// END FOREACH ROW_ID

		}// END IF $_POST['row_id']

		Header("Location: /admin/?mcmd=4&module=CMS_Catalog");
		exit;

	}
	break;// END SECTION UNMAP BRANCH TO PRODUCTS



	case 'attribut':{
		// presmerovanie pri mapovani
		if (is_Array($_POST['filter_branch'])){
			foreach ($_POST['filter_branch'] as $key => $value){
				if ($value != ''){
					Header("Location: /admin/?mcmd=13&module=CMS_Catalog&row_id[]=".$_POST['row_id'][0]."&filter_branch=".$value);
					exit;
				}
			}
		}

		if (is_Array($_POST['row_id'])){

		// PRESMERUJE NA UPDATE ATRIBUT
		if($_POST['go']==9){
			$ignore = array ("mcmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: /admin/?mcmd=9&module=CMS_Catalog$link");
			exit;
		}

		foreach ($_POST['row_id'] as $name => $id){
			$attribut = $id === '0' ? new CMS_Catalog_AttributeDefinition() : new CMS_Catalog_AttributeDefinition($id);
			$attribut->setContextLanguage($GLOBALS['localLanguage']);

			$_POST['f_catalogId'] = $_SESSION['currentCatalog'];

			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'f_') !== FALSE){
					$column_name = str_replace('f_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$attribut->$function($value);
				}
			}// END FOREACH F_

			$attribut->save();

			$new_id = $attribut->getId();

			if($_POST['delete']==1){
				$attribut->delete();
			}

		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']

	if ($_POST['go'] == 'list') {
		Header("Location: /admin/?".getReturnParameter());
		exit;
	}

	if ($_POST['go'] == 'edit') {
		$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
		$link = urlPost($ignore);
		Header("Location: /admin/?mcmd=9&module=CMS_Catalog&row_id[]=$new_id$link");
		exit;
	}


		}
	break;// END SECTION ATRIBUT


	case 'mapattributtoproduct':{

		if (is_Array($_POST['row_id'])){


			foreach ($_POST['row_id'] as $name => $id){

				$attribut_map = $_POST['map_id'][$id] === '0' ? new CMS_Catalog_ProductAttribute() : new CMS_Catalog_ProductAttribute($_POST['map_id'][$id]);
				$attribut_map->setContextLanguage($GLOBALS['localLanguage']);

				$attribut_map->setValue($_POST['attribut_value'][$id]);

				$attribut_map->setAttributeDefinitionId($_POST['attribut_id']);

				$attribut_map->setProductId($id);

				$attribut_map->save();

			}// END FOREACH ROW_ID

		}// END IF $_POST['row_id']

		Header("Location: /admin/?mcmd=7&module=CMS_Catalog");
		exit;

	}
	break;// END SECTION MAP ATTRIBUT TO PRODUCT


	case 'unmapattributtoproduct':{

		if (is_Array($_POST['row_id'])){


			foreach ($_POST['row_id'] as $name => $id){
				$attribut_map = $_POST['map_id'][$id] === '0' ? new CMS_Catalog_ProductAttribute() : new CMS_Catalog_ProductAttribute($_POST['map_id'][$id]);
				$attribut_map->setContextLanguage($GLOBALS['localLanguage']);

				$attribut_map->delete();

			}// END FOREACH ROW_ID

		}// END IF $_POST['row_id']

		Header("Location: /admin/?mcmd=7&module=CMS_Catalog");
		exit;

	}
	break;// END SECTION UNMAP ATTRIBUT TO PRODUCT



	case 'mapproducttoattribut':{

		if (is_Array($_POST['row_id'])){


			foreach ($_POST['row_id'] as $name => $id){

				$attribut_map = $_POST['map_id'][$id] === '0' ? new CMS_Catalog_ProductAttribute() : new CMS_Catalog_ProductAttribute($_POST['map_id'][$id]);
				$attribut_map->setContextLanguage($GLOBALS['localLanguage']);

				$attribut_map->setValue($_POST['attribut_value'][$id]);

				$attribut_map->setAttributeDefinitionId($id);

				$attribut_map->setProductId($_POST['product_id']);

				$attribut_map->save();

			}// END FOREACH ROW_ID

		}// END IF $_POST['row_id']
		Header("Location: /admin/?".getReturnParameter(0));
		//Header("Location: /admin/?mcmd=10&module=CMS_Catalog");
		exit;

	}
	break;// END SECTION MAP PRODUCT TO ATRIBUT


	case 'unmapproducttoattribut':{

		if (is_Array($_POST['row_id'])){


			foreach ($_POST['row_id'] as $name => $id){
				$attribut_map = $_POST['map_id'][$id] === '0' ? new CMS_Catalog_ProductAttribute() : new CMS_Catalog_ProductAttribute($_POST['map_id'][$id]);
				$attribut_map->setContextLanguage($GLOBALS['localLanguage']);

				$attribut_map->delete();

			}// END FOREACH ROW_ID

		}// END IF $_POST['row_id']

		Header("Location: /admin/?mcmd=10&module=CMS_Catalog");
		exit;

	}
	break;// END SECTION UNMAP PRODUCT TO ATRIBUT





	case 'product':{

		if (is_Array($_POST['row_id'])){

		// PRESMERUJE NA UPDATE PRODUCT
		if($_POST['go']==12){
			$ignore = array ("mcmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: /admin/?mcmd=12&module=CMS_Catalog$link");
			exit;
		}

		if((!isset($_POST['f_isPublished'])) && ($_POST['act']=="update"))$_POST['f_isPublished'] = 0;

		if (isset($_POST['f_valid_from'])){
			if($_POST['f_valid_from']=='')$_POST['f_valid_from'] = null;
		}

		if (isset($_POST['f_valid_to'])){
			if($_POST['f_valid_to']=='')$_POST['f_valid_to'] = null;
		}
		foreach ($_POST['row_id'] as $name => $id)
		{

		//print_r($_POST);exit;
			$_POST["f_title"] = str_replace("'","&#39;",$_POST["f_title"]);
			$_POST["f_description"] = str_replace("'","&#39;",$_POST["f_description"]);
			$_POST["f_descriptionExtended"] = str_replace("'","&#39;",$_POST["f_descriptionExtended"]);
			$product = $id === '0' ? new CMS_Catalog_Product() : new CMS_Catalog_Product($id);
			$product->setContextLanguage($GLOBALS['localLanguage']);

			$_POST['f_catalogId'] = $_SESSION['currentCatalog'];

			// only_detail - doplnene 9-2015 lebo ri aktualizacii attributu aktualizoval aj popis...
			if ($_POST['only_detail'])
			{
				foreach($_POST as $column_name => $value){
					if(strpos($column_name, 'f_') !== FALSE){
						$column_name = str_replace('f_', '', $column_name);
						$function = 'set'.ucfirst($column_name);
						$product->$function($value);
						//echo $function."-".$value."<br>";
					}
				}// END FOREACH F_

				//exit;

				$product->save();
			}
			$new_id = $product->getId();

			if ($_POST['map_to_branch']){

					$parent = new CMS_Catalog_Branch($_POST['map_to_branch']);
					$parent->addItem($product);

			}

			if ($_POST['unmap_to_branch']){
					$parent = new CMS_Catalog_Branch($_POST['unmap_to_branch']);
					$parent->removeItem($product);

			}

			if ($_POST['map_gallery']){
				$mod = CMS_Module::addModule('CMS_Gallery');
				$mod->utilise();

				$product->addGallery(new CMS_Gallery($_POST['map_gallery']));

			}

			if ($_POST['unmap_gallery']){
				$mod = CMS_Module::addModule('CMS_Gallery');
				$mod->utilise();

				$product->removeGallery(new CMS_Gallery($_POST['unmap_gallery']));

			}

			if($_POST['delete']==1){
				$product->delete();
			}

			if($_POST['add_attribut_id']){
				$new_attribut = new CMS_Catalog_ProductAttribute();
				$new_attribut->setContextLanguage($GLOBALS['localLanguage']);
				$new_attribut->setAttributeDefinitionId($_POST['add_attribut_id']);
				$new_attribut->setProductId($new_id);
				$new_attribut->setImage($_POST['add_attribut_value_image']);
				$new_attribut->setValue($_POST['add_attribut_value']);
				$new_attribut->save();
			}


			if($_POST['update_attribut']){

				foreach ($_POST['update_attribut_value'] as $key => $value){
					$new_attribut = new CMS_Catalog_ProductAttribute($key);
					$new_attribut->setContextLanguage($GLOBALS['localLanguage']);
					$new_attribut->setValue($value);
					$new_attribut->save();
				}

				foreach ($_POST['update_attribut_value_image'] as $key => $value){
					$new_attribut = new CMS_Catalog_ProductAttribute($key);
					$new_attribut->setImage($value);
					$new_attribut->save();
				}

				if (is_Array($_POST['remove_attribut_id'])){

					foreach ($_POST['remove_attribut_id'] as $value){
						$new_attribut = new CMS_Catalog_ProductAttribute($value);
						$new_attribut->delete();
					}

				}

			}

			if($_POST['move_down_attribut'] > 0){
				$move_attribut = new CMS_Catalog_ProductAttribute($_POST['move_down_attribut']);
				$move_attribut->moveDown();
			}

			if($_POST['move_up_attribut'] > 0){
				$move_attribut = new CMS_Catalog_ProductAttribute($_POST['move_up_attribut']);
				$move_attribut->moveUp();
			}

			if($_POST['move_bottom_attribut'] > 0){
				$move_attribut = new CMS_Catalog_ProductAttribute($_POST['move_bottom_attribut']);
				$move_attribut->moveToBottom();
			}

			if($_POST['move_top_attribut'] > 0){
				$move_attribut = new CMS_Catalog_ProductAttribute($_POST['move_top_attribut']);
				$move_attribut->moveToTop();
			}

			if ($_POST['language_visibility']==1){

				$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
				$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();

				foreach ($GLOBALS['LanguageList'] as $value){

					$code = $value['code'];
					$local_visibility = $value['local_visibility'];

					if ($local_visibility) {
						$valname = "a_languageIsVisible".$code;

						if(!isset($_POST[$valname]))
							$_POST[$valname] = 0;

						$product->setContextLanguage($code);
						$function = 'set'.ucfirst($column_name);

						$product->setLanguageIsVisible($_POST[$valname]);
					}
				}
			$product->save();
			}

			if ($_POST['move_down_in_category'] == 1){
					$product->moveDown($_POST['s_category']);
				}

			if ($_POST['move_up_in_category'] == 1){
					$product->moveUp($_POST['s_category']);
				}
			if ($_POST['move_bottom_in_category'] == 1){
					$product->moveToBottom($_POST['s_category']);
				}

			if ($_POST['move_top_in_category'] == 1){
					$product->moveToTop($_POST['s_category']);
				}

			if ($_POST['price']){


				foreach ($_POST['price'] as $map_id => $price){
					//echo "<br>..".$map_id;
					if (is_numeric($price)){
						if ($price == '')
							$price=0;

						if ($map_id == 0)
							$product->addPrice($price,null,null,"'".$_POST['currency']."'");
						else{
							$price_edit = new CMS_Catalog_Price($map_id);
							$price_edit->setPrice($price);
							$price_edit->setCurrency("'".$_POST['currency']."'");
							$price_edit->save();
						}
					}
				}


			}


		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']

	if ($_POST['go'] == 'list') {
		Header("Location: /admin/?".getReturnParameter());
		exit;
	}

	if ($_POST['go'] == 'edit') {
		$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
		//$link = urlPost($ignore);
		$link = null;
		Header("Location: /admin/?mcmd=12&module=CMS_Catalog&row_id[]=$new_id$link&showtable=".$_POST['showtable']);
		exit;
	}


		}
	break;// END SECTION PRODUCT


	case 'product_price':{

		if (isset($_POST['product_id'])){
				$product_id = $_POST['product_id'];
				if(isset($_POST['update_price']) and $_POST['update_price'] == 1){
					$publish_price_array = $_POST['publish_price_id'];
					$update_price_array = $_POST['update_price_value'];
					$remove_price_array = $_POST['remove_price_id'];
					$update_note_array = $_POST['price_note'];
					$pocet_update = count($publish_price_array);
					$pocet_delete = count($remove_price_array);


					//1.najskor nastavit vsetku viditelnost na false
					$product = new CMS_Catalog_Product($_POST['product_id']);
					$prices = $product->getPriceList();
					foreach($prices as $price){
						$price->setContextLanguage($GLOBALS['localLanguage']);
						$price->setIsPublished("0");
						$price->setPrice($price->getPrice());
						$price->setProductId($price->getProductId());
						$price->setCurrency($price->getCurrency());
						$price->setValidFrom($price->getValidFrom());
						$price->setValidTo($price->getValidTo());
						$price->setAccess($price->getAccess());
						$price->setAccessGroups($price->getAccessGroups());
						$price->setNote($price->getNote() == null ? "" :$price->getNote());
						$price->save();
					}

					//2.nastavit viditelnost na true pre vybrate	ceny
					for($i = 0;$i < $pocet_update;$i++){
						$cena_id = $publish_price_array[$i];

						$price = new CMS_Catalog_Price($cena_id);
						$price->setContextLanguage($GLOBALS['localLanguage']);
						$price->setIsPublished("1");
						$price->setPrice($price->getPrice());
						$price->setProductId($price->getProductId());
						$price->setCurrency($price->getCurrency());
						$price->setValidFrom($price->getValidFrom());
						$price->setValidTo($price->getValidTo());
						$price->setAccess($price->getAccess());
						$price->setAccessGroups($price->getAccessGroups());
						$price->setNote($price->getNote() == null ? "" :$price->getNote());
						$price->save();
					}
					//3.aktualizovat ceny

					foreach($update_price_array as $key => $value){

						$price = new CMS_Catalog_Price($key);
						$price->setContextLanguage($GLOBALS['localLanguage']);
						$price->setPrice($value);
						$price->setIsPublished($price->getIsPublished());
						$price->setProductId($price->getProductId());
						$price->setCurrency($price->getCurrency());
						$price->setValidFrom($price->getValidFrom());
						$price->setValidTo($price->getValidTo());
						$price->setAccess($price->getAccess());
						$price->setAccessGroups($price->getAccessGroups());
						$price->setNote($price->getNote() == null ? "" :$price->getNote());
						$price->save();
					}
					foreach($update_note_array as $key => $value){

						$price = new CMS_Catalog_Price($key);
						$price->setContextLanguage($GLOBALS['localLanguage']);
						$price->setPrice($price->getPrice());
						$price->setIsPublished($price->getIsPublished());
						$price->setProductId($price->getProductId());
						$price->setCurrency($price->getCurrency());
						$price->setValidFrom($price->getValidFrom());
						$price->setValidTo($price->getValidTo());
						$price->setAccess($price->getAccess());
						$price->setAccessGroups($price->getAccessGroups());
						$price->setNote($value);
						$price->save();
					}
					//4.vymazat vybrate	ceny
					for($i = 0;$i < $pocet_delete;$i++){
						$cena_id = $remove_price_array[$i];
						$price = new CMS_Catalog_Price($cena_id);
						$price->delete();
					}


				}else{
			  	if((!isset($_POST['priceIsPublished'])))$_POST['priceIsPublished'] = 0;

					if (isset($_POST['price_valid_from'])){
						if($_POST['price_valid_from']=='')$_POST['price_valid_from'] = null;
					}

					if (isset($_POST['price_valid_to'])){
						if($_POST['price_valid_to']=='')$_POST['price_valid_to'] = null;
					}

					if (!isset($_POST['new_price']) or !is_numeric($_POST['new_price']) or $_POST['new_price']==''){
						$_POST['new_price'] = 0;
					}
					if($_POST['price_access']==3)// ak je skupina
					{
						$acces_group = serialize($_POST['price_access_groups']);
					}else
						$acces_group = null;

					$price_edit = new CMS_Catalog_Price();
					$price_edit->setContextLanguage($GLOBALS['localLanguage']);
					//echo $_POST['price_currency'];
					$price_edit->setPrice($_POST['new_price']);
					$price_edit->setIsPublished($_POST['priceIsPublished']);
					$price_edit->setProductId($_POST['product_id']);
					$price_edit->setCurrency($_POST['price_currency']);
					$price_edit->setValidFrom($_POST['price_valid_from']);
					$price_edit->setValidTo($_POST['price_valid_to']);
					$price_edit->setAccess($_POST['price_access']);
					$price_edit->setAccessGroups($acces_group);
					$price_edit->setNote($_POST['price_note']);
					$price_edit->save();



				}
		}// END IF $_POST['product_id']


			if ($_POST['go'] == 'list') {
				Header("Location: /admin/?".getReturnParameter());
				exit;
			}

			if ($_POST['go'] == 'edit') {

				//$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				Header("Location: /admin/?mcmd=12&module=CMS_Catalog&row_id[]=$product_id&showtable=".$_POST['showtable']);
				exit;
			}
		}
		break;// END SECTION PRODUCT PRICE

	case 'product_attachment':{

		if (isset($_POST['product_id'])){
				$product_id = $_POST['product_id'];

				$product = new CMS_Catalog_Product($_POST['product_id']);


				if($_POST['add_attachment'] == 1){
					$file_title = $_POST['p__title'];
					$file_name = $_POST['p__file'];
					$priloha = new CMS_Attachment();
					$priloha->setContextLanguage($GLOBALS['localLanguage']);
					$priloha->setTitle($file_title);
					$priloha->setFile($file_name);
					$priloha->save();
					$product->addAttachment($priloha);
				}

				if($_POST['update_attachment'] == 1){

						if (($_POST['update_attachment'])&&($_POST['attach_update'])){
							$pole_lang = Array(0=>'');
							foreach($_POST as $column_name => $value){
								if(strpos($column_name, 'language_visibility') !== FALSE){
									$pole_lang[] = substr($column_name,19);
								}
							}
							foreach ($product->getAttachments() as $value){
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
										$product->removeAttachment($priloha);
									}
								}
							}
						}
				}
		}// END IF $_POST['product_id']


			if ($_POST['go'] == 'list') {
				Header("Location: /admin/?".getReturnParameter());
				exit;
			}

			if ($_POST['go'] == 'edit') {

				//$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				Header("Location: /admin/?mcmd=12&module=CMS_Catalog&row_id[]=$product_id&showtable=".$_POST['showtable']);
				exit;
			}
		}
		break;// END SECTION


	case 'product_setup':{

		if (is_Array($_POST['row_id'])){

		$old_product_id= 0;
		foreach ($_POST['row_id'] as $name => $id){

			$product = $id === '0' ? new CMS_Catalog_Product() : new CMS_Catalog_Product($id);
			$product->setContextLanguage($GLOBALS['localLanguage']);

			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'f_') !== FALSE){
					$column_name = str_replace('f_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$product->$function($value);
				}
			}// END FOREACH F_

			if ($_POST['setup_type'] == 'visibility')
			{
				if(!isset($_POST['visibility'][$id]))
					$_POST['visibility'][$id] = 0;

				$product->setIsPublished($_POST['visibility'][$id]);
			}
			elseif ($_POST['setup_type'] == 'valid')
			{

				if (isset($_POST['validfrom'][$id])){
					if($_POST['validfrom'][$id]=='')$_POST['validfrom'][$id] = null;
				}

				if (isset($_POST['validto'][$id])){
					if($_POST['validto'][$id]=='')$_POST['validto'][$id] = null;
				}
				$product->setValidFrom($_POST['validfrom'][$id]);
				$product->setValidTo($_POST['validto'][$id]);
			}
			elseif ($_POST['setup_type'] == 'image'){
				$product->setImage($_POST['image'][$id]);
			}
			elseif ($_POST['setup_type'] == 'access'){
				$product->setAccess($_POST['access'][$id]);
			}
			elseif ($_POST['setup_type'] == 'news'){
				$is_news = isset($_POST['news'][$id]) ? 1 : 0;
				$product->setIsNews($is_news);
			}
			elseif ($_POST['setup_type'] == 'sale'){
				$is_sale = isset($_POST['sale'][$id]) ? 1 : 0;
				$product->setIsSale($is_sale);
			}
			elseif ($_POST['setup_type'] == 'stock'){
				$in_stock = isset($_POST['stock'][$id]) && is_numeric($_POST['stock'][$id]) ? $_POST['stock'][$id] : "NULL";
				$product->setInStock($in_stock);
			}
			$product->save();

			$new_id = $product->getId();

			if ($_POST['setup_type'] == 'visibility'){

				$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
				$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();

				foreach ($GLOBALS['LanguageList'] as $value){

					$code = $value['code'];
					$local_visibility = $value['local_visibility'];

					if ($local_visibility) {
						$valname = "a_languageIsVisible".$code;

						if(!isset($_POST[$valname][$id]))
							$_POST[$valname][$id] = 0;

						$product->setContextLanguage($code);

						$product->setLanguageIsVisible($_POST[$valname][$id]);
					}
				}
			$product->save();
			}


			$old_product_id = $id;
		}// END FOREACH ROW_ID

			if ($_POST['setup_type'] == 'price' )
			{
				$access = isset($_POST['s_group']) ? $_POST['s_group'] : CMS::ACCESS_PUBLIC;
				$access_code = substr($access,0,1);
				if($access_code == 3)
				{
					$access_group = substr($access,2);
					$access_group = serialize(array($access_group));
					$access = 3;
				}

				foreach ($_POST['price'] as $key => $value)
				{
					foreach ($value as $map_id => $price)
					{
						if (is_numeric($price))
						{
							if ($price == '')
								$price=0;

							if ($map_id == 0)
							{
								$product = new CMS_Catalog_Product($key);
								if($access_code == 3)
									$product->addPrice($price,null,null,$_POST['price_currency'],$access_code,$access_group);
								else
									$product->addPrice($price,null,null,$_POST['price_currency'],$access_code);
							}else{
								$price_edit = new CMS_Catalog_Price($map_id);
								$price_edit->setPrice($price);
								$price_edit->setProductId($key);
								$price_edit->setCurrency($_POST['price_currency']);
								$price_edit->setAccess($access_code);
								if($access_code == 3)
									$price_edit->setAccessGroups($access_group);
								$price_edit->save();

							}
						}
					}
				}

			}

	}// END IF $_POST['row_id']

	if ($_POST['go'] == 'list') {
		Header("Location: /admin/?mcmd={$_POST['mcmd']}&module=CMS_Catalog&start={$_POST['start']}&setup_type={$_POST['setup_type']}&currency={$_POST['currency']}&group={$_POST['s_group']}");
		exit;
	}

	Header("Location: /admin/?mcmd={$_POST['mcmd']}&module=CMS_Catalog&start={$_POST['start']}&setup_type={$_POST['setup_type']}&currency={$_POST['currency']}&group={$_POST['s_group']}");
	exit;

		}
	break;// END SECTION PRODUCT SETUP




	case 'branch_language':{

		if (is_Array($_POST['row_id'])){


		foreach ($_POST['row_id'] as $name => $id){
			$branch = $id === '0' ? new CMS_Catalog_Branch() : new CMS_Catalog_Branch($id);
			$branch->setContextLanguage($GLOBALS['localLanguage']);

			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'f_') !== FALSE){
					$column_name = str_replace('f_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$branch->$function($value);
				}
			}// END FOREACH F_

			if(!isset($_POST['visibility'][$id]))
				$_POST['visibility'][$id] = 0;

			$branch->setIsPublished($_POST['visibility'][$id]);

			$branch->save();

			$new_id = $branch->getId();

			if ($_POST['language_visibility']==1){

				$GLOBALS['menuLang'] = CMS_Languages::getSingleton();
				$GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();

				foreach ($GLOBALS['LanguageList'] as $value){

					$code = $value['code'];
					$local_visibility = $value['local_visibility'];

					if ($local_visibility) {
						$valname = "a_languageIsVisible".$code;

						if(!isset($_POST[$valname][$id]))
							$_POST[$valname][$id] = 0;

						$branch->setContextLanguage($code);

						$branch->setLanguageIsVisible($_POST[$valname][$id]);
					}
				}
			$branch->save();
			}

		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']

	if ($_POST['go'] == 'list') {
		Header("Location: /admin/?mcmd={$_POST['mcmd']}&module=CMS_Catalog");
		exit;
	}

	if ($_POST['go'] == 'edit') {
		$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
		//$link = urlPost($ignore);
		$link = null;
		Header("Location: /admin/?mcmd=12&module=CMS_Catalog&row_id[]=$new_id$link&showtable=".$_POST['showtable']);
		exit;
	}

	Header("Location: /admin/?module=CMS_Catalog&mcmd={$_POST['mcmd']}");
	exit;

		}
	break;// END SECTION PRODUCT LANG

	case 'branch_attachment':{

		if (isset($_POST['branch_id'])){
				$branch_id = $_POST['branch_id'];

				$branch = new CMS_Catalog_Branch($_POST['branch_id']);


				if($_POST['add_attachment'] == 1){
					$file_title = $_POST['p__title'];
					$file_name = $_POST['p__file'];
					$priloha = new CMS_Attachment();
					$priloha->setContextLanguage($GLOBALS['localLanguage']);
					$priloha->setTitle($file_title);
					$priloha->setFile($file_name);
					$priloha->save();
					$branch->addAttachment($priloha);
				}

				if($_POST['update_attachment'] == 1){

						if (($_POST['update_attachment'])&&($_POST['attach_update'])){
							$pole_lang = Array(0=>'');
							foreach($_POST as $column_name => $value){
								if(strpos($column_name, 'language_visibility') !== FALSE){
									$pole_lang[] = substr($column_name,19);
								}
							}
							foreach ($branch->getAttachments() as $value){
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
										$branch->removeAttachment($priloha);
									}
								}
							}
						}
				}
		}// END IF $_POST['product_id']


			if ($_POST['go'] == 'list') {
				Header("Location: /admin/?".getReturnParameter());
				exit;
			}

			if ($_POST['go'] == 'edit') {

				//$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				Header("Location: /admin/?mcmd=6&module=CMS_Catalog&row_id[]=$branch_id&showtable=".$_POST['showtable']);
				exit;
			}
		}
		break;// END SECTION


	case 'group_attribute':{

		if (is_Array($_POST['row_id'])){

		// PRESMERUJE NA UPDATE ATRIBUT
		if($_POST['go']==25){
			$ignore = array ("mcmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: /admin/?mcmd=25&module=CMS_Catalog$link");
			exit;
		}

		foreach ($_POST['row_id'] as $name => $id){
			$attributGroup = $id === '0' ? new CMS_Catalog_AttributeGroup() : new CMS_Catalog_AttributeGroup($id);

			$attributGroup->setContextLanguage($GLOBALS['localLanguage']);
			foreach($_POST as $column_name => $value){
				if(strpos($column_name, 'f_') !== FALSE){
					$column_name = str_replace('f_', '', $column_name);
					$function = 'set'.ucfirst($column_name);
					$attributGroup->$function($value);
				}
			}// END FOREACH F_

			$attributGroup->save();

			$new_id = $attributGroup->getId();

			// ak je nova skupina tak priradit ku katalogu
			if($id === '0'){
				$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
				$catalog->addItem($attributGroup);
			}

			if($_POST['delete']==1){

				#vymazat vazbu na katalog
				$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
				$catalog->removeItem($attributGroup);

				#vymazat samotnu skupinu
				$attributGroup->delete();
			}



		}// END FOREACH ROW_ID
	}// END IF $_POST['row_id']

	if ($_POST['go'] == 'list') {
		Header("Location: /admin/?".getReturnParameter());
		exit;
	}

	if ($_POST['go'] == 'edit') {
		$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
		$link = urlPost($ignore);
		Header("Location: /admin/?mcmd=25&module=CMS_Catalog&row_id[]=$new_id$link");
		exit;
	}


		}
	break;// END SECTION ATRIBUT

	case 'map_attribute_to_group':{
		if(isset($_POST['add_attribut_id']) && $_POST['add_attribut_id']!=0){
			$attributeGroup = new CMS_Catalog_AttributeGroup($_POST['group_id']);
			$attributeGroup->addAttribute(new CMS_Catalog_AttributeDefinition($_POST['add_attribut_id']));
		}

		Header("Location: /admin/?mcmd=25&module=CMS_Catalog&row_id[]={$_POST['group_id']}");
		exit;

	}
	case 'unmap_attribute_to_group':{

		$attributeGroup = new CMS_Catalog_AttributeGroup($_POST['group_id']);

		if (is_Array($_POST['remove_attribut_id'])){

			foreach ($_POST['remove_attribut_id'] as $value){
				$attributeGroup->removeAttribute(new CMS_Catalog_AttributeDefinition($value));
			}

		}

		Header("Location: /admin/?mcmd=25&module=CMS_Catalog&row_id[]={$_POST['group_id']}");
		exit;

	}


	################################################################################################
	# section import stock 1
	################################################################################################

	case 'import_stock_1':
	{

		$time_mark = time();
		$tmp_file_name = $_SESSION['user']['name'].'_import_stock_'.$time_mark.'.txt';

		foreach ($_FILES as $file => $value)
			$_FILES[$file]['name'] =  $tmp_file_name;

		$upload = new CN_FileUpload();
		$upload -> setTargetDirectory($GLOBALS['tmpfiles_path']);
		$upload -> upload();

		if ($_POST['cp_src'] != 'utf-8') {

			// ###############################  charset start
			require_once "themes/default/scripts/charset/ConvertCharset.class";
			$C_CONVERT=new ConvertCharset();

			$file=file($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_stock_'.$time_mark.'.txt');
			$converted="";
			for($i=0; $i<count($file); $i++){
				$line=$file[$i];
				$converted.=$C_CONVERT->Convert($file[$i], $_POST['cp_src'], "utf-8");
			}

			// ###############################

			$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_stock_'.$time_mark.'.txt', 'w');
			fwrite($handle, $converted);
			fclose($handle);
			// ###############################  charset end

		}

		Header("Location: /admin/?mcmd=30&module=CMS_Catalog&time_mark=$time_mark&delimiter={$_POST['delimiter']}");
		exit;

	}

	################################################################################################
	# section import 2
	################################################################################################

	case 'import_stock_2':
	{

		$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_stock_'.$_POST['time_mark'].'.txt', 'r');
		$array_delimiter = array('\t',';',',','§');

		$num_row = 0;
		$import = array();
		$toSql = array();
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
		  if(is_array($data) && count($data) == 2)// ak je pole a ma dva stplce
		  {
			$code = trim($data[0]);
			$amount = $data[1];
			if(is_numeric($amount))
			{
			  $toSql = "Update `catalog_products` set `in_stock`={$amount} where `code`='{$code}'";
			  $query = new CN_SqlQuery($toSql);
			  $query->execute();
			}

		  }

		}
		fclose($handle);

		//$sql = join(" , ",$toSql);
		//$sql = "Update `catalog_products` ".$sql;

		Header("Location: /admin/?mcmd=30&module=CMS_Catalog&message=".tr('Údaje boli aktualizované'));
		exit;

	}

	case 'import_products_PNEU_1':
	{

		$time_mark = time();
		$tmp_file_name = $_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt';

		foreach ($_FILES as $file => $value)
			$_FILES[$file]['name'] =  $tmp_file_name;

		$upload = new CN_FileUpload();
		$upload -> setTargetDirectory($GLOBALS['tmpfiles_path']);
		$upload -> upload();

		if ($_POST['cp_src'] != 'utf-8') {

			// ###############################  charset start
			require_once "themes/default/scripts/charset/ConvertCharset.class";
			$C_CONVERT=new ConvertCharset();

			$file=file($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt');
			$converted="";
			for($i=0; $i<count($file); $i++){
				$line=$file[$i];
				$converted.=$C_CONVERT->Convert($file[$i], $_POST['cp_src'], "utf-8");
			}

			// ###############################

			$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt', 'w');
			fwrite($handle, $converted);
			fclose($handle);
			// ###############################  charset end

		}

		Header("Location: /admin/?mcmd=102&module=CMS_Catalog&time_mark=$time_mark&delimiter={$_POST['delimiter']}");
		exit;

	}

	################################################################################################
	# section import products PNEU 2
	################################################################################################
	case 'import_products_PNEU_2':
	{
		$ch = curl_init('themes/default/');
	}
	case 'import_products_PNEU_2_RUN':
	{

		$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_POST['time_mark'].'.txt', 'r');
		$array_delimiter = array('\t',';',',','§');

		$import = new ImportPneu();
		/* zistit cisla atributov */
		$brand_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"brand",$_SESSION['currentCatalog']);
		$size_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"size",$_SESSION['currentCatalog']);
		$r_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"r",$_SESSION['currentCatalog']);
		$li_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"li",$_SESSION['currentCatalog']);
		$si_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"si",$_SESSION['currentCatalog']);
		$xl_rf_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"xl/rf",$_SESSION['currentCatalog']);
		//$type_wheather_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"type",$_SESSION['currentCatalog']);
		$note_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"note",$_SESSION['currentCatalog']);
		$pr_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"PR",$_SESSION['currentCatalog']);

		$rows = 0;
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
			$rows++;
		}
		fseek($handle, 0);

		$width = 0;		//	the starting width
		$percentage = 0;	//	the starting percentage
		$total_iterations = $rows;	//	the number of iterations to perform
		$width_per_iteration = 300 / $total_iterations; // how many pixels should the progress div be increased per each iteration
		$rows = 0;
		ob_start ();
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
		  if(is_array($data) )
		  {
			$rows++;
			$brand = trim($data[0]);
			$code = trim($data[1]);
			$size = trim($data[2]);
			//$size = str_replace("-","/",trim($data[2]));
			$r = trim($data[3]);
			$li = str_replace("-","/",trim($data[4]));
			$si = trim($data[5]);
			$xl_rf = trim($data[6]);
			$pattern = trim($data[7]);
			$price = trim($data[8]);
			$picture = isset($data[9]) ? trim($data[9]) : "";
			$note = isset($data[10]) ? $data[10] : null;


			$product_id = $import->updateProductData($data);

 			$import->updateAttribute($product_id, $brand_id, $brand);
 			$import->updateAttribute($product_id, $size_id, $size);
 			$import->updateAttribute($product_id, $r_id, $r);
 			$import->updateAttribute($product_id, $li_id, $li);
 			$import->updateAttribute($product_id, $si_id, $si);
 			$import->updateAttribute($product_id, $xl_rf_id, $xl_rf);
 			if(is_numeric($note_id) && $note)
 			{
				$import->updateAttribute($product_id, $note_id, $note,null,true);
			}
  			if(is_numeric($pr_id))
 				$import->updateAttribute($product_id, $pr_id, $xl_rf);

 			$import->updatePrice($product_id, $price);

			echo '<div style="width:300px;border:1px solid #ccc;position:absolute;top:200px;left:50%;margin-left:-150px"><div style="height:20px;background-color:#000;width:' . $width . 'px;"></div></div>';
			$width += $width_per_iteration;
			echo "&nbsp;";
			ob_flush();
			flush();
		  }

		}
		fclose($handle);

		echo "<script type='text/javascript'>document.location = '/admin/?mcmd=102&module=CMS_Catalog&message=".tr('Údaje boli aktualizované')."'</script>";
		//Header("Location: /admin/?mcmd=102&module=CMS_Catalog&message=".tr('Údaje boli aktualizované'));
		exit;

	}

	case 'import_products_PNEU_duse_1':
	{

		$time_mark = time();
		$tmp_file_name = $_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt';

		foreach ($_FILES as $file => $value)
			$_FILES[$file]['name'] =  $tmp_file_name;

		$upload = new CN_FileUpload();
		$upload -> setTargetDirectory($GLOBALS['tmpfiles_path']);
		$upload -> upload();

		if ($_POST['cp_src'] != 'utf-8') {

			// ###############################  charset start
			require_once "themes/default/scripts/charset/ConvertCharset.class";
			$C_CONVERT=new ConvertCharset();

			$file=file($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt');
			$converted="";
			for($i=0; $i<count($file); $i++){
				$line=$file[$i];
				$converted.=$C_CONVERT->Convert($file[$i], $_POST['cp_src'], "utf-8");
			}

			// ###############################

			$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt', 'w');
			fwrite($handle, $converted);
			fclose($handle);
			// ###############################  charset end

		}

		Header("Location: /admin/?mcmd=108&module=CMS_Catalog&time_mark=$time_mark&delimiter={$_POST['delimiter']}");
		exit;

	}

	################################################################################################
	# section import products PNEU 2
	################################################################################################
	case 'import_products_PNEU_duse_2':
	{
		$ch = curl_init('themes/default/');
	}
	case 'import_products_PNEU_2_duse_RUN':
	{

		$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_POST['time_mark'].'.txt', 'r');
		$array_delimiter = array('\t',';',',','§');

		$import = new ImportPneu();
		/* zistit cisla atributov */
		$brand_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"brand",$_SESSION['currentCatalog']);
		$size_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"size",$_SESSION['currentCatalog']);
		$valve_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"valve",$_SESSION['currentCatalog']);

		$rows = 0;
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
			$rows++;
		}
		fseek($handle, 0);

		$width = 0;		//	the starting width
		$percentage = 0;	//	the starting percentage
		$total_iterations = $rows;	//	the number of iterations to perform
		$width_per_iteration = 300 / $total_iterations; // how many pixels should the progress div be increased per each iteration
		$rows = 0;
		ob_start ();
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
		  if(is_array($data) )
		  {
			$rows++;
			$brand = trim($data[0]);
			$code = trim($data[1]);
			$size = trim($data[2]);
			$valve = trim($data[3]);
			$price = trim($data[4]);

			if($code)
			{
				//$picture = isset($data[4]) ? trim($data[4]) : "";
				//$notes = isset($data[5]) ? trim($data[5]) : "";

	//			$li = str_replace("-","/",trim($data[4]));

				$product_id = $import->updatePneuDuseProductData($data);
	//
				$import->updateAttribute($product_id, $brand_id, $brand);
				$import->updateAttribute($product_id, $size_id, $size);
				$import->updateAttribute($product_id, $valve_id, $valve);
	//
				$import->updatePrice($product_id, $price);
			}
			echo '<div style="width:300px;border:1px solid #ccc;position:absolute;top:200px;left:50%;margin-left:-150px"><div style="height:20px;background-color:#000;width:' . $width . 'px;"></div></div>';
			$width += $width_per_iteration;
			echo "&nbsp;";
			ob_flush();
			flush();
		  }

		}
		fclose($handle);

		echo "<script type='text/javascript'>document.location = '/admin/?mcmd=108&module=CMS_Catalog&message=".tr('Údaje boli aktualizované')."'</script>";
		//Header("Location: /admin/?mcmd=102&module=CMS_Catalog&message=".tr('Údaje boli aktualizované'));
		exit;

	}

	case 'import_products_PNEU_disky_1':
	{

		$time_mark = time();
		$tmp_file_name = $_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt';

		foreach ($_FILES as $file => $value)
			$_FILES[$file]['name'] =  $tmp_file_name;

		$upload = new CN_FileUpload();
		$upload -> setTargetDirectory($GLOBALS['tmpfiles_path']);
		$upload -> upload();

		if ($_POST['cp_src'] != 'utf-8')
		{

			// ###############################  charset start
			require_once "themes/default/scripts/charset/ConvertCharset.class";
			$C_CONVERT=new ConvertCharset();

			$file=file($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt');
			$converted="";
			for($i=0; $i<count($file); $i++){
				$line=$file[$i];
				$converted.=$C_CONVERT->Convert($file[$i], $_POST['cp_src'], "utf-8");
			}

			// ###############################

			$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt', 'w');
			fwrite($handle, $converted);
			fclose($handle);
			// ###############################  charset end

		}

		Header("Location: /admin/?mcmd=110&module=CMS_Catalog&time_mark=$time_mark&delimiter={$_POST['delimiter']}");
		exit;

	}

	################################################################################################
	# section import products PNEU 2
	################################################################################################
	case 'import_products_PNEU_disky_2':
	{
		$ch = curl_init('themes/default/');
	}
	case 'import_products_PNEU_2_disky_RUN':
	{

		$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_POST['time_mark'].'.txt', 'r');
		$array_delimiter = array('\t',';',',','§');

		$import = new ImportPneu();
		/* zistit cisla atributov */
		$brand_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"brand",$_SESSION['currentCatalog']);
		$mark_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"mark",$_SESSION['currentCatalog']);
		$model_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"model",$_SESSION['currentCatalog']);
		$size_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"size",$_SESSION['currentCatalog']);
		$roztec_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"roztec",$_SESSION['currentCatalog']);
		$ET_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"ET",$_SESSION['currentCatalog']);

		$rows = 0;
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
			$rows++;
		}
		fseek($handle, 0);

		$width = 0;		//	the starting width
		$percentage = 0;	//	the starting percentage
		$total_iterations = $rows;	//	the number of iterations to perform
		$width_per_iteration = 300 / $total_iterations; // how many pixels should the progress div be increased per each iteration
		$rows = 0;
		ob_start ();
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
		  if(is_array($data) )
		  {
			$rows++;
			$brand = trim($data[0]);
			$code = trim($data[1]);
			$mark = trim($data[2]);
			$model = trim($data[3]);
			$size = trim($data[4]);
			$roztec = trim($data[5]);
			$et = trim($data[6]);
			$price = trim($data[7]);

			if($code)
			{
				$picture = isset($data[8]) ? trim($data[8]) : "";

				$product_id = $import->updatePneuDiskyProductData($data);

				$import->updateAttribute($product_id, $brand_id, $brand);
				$import->updateAttribute($product_id, $size_id, $size);
				$import->updateAttribute($product_id, $mark_id, $mark);
				$import->updateAttribute($product_id, $model_id, $model);
				$import->updateAttribute($product_id, $roztec_id, $roztec);
				$import->updateAttribute($product_id, $ET_id, $et);

				$import->updatePrice($product_id, $price);
			}
			echo '<div style="width:300px;border:1px solid #ccc;position:absolute;top:200px;left:50%;margin-left:-150px"><div style="height:20px;background-color:#000;width:' . $width . 'px;"></div></div>';
			$width += $width_per_iteration;
			echo "&nbsp;";
			ob_flush();
			flush();
		  }

		}
		fclose($handle);

		echo "<script type='text/javascript'>document.location = '/admin/?mcmd=110&module=CMS_Catalog&message=".tr('Údaje boli aktualizované')."'</script>";
		//Header("Location: /admin/?mcmd=102&module=CMS_Catalog&message=".tr('Údaje boli aktualizované'));
		exit;

	}

	################################################################################################
	# section import products PPRESS
	################################################################################################
	case 'import_products_PPRESS_1':
	{

		$time_mark = time();
		$tmp_file_name = $_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt';

		foreach ($_FILES as $file => $value)
			$_FILES[$file]['name'] =  $tmp_file_name;

		$upload = new CN_FileUpload();
		$upload -> setTargetDirectory($GLOBALS['tmpfiles_path']);
		$upload -> upload();

		if ($_POST['cp_src'] != 'utf-8') {

			// ###############################  charset start
			require_once "themes/default/scripts/charset/ConvertCharset.class";
			$C_CONVERT=new ConvertCharset();

			$file=file($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt');
			$converted="";
			for($i=0; $i<count($file); $i++){
				$line=$file[$i];
				$converted.=$C_CONVERT->Convert($file[$i], $_POST['cp_src'], "utf-8");
			}

			// ###############################

			$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt', 'w');
			fwrite($handle, $converted);
			fclose($handle);
			// ###############################  charset end

		}

		Header("Location: /admin/?mcmd=104&module=CMS_Catalog&time_mark=$time_mark&delimiter={$_POST['delimiter']}");
		exit;

	}
	case 'import_products_PPRESS_2':
	{
		$ch = curl_init('themes/default/');
	}
	case 'import_products_PPRESS_2_RUN':
	{

		$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_POST['time_mark'].'.txt', 'r');
		$array_delimiter = array('\t',';',',','§');

		$import = new ImportPneu();
		/* zistit cisla atributov */
		$hmotnost_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"hmotnost",$_SESSION['currentCatalog']);
		$mnozstvo_karton_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"mnozstvo_karton",$_SESSION['currentCatalog']);
		$pocet_kartonov_v_rade_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"pocet_kartonov_v_rade",$_SESSION['currentCatalog']);
		$pocet_kartonov_v_palete_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"pocet_kartonov_v_palete",$_SESSION['currentCatalog']);
		$EAN_ks_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"EAN_ks",$_SESSION['currentCatalog']);
		$EAN_box_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"EAN_box",$_SESSION['currentCatalog']);
		$skupina_id = $import->getAttributeIdByName($GLOBALS['localLanguage'],"skupina",$_SESSION['currentCatalog']);


		$rows = 0;
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
			$rows++;
		}
		fseek($handle, 0);

		$width = 0;		//	the starting width
		$percentage = 0;	//	the starting percentage
		$total_iterations = $rows;	//	the number of iterations to perform
		$width_per_iteration = 300 / $total_iterations; // how many pixels should the progress div be increased per each iteration
		$rows = 0;
		ob_start ();
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
		  if(is_array($data) )
		  {
			$rows++;
			$code = trim($data[0]);
			$title = trim($data[1]);
			$skupina = trim($data[2]);
			$hmotnost = trim($data[3]);
			$mnozstvo_karton = trim($data[4]);
			$pocet_kartonov_v_rade = trim($data[5]);
			$pocet_kartonov_v_palete = trim($data[6]);
			$EAN_ks = trim($data[7]);
			$EAN_box = trim($data[8]);
			//$picture = isset($data[9]) ? trim($data[9]) : "";

			$product_id = $import->update_PPRESS_ProductData($data);

 			$import->updateAttribute($product_id, $hmotnost_id, $hmotnost);
 			$import->updateAttribute($product_id, $mnozstvo_karton_id, $mnozstvo_karton);
 			$import->updateAttribute($product_id, $pocet_kartonov_v_rade_id, $pocet_kartonov_v_rade);
 			$import->updateAttribute($product_id, $pocet_kartonov_v_palete_id, $pocet_kartonov_v_palete);
 			$import->updateAttribute($product_id, $EAN_ks_id, $EAN_ks);
 			$import->updateAttribute($product_id, $EAN_box_id, $EAN_box);
			$import->updateAttribute($product_id, $skupina_id, $skupina);
// 			$import->updatePrice($product_id, $price);

			echo '<div style="width:300px;border:1px solid #ccc;position:absolute;top:200px;left:50%;margin-left:-150px"><div style="height:20px;background-color:#000;width:' . $width . 'px;"></div></div>';
			$width += $width_per_iteration;
			echo "&nbsp;";
			ob_flush();
			flush();
		  }

		}
		fclose($handle);

		echo "<script type='text/javascript'>document.location = '/admin/?mcmd=104&module=CMS_Catalog&message=".tr('Údaje boli aktualizované')."'</script>";

		exit;

	}
	################################################################################################
	# section import products AMI
	################################################################################################
	case 'import_products_AMI_1':
	{

		$time_mark = time();
		$tmp_file_name = $_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt';

		foreach ($_FILES as $file => $value)
			$_FILES[$file]['name'] =  $tmp_file_name;

		$upload = new CN_FileUpload();
		$upload -> setTargetDirectory($GLOBALS['tmpfiles_path']);
		$upload -> upload();

		if ($_POST['cp_src'] != 'utf-8')
		{

			// ###############################  charset start
			//require_once "themes/default/scripts/charset/ConvertCharset.class";
			//$C_CONVERT=new ConvertCharset();

			$file=file($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt');
			$converted="";
			for($i=0; $i<count($file); $i++)
			{
				$line=$file[$i];
				//$converted.=$C_CONVERT->Convert($file[$i], $_POST['cp_src'], "utf-8");
				$converted.=@iconv($_POST['cp_src'],"utf-8", $file[$i]);
			}

			// ###############################

			$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt', 'w');
			fwrite($handle, $converted);
			fclose($handle);
			// ###############################  charset end

		}

		Header("Location: /admin/?mcmd=106&module=CMS_Catalog&time_mark=$time_mark&delimiter={$_POST['delimiter']}");
		exit;

	}
	case 'import_products_AMI_2':
	{
		$ch = curl_init('themes/default/');
	}
	case 'import_products_AMI_2_RUN':
	{

		$import = new ImportPneu();
		//vymazat vsetky stare data z katalogu
		echo "<br>Mažem starú databázu.";
		$import->deleteKatalogData(1);
		echo "<br>Databáza boal zmazaná!";

		$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_POST['time_mark'].'.txt', 'r');
		$array_delimiter = array('\t',';',',','§');

		$import = new ImportPneu();
		/* zistit cisla atributov */
		$cislo_skladu = 104;
		$pocet_svetel_zdrojov = 17;
		$prikon_1_zdroja = 18;
		$objimka = 16;
		$typ_zdroja = 15;
		$kategoria = 40;
		$produktovy_rad = 39;
		$krytie = 19;
		$typ_el_zar = 20;
		$dlzka_a = 22;
		$dlzka_b = 23;
		$dlzka_c = 24;
		$hmotnost = 30;

		$rows = 0;
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
			$rows++;
		}
		fseek($handle, 0);

		$width = 0;		//	the starting width
		$percentage = 0;	//	the starting percentage
		$total_iterations = $rows;	//	the number of iterations to perform
		$width_per_iteration = 300 / $total_iterations; // how many pixels should the progress div be increased per each iteration
		$rows = 0;
		ob_start ();
		$ignore_rows = 0;
		$num_row = 0;

		$old_kategoria = "--";
		$top_category = null;
		$two_level_category = null;
		$old_produktovy_rad = "--";
		echo "<br>Importujem produkty!<hr>";
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
		  if(is_array($data) )
		  {
			$num_row++;
			if($num_row <= $ignore_rows ) // ignorovat riadky
				continue;

			$rows++;

			$data_cislo_skladu 			= trim($data[3]);
			$data_pocet_svetel_zdrojov 	= trim($data[6]);
			$data_prikon_1_zdroja 		= trim($data[7]);
			$data_objimka 				= trim($data[8]);
			$data_typ_zdroja 			= trim($data[9]);
			$data_kategoria 			= trim($data[18]);
			$data_produktovy_rad 		= trim($data[19]);
			$data_krytie 				= trim($data[20]);
			$data_typ_el_zar 			= trim($data[21]);
			$data_dlzka_a 				= trim($data[24]);
			$data_dlzka_b 				= trim($data[25]);
			$data_dlzka_c 				= trim($data[26]);
			$data_hmotnost 				= trim($data[27]);

			$cena 						= trim($data[13]);
			$kod 						= trim($data[4]);
			$popis 						= trim($data[5]);
			$obrazok 					= trim($data[16]);
			$zasoby_na_sklade			= trim($data[10]);

			$product_id = $import->update_AMI_ProductData($kod,$popis,$zasoby_na_sklade,$obrazok);

			$vyhlasenie_o_zhode			= trim($data[14]);
			if(!empty($vyhlasenie_o_zhode))
				$import->updateAttachment($product_id,"Vyhlásenie o zhode",$vyhlasenie_o_zhode);

			$catalog_list				= trim($data[15]);
			if(!empty($catalog_list))
				$import->updateAttachment($product_id,"Katalógový list",$catalog_list);

			$cat_kategoria 						= trim($data[18]);
			$cat_produktovy_rad					= trim($data[19]);

			$cat_kategoria_en					= trim($data[34]);

			if($rows%100 == 0)
				echo $rows;
			echo ".";

			if($old_kategoria != $cat_kategoria)
			{
				$top_category = $import->createTOPCategory("sk",$cat_kategoria);
				$import->createTOPCategoryLang($top_category,"en",$cat_kategoria_en);// pridat en verziu
			}
			$old_kategoria = $cat_kategoria;


			if($old_produktovy_rad != $cat_produktovy_rad)
			{
				$two_level_category = $import->createCategory($top_category,"sk",$cat_kategoria, $cat_produktovy_rad);
				$import->createCategoryLang($two_level_category,"en",$cat_produktovy_rad);// pridat en verziu
			}
			$old_produktovy_rad = $cat_produktovy_rad;

			$import->addProductToCategory($product_id, $two_level_category);

 			$import->updateAttribute($product_id, $cislo_skladu, $data_cislo_skladu);
 			$import->updateAttribute($product_id, $pocet_svetel_zdrojov, $data_pocet_svetel_zdrojov);
 			$import->updateAttribute($product_id, $prikon_1_zdroja, $data_prikon_1_zdroja);
 			$import->updateAttribute($product_id, $objimka, $data_objimka);
 			$import->updateAttribute($product_id, $typ_zdroja, $data_typ_zdroja);
 			$import->updateAttribute($product_id, $kategoria, $data_kategoria,$cat_kategoria_en);
			$import->updateAttribute($product_id, $produktovy_rad, $data_produktovy_rad);
			$import->updateAttribute($product_id, $krytie, $data_krytie);
			$import->updateAttribute($product_id, $typ_el_zar, $data_typ_el_zar);
			if($data_dlzka_a>0)
				$import->updateAttribute($product_id, $dlzka_a, $data_dlzka_a);
			if($data_dlzka_b>0)
				$import->updateAttribute($product_id, $dlzka_b, $data_dlzka_b);
			if($data_dlzka_c>0)
				$import->updateAttribute($product_id, $dlzka_c, $data_dlzka_c);
			if($data_hmotnost>0)
				$import->updateAttribute($product_id, $hmotnost, $data_hmotnost);

			if($cena > 0)
				$import->updatePrice($product_id, $cena);

			echo '<div style="width:300px;border:1px solid #ccc;position:absolute;top:200px;left:50%;margin-left:-150px"><div style="height:20px;background-color:#000;width:' . $width . 'px;"></div></div>';
			$width += $width_per_iteration;
			echo "&nbsp;";
			ob_flush();
			flush();
		  }

		}
		fclose($handle);
		$import->optimizeKatalogData();
		echo tr('<hr>Údaje boli aktualizované');
		echo "<script type='text/javascript'>document.location = '/admin/?mcmd=106&module=CMS_Catalog&message=".tr('Údaje boli aktualizované')."'</script>";

		exit;

	}

	################################################################################################
	# section import products REWAN
	################################################################################################
	case 'import_products_REWAN_1':
	{

		$time_mark = time();
		$tmp_file_name = $_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt';

		foreach ($_FILES as $file => $value)
			$_FILES[$file]['name'] =  $tmp_file_name;

		$upload = new CN_FileUpload();
		$upload -> setTargetDirectory($GLOBALS['tmpfiles_path']);
		$upload -> upload();

		if ($_POST['cp_src'] != 'utf-8')
		{

			// ###############################  charset start
			//require_once "themes/default/scripts/charset/ConvertCharset.class";
			//$C_CONVERT=new ConvertCharset();

			$file=file($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt');
			$converted="";
			for($i=0; $i<count($file); $i++)
			{
				$line=$file[$i];
				//$converted.=$C_CONVERT->Convert($file[$i], $_POST['cp_src'], "utf-8");
				$converted.=@iconv($_POST['cp_src'],"utf-8", $file[$i]);
			}

			// ###############################

			$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$time_mark.'.txt', 'w');
			fwrite($handle, $converted);
			fclose($handle);
			// ###############################  charset end

		}

		Header("Location: /admin/?mcmd=112&module=CMS_Catalog&time_mark=$time_mark&delimiter={$_POST['delimiter']}");
		exit;

	}
	case 'import_products_REWAN_2':
	{
		$ch = curl_init('themes/default/');
	}
	case 'import_products_REWAN_2_RUN':
	{

		$import = new ImportPneu();
		//vymazat vsetky stare data z katalogu
		//echo "<br>Mažem starú databázu.";
		
		//$import->deleteKatalogData(1);
		
		#TODO: urobit mazanie na kategoriu
		
		//echo "<br>Databáza bola zmazaná!";

		$handle = fopen($GLOBALS['tmpfiles_path'].'/'.$_SESSION['user']['name'].'_import_products_'.$_POST['time_mark'].'.txt', 'r');
		$array_delimiter = array('\t',';',',','§');

		$import = new ImportPneu();
		/* zistit cisla atributov */
		$typ_vlakna = $import->getAttributeIdByName($GLOBALS['localLanguage'],"Typ vlákna",$_SESSION['currentCatalog']); //82;
		$pocet_vlakien = $import->getAttributeIdByName($GLOBALS['localLanguage'],"Počet vlákien",$_SESSION['currentCatalog']); //83;
		$vonkajsi_plast = $import->getAttributeIdByName($GLOBALS['localLanguage'],"Vonkajší plášť",$_SESSION['currentCatalog']); //89;
		$pocet_bufferov = $import->getAttributeIdByName($GLOBALS['localLanguage'],"Počet buferov",$_SESSION['currentCatalog']); //84;
		$pocet_vlakien_v_bufferi = $import->getAttributeIdByName($GLOBALS['localLanguage'],"Počet vlákien v buferi",$_SESSION['currentCatalog']); //85;
		$typ_konstrukcie = $import->getAttributeIdByName($GLOBALS['localLanguage'],"Typ konštrukcie",$_SESSION['currentCatalog']); //87;
		$balenie = $import->getAttributeIdByName($GLOBALS['localLanguage'],"Balenie",$_SESSION['currentCatalog']); //90;
		
		$rows = 0;
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
			$rows++;
		}
		fseek($handle, 0);
		

		$width = 0;		//	the starting width
		$percentage = 0;	//	the starting percentage
		$total_iterations = $rows;	//	the number of iterations to perform
		$width_per_iteration = 300 / $total_iterations; // how many pixels should the progress div be increased per each iteration
		$rows = 0;
		ob_start ();
		$ignore_rows = 0;
		$num_row = 0;

		$old_kategoria = "--";
		$top_category = null;
		$category_id = null;
		$old_produktovy_rad = "--";
		echo "<br>Importujem produkty!<hr>";
		while(($data = fgetcsv($handle, 1000, $array_delimiter[$_POST['delimiter']])) !== false)
		{
		  if(is_array($data) )
		  {
			$num_row++;
			if($num_row <= $ignore_rows ) // ignorovat riadky
				continue;

			$rows++;

			$data_balenie 		= trim($data[6]);
			$data_typ_vlakna 	= trim($data[7]);
			$data_pocet_vlakien	= trim($data[8]);
			$data_vonkajsi_plast= trim($data[9]);
			$data_pocet_bufferov= trim($data[10]);
			$data_pocet_vlakien_v_bufferi = trim($data[11]);
			$data_typ_konstrukcie = trim($data[12]);

			$cena 		= trim($data[4]);
			$kod 		= trim($data[0]);
			$popis 		= trim($data[1]);
			$popis2		= trim($data[3]);
			$obrazok 	= trim($data[6]);
			$nazov		= trim($data[2]);

			$product_id = $import->update_REWAN_ProductData($kod, $nazov, $popis, $popis2, $obrazok);


			$cat_kategoria = trim($data[5]);

			if($rows%100 == 0)
				echo $rows;
			echo ".";
			
			if($old_kategoria != $cat_kategoria)
			{
				$category_id = $import->getCategoryIdByName("sk",$cat_kategoria);
				//$import->createTOPCategoryLang($top_category,"en",$cat_kategoria_en);// pridat en verziu
			}
			$old_kategoria = $cat_kategoria;

			if( $category_id )
				$import->addProductToCategory($product_id, $category_id);

			if( strlen($data_balenie) > 0 )
				$import->updateAttribute($product_id, $balenie, $data_balenie);
			if( strlen($data_typ_vlakna) > 0 )
				$import->updateAttribute($product_id, $typ_vlakna, $data_typ_vlakna);
 			$import->updateAttribute($product_id, $pocet_vlakien, $data_pocet_vlakien);
 			$import->updateAttribute($product_id, $vonkajsi_plast, $data_vonkajsi_plast);
 			$import->updateAttribute($product_id, $pocet_bufferov, $data_pocet_bufferov);
 			$import->updateAttribute($product_id, $pocet_vlakien_v_bufferi, $data_pocet_vlakien_v_bufferi);
			$import->updateAttribute($product_id, $typ_konstrukcie, $data_typ_konstrukcie);

			if($cena > 0)
				$import->updatePrice($product_id, $cena);

			echo '<div style="width:300px;border:1px solid #ccc;position:absolute;top:200px;left:50%;margin-left:-150px"><div style="height:20px;background-color:#000;width:' . $width . 'px;"></div></div>';
			$width += $width_per_iteration;
			echo "&nbsp;";
			ob_flush();
			flush();
		  }

		}
		fclose($handle);
		$import->optimizeKatalogData();
		echo tr('<hr>Údaje boli aktualizované');
		echo "<script type='text/javascript'>document.location = '/admin/?mcmd=111&module=CMS_Catalog&message=".tr('Údaje boli aktualizované')."'</script>";

		exit;

	}
		default:
		; // throw;
}


	if(isset($_POST['goAjax']) &&  $_POST['goAjax']== 1)
	{

		switch($_REQUEST['section'])
		{
			// sort branches in catalog
			case 'sort_items':
			{
				$entity = null;
				if($_POST["entity_type"] == CMS_Catalog::ENTITY_ID)
					$entity = new CMS_Catalog($_POST["entity_id"]);

				if(!is_null($entity))
				{
					$sort_table = new CMS_SortTable();
					$sort_table->setParentEntity($entity);

					if($_POST["entity_type"] == CMS_Catalog::ENTITY_ID)
						$sortHandler = new SortCatalogBranchesSaveHandler();

					$sort_table->setSaveHandler($sortHandler);
					foreach ( $_POST["item"] as $item )
					{
						list($sub_entity_type,$sub_entity_id) = explode("_",$item);
						$sort_item = new CMS_SortTable_Item();

						if($sub_entity_type == CMS_Catalog_Branch::ENTITY_ID)
							$sort_item->data = new CMS_Catalog_Branch($sub_entity_id);

						if(!is_null($sort_item->data))
							$sort_table->addItem($sort_item);
					}
					$sort_table->save();
				}
				exit;
			}

			// sort branches in branch
			case 'sort_items_branch':
			{
				$entity = null;
				if($_POST["entity_type"] == CMS_Catalog_Branch::ENTITY_ID)
					$entity = new CMS_Catalog_Branch($_POST["entity_id"]);

				if(!is_null($entity))
				{
					$sort_table = new CMS_SortTable();
					$sort_table->setParentEntity($entity);

					if($_POST["entity_type"] == CMS_Catalog_Branch::ENTITY_ID)
						$sortHandler = new SortCatalogBranchesToBranchSaveHandler();

					$sort_table->setSaveHandler($sortHandler);
					foreach ( $_POST["item"] as $item )
					{
						list($sub_entity_type,$sub_entity_id) = explode("_",$item);
						$sort_item = new CMS_SortTable_Item();

						if($sub_entity_type == CMS_Catalog_Branch::ENTITY_ID)
							$sort_item->data = new CMS_Catalog_Branch($sub_entity_id);

						if(!is_null($sort_item->data))
							$sort_table->addItem($sort_item);
					}
					$sort_table->save();
				}
				exit;
			}

			// sort products in branch
			case 'sort_items_product':
			{
				$entity = null;
				if($_POST["entity_type"] == CMS_Catalog_Branch::ENTITY_ID)
					$entity = new CMS_Catalog_Branch($_POST["entity_id"]);

				if(!is_null($entity))
				{
					$sort_table = new CMS_SortTable();
					$sort_table->setParentEntity($entity);

					if($_POST["entity_type"] == CMS_Catalog_Branch::ENTITY_ID)
						$sortHandler = new SortCatalogProductsToBranchSaveHandler();

					$sort_table->setSaveHandler($sortHandler);
					foreach ( $_POST["item"] as $item )
					{
						list($sub_entity_type,$sub_entity_id) = explode("_",$item);
						$sort_item = new CMS_SortTable_Item();

						if($sub_entity_type == CMS_Catalog_Product::ENTITY_ID)
							$sort_item->data = new CMS_Catalog_Product($sub_entity_id);

						if(!is_null($sort_item->data))
							$sort_table->addItem($sort_item);
					}
					$sort_table->save();
				}
				exit;
			}


		}

	}
	############################################################################################################

}
catch(CN_Exception $e){
	echo $e->displayDetails();
}
?>
