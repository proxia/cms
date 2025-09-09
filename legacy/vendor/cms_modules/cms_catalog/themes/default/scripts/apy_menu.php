<?php

try{
require("../cms_classes/apycom_menu.php");

$st = new Apycom_ItemStyle('item_1');

$st->setOption('itemBackColor', '#dfdfdf,#ededed');
$st->setOption('fontStyle', 'normal 11px Verdana');
$st->setOption('fontColor', '#000000,#000000');
$st->setOption('fontDecoration', 'none,none');
//$st->setOption('CSS', 'apymenu_item');

$st_lang = new Apycom_ItemStyle('item_2');

$st_lang->setOption('itemBackColor', '#FDF4F4,#FBE6E6');
$st_lang->setOption('fontStyle', 'normal 11px Verdana');
$st_lang->setOption('fontColor', '#000000,#000000');
$st_lang->setOption('fontDecoration', 'none,none');

$st_lang2 = new Apycom_ItemStyle('item_3');

$st_lang2->setOption('itemBackColor', '#F3B6B6,#F3B6B6');
$st_lang2->setOption('fontStyle', 'normal 11px Verdana');
$st_lang2->setOption('fontColor', '#000000,#000000');
$st_lang2->setOption('fontDecoration', 'none,none');

$st_lang3 = new Apycom_ItemStyle('item_4');
$st_lang3->setOption('itemBackColor', '#ffe09f,#ffcc66');
$st_lang3->setOption('fontStyle', 'normal 11px Verdana');
$st_lang3->setOption('fontColor', '#000000,#000000');
$st_lang3->setOption('fontDecoration', 'none,none');
	
$mst = new Apycom_MenuStyle('menu_top');
$mst->setOption('menuBackColor', '#000000');
$mst->setOption('menuBorderStyle', 'solid');
$mst->setOption('menuBorderColor', '#000000');

/***********/

$m = new Apycom_Menu();
$m->setAlignment(Apycom_Menu::ALIGNMENT_HORIZONTAL);
$m->setFontColorNormal("ff0000");
$m->setBackgroundColor("#B12C27");
$m->setMainArrowImageNormal("themes/default/images/arrowdn.gif");
$m->setMainArrowImageHover("themes/default/images/arrowdn.gif");
$m->setSubImageArrowNormal("themes/default/images/arrow.gif");
$m->setSubImageArrowHover("themes/default/images/arrow.gif");
$m->setIconWidth(16);
$m->setIconHeight(16);
$m->setIconTopWidth(16);
$m->setIconTopHeight(16);
$m->setArrowWidth(7);
$m->setArrowHeight(7);
$m->setItemPadding(2);
$m->setItemSpacing(1);
$m->registerItemStyle($st);
$m->registerItemStyle($st_lang);
$m->registerItemStyle($st_lang2);
$m->registerItemStyle($st_lang3);
$m->registerMenuStyle($mst);
$m->setTransition(5);
/***************************************************************************************
	ITEM START
***************************************************************************************/
$i1 = new Apycom_MenuItem();
$i1->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Katalógy").'&nbsp;&nbsp;&nbsp;');
$i1->setItemStyle('item_3');
$i1->setNormalIcon($GLOBALS['path_relative'].'themes/default/images/catalog_s.gif');
			
$i16 = new Apycom_MenuItem();
$i16->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Zoznam katalógov").'&nbsp;&nbsp;&nbsp;');

$i16->setItemStyle('item_2');
$i16->setItemStyle('item_2');
$i16->setLink('./?module=CMS_Catalog');

$i1->addChildItem($i16);


$i18 = new Apycom_MenuItem();
$i18->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Moduly").'&nbsp;&nbsp;&nbsp;');
$i18->setNormalIcon($GLOBALS['path_relative'].'themes/default/images/moduly_s.gif');
$i18->setItemStyle('item_2');

$i19 = new Apycom_MenuItem();
$i19->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Gallery").'&nbsp;&nbsp;&nbsp;');
$i19->setItemStyle('item_2');
$i19->setItemStyle('item_2');
$i19->setLink('./?module=CMS_Gallery');

if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Gallery')){
		$i18->addChildItem($i19);	
		}


if (isset($_SESSION['currentCatalog'])){

	$i2 = new Apycom_MenuItem();
	$i2->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Kategórie").'&nbsp;&nbsp;&nbsp;');
		$i2->setNormalIcon($GLOBALS['path_relative'].'themes/default/images/category_s.gif');
	$i2->setItemStyle('item_2');
	if (isset($_SESSION['currentCatalog'])){
		$i2->setItemStyle('item_2');
		//$i2->setLink('./?module=CMS_Catalog&mcmd=4');
	}
	else
		$i2->setItemStyle('item_2_off');
	
	
	$i6 = new Apycom_MenuItem();
	$i6->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Zoznam kategórií").'&nbsp;&nbsp;&nbsp;');
	
	$i6->setItemStyle('item_2');
	if (isset($_SESSION['currentCatalog'])){
		$i6->setItemStyle('item_2');
		$i6->setLink('./?module=CMS_Catalog&mcmd=4');
	}
	else
		$i6->setItemStyle('item_2_off');
		
	$i2->addChildItem($i6);
	
	
	$i7 = new Apycom_MenuItem();
	$i7->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Strom kategórií").'&nbsp;&nbsp;&nbsp;');
	
	$i7->setItemStyle('item_2');
	if (isset($_SESSION['currentCatalog'])){
		$i7->setItemStyle('item_2');
		$i7->setLink('./?module=CMS_Catalog&mcmd=18');
	}
	else
		$i7->setItemStyle('item_2_off');
		
	$i2->addChildItem($i7);
	
	
	
	
	$i8 = new Apycom_MenuItem();
	$i8->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Viditeľnosť kategórií").'&nbsp;&nbsp;&nbsp;');
	
	$i8->setItemStyle('item_2');
	if (isset($_SESSION['currentCatalog'])){
		$i8->setItemStyle('item_2');
		$i8->setLink('./?module=CMS_Catalog&mcmd=19');
	}
	else
		$i8->setItemStyle('item_2_off');
		
	$i2->addChildItem($i8);
	
	
	
	
	
	$i3 = new Apycom_MenuItem();
	$i3->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Produkty").'&nbsp;&nbsp;&nbsp;');
	$i3->setNormalIcon('themes/default/images/product_s.gif');	
	if (isset($_SESSION['currentCatalog'])){
		$i3->setItemStyle('item_2');
	}
	else
		$i3->setItemStyle('item_2_off');
	
	
	
	$i9 = new Apycom_MenuItem();
	$i9->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Zoznam produktov").'&nbsp;&nbsp;&nbsp;');
	
	$i9->setItemStyle('item_2');
	if (isset($_SESSION['currentCatalog'])){
		$i9->setItemStyle('item_2');
		$i9->setLink('./?module=CMS_Catalog&mcmd=10');
	}
	else
		$i->setItemStyle('item_2_off');
		
	$i3->addChildItem($i9);
	
	$i10 = new Apycom_MenuItem();
	$i10->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Nastavenia").'&nbsp;&nbsp;&nbsp;');
	
	$i10->setItemStyle('item_2');
	if (isset($_SESSION['currentCatalog'])){
		$i10->setItemStyle('item_2');
		$i10->setLink('./?module=CMS_Catalog&mcmd=10');
	}
	else
		$i->setItemStyle('item_2_off');
		
	$i3->addChildItem($i10);
	
	
	$i11 = new Apycom_MenuItem();
	$i11->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Viditeľnosť").'&nbsp;&nbsp;&nbsp;');
	
	$i11->setItemStyle('item_2');
	if (isset($_SESSION['currentCatalog'])){
		$i11->setItemStyle('item_2');
		$i11->setLink('./?module=CMS_Catalog&mcmd=17&setup_type=visibility');
	}
	else
		$i11->setItemStyle('item_2_off');
		
	$i10->addChildItem($i11);
	
	
	$i12 = new Apycom_MenuItem();
	$i12->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Platnosť").'&nbsp;&nbsp;&nbsp;');
	
	$i12->setItemStyle('item_2');
	if (isset($_SESSION['currentCatalog'])){
		$i12->setItemStyle('item_2');
		$i12->setLink('./?module=CMS_Catalog&mcmd=17&setup_type=valid');
	}
	else
		$i12->setItemStyle('item_2_off');
		
	$i10->addChildItem($i12);
	
	$i13 = new Apycom_MenuItem();
	$i13->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Obrázok").'&nbsp;&nbsp;&nbsp;');
	
	$i13->setItemStyle('item_2');
	if (isset($_SESSION['currentCatalog'])){
		$i13->setItemStyle('item_2');
		$i13->setLink('./?module=CMS_Catalog&mcmd=17&setup_type=image');
	}
	else
		$i13->setItemStyle('item_2_off');
		
	$i10->addChildItem($i13);
	
	
	$i14 = new Apycom_MenuItem();
	$i14->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Zobrazovacie práva").'&nbsp;&nbsp;&nbsp;');
	
	$i14->setItemStyle('item_2');
	if (isset($_SESSION['currentCatalog'])){
		$i14->setItemStyle('item_2');
		$i14->setLink('./?module=CMS_Catalog&mcmd=17&setup_type=access');
	}
	else
		$i14->setItemStyle('item_2_off');
		
	$i10->addChildItem($i14);
	
	
	
	$i15 = new Apycom_MenuItem();
	$i15->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Ceny").'&nbsp;&nbsp;&nbsp;');
	
	$i15->setItemStyle('item_2');
	if (isset($_SESSION['currentCatalog'])){
		$i15->setItemStyle('item_2');
		$i15->setLink('./?module=CMS_Catalog&mcmd=17&setup_type=price');
	}
	else
		$i15->setItemStyle('item_2_off');
		
	$i10->addChildItem($i15);
	
	
	$i16 = new Apycom_MenuItem();
	$i16->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Novinky").'&nbsp;&nbsp;&nbsp;');
	
	$i16->setItemStyle('item_2');
	if (isset($_SESSION['currentCatalog'])){
		$i16->setItemStyle('item_2');
		$i16->setLink('./?module=CMS_Catalog&mcmd=17&setup_type=news');
	}
	else
		$i16->setItemStyle('item_2_off');
		
	$i10->addChildItem($i16);	
	
	$i4 = new Apycom_MenuItem();
	$i4->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Atribúty").'&nbsp;&nbsp;&nbsp;');
	$i4->setNormalIcon($GLOBALS['path_relative'].'themes/default/images/attribute_s.gif');	
	if (isset($_SESSION['currentCatalog'])){
		$i4->setLink('./?module=CMS_Catalog&mcmd=7');
		$i4->setItemStyle('item_2');
	}
	else
		$i4->setItemStyle('item_2_off');


	$i17 = new Apycom_MenuItem();
	$i17->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Atribúty").'&nbsp;&nbsp;&nbsp;');
//	$i17->setNormalIcon($GLOBALS['path_relative'].'themes/default/images/attribute_s.gif');	
	if (isset($_SESSION['currentCatalog'])){
		$i17->setLink('./?module=CMS_Catalog&mcmd=7');
		$i17->setItemStyle('item_2');
	}
	else
		$i17->setItemStyle('item_2_off');
	
	$i4->addChildItem($i17);		

	$i21 = new Apycom_MenuItem();
	$i21->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Skupiny atribútov").'&nbsp;&nbsp;&nbsp;');
//	$i17->setNormalIcon($GLOBALS['path_relative'].'themes/default/images/attribute_s.gif');	
	if (isset($_SESSION['currentCatalog'])){
		$i21->setLink('./?module=CMS_Catalog&mcmd=23');
		$i21->setItemStyle('item_2');
	}
	else
		$i21->setItemStyle('item_2_off');
	
	$i4->addChildItem($i21);
			
}

	$button_apy_help = new Apycom_MenuItem();
	$button_apy_help->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Pomocník").'&nbsp;&nbsp;&nbsp;');
	$button_apy_help->setItemStyle('item_2');
	$button_apy_help->setNormalIcon('themes/default/images/help_s.gif');
		
	
	$button_apy_help_2 = new Apycom_MenuItem();
	$button_apy_help_2->setLabel(tr("Pomocník").'&nbsp;&nbsp;&nbsp;');
	$button_apy_help_2->setItemStyle('item_2');
	$button_apy_help_2->setNormalIcon('themes/default/images/help_s.gif');
	$button_apy_help_2->setLink('./?cmd=help');
	$button_apy_help->addChildItem($button_apy_help_2);
	
	$button_apy_userManual = new Apycom_MenuItem();
	$button_apy_userManual->setLabel(tr("Používateľská príručka").'&nbsp;&nbsp;&nbsp;');
	$button_apy_userManual->setItemStyle('item_2');
	$button_apy_userManual->setNormalIcon('themes/default/images/help_s.gif');
	$button_apy_userManual->setLink('./themes/default/help/pouzivatelska.pdf');
	$button_apy_userManual->setTarget('_blank');
	$button_apy_help->addChildItem($button_apy_userManual);

	$button_apy_contentLanguage = new Apycom_MenuItem();
	$button_apy_contentLanguage->setLabel(tr("Jazyk obsahu").'&nbsp;&nbsp;&nbsp;['.$GLOBALS['localLanguage'].']');
	$button_apy_contentLanguage->setItemStyle('item_4');
	$button_apy_contentLanguage->setNormalIcon('themes/default/images/lang_s.gif');
	

$i=0;
	foreach($GLOBALS['LanguageList'] as $column_name => $language_id){
		if ($language_id['local_visibility']){
			$i++;
			$title = $language_id['native_name'];
			$id = $language_id['code'];
			$name = "lang".$i;
			$$name = new Apycom_MenuItem();
			$$name->setLabel('&nbsp;&nbsp;&nbsp;'.$title.'&nbsp;&nbsp;&nbsp;');
			$$name->setLink("./?setLocalLanguage=$id&cmd=".$_GET['cmd']."&mcmd=".$_GET['mcmd']."&row_id[]=".$_GET['row_id'][0]."&module=".$_GET['module']."&start=".$_GET['start']."&s_category=".$_GET['s_category']);
			$$name->setItemStyle('item_4');
			
			if($GLOBALS['localLanguage']==$id)
				$$name->setNormalIcon('themes/default/images/visible.gif');
			else
				$$name->setNormalIcon('themes/default/images/blank.gif');
			$button_apy_contentLanguage->addChildItem($$name);
		}
	}
	
/***************************************************************************************
	ITEM END
***************************************************************************************/


		$menuKatalog = new CMS_Catalog_List();
		$menuKatalog->execute();
		
		$i=0;
		foreach($menuKatalog as $column_name => $value){
			
			$i++;
			
			$value->setContextLanguage($GLOBALS['localLanguage']);
			$defaultView = 0;
			
			if ($value->getTitle() == ''){
				$value->setContextLanguage($GLOBALS['localLanguageDefault']);
				$defaultView = 1;
			}
			
			if($defaultView == 1)
				$title = $GLOBALS['defaultViewStartTag'].$value->getTitle().$GLOBALS['defaultViewEndTag'];
			else
				$title = $value->getTitle();
			
			$id = $value->getId();
			$name = "im".$i;
			$$name = new Apycom_MenuItem();
			$$name->setLabel($title);
			//$$name->setLink("./?mcmd=3&module=CMS_Catalog&row_id[]=$id");
			$$name->setItemStyle('item_2');
			$$name->setNormalIcon($GLOBALS['path_relative'].'themes/default/images/catalog_s.gif');
			
			$i1->addChildItem($$name);
			
			
			
			$nameD = "im_det".$id;
			$$nameD = new Apycom_MenuItem();
			$$nameD->setLabel(tr('Detail'));
			$$nameD->setLink("./?mcmd=3&module=CMS_Catalog&setCatalog=$id");
			$$nameD->setItemStyle('item_2');
			//$$nameD->setNormalIcon('themes/default/images/menu_s_info.gif');
			$$nameD->setNormalIcon($GLOBALS['path_relative'].'themes/default/images/catalog_edit_s.gif');
			$$name->addChildItem($$nameD);
			
			$nameP = "im_pol".$id;
			$$nameP = new Apycom_MenuItem();
			$$nameP->setLabel(tr('Položky'));
			$$nameP->setLink("./?module=CMS_Catalog&setCatalog=$id&mcmd=4");
			$$nameP->setItemStyle('item_2');
			$$nameP->setNormalIcon($GLOBALS['path_relative'].'themes/default/images/catalog_item_s.gif');
			
			$$name->addChildItem($$nameP);
			
			
			
			$nameV = "im_view".$id;
			$$nameV = new Apycom_MenuItem();
			$$nameV->setLabel(tr('Ukážka'));
			$$nameV->setLink("./?mcmd=22&module=CMS_Catalog&setCatalog=$id");
			$$nameV->setItemStyle('item_2');
			$$nameV->setNormalIcon($GLOBALS['path_relative'].'themes/default/images/catalog_show_s.gif');
			
			$$name->addChildItem($$nameV);
			
		}
		
		


/***************************************************************************************
	MAPOVANIE MENU
***************************************************************************************/
$m->addItem($i1);
if (isset($_SESSION['currentCatalog'])){
		$m->addItem($i2);
		$m->addItem($i3);
		$m->addItem($i4);
	
}

$m->addItem($i18);
$m->addItem($button_apy_help);
$m->addItem($button_apy_contentLanguage);
/***************************************************************************************
	END MAPOVANIE MENU
***************************************************************************************/


// INIT MENU
echo $m->render();
}
catch(CN_Exception $e){
			echo $e->getMessage();
			echo $e->displayDetails();
	}
?>
