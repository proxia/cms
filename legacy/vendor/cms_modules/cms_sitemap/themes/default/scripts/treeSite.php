<script type="text/javascript" src="/js/apytmenu.js"></script>
<script type="text/javascript" src="/js/apytmenu_ss.js"></script>
<script language="JavaScript" type="text/javascript">
  function setSiteMap (){
			try {
		document.siteMap.onsubmit();
		}
	  catch(e){}
		document.siteMap.submit();
	}
	</script>
<?php
	$is_help = 0;
	if (file_exists("themes/default/help/mcmd".$_GET['mcmd']."_sitemap.html"))
			$is_help=1;
?>

<table class="tb_middle">
<form method="post" name="form_search" id="form_search">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="/cms_modules/cms_sitemap/images/sitemap_view.png" alt="" />&nbsp;&nbsp;<?=tr('Mapa stránky')?></td>
				</tr>
			</table>
		</td>
	</tr>
</form>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left" width=40>
    <?php
    	echo"<table class=\"tb_toolbar\">";

    		if($_GET['mcmd'] == 1){

    			if(($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER) || ($GLOBALS['user_login']->checkPrivilege(102, CMS_Privileges::UPDATE_PRIVILEGE) === true))
    				createButton('tb_toolbar','setSiteMap','siteMap',0,0,'#','go','list','all_m_save.png',tr('Uložiť'),tr('Uložiť'));
				else
					createOffButton('all_m_save_off.png',tr('Uložiť'),tr('Uložiť'));

    				if ($is_help)
    					createButton('tb_toolbar','','','1','','themes/default/help/mcmd'.$_GET['mcmd'].'_sitemap.html','cmd','help','all_m_help.png',tr('Pomocník'),tr('Pomocník'));
    			}

    	echo"</table>";
    ?>
		</td>
		<td class="td_link_h"><img src="/images/pixel.gif" width="2" /></td>
		<td  class="td_middle_center"  width="98%" style="align:center">
		<?php include($GLOBALS['smarty']->get_template_vars('path_relative')."themes/default/scripts/tree.php");?>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
