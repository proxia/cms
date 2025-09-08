<?php
	$is_help = 0;
	if (file_exists("themes/default/help/mcmd".$_GET['mcmd']."_newsletter.html"))
			$is_help=1;
	echo"<table class=\"tb_toolbar\">";

		// newsletter sending
		if($GLOBALS['smarty']->get_template_vars(toolbar_id) == 1){

			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(104, CMS_Privileges::ADD_PRIVILEGE) === true))
				createButton('tb_toolbar','checkControls','send_form',0,0,'#','go','list','m_newsletter_send.gif',tr('Odoslať'),tr('Odoslať'));
			else
				createOffButton('all_m_add_off.png',tr('Odoslať'),tr('Odoslať'));

				if ($is_help)
					createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_GET['mcmd'].'_newsletter.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
		}

		// distribution list
		if($GLOBALS['smarty']->get_template_vars(toolbar_id) == 2){

			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(104, CMS_Privileges::ADD_PRIVILEGE) === true))
				createButton('tb_toolbar','','','','','./?showtable=1&go=new&module='.$GLOBALS['smarty']->get_template_vars(module).'','','','all_m_add.gif',tr('Nový'),tr('Nový'));
			else
				createOffButton('all_m_add_off.png',tr('Nový'),tr('Nový'));

			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(104, CMS_Privileges::UPDATE_PRIVILEGE) === true))
			{
				createButton('tb_toolbar','ischecked','distrib_list',1,$GLOBALS['smarty']->get_template_vars(max_list),'#','go','edit_','all_m_edit.gif',tr('Uprav'),tr('Uprav'));
				createButton('tb_toolbar','ischecked','distrib_list',1,$GLOBALS['smarty']->get_template_vars(max_list),'#','f_isEnabled',1,'all_m_publish.gif',tr('Ukáž'),tr('Ukáž'));
				createButton('tb_toolbar','ischecked','distrib_list',1,$GLOBALS['smarty']->get_template_vars(max_list),'#','f_isEnabled',0,'all_m_unpublish.gif',tr('Ukry'),tr('Ukry'));
			}
			else
			{
				createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));
				createOffButton('all_m_publish_off.png',tr('Ukáž'),tr('Ukáž'));
				createOffButton('all_m_unpublish_off.png',tr('Ukry'),tr('Ukry'));
			}


			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(104, CMS_Privileges::DELETE_PRIVILEGE) === true))
				createButton('tb_toolbar','ischecked','distrib_list','1',$GLOBALS['smarty']->get_template_vars(max_list),'#','delete','1','all_m_delete.gif',tr('Vymazať'),tr('Vymazať'));
			else
				createOffButton('all_m_delete_off.png',tr('Vymazať'),tr('Vymazať'));
				if ($is_help)
					createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_newsletter.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
		}

		// templates list
		if($GLOBALS['smarty']->get_template_vars(toolbar_id) == 3){

			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(104, CMS_Privileges::ADD_PRIVILEGE) === true))
				createButton('tb_toolbar','','','','','./?showtable=2&go=new&module='.$GLOBALS['smarty']->get_template_vars(module).'','','','all_m_add.gif',tr('Nová'),tr('Nová'));
			else
				createOffButton('all_m_add_off.png',tr('Nová'),tr('Nová'));

			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(104, CMS_Privileges::UPDATE_PRIVILEGE) === true))
			{
				createButton('tb_toolbar','ischecked','template_list',1,$GLOBALS['smarty']->get_template_vars(max_list),'#','go','edit_','all_m_edit.gif',tr('Uprav'),tr('Uprav'));
				createButton('tb_toolbar','ischecked','template_list',1,$GLOBALS['smarty']->get_template_vars(max_list),'#','f_isPublished',1,'all_m_publish.gif',tr('Ukáž'),tr('Ukáž'));
				createButton('tb_toolbar','ischecked','template_list',1,$GLOBALS['smarty']->get_template_vars(max_list),'#','f_isPublished',0,'all_m_unpublish.gif',tr('Ukry'),tr('Ukry'));
			}
			else
			{
				createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));
				createOffButton('all_m_publish_off.png',tr('Ukáž'),tr('Ukáž'));
				createOffButton('all_m_unpublish_off.png',tr('Ukry'),tr('Ukry'));
			}


			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(104, CMS_Privileges::DELETE_PRIVILEGE) === true))
				createButton('tb_toolbar','ischecked','template_list','1',$GLOBALS['smarty']->get_template_vars(max_list),'#','delete','1','all_m_delete.gif',tr('Vymazať'),tr('Vymazať'));
			else
				createOffButton('all_m_delete_off.png',tr('Vymazať'),tr('Vymazať'));
				if ($is_help)
					createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_newsletter.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
		}
		
		// history list
		if($GLOBALS['smarty']->get_template_vars(toolbar_id) == 4){
			
		}
		
		// new or edit distribution list
		if($GLOBALS['smarty']->get_template_vars(toolbar_id) == 5){

			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(104, CMS_Privileges::UPDATE_PRIVILEGE) === true))
			{
				createButton('tb_toolbar','checkControls','form_new_distrib',0,0,'#','go','list','all_m_save.gif',tr('Uložiť'),tr('Uložiť'));
				createButton('tb_toolbar','checkControls','form_new_distrib',0,0,'#','go','edit','all_m_apply.gif',tr('Použiť'),tr('Použiť'));
			}
			else
			{
				createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
				createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
			}

				createButton('tb_toolbar','','','','','./?mcmd=1&module='.$GLOBALS['smarty']->get_template_vars(module).'&showtable=1','','','all_m_back.gif',tr('Späť'),tr('Späť'));
			
			if ($is_help)
					createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_newsletter.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
		}
		
		// new or edit template
		if($GLOBALS['smarty']->get_template_vars(toolbar_id) == 6){

			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(104, CMS_Privileges::UPDATE_PRIVILEGE) === true))
			{
				createButton('tb_toolbar','checkControls','form_new_template',0,0,'#','go','list','all_m_save.gif',tr('Uložiť'),tr('Uložiť'));
				createButton('tb_toolbar','checkControls','form_new_template',0,0,'#','go','edit','all_m_apply.gif',tr('Použiť'),tr('Použiť'));
			}
			else
			{
				createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
				createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
			}

				createButton('tb_toolbar','','','','','./?mcmd=1&module='.$GLOBALS['smarty']->get_template_vars(module).'&showtable=2','','','all_m_back.gif',tr('Späť'),tr('Späť'));
			
			if ($is_help)
					createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_newsletter.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
		}
		
		
				// new or edit recipient
		if($GLOBALS['smarty']->get_template_vars(toolbar_id) == 7){

			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(104, CMS_Privileges::UPDATE_PRIVILEGE) === true))
			{
				createButton('tb_toolbar','checkControls','form_new_recipient',0,0,'#','go','list','all_m_save.gif',tr('Uložiť'),tr('Uložiť'));
			}
			else
			{
				createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
			}

				createButton('tb_toolbar','','','','','./?mcmd=1&module='.$GLOBALS['smarty']->get_template_vars(module).'&showtable=1','','','all_m_back.gif',tr('Späť'),tr('Späť'));
			
			if ($is_help)
					createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_newsletter.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
		}
		
		// new internal recipient
		if($GLOBALS['smarty']->get_template_vars(toolbar_id) == 8){

			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(104, CMS_Privileges::UPDATE_PRIVILEGE) === true))
			{
				createButton('tb_toolbar','ischecked','list_users',1,$GLOBALS['smarty']->get_template_vars(max_list1),'#','go','list','all_m_save.gif',tr('Priložiť'),tr('Priložiť'));
			}
			else
			{
				createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
			}

				createButton('tb_toolbar','','','','','./?mcmd=1&module='.$GLOBALS['smarty']->get_template_vars(module).'&showtable=1','','','all_m_back.gif',tr('Späť'),tr('Späť'));
			
			if ($is_help)
					createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_newsletter.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
		}
		
		// list recipients
		if($GLOBALS['smarty']->get_template_vars(toolbar_id) == 9){

			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(104, CMS_Privileges::UPDATE_PRIVILEGE) === true))
			{
				createButton('tb_toolbar','ischecked','list_recipients','1',$GLOBALS['smarty']->get_template_vars(max_list),'#','delete','1','all_m_delete.gif',tr('Vymazať'),tr('Vymazať'));
			}
			else
			{
				createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
			}

				createButton('tb_toolbar','','','','','./?mcmd=1&module='.$GLOBALS['smarty']->get_template_vars(module).'&showtable=1','','','all_m_back.gif',tr('Späť'),tr('Späť'));
			
			if ($is_help)
					createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_newsletter.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
		}
		
		// history list recipients
		if($GLOBALS['smarty']->get_template_vars(toolbar_id) == 10){

			createButton('tb_toolbar','','','','','./?mcmd=1&module='.$GLOBALS['smarty']->get_template_vars(module).'&showtable=3','','','all_m_back.gif',tr('Späť'),tr('Späť'));
			
			if ($is_help)
					createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_newsletter.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
		}
		
		// history template
		if($GLOBALS['smarty']->get_template_vars(toolbar_id) == 11){

			createButton('tb_toolbar','','','','','./?mcmd=1&module='.$GLOBALS['smarty']->get_template_vars(module).'&showtable=3','','','all_m_back.gif',tr('Späť'),tr('Späť'));
			
			if ($is_help)
					createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_newsletter.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
		}
		
	echo"</table>";
?>