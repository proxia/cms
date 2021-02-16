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

var pole=new Array("file_upload","0","100","V");

</script>
{/literal}
{insert name=check}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title" cellpadding="0" cellspacing="0">
				<tr>
					<td height="50">

					&nbsp;&nbsp;{insert name='tr' value='Import produktov firmy AMI do web katalógu'} 1/2
					</td>
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
					<table class="tb_list" cellpadding="0" cellspacing="0">
						<tr class="tr_header">
							<td colspan="2">&nbsp;{insert name='tr' value='Nastavenie importu'}</td>
						</tr>
						<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php" enctype="multipart/form-data">
						<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
						<input type="hidden" id="section" name="section" value="import_products_AMI_1" />
						<tr><td colspan="2" class="td_link_space"></td></tr>

						<tr>
							<td colspan="2" class="td_align_center">
								<table cellpadding="5" cellspacing="1">

									<tr>
										<td height="25">{insert name='tr' value='Katalóg'}</td>
										<td>{$catalog_title}</td>
									</tr>
									<tr>
										<td height="25">{insert name='tr' value='Stĺpce sú oddelené'}</td>
										<td>
											<select name='delimiter'>
												<option value="0">{insert name="tr" value="tab"}</option>
												<option value="1" selected="selected">;</option>
												<option value="2">,</option>
												<option value="3">§</option>
											</select>
										</td>
									</tr>
									<tr>
										<td height="25">{insert name='tr' value='Kódovanie súboru'}</td>
										<td>
											<select name="cp_src">
											<option value="utf-8">utf-8</option>
											<option value="windows-1250" selected="selected">windows-1250</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Súbor*</td>
										<td><input type="file" size="50" name="file_upload" id="file_upload" /></td>
									</tr>
								</table>

							</td>
						</tr>
						</form>

					</table>
				</td>
			</tr>
		</table>
		<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
