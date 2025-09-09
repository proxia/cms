<form name="form_icon_languages" id="form_icon_languages">
<input type="hidden" id="section" name="section" value="category_icon_languages" />
<input type="hidden" name="row_id[]" id="row_id[]" value="{$category_detail->getId()}" />
<table class="tb_list_in_tab" align="center">
	<tr class="tr_header">
		<td colspan="4">&nbsp;{insert name='tr' value='Ikony jazykových verzií'}</td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	{foreach name='language' from=$LanguageListLocal item='language_id' }
	{$category_detail->setContextLanguage($language_id.code)}
	{php}
		$path = "{$GLOBALS['config']['mediadir']}/".$GLOBALS['smarty']->get_template_vars('category_detail')->getLocalizedImage();
		$name = basename($path);
		$GLOBALS["smarty"]->assign("icon_name",$name);
		$GLOBALS["smarty"]->assign("icon_path",$path);
	{/php}
	<tr>
		<td>&nbsp;{$language_id.code}</td>
		<td><input size=40 type="text" name="a_languageIcons{$language_id.code}" id="f_languageIcons{$language_id.code}" value="{$category_detail->getLocalizedImage()}" /></td>
		<td><a  href="javascript:insertfile('form_icon_languages','a_languageIcons{$language_id.code}')" title="{insert name='tr' value='vlož obrázok'}"><img src="images/paste.gif" width="21" height="21" border="0"></a></td>
	</tr>
	{if ($category_detail->getLocalizedImage() neq '')}
		<tr>
		<td>&nbsp;{insert name='tr' value='Obrázok'}</td>
		<td width=22>&nbsp;<a  href="{$icon_path}" target="_blank" title="{insert name='tr' value='ukáž'}"><img src="images/view_s.png" border="0"></a></td>
		</tr>
	{/if}
	{/foreach}
	<tr>
		<td></td>
		<td class="td_center" colspan="2"><br /><input class="button" type="button" onclick="updateAjax('form_icon_languages','language_icon_list')" value="{insert name='tr' value='Uložiť ikony'}" /></td>
	</tr>

</table>
</form>
