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
					sel_value = 2;
				if (do_check == false)
					sel_value = 1;

			setRowBgColor (the_form, i);
        }
    }

    return true;
}

function hiddencombo(id){

	var style=document.getElementById('combo'+id).style;
	style.visibility = "hidden";

}

function showcombo(id){
	{/literal}
		{foreach name='branch' from=$branch_list item='branch_id' }
			hiddencombo({$smarty.foreach.branch.iteration});
		{/foreach}
	{literal}
	var style=document.getElementById('combo'+id).style;
	style.visibility = "visible";

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

				if ((act_type == "delete") && (act_value == 1)){
			{/literal}
					var potvrdenie = confirm('{insert name='tr' value='Pozor táto operácia je nevratná, vybrané položky sa navždy vymažú !!! Vymazať ?'}')
			{literal}
					if (potvrdenie){
							submitform(act_type,act_value,the_form)
							return;
						}
					else
							return false;
				}



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
{assign var='title' value='Katalóg / prehľad'}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_top_menu">
				<tr>
					<td width="90%">{include file="title_menu.tpl"}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>

	{foreach name='branch' from=$branch_list item='branch_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.branch.iteration}
	<tr>
		<td class="td_middle_left">
		{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
		{include_php file=$path_toolbar}
		</td>
		<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list2">
				{assign var="stlpcov" value=8}

			{foreach name='branch' from=$branch_list item='branch_id'}

				{assign var=defaultView value=0}
				{if ($branch_id.object.title eq '')}
					{assign var=defaultView value=1}
				{/if}

				{assign var=uroven value=$branch_id.uroven}
				{assign var=space value='-'}
				{php}
					$uroven = $GLOBALS['smarty']->get_template_vars(uroven);
					$space = "<td>-</td>";
					$odstup = "";
					for ($f=0;$f<$uroven;$f++){
						$odstup .= $space;
					}
					$GLOBALS["smarty"]->assign("odstup",$odstup);
				{/php}
				<tr>
					<td colspan="{$stlpcov}" class="td_link_space"></td>
				</tr>
				<tr>
					{$odstup}
					<td>
						<a class="bold_href" href="./?module=CMS_Catalog&mcmd=6&row_id[]={$branch_id.object.id}">
							{if $defaultView eq 1}{$defaultViewStartTag}{/if}
								{$branch_id.object.title}
							{if $defaultView eq 1}{$defaultViewEndTag}{/if}
						</a>
					</td>
					{insert name='getNumChild' type='product' id=$branch_id.object.id assign='numProduct'}
					{insert name='getNumChild' type='branch' id=$branch_id.object.id assign='numBranch'}


				</tr>
				<tr>
					{insert name='getBranchProducts' id=$branch_id.object.id assign='product_list'}
					<td></td>
					<td>
						<table>
							{foreach name='product' from=$product_list item='product_id'}
								{$product_id->setContextLanguage($localLanguage)}
								{assign var=defaultView value=0}
								{if ($product_id->getTitle() eq '')}
									{$product_id->setContextLanguage($localLanguageDefault)}
									{assign var=defaultView value=1}
								{/if}
							<tr>
								<td class="bold">{insert name='tr' value='Názov produktu'}</td>
								<td>
									<a href="./?module=CMS_Catalog&mcmd=12&row_id[]={$product_id->getId()}">
										{if $defaultView eq 1}{$defaultViewStartTag}{/if}
											{$product_id->getTitle()}
										{if $defaultView eq 1}{$defaultViewEndTag}{/if}
									</a>
								</td>
							</tr>
							<tr>
								<td class="bold">
									{insert name='tr' value='Kód produktu'}
								</td>
								<td>
									{$product_id->getCode()}
								</td>
							</tr>
							<tr>
								<td class="bold">
									{insert name='tr' value='Popis 1'}
								</td>
								<td>
									{$product_id->getDescription()}
								</td>
							</tr>
							<tr>
								<td class="bold">
									{insert name='tr' value='Popis 2'}
								</td>
								<td>
									{$product_id->getDescriptionExtended()}
								</td>
							</tr>

							{*insert name='getProductAttributes' id=$product_id->getId() assign='attribut_product_list'*}
							{foreach name='attribut_product' from=$attribut_product_list item='attribut_product_id' }
								{assign var='attribut_name' value=$attribut_product_id->getAttributeDefinitionId()}

							<tr>
								<td>
									{$attribut_product_list_title.$attribut_name}
								</td>
								<td>
									{$attribut_product_id->getValue()}
								</td>
							</tr>
							{/foreach}
							<tr><td colspan="2"><br><br></td></tr>
						{/foreach}

						</table>
					</td>
				</tr>

			{/foreach}
			</table>
			<br />
		</td>
	</tr>

	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>