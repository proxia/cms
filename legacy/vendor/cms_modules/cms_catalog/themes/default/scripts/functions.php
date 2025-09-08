<?php
function insert_getOptionsFromXml ($input){

	$path = $input['path'];
	$language = $input['language'];
	$select = $input['select'];

	$s = CMS_Job_Data::getSingleton();
	$s->load($path);

	$aa = $s->getAllSections($language=null);
	$a = $s->getAllSubsections(1, $language=sk);

	$vrat = 0;
	foreach ($aa as $value=> $x){

		$vrat .=  "<option value=\"$value\"";

		if ($value == $select)
			$vrat .=  " selected=\"selected\" ";

		$vrat .= ">$x</option>";

		$c = $s->getAllSubsections($value, $language=sk);

		foreach ($c as $val => $n){

			$vrat .=  "<option value=\"$val\"";

			if ($val == $select)
				$vrat .=  " selected=\"selected\" ";

			$vrat .=  ">&nbsp;&nbsp;&nbsp;$n</option>";

		}
	}

	return $vrat;
}

function insert_getNamefromXml ($input){

	$path = $input['path'];
	$language = $input['language'];
	$id = $input['id'];

	$s = CMS_Job_Data::getSingleton();
	$s->load($path);
	$a = $s->getSectionNameById($id, $language);
	echo $a;

}

function insert_getCompanyInfo($input){

	$module_comp = CMS_Module::addModule('cms_company');
	$module_comp->utilise();

	$company = new CMS_Company($input['id']);
	$company->execute();
	$link = "get".$input['pole'];
	echo $company->$link();

}

function insert_getUserDetailInfo($input){

	$company = new CMS_User($input['id']);
	$company->execute();
	$link = "get".$input['pole'];
	echo $company->$link();

}

function insert_getMapId($input){

	$product = new CMS_Catalog_Product($input['productId']);
	$attribut_product_list = $product->getAttributes();

	foreach ($attribut_product_list as $value){
		if ($value->getAttributeDefinitionId() == $input['attributId'])
			return $value->getId();
	}
	return 0;
}


function insert_getAttributValue($input){

	$product = new CMS_Catalog_Product($input['productId']);
	$attribut_product_list = $product->getAttributes();

	foreach ($attribut_product_list as $value){
		if ($value->getAttributeDefinitionId() == $input['attributId'])
			return $value->getValue();
	}
	return "";
}

function insert_getExistsAttribut($input){
	if(isset($input['productId'])){
		$product = new CMS_Catalog_Product($input['productId']);
		$attribut_product_list = $product->attributeExists(new CMS_Catalog_AttributeDefinition($input['attributId']));
		return $attribut_product_list;

	}else if(isset($input['branchId'])){
		$branch = new CMS_Catalog_Branch($input['branchId']);
		$attribut_branch_list = $branch->attributeExists(new CMS_Catalog_AttributeDefinition($input['attributId']));
		return $attribut_branch_list;

	}else if(isset($input['groupId'])){
		$group = new CMS_Catalog_AttributeGroup($input['groupId']);
		$attribut_group_bool = $group->attributeExists(new CMS_Catalog_AttributeDefinition($input['attributId']));
		return $attribut_group_bool;
	}


}

function insert_getOptionListBranch($zdroj){

	$space = "&nbsp;&nbsp;&nbsp;&nbsp;";

	for ($f = 0; $f <  $zdroj['uroven']; $f++)
		$odstup .= $space;

	if ($zdroj['catalog']){
		$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
		$branch_list = $catalog->getChildren();

		$num_maxforeach = 0;
		foreach($branch_list as $value){
			$num_maxforeach++;
		}

		$num_foreach = 0;
		foreach($branch_list as $value){
			$num_foreach++;
			$value->setContextLanguage($GLOBALS['localLanguage']);
			$defaultView = 0;
			if ($value->getTitle() == ''){
				$value->setContextLanguage($GLOBALS['localLanguageDefault']);
				$defaultView = 1;
			}

			if($defaultView == 1)
				$branch_title = $GLOBALS['defaultViewStartTag'].$value->getTitle().$GLOBALS['defaultViewEndTag'];
			else
				$branch_title = $value->getTitle();

			$branch_id = $value->getId();


			$num_children = 1;

			if (($zdroj['type']=='noend') || ($zdroj['type']=='end')){
				// test na nezobrazenie poslednej urovne kategorii

				$branch_last = new CMS_Catalog_branch($branch_id);
				$branch_list_last = $branch_last->getChildren();
				$num_children = $branch_list_last->getSize();
			}


			if ( $zdroj['zakaz'] != $branch_id ) {

				$disabled="";

				if ($zdroj['type']=='noend'){
					$disabled="";
					if ($num_children == 0)
						$disabled = 'disabled="disabled" style="color:#999; background:white;"';
				}

				if ($zdroj['type']=='end'){
					$disabled="";
					if ($num_children > 0)
						$disabled = 'disabled="disabled" style="color:#999; background:white;"';
				}

				if ($zdroj['unselect'] == $branch_id)
					$disabled = 'disabled="disabled" style="color:#999; background:white;"';

				echo "<option $disabled value=\"$branch_id\"";
					if($branch_id == $zdroj['select'])echo" selected=\"selected\" ";
				echo ">$odstup$branch_title</option>";

				$send['adr'] = $branch_id;
				$send['uroven'] = $zdroj['uroven'] + 1;
				$send['select'] = $zdroj['select'];
				$send['unselect'] = $zdroj['unselect'];
				$send['zakaz'] = $zdroj['zakaz'];
				$send['type'] = $zdroj['type'];
				$send['catalog'] = null;
				insert_getOptionListBranch($send);

			}
		}
	}
	elseif ($zdroj['adr']){
		$branch = new CMS_Catalog_branch($zdroj['adr']);
		$branch_list = $branch->getChildren();
		foreach($branch_list as $value){
			$value->setContextLanguage($GLOBALS['localLanguage']);
			$defaultView = 0;
			if ($value->getTitle() == ''){
				$value->setContextLanguage($GLOBALS['localLanguageDefault']);
				$defaultView = 1;
			}

			if($defaultView == 1)
				$branch_title = $GLOBALS['defaultViewStartTag'].$value->getTitle().$GLOBALS['defaultViewEndTag'];
			else
				$branch_title = $value->getTitle();

			$branch_id = $value->getId();

			$num_children = 1;

			if (($zdroj['type']=='noend') || ($zdroj['type']=='end')){
				// test na nezobrazenie poslednej urovne kategorii

				$branch_last = new CMS_Catalog_branch($branch_id);
				$branch_list_last = $branch_last->getChildren();
				$num_children = $branch_list_last->getSize();
			}

			if ( $zdroj['zakaz'] != $branch_id ) {

				$disabled="";

				if ($zdroj['type']=='noend'){
					$disabled="";
					if ($num_children == 0)
						$disabled = 'disabled="disabled" style="color:#999; background:white;"';
				}

				if ($zdroj['type']=='end'){
					$disabled="";
					if ($num_children > 0)
						$disabled = 'disabled="disabled" style="color:#999; background:white;"';
				}

				if ($zdroj['unselect'] == $branch_id)
					$disabled = 'disabled="disabled" style="color:#999; background:white;"';

				echo "<option $disabled value=\"$branch_id\"";
					if($branch_id == $zdroj['select'])echo" selected=\"selected\" ";
				echo ">$odstup$branch_title</option>";

				$send['adr'] = $branch_id;
				$send['uroven'] = $zdroj['uroven'] + 1;
				$send['select'] = $zdroj['select'];
				$send['unselect'] = $zdroj['unselect'];
				$send['zakaz'] = $zdroj['zakaz'];
				$send['type'] = $zdroj['type'];
				$send['catalog'] = null;
				insert_getOptionListBranch($send);

			}

		}
	}

}

function getBranchListCascade($zdroj,& $countRows,& $countRowsAll){
	static $output;

	$countRows++;
	$send['valid_range_from'] = $zdroj['valid_range_from'];
	$send['valid_range_to'] = $zdroj['valid_range_to'];

	if ($zdroj['catalog']){
		$catalog = new CMS_Catalog($_SESSION['currentCatalog']);
		$branch_list = $catalog->getChildren();

		$num_maxforeach = $branch_list->getSize();
// 		$num_maxforeach = 0;
// 		foreach($branch_list as $value){
// 			$num_maxforeach++;
// 		}

		$num_foreach = 0;
		foreach($branch_list as $value){
			$countRowsAll++;
			$num_foreach++;
			$value->setContextLanguage($GLOBALS['localLanguage']);
			$defaultView = 0;
			if ($value->getTitle() == ''){
				$value->setContextLanguage($GLOBALS['localLanguageDefault']);
				$defaultView = 1;
			}

			if($defaultView == 1)
				$branch_title = $GLOBALS['defaultViewStartTag'].$value->getTitle().$GLOBALS['defaultViewEndTag'];
			else
				$branch_title = $value->getTitle();

			$branch_id = $value->getId();

			if($num_foreach == 1)
				$order = 'first';

			if (($num_foreach > 1) && ($num_foreach < $num_maxforeach))
				$order = 'middle';

			if ($num_foreach == $num_maxforeach)
				$order = 'end';

			if( $countRows <= $send['valid_range_from'] )
				;
			else if($countRows > $send['valid_range_to'])
				;
			else{

				$output[$branch_id]['object']["id"] = $value->getId();
				$output[$branch_id]['object']["title"] = $value->getTitle();
				$output[$branch_id]['object']["language_is_visible"] = $value->getLanguageIsVisible();
				$output[$branch_id]['object']["is_published"] = $value->getIsPublished();
				$output[$branch_id]['uroven'] = $zdroj['uroven'];
				$output[$branch_id]['order'] = $order;
			}
			//	echo "<br>riadok:".$countRows." cislo:".$branch_id;
			$send['adr'] = $branch_id;
			$send['uroven'] = $zdroj['uroven'] + 1;
			$send['select'] = $zdroj['select'];
			$send['zakaz'] = $zdroj['zakaz'];
			$send['catalog'] = null;
			getBranchListCascade($send,$countRows,$countRowsAll);

		}
	}
	elseif ($zdroj['adr']){

		$branch = new CMS_Catalog_branch($zdroj['adr']);

		//$branch_list = $branch->getChildren();
		$branch_list = $branch->getChildrenArray($GLOBALS['localLanguage']);

		$num_maxforeach2 = count($branch_list);

		$num_foreach2 = 0;
		foreach($branch_list as $value){
			$countRowsAll++;
			$num_foreach2++;
			$defaultView = 0;
			if ($value["title"] == ''){
				$value["title"] = "...".$value["id"]."...";
				$defaultView = 1;
			}

			if($defaultView == 1)
				$branch_title = $GLOBALS['defaultViewStartTag'].$value["title"].$GLOBALS['defaultViewEndTag'];
			else
				$branch_title = $value["title"];

			$branch_id = $value["id"];

			if($num_foreach2 == 1)
				$order = 'first';

			if (($num_foreach2 > 1) && ($num_foreach2 < $num_maxforeach2))
				$order = 'middle';

			if ($num_foreach2 == $num_maxforeach2)
				$order = 'end';


			if( $countRows <= $send['valid_range_from'] )
				;
			else if($countRows > $send['valid_range_to'])
				;
			else{
				$output[$branch_id]['object']["id"] = $value["id"];
				$output[$branch_id]['object']["title"] = $value["title"];
				$output[$branch_id]['object']["language_is_visible"] = $value["language_is_visible"];
				$output[$branch_id]['object']["is_published"] = $value["is_published"];

				$output[$branch_id]['uroven'] = $zdroj['uroven'];
				$output[$branch_id]['order'] = $order;
			}
			//	echo "<br>riadokk:".$countRows." cislo:".$branch_id." all:".$countRowsAll;
			$send['adr'] = $branch_id;
			$send['uroven'] = $zdroj['uroven'] + 1;
			$send['select'] = $zdroj['select'];
			$send['zakaz'] = $zdroj['zakaz'];
			$send['catalog'] = null;
			getBranchListCascade($send,$countRows,$countRowsAll);


		}
	}

	return $output;
}

function insert_getNumChild($input){
	$type = $input['type'];
	$id = $input['id'];

	if ($type == 'branch'){

		$branch = new CMS_Catalog_Branch($id);
		$branch_list = $branch->getChildren();
		return $branch_list->getSize();

	}

	if ($type == 'product'){

		$branch = new CMS_Catalog_Branch($id);
		$product_list = $branch->getItems(CMS_Catalog_Product::ENTITY_ID);
		return $product_list->getSize();

	}
}

function insert_getBranchProducts($input){
	$branch = new CMS_Catalog_Branch($input['id']);
	$product_list = $branch->getItems(CMS_Catalog_Product::ENTITY_ID, false);
	return $product_list;
}

function insert_getProductAttributes($input){
	$product = new CMS_Catalog_Product($input['id']);

	$attribut_product_list = $product->getAttributes();

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

	return $attribut_product_list;
}

function insert_getPrice($input){
	$currency = isset($input['currency']) ? "'".$input['currency']."'" : "'EUR'";
	$access = $input['access'];
	$product = new CMS_Catalog_Product($input['id']);
	$price_list = $product->getPriceList(null,null,true,$currency,$access);
	foreach ($price_list as $price_id){
		$return['id'] = $price_id->getId();
		$return['price'] = $price_id->getPrice();
		return $return;
	}

}

function insert_getAvailableCurrencies(){
	return $GLOBALS['project_config']->getAvailableCurrencies();
}

function insert_getSelectedGroup($input){
	$accessGroups = $input["groups"];
	if($accessGroups==null)
		return "";
	$accessGroups = unserialize($accessGroups);
	$listGroups = "";
	foreach($accessGroups as $key => $value){
		$group = new CMS_Group($value);
		$group->setContextLanguage($GLOBALS['localLanguage']);
		$listGroups .=$group->getTitle().", ";
	}
	return $listGroups;
}

function insert_initialize_array_pager_vars($input){

	$start = $_GET['start'] ? $_GET['start']:0;
	$celkomRiadkov = $GLOBALS['countAllRows'];
	$perpage = $GLOBALS["perpage"]?$GLOBALS["perpage"]:20;
	$firstStart = 0;
	$size = $GLOBALS['countRows'];
	$nextStart = $start + $perpage;
	$previousStart = ($start - $perpage);
	$previousStart = $previousStart < 0 ? 0 : $previousStart;
	$lastStart = floor($celkomRiadkov/$perpage)*$perpage;
	$pageCount = floor($celkomRiadkov/$perpage) + 1;
	$currentPage = $start/$perpage + 1;


	$GLOBALS["smarty"]->assign("start",$start);
	$GLOBALS["smarty"]->assign("p_firstStart",$firstStart);
	$GLOBALS["smarty"]->assign("p_lastStart",$lastStart);
	$GLOBALS["smarty"]->assign("p_nextStart",$nextStart);
	$GLOBALS["smarty"]->assign("p_previousStart",$previousStart);
	$GLOBALS["smarty"]->assign("p_pageCount",$pageCount);
	$GLOBALS["smarty"]->assign("p_currentPage",$currentPage);
	$GLOBALS["smarty"]->assign("p_size",$size);
	$GLOBALS["smarty"]->assign("perpage",$perpage);
	$GLOBALS["smarty"]->assign("p_totalRecordCount",$celkomRiadkov);
}

?>
