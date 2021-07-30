<?php
try{

	//var_dump(dirname(__FILE__)."lll");exit;
	require(dirname(__FILE__)."/../vendor/cms_classes/apycom_menu.php");

	include(dirname(__FILE__)."/buttons_privileges.php");

	$st = new Apycom_ItemStyle('item_1');

	$st->setOption('itemBackColor', '#dfdfdf,#ededed');
	$st->setOption('fontStyle', 'normal 11px Verdana');
	$st->setOption('fontColor', '#000000,#000000');
	$st->setOption('fontDecoration', 'none,none');
	//$st->setOption('CSS', 'apymenu_item');

	$st_off = new Apycom_ItemStyle('item_1_off');

	$st_off->setOption('itemBackColor', '#f0f0f0,#f0f0f0');
	$st_off->setOption('fontStyle', 'normal 11px Verdana');
	$st_off->setOption('fontColor', '#b9b9b9,#b9b9b9');
	$st_off->setOption('fontDecoration', 'none,none');

	$st_lang = new Apycom_ItemStyle('item_2');

	$st_lang->setOption('itemBackColor', '#ffe09f,#ffcc66');
	$st_lang->setOption('fontStyle', 'normal 11px Verdana');
	$st_lang->setOption('fontColor', '#000000,#000000');
	$st_lang->setOption('fontDecoration', 'none,none');

	$mst = new Apycom_MenuStyle('menu_top');
	$mst->setOption('menuBackColor', '#000000');
	$mst->setOption('menuBorderStyle', 'solid');
	$mst->setOption('menuBorderColor', '#a7a7a7');

	/***********/

	$m = new Apycom_Menu();
	$m->setAlignment(Apycom_Menu::ALIGNMENT_HORIZONTAL);
	$m->setFontColorNormal("ff0000");
	$m->setBackgroundColor("#fcfcfc");
	$m->setMainArrowImageNormal("images/arrowdn.gif");
	$m->setMainArrowImageHover("images/arrowdn.gif");
	$m->setSubImageArrowNormal("images/arrow.gif");
	$m->setSubImageArrowHover("images/arrow.gif");
	$m->setIconWidth(16);
	$m->setIconHeight(16);
	$m->setIconTopWidth(16);
	$m->setIconTopHeight(16);
	$m->setArrowWidth(7);
	$m->setArrowHeight(7);
	$m->setItemPadding(2);
	$m->setItemSpacing(1);
	$m->registerItemStyle($st);
	$m->registerItemStyle($st_off);
	$m->registerItemStyle($st_lang);
	$m->registerMenuStyle($mst);
	$m->setTransition(5);
	/***************************************************************************************
		ITEM START
	***************************************************************************************/
	if ($GLOBALS['buttons_privileges']['button_apy_home']['visibility']) {

		$button_apy_home = new Apycom_MenuItem();
		$button_apy_home->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Domov").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_home']['link'])
			$button_apy_home->setLink('./');

		if ($GLOBALS['buttons_privileges']['button_apy_home']['enabled'])
			$button_apy_home->setItemStyle('item_1');
		else
			$button_apy_home->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_home']['image'])
			$button_apy_home->setNormalIcon('images/home_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_menu']['visibility']) {

		$button_apy_menu = new Apycom_MenuItem();
		$button_apy_menu->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Menu").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_menu']['enabled']))
		  $button_apy_menu->setItemStyle('item_1');
		else
		  $button_apy_menu->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_menu']['image'])
			$button_apy_menu->setNormalIcon('images/menu_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_page']['visibility']) {

		$button_apy_page = new Apycom_MenuItem();
		$button_apy_page->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Stránka").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_page']['enabled'])
			$button_apy_page->setItemStyle('item_1');
		else
			$button_apy_page->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_menu']['image'])
			$button_apy_page->setNormalIcon('images/stranka_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_contents']['visibility']) {

		$button_apy_contents = new Apycom_MenuItem();
		$button_apy_contents->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Obsah").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_contents']['enabled'])
			$button_apy_contents->setItemStyle('item_1');
		else
			$button_apy_contents->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_contents']['image'])
			$button_apy_contents->setNormalIcon('images/obsah_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_modules']['visibility']) {

		$button_apy_modules = new Apycom_MenuItem();
		$button_apy_modules->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Moduly").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_modules']['enabled'])
			$button_apy_modules->setItemStyle('item_1');
		else
			$button_apy_modules->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_modules']['image'])
			$button_apy_modules->setNormalIcon('images/moduly_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_quick']['visibility']) {

		$button_apy_quick = new Apycom_MenuItem();
		$button_apy_quick->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Rýchlo").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_quick']['enabled'])
			$button_apy_quick->setItemStyle('item_1');
		else
			$button_apy_quick->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_quick']['image'])
			$button_apy_quick->setNormalIcon('images/rychlo_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_help']['visibility']) {

		$button_apy_help = new Apycom_MenuItem();
		$button_apy_help->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Pomocník").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_help']['enabled'])
			$button_apy_help->setItemStyle('item_1');
		else
			$button_apy_help->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_help']['image'])
			$button_apy_help->setNormalIcon('images/help_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_mainOptions']['visibility']) {

		$button_apy_mainOptions = new Apycom_MenuItem();
		$button_apy_mainOptions->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Hlavné nastavenia").'&nbsp;&nbsp;&nbsp;');

		if (($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) && ($GLOBALS['buttons_privileges']['button_apy_mainOptions']['enabled']))
			$button_apy_mainOptions->setItemStyle('item_1');
		else
			$button_apy_mainOptions->setItemStyle('item_1_off');

		if (($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) && ($GLOBALS['buttons_privileges']['button_apy_mainOptions']['link']))
			$button_apy_mainOptions->setLink('./?cmd=25');

		if ($GLOBALS['buttons_privileges']['button_apy_mainOptions']['image'])
			$button_apy_mainOptions->setNormalIcon('images/settings_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_mainOptions']['visibility']) {

		$button_apy_trash = new Apycom_MenuItem();
		$button_apy_trash->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Kôš").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(2, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_trash']['enabled']) )
			$button_apy_trash->setItemStyle('item_1');
		else
			$button_apy_trash->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(2, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_trash']['link']) )
			$button_apy_trash->setLink('./?cmd=10');

		if ($GLOBALS['buttons_privileges']['button_apy_trash']['image'])
			$button_apy_trash->setNormalIcon('images/trash_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_mediaManager']['visibility']) {

		$button_apy_mediaManager = new Apycom_MenuItem();
		$button_apy_mediaManager->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Manažér médií").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(9, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_mediaManager']['enabled']))
			$button_apy_mediaManager->setItemStyle('item_1');
		else
			$button_apy_mediaManager->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(9, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_mediaManager']['link']))
			$button_apy_mediaManager->setLink('./?cmd=26');

		if ($GLOBALS['buttons_privileges']['button_apy_mediaManager']['image'])
			$button_apy_mediaManager->setNormalIcon('images/media_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_userManager']['visibility']) {

		$button_apy_userManager = new Apycom_MenuItem();
		$button_apy_userManager->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Manažér používateľov").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(8, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_userManager']['enabled']))
			$button_apy_userManager->setItemStyle('item_1');
		else
			$button_apy_userManager->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(8, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_userManager']['link']))
			$button_apy_userManager->setLink('./?cmd=16');

		if ($GLOBALS['buttons_privileges']['button_apy_userManager']['image'])
			$button_apy_userManager->setNormalIcon('images/user_s.gif');

	}

	/* manazer skupin off */
	if ($GLOBALS['buttons_privileges']['button_apy_groupManager']['visibility']) {

		$button_apy_groupManager = new Apycom_MenuItem();
		$button_apy_groupManager->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Manažér skupín").'&nbsp;&nbsp;&nbsp;');
		if ((($GLOBALS['user_login']->checkPrivilege(12, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_groupManager']['link']))
			$button_apy_groupManager->setLink('./?cmd=33');

		if ((($GLOBALS['user_login']->checkPrivilege(12, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_groupManager']['enabled']))
			$button_apy_groupManager->setItemStyle('item_1');
		else
			$button_apy_groupManager->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_groupManager']['image'])
			$button_apy_groupManager->setNormalIcon('images/group_s.gif');
			/**/
	}


	if ($GLOBALS['buttons_privileges']['button_apy_activityManager']['visibility']) {

		$button_apy_activityManager = new Apycom_MenuItem();
		$button_apy_activityManager->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Manažér aktivít").'&nbsp;&nbsp;&nbsp;');
		$button_apy_activityManager->setLink('./?cmd=36');

		$button_apy_activityManager->setItemStyle('item_1');

		if ($GLOBALS['buttons_privileges']['button_apy_activityManager']['image'])
			$button_apy_activityManager->setNormalIcon('images/activity_s.gif');


		$button_apy_activityUser = new Apycom_MenuItem();
		$button_apy_activityUser->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Aktivity editorov").'&nbsp;&nbsp;&nbsp;');
		$button_apy_activityUser->setLink('./?cmd=36');

		$button_apy_activityUser->setItemStyle('item_1');

		if ($GLOBALS['buttons_privileges']['button_apy_activityManager']['image'])
			$button_apy_activityUser->setNormalIcon('images/activity_s.gif');


		$button_apy_loginTrackingUser = new Apycom_MenuItem();
		$button_apy_loginTrackingUser->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Report prihlásení").'&nbsp;&nbsp;&nbsp;');
		$button_apy_loginTrackingUser->setLink('./?cmd=37');

		$button_apy_loginTrackingUser->setItemStyle('item_1');

		if ($GLOBALS['buttons_privileges']['button_apy_activityManager']['image'])
			$button_apy_loginTrackingUser->setNormalIcon('images/activity_s.gif');

	}




	$site_url = $GLOBALS["config_all"]->getValue('site','url');

	if ($GLOBALS['buttons_privileges']['button_apy_preview']['visibility']) {

		$button_apy_preview = new Apycom_MenuItem();
		$button_apy_preview->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Ukážka").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_preview']['link']) {
			$button_apy_preview->setLink($site_url['value']);
			$button_apy_preview->setTarget('_blank');
		}

		if ($GLOBALS['buttons_privileges']['button_apy_preview']['enabled'])
			$button_apy_preview->setItemStyle('item_1');
		else
			$button_apy_preview->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_preview']['image'])
			$button_apy_preview->setNormalIcon('images/desktop_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_clientInfo']['visibility']) {

		$button_apy_clientInfo = new Apycom_MenuItem();
		$button_apy_clientInfo->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Karta zákazníka").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_clientInfo']['link']) {
			$button_apy_clientInfo->setLink('./?cmd=31');
		}

		if ($GLOBALS['buttons_privileges']['button_apy_clientInfo']['enabled'])
			$button_apy_clientInfo->setItemStyle('item_1');
		else
			$button_apy_clientInfo->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_clientInfo']['image'])
			$button_apy_clientInfo->setNormalIcon('images/client_s.gif');

	}

	if ($GLOBALS['buttons_privileges']['button_apy_articleManager']['visibility']) {

		$button_apy_articleManager = new Apycom_MenuItem();
		$button_apy_articleManager->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Manažér článkov").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_articleManager']['enabled']))
			$button_apy_articleManager->setItemStyle('item_1');
		else
			$button_apy_articleManager->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_articleManager']['image'])
			$button_apy_articleManager->setNormalIcon('images/article_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_articlesOverview']['visibility']) {

		$button_apy_articlesOverview = new Apycom_MenuItem();
		$button_apy_articlesOverview->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Prehľad článkov").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_articlesOverview']['enabled']))
			$button_apy_articlesOverview->setItemStyle('item_1');
		else
			$button_apy_articlesOverview->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_articlesOverview']['link']))
			$button_apy_articlesOverview->setLink('./?cmd=7');

		if ($GLOBALS['buttons_privileges']['button_apy_articleManager']['image'])
			$button_apy_articlesOverview->setNormalIcon('images/article_s_info.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_articlesSetupLanguage']['visibility']) {

		$button_apy_articlesSetupLanguage = new Apycom_MenuItem();
		$button_apy_articlesSetupLanguage->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Nastavenie viditeľnosti").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_articlesSetupLanguage']['enabled']))
			$button_apy_articlesSetupLanguage->setItemStyle('item_1');
		else
			$button_apy_articlesSetupLanguage->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_articlesSetupLanguage']['link']))
			$button_apy_articlesSetupLanguage->setLink('./?cmd=7&setup_type=visibility');

		if ($GLOBALS['buttons_privileges']['button_apy_articlesSetupLanguage']['image'])
			$button_apy_articlesSetupLanguage->setNormalIcon('images/article_s_setup.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_articlesSetupAccess']['visibility']) {

		$button_apy_articlesSetupAccess = new Apycom_MenuItem();
		$button_apy_articlesSetupAccess->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Nastavenie práv").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_articlesSetupAccess']['enabled']))
			$button_apy_articlesSetupAccess->setItemStyle('item_1');
		else
			$button_apy_articlesSetupAccess->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_articlesSetupAccess']['link']))
			$button_apy_articlesSetupAccess->setLink('./?cmd=7&setup_type=access');

		if ($GLOBALS['buttons_privileges']['button_apy_articlesSetupLanguage']['image'])
			$button_apy_articlesSetupAccess->setNormalIcon('images/article_s_setup.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_articlesSetupExpire']['visibility']) {

		$button_apy_articlesSetupExpire = new Apycom_MenuItem();
		$button_apy_articlesSetupExpire->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Nastavenie platnosti").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_articlesSetupExpire']['enabled']))
			$button_apy_articlesSetupExpire->setItemStyle('item_1');
		else
			$button_apy_articlesSetupExpire->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_articlesSetupExpire']['link']))
			$button_apy_articlesSetupExpire->setLink('./?cmd=7&setup_type=expire');

		if ($GLOBALS['buttons_privileges']['button_apy_articlesSetupLanguage']['image'])
			$button_apy_articlesSetupExpire->setNormalIcon('images/article_s_setup.gif');

	}



	if ($GLOBALS['buttons_privileges']['button_apy_news']['visibility']) {

		$button_apy_news = new Apycom_MenuItem();
		$button_apy_news->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Novinky").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(10, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_news']['enabled']))
			$button_apy_news->setItemStyle('item_1');
		else
			$button_apy_news->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(10, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_news']['link']))
			$button_apy_news->setLink('./?cmd=24');

		if ($GLOBALS['buttons_privileges']['button_apy_news']['image'])
			$button_apy_news->setNormalIcon('images/news_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_categoryManager']['visibility']) {

		$button_apy_categoryManager = new Apycom_MenuItem();
		$button_apy_categoryManager->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Manažér kategórií").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_categoryManager']['enabled']))
			$button_apy_categoryManager->setItemStyle('item_1');
		else
			$button_apy_categoryManager->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_categoryManager']['image'])
			$button_apy_categoryManager->setNormalIcon('images/category_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_frontPage']['visibility']) {

		$button_apy_frontPage = new Apycom_MenuItem();
		$button_apy_frontPage->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Úvodná stránka").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(11, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_frontPage']['enabled']))
			$button_apy_frontPage->setItemStyle('item_1');
		else
			$button_apy_frontPage->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(11, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_frontPage']['link']))
			$button_apy_frontPage->setLink('./?cmd=15');

		if ($GLOBALS['buttons_privileges']['button_apy_frontPage']['image'])
			$button_apy_frontPage->setNormalIcon('images/frontpage_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_weblinkManager']['visibility']) {

		$button_apy_weblinkManager = new Apycom_MenuItem();
		$button_apy_weblinkManager->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Manažér odkazov").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_weblinkManager']['enabled']))
			$button_apy_weblinkManager->setItemStyle('item_1');
		else
			$button_apy_weblinkManager->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_weblinkManager']['link']))
			$button_apy_weblinkManager->setLink('./?cmd=12');

		if ($GLOBALS['buttons_privileges']['button_apy_weblinkManager']['image'])
			$button_apy_weblinkManager->setNormalIcon('images/weblinks_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_archiveManager']['visibility']) {

		$button_apy_archiveManager = new Apycom_MenuItem();
		$button_apy_archiveManager->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Archív manažér").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(3, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_archiveManager']['enabled']))
			$button_apy_archiveManager->setItemStyle('item_1');
		else
			$button_apy_archiveManager->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(3, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_archiveManager']['link']))
			$button_apy_archiveManager->setLink('./?cmd=11');

		if ($GLOBALS['buttons_privileges']['button_apy_archiveManager']['image'])
			$button_apy_archiveManager->setNormalIcon('images/archiv_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_languageManager']['visibility']) {

		$button_apy_languageManager = new Apycom_MenuItem();
		$button_apy_languageManager->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Manažér jazykov").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(4, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login']->checkPrivilege(4, CMS_Privileges::UPDATE_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_languageManager']['enabled']))
			$button_apy_languageManager->setItemStyle('item_1');
		else
			$button_apy_languageManager->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(4, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login']->checkPrivilege(4, CMS_Privileges::UPDATE_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_languageManager']['link']))
			$button_apy_languageManager->setLink('./?cmd=19');

		if ($GLOBALS['buttons_privileges']['button_apy_languageManager']['image'])
			$button_apy_languageManager->setNormalIcon('images/lang_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_languageApplication']['visibility']) {

		$button_apy_languageApplication = new Apycom_MenuItem();
		$button_apy_languageApplication->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Jazyk aplikácie").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_languageApplication']['link'])
			$button_apy_languageApplication->setLink('./?cmd=19');

		if ($GLOBALS['buttons_privileges']['button_apy_languageApplication']['enabled'])
			$button_apy_languageApplication->setItemStyle('item_1');
		else
			$button_apy_languageApplication->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_languageApplication']['image'])
			$button_apy_languageApplication->setNormalIcon('images/lang_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_categoriesOverview']['visibility']) {

		$button_apy_categoriesOverview = new Apycom_MenuItem();
		$button_apy_categoriesOverview->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Prehľad kategórií").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesOverview']['link'])
			$button_apy_categoriesOverview->setLink('./?cmd=1');

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesOverview']['enabled'])
			$button_apy_categoriesOverview->setItemStyle('item_1');
		else
			$button_apy_categoriesOverview->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesOverview']['image'])
			$button_apy_categoriesOverview->setNormalIcon('images/category_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_categoriesBindings']['visibility']) {

		$button_apy_categoriesBindings = new Apycom_MenuItem();
		$button_apy_categoriesBindings->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Väzby kategórií").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesBindings']['link'])
			$button_apy_categoriesBindings->setLink('./?cmd=22');

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesBindings']['enabled'])
			$button_apy_categoriesBindings->setItemStyle('item_1');
		else
			$button_apy_categoriesBindings->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesBindings']['image'])
			$button_apy_categoriesBindings->setNormalIcon('images/category_s_.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_categoriesSetupLanguage']['visibility']) {

		$button_apy_categoriesSetupLanguage = new Apycom_MenuItem();
		$button_apy_categoriesSetupLanguage->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Nastavenie viditeľnosti").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesSetupLanguage']['link'])
			$button_apy_categoriesSetupLanguage->setLink('./?cmd=1&setup_type=visibility');

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesSetupLanguage']['enabled'])
			$button_apy_categoriesSetupLanguage->setItemStyle('item_1');
		else
			$button_apy_categoriesSetupLanguage->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesSetupLanguage']['image'])
			$button_apy_categoriesSetupLanguage->setNormalIcon('images/category_s_.gif');

	}

	if ($GLOBALS['buttons_privileges']['button_apy_categoriesSetupAccess']['visibility']) {

		$button_apy_categoriesSetupAccess = new Apycom_MenuItem();
		$button_apy_categoriesSetupAccess->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Nastavenie práv").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesSetupAccess']['link'])
			$button_apy_categoriesSetupAccess->setLink('./?cmd=1&setup_type=access');

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesSetupAccess']['enabled'])
			$button_apy_categoriesSetupAccess->setItemStyle('item_1');
		else
			$button_apy_categoriesSetupAccess->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesSetupAccess']['image'])
			$button_apy_categoriesSetupAccess->setNormalIcon('images/category_s_.gif');

	}

	if ($GLOBALS['buttons_privileges']['button_apy_menuOverview']['visibility']) {

		$button_apy_menuOverview = new Apycom_MenuItem();
		$button_apy_menuOverview->setLabel('&nbsp;&nbsp;&nbsp;'.tr("Prehľad menu").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_menuOverview']['link'])
			$button_apy_menuOverview->setLink('./?cmd=4');

		if ($GLOBALS['buttons_privileges']['button_apy_menuOverview']['enabled'])
			$button_apy_menuOverview->setItemStyle('item_1');
		else
			$button_apy_menuOverview->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_menuOverview']['image'])
			$button_apy_menuOverview->setNormalIcon('images/menu_s.gif');

	}

	// QUICK MENU START

	if ($GLOBALS['buttons_privileges']['button_apy_articleList_quick']['visibility']) {

		$button_apy_articleList_quick = new Apycom_MenuItem();
		$button_apy_articleList_quick->setLabel(tr("Zoznam článkov").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_articleList_quick']['enabled']))
			$button_apy_articleList_quick->setItemStyle('item_1');
		else
			$button_apy_articleList_quick->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_articleList_quick']['link']))
			$button_apy_articleList_quick->setLink('./?cmd=7');

		if ($GLOBALS['buttons_privileges']['button_apy_articleList_quick']['image'])
			$button_apy_articleList_quick->setNormalIcon('images/article_s_info.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_newArticle_quick']['visibility']) {

		$button_apy_newArticle_quick = new Apycom_MenuItem();
		$button_apy_newArticle_quick->setLabel(tr("Nový článok").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_newArticle_quick']['enabled']))
			$button_apy_newArticle_quick->setItemStyle('item_1');
		else
			$button_apy_newArticle_quick->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_newArticle_quick']['link']))
			$button_apy_newArticle_quick->setLink('./?cmd=8');

		if ($GLOBALS['buttons_privileges']['button_apy_articleList_quick']['image'])
			$button_apy_newArticle_quick->setNormalIcon('images/article_s_add.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_categoryList_quick']['visibility']) {

		$button_apy_categoryList_quick = new Apycom_MenuItem();
		$button_apy_categoryList_quick->setLabel(tr("Zoznam kategórií").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_categoryList_quick']['enabled']))
			$button_apy_categoryList_quick->setItemStyle('item_1');
		else
			$button_apy_categoryList_quick->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_categoryList_quick']['link']))
			$button_apy_categoryList_quick->setLink('./?cmd=1');

		if ($GLOBALS['buttons_privileges']['button_apy_categoryList_quick']['image'])
			$button_apy_categoryList_quick->setNormalIcon('images/category_s_info.gif');

	}

	if ($GLOBALS['buttons_privileges']['button_apy_newCategory_quick']['visibility']) {

		$button_apy_newCategory_quick = new Apycom_MenuItem();
		$button_apy_newCategory_quick->setLabel(tr("Nová kategória").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_newCategory_quick']['enabled']))
			$button_apy_newCategory_quick->setItemStyle('item_1');
		else
			$button_apy_newCategory_quick->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_newCategory_quick']['link']))
			$button_apy_newCategory_quick->setLink('./?cmd=2');

		if ($GLOBALS['buttons_privileges']['button_apy_newCategory_quick']['image'])
			$button_apy_newCategory_quick->setNormalIcon('images/category_s_add.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_mediaManager_quick']['visibility']) {

		$button_apy_mediaManager_quick = new Apycom_MenuItem();
		$button_apy_mediaManager_quick->setLabel(tr("Manažér médií").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(9, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_mediaManager_quick']['enabled']))
			$button_apy_mediaManager_quick->setItemStyle('item_1');
		else
		 	$button_apy_mediaManager_quick->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(9, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_mediaManager_quick']['link']))
			$button_apy_mediaManager_quick->setLink('./?cmd=26');

		if ($GLOBALS['buttons_privileges']['button_apy_mediaManager_quick']['image'])
			$button_apy_mediaManager_quick->setNormalIcon('images/media_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_newFile_quick']['visibility']) {

		$button_apy_newFile_quick = new Apycom_MenuItem();
		$button_apy_newFile_quick->setLabel(tr("Nový súbor").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(9, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_newFile_quick']['enabled']))
			$button_apy_newFile_quick->setItemStyle('item_1');
		else
			$button_apy_newFile_quick->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(9, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_newFile_quick']['link']))
			$button_apy_newFile_quick->setLink('./?cmd=28');

		if ($GLOBALS['buttons_privileges']['button_apy_newFile_quick']['image'])
			$button_apy_newFile_quick->setNormalIcon('images/media_s_add.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_trash_quick']['visibility']) {

		$button_apy_trash_quick = new Apycom_MenuItem();
		$button_apy_trash_quick->setLabel(tr("Kôš").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(2, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_trash_quick']['enabled']))
		  	$button_apy_trash_quick->setItemStyle('item_1');
		else
			$button_apy_trash_quick->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(2, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_trash_quick']['link']))
			$button_apy_trash_quick->setLink('./?cmd=10');

		if ($GLOBALS['buttons_privileges']['button_apy_trash_quick']['image'])
			$button_apy_trash_quick->setNormalIcon('images/trash_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_myProxia_quick']['visibility']) {

		$button_apy_myProxia_quick = new Apycom_MenuItem();
		$button_apy_myProxia_quick->setLabel(tr("Moja PROXIA").'&nbsp;&nbsp;&nbsp;');


	  	$button_apy_myProxia_quick->setItemStyle('item_1');

	//	if ($GLOBALS['buttons_privileges']['button_apy_myProxia_quick']['image'])
	//		$button_apy_myProxia_quick->setNormalIcon('images/trash_s.gif');

	}

	if ($GLOBALS['buttons_privileges']['button_apy_myArticles_quick']['visibility']) {

		$button_apy_myArticles_quick = new Apycom_MenuItem();
		$button_apy_myArticles_quick->setLabel(tr("Moje články").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_myArticles_quick']['enabled']))
		  	$button_apy_myArticles_quick->setItemStyle('item_1');
		else
			$button_apy_myArticles_quick->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_myArticles_quick']['link']))
			$button_apy_myArticles_quick->setLink('./?cmd=7&s_author='.$_SESSION['user']['id']);

		//if ($GLOBALS['buttons_privileges']['button_apy_myArticles_quick']['image'])
			//$button_apy_myArticles_quick->setNormalIcon('images/trash_s.gif');

	}

	if ($GLOBALS['buttons_privileges']['button_apy_myCategories_quick']['visibility']) {

		$button_apy_myCategories_quick = new Apycom_MenuItem();
		$button_apy_myCategories_quick->setLabel(tr("Moje kategórie").'&nbsp;&nbsp;&nbsp;');

		if ((($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_myCategories_quick']['enabled']))
		  	$button_apy_myCategories_quick->setItemStyle('item_1');
		else
			$button_apy_myCategories_quick->setItemStyle('item_1_off');

		if ((($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_myCategories_quick']['link']))
			$button_apy_myCategories_quick->setLink('./?cmd=1&s_author='.$_SESSION['user']['id']);

		//if ($GLOBALS['buttons_privileges']['button_apy_trash_quick']['image'])
			//$button_apy_myCategories_quick->setNormalIcon('images/trash_s.gif');

	}

	// QUICK MENU END

	if ($GLOBALS['buttons_privileges']['button_apy_contentLanguage']['visibility']) {

		$button_apy_contentLanguage = new Apycom_MenuItem();
		$button_apy_contentLanguage->setLabel(tr("Jazyk obsahu").'&nbsp;&nbsp;&nbsp;['.$GLOBALS['localLanguage'].']');

		if ($GLOBALS['buttons_privileges']['button_apy_contentLanguage']['enabled'])
			$button_apy_contentLanguage->setItemStyle('item_2');
		else
			$button_apy_contentLanguage->setItemStyle('item_2_off');

		if ($GLOBALS['buttons_privileges']['button_apy_contentLanguage']['image'])
			$button_apy_contentLanguage->setNormalIcon('images/lang_s.gif');

	}


	if ($GLOBALS['buttons_privileges']['button_apy_help_2']['visibility']) {

		$button_apy_help_2 = new Apycom_MenuItem();
		$button_apy_help_2->setLabel(tr("Pomocník").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_help_2']['enabled'])
			$button_apy_help_2->setItemStyle('item_1');
		else
			$button_apy_help_2->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_help_2']['image'])
			$button_apy_help_2->setNormalIcon('images/help_s.gif');

		if ($GLOBALS['buttons_privileges']['button_apy_help_2']['link'])
			$button_apy_help_2->setLink('./?cmd=help');

	}

	if ($GLOBALS['buttons_privileges']['button_apy_userManual']['visibility']) {

		$button_apy_userManual = new Apycom_MenuItem();
		$button_apy_userManual->setLabel(tr("Používateľská príručka").'&nbsp;&nbsp;&nbsp;');

		if ($GLOBALS['buttons_privileges']['button_apy_userManual']['enabled'])
			$button_apy_userManual->setItemStyle('item_1');
		else
			$button_apy_userManual->setItemStyle('item_1_off');

		if ($GLOBALS['buttons_privileges']['button_apy_userManual']['image'])
			$button_apy_userManual->setNormalIcon('images/help_s.gif');

		if ($GLOBALS['buttons_privileges']['button_apy_userManual']['link']){
			$button_apy_userManual->setLink('./help/pouzivatelska.pdf');
			$button_apy_userManual->setTarget('_blank');
		}

	}


	/***************************************************************************************
		ITEM END
	***************************************************************************************/



	/***************************************************************************************
		MAPOVANIE MENU
	***************************************************************************************/
	if (($GLOBALS['localLanguage']=='sk') && ($GLOBALS['buttons_privileges']['button_apy_help']['bind']) && ($GLOBALS['buttons_privileges']['button_apy_help']['visibility'])) {

		if ($GLOBALS['buttons_privileges']['button_apy_help_2']['visibility'])
			$button_apy_help->addChildItem($button_apy_help_2);

		if ($GLOBALS['buttons_privileges']['button_apy_userManual']['visibility'])
			$button_apy_help->addChildItem($button_apy_userManual);

	}

	if (( ($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_menu']['bind']) && ($GLOBALS['buttons_privileges']['button_apy_menu']['visibility']))
		$button_apy_menu->addChildItem($button_apy_menuOverview);


	if ( ($GLOBALS['buttons_privileges']['button_apy_page']['bind']) && ($GLOBALS['buttons_privileges']['button_apy_page']['visibility']) ){

		if ($GLOBALS['buttons_privileges']['button_apy_mainOptions']['visibility'])
			$button_apy_page->addChildItem($button_apy_mainOptions);

		if ($GLOBALS['buttons_privileges']['button_apy_trash']['visibility'])
			$button_apy_page->addChildItem($button_apy_trash);

		if ($GLOBALS['buttons_privileges']['button_apy_mediaManager']['visibility'])
			$button_apy_page->addChildItem($button_apy_mediaManager);

		if ($GLOBALS['buttons_privileges']['button_apy_userManager']['visibility'])
			$button_apy_page->addChildItem($button_apy_userManager);

		if ($GLOBALS['buttons_privileges']['button_apy_groupManager']['visibility'])
			$button_apy_page->addChildItem($button_apy_groupManager); //manazer skupin off

		if ($GLOBALS['buttons_privileges']['button_apy_activityManager']['visibility'])
			$button_apy_page->addChildItem($button_apy_activityManager);

				if ($GLOBALS['buttons_privileges']['button_apy_activityManager']['visibility'])
					$button_apy_activityManager->addChildItem($button_apy_activityUser);

				if ($GLOBALS['buttons_privileges']['button_apy_activityManager']['visibility'])
					$button_apy_activityManager->addChildItem($button_apy_loginTrackingUser);


		if ($GLOBALS['buttons_privileges']['button_apy_languageManager']['visibility'])
			$button_apy_page->addChildItem($button_apy_languageManager);

		if ($GLOBALS['buttons_privileges']['button_apy_preview']['visibility'])
			$button_apy_page->addChildItem($button_apy_preview);

		if ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)
			$button_apy_page->addChildItem($button_apy_clientInfo);

		if ($GLOBALS['buttons_privileges']['button_apy_languageApplication']['visibility'])
			$button_apy_page->addChildItem($button_apy_languageApplication);

	}


	if ( ($GLOBALS['buttons_privileges']['button_apy_contents']['bind']) && ($GLOBALS['buttons_privileges']['button_apy_contents']['visibility']) ){

		if ($GLOBALS['buttons_privileges']['button_apy_articleManager']['visibility'])
			$button_apy_contents->addChildItem($button_apy_articleManager);

		if ($GLOBALS['buttons_privileges']['button_apy_news']['visibility'])
			$button_apy_contents->addChildItem($button_apy_news);

		if ($GLOBALS['buttons_privileges']['button_apy_categoryManager']['visibility'])
			$button_apy_contents->addChildItem($button_apy_categoryManager);

		if ($GLOBALS['buttons_privileges']['button_apy_frontPage']['visibility'])
			$button_apy_contents->addChildItem($button_apy_frontPage);

		if ($GLOBALS['buttons_privileges']['button_apy_weblinkManager']['visibility'])
			$button_apy_contents->addChildItem($button_apy_weblinkManager);

		if ($GLOBALS['buttons_privileges']['button_apy_archiveManager']['visibility'])
			$button_apy_contents->addChildItem($button_apy_archiveManager);

	}


	if ((($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_categoryManager']['bind']) && ($GLOBALS['buttons_privileges']['button_apy_articleManager']['visibility']) ){

		if ($GLOBALS['buttons_privileges']['button_apy_articlesOverview']['visibility'])
			$button_apy_articleManager->addChildItem($button_apy_articlesOverview);

		if ($GLOBALS['buttons_privileges']['button_apy_articlesSetupLanguage']['visibility'])
			$button_apy_articleManager->addChildItem($button_apy_articlesSetupLanguage);

		if ($GLOBALS['buttons_privileges']['button_apy_articlesSetupAccess']['visibility'])
			$button_apy_articleManager->addChildItem($button_apy_articlesSetupAccess);

		if ($GLOBALS['buttons_privileges']['button_apy_articlesSetupExpire']['visibility'])
			$button_apy_articleManager->addChildItem($button_apy_articlesSetupExpire);

	}



	if ((($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)) && ($GLOBALS['buttons_privileges']['button_apy_categoryManager']['bind']) && ($GLOBALS['buttons_privileges']['button_apy_categoryManager']['visibility']) ){

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesOverview']['visibility'])
			$button_apy_categoryManager->addChildItem($button_apy_categoriesOverview);

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesBindings']['visibility'])
			$button_apy_categoryManager->addChildItem($button_apy_categoriesBindings);

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesSetupLanguage']['visibility'])
			$button_apy_categoryManager->addChildItem($button_apy_categoriesSetupLanguage);

		if ($GLOBALS['buttons_privileges']['button_apy_categoriesSetupAccess']['visibility'])
			$button_apy_categoryManager->addChildItem($button_apy_categoriesSetupAccess);

	}


	if ( ($GLOBALS['buttons_privileges']['button_apy_quick']['bind']) && ($GLOBALS['buttons_privileges']['button_apy_quick']['visibility']) ) {

		if ($GLOBALS['buttons_privileges']['button_apy_articleList_quick']['visibility'])
			$button_apy_quick->addChildItem($button_apy_articleList_quick);

		if ($GLOBALS['buttons_privileges']['button_apy_newArticle_quick']['visibility'])
			$button_apy_quick->addChildItem($button_apy_newArticle_quick);

		if ($GLOBALS['buttons_privileges']['button_apy_categoryList_quick']['visibility'])
			$button_apy_quick->addChildItem($button_apy_categoryList_quick);

		if ($GLOBALS['buttons_privileges']['button_apy_newCategory_quick']['visibility'])
			$button_apy_quick->addChildItem($button_apy_newCategory_quick);

		if ($GLOBALS['buttons_privileges']['button_apy_mediaManager_quick']['visibility'])
			$button_apy_quick->addChildItem($button_apy_mediaManager_quick);

		if ($GLOBALS['buttons_privileges']['button_apy_newFile_quick']['visibility'])
			$button_apy_quick->addChildItem($button_apy_newFile_quick);

		if ($GLOBALS['buttons_privileges']['button_apy_trash_quick']['visibility'])
			$button_apy_quick->addChildItem($button_apy_trash_quick);

		if ($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER){
			if ($GLOBALS['buttons_privileges']['button_apy_myProxia_quick']['visibility'])
				$button_apy_quick->addChildItem($button_apy_myProxia_quick);
		}

	}

	if ($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER){
		if ( ($GLOBALS['buttons_privileges']['button_apy_myProxia_quick']['bind']) && ($GLOBALS['buttons_privileges']['button_apy_myProxia_quick']['visibility']) ) {

			if ($GLOBALS['buttons_privileges']['button_apy_myArticles_quick']['visibility'])
				$button_apy_myProxia_quick->addChildItem($button_apy_myArticles_quick);

			if ($GLOBALS['buttons_privileges']['button_apy_myCategories_quick']['visibility'])
				$button_apy_myProxia_quick->addChildItem($button_apy_myCategories_quick);

		}
	}


	$m->addItem($button_apy_home);
	$m->addItem($button_apy_menu);
	$m->addItem($button_apy_page);
	$m->addItem($button_apy_contents);
	$m->addItem($button_apy_modules);
	$m->addItem($button_apy_quick);
	$m->addItem($button_apy_help);
	$m->addItem($button_apy_contentLanguage);

	/***************************************************************************************
		END MAPOVANIE MENU
	***************************************************************************************/



	/***************************************************************************************
		ITEM START DYNAMICKY VYPIS DB MENU
	***************************************************************************************/

	if ((($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::VIEW_PRIVILEGE) === true) && ($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::ACCESS_PRIVILEGE) === true)) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){

		$menuMenu = new CMS_MenuList();
		$menuMenu->addCondition("is_trash", 0);
		$menuMenu->execute();

		$i=0;
		foreach($menuMenu as $column_name => $value){

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
			$$name->setLabel('&nbsp;&nbsp;&nbsp;'.$title.'&nbsp;&nbsp;&nbsp;');
			$$name->setLink("./?cmd=6&row_id[]=$id");
			$$name->setItemStyle('item_1');
			$$name->setNormalIcon('images/menu_s_info.gif');

			if ( ($GLOBALS['buttons_privileges']['button_apy_menu']['bind']) && ($GLOBALS['buttons_privileges']['button_apy_menu']['visibility']) )
				$button_apy_menu->addChildItem($$name);

			$nameD = "im_det".$id;
			$$nameD = new Apycom_MenuItem();
			$$nameD->setLabel('&nbsp;&nbsp;&nbsp;'.tr('Detail').'&nbsp;&nbsp;&nbsp;');
			$$nameD->setLink("./?cmd=6&row_id[]=$id");
			$$nameD->setItemStyle('item_1');
			//$$nameD->setNormalIcon('images/menu_s_info.gif');

			$$name->addChildItem($$nameD);

			$nameP = "im_pol".$id;
			$$nameP = new Apycom_MenuItem();
			$$nameP->setLabel('&nbsp;&nbsp;&nbsp;'.tr('Položky').'&nbsp;&nbsp;&nbsp;');
			$$nameP->setLink("./?cmd=23&s_category=$id");
			$$nameP->setItemStyle('item_1');
			//$$nameP->setNormalIcon('images/menu_s_info.gif');

			$$name->addChildItem($$nameP);


		}
	}

	$available_install_languages = CMS_Languages::getSingleton()->getAvailableTranslations("../");

	$get = function (string $var, int $idx = null) {
	    $val = $_GET[$var] ?? null;

	    if (!is_null($idx)) {
	        return ($val and $val[$idx]) ?? null;
        }

	    return $val;
    };

	foreach($available_install_languages as $lang){

		$i++;

		$title = $lang;
		$id = $lang;
		$name = "lang".$i;
		$$name = new Apycom_MenuItem();
		$$name->setLabel('&nbsp;&nbsp;&nbsp;'.$title.'&nbsp;&nbsp;&nbsp;');
		$$name->setLink("./?setPreferedLanguage=$id&cmd=".$get('cmd')."&mcmd=".$get('mcmd')."&row_id[]=".$get('row_id', 0) ?? null."&module=".$get('module')."&start=".$get('start')."&s_category=".$get('category'));
		$$name->setItemStyle('item_1');

		if($GLOBALS['preferedLanguage']==$id)
			$$name->setNormalIcon('images/visible.gif');
		else
			$$name->setNormalIcon('images/blank.gif');

		if ( ($GLOBALS['buttons_privileges']['button_apy_languageApplication']['bind']) && ($GLOBALS['buttons_privileges']['button_apy_languageApplication']['visibility']) )
			$button_apy_languageApplication->addChildItem($$name);
	}


	$i=0;
	foreach($GLOBALS['LanguageList'] as $column_name => $language_id){
		if ($language_id['local_visibility']){
			$i++;
			$title = $language_id['native_name'];
			$id = $language_id['code'];
			$name = "lang".$i;
			$$name = new Apycom_MenuItem();
			$$name->setLabel('&nbsp;&nbsp;&nbsp;'.$title.'&nbsp;&nbsp;&nbsp;');
			$$name->setLink("./?setLocalLanguage=$id&cmd=".$get('cmd')."&mcmd=".$get('mcmd')."&row_id[]=".$get('row_id', 0)."&module=".$get('module')."&start=".$get('start')."&s_category=".$get('category'));
			$$name->setItemStyle('item_2');

			if($GLOBALS['localLanguage']==$id)
				$$name->setNormalIcon('images/visible.gif');
			else
				$$name->setNormalIcon('images/blank.gif');

			if ( ($GLOBALS['buttons_privileges']['button_apy_contentLanguage']['bind']) && ($GLOBALS['buttons_privileges']['button_apy_contentLanguage']['visibility']) )
				$button_apy_contentLanguage->addChildItem($$name);
		}
	}


	// vypis
	$menuModules = CMS_Module::getAvailableModules();

	$enableModules = CMS_ProjectConfig::getSingleton()->getAvailableModules();

	$i=0;
	foreach($menuModules as $column_name => $value){

		$i++;
		$id = $value->getName();

		if (array_search($id,$enableModules) === false)
			continue;

		if (($id == 'CMS_Catalog'))
			continue;

		$metainfo = $value->getMetainfo();

		if($metainfo['title'][$GLOBALS['preferedLanguage']] == '')
			$title = $GLOBALS['defaultViewStartTag'].$metainfo['title'][$GLOBALS['preferedLanguageDefault']].$GLOBALS['defaultViewEndTag'];
		else
			$title = $metainfo['title'][$GLOBALS['preferedLanguage']];

		$meta_code = $metainfo["code"]["independent"];
		// tu skontrolovat ci ma pravo na access pre danny modul

		$right_code = CMS_LogicEntity::getSingleton()->getIdByName(str_replace("CMS_","",$meta_code));

		$name = "mod_".$i;
		$$name = new Apycom_MenuItem();
		$$name->setLabel('&nbsp;&nbsp;&nbsp;'.$title.'&nbsp;&nbsp;&nbsp;');

		if (($GLOBALS['user_login']->checkPrivilege($right_code, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){
	 		$$name->setLink("./?module=$id");
	 		$$name->setItemStyle('item_1');
	 	}
		else
	 		$$name->setItemStyle('item_1_off');

		if ( ($GLOBALS['buttons_privileges']['button_apy_modules']['bind']) && ($GLOBALS['buttons_privileges']['button_apy_modules']['visibility']) )
			$button_apy_modules->addChildItem($$name);
	}


	/***************************************************************************************
		ITEM END DYNAMICKY VYPIS DB MENU
	***************************************************************************************/


	// 	INIT MENU
	echo $m->render();
}
 catch(CN_Exception $e){
	echo $e->displayDetails();
}
