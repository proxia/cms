<?php
try{
require("../cms_classes/apycom_tree_menu.php");
exit;
$s = new Apycom_TreeItemStyle('cool_style');
$s->setOption('tfontStyle', 'normal 10px Verdana');
$s->setOption('tfontColorNormal', '#000000');
$s->setOption('titemBackColor', '#f1f1f1,#ffffff');


$xs = new Apycom_TreeItemStyle('cool_xp');
$xs->setOption('tXPTitleBackColor', '#00FF00');
$xs->setOption('tfontStyle', 'bold 30px Arial');
$xs->setOption('tfontColorNormal', '#000000');

$GLOBALS['title_size'] = 24;
$GLOBALS['title_one_size'] = 1;

$GLOBALS["tm"] = new Apycom_TreeMenu();
$GLOBALS["tm"]->setSaveState(true);
$GLOBALS["tm"]->setLevelIndent("10");
$GLOBALS["tm"]->setCloseExpandedItem(false);
$GLOBALS["tm"]->setWidth('190');
$GLOBALS["tm"]->setExpandItems(false);
$GLOBALS["tm"]->setExpandPolicy(Apycom_TreeMenu::EXPAND_POLICY_ON_ICON_CLICK);
$GLOBALS["tm"]->setCursor('hand');
$GLOBALS["tm"]->setFontColorHover('#000000');
$GLOBALS["tm"]->setBackgroundColor('#edece9');
$GLOBALS["tm"]->setBorderColor('#bababa');
$GLOBALS["tm"]->setItemBackgroundColorHover('#f3f3f3');
$GLOBALS["tm"]->setIsFloatable(false);
$GLOBALS["tm"]->setIsMovable(false);
$GLOBALS["tm"]->registerItemStyle($s);
//$GLOBALS["tm"]->registerXPStyle($xs);
$GLOBALS["tm"]->setXpEnable(true);
$GLOBALS["tm"]->setXpIconHeight(23);

$GLOBALS["tm"]->setPosition(Apycom_TreeMenu::POSITION_RELATIVE);

$GLOBALS["tm"]->setXpIconExpandNormal('themes/'.$GLOBALS['current_theme'].'/images/xpexpand1.gif');
$GLOBALS["tm"]->setXpIconExpandHover('themes/'.$GLOBALS['current_theme'].'/images/xpexpand1.gif');
$GLOBALS["tm"]->setXpIconCollapsedNormal('themes/'.$GLOBALS['current_theme'].'/images/xpcollapse1.gif');
$GLOBALS["tm"]->setXpIconCollapsedHover('themes/'.$GLOBALS['current_theme'].'/images/xpcollapse1.gif');

$GLOBALS["tm"]->setXpTitleBackgroundImage('themes/'.$GLOBALS['current_theme'].'/images/xptitle.gif');
$GLOBALS["tm"]->setXpTitleLeftImage('themes/'.$GLOBALS['current_theme'].'/images/xptitleleft.gif');
$GLOBALS["tm"]->setXpIconHeight(23);
$GLOBALS["tm"]->setXpTitleBackgroundColor('#AFB1C3');
$GLOBALS["tm"]->setIconExpandedNormal('themes/'.$GLOBALS['current_theme'].'/images/expandbtn2.gif');
$GLOBALS["tm"]->setIconExpandedHover('themes/'.$GLOBALS['current_theme'].'/images/expandbtn2.gif');
$GLOBALS["tm"]->setIconExpandedExpanded('themes/'.$GLOBALS['current_theme'].'/images/collapsebtn2.gif');
$GLOBALS["tm"]->setBlankImage(''.$GLOBALS['current_theme'].'/blank.gif');


$GLOBALS["tm"]->setShowMenuLines(true);
$GLOBALS["tm"]->setLineImageHorizontal('themes/'.$GLOBALS['current_theme'].'/images/vpoint.gif');
$GLOBALS["tm"]->setLineImageVertical('themes/'.$GLOBALS['current_theme'].'/images/hpoint.gif');
$GLOBALS["tm"]->setLineImageCorner('themes/'.$GLOBALS['current_theme'].'/images/cpoint.gif');

$GLOBALS["tm"]->setXpIconCollapsedHover('themes/'.$GLOBALS['current_theme'].'/images/xpcollapse1.gif');


/***************************************************************************************
	ITEM START DYNAMICKY VYPIS DB MENU
***************************************************************************************/
function getApyTreeTop($menu_id){
	$top_category = new CMS_Menu($menu_id);
	$nameX = "menu".$top_category->getId();
	$GLOBALS[$nameX] = new Apycom_TreeItem();

	$top_category->setContextLanguage($GLOBALS['localLanguage']);
	$defaultView = 0;
	if ($top_category->getTitle() == ''){
		$top_category->setContextLanguage($GLOBALS['localLanguageDefault']);
		$defaultView = 1;
	}

	if ($defaultView == 1){
		if ($top_category->getTitle() <> '')
			$title = $GLOBALS['defaultViewStartTag'].$top_category->getTitle().$GLOBALS['defaultViewEndTag'];
		else
			$title = $top_category->getTitle();
	}
	else{
		$title = $top_category->getTitle();
	}

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::VIEW_PRIVILEGE) === true))
		$GLOBALS[$nameX]->setLabel("&nbsp;&nbsp;&nbsp;<a class='tree_menu_link_top' href='./?cmd=6&row_id[]=".$top_category->getId()."'>".$title."</a>&nbsp;&nbsp;&nbsp;");
	else
		$GLOBALS[$nameX]->setLabel("&nbsp;&nbsp;&nbsp;".$title."&nbsp;&nbsp;&nbsp;");
	//$GLOBALS[$nameX]->setLink("./?cmd=6&row_id[]=".$top_category->getId());
	$GLOBALS["tm"]->addTreeItem($GLOBALS[$nameX]);
	$GLOBALS["tm"]->setFontStyle('bold 11px Verdana');
	$GLOBALS["tm"]->setFontColorNormal('#ffffff');
	$GLOBALS["tm"]->setFontColorHover('#e2e2e2');

	$top_category_foreach = $top_category->getItems();

	foreach($top_category_foreach as $cat_id => $cat_value){
				if((get_class($cat_value) != 'cms_modules\cms_catalog\classes\CMS_Catalog')&&(get_class($cat_value) != 'CMS_Attachment')&&(get_class($cat_value) != 'cms_modules\cms_event_calendar\classes\CMS_EventCalendar_Event'))
        	 		$isTrash = $cat_value->getIsTrash();
        		else
          			$isTrash = 0;

          		if ($isTrash == 1)
          			continue;

				$cat_value->setContextLanguage($GLOBALS['localLanguage']);
				$defaultView = 0;
				if ($cat_value->getTitle() == ''){
					$cat_value->setContextLanguage($GLOBALS['localLanguageDefault']);
					$defaultView = 1;
				}

				if ($defaultView == 1){
					if ($cat_value->getTitle() <> '')
						$title = $GLOBALS['defaultViewStartTag'].$cat_value->getTitle().$GLOBALS['defaultViewEndTag'];
					else
						$title = $cat_value->getTitle();
				}
				else{
					$title = $cat_value->getTitle();
				}

				$id = $cat_value->getId();
				$obj_type = getObjectType($cat_value,"section");
				$name = "im".$obj_type.$id;
				//$image = $cat_value->getImage();
//				if(!empty($image) or !is_null($image))
//  	       			$title = "<DIV style='margin-top:10px;'><img src='mediafiles/$image'></DIV>";
				$GLOBALS[$name] = new Apycom_TreeItem();


				$GLOBALS[$name]->setLabel(wordwrap($title,$GLOBALS['title_size'],'<br />'));


				if (get_class($cat_value) == 'CMS_Category'){
						//$GLOBALS[$name]->setLink("./?cmd=3&row_id[]=$id");
						if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::VIEW_PRIVILEGE) === true))
							$GLOBALS[$name]->setLabel("<a class='tree_menu_link' href='./?cmd=3&row_id[]=$id'>".wordwrap($title,$GLOBALS['title_size'],'<br />')."</a>");
						else
							$GLOBALS[$name]->setLabel(wordwrap($title,$GLOBALS['title_size'],'<br />'));
						$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/icon_folder.gif");
					}

				if (get_class($cat_value) == 'CMS_Weblink'){
					if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::VIEW_PRIVILEGE) === true))
						$GLOBALS[$name]->setLink("./?cmd=12&row_id[]=$id");
						$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/icon_weblink.gif");
					}

				if (get_class($cat_value) == 'CMS_Article'){
					if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::VIEW_PRIVILEGE) === true))
						$GLOBALS[$name]->setLink("./?cmd=9&row_id[]=$id");
						$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/icon_article.gif");
					}

				if (get_class($cat_value) == 'cms_modules\cms_event_calendar\classes\CMS_EventCalendar_Event'){
					if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(109, CMS_Privileges::VIEW_PRIVILEGE) === true))
						$GLOBALS[$name]->setLink("./?module=CMS_EventCalendar&mcmd=3&row_id[]=$id");
						$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/event_s.gif");
					}

				if (get_class($cat_value) == 'cms_modules\cms_gallery\classes\CMS_Gallery'){
					if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(103, CMS_Privileges::VIEW_PRIVILEGE) === true))
						$GLOBALS[$name]->setLink("./?module=CMS_Gallery&mcmd=3&row_id[]=$id");
						$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/gallery_s.gif");
					}

				if (get_class($cat_value) == 'cms_modules\cms_catalog\classes\CMS_Catalog'){
					if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(105, CMS_Privileges::VIEW_PRIVILEGE) === true))
						$GLOBALS[$name]->setLink("./?setProxia=catalog&mcmd=3&setCatalog=$id");
						$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/catalog_s.gif");
					}

				//$GLOBALS[$name]->setNormalIcon("images/home.gif");
				$GLOBALS[$name]->setItemStyle('cool_style');
				//echo $name;exit;
				$GLOBALS[$nameX]->addChildItem($GLOBALS[$name]);

				if (get_class($cat_value) == 'CMS_Category'){
						$category2 = new CMS_Category($id);
						$category_filter_foreach_vektor2 = $category2->getItems(null,true);

						if($category_filter_foreach_vektor2->getSize() == 0)
								{
								//if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::VIEW_PRIVILEGE) === true))
								//$GLOBALS[$name]->setLink("./?cmd=3&row_id[]=$id");
								}
						getApyTreeSub($id,1);
					}
		}
/*
	if ($menu_id == 2){
			$GLOBALS[$m_forum] = new Apycom_TreeItem();
			$GLOBALS[$m_forum]->setLabel('&nbsp;&nbsp;&nbsp;'.tr('FÓRUM').'&nbsp;&nbsp;&nbsp;');
			$GLOBALS[$m_forum]->setItemStyle('cool_xp');
			$GLOBALS["tm"]->addTreeItem($GLOBALS[$m_forum]);
			$GLOBALS["tm"]->setFontStyle('bold 13px Arial');
			$GLOBALS["tm"]->setFontColorNormal('#000000');
			$GLOBALS["tm"]->setFontColorHover('#000000');
			getApyTreeSubForum(1);
		}
*/
}

function getApyTreeSub($zdroj,$uroven){

	$category = new CMS_Category($zdroj);

	$category_filter_foreach = $category->getItems();
	//$category_filter_foreach = new CN_VectorIterator($category_filter_foreach_vektor);
	foreach($category_filter_foreach as $cat_id => $cat_value){

				if((get_class($cat_value) != 'cms_modules\cms_catalog\classes\CMS_Catalog')&&(get_class($cat_value) != 'CMS_Attachment')&&(get_class($cat_value) != 'cms_modules\cms_event_calendar\classes\CMS_EventCalendar_Event'))
        	 		$isTrash = $cat_value->getIsTrash();
        		else
          			$isTrash = 0;

          		if ($isTrash == 1)
          			continue;

				$cat_value->setContextLanguage($GLOBALS['localLanguage']);
				$defaultView = 0;
				if ($cat_value->getTitle() == ''){
					$cat_value->setContextLanguage($GLOBALS['localLanguageDefault']);
					$defaultView = 1;
				}

				if ($defaultView == 1){
					if ($cat_value->getTitle() <> '')
						$title = $GLOBALS['defaultViewStartTag'].$cat_value->getTitle().$GLOBALS['defaultViewEndTag'];
					else
						$title = $cat_value->getTitle();
				}
				else{
					$title = $cat_value->getTitle();
				}

				$title = wordwrap($title,$GLOBALS['title_size']-($GLOBALS['title_one_size']+$uroven),'<br />');
				//$title .= $GLOBALS['title_size']-($uroven*$GLOBALS['title_one_size']);
				$id = $cat_value->getId();
				$obj_type = getObjectType($cat_value,"section");
				$name = "im".$obj_type.$id;

				$GLOBALS[$name] = new Apycom_TreeItem();
				$GLOBALS[$name]->setLabel(wordwrap($title,$GLOBALS['title_size'],'<br />'));

				if (get_class($cat_value) == 'CMS_Category'){
						//$GLOBALS[$name]->setLink("./?cmd=3&row_id[]=$id");
						if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::VIEW_PRIVILEGE) === true))
							$GLOBALS[$name]->setLabel("<a class='tree_menu_link' href='./?cmd=3&row_id[]=$id'>".wordwrap($title,$GLOBALS['title_size'],'<br />')."</a>");
						else
							$GLOBALS[$name]->setLabel(wordwrap($title,$GLOBALS['title_size'],'<br />'));
						$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/icon_folder.gif");
					}

				if (get_class($cat_value) == 'CMS_Weblink'){
						if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::VIEW_PRIVILEGE) === true))
							$GLOBALS[$name]->setLink("./?cmd=12&row_id[]=$id");
						$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/icon_weblink.gif");
					}

				if (get_class($cat_value) == 'CMS_Article'){
						if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::VIEW_PRIVILEGE) === true))
							$GLOBALS[$name]->setLink("./?cmd=9&row_id[]=$id");
						$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/icon_article.gif");
					}

				if (get_class($cat_value) == 'cms_modules\cms_event_calendar\classes\CMS_EventCalendar_Event'){
					if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(109, CMS_Privileges::VIEW_PRIVILEGE) === true))
						$GLOBALS[$name]->setLink("./?module=CMS_EventCalendar&mcmd=3&row_id[]=$id");
					$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/event_s.gif");
					}

				if (get_class($cat_value) == 'cms_modules\cms_gallery\classes\CMS_Gallery'){
						if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(103, CMS_Privileges::VIEW_PRIVILEGE) === true))
							$GLOBALS[$name]->setLink("./?module=CMS_Gallery&mcmd=3&row_id[]=$id");
						$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/gallery_s.gif");
					}

				if (get_class($cat_value) == 'cms_modules\cms_catalog\classes\CMS_Catalog'){
					if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(105, CMS_Privileges::VIEW_PRIVILEGE) === true))
						$GLOBALS[$name]->setLink("./?setProxia=catalog&mcmd=3&setCatalog=$id");
					$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/catalog_s.gif");
					}
				$GLOBALS[$name]->setItemStyle('cool_style');
				$nazov = "imcategory".$zdroj;
				$GLOBALS[$nazov]->addChildItem($GLOBALS[$name]);
				if (get_class($cat_value) == 'CMS_Category'){
						$category2 = new CMS_Category($id);
						$category_filter_foreach_vektor2 = $category2->getItems(null,true);

						if($category_filter_foreach_vektor2->getSize() == 0)
								{
								//if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::VIEW_PRIVILEGE) === true))
									//$GLOBALS[$name]->setLink("./?cmd=3&row_id[]=$id");
								}
						$uroven++;
						getApyTreeSub($id,$uroven);
						}
		}

}

/*
function getApyTreeSubForum($idd){

	$module_forum = CMS_Module::addModule('cms_forum');
	$module_forum->utilise();

	$forum= new CMS_Forum($idd);
	$topic = $forum->getTopics();

	//$category_filter_foreach_vektor = $category->getItems();
	//$category_filter_foreach = new CN_VectorIterator($category_filter_foreach_vektor);
	foreach($topic as $cat_id => $cat_value){

				$title = $cat_value->getTitle();
				$id = $cat_value->getId();

				$name = "for".$id;

				$GLOBALS[$name] = new Apycom_TreeItem();
				$GLOBALS[$name]->setLabel(wordwrap($title,$GLOBALS['title_size'],'<br />'));


				$GLOBALS[$name]->setLink("./?topic_id=$id&cmd=topic_list");
				$GLOBALS[$name]->setNormalIcon("themes/".$GLOBALS['current_theme']."/images/icon_article.gif");


				$GLOBALS[$name]->setItemStyle('cool_style');
				$GLOBALS[$m_forum]->addChildItem($GLOBALS[$name]);
		}

}
*/

$menu_list = New CMS_MenuList();
$menu_list->addCondition("is_trash", 0);
$menu_list->execute();
foreach ($menu_list as $menu_id){
	getApyTreeTop($menu_id->getId());
}





// INIT MENU
echo $GLOBALS['tm']->render();
}
catch(CN_Exception $e){
			echo $e->getMessage();
			echo $e->displayDetails();
	}
?>
