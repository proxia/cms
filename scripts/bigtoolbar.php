
    <table class="tb_toolbar_big">
    	<tr>
        
        <?php if (($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){?>
            <td><?=createButton('tb_toolbar_big','','','','','./?cmd=8','','','article_view_add.png',tr('Pridaj článok'));?></td>
        <?php }else{?>
            <td><?=createOffBigButton('article_view_add_off.png',tr('Pridaj článok'),tr('Pridaj článok'));?></td>
        <?php }?>


        <?php if (($GLOBALS['user_login']->checkPrivilege(9, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){?>
            <td><?=createButton('tb_toolbar_big','','','','','./?cmd=28','','','media_view_add.png',tr('Pridaj obrázok'));?></td>
        <?php }else{?>
            <td><?=createOffBigButton('media_view_add_off.png',tr('Pridaj obrázok'),tr('Pridaj obrázok'));?></td>
        <?php }?>
    		
    		
        <?php if (($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ADD_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){?>
            <td><?=createButton('tb_toolbar_big','','','','','./?cmd=2','','','cat_view_add.png',tr('Pridaj kategóriu'));?></td>
        <?php }else{?>
            <td><?=createOffBigButton('cat_view_add_off.png',tr('Pridaj kategóriu'),tr('Pridaj kategóriu'));?></td>
        <?php }?>
        
    	</tr>
    	<tr>
        <?php if (($GLOBALS['user_login']->checkPrivilege(5, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){?>
            <td><?=createButton('tb_toolbar_big','','','','','./?cmd=7','','','article_view.png',tr('Manažér článkov'));?></td>
        <?php }else{?>
            <td><?=createOffBigButton('article_view_off.png',tr('Manažér článkov'),tr('Manažér článkov'));?></td>
        <?php }?>
    		
        
        <?php if (($GLOBALS['user_login']->checkPrivilege(9, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){?>
            <td><?=createButton('tb_toolbar_big','','','','','./?cmd=26','','','media_view.png',tr('Manažér médií'));?></td>
        <?php }else{?>
            <td><?=createOffBigButton('media_view_off.png',tr('Manažér médií'),tr('Manažér médií'));?></td>
        <?php }?>
    		
        
        <?php if (($GLOBALS['user_login']->checkPrivilege(6, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){?>
            <td><?=createButton('tb_toolbar_big','','','','','./?cmd=1','','','cat_view.png',tr('Manažér kategórií'));?></td>
        <?php }else{?>
            <td><?=createOffBigButton('cat_view_off.png',tr('Manažér kategórií'),tr('Manažér kategórií'));?></td>
        <?php }?>
    		
    	</tr>
		
		<tr>
        <?php if (($GLOBALS['user_login']->checkPrivilege(8, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){?>
            <td><?=createButton('tb_toolbar_big','','','','','./?cmd=16','','','user_view.png',tr('Manažér používateľov'));?></td>
        <?php }else{?>
            <td><?=createOffBigButton('user_view_off.png',tr('Manažér používateľov'),tr('Manažér používateľov'));?></td>
        <?php }?>
    		
        
        <?php if (($GLOBALS['user_login']->checkPrivilege(4, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){?>
            <td><?=createButton('tb_toolbar_big','','','','','./?cmd=19','','','language_view.png',tr('Manažér jazykov'));?></td>
        <?php }else{?>
            <td><?=createOffBigButton('language_view_off.png',tr('Manažér jazykov'),tr('Manažér jazykov'));?></td>
        <?php }?>
    		
        
        <?php if (($GLOBALS['user_login']->checkPrivilege(11, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){?>
            <td><?=createButton('tb_toolbar_big','','','','','./?cmd=15','','','frontpage_view.png',tr('FrontPage manažér'));?></td>
        <?php }else{?>
            <td><?=createOffBigButton('frontpage_view_off.png',tr('FrontPage manažér'),tr('FrontPage manažér'));?></td>
        <?php }?>
    		
    	</tr>
    	
		<tr>
		<?php if (($GLOBALS['user_login']->checkPrivilege(2, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){?>
            <td><?=createButton('tb_toolbar_big','','','','','./?cmd=10','','','trash_view.png',tr('Kôš'));?></td>
        <?php }else{?>
            <td><?=createOffBigButton('trash_view_off.png',tr('Kôš'),tr('Kôš'));?></td>
        <?php }?>
        
        <?php if (($GLOBALS['user_login']->checkPrivilege(1, CMS_Privileges::ACCESS_PRIVILEGE) === true) || ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)){?>
            <td><?=createButton('tb_toolbar_big','','','','','./?cmd=4','','','menu_view.png',tr('Menu manažér'));?></td>
        <?php }else{?>
            <td><?=createOffBigButton('menu_view_off.png',tr('Menu manažér'),tr('Menu manažér'));?></td>
        <?php }?>
        
        <?php if ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER){?>
            <td><?=createButton('tb_toolbar_big','','','','','./?cmd=25','','','options_view.png',tr('Hlavné nastavenia'));?></td>
        <?php }else{?>
            <td><?=createOffBigButton('options_view_off.png',tr('Hlavné nastavenia'),tr('Hlavné nastavenia'));?></td>
        <?php }?>
        
		</tr>
		
    </table>

