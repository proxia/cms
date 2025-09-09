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

function ischecked(the_form,min,max,act_type,act_value){
	  var basename = "box";
      pocetChecked = 0;
      for (var i = min; i <= max; i++)
        {
			if (typeof(document.forms[the_form].elements[basename + i]) != 'undefined') {
            		if (document.forms[the_form].elements[basename + i].checked == true)
						pocetChecked++;
				}
        }
      if(pocetChecked == 0 ){
{/literal}
        	alert("{insert name='tr' value='Nevybrali ste žiadny záznam na spracovanie'}!");
{literal}
        	return false;
        }
		else{
			submitform(act_type,act_value)
		}
 }

   // zoznam objektov ktore treba kontrolovat
	// E - kontrola na email
	// V - kontrola na retazec
	// N - kontrola na cislo
	// U - kontrola na url
	// H - kontrola na rovnost hesla musia byt dve polia z H alebo ziadne
	// "nazov pola" "min dlzka" "max dlzka" "typ kontroly"
	var pole=new Array(
			"f_title","0","100","V",
			"f_name","0","100","V"
		);
</script>
{/literal}
{insert name=check}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/menu_view_add.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér menu / Nové menu'}</td>
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
			<table class="tb_list">

				<tr class="tr_header">
					<td colspan="2">&nbsp;{insert name='tr' value='Detail menu'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="action.php">
				<input type="hidden" id="section" name="section" value="menu" />
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="0" />
				<tr><td colspan="2" class="td_link_space"></td></tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Title menu'}*</td>
					<td width="85%"><input type="text" name="f_title" id="f_title" /></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Názov menu'}*</td>
					<td width="85%"><input type="text" name="f_name" id="f_name" /></td>
				</tr>
				<tr>
					<td class="td_valign_top">&nbsp;{insert name='tr' value='Popis menu'}</td>
					<td width="90%"><textarea cols="40" rows="6" name="f_description" id="f_description"></textarea></td>
				</tr>
				</form>
			</table>
			<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
