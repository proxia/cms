<form name="form_languages" id="form_languages">
<input type="hidden" id="section" name="section" value="gallery_languages" />
<input type="hidden" name="row_id[]" id="row_id[]" value="{$gallery_detail->getId()}" />
<table class="tb_list_in_tab" align="center">
	<tr class="tr_header">
		<td colspan="3">&nbsp;{insert name='tr' value='Jazykové verzie'}</td>
	</tr>
	<tr>
		<td>{insert name='tr' value='Názov'}</td>
		<td>{insert name='tr' value='Viditeľnosť'}</td>
		<td>{insert name='tr' value='Náhľad'}</td>
	</tr>
	{foreach name='language' from=$LanguageListLocal item='language_id' }
	{$gallery_detail->setContextLanguage($language_id.code)}
	<tr>
		<td>&nbsp;{$language_id.code}</td>
		<td><input type="checkbox" name="a_languageIsVisible{$language_id.code}" id="f_languageIsVisible{$language_id.code}" value="1" {if $gallery_detail->getLanguageIsVisible() eq 1}checked="checked"{/if} /></td>
		<td><a title="{insert name='tr' value='ukáž'}" href="javascript:ukazlang('lang{$language_id.code}')"><img src="../themes/default/images/view_s.png" /></td>
	</tr>
	{/foreach}
	<tr>
		<td></td>
		<td class="td_center" colspan="2"><br />
		{if (($user_login->checkPrivilege(103, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}
			<input class="button" type="button" onclick="updateAjax('form_languages','language_list')" value="{insert name='tr' value='Zmeniť nastavenie'}" />
		{/if}
		</td>
	</tr>
</table>
</form>
