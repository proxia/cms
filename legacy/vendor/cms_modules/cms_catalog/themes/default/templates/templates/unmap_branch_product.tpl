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
</script>
{/literal}
{$detail_branch->setContextLanguage("$localLanguage")}
{assign var='title_branch' value = $detail_branch->getTitle() }
{php}
	$title = tr('Vymazanie kategórie ') ;
	$title .= $GLOBALS['smarty']->get_template_vars(title_branch);
	$title .= tr(' z produktov');
	$GLOBALS["smarty"]->assign("title",$title);
{/php}

<table class="tb_middle">
	<tr>
		<td colspan="3">{include file="title_menu.tpl"}</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	
	{foreach name='product' from=$product_list item='product_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.product.iteration}
	<tr>
		<td class="td_middle_left">
		{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
		{include_php file=$path_toolbar}
		</td>
		<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list2">
				{assign var="stlpcov" value=6}
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form1',1,{$max_list})" /></td>
					<td>{insert name='tr' value='Názov produktu'}</td>
					<td>{insert name='tr' value='Kód produktu'}</td>
					<td class="td_align_center">{insert name='tr' value='ID produktu'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="section" name="section" value="unmapbranchtoproducts" />
				<input type="hidden" id="branch_id" name="branch_id" value="{$detail_branch->getId()}" />
				<input type="hidden" id="start" name="start" value="{$start}" />
			{foreach name='product' from=$product_list item='product_id'}
				
				{$product_id->setContextLanguage($localLanguage)}
				{assign var=defaultView value=0}
				{if ($product_id->getTitle() eq '')}
					{$product_id->setContextLanguage($localLanguageDefault)}
					{assign var=defaultView value=1}
				{/if}

				<tr>
					<td colspan="{$stlpcov}" class="td_link_space"></td>
				</tr>
				<tr id="row{$smarty.foreach.product.iteration}" onmouseover="pozadieIN('form1','{$smarty.foreach.product.iteration}')" onmouseout="pozadieOUT('form1','{$smarty.foreach.product.iteration}')">
					<td class="td_align_center">{$smarty.foreach.product.iteration}</td>
					<td><input onclick="setRowBgColor('form1',{$smarty.foreach.product.iteration})" id="box{$smarty.foreach.product.iteration}" type="checkbox" name="row_id[]" value="{$product_id->getId()}" /></td>
					<td>
						<a href="./?module=CMS_Catalog&mcmd=12&row_id[]={$product_id->getId()}">
							{if $defaultView eq 1}{$defaultViewStartTag}{/if}
								{$product_id->getTitle()}
							{if $defaultView eq 1}{$defaultViewEndTag}{/if}
						</a>
					</td>
					<td class="td_align_center">
						{$product_id->getCode()}
					</td>
					<td class="td_align_center">{$product_id->getId()}</td>
				</tr>
			{/foreach}
				</form>
			</table>

			<br />
		</td>
	</tr>
	
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>