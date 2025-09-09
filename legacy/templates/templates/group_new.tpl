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


   // zoznam objektov ktore treba kontrolovat
	// E - kontrola na email
	// V - kontrola na retazec
	// N - kontrola na cislo
	// U - kontrola na url
	// H - kontrola na rovnost hesla musia byt dve polia z H alebo ziadne
	// "nazov pola" "min dlzka" "max dlzka" "typ kontroly"
	var pole=new Array(
			"f_name","0","50","V",
			"f_title","0","100","V"
		);


</script>
{/literal}
{insert name=check}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/group_view_add.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér skupín / Nová skupina'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left">
			{include_php file="scripts/toolbar.php"}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list" border="0">

				<tr class="tr_header">
					<td colspan="4">&nbsp;{insert name='tr' value='Detail skupiny'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="action.php">

				<input type="hidden" id="section" name="section" value="groups" />
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
				<input type="hidden" id="row_id" name="row_id[]" value="0" />

				<input type="hidden" id="f_language_is_visible" name="f_language_is_visible" value="1" />
				<tr><td colspan="4" class="td_link_space"></td></tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Kód skupiny'}*</td>
					<td><input size="80" maxlength="80" type="text" name="f_name" id="f_name" /></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Názov skupiny'}*</td>
					<td><input size="80" maxlength="80" type="text" name="f_title" id="f_title" /></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Viditeľnosť'}</td>
					<td><input type="radio" name="f_isPublished" id="f_isPublished" value="0" checked="checked" />{insert name='tr' value='Nie'}&nbsp;<input type="radio" name="f_isPublished" id="f_isPublished" value="1" />{insert name='tr' value='Áno'}</td>
				</tr>
				<tr>
					<td valign="top">&nbsp;{insert name='tr' value='Popis skupiny'}</td>
					<td><textarea name="f_description" id="f_description" cols="80" rows="8" ></textarea></td>
				</tr>
				</form>
			</table>
			<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
