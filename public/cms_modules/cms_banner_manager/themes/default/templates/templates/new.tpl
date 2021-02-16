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
			"c_title","0","100","V",
			"c_impressions_purchased","0","100","N"
		);


function insertfile(form_name,form_text_name){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
	} 
</script>
{/literal}
{insert name=check}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="{insert name='merge' value1=$path_relative value2='themes/default/images/banner_view.png'}" alt="" />&nbsp;&nbsp;{insert name='tr' value='Banner manažér / Nový'}</td>
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
			<table width="100%">
			<tr>
				<td class="td_valign_top">
					<table class="tb_list">
						<tr class="tr_header">
							<td colspan="2">&nbsp;{insert name='tr' value='Detail'}</td>
						</tr>
				<form name="form1" id="form1" method="post" action="../modules/cms_banner_manager/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="0" />
				<input type="hidden" id="section" name="section" value="update" />		
						<tr><td colspan="2" class="td_link_space"></td></tr>
						
						<tr>
							<td width="150">&nbsp;{insert name='tr' value='Názov'}*</td>
							<td><input maxlength="60" size="60" type="text" name="c_title" id="c_title" /></td>
						</tr>
						<tr>
							<td width="150">&nbsp;{insert name='tr' value='Popis'}</td>
							<td><input size="80" type="text" name="c_description" id="c_description" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Banner'}</td>
							<td width="30%"><input size=50 type="text" name="c_source_url" id="c_source_url" />
                  			<a href="javascript:insertfile('form1','c_source_url')" title="{insert name='tr' value='vlož obrázok'}"><img src="themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
						</tr>
						<tr>
							<td width="150">&nbsp;{insert name='tr' value='Kód'}</td>
							<td><input size="60" type="text" name="c_name" id="c_name" /></td>
						</tr>
						<tr>
							<td width="150">&nbsp;{insert name='tr' value='Platnosť od'}</td>
							<td>{insert name=makeCalendar nazov="c_valid_from"}</td>
						</tr>
						<tr>
							<td width="150">&nbsp;{insert name='tr' value='Platnosť do'}</td>
							<td>{insert name=makeCalendar nazov="c_valid_to"}</td>
						</tr>
						<tr>
							<td width="150">&nbsp;{insert name='tr' value='Cieľ URL'}</td>
							<td><input size="60" type="text" name="c_target_url" id="c_target_url" /></td>
						</tr>
						<!--tr>
							<td width="150">&nbsp;{insert name='tr' value='Výška'}</td>
							<td><input maxlength="5" size="5" type="text" name="c_width" id="c_width" value="0"/></td>
						</tr>
						<tr>
							<td width="150">&nbsp;{insert name='tr' value='Šírka'}</td>
							<td><input maxlength="5" size="5" type="text" name="c_height" id="c_height"  value="0"/></td>
						</tr-->
						<tr>
							<td width="150">&nbsp;{insert name='tr' value='Povolených zobrazení'}</td>
							<td><input size="5" type="text" name="c_impressions_purchased" id="c_impressions_purchased"  value="0"/></td>
						</tr>
						<tr><td colspan="2"><hr /></td></tr>
					</table>
				</td>
			</tr>
		</table>
		<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
