<?php
try{

	include($GLOBALS['smarty']->get_template_vars(path_relative)."themes/default/scripts/functions.php");
	switch ($_GET["mcmd"]) {
		// newsletter *********************************************************************************
		case "1":{
				// nastavenie zobrazenia uvodneho bloku
				if(!isset($_GET['showtable']))$_GET['showtable'] = 0;
				require_once("cms_classes/apycom_tabs.php");

				$st = new Apycom_TabStyle('cool_style');
				$st->setOption('bfontStyle', '10px Verdana');
				$st->setOption('bfontColor', '#000000');

				$item1 = new Apycom_TabItem(tr("Odoslanie správy"), "javascript:ukaz(0,4)");
				$item1->setTabStyle('cool_style');


				$item2 = new Apycom_TabItem(tr("Distribučné zoznamy"), "javascript:ukaz(1,4)");
				$item2->setTabStyle('cool_style');

				$item3 = new Apycom_TabItem(tr("Šablóny"), "javascript:ukaz(2,4)");
				$item3->setTabStyle('cool_style');

				$item4 = new Apycom_TabItem(tr("História"), "javascript:ukaz(3,4)");
				$item4->setTabStyle('cool_style');


				$t = new Apycom_Tabs();
				$t->registerTabStyle($st);
				$t->setBlankImage('themes/default/images/blank.gif');
				$t->setItemBeforeImageNormal('themes/default/images/tabs/tab01_before_n2.gif');
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
				$GLOBALS["smarty"]->assign("showtable",$_GET['showtable']);
				$GLOBALS["smarty"]->assign("go",$_GET['go']);
				$GLOBALS["smarty"]->assign("newsletter_menu",$t->render());

				$GLOBALS["smarty"]->assign("FORMAT_PLAIN_TEXT",CMS_Newsletter_DistributionList::FORMAT_PLAIN_TEXT);
				$GLOBALS["smarty"]->assign("FORMAT_HTML",CMS_Newsletter_DistributionList::FORMAT_HTML);


				$distribution_list = new CMS_Newsletter_DistributionListList();
				$distribution_list->addCondition("send_date IS NULL", null, null, true);
				$distribution_list->execute();
				$GLOBALS["smarty"]->assign("distribution_list",$distribution_list);
				$templates_list = new CMS_ArticleList();
				$templates_list->addCondition("usable_by", CMS_Newsletter::ENTITY_ID);
				$templates_list->addCondition("is_archive", 0);
				$templates_list->execute();
				$GLOBALS["smarty"]->assign("templates_list",$templates_list);


				$distribution_list2 = new CMS_Newsletter_DistributionListList();
				$distribution_list2->addCondition("send_date IS NULL", null, null, true);
				$distribution_list2->addCondition("is_enabled", 1);
				$distribution_list2->execute();
				$GLOBALS["smarty"]->assign("distribution_list2",$distribution_list2);
				$templates_list2 = new CMS_ArticleList();
				$templates_list2->addCondition("usable_by", CMS_Newsletter::ENTITY_ID);
				$templates_list2->addCondition("is_archive", 0);
				$templates_list2->addCondition("is_published", 1);
				$templates_list2->execute();
				$GLOBALS["smarty"]->assign("templates_list2",$templates_list2);


				// distribution list edit
				if (($_GET['showtable'] == 1) && ($_GET['go'] == 'edit')){
					$distribution_edit = new CMS_Newsletter_DistributionList($_GET['row_id'][0]);
					$distribution_edit->execute();
					//print_r($distribution_edit);
					$GLOBALS["smarty"]->assign("distribution_edit",$distribution_edit);
				}

				// distribution list recipients
				if ( (($_GET['showtable'] == 1) && ($_GET['go'] == 'list_recipients')) || (($_GET['showtable'] == 3) && ($_GET['go'] == 'history_list_recipients'))){
					if (CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Company')){
						$mod = CMS_Module::addModule('CMS_Company');
						$mod->utilise();
					}
					$distribution_list_edit = new CMS_Newsletter_DistributionList($_GET['row_id'][0]);
					$distribution_list_edit->execute();
					$distribution_list_recipients = $distribution_list_edit->getRecipients();
					$GLOBALS["smarty"]->assign("obj_user",CMS_User::ENTITY_ID);
					$GLOBALS["smarty"]->assign("obj_company",CMS_Company::ENTITY_ID);
					$GLOBALS["smarty"]->assign("distribution_list_edit",$distribution_list_edit);
					$GLOBALS["smarty"]->assign("distribution_list_recipients",$distribution_list_recipients);
				}

				// new recipients
				if (($_GET['showtable'] == 1) && ($_GET['go'] == 'new_recipient')){
					$distribution_list = new CMS_Newsletter_DistributionList($_GET['row_id'][0]);
					$distribution_list->execute();
					//print_r($distribution_edit);
					$GLOBALS["smarty"]->assign("distribution_list",$distribution_list);
				}

				// new file recipients
				if (($_GET['showtable'] == 1) && ($_GET['go'] == 'new_file_recipients')){
					$distribution_list = new CMS_Newsletter_DistributionList($_GET['row_id'][0]);
					$distribution_list->execute();
					//print_r($distribution_edit);
					$GLOBALS["smarty"]->assign("distribution_list",$distribution_list);
				}

				// new internal recipients
				if (($_GET['showtable'] == 1) && ($_GET['go'] == 'new_internal_recipient')){

					if (CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Company')){
						$GLOBALS["smarty"]->assign("mod_company",1);
					}
					else
					$GLOBALS["smarty"]->assign("mod_company",0);

					if($_GET['filter'] == 1){
						$list_users = new CMS_UserList();
						$list_users->addCondition('is_editor', 0);
						$list_users->execute();
					}

					if($_GET['filter'] == 2){
						$list_users = new CMS_UserList();
						$list_users->addCondition('is_editor', 1);
						$list_users->execute();
					}

					if(($_GET['filter'] == 3)&&(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Company'))){
						$mod = CMS_Module::addModule('CMS_Company');
						$mod->utilise();
						$list_users = new CMS_Company_CompanyList();
						$list_users->addCondition('is_enabled', 1);
						$list_users->execute();
					}

					$GLOBALS["smarty"]->assign("list_users",$list_users);
					$distribution_list = new CMS_Newsletter_DistributionList($_GET['row_id'][0]);
					$distribution_list->execute();
					$GLOBALS["smarty"]->assign("filter",$_GET['filter']);
					$GLOBALS["smarty"]->assign("distribution_list",$distribution_list);
				}

				// template list edit
				if ( (($_GET['showtable'] == 2) && ($_GET['go'] == 'edit')) || (($_GET['showtable'] == 3) && ($_GET['go'] == 'history_template'))){
					$template_edit = new CMS_Article($_GET['row_id'][0]);
					$template_edit->execute();
					//print_r($template_edit);
					$GLOBALS["smarty"]->assign("template_edit",$template_edit);
								// nacitanie listu priloch
					$attach = $template_edit->getAttachments();
					$GLOBALS["smarty"]->assign("attach_list",$attach);
				}

				$history_list = new CMS_Newsletter_DistributionListList();
				$history_list->addCondition("send_date IS NOT NULL", null, null, true);
				$history_list->setSortDirection('DESC');
				$history_list->execute();

				$GLOBALS["smarty"]->assign("history_list",$history_list);
				$GLOBALS["smarty"]->display("newsletter.tpl");
			}
		break;
		//*************************************************************************************************

		// nove forum *********************************************************************************
		case "2":{
				$GLOBALS["smarty"]->display("new.tpl");
			}
		break;
		//*************************************************************************************************

		// update forumu *********************************************************************************
		case "3":{
				$forum = new CMS_Forum($_REQUEST['row_id'][0]);

				$forum->execute();

				$topic = $forum->getTopics();

				$users = new CMS_UserList();
				$users->addCondition("is_editor", 1);
				$users -> execute();

				$GLOBALS["smarty"]->assign("user_list",$users);
				$GLOBALS["smarty"]->assign("num_tem",$topic->getSize());
				$GLOBALS["smarty"]->assign("topic",$topic);
				$GLOBALS["smarty"]->assign("detail_forum",$forum);
				$GLOBALS["smarty"]->display("edit.tpl");
			}
		break;
		//*************************************************************************************************

	}
}
catch(CN_Exception $e){
	echo $e->getMessage();
	echo $e->displayDetails();
}

?>
