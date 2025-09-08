
<table class="tb_main">
	<tr>
		<td colspan="3">{if $mcmd neq '999' && $mcmd neq '998'}{include file="top.tpl"}{/if}</td>
	</tr>
	<tr>
		<td colspan="3">{include file="message.tpl"}</td>
	</tr>
	{if $cmd eq 'help' AND $proxiaType eq 'catalog'}
	<tr>
		<td colspan="3">
		<iframe id="previewIframe" name="previewIframe" unselectable="true" atomicselection="true" src="help/catalog/index.html" width="100%" height="550" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" frameborder="0" border="0"></iframe>
		</td>
	</tr>
	{else}
	<tr>
		<td colspan="3" class="td_valign_top">{include_php file="$theme_path/scripts/module_init.php"}</td>
	</tr>
	{/if}
	{if $mcmd neq '999' && $mcmd neq '998'}
	<tr>
		<td class="td_align_center" colspan="3"><img align="absmiddle" src="images/logo_foot.gif" />{$proxia.foot_text}</td>
	</tr>
	{/if}
</table>