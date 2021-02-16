{include file="top.tpl"}
<table align="center" width="100%">
<tr><td >
		{foreach name='sites' from=$sites key=index item='site_id'}
			{if $index % 15 eq 0 || $index eq 0}
				{if $index neq 0}
					</table>
				{/if}
				<table width="20%" align="left" style="margin:10px;border:1px solid gray;" cellspacing="0">
				<tr class="tr_header">
					<td class="td_middle_center" colspan="3">{insert name='tr' value='Vyberte si projekt na aktualizáciu'}</td>
				</tr>
			{/if}
			<tr >
				<td style="border-bottom:1px solid #e0e0e0;padding:0 5px" class="td_right">{$index}</td>
				<td style="border-bottom:1px solid #e0e0e0;padding:0 5px" class="td_right"><img src="images/logo24.png" /></td>
				<td style="border-bottom:1px solid #e0e0e0;padding:0 5px" valign="middle" nowrap><a href="./?setSite={$site_id.site_name}">{$site_id.site_name}</a></td>
				{*insert name='getConfigProject' project=$site_id.name section='site' option='logo' assign='logo'*}
			</tr>
		{/foreach}
		</table>
</td></tr>
</table>

