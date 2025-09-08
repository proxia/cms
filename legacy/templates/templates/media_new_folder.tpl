{literal}
<script language="JavaScript" type="text/javascript">
function pozadie (farba,idd){
		idd.style.background = farba;
	}

var sel_value = 1;
function selectall(the_form, min, max){
	basename = "box";
	if (sel_value==2)
		do_check = false;
	if (sel_value==1)
		do_check = true;
    for (var i = min; i <= max; i++) {
        if (typeof(document.forms[the_form].elements[basename + i]) != 'undefined') {
            document.forms[the_form].elements[basename + i].checked = do_check;
				if (do_check == true)
					sel_value = 2
				if (do_check == false)
					sel_value = 1
        }
    }

    return true;
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


function listItemTask(the_form,min,max,act_type,act_value,row){
		document.forms[the_form].elements[row].checked = true;
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

function showPreview(path) {
	if (top.frames && top.frames['preview'])
		top.frames['preview'].document.location = "scripts/mediamanager/preview.php?path=" + path;
}
// zoznam objektov ktore treba kontrolovat
	// E - kontrola na email
	// V - kontrola na retazec
	// N - kontrola na cislo
	// U - kontrola na url
	// H - kontrola na rovnost hesla musia byt dve polia z H alebo ziadne
	// "nazov pola" "min dlzka" "max dlzka" "typ kontroly"
	var pole=new Array(
			"new_folder_name","0","100","V"
		);
</script>
{/literal}
{insert name=check}
<table class="tb_middle">
	<tr>
		<td colspan="5">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/media_view.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér médií / Nový adresár'}</td>
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
		<form action="action.php" method="post" name="form1" id="form1">
		<input type="hidden" name="section" value="media">
		<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
			<table>
				<tr>
					<td>
						{insert name='tr' value='Nadradený adresár'}&nbsp;
					</td>
					<td>
						<select name="infolder" id="infolder">
							<option value="/">/</option>
							{insert name=getOptionFolderList selected=$m_directory}
						</select>
					</td>
				</tr>
				<tr>
					<td>
						{insert name='tr' value='Názov adresára'}
					</td>
					<td>
						<input type="text" name="new_folder_name" id="new_folder_name" size="20" maxlength="255" />
					</td>
				</tr>
			</table>
		</form>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
