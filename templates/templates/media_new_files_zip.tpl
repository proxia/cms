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


var numRows = 0;
var scrollCount = 0;

function addRow(id, addheight, skip_add) {
	var html = "";

	//if (!skip_add)
		numRows++;

	scrollCount++;

	var elm = document.createElement("div");
	elm.id = 'row_' + numRows;

	html += '<hr />';
	html += '<table border="0" cellspacing="0" cellpadding="4">';
	html += '<tr><td nowrap="nowrap"></td>';
	html += '<td><input name="file' + numRows + '" type="file" size="80" /></td>';
	html += '<td><a href="javascript:delRow(\'row_'+ numRows +'\')">&nbsp;<img src="images/form_delete.gif" alt="Remove" title="Remove" border="0" /></a></td>';
	html += '</tr></table>';

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

	var elements = document.forms["form1"].elements;

	for (i=0; i<elements.length; i++) {
	
		var name = elements[i].getAttribute("name");
		var value = elements[i].value;

		if ( (name == null) || (name == "section") || (name == "cmd") || (name == "fileinfolder") )
			continue;

		//var indexfilename = name.indexOf("filename");
		//var indexfile = name.indexOf("file");
		var isFile = (name.indexOf("file") == 0) ? true : false;
		
		if (isFile) {
			fileid = name.substring(4);
			if (value == "") {
			{/literal}
				alert('{insert name='tr' value='nezadali ste povinnú položku'}');
			{literal}
				return false;
			}
			
		}
	}

	document.forms["form1"].submit();
}
</script>
{/literal}
<table class="tb_middle">
<form method="post" name="form_search" id="form_search">
	<tr>
		<td colspan="5">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/media_view_add.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér médií / Nové súbory zabalené v ZIP súbore'}</td>
				</tr>
			</table>
		</td>
	</tr>
	</form>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left">
			{include_php file="../scripts/toolbar.php"}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
		<form action="action.php" accept-charset="utf-8" method="post" name="form1" id="form1" enctype="multipart/form-data">
		<input type="hidden" name="section" value="media">
		<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
		<input type="hidden" name="zip" id="zip" value="1" />
			<table>
				<tr>
					<td>
						{insert name='tr' value='Cieľový adresár'}&nbsp;&nbsp;<br /><br />
					</td>
					<td>
						<select name="fileinfolder" id="fileinfolder">
							<option value="..{$project_folder}/{$site_name_name}/mediafiles/">/</option>
							{insert name=getOptionFolderList selected=$m_directory}
						</select>
						<br /><br />
					</td>
				</tr>
				<tr>
					<td nowrap="nowrap"></td>
					<td><input name="file0" id="file0" type="file" size="80" /></td>
				</tr>
				<tr>
					<td nowrap="nowrap"></td>
					<td>{insert name='tr' value='Vložte iba súbor s koncovkou "zip". Po nakopírovaní sa obsah zip súboru nakopíruje do vybratého cieľového adresára.'}</td>
				</tr>
				<tr><td></td><td><div id="addPosition"></div></td></tr>
			</table>
				
				<hr />
		</form>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>