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

		var numRows = 1;
		var scrollCount = 0;

function addRow(id, addheight, skip_add) {
	var html = "";

	//if (!skip_add)
		numRows++;

	scrollCount++;

	var elm = document.createElement("div");
	elm.id = 'row_' + numRows;
			
		html += '	<table class="tb_list">';
			html += '	<tr>';
			{/literal}
				html += '	<td>&nbsp;{insert name='tr' value='Odpoveď'} '+numRows+'* </td>';
				{literal}
				html += '	<td width="85%"><input size="50" type="text" name="p__odpoved' +  numRows + '" id="p__odpoved" />&nbsp;&nbsp;<a href="javascript:delRow(\'row_'+ numRows +'\')">&nbsp;<img src="themes/default/images/form_delete.gif" alt="Remove" title="Remove" border="0" /></a></td>';
			html += '	</tr>';
			html += '</table>';

	elm.innerHTML = html;

	document.getElementById(id).appendChild(elm);
	document.forms['uploadForm'].numfiles.value = numRows;
}

function delRow(id) {
	var elm = document.getElementById(id);
	if (elm) {
		elm.parentNode.removeChild(elm);
		scrollCount--;
		document.forms['uploadForm'].numfiles.value = (document.forms['uploadForm'].numfiles.value - 1);
	}
}

function validateForm(form) {

	var elements = form1.elements;

	for (i=0; i<elements.length; i++) {
	
		var name = elements[i].getAttribute("name");
		var value = elements[i].value;

		if ( (name == null) || (name == "mcmd") || (name == "row_id[]") || (name == "f_isPublished") || (name == "section") )
			continue;

		//var indexfilename = name.indexOf("filename");
		//var indexfile = name.indexOf("file");
		//var isFile = (name.indexOf("file") == 0) ? true : false;
		

			if (value == "") {
			{/literal}
				alert('{insert name='tr' value='nezadali ste povinnú položku'}');
			{literal}
				return false;			
			}
	}

	form1.submit();
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
					<td><img class="img_middle" src="{insert name='merge' value1=$path_relative value2='themes/default/images/gallery_view.png'}" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér Fotogalérií / Nová fotogaléria'}</td>
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
		<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
		
			<table class="tb_list">

				<tr class="tr_header">
					<td colspan="2">&nbsp;{insert name='tr' value='Detail fotogalérie'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="../modules/cms_gallery/action.php">
				<input type="hidden" id="section" name="section" value="new" />
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="0" />
				<tr><td colspan="2" class="td_link_space"></td></tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Názov fotogalérie'}*</td>
					<td width="85%"><input size="60" type="text" name="f_title" id="f_title" /></td>
				</tr>
				<tr>
					<td class="td_valign_top">&nbsp;{insert name='tr' value='Popis fotogalérie'}</td>
					<td width="90%"><textarea cols="90" rows="10" name="f_description" id="f_description"></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Viditeľnosť'}</td>
					<td><input type="radio" name="f_isPublished" id="f_isPublished" value="0" checked="checked" />{insert name='tr' value='Nie'}&nbsp;<input type="radio" name="f_isPublished" id="f_isPublished" value="1" />{insert name='tr' value='Áno'}</td>
				</tr>
				<tr>
					<td valign="top" nowrap>&nbsp;{insert name='tr' value='Zobrazovacie&nbsp;práva'}</td>
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
			
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>