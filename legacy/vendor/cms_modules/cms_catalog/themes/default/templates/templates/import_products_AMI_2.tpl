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
		<td class="td_link_h"><img src="../themes/default/images/pixel.gif" width="1" /></td>
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
						<input type="hidden" id="section" name="section" value="import_products_AMI_2" />
						<input type="hidden" id="delimiter" name="delimiter" value="{$delimiter}" />
						<input type="hidden" id="time_mark" name="time_mark" value="{$time_mark}" />
						<tr><td colspan="2" class="td_link_space"></td></tr>
						<tr>
							<td colspan="2" class="td_align_center">
								<table  cellpadding="4" cellspacing="1" border="1" style="margin:10px;border-collapse:collapse;">
									<tr>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='#'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Sklad'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Kód'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Názov'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Popis'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Počet svetelných zdrojov'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Príkon 1 zdroja'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Objimka'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Svetelný zdroj'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Cena'}</strong></td>
										<!--td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Obrázok'}</strong></td-->
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Kategória'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Produktový rad'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Krytie'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Typ el zapojenia'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='A'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='B'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='C'}</strong></td>
										<td bgcolor="#e0e0e0" style="padding:5px;"><strong>{insert name='tr' value='Hmotnosť'}</strong></td>
									</tr>
									{foreach name="import" from=$import item=row}
										<tr>
												<td style="padding:5px;">{$smarty.foreach.import.index+1}</td>
												<td style="padding:5px;">{$row.0}</td>
												<td style="padding:5px;">{$row.1}</td>
												<td style="padding:5px;">{$row.1}</td>
												<td style="padding:5px;">{$row.2}</td>
												<td style="padding:5px;">{$row.3}</td>
												<td style="padding:5px;">{$row.4}</td>
												<td style="padding:5px;">{$row.5}</td>
												<td style="padding:5px;">{$row.6}</td>
												<td style="padding:5px;">{$row.7}</td>
												<td style="padding:5px;">{$row.8}</td>
												<td style="padding:5px;">{$row.9}</td>
												<td style="padding:5px;">{$row.10}</td>
												<td style="padding:5px;">{$row.11}</td>
												<td style="padding:5px;">{$row.12}</td>
												<td style="padding:5px;">{$row.13}</td>
												<td style="padding:5px;">{$row.14}</td>
												<td style="padding:5px;">{$row.15}</td>
												<td style="padding:5px;">{$row.16}</td>
												<!--td style="padding:5px;">{$row.17}</td-->
										</tr>
									{/foreach}
								</table>
								<div style="font-size:1.4em;color:red;">{insert name='tr' value='Toto je len náhľad! Zobrazených je maximálne 150 riadkov importu!'}</div>
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
