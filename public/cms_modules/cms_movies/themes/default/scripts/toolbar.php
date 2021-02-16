<?php
	$is_help = 0;
	if (file_exists("themes/default/help/mcmd".$_GET['mcmd']."_movies.html"))
			$is_help=1;
	echo"<table class=\"tb_toolbar\">";
	
		// list
		if($_GET['mcmd'] == 1){
			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(109, CMS_Privileges::ADD_PRIVILEGE) === true))
				createButton('tb_toolbar','','','','','./?mcmd=2&module='.$GLOBALS['smarty']->get_template_vars(module).'','','','all_m_add.png',tr('Nový'),tr('Nový'));
			else
				createOffButton('all_m_add_off.png',tr('Nová'),tr('Nová'));

			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(109, CMS_Privileges::UPDATE_PRIVILEGE) === true)){
				createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars(max_list),'#','go','3','all_m_edit.png',tr('Uprav'),tr('Uprav'));
				createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars(max_list),'#','c_isPublished',1,'all_m_publish.png',tr('Ukáž'),tr('Ukáž'));
				createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars(max_list),'#','c_isPublished',0,'all_m_unpublish.png',tr('Ukry'),tr('Ukry'));
			}
			else{
				createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));
				createOffButton('all_m_publish_off.png',tr('Ukáž'),tr('Ukáž'));
				createOffButton('all_m_unpublish_off.png',tr('Ukry'),tr('Ukry'));
			}
			
			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(109, CMS_Privileges::DELETE_PRIVILEGE) === true))
				createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars(max_list),'#','delete','1','all_m_delete.png',tr('Vymazať'),tr('Vymazať'));
			else
				createOffButton('all_m_delete_off.png',tr('Vymazať'),tr('Vymazať'));
				
			
			if ($is_help)
				createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_GET['mcmd'].'_movies.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
		}
		
		// company manager new
		if($_GET['mcmd'] == 2){
			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(109, CMS_Privileges::ADD_PRIVILEGE) === true)){	
				createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
				createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
			}
			else{
				createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
				createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
			}
			
			createButton('tb_toolbar','','','','','./?mcmd=1&module='.$GLOBALS['smarty']->get_template_vars(module).'','','','all_m_back.png',tr('Späť'),tr('Späť'));

			if ($is_help)
				createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_movies.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
		}
		
		// company manager edit
		if($_GET['mcmd'] == 3){
			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(109, CMS_Privileges::UPDATE_PRIVILEGE) === true)){	
				createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
				createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
			}
			else{
				createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
				createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
			}
				createButton('tb_toolbar','','','','','./?mcmd=1&module='.$GLOBALS['smarty']->get_template_vars(module).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
				if ($is_help)
					createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_movies.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
			}
	
	echo"</table>";
?>