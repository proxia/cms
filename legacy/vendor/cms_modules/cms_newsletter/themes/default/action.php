<?php
//$post = var_export($_POST,true);echo($post);EXIT;

if(!isset($_POST['go']))$_POST['go'] = false;
if(!isset($_POST['delete']))$_POST['delete'] = false;
if(!isset($_POST['add_attachment']))$_POST['add_attachment'] = false;
if(!isset($_POST['remove_attachment']))$_POST['remove_attachment'] = false;
if(!isset($_POST['rename_attachment']))$_POST['rename_attachment'] = false;
if(!isset($_POST['update_attachment']))$_POST['update_attachment'] = false;
if(!isset($_POST['attach_update']))$_POST['attach_update'] = false;

try
{
	ini_set("include_path",ini_get('include_path').PATH_SEPARATOR.realpath('../../'));
	
	$GLOBALS['project_folder']="/_sub";
	
	##############################################
	# login
	
	if(isset($_SESSION['user'])){
		$u = CMS_UserLogin::getSingleton();
		
		if($_SESSION['user']['type'] == CMS_UserLogin::ADMIN_USER){
			$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);
			
			include("admin/dblogin.php");
			
			$data->setDataSource("proxia");
			$data->open();
			
			$u->setUserType(CMS_UserLogin::ADMIN_USER);
			$u->autoLogin();
		}
		elseif($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER){
			$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);
			
			if (!isset($GLOBALS['project_config']))
				$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);
				
			$data->setUser($GLOBALS['project_config']->getSqlUser());
			$data->setPassword($GLOBALS['project_config']->getSqlPassword());
			$data->setDataSource($GLOBALS['project_config']->getSqlDsn());
			$data->open();
	
			$u->setUserType(CMS_UserLogin::REGULAR_USER);
			$u->autoLogin();
		}
		
		CN_SqlDatabase::removeDatabase();
	}
	
	##############################################
	
	$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);
	
	include ("admin/themes/{$GLOBALS['current_theme']}/scripts/functions.php");
	
	$path = "../../".$GLOBALS['project_folder']."/".$_SESSION['user']['name']."/config";
	
 	//  START DB
	if (!isset($GLOBALS['project_config']))
		$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);
	
	$data->setUser($GLOBALS['project_config']->getSqlUser());
	$data->setPassword($GLOBALS['project_config']->getSqlPassword());
	
	$data->setDataSource($_SESSION['user']['dsn']);
	$data->open();
	
	$GLOBALS["config_all"] = CN_Config::loadFromFile($path."/config.xml");
	
	$user_detail = CMS_UserLogin::getSingleton()->getUser();
	
	$GLOBALS['localLanguage'] = $user_detail->getConfigValue('default_local_language');
	
	if (!$GLOBALS['localLanguage'])
		$GLOBALS['localLanguage'] = getConfig('proxia','default_local_language');
	
	####################################################################################################
	if (CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Company')){
		$mod = CMS_Module::addModule('CMS_Company');
		$mod->utilise();
	}
	
	if($_POST['section'] == 'distribution_list'):
		if (is_Array($_POST['row_id'])){
			
			if ($_POST['go'] == 'edit_') {
				Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=1&row_id[]=".$_POST['row_id'][0]."&go=edit");
				exit;
			}
			
			foreach ($_POST['row_id'] as $name => $id){
				$forum = $id === '0' ? new CMS_Newsletter_DistributionList() : new CMS_Newsletter_DistributionList($id);
				$forum->setContextLanguage($GLOBALS['localLanguage']);
				
				foreach($_POST as $column_name => $value){
					
					if(strpos($column_name, 'f_') !== FALSE){
						
						$column_name = str_replace('f_', '', $column_name);
						
						$function = 'set'.ucfirst($column_name);
						
						$forum->$function($value);
					}
				}// END FOREACH F_
				
				$forum->save();
				$new_id = $forum->getId();
				
				if($_POST['delete']==1){
					$forum->delete();
				}
				
			}// END FOREACH ROW_ID
			
		}// END IF $_POST['row_id']
		
		if ($_POST['go'] == 'list') {
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=1&go=".$_POST['go']);
			exit;
		}
		
		if ($_POST['go'] == 'edit') {
			$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&row_id[]=$new_id$link&showtable=1&go=".$_POST['go']);
			exit;
		}
		
		Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=1&go=".$_POST['go']);
		exit;
	endif;
	
	if($_POST['section'] == 'template'):
		
		if (is_Array($_POST['row_id'])){
			
			if ($_POST['go'] == 'edit_') {
				Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=2&go=edit&row_id[]=".$_POST['row_id'][0]);
				exit;
			}
			
			$_POST['f_UsableBy'] = CMS_Newsletter::ENTITY_ID;
			foreach ($_POST['row_id'] as $name => $id){
				$forum = $id === '0' ? new CMS_Article() : new CMS_Article($id);
				$forum->setContextLanguage('sk');
				
				if ($_POST['add_attachment'] == 1){
					$priloha = new CMS_Attachment();
					$priloha->setContextLanguage($GLOBALS['localLanguage']);
				}
				
				foreach($_POST as $column_name => $value){
					
					if(strpos($column_name, 'f_') !== FALSE){
						
						$column_name = str_replace('f_', '', $column_name);
						
						$function = 'set'.ucfirst($column_name);
						
						$forum->$function($value);
					}
					
					if ($_POST['add_attachment'] == 1){
						if(strpos($column_name, 'p__') !== FALSE){
							$column_name = str_replace('p__', '', $column_name);
							$function = 'set'.ucfirst($column_name);
							$priloha->$function($value);
							
						}
					}
					
				}// END FOREACH F_
				
				$forum->save();
				$new_id = $forum->getId();
				
				if ($_POST['add_attachment'] == 1){
					$priloha->save();
					$new_id_attach = $priloha->getId();
					$forum->addAttachment($priloha);
				}
				
				// upravy priloh start
				
				if (($_POST['update_attachment'])&&($_POST['attach_update'])){
					$pole_lang = Array(0=>'');
					foreach($_POST as $column_name => $value){
						if(strpos($column_name, 'language_visibility') !== FALSE){
							$pole_lang[] = substr($column_name,19);
						}
					}
					
					foreach ($forum->getAttachments() as $value){
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
								$priloha->delete();
							}
						}
					}
				}
				// upravy priloh end
				
				if($_POST['delete']==1){
					$forum->delete();
				}
				
			}// END FOREACH ROW_ID
			
		}// END IF $_POST['row_id']
		
		if ($_POST['go'] == 'list') {
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=2&go=".$_POST['go']);
			exit;
		}
		
		if ($_POST['go'] == 'edit') {
			$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&row_id[]=$new_id$link&showtable=2&go=".$_POST['go']);
			exit;
		}
		
		Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=2&go=list");
		exit;
	endif;
	
	if($_POST['section'] == 'recipient'):
		$forum = new CMS_Newsletter_DistributionList($_POST['distribution']);
		$forum->addExternalRecipient($_POST['f_email'],$_POST['f_firstName'], $_POST['f_familyName']);
		$forum->save();
		$new_id = $forum->getId();
		
		if ($_POST['go'] == 'list') {
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=1&go=list_recipients&row_id[]=".$_POST['distribution']);
			exit;
		}
		
		if ($_POST['go'] == 'edit') {
			$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&row_id[]=$new_id$link&showtable=1&go=".$_POST['go']);
			exit;
		}
	
	endif;
	
	if($_POST['section'] == 'recipient_file'):
		$distrib = new CMS_Newsletter_DistributionList($_POST['distribution']);
		$distrib->ImportRecipientsFromCsv($_FILES['file']['tmp_name'],$_POST['odd_pole'],$_POST['odd_text']);
		
		if ($_POST['go'] == 'list') {
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=1&go=list_recipients&row_id[]=".$_POST['distribution']);
			exit;
		}
		
		if ($_POST['go'] == 'edit') {
			$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&row_id[]=$new_id$link&showtable=1&go=".$_POST['go']);
			exit;
		}
		
	endif;

	if($_POST['section'] == 'internal_recipient'):
		foreach ($_POST['row_id'] as $user_id){
			if (($_POST['filter'] == 1) || ($_POST['filter'] == 2)){
				$rec_user = new CMS_User($user_id);
				$forum = new CMS_Newsletter_DistributionList($_POST['distribution']);
				$forum->addRecipient($rec_user);
				$forum->save();
			}
			
			if ($_POST['filter'] == 3){
				$rec_user = new CMS_Company($user_id);
				$forum = new CMS_Newsletter_DistributionList($_POST['distribution']);
				$forum->addRecipient($rec_user);
				$forum->save();
			}
		}
		
		if ($_POST['go'] == 'list') {
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=1&go=list_recipients&row_id[]=".$_POST['distribution']);
			exit;
		}
		
		if ($_POST['go'] == 'edit') {
			$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&row_id[]=$new_id$link&showtable=1&go=".$_POST['go']);
			exit;
		}
		
	endif;
	
	if($_POST['section'] == 'remove_recipients'):
		foreach ($_POST['row_id'] as $user_id){
			$recipient = explode(",",$user_id);
			if($recipient[0] == 'x'){
				$forum = new CMS_Newsletter_DistributionList($_POST['distribution']);
				$forum->removeExternalRecipient($recipient[2]);
			}
			else{
				
				$class_name = CMS_Entity::getEntitynameById($recipient[1]);
				
				$entity = new $class_name($recipient[0]);
				$forum = new CMS_Newsletter_DistributionList($_POST['distribution']);
				$forum->removeRecipient($entity);
			}
		}
		
		if ($_POST['go'] == 'list') {
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=2&go=list_recipients");
			exit;
		}
		
		if ($_POST['go'] == 'edit') {
			$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&row_id[]=$new_id$link&showtable=1&go=".$_POST['go']);
			exit;
		}
		
		Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=1&go=list_recipients&row_id[]=".$_POST['distribution']);
		exit;
	endif;
	
	if($_POST['section'] == 'add_exclude_list'):
		
		CMS_Newsletter::addToExcludeList($_POST['exclude_email']);
		
		Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=5&go=".$_POST['go']);
		exit;
		
	endif;
	
	if($_POST['section'] == 'send'):
		$forum = new CMS_Newsletter_DistributionList($_POST['distribution']);
		$forum->setContextLanguage('sk');
		$new_distrib = $forum->clonedistributionlist();
		$new_distrib->setParentDistributionList($forum);
		$template = new CMS_Article($_POST['template']);
		$new_template = clone($template);
		$new_template->save();

		# clone attachments ##################

		$orig_attachments = $template->getAttachments();

		foreach ($orig_attachments as $orig_attachment)
		{
			$new_attachment = new CMS_Attachment();
			$new_attachment->setFile($orig_attachment->getFile());

			foreach($GLOBALS['project_config']->getAvailableTranslations() as $locale)
			{
				$orig_attachment->setContextLanguage($locale);
				$new_attachment->setContextLanguage($locale);

				$new_attachment->setTitle($orig_attachment->getTitle());
				$new_attachment->setDescription($orig_attachment->getDescription());
				$new_attachment->setLanguageIsVisible($orig_attachment->getLanguageIsVisible());
			}

			$new_attachment->save();

			$new_template->addAttachment($new_attachment);
		}

		######################################
		
		$new_distrib->setTemplate($new_template->getId());
		$new_distrib->setSender($_POST['sender_email']);
		$new_distrib->setSenderName($_POST['sender_name']);
		$new_distrib->save();
		$new_distrib->send($_POST['send_type'],'sk');
		
		if ($_POST['go'] == 'list') {
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&showtable=1&go=".$_POST['go']);
			exit;
		}
		
		if ($_POST['go'] == 'edit') {
			$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
			$link = urlPost($ignore);
			Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter&row_id[]=$new_id$link&showtable=1&go=".$_POST['go']);
			exit;
		}
		
	endif;
	
	if ($_POST['go'] == 'list') {
		Header("Location: ../../admin/?mcmd=1&module=CMS_Newsletter");
		exit;
	}
	
	if ($_POST['go'] == 'edit') {
		$ignore = array ("row_id","mcmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
		$link = urlPost($ignore);
		Header("Location: ../../admin/?mcmd=3&module=CMS_Newsletter&row_id[]=$new_id$link");
		exit;
	}
	
	Header("Location: ../../?module=CMS_Newsletter&mcmd=1");
	exit;
}
catch(CN_Exception $e){
	echo $e->displayDetails();
}
?>
