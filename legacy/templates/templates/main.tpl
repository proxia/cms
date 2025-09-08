<table class="tb_main">
	<tr>
		<td colspan="3">{include file="top.tpl"}</td>
	</tr>
	<tr>
		<td colspan="3">{include file="message.tpl"}</td>
	</tr>
	{if $cmd eq 'help'}
	<tr>
		<td colspan="3">
		<iframe id="previewIframe" name="previewIframe" unselectable="true" atomicselection="true" src="help/index.html" width="100%" height="550" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" frameborder="0" border="0"></iframe>
		</td>
	</tr>
	{else}
	<tr>
		<td colspan="3" class="td_valign_top">{include_php file="$theme_path/scripts/center.php"}</td>
	</tr>
	{/if}
	{insert name='getConfig' section='proxia' option='show_history_table' assign=show_history_table}
	{if $show_history_table eq 'true'}
	<tr>
		<td colspan="3">
			{include file="history_table.tpl"}
		</td>
	</tr>
	{/if}
	<tr>
		<td colspan="3" class="td_align_center"><img align="absmiddle" src="images/logo_foot.gif" />{$proxia.foot_text}</td>
	</tr>

</table>