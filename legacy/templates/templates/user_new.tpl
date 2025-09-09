{literal}
<script language="JavaScript" type="text/javascript">
// start tabulator ***************************************************************
function showtd(id){
	var style=document.getElementById(id).style;
	style.backgroundColor = "#ffffff";
	style.borderBottom = "0px";
}

function showtdhref(id){
	var style=document.getElementById(id).style;
	style.backgroundColor = "#ffffff";
	style.fontWeight = "normal";
	style.color = "#cc3333";
}

function hiddentd(id){
	var style=document.getElementById(id).style;
	style.backgroundColor = "#dedede";
	style.borderBottomWidth = "1px";
	style.borderStyle = "solid";
	style.borderColor = "#bcbcbc";
}

function hiddentdhref(id){
	var style=document.getElementById(id).style;
	style.backgroundColor = "#dedede";
	style.fontWeight = "normal";
	style.color = "#000000";
}

function hiddenblok(id){
	var style=document.getElementById(id).style;
	style.display = "none";
}

function showblok(id){
	var style=document.getElementById(id).style;
	style.display = "block";
}

function ukaz(id,num_block){
	for (block=1;block<=num_block;block=block+1){

			var b = "b"+block;
			hiddentd(b);
			var bh = "bh"+block;
			hiddentdhref(bh);
			var blok = "blok"+block;
			hiddenblok(blok);
		}
	var pid = "b"+id;
	var pid2 = "bh"+id;
	var pid3 = "blok"+id;

	showtd(pid);
	showtdhref(pid2);
	showblok(pid3);
}
// end tabulator ***************************************************************

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
			"f_firstname","0","100","V",
			"f_familyname","0","100","V",
			"f_login","0","100","V",
			"f_password","0","100","V"
		);
</script>
{/literal}
{insert name=check}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/user_view_edit.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér používateľov / Úprava používateľa'}</td>
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
		<table width="100%">
			<tr>
				<td class="td_valign_top">
					<table class="tb_list">
						<tr class="tr_header">
							<td colspan="2">&nbsp;{insert name='tr' value='Detail používateľa'}</td>
						</tr>
						<form name="form1" id="form1" method="post" action="action.php">
						<input type="hidden" name="section" id="section" value="user" />
						<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
						<input type="hidden" id="row_id[]" name="row_id[]" value="0" />

						<tr><td colspan="2" class="td_link_space"></td></tr>
						<tr>
							<td width="150">&nbsp;{insert name='tr' value='Titul'}</td>
							<td><input maxlength="30" size="30" type="text" name="f_title" id="f_title" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Meno'}*</td>
							<td><input size="20" maxlength="30" type="text" name="f_firstname" id="f_firstname" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Priezvisko'}*</td>
							<td><input size="30" maxlength="30" type="text"  name="f_familyname" id="f_familyname" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Nick'}</td>
							<td><input size="20" maxlength="30" type="text" name="f_nickname" id="f_nickname" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Prihlasovacie meno'}*</td>
							<td><input maxlength="30" type="text" name="f_login" id="f_login" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Heslo'}*</td>
							<td><input maxlength="30" type="password" name="f_password" id="f_password" /></td>
						</tr>
						<tr><td colspan="2"><hr /></td></tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Ulica'}</td>
							<td><input size="30" maxlength="30" type="text" name="f_street" id="f_street" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Mesto'}</td>
							<td><input size="20" maxlength="30" type="text" name="f_city" id="f_city" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='PSČ'}</td>
							<td><input size="6" maxlength="10" type="text" name="f_zip" id="f_zip" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Krajina'}</td>
							<td><input type="text" name="f_country" id="f_country" /></td>
						</tr>
						<tr><td colspan="2"><hr /></td></tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Telefón'}</td>
							<td><input size="20" maxlength="20" type="text" name="f_phone" id="f_phone" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Fax'}</td>
							<td><input size="20" maxlength="20" type="text" name="f_fax" id="f_fax" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Mobil'}</td>
							<td><input size="20" maxlength="20" type="text" name="f_cell" id="f_cell" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Email'}</td>
							<td><input size="30" maxlength="50" type="text" name="f_email" id="f_email" /></td>
						</tr>


						{if $user_login_type eq $admin_user}

							<tr><td colspan="2"><hr /></td></tr>

							<tr>
								<td>&nbsp;{insert name='tr' value='Editor'}</td>
								<td><input type="checkbox" name="f_is_editor" id="f_is_editor" value="1" /></td>
							</tr>

						{/if}

					</table>
				</td>


			</tr>
		</table>
		<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
