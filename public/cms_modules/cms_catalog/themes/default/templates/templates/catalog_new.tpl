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
{assign var='title' value='Katalóg / nový'}
<table class="tb_middle">
	<tr>
		<td colspan="3">{include file="title_menu.tpl"}</td>
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
					<td colspan="2">&nbsp;{insert name='tr' value='Detail katalógu'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="0" />
				<input type="hidden" id="section" name="section" value="catalog" />
				<tr><td colspan="2" class="td_link_space"></td></tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Názov'}*</td>
					<td width="85%"><input size="60" type="text" name="f_title" id="f_title" /></td>
				</tr>
				<tr>
					<td valign="top">&nbsp;{insert name='tr' value='Popis'}*</td>
					<td width="85%"><textarea name="f_description" id="f_description" rows="5" cols="58"></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Viditeľnosť'}</td>
					<td><input type="radio" name="f_isPublished" id="f_isPublished" value="0" checked="checked" />{insert name='tr' value='Nie'}&nbsp;<input type="radio" name="f_isPublished" id="f_isPublished" value="1" />{insert name='tr' value='Áno'}</td>
				</tr>	
			</table>
			</form>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>