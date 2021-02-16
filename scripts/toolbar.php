<?php
$is_help = 0;
if (file_exists("help/cmd".$_REQUEST['cmd'].".html"))
$is_help=1;

echo"<table class=\"tb_toolbar\">";

		// category manager list
if($_REQUEST['cmd'] == 1){
	if (($_GET['setup_type'] == 'visibility') || ($_GET['setup_type'] == 'access')){
		createButton('tb_toolbar','ischecked_no','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','','','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	}
	
	else{
		if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ADD_PRIVILEGE) === true))
		createButton('tb_toolbar','','','','','./?cmd=2&s_category='.$GLOBALS['smarty']->get_template_vars('s_category').'','','','all_m_add.png',tr('Nová'),tr('Nová'));
		else
		createOffButton('all_m_add_off.png',tr('Nová'),tr('Nová'));
	
		if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		{
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','3','all_m_edit.png',tr('Uprav'),tr('Uprav'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',1,'all_m_publish.png',tr('Ukáž'),tr('Ukáž'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',0,'all_m_unpublish.png',tr('Ukry'),tr('Ukry'));
		}
		else
		{
			createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));
			createOffButton('all_m_publish_off.png',tr('Ukáž'),tr('Ukáž'));
			createOffButton('all_m_unpublish_off.png',tr('Ukry'),tr('Ukry'));
		}
	
		if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ADD_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','clone','1','all_m_copy.png',tr('Kopíruj'),tr('Kopíruj'));
		else
		createOffButton('all_m_copy_off.png',tr('Kopíruj'),tr('Kopíruj'));
	
		if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::DELETE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars('max_list'),'#','trash','1','all_m_totrash.png',tr('Do koša'),tr('Do koša'));
		else
		createOffButton('all_m_totrash_off.png',tr('Do koša'),tr('Do koša'));
	}
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// category manager new
if($_REQUEST['cmd'] == 2){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ADD_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));

	}
	else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}

	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// category manager edit
if($_REQUEST['cmd'] == 3){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::UPDATE_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}
	else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::DELETE_PRIVILEGE) === true))
	createButton('tb_toolbar','checkControls','form1',0,0,'#','trash','1','all_m_totrash.png',tr('Do koša'),tr('Do koša'));
	else
	createOffButton('all_m_totrash_off.png',tr('Do koša'),tr('Do koša'));
	
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// menu manager list
if($_REQUEST['cmd'] == 4){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::ADD_PRIVILEGE) === true))
	createButton('tb_toolbar','','','','','./?cmd=5','','','all_m_add.png',tr('Nové'),tr('Nové'));
	else
	createOffButton('all_m_add_off.png',tr('Nové'),tr('Nové'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::UPDATE_PRIVILEGE) === true))
	createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','6','all_m_edit.png',tr('Uprav'),tr('Uprav'));
	else
	createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::DELETE_PRIVILEGE) === true))
	createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars('max_list'),'#','trash','1','all_m_totrash.png',tr('Do koša'),tr('Do koša'));
	else
	createOffButton('all_m_totrash_off.png',tr('Do koša'),tr('Do koša'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// category menu new
if($_REQUEST['cmd'] == 5){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::ADD_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}
	else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}

	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));

}

		// menu manager edit
if($_REQUEST['cmd'] == 6){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::UPDATE_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}
	else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}

	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));

}

		// articles manager list
if($_REQUEST['cmd'] == 7){
	
	if (($_GET['setup_type'] == 'visibility') || ($_GET['setup_type'] == 'access')|| ($_GET['setup_type'] == 'expire')){
		createButton('tb_toolbar','ischecked_no','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','','','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	}
	
	else{
	
		if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ADD_PRIVILEGE) === true))
		createButton('tb_toolbar','','','','','./?cmd=8','','','all_m_add.png',tr('Nový'),tr('Nový'));
		else
		createOffButton('all_m_add_off.png',tr('Nový'),tr('Nový'));
	
		if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		{
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',1,'all_m_publish.png',tr('Ukáž'),tr('Ukáž'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','9','all_m_edit.png',tr('Uprav'),tr('Uprav'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',0,'all_m_unpublish.png',tr('Ukry'),tr('Ukry'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','archive',1,'all_m_archive_in.png',tr('Archív'),tr('Archív'));
		}
		else
		{
			createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));
			createOffButton('all_m_publish_off.png',tr('Ukáž'),tr('Ukáž'));
			createOffButton('all_m_unpublish_off.png',tr('Ukry'),tr('Ukry'));
			createOffButton('all_m_archive_in_off.png',tr('Archív'),tr('Archív'));
		}
	
		if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ADD_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','clone','1','all_m_copy.png',tr('Kopíruj'),tr('Kopíruj'));
		else
		createOffButton('all_m_copy_off.png',tr('Kopíruj'),tr('Kopíruj'));
	
		if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::DELETE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars('max_list'),'#','trash','1','all_m_totrash.png',tr('Do koša'),tr('Do koša'));
		else
		createOffButton('all_m_totrash_off.png',tr('Do koša'),tr('Do koša'));
	}
	
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// article new
if($_REQUEST['cmd'] == 8){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ADD_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}
	else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}

	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));

}

		// article edit
if($_REQUEST['cmd'] == 9){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::UPDATE_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}
	else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::DELETE_PRIVILEGE) === true))
	createButton('tb_toolbar','checkControls','form1',0,0,'#','trash','1','all_m_totrash.png',tr('Do koša'),tr('Do koša'));
	else
	createOffButton('all_m_totrash_off.png',tr('Do koša'),tr('Do koša'));
	
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));

}

		// trash list
if($_REQUEST['cmd'] == 10){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(2, CMS_Privileges::RESTORE_PRIVILEGE) === true))
	createButton('tb_toolbar','ischecked','name_form',1,-1,'#','restore','1','all_m_restore.png',tr('Obnoviť'),tr('Obnoviť'));
	else
	createOffButton('all_m_restore_off.png',tr('Obnoviť'),tr('Obnoviť'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(2, CMS_Privileges::DELETE_PRIVILEGE) === true))
	createButton('tb_toolbar','ischecked','name_form',1,-1,'#','delete','1','all_m_delete.png',tr('Vymazať'),tr('Vymazať'));
	else
	createOffButton('all_m_delete_off.png',tr('Vymazať'),tr('Vymazať'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// archive list
if($_REQUEST['cmd'] == 11){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(3, CMS_Privileges::RESTORE_PRIVILEGE) === true))
	createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','unarchive','1','all_m_archive_out.png',tr('Obnoviť'),tr('Obnoviť'));
	else
	createOffButton('all_m_archive_out_off.png',tr('Obnoviť'),tr('Obnoviť'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(3, CMS_Privileges::DELETE_PRIVILEGE) === true))
	createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','trash','1','all_m_totrash.png',tr('Do koša'),tr('Do koša'));
	else
	createOffButton('all_m_totrash_off.png',tr('Do koša'),tr('Do koša'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// weblink manager list
if($_REQUEST['cmd'] == 12){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::ADD_PRIVILEGE) === true))
	createButton('tb_toolbar','','','','','./?cmd=13&s_category='.$GLOBALS['smarty']->get_template_vars('s_category').'','','','all_m_add.png',tr('Nový'),tr('Nový'));
	else
	createOffButton('all_m_add_off.png',tr('Nový'),tr('Nový'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::UPDATE_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','14','all_m_edit.png',tr('Uprav'),tr('Uprav'));
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',1,'all_m_publish.png',tr('Ukáž'),tr('Ukáž'));
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',0,'all_m_unpublish.png',tr('Ukry'),tr('Ukry'));
	}
	else
	{
		createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));
		createOffButton('all_m_publish_off.png',tr('Ukáž'),tr('Ukáž'));
		createOffButton('all_m_unpublish_off.png',tr('Ukry'),tr('Ukry'));
	}

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::DELETE_PRIVILEGE) === true))
	createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars('max_list'),'#','trash','1','all_m_totrash.png',tr('Do koša'),tr('Do koša'));
	else
	createOffButton('all_m_totrash_off.png',tr('Do koša'),tr('Do koša'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// weblink new
if($_REQUEST['cmd'] == 13){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::ADD_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}
	else
	{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}

	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// weblink edit
if($_REQUEST['cmd'] == 14){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::UPDATE_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}
	else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(7, CMS_Privileges::DELETE_PRIVILEGE) === true))
	createButton('tb_toolbar','checkControls','form1',0,0,'#','trash','1','all_m_totrash.png',tr('Do koša'),tr('Do koša'));
	else
	createOffButton('all_m_totrash_off.png',tr('Do koša'),tr('Do koša'));
	
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));

}

		// frontpage list
if($_REQUEST['cmd'] == 15){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(11, CMS_Privileges::UPDATE_PRIVILEGE) === true))
	createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','unfrontpage','1','frontpage_m_delete.png',tr('Zrušiť'),tr('Zrušiť'));
	else
	createOffButton('frontpage_m_delete_off.png',tr('Zrušiť'),tr('Zrušiť'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(11, CMS_Privileges::DELETE_PRIVILEGE) === true))
	createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','trash','1','all_m_totrash.png',tr('Do koša'),tr('Do koša'));
	else
	createOffButton('all_m_totrash_off.png',tr('Do koša'),tr('Do koša'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// user manager list
if($_REQUEST['cmd'] == 16){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(8, CMS_Privileges::ADD_PRIVILEGE) === true))
	createButton('tb_toolbar','','','','','./?cmd=17','','','all_m_add.png',tr('Nový'),tr('Nový'));
	else
	createOffButton('all_m_add_off.png',tr('Nový'),tr('Nový'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(8, CMS_Privileges::UPDATE_PRIVILEGE) === true)){
		createButton('tb_toolbar','ischecked','name_form',1,-1,'#','go','18','all_m_edit.png',tr('Uprav'),tr('Uprav'));
		createButton('tb_toolbar','ischecked','name_form',1,-1,'#','f_isEnabled',1,'all_m_publish.png',tr('Aktivuj'),tr('Aktivuj'));
		createButton('tb_toolbar','ischecked','name_form',1,-1,'#','f_isEnabled',0,'all_m_unpublish.png',tr('Deaktivuj'),tr('Deaktivuj'));
	}
	else{
		createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));
		createOffButton('all_m_publish_off.png',tr('Aktivuj'),tr('Aktivuj'));
		createOffButton('all_m_unpublish_off.png',tr('Deaktivuj'),tr('Deaktivuj'));
	}
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// user manager new
if($_REQUEST['cmd'] == 17){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(8, CMS_Privileges::ADD_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}
	else
	{
		createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uložiť'));
		createOffButton('all_m_publish_off.png',tr('Aktivuj'),tr('Použiť'));
	}

	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// user manager edit
if($_REQUEST['cmd'] == 18){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(8, CMS_Privileges::UPDATE_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','checkControls','name_form',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','name_form',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}
	else
	{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}

	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// language manager list
if($_REQUEST['cmd'] == 19){
	if($GLOBALS['show_add_lang'])
	{
		if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(4, CMS_Privileges::ADD_PRIVILEGE) === true))
		createButton('tb_toolbar','','','','','./?cmd=20','','','all_m_add.png',tr('Nový'),tr('Nový'));
		else
		createOffButton('all_m_add_off.png',tr('Nový'),tr('Nový'));

	}
			//createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','21','all_m_edit.png',tr('Uprav'),tr('Uprav'));
			//createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars('max_list'),'#','trash','1','all_m_totrash.png',tr('Do koša'),tr('Do koša'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// language manager new
if($_REQUEST['cmd'] == 20){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(4, CMS_Privileges::ADD_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
			//	createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
		createButton('tb_toolbar','','','','','./?cmd=19','','','all_m_back.png',tr('Späť'),tr('Späť'));
		if ($is_help)
		createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
	}
	else
	{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
				//createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
		createOffButton('all_m_back_off.png',tr('Späť'),tr('Späť'));
	}
}

		// language manager edit
if($_REQUEST['cmd'] == 21){
	createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
	createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	createButton('tb_toolbar','','','','','./?cmd=19','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// news list
if($_REQUEST['cmd'] == 24){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(10, CMS_Privileges::UPDATE_PRIVILEGE) === true))
	createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','unnews','1','news_m_delete.png',tr('Zrušiť'),tr('Zrušiť'));
	else
	createOffButton('news_m_delete_off.png',tr('Zrušiť'),tr('Zrušiť'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(10, CMS_Privileges::DELETE_PRIVILEGE) === true))
	createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','trash','1','all_m_totrash.png',tr('Do koša'),tr('Do koša'));
	else
	createOffButton('all_m_totrash_off.png',tr('Do koša'),tr('Do koša'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// options list
if($_REQUEST['cmd'] == 25){

	createButton('tb_toolbar','send_form','name_form',1,1,'#','option','1','all_m_save.png',tr('Uložiť'),tr('Uložiť'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// media manager list
if($_REQUEST['cmd'] == 26){
	createButton('tb_toolbar','','','','','./?cmd=28&m_directory='.urlencode($_GET['m_directory']),'','','file_m_add.png',tr('Nový súbor'),tr('Nový súbor'));
	createButton('tb_toolbar','','','','','./?cmd=28&zip=1&m_directory='.urlencode($_GET['m_directory']),'','','file_m_add.png',tr('Nové súbory hromadne v ZIP'),tr('Nové súbory hromadne v ZIP'));
	createButton('tb_toolbar','','','','','./?cmd=27&m_directory='.urlencode($_GET['m_directory']),'','','folder_m_add.png',tr('Nový adresár'),tr('Nový adresár'));
	createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','delete','1','all_m_delete.png',tr('Vymazať'),tr('Vymazať'));
				//createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','21','all_m_edit.png',tr('Uprav'),tr('Uprav'));
				//createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars('max_list'),'#','trash','1','all_m_totrash.png',tr('Do koša'),tr('Do koša'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// new folder in mediamanager
if($_REQUEST['cmd'] == 27){
	createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
	//createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// upload file in filemanager
if($_REQUEST['cmd'] == 28){
	createButton('tb_toolbar','validateForm','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
	if(!$_REQUEST['zip'] )
		createButton('tb_toolbar','addRow','addPosition','true',0,'#','addPosition','true','file_m_row_add.png',tr('Ďaľší súbor'),tr('Ďaľší súbor'));
	createButton('tb_toolbar','','','','','./?cmd=26','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// group list
if($_REQUEST['cmd'] == 33){
		if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(12, CMS_Privileges::ADD_PRIVILEGE) === true))
			createButton('tb_toolbar','','','','','./?cmd=34','','','all_m_add.png',tr('Nový'),tr('Nový'));
		else
			createOffButton('all_m_add_off.png',tr('Nový'),tr('Nový'));
			
		if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(12, CMS_Privileges::UPDATE_PRIVILEGE) === true)){
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','9','all_m_edit.png',tr('Uprav'),tr('Uprav'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',1,'all_m_publish.png',tr('Ukáž'),tr('Ukáž'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',0,'all_m_unpublish.png',tr('Ukry'),tr('Ukry'));
		}
		else{
			createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));		
			createOffButton('all_m_publish_off.png',tr('Ukáž'),tr('Ukáž'));
			createOffButton('all_m_unpublish_off.png',tr('Ukry'),tr('Ukry'));
			}	
		if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(12, CMS_Privileges::DELETE_PRIVILEGE) === true))
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','delete','1','all_m_delete.png',tr('Vymazať'),tr('Vymazať'));
		else
		createOffButton('all_m_delete_off.png',tr('Vymazať'),tr('Vymazať'));				
}
if($_REQUEST['cmd'] == 34){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(12, CMS_Privileges::ADD_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));

	}
	else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}

	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}
if($_REQUEST['cmd'] == 35){

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(12, CMS_Privileges::UPDATE_PRIVILEGE) === true))
	{
		createButton('tb_toolbar','validateForm','document.form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','validateForm','document.form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));

	}
	else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}

	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','help/cmd'.$_REQUEST['cmd'].'.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}
echo"</table>";
?>
