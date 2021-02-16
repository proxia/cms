{literal}
<script language="JavaScript" type="text/javascript">
function addelement(act_type,act_value){
	var newelement = document.createElement('INPUT');
	newelement.type = 'hidden';
	newelement.name = act_type;
	newelement.value = act_value;
	document.form1.appendChild(newelement)
}

function submitform(act_type,act_value){
	addelement(act_type,act_value);
	try {
		document.form1.onsubmit();
		}
	catch(e){}
		document.form1.submit();
}
var pole=new Array();
</script>
{/literal}
{insert name=check}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title" cellpadding="0" cellspacing="0">
				<tr>
					<td height="50">&nbsp;&nbsp;{insert name='tr' value='Import produktov '} 2/2</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left">
		{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
		{include_php file=$path_toolbar}
		</td>
		<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="1" /></td>
		<td class="td_middle_center">
			<table width="100%">
			<tr>
				<td class="td_valign_top">
					<table class="tb_list" border=0 cellpadding="0" cellspacing="0">
						<tr class="tr_header" >
							<td colspan="2">&nbsp;{insert name='tr' value='Odsúhlasenie importu'} {insert name='tr' value='Katalóg'}: {$catalog_title}</td>
						</tr>
						<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
						<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
						<input type="hidden" id="section" name="section" value="import_products_PPRESS_2" />
						<input type="hidden" id="delimiter" name="delimiter" value="{$delimiter}" />
						<input type="hidden" id="time_mark" name="time_mark" value="{$time_mark}" />
						<tr><td colspan="2" class="td_link_space"></td></tr>
						<tr>
							<td colspan="2" class="td_align_center">
								<table  cellpadding="4" cellspacing="1" border="1" style="margin:10px;border-collapse:collapse;">
									<tr>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Kód'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Názov'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Skupina'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='hmotnosť v gramoch'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='množstvo v kartóne'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='počet kartónov v rade'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='počet kartónov na palete'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='EAN kus'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='EAN box'}</strong></td>
									</tr>
									{foreach from=$import item=row}
										<tr>
												<td style="padding:5px;">{$row.0}</td>
												<td style="padding:5px;">{$row.1}</td>
												<td style="padding:5px;">{$row.2}</td>
												<td style="padding:5px;">{$row.3}</td>
												<td style="padding:5px;">{$row.4}</td>
												<td style="padding:5px;">{$row.5}</td>
												<td style="padding:5px;">{$row.6}</td>
												<td style="padding:5px;">{$row.7}</td>
												<td style="padding:5px;">{$row.8}</td>
										</tr>
									{/foreach}
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
