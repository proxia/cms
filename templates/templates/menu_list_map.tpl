{literal}
<script language="JavaScript" type="text/javascript">

var colorRowMouseOver = '#f5f5f5';
var colorRowMouseOut = '#ffffff';
var coloRowSelectedMouseOut = '#fbe6e6';
var coloRowSelectedMouseOver = '#f7cccc';

function pozadieIN (the_form, id){
	row_name = "row" + id;
	basename_checkbox = "box";
	
	if (document.forms[the_form].elements[basename_checkbox + id].checked)
		document.getElementById(row_name).style.background = coloRowSelectedMouseOver;
	else
		document.getElementById(row_name).style.background = colorRowMouseOver;
}

function pozadieOUT (the_form, id){
	row_name = "row" + id;
	basename_checkbox = "box";
	
	if (document.forms[the_form].elements[basename_checkbox + id].checked)
		document.getElementById(row_name).style.background = coloRowSelectedMouseOut;
	else
		document.getElementById(row_name).style.background = colorRowMouseOut;
}

function setRowBgColor(the_form, id){
	
	basename_checkbox = "box";
	row_name = "row" + id;
	is_check = document.forms[the_form].elements[basename_checkbox + id].checked;
	
	if (is_check){
		document.getElementById(row_name).style.background = coloRowSelectedMouseOut;
	}
	else{
		document.getElementById(row_name).style.background = colorRowMouseOut;
	}
}

function selectall_2(the_form, min, max,basename){
	//basename = "box";
    for (var i = min; i <= max; i++) {
        if (typeof(document.forms[the_form].elements[basename + i]) != 'undefined') {
            document.forms[the_form].elements[basename + i].checked = document.forms[the_form].elements[basename].checked;
			setRowBgColor (the_form, i);
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

function listItemTask(the_form,min,max,act_type,act_value,act_type2,act_value2,row){
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
			submitform(act_type,act_value,act_type2,act_value2)
		}
  }
  

function addelement(act_type,act_value){
	var newelement = document.createElement('INPUT'); 
	newelement.type = 'hidden'; 
	newelement.name = act_type; 
	newelement.value = act_value;
	document.form1.appendChild(newelement)
} 

function submitform(act_type,act_value,act_type2,act_value2){
	addelement(act_type,act_value);
	addelement(act_type2,act_value2);
	try {
		document.form1.onsubmit();
		}
	catch(e){}
		document.form1.submit();
}
</script>
{/literal}
<table class="tb_middle">
	<form method="get" name="form_search" id="form_search">
	<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
	<tr>
		<td>
		
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/menu_view_move.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér menu / Väzby menu'} {if is_object($current_menu)}<span class="black">{$current_menu->getTitle()}</span>{/if}</td>
					<td class="td_align_right">
						<img class="img_middle" src="images/filter_m_add.png" alt="{insert name='tr' value='filter'}" />
						<select name="s_category" onchange="form_search.submit()">
							<!--<option value="0">{insert name='tr' value='VYBERTE SI MENU'}</option>-->
							{foreach name='menu' from=$menu_list item='menu_id'}
										{$menu_id->setContextLanguage($localLanguage)}
											{assign var=defaultView value=0}
											{if ($menu_id->getTitle() eq '')}
												{$menu_id->setContextLanguage($localLanguageDefault)}
												{assign var=defaultView value=1}
											{/if}
							<option value="{$menu_id->getId()}" {if $menu_id->getId() eq $s_category}selected{/if} >
											{if $defaultView eq 1}{$defaultViewStartTag}{/if}
												{$menu_id->getTitle()}
											{if $defaultView eq 1}{$defaultViewEndTag}{/if}
							</option>
							{/foreach}
						</select>
						&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
			</table>
		
		</td>
	</tr>
	</form>
	<tr><td class="td_link_v"></td></tr>
	
	{if $s_category > 0}
	
	{assign var='max_list' value=0}
	{foreach name='category' from=$category_list_filter item='category_id'}
		{insert name=getObjectType item=$category_id set='section' assign="row_type"}
		{if ($row_type eq 'category')OR($row_type eq 'article')OR($row_type eq 'weblink')}
			{if !($category_id->getIsTrash())}
				{assign var=max_list value=$max_list+1}
			{/if}
		{/if}
	{/foreach}
	<tr>
		<td class="td_middle_center">
		<form name="form1" id="form1" method="post" action="action.php">
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
				<input type="hidden" id="s_category" name="s_category" value="{$s_category}" />
				
			{$table->getTable()}
			</form>
			<br />
		</td>
	</tr>
	<tr><td class="td_link_v"></td></tr>
	{/if}
</table>
