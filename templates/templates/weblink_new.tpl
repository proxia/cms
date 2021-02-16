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
					<td><img class="img_middle" src="images/weblink_view_add.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér odkazov / Nový odkaz'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left">
			{include_php file="../scripts/toolbar.php"}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list">

				<tr class="tr_header">
					<td colspan="2">&nbsp;{insert name='tr' value='Detail odkazu'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="action.php">
				<input type="hidden" id="section" name="section" value="weblink" />
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="0" />
				<input type="hidden" name="s_category" id="s_category" value="0" />
				<tr><td colspan="2" class="td_link_space"></td></tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Názov odkazu'}*</td>
					<td width="85%"><input size="60" type="text" name="f_title" id="f_title" /></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='URL'}</td>
					<td width="85%"><input size="60" type="text" name="f_url" id="f_url" value="http://"/></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Cieľ'}</td>
					<td width="85%">
						<select name="f_target" id="f_target">
							<option value="">{insert name='tr' value='None (use implicit)'}</option>
							<option value="_blank">{insert name='tr' value='New window (_blank)'}</option>
							<option value="_self">{insert name='tr' value='Same frame (_self)'}</option>
							<option value="_top">{insert name='tr' value='Top frame (_top)'}</option>
						</select>
				</tr>
				<tr>
					<td class="td_valign_top">&nbsp;{insert name='tr' value='Popis odkazu'}</td>
					<td width="90%"><textarea cols="80" rows="6" name="f_description" id="f_description"></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Viditeľnosť'}</td>
					<td><input type="radio" name="f_isPublished" id="f_isPublished" value="0" checked="checked" />{insert name='tr' value='Nie'}&nbsp;<input type="radio" name="f_isPublished" id="f_isPublished" value="1" />{insert name='tr' value='Áno'}</td>
				</tr>
				<tr>
					<td valign="top">&nbsp;{insert name='tr' value='Zobrazovacie&nbsp;práva'}</td>
					<td>
						<select name="f_access" id="f_access">
							<option value="{$ACCESS_PUBLIC}">{insert name='tr' value='Verejné'}</option>
							<option value="{$ACCESS_REGISTERED}">{insert name='tr' value='Registrovaným'}</option>
							<option value="{$ACCESS_SPECIAL}">{insert name='tr' value='Skupiny používateľov'}</option>
						</select>
					</td>
				</tr>
				</form>
			</table>
			<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
