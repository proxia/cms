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

//pozor
function ischecked(the_form,min,max,act_type,act_value){
		
			submitform(act_type,act_value)

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
{assign var='title' value='Produkty / prehľad'}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table width="100%">
				<tr>
					<td>{include file="title_menu.tpl"}</td>
					<form method="get" name="form_search" id="form_search" onsubmit="">
					<input type="hidden" name="mcmd" value="{$mcmd}" />
					<input type="hidden" name="module" value="{$module}" />
					<td class="td_align_right">
						<select name="s_category" onchange="return checkControl(this,form_search)">
							<option value="0">{insert name='tr' value='všetky kategórie'}</option>
							{insert name='getOptionListBranch' catalog='$catalog_id' select=$s_category type='end'}
						</select>
					</td>
					</form>
				</tr>
			</table>
		</td>
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
		<td class="td_link_h"><img src="../themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list2">
				{assign var="stlpcov" value=4}
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td>{insert name='tr' value='Názov produktu'}</td>
					
					{foreach name='language' from=$LanguageListLocal item='language_id'}	
					<td>{$language_id.code}</td>					
					{/foreach}
						
					<td class="td_align_center">{insert name='tr' value='ID'}</td>
					
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="section" name="section" value="product_language" />
				<input type="hidden" name="language_visibility" id="language_visibility" value="1" />
				<input type="hidden" id="start" name="start" value="{$start}" />
				
			{foreach name='product' from=$product_list item='product_id'}
				<input type="hidden" name="row_id[]" value="{$product_id->getId()}">
				{$product_id->setContextLanguage($localLanguage)}
				{assign var=defaultView value=0}
				{if ($product_id->getTitle() eq '')}
					{$product_id->setContextLanguage($localLanguageDefault)}
					{assign var=defaultView value=1}
				{/if}

				<tr>
					<td colspan="{$stlpcov}" class="td_link_space"></td>
					{foreach name='language' from=$LanguageListLocal item='language_id' }
					<td class="td_link_space"></td>
					{/foreach}
				</tr>
				<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
					<td class="td_align_center">{$smarty.foreach.product.iteration}</td>
					<td>
						<a href="./?module=CMS_Catalog&mcmd=12&row_id[]={$product_id->getId()}">
							{if $defaultView eq 1}{$defaultViewStartTag}{/if}
								{$product_id->getTitle()}
							{if $defaultView eq 1}{$defaultViewEndTag}{/if}
						</a>
					</td>
					
					{foreach name='language' from=$LanguageListLocal item='language_id' }
					{assign var=triedaLang value='class="hrefyeslang"'}
					{$product_id->setContextLanguage($language_id.code)}
					{if ($product_id->getTitle() eq '')}{assign var=triedaLang value='class="hrefnolang"'}{/if}
						<td><input type="checkbox" name="a_languageIsVisible{$language_id.code}[{$product_id->getId()}]" value="1" {if $product_id->getLanguageIsVisible() eq 1}checked="checked"{/if}></td>
					{/foreach}
					
					<td class="td_align_center">{$product_id->getId()}</td>
					
				</tr>
			{/foreach}
				</form>
			</table>
			
			{if ($qs eq 0) OR ($perpage < $p_totalRecordCount)}
			<table align="right" width="150">
				<tr>
					{if $p_previousStart >= 0}
						<td align="center" width="37">
							<a href="./?mcmd=10&module=CMS_Catalog&start={$p_firstStart}" title="{insert name='tr' value='Úvodná stránka'}"><img src="../themes/default/images/p_start.png" /></a>
						</td>
						<td align="center" width="37">
							<a href="./?mcmd=10&module=CMS_Catalog&start={$p_previousStart}" title="{insert name='tr' value='Predchádzajúca stránka'}"><img src="../themes/default/images/p_back.png" /></a>
						</td>
					{else}
						<td align="center" width="37"></td>
						<td align="center" width="37"></td>
					{/if}
					{if $p_nextStart < $p_totalRecordCount}
						<td align="center" width="38">
							<a href="./?mcmd=10&module=CMS_Catalog&start={$p_nextStart}" title="{insert name='tr' value='Ďalšia stránka'}"><img src="../themes/default/images/p_next.png" /></a>
						</td>
						<td align="center" width="38">
							<a href="./?mcmd=10&module=CMS_Catalog&start={$p_lastStart}" title="{insert name='tr' value='Posledná stránka'}"><img src="../themes/default/images/p_end.png" /></a>
						</td>
					{else}
						<td align="center" width="38"></td>
						<td align="center" width="38"></td>
					{/if}
				</tr>
			</table>
			{/if}
			<br />
		</td>
	</tr>
	
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>