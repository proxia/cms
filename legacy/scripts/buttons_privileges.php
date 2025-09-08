<?php

// 
try{

	####### ZOBRAZENIE VSETKYCH TLACIDIEL #########################################################################
	
	$GLOBALS['buttons_privileges_all'] = array(
		'button_apy_home' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_menu' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_page' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_contents' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_modules' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_quick' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_help' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_menuManager' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_mainOptions' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_trash' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_mediaManager' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_userManager' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_groupManager' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),		
		'button_apy_preview' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_clientInfo' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_articleManager' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		
		'button_apy_articlesOverview' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_articlesSetupLanguage' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_articlesSetupAccess' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_articlesSetupExpire' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
	
		'button_apy_news' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_categoryManager' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_frontPage' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_weblinkManager' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_archiveManager' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_languageManager' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_languageApplication' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_categoriesOverview' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		
		'button_apy_categoriesSetupLanguage' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_categoriesSetupAccess' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
	
		'button_apy_categoriesBindings' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_menuOverview' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_menuBindings' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_articleList_quick' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_newArticle_quick' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_categoryList_quick' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_newCategory_quick' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_mediaManager_quick' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_newFile_quick' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_trash_quick' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		
		'button_apy_myProxia_quick' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_myArticles_quick' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_myCategories_quick' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),

		'button_apy_activityManager' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
	
		'button_apy_contentLanguage' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_help_2' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_userManual' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE)
	);
	
	#######################################################################################################################

	####### ZOBRAZENIE PRI MODULE #########################################################################
	
	$GLOBALS['buttons_privileges_module'] = array(
		'button_apy_home' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_menu' => array ('visibility' => TRUE, 'enabled' => FALSE, 'image' => TRUE, 'link' => FALSE, 'bind' => FALSE),
		'button_apy_page' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_contents' => array ('visibility' => TRUE, 'enabled' => FALSE, 'image' => TRUE, 'link' => FALSE, 'bind' => FALSE),
		'button_apy_modules' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_quick' => array ('visibility' => TRUE, 'enabled' => FALSE, 'image' => TRUE, 'link' => FALSE, 'bind' => FALSE),
		'button_apy_help' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_menuManager' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_mainOptions' => array ('visibility' => TRUE, 'enabled' => FALSE, 'image' => TRUE, 'link' => FALSE, 'bind' => TRUE),
		'button_apy_trash' => array ('visibility' => TRUE, 'enabled' => FALSE, 'image' => TRUE, 'link' => FALSE, 'bind' => TRUE),
		'button_apy_mediaManager' => array ('visibility' => TRUE, 'enabled' => FALSE, 'image' => TRUE, 'link' => FALSE, 'bind' => TRUE),
		'button_apy_userManager' => array ('visibility' => TRUE, 'enabled' => FALSE, 'image' => TRUE, 'link' => FALSE, 'bind' => TRUE),
		'button_apy_groupManager' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),		
		'button_apy_preview' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_clientInfo' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_articleManager' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		
		'button_apy_articlesOverview' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_articlesSetupLanguage' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_articlesSetupAccess' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_articlesSetupExpire' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
	
		'button_apy_news' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_categoryManager' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_frontPage' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_weblinkManager' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_archiveManager' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_languageManager' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_languageApplication' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_categoriesOverview' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_categoriesBindings' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_categoriesSetupLanguage' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_categoriesSetupAccess' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
	
		'button_apy_menuOverview' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_menuBindings' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_articleList_quick' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_newArticle_quick' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_categoryList_quick' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_newCategory_quick' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_mediaManager_quick' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_newFile_quick' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_trash_quick' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		
		'button_apy_myProxia_quick' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_myArticles_quick' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_myCategories_quick' => array ('visibility' => FALSE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
	
		'button_apy_contentLanguage' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_help_2' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE),
		'button_apy_userManual' => array ('visibility' => TRUE, 'enabled' => TRUE, 'image' => TRUE, 'link' => TRUE, 'bind' => TRUE)
	);
	
	#######################################################################################################################
	
	if ($GLOBALS['use_module'])
		$GLOBALS['buttons_privileges'] = $GLOBALS['buttons_privileges_module'];
	else
		$GLOBALS['buttons_privileges'] = $GLOBALS['buttons_privileges_all'];
	
}
catch(CN_Exception $e){
	echo $e->getMessage();
	echo $e->displayDetails();
}
?>
