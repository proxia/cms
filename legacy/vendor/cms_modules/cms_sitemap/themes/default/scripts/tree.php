<?php

require_once("cms_classes/apycom_tree_menu.php");
require_once("cms_classes/apycom_tabs.php");

    function showItems($object,$keyname){

      $object_id = $object->getId();
      if(get_class($object) != 'CMS_Catalog' )
      	$isTrash = $object->getIsTrash();
      else
		$isTrash = 0;

      if(!($object instanceof CMS_Menu))
          	$isPublished = $object->getIsPublished();

			if(get_class($object) != 'CMS_Catalog')
				$object_filter_foreach = $object->getItems();
			else
				$object_filter_foreach = $object->getChildren(); //Catalog

			foreach($object_filter_foreach as $object_filter_foreach_list => $object_filter_foreach_id)
			{
				if((get_class($object_filter_foreach_id) != 'CMS_Catalog')&&(get_class($object_filter_foreach_id) != 'CMS_Attachment')&&(get_class($object_filter_foreach_id) != 'CMS_EventCalendar_Event')&&(get_class($object_filter_foreach_id) != 'CMS_Catalog_Product'))
        	 		$isTrash = $object_filter_foreach_id->getIsTrash();
				else
          			$isTrash = 0;

				$isPublished = 0;
				if((!($object_filter_foreach_id instanceof CMS_Menu)) && (get_class($object_filter_foreach_id) != 'CMS_Attachment'))
					$isPublished = $object_filter_foreach_id->getIsPublished();
				else
					$isPublished = 1;

// 				if(get_class($object_filter_foreach_id) == "CMS_Menu")
// 						$name = "menu".$object_filter_foreach_id->getId();
// 				elseif(get_class($object_filter_foreach_id)  == "CMS_Gallery")
// 						$name = "gallery".$object_filter_foreach_id->getId();
// 				elseif(get_class($object_filter_foreach_id)  == "CMS_Category" )
// 						$name = "category".$object_filter_foreach_id->getId();
// 				elseif(get_class($object_filter_foreach_id)  == "CMS_Article" )
// 						$name = "article".$object_filter_foreach_id->getId();
// 				elseif(get_class($object_filter_foreach_id)  == "CMS_Weblink" )
// 						$name = "weblink".$object_filter_foreach_id->getId();
// 				elseif(get_class($object_filter_foreach_id)  == "CMS_Catalog" )
// 						$name = "catalog".$object_filter_foreach_id->getId();
// 				elseif(get_class($object_filter_foreach_id)  == "CMS_Catalog_Product")
// 						$name = "catalog_product".$object_filter_foreach_id->getId();
// 				elseif(get_class($object_filter_foreach_id ) == "CMS_Catalog_Branch")
// 						$name = "catalog_branch".$object_filter_foreach_id->getId();
//
// 				else
// 					{
// 						//echo get_class($object_filter_foreach_id);
// 						continue;
// 					}

				$name = get_class($object_filter_foreach_id ).":".$object_filter_foreach_id->getId();

				$GLOBALS[$name] = new Apycom_TreeItem();
				$checked = $GLOBALS["siteMapClass"]->itemExists($object_filter_foreach_id) ? " checked " : " ";
				$checkbox = "&nbsp;&nbsp;&nbsp;<input class=checkboxSiteMap type='checkbox' name='row_id[]' ".$checked." value='".$name."'>&nbsp;&nbsp;&nbsp;";

				$object_filter_foreach_id->setContextLanguage($GLOBALS['localLanguage']);
				$defaultView = 0;
				if ($object_filter_foreach_id->getTitle() == '')
				{
					$object_filter_foreach_id->setContextLanguage($GLOBALS['localLanguageDefault']);
					$defaultView = 1;
				}

				if($defaultView == 1)
					$title = $GLOBALS['defaultViewStartTag'].$object_filter_foreach_id->getTitle().$GLOBALS['defaultViewEndTag'];
				else
					$title = $object_filter_foreach_id->getTitle();

				$GLOBALS[$name]->setLabel($checkbox."".$title);
				// vyhodit polozky co su v kosi a nepublikovatelne

				// teareticky vyskusat isDisplayable
				if($isTrash==1 )
					continue;
				else if( $isPublished==0)
					continue;

				if(get_class($object_filter_foreach_id) == "CMS_Menu" or get_class($object_filter_foreach_id) == "CMS_Category")
				{
					$GLOBALS[$name]->setNormalIcon("/images/icon_folder.gif");
					showItems($object_filter_foreach_id,$name); // rekurzia
				}
				else if(get_class($object_filter_foreach_id) == "CMS_Article")
					$GLOBALS[$name]->setNormalIcon("/images/icon_article.gif");
				else if(get_class($object_filter_foreach_id) == "CMS_Weblink")
					$GLOBALS[$name]->setNormalIcon("/images/icon_weblink.gif");
				else if(get_class($object_filter_foreach_id) == "CMS_Gallery")
					$GLOBALS[$name]->setNormalIcon("/images/gallery_s.gif");
				else if(get_class($object_filter_foreach_id) == "CMS_EventCalendar_Event")
					$GLOBALS[$name]->setNormalIcon("/images/event_s.gif");
				else if(get_class($object_filter_foreach_id) == "CMS_Catalog")
				{
					$GLOBALS[$name]->setNormalIcon("/images/catalog_s.gif");
					showItems($object_filter_foreach_id,$name); // rekurzia
				}
				else if(get_class($object_filter_foreach_id) == "CMS_Catalog_Branch")
				{
					$GLOBALS[$name]->setNormalIcon("/images/category_s.gif");
					//showItems($object_filter_foreach_id,$name); // rekurzia
				}
				$GLOBALS[$keyname]->addChildItem($GLOBALS[$name]);
      		}
   	 }

    function showResult($object)
    {

      		$object_id = $object->getId();
			if(get_class($object) == "CMS_Catalog")
				$object_filter_foreach = $object->getChildren();
			else
				$object_filter_foreach = $object->getItems();
			foreach($object_filter_foreach as $object_filter_foreach_list => $object_filter_foreach_id)
			{

				if((get_class($object_filter_foreach_id) != 'CMS_Catalog')&&(get_class($object_filter_foreach_id) != 'CMS_Attachment')&&(get_class($object_filter_foreach_id) != 'CMS_EventCalendar_Event')&&(get_class($object_filter_foreach_id) != 'CMS_Catalog_Product'))
					$isTrash = $object_filter_foreach_id->getIsTrash();
				else
					$isTrash = 0;

				$isPublished = 0;
				if((!($object_filter_foreach_id instanceof CMS_Menu)) && (get_class($object_filter_foreach_id) != 'CMS_Attachment'))
					$isPublished = $object_filter_foreach_id->getIsPublished();
				else
					$isPublished = 1;

				// teareticky vyskusat isDisplayable
				if($isTrash==1 )
					continue;
				else if( $isPublished==0)
					continue;


				$GLOBALS["level"]++;
				$privateCountExists=0;

				if($GLOBALS["siteMapClass"]->itemExists($object_filter_foreach_id))
				{
					$countParents = $GLOBALS["level"]-1;

					$parent_object = $object_filter_foreach_id;
					//
					for($k=0;$k < $countParents;$k++)
					{
						if($parent_object->hasParent())
						{

							if($parent_object instanceof CMS_Category)
							{
								$parent_object = $parent_object->getParent();// vrati category
									//print($k."<font color=green>".$parent_object->getTitle()."</font>");
								if($GLOBALS["siteMapClass"]->itemExists($parent_object))
									$privateCountExists++;
									//zistit ci existuje v sitemap
									//ak neexistuje tak vypis bez odsadenia
									// inak odsadit o pocet najdenych parentov /mozno/
							}else
							{
								$parent_object_vector = $parent_object->getParents();// vrati vector
								foreach($parent_object_vector as $parent_object_vector_list => $parent_object_vector_id)
								{
									$parent_object=$parent_object_vector_id;
									if($GLOBALS["siteMapClass"]->itemExists($parent_object_vector_id))
									$privateCountExists++;
									//zistit ci existuje v sitemap
								}
							}
						}
					}
					$privateCountExists++;
					$imgWidth = $countParents*25;
					$image =  "<img src='/images/blank.gif' width='".$imgWidth."' height=1 >";
					$image .=  "<img src='/images/hpoint.gif' width='5' height=1 >";
					//echo "<br>".$color."".$GLOBALS["level"]."&nbsp;&nbsp;".$object_filter_foreach_id->getId()."&nbsp;".$object_filter_foreach_id->getTitle()."</font>&nbsp;&nbsp;&nbsp;";

					$object_filter_foreach_id->setContextLanguage($GLOBALS['localLanguage']);
					$defaultView = 0;
					if ($object_filter_foreach_id->getTitle() == ''){
						$object_filter_foreach_id->setContextLanguage($GLOBALS['localLanguageDefault']);
						$defaultView = 1;
					}

					if($defaultView == 1)
						$title = $GLOBALS['defaultViewStartTag'].$object_filter_foreach_id->getTitle().$GLOBALS['defaultViewEndTag'];
					else
						$title = $object_filter_foreach_id->getTitle();

					echo "<br>".$image."&nbsp;&nbsp;&nbsp;".$title."&nbsp;&nbsp;&nbsp;";
					}
					if(get_class($object_filter_foreach_id) == "CMS_Menu" or get_class($object_filter_foreach_id) == "CMS_Category" or get_class($object_filter_foreach_id) == "CMS_Catalog")
					showResult($object_filter_foreach_id); // rekurzia
					$GLOBALS["level"]--;

      			}
   		}

### definovanie stylov pre STROM
$s = new Apycom_TreeItemStyle('menu_style');
$s->setOption('tfontStyle', 'bold Verdana');
$s->setOption('tfontColorNormal', '#000000');
$s->setOption('titemBackColor', '#e0e0e0,#6699ff');

$s1 = new Apycom_TreeItemStyle('no_show_style');//nepouziva sa
$s1->setOption('titemBackColor', '#ff6666,#ff6666');

$GLOBALS["sitemap"] = new Apycom_TreeMenu();
$GLOBALS["sitemap"]->setSaveState(true);

$GLOBALS["sitemap"]->setWidth("'50%'");
$GLOBALS["sitemap"]->setExpandPolicy(Apycom_TreeMenu::EXPAND_POLICY_ON_ICON_CLICK);
$GLOBALS["sitemap"]->setCloseExpandedItem(false);
$GLOBALS["sitemap"]->setExpandItems(false);
//$GLOBALS["sitemap"]->setCursor('pointer');
$GLOBALS["sitemap"]->setFontColorHover('#000000');
//$GLOBALS["sitemap"]->setBackgroundColor('#ffffff');
$GLOBALS["sitemap"]->setItemBackgroundColorHover('#99ccff');
$GLOBALS["sitemap"]->setItemBackgroundColorNormal('#e8effd');
$GLOBALS["sitemap"]->setBorderColor('#ffffff');
$GLOBALS["sitemap"]->setBorderWidth(2);

$GLOBALS["sitemap"]->setGlobalImgPrefix("../cms_modules/cms_sitemap/");
$GLOBALS["sitemap"]->setBackgroundImage("/images/back1.gif");
$GLOBALS["sitemap"]->setBlankImage('/images/blank.gif');
//$GLOBALS["sitemap"]->setFontDecorationHover("underline");


## ICONS
$GLOBALS["sitemap"]->setIconExpandedNormal('/images/expandbtn2.gif');
$GLOBALS["sitemap"]->setIconExpandedHover('/images/expandbtn2.gif');
$GLOBALS["sitemap"]->setIconExpandedExpanded('/images/collapsebtn2.gif');


## XP style
$GLOBALS["sitemap"]->setXpEnable(false);
$GLOBALS["sitemap"]->setXpIconExpandNormal('/images/xpexpand1.gif');
$GLOBALS["sitemap"]->setXpIconExpandHover('/images/xpexpand1.gif');
$GLOBALS["sitemap"]->setXpIconCollapsedNormal('/images/xpcollapse2.gif');
$GLOBALS["sitemap"]->setXpIconCollapsedHover('/images/xpcollapse2.gif');


## LINES
$GLOBALS["sitemap"]->setShowMenuLines(true);
$GLOBALS["sitemap"]->setLineImageHorizontal("/images/vpoint.gif");
$GLOBALS["sitemap"]->setLineImageVertical("/images/hpoint.gif");
$GLOBALS["sitemap"]->setLineImageCorner("/images/cpoint.gif");


$GLOBALS["sitemap"]->registerItemStyle($s);
$GLOBALS["sitemap"]->registerItemStyle($s1);
$GLOBALS["sitemap"]->setPosition(Apycom_TreeMenu::POSITION_RELATIVE);


// nastavenie pre TBAS

			if(!isset($_GET['msg']))$_GET['msg'] = 0;

			$st = new Apycom_TabStyle('cool_style');
			$st->setOption('bfontStyle', '10px Verdana');
			$st->setOption('bfontColor', '#000000');

			$item1 = new Apycom_TabItem(tr("Úprava mapy stránky"), "item1");
			$item1->setTabStyle('cool_style');


			$item2 = new Apycom_TabItem(tr("Náhľad"), "item2");
			$item2->setTabStyle('cool_style');

			$t = new Apycom_Tabs();
			$t->registerTabStyle($st);

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
			$t->setSelectedItem($_GET['msg']);
			$tabs = $t->render();



### generate tree
// JAZYKOVKU doplnit
//echo $GLOBALS['localLanguage'];
     // CN_Application::getSingleton()->setLanguage($GLOBALS['localLanguage']);

        global $kernel;

		$GLOBALS["siteMapClass"] = $kernel->getContainer()->get(App\Sitemap\Sitemap::class);

		$menu_list = new CMS_MenuList();
		$menu_list->addCondition("is_trash", 0);
		$menu_list->execute();

		foreach($menu_list as $menu => $menu_id)
		{
  			$name = get_class($menu_id).":".$menu_id->getId();
  	    	$GLOBALS[$name] = new Apycom_TreeItem();
  	     	$checked = $GLOBALS["siteMapClass"]->itemExists($menu_id) ? " checked " : " ";
  			$checkbox = "&nbsp;&nbsp;&nbsp;<input class='checkboxSiteMap' type='checkbox' name='row_id[]' ".$checked." value='".$name."'>&nbsp;&nbsp;&nbsp;";

      		$menu_id->setContextLanguage($GLOBALS['localLanguage']);
			$defaultView = 0;
      		if ($menu_id->getTitle() == ''){
      			$menu_id->setContextLanguage($GLOBALS['localLanguageDefault']);
      			$defaultView = 1;
      		}

      		if($defaultView == 1)
      			$title_name = $GLOBALS['defaultViewStartTag'].$menu_id->getTitle().$GLOBALS['defaultViewEndTag'];
      		else
      			$title_name = $menu_id->getTitle();

	       	$GLOBALS[$name]->setLabel($checkbox.'&nbsp;&nbsp;&nbsp;'.$title_name.'&nbsp;&nbsp;&nbsp;');
  	     	$GLOBALS[$name]->setItemStyle('menu_style');
  	     	$GLOBALS[$name]->setNormalIcon("/images/icon_mark2.gif");
  	     	$GLOBALS["sitemap"]->addTreeItem($GLOBALS[$name]);
  			showItems($menu_id,$name);
      	}
?>
		<table align="center" class="tb_tabs">
		<tr><td colspan="2"><br /></td></tr>
		<tr class="tr_header_tab">
			<td colspan="2" class="td_tabs_top">
					<?=$tabs?>
			</td>
		</tr>
		<tr><td class="td_valign_top" colspan="2">
				<div id="item1" style="visibility: hidden;">
        <form name='siteMap' id='siteMap' action='/sitemap/save' method='POST'>
  			<input type=hidden name=mcmd value=2 >
  			<input type='hidden' id='section' name='section' value='new' />

<?php
      // INIT TREE
      echo $GLOBALS['sitemap']->render();
?>
        </form>
        </div>
		<div id="item2" style="visibility: hidden;">
<?php
	$GLOBALS["level"] = 0;
	$menu_list_nahlad = new CMS_MenuList();
	$menu_list_nahlad->addCondition("is_trash", 0);
	$menu_list_nahlad->execute();
	$GLOBALS["menu_id"] = null;
	foreach($menu_list_nahlad as $menu_nahlad => $menu_nahlad_id)
	{
         $GLOBALS["level"]++;
         $GLOBALS["countExists"]=0;
         $imgWidth = 25;
         $GLOBALS["menu_id"].$menu_nahlad_id->getId();
         if($GLOBALS["siteMapClass"]->itemExists($menu_nahlad_id)){
             $image =  "<img src='cms_modules/cms_sitemap/images/blank.gif' width='".$imgWidth."' height=1>";
             $image .=  "<img src='cms_modules/cms_sitemap/images/hpoint.gif' width='5' height=1>";
			 $menu_nahlad_id->setContextLanguage($GLOBALS['localLanguage']);
			$defaultView = 0;
			if ($menu_nahlad_id->getTitle() == ''){
				$menu_nahlad_id->setContextLanguage($GLOBALS['localLanguageDefault']);
				$defaultView = 1;
			}

			if($defaultView == 1)
				$title_name_nahlad = $GLOBALS['defaultViewStartTag'].$menu_nahlad_id->getTitle().$GLOBALS['defaultViewEndTag'];
			else
				$title_name_nahlad = $menu_nahlad_id->getTitle();

             echo "<br>".$image."&nbsp;&nbsp;&nbsp;".$title_name_nahlad."&nbsp;&nbsp;&nbsp;";
            // echo "<div>";
         }
		 showResult($menu_nahlad_id);
         $GLOBALS["level"]--;
      }
?>
	  </div>
	</td> </tr>
</table>
