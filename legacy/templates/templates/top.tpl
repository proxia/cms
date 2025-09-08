<table class="tb_top" cellspacing="0" cellpadding="0">
	<tr>
		<td style="background-image: url(images/top_left.jpg);background-repeat: no-repeat;width:160px;height:40px;"><div style="width:160px;height:40px;"></div></td>
		{if $proxiaCatalog eq 1}
		<form name="proxia" action="./" method="get">
		<td class="td_left">
		{*if ($user_login_type eq 1)*}
		<select name="setProxia" class="proxia" onchange="document.proxia.submit()">
			<option class="proxia" value="web" {if $proxiaType eq 'web'}selected="selected"{/if}>WEB</option>
			<option class="proxia" value="catalog" {if $proxiaType eq 'catalog'}selected="selected"{/if}>CATALOG</option>			}
		</select>
		{*/if*}
		</td>
		</form>
		{/if}
    	<td class="td_left_middle" nowrap="nowrap">&nbsp;&nbsp;&nbsp;{$currentSiteName}&nbsp;&nbsp;&nbsp;{$currentUserName}</td>


		{if $is_login eq 1}
			<td width="80%" style="text-align:right">
			<form name="sw">
					<input type="hidden" name="beg2" value="{$session_time}:00">
					&nbsp;<input class="casomiera" type="text" name="disp2" size="23" readonly>&nbsp;
			</td>
			</form>

		{/if}



		<form name="site" action="./" method="get">
		<td class="td_right_middle" width="50%">
		{if ($user_login_type eq 1)}
		<select name="setSite" class="site" onchange="document.site.submit()">
			{foreach name='setSite' from=$sites item='site_id'}
				<option value="{$site_id.site_name}" {if $site_id.site_name eq $currentSiteName}selected="selected"{/if}>{$site_id.site_name}</option>
			{/foreach}
		</select>
		{/if}
		</td>
		</form>

	{if is_object ($user_login) AND $proxiaType eq 'web'}
		<td class="td_right" nowrap>
			&nbsp;&nbsp;&nbsp;

			{if (($user_login->checkPrivilege(2, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
			<a href="./?cmd=10" title="{insert name='tr' value='Kôš'}"><img alt="{insert name='tr' value='Kôš'}" src="{$theme_path}/images/trash_t.png" border="0" /></a>
			{else}
			<img alt="{insert name='tr' value='Kôš'}" src="{$theme_path}/images/trash_t_off.png" border="0" />
			{/if}
			&nbsp;
			{if (($user_login->checkPrivilege(9, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
			<a href="./?cmd=26" title="{insert name='tr' value='Manažér médií'}"><img alt="{insert name='tr' value='Manažér médií'}" src="{$theme_path}/images/media_t.png" border="0" /></a>
			{else}
			<img alt="{insert name='tr' value='Manažér médií'}" src="{$theme_path}/images/media_t_off.png" border="0" />
			{/if}
			&nbsp;
			{if (($user_login->checkPrivilege(6, $privilege_add) eq 1) OR ($user_login_type eq $admin_user))}
			<a href="./?cmd=2" title="{insert name='tr' value='Nová kategória'}"><img alt="{insert name='tr' value='Nová kategória'}" src="{$theme_path}/images/cat_t_add.png" border="0" /></a>
			{else}
			<img alt="{insert name='tr' value='Nová kategória'}" src="{$theme_path}/images/cat_t_add_off.png" border="0" />
			{/if}
			&nbsp;
			{if (($user_login->checkPrivilege(6, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
			<a href="./?cmd=1" title="{insert name='tr' value='Zoznam kategórií'}"><img alt="{insert name='tr' value='Zoznam kategórií'}" src="{$theme_path}/images/cat_t_info.png" border="0" /></a>
			{else}
			<img alt="{insert name='tr' value='Zoznam kategórií'}" src="{$theme_path}/images/cat_t_info_off.png" border="0" />
			{/if}
			&nbsp;
			{if (($user_login->checkPrivilege(5, $privilege_add) eq 1) OR ($user_login_type eq $admin_user))}
			<a href="./?cmd=8" title="{insert name='tr' value='Nový článok'}"><img alt="{insert name='tr' value='Nový článok'}" src="{$theme_path}/images/article_t_add.png" border="0" /></a>
			{else}
			<img alt="{insert name='tr' value='Nový článok'}" src="{$theme_path}/images/article_t_add_off.png" border="0" />
			{/if}
			&nbsp;
			{if (($user_login->checkPrivilege(5, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
			<a href="./?cmd=7" title="{insert name='tr' value='Zoznam článkov'}"><img alt="{insert name='tr' value='Zoznam článkov'}" src="{$theme_path}/images/article_t_info.png" border="0" /></a>
			{else}
			<img alt="{insert name='tr' value='Zoznam článkov'}" src="{$theme_path}/images/article_t_info_off.png" border="0" />
			{/if}
			&nbsp;&nbsp;&nbsp;&nbsp;

		</td>
		{/if}

		{if is_object ($user_login) AND $proxiaType eq 'catalog'}
		<td class="td_right" nowrap>
			&nbsp;&nbsp;&nbsp;

			{if (($user_login->checkPrivilege(105, $privilege_add) eq 1) OR ($user_login_type eq $admin_user))}
			<a href="./?mcmd=2" title="{insert name='tr' value='Nový katalóg'}"><img alt="{insert name='tr' value='Nový katalóg'}" src="{$theme_path}/images/catalog_t_add.png" border="0" /></a>
			{else}
			<img alt="{insert name='tr' value='Nový katalóg'}" src="{$theme_path}/images/catalog_t_add_off.png" border="0" />
			{/if}
			{if (($user_login->checkPrivilege(105, $privilege_view) eq 1) OR ($user_login_type eq $admin_user))}
			&nbsp;
			<a href="./?mcmd=1" title="{insert name='tr' value='Zoznam katalógov'}"><img alt="{insert name='tr' value='Zoznam katalógov'}" src="{$theme_path}/images/catalog_t_info.png" border="0" /></a>
			{else}
			<img alt="{insert name='tr' value='Zoznam katalógov'}" src="{$theme_path}/images/catalog_t_info_off.png" border="0" />
			{/if}
			{if $catalog_id}
				&nbsp;
				{if (($user_login->checkPrivilege(1050001, $privilege_add) eq 1) OR ($user_login_type eq $admin_user))}
				<a href="./?mcmd=5" title="{insert name='tr' value='Nová kategória'}"><img alt="{insert name='tr' value='Nová kategória'}" src="{$theme_path}/images/cat_t_add.png" border="0" /></a>
				{else}
				<img alt="{insert name='tr' value='Nová kategória'}" src="{$theme_path}/images/cat_t_add_off.png" border="0" />
				{/if}
				&nbsp;
				{if (($user_login->checkPrivilege(1050001, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
				<a href="./?mcmd=4" title="{insert name='tr' value='Zoznam kategórií'}"><img alt="{insert name='tr' value='Zoznam kategórií'}" src="{$theme_path}/images/cat_t_info.png" border="0" /></a>
				{else}
				<img alt="{insert name='tr' value='Zoznam kategórií'}" src="{$theme_path}/images/cat_t_info_off.png" border="0" />
				{/if}
				&nbsp;
				{if (($user_login->checkPrivilege(1050002, $privilege_add) eq 1) OR ($user_login_type eq $admin_user))}
				<a href="./?mcmd=11" title="{insert name='tr' value='Nový produkt'}"><img alt="{insert name='tr' value='Nový produkt'}" src="{$theme_path}/images/product_t_add.png" border="0" /></a>
				{else}
				<img alt="{insert name='tr' value='Nový produkt'}" src="{$theme_path}/images/product_t_add_off.png" border="0" />
				{/if}
				&nbsp;
				{if (($user_login->checkPrivilege(1050002, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
				<a href="./?mcmd=10" title="{insert name='tr' value='Zoznam produktov'}"><img alt="{insert name='tr' value='Zoznam produktov'}" src="{$theme_path}/images/product_t_info.png" border="0" /></a>
				{else}
				<img alt="{insert name='tr' value='Zoznam produktov'}" src="{$theme_path}/images/product_t_info_off.png" border="0" />
				{/if}
				{if (($user_login->checkPrivilege(1050002, $privilege_add) eq 1) OR ($user_login_type eq $admin_user))}
				<a href="./?mcmd=8" title="{insert name='tr' value='Nový atribút'}"><img alt="{insert name='tr' value='Nový atribút'}" src="{$theme_path}/images/atribut_t_add.png" border="0" /></a>
				{else}
				<img alt="{insert name='tr' value='Nový atribút'}" src="{$theme_path}/images/atribut_t_add_off.png" border="0" />
				{/if}
				&nbsp;
				{if (($user_login->checkPrivilege(1050002, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
				<a href="./?mcmd=7" title="{insert name='tr' value='Zoznam atribútov'}"><img alt="{insert name='tr' value='Zoznam atribútov'}" src="{$theme_path}/images/atribut_t_info.png" border="0" /></a>
				{else}
				<img alt="{insert name='tr' value='Zoznam atribútov'}" src="{$theme_path}/images/atribut_t_info_off.png" border="0" />
				{/if}
			{/if}

			&nbsp;&nbsp;&nbsp;&nbsp;

		</td>
		{/if}

		{if is_object ($user_login)}
		<td class="td_right_middle" valign="top">
			&nbsp;<a title="{insert name='tr' value='odhlásiť'}" href="./?cmd=logout"><img align="bottom" src="images/logout36.png" alt="{insert name='tr' value='odhlásiť'}"></a>
		</td>
		{/if}
		{if !is_object ($user_login)}
		<td class="td_right" nowrap>{insert name='tr' value='version'} {$proxia.version}</td>
		{/if}
	</tr>
</table>



{if is_object ($user_login) AND $proxiaType eq 'web'}
	<table class="tb_top_menu" width="100%">
		<tr>
			<!--td width="20">
				{if $expandTree eq 0}
					<a href="./?{$current_link}setExpandTree=show"><img src="images/expand_s.gif"></a>
				{elseif $expandTree eq 1}
					<a href="./?{$current_link}setExpandTree=hidden"><img src="images/collapse_s.gif"></a>
				{/if}
				&nbsp;
			</td-->
			<td>{include_php file="$theme_path/scripts/apy_menu.php"}&nbsp;</td>
		</tr>
	</table>
{/if}
{if is_object ($user_login) AND $proxiaType eq 'catalog'}
	<table class="tb_top_menu" width="100%">
		<!--tr>
			<td>{*include_php file="../modules/cms_catalog/scripts/apy_menu.php"*}</td>
		</tr-->
		<tr>

			<td>
				{include_php file="$theme_path/vendor/cms_modules/cms_catalog/themes/default/templates/templates/top_menu.tpl"}
			</td>
		</tr>
	</table>
{/if}
