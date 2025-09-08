{literal}
<script language="JavaScript" type="text/javascript">
var colorRowMouseOver = '#f5f5f5';
var colorRowMouseOut = '#ffffff';
var coloRowSelectedMouseOut = '#fbe6e6';
var coloRowSelectedMouseOver = '#f7cccc';

function pozadieIN (the_form, id){
	row_name = "row" + id;
	basename_checkbox = "box";
	{/literal}
	{if ($setup_type neq 'visibility')}
	if (document.forms[the_form].elements[basename_checkbox + id].checked)
		document.getElementById(row_name).style.background = coloRowSelectedMouseOver;
	else
		document.getElementById(row_name).style.background = colorRowMouseOver;
	{else}
		document.getElementById(row_name).style.background = colorRowMouseOver;
	{/if}
	{literal}
}

function pozadieOUT (the_form, id){
	row_name = "row" + id;
	basename_checkbox = "box";
	{/literal}
	{if ($setup_type neq 'visibility')}
	if (document.forms[the_form].elements[basename_checkbox + id].checked)
		document.getElementById(row_name).style.background = coloRowSelectedMouseOut;
	else
		document.getElementById(row_name).style.background = colorRowMouseOut;
	{else}
		document.getElementById(row_name).style.background = colorRowMouseOut;
	{/if}
	{literal}
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

			if (basename == 'box')
				setRowBgColor (the_form, i);
        }
    }

    return true;
}

function setSelect(the_form, id, min, max){
	var basename = "box";
	pocetChecked = 0;

	setupValue = document.forms[the_form].elements[id].value ;

	{/literal}
	{foreach name='product' from=$product_list item='product_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.product.iteration}

	{literal}

	for (var i = min; i <= max; i++){
		if (typeof(document.forms[the_form].elements[basename + i]) != 'undefined') {
			if (document.forms[the_form].elements[basename + i].checked == true){
				document.forms[the_form].elements["access" + i].value = setupValue;
				pocetChecked++;
			}

		}
	}

	if(pocetChecked == 0 ){
		{/literal}
        	alert("{insert name='tr' value='Nevybrali ste žiadny záznam na spracovanie'}!");
		{literal}
    }
}

function setCalendar(the_form, id, min, max){
	var basename = "box";
	pocetChecked = 0;

	setupValue = document.forms[the_form].elements[id].value ;


	for (var i = min; i <= max; i++){
		if (typeof(document.forms[the_form].elements[basename + i]) != 'undefined') {
			if (document.forms[the_form].elements[basename + i].checked == true){
				new_id = i + 1 ;
				document.forms[the_form].elements["f-calendar-field-" + new_id].value = setupValue;
				pocetChecked++;
			}

		}
	}

	if(pocetChecked == 0 ){
		{/literal}
        	alert("{insert name='tr' value='Nevybrali ste žiadny záznam na spracovanie'}!");
		{literal}
    }
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


function ischecked_no(the_form,min,max,act_type,act_value){
      submitform(act_type,act_value)
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

function checkControl(categoryTree,form_search){
  var isOptionDisabled = categoryTree.options[categoryTree.selectedIndex].disabled;
  if(isOptionDisabled){
    categoryTree.selectedIndex = 0;//categoryTree.defaultSelectedIndex;
    return false;
  }
  else categoryTree.defaultSelectedIndex = categoryTree.selectedIndex;
  form_search.submit();
}

</script>
{/literal}

<table class="tb_middle">

	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td width="60%"><img class="img_middle" src="images/article_view_info.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér článkov'}</td>
					<td class="td_align_right">
						<img class="img_middle" src="images/filter_m_add.png" alt="{insert name='tr' value='filter'}" />
					</td>
					<form name="search" method="get">
					<input type="hidden" name="cmd" value="7" />
					<td class="td_right">
						<input width="17" name="q" id="q" type="text" />&nbsp;&nbsp;<input type="submit" value="{insert name='tr' value='OK'}">&nbsp;&nbsp;
					</td>
					</form>
					<form method="get" name="form_search" id="form_search">
					<input type="hidden" name="cmd" value="7" />
					<td class="td_align_right">
						<select name="s_category" onchange="return checkControl(this,form_search)">
							<option value="0">{insert name='tr' value='všetky kategórie'}</option>
							{insert name='getOptionListMappedCategory' free='totally' select=$s_category}
						</select>
					</td>
					</form>
					<form method="get" name="form_search_author" id="form_search_author">
					<input type="hidden" name="cmd" value="7" />
					<td class="td_align_right">
						<select name="s_author" onchange="form_search_author.submit()">
							<option value="0">{insert name='tr' value='všetci autori'}</option>
							{insert name='getOptionListAuthors' select=$s_author}
						</select>
					</td>
					</form>
				</tr>
			</table>
		</td>
	</tr>

	<tr><td colspan="3" class="td_link_v"></td></tr>
  {assign var='max_list' value=0}
	{foreach name='category' from=$article_list item='article_id' }
	    {if !($article_id->getIsTrash()) AND !($article_id->getIsArchive())}
					{assign var=max_list value=$max_list+1}
			{/if}
	{/foreach}
	<tr>
		<td class="td_middle_left">
			{include_php file="scripts/toolbar.php"}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<form name="form1" id="form1" method="post" action="action.php">
				{if $setup_type == ''}
					<input type="hidden" id="section" name="section" value="article" />
				{elseif $setup_type == 'visibility'}
					<input type="hidden" id="section" name="section" value="article_visibility" />
				{elseif $setup_type == 'access'}
					<input type="hidden" id="section" name="section" value="article_access" />
				{elseif $setup_type == 'expire'}
					<input type="hidden" id="section" name="section" value="article_expire" />
				{/if}
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
				<input type="hidden" id="go" name="go" value="0" />
				<input type="hidden" id="start" name="start" value="{$start}" />
				{$table->getTable()}
			</form>
				{include file="Proxia:default.pager" list=$article_list}
			<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
