<?php
$is_help = 0;
if (file_exists("themes/default/help/mcmd".$_GET['mcmd']."_catalog.html"))
$is_help=1;
echo"<table class=\"tb_toolbar\">";

		// catalog manager list
if($_GET['mcmd'] == 1){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(105, CMS_Privileges::ADD_PRIVILEGE) === true))
		createButton('tb_toolbar','','','','','./?mcmd=2&module='.$GLOBALS['smarty']->get_template_vars('module').'','','','all_m_add.png',tr('Nový'),tr('Nový'));
	else
		createOffButton('all_m_add_off.png',tr('Nový'),tr('Nový'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(105, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		{
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','3','all_m_edit.png',tr('Uprav'),tr('Uprav'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',1,'all_m_publish.png',tr('Ukáž'),tr('Ukáž'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',0,'all_m_unpublish.png',tr('Ukry'),tr('Ukry'));
		}
	else{
			createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));
			createOffButton('all_m_publish_off.png',tr('Ukáž'),tr('Ukáž'));
			createOffButton('all_m_unpublish_off.png',tr('Ukry'),tr('Ukry'));
		}

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(105, CMS_Privileges::DELETE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars('max_list'),'#','delete','1','all_m_delete.png',tr('Vymazať'),tr('Vymazať'));
	else
		createOffButton('all_m_delete_off.png',tr('Vymazať'),tr('Vymazať'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_GET['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// catalog manager new
if($_GET['mcmd'] == 2){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(105, CMS_Privileges::ADD_PRIVILEGE) === true)){
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// catalog manager edit
if($_GET['mcmd'] == 3){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(105, CMS_Privileges::ADD_PRIVILEGE) === true)){
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// branch list
if($_GET['mcmd'] == 4){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050001, CMS_Privileges::ADD_PRIVILEGE) === true))
		createButton('tb_toolbar','','','','','./?mcmd=5&module='.$GLOBALS['smarty']->get_template_vars('module').'','','','all_m_add.png',tr('Nová'),tr('Nová'));
	else
		createOffButton('all_m_add_off.png',tr('Nová'),tr('Nová'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050001, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		{
			//createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','6','all_m_edit.png',tr('Uprav'),tr('Uprav'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',1,'all_m_publish.png',tr('Ukáž'),tr('Ukáž'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',0,'all_m_unpublish.png',tr('Ukry'),tr('Ukry'));
		}
	else{
			createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));
			createOffButton('all_m_publish_off.png',tr('Ukáž'),tr('Ukáž'));
			createOffButton('all_m_unpublish_off.png',tr('Ukry'),tr('Ukry'));
	}
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050001, CMS_Privileges::DELETE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars('max_list'),'#','delete','1','all_m_delete.png',tr('Vymazať'),tr('Vymazať'));
	else
		createOffButton('all_m_delete_off.png',tr('Vymazať'),tr('Vymazať'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_GET['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// branch new
if($_GET['mcmd'] == 5){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050001, CMS_Privileges::ADD_PRIVILEGE) === true)){
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
		createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// branch edit
if($_GET['mcmd'] == 6){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050001, CMS_Privileges::ADD_PRIVILEGE) === true)){
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// atribut list
if($_GET['mcmd'] == 7){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::ADD_PRIVILEGE) === true))
		createButton('tb_toolbar','','','','','./?mcmd=8&module='.$GLOBALS['smarty']->get_template_vars('module').'','','','all_m_add.png',tr('Nový'),tr('Nový'));
	else
		createOffButton('all_m_add_off.png',tr('Nový'),tr('Nový'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','9','all_m_edit.png',tr('Uprav'),tr('Uprav'));
	else
		createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::DELETE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars('max_list'),'#','delete','1','all_m_delete.png',tr('Vymazať'),tr('Vymazať'));
	else
		createOffButton('all_m_delete_off.png',tr('Vymazať'),tr('Vymazať'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_GET['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// atribut new
if($_GET['mcmd'] == 8){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::ADD_PRIVILEGE) === true)){
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// atribut edit
if($_GET['mcmd'] == 9){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::ADD_PRIVILEGE) === true)){
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// produkt list
if($_GET['mcmd'] == 10){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::ADD_PRIVILEGE) === true))
		createButton('tb_toolbar','','','','','./?mcmd=11&module='.$GLOBALS['smarty']->get_template_vars('module').'','','','all_m_add.png',tr('Nový'),tr('Nový'));
	else
		createOffButton('all_m_add_off.png',tr('Nový'),tr('Nový'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::UPDATE_PRIVILEGE) === true)){
		//createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','12','all_m_edit.png',tr('Uprav'),tr('Uprav'));
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',1,'all_m_publish.png',tr('Ukáž'),tr('Ukáž'));
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',0,'all_m_unpublish.png',tr('Ukry'),tr('Ukry'));
	}else{
		createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));
		createOffButton('all_m_publish_off.png',tr('Ukáž'),tr('Ukáž'));
		createOffButton('all_m_unpublish_off.png',tr('Ukry'),tr('Ukry'));
	}
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::DELETE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars('max_list'),'#','delete','1','all_m_delete.png',tr('Vymazať'),tr('Vymazať'));
	else
		createOffButton('all_m_delete_off.png',tr('Vymazať'),tr('Vymazať'));

	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_GET['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// produkt new
if($_GET['mcmd'] == 11){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::ADD_PRIVILEGE) === true)){
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// produkt edit
if($_GET['mcmd'] == 12){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::ADD_PRIVILEGE) === true)){
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// map attribut to more product
if($_GET['mcmd'] == 13){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','12','all_m_edit.png',tr('Označené položky priradiť'),tr('Označené položky priradiť'));
	else
		createOffButton('all_m_edit_off.png',tr('Označené položky priradiť'),tr('Označené položky priradiť'));

	createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// unmap attribut to more product
if($_GET['mcmd'] == 14){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','12','all_m_edit.png',tr('Označené položky vymazať'),tr('Označené položky vymazať'));
	else
		createOffButton('all_m_edit_off.png',tr('Označené položky priradiť'),tr('Označené položky priradiť'));
	createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// map product to more attribut
if($_GET['mcmd'] == 15){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','12','all_m_edit.png',tr('Označené položky priradiť'),tr('Označené položky priradiť'));
	else
		createOffButton('all_m_edit_off.png',tr('Označené položky priradiť'),tr('Označené položky priradiť'));

	createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// unmap product to more attribut
if($_GET['mcmd'] == 16){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','12','all_m_edit.png',tr('Označené položky vymazať'),tr('Označené položky vymazať'));
	else
		createOffButton('all_m_edit_off.png',tr('Označené položky vymazať'),tr('Označené položky vymazať'));

	createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}


		// produkt list language
if($_GET['mcmd'] == 17){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','','','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
	else
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));

	createButton('tb_toolbar','','','','','./?mcmd=10&module='.$GLOBALS['smarty']->get_template_vars('module').'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_GET['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// branch list tree
if($_GET['mcmd'] == 18){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050001, CMS_Privileges::ADD_PRIVILEGE) === true))
		createButton('tb_toolbar','','','','','./?mcmd=5&module='.$GLOBALS['smarty']->get_template_vars('module').'','','','all_m_add.png',tr('Nová'),tr('Nová'));
	else
		createOffButton('all_m_add_off.png',tr('Nová'),tr('Nová'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050001, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		{
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','6','all_m_edit.png',tr('Uprav'),tr('Uprav'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',1,'all_m_publish.png',tr('Ukáž'),tr('Ukáž'));
			createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','f_isPublished',0,'all_m_unpublish.png',tr('Ukry'),tr('Ukry'));
		}
	else{
			createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));
			createOffButton('all_m_publish_off.png',tr('Ukáž'),tr('Ukáž'));
			createOffButton('all_m_unpublish_off.png',tr('Ukry'),tr('Ukry'));
	}
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050001, CMS_Privileges::DELETE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars('max_list'),'#','delete','1','all_m_delete.png',tr('Vymazať'),tr('Vymazať'));
	else
		createOffButton('all_m_delete_off.png',tr('Vymazať'),tr('Vymazať'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_GET['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}


		// branch list language
if($_GET['mcmd'] == 19){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(105, CMS_Privileges::ADD_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','','','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
	else
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));

	createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_GET['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// map branch to more product
if($_GET['mcmd'] == 20){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(105, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','12','all_m_edit.png',tr('Označené položky priradiť'),tr('Označené položky priradiť'));
	else
		createOffButton('all_m_edit_off.png',tr('Označené položky priradiť'),tr('Označené položky priradiť'));

	createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// unmap branch to more product
if($_GET['mcmd'] == 21){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(105, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','12','all_m_edit.png',tr('Označené položky odobrať'),tr('Označené položky odobrať'));
	else
		createOffButton('all_m_edit_off.png',tr('Označené položky odobrať'),tr('Označené položky odobrať'));

	createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// atribut list
if($_GET['mcmd'] == 23){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::ADD_PRIVILEGE) === true))
		createButton('tb_toolbar','','','','','./?mcmd=24&module='.$GLOBALS['smarty']->get_template_vars('module').'','','','all_m_add.png',tr('Nový'),tr('Nový'));
	else
		createOffButton('all_m_add_off.png',tr('Nový'),tr('Nový'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::UPDATE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1',1,$GLOBALS['smarty']->get_template_vars('max_list'),'#','go','25','all_m_edit.png',tr('Uprav'),tr('Uprav'));
	else
		createOffButton('all_m_edit_off.png',tr('Uprav'),tr('Uprav'));

	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::DELETE_PRIVILEGE) === true))
		createButton('tb_toolbar','ischecked','form1','1',$GLOBALS['smarty']->get_template_vars('max_list'),'#','delete','1','all_m_delete.png',tr('Vymazať'),tr('Vymazať'));
	else
		createOffButton('all_m_delete_off.png',tr('Vymazať'),tr('Vymazať'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_GET['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// atribut new
if($_GET['mcmd'] == 24){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::ADD_PRIVILEGE) === true)){
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	createButton('tb_toolbar','','','','','./?'.getReturnParameter(0).'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

		// atribut edit
if($_GET['mcmd'] == 25){
	if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(1050002, CMS_Privileges::ADD_PRIVILEGE) === true)){
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
		createButton('tb_toolbar','checkControls','form1',0,0,'#','go','edit','all_m_apply.png',tr('Použiť'),tr('Použiť'));
	}else{
		createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));
		createOffButton('all_m_apply_off.png',tr('Použiť'),tr('Použiť'));
	}
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
	if ($is_help)
	createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_REQUEST['mcmd'].'_catalog.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
}

if($_GET['mcmd'] == 26)
{
	createButton('tb_toolbar','sortItems','',0,0,'#','','','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
}

if($_GET['mcmd'] == 27)
{
	createButton('tb_toolbar','sortItems','',0,0,'#','','','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
}
if($_GET['mcmd'] == 28)
{
	createButton('tb_toolbar','sortItems','',0,0,'#','','','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
}

/* IMPORT SKLADU */
if($_GET['mcmd'] == 29)
{
	createButton('tb_toolbar','checkControls','form1',0,0,'#','','','all_m_save.png',tr('Načítať'),tr('Načítať'));
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
}
if($_GET['mcmd'] == 30)
{
	createButton('tb_toolbar','submitform','form1',0,0,'#','','','all_m_save.png',tr('Importovať'),tr('Importovať'));
	createButton('tb_toolbar','','','','','./?module=CMS_Catalog&mcmd=29','','','all_m_back.png',tr('Späť'),tr('Späť'));
}


/* IMPORT PNEU DT*/
if($_GET['mcmd'] == 101)
{
	createButton('tb_toolbar','checkControls','form1',0,0,'#','','','all_m_save.png',tr('Načítať'),tr('Načítať'));
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
}
if($_GET['mcmd'] == 102)
{
	createButton('tb_toolbar','submitform','form1',0,0,'#','','','all_m_save.png',tr('Importovať'),tr('Importovať'));
	createButton('tb_toolbar','','','','','./?module=CMS_Catalog&mcmd=101','','','all_m_back.png',tr('Späť'),tr('Späť'));
}

/* IMPORT PPPRESS DT*/
if($_GET['mcmd'] == 103)
{
	createButton('tb_toolbar','checkControls','form1',0,0,'#','','','all_m_save.png',tr('Načítať'),tr('Načítať'));
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
}
if($_GET['mcmd'] == 104)
{
	createButton('tb_toolbar','submitform','form1',0,0,'#','','','all_m_save.png',tr('Importovať'),tr('Importovať'));
	createButton('tb_toolbar','','','','','./?module=CMS_Catalog&mcmd=103','','','all_m_back.png',tr('Späť'),tr('Späť'));
}

/* IMPORT AMI */
if($_GET['mcmd'] == 105)
{
	createButton('tb_toolbar','checkControls','form1',0,0,'#','','','all_m_save.png',tr('Načítať'),tr('Načítať'));
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
}
if($_GET['mcmd'] == 106)
{
	createButton('tb_toolbar','submitform','form1',0,0,'#','','','all_m_save.png',tr('Importovať'),tr('Importovať'));
	createButton('tb_toolbar','','','','','./?module=CMS_Catalog&mcmd=105','','','all_m_back.png',tr('Späť'),tr('Späť'));
}

/* IMPORT PNEU DT DUSE*/
if($_GET['mcmd'] == 107)
{
	createButton('tb_toolbar','checkControls','form1',0,0,'#','','','all_m_save.png',tr('Načítať'),tr('Načítať'));
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
}
if($_GET['mcmd'] == 108)
{
	createButton('tb_toolbar','submitform','form1',0,0,'#','','','all_m_save.png',tr('Importovať'),tr('Importovať'));
	createButton('tb_toolbar','','','','','./?module=CMS_Catalog&mcmd=107','','','all_m_back.png',tr('Späť'),tr('Späť'));
}

/* IMPORT PNEU DT DISKY*/
if($_GET['mcmd'] == 109)
{
	createButton('tb_toolbar','checkControls','form1',0,0,'#','','','all_m_save.png',tr('Načítať'),tr('Načítať'));
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
}
if($_GET['mcmd'] == 110)
{
	createButton('tb_toolbar','submitform','form1',0,0,'#','','','all_m_save.png',tr('Importovať'),tr('Importovať'));
	createButton('tb_toolbar','','','','','./?module=CMS_Catalog&mcmd=109','','','all_m_back.png',tr('Späť'),tr('Späť'));
}

/* IMPORT AMI */
if($_GET['mcmd'] == 111)
{
	createButton('tb_toolbar','checkControls','form1',0,0,'#','','','all_m_save.png',tr('Načítať'),tr('Načítať'));
	createButton('tb_toolbar','','','','','./?'.getReturnParameter().'','','','all_m_back.png',tr('Späť'),tr('Späť'));
}
if($_GET['mcmd'] == 112)
{
	createButton('tb_toolbar','submitform','form1',0,0,'#','','','all_m_save.png',tr('Importovať'),tr('Importovať'));
	createButton('tb_toolbar','','','','','./?module=CMS_Catalog&mcmd=112','','','all_m_back.png',tr('Späť'),tr('Späť'));
}
/* ------------- */
echo"</table>";
?>
