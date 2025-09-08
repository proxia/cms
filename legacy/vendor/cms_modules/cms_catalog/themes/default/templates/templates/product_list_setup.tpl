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
	{if ($setup_type eq 'valid' OR $setup_type eq 'access')}
	if (document.forms[the_form].elements[basename_checkbox + id].checked)
		document.getElementById(row_name).style.background = coloRowSelectedMouseOver;
	else
	{/if}
	{literal}
		document.getElementById(row_name).style.background = colorRowMouseOver;
}

function pozadieOUT (the_form, id){
	row_name = "row" + id;
	basename_checkbox = "box";
	{/literal}
	{if ($setup_type eq 'valid' OR $setup_type eq 'access')}
	if (document.forms[the_form].elements[basename_checkbox + id].checked)
		document.getElementById(row_name).style.background = coloRowSelectedMouseOut;
	else
	{/if}
	{literal}
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


function selectall_2(the_form, min, max,basename){
	//basename = "box";
    for (var i = min; i <= max; i++) {
        if (typeof(document.forms[the_form].elements[basename + i]) != 'undefined') {
            document.forms[the_form].elements[basename + i].checked = document.forms[the_form].elements[basename].checked;
			//setRowBgColor (the_form, i);
        }
    }

    return true;
}

//pozor
function ischecked(the_form,min,max,act_type,act_value){

			submitform(act_type,act_value)

  }

function insertfile(form_name,form_text_name){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
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

  if(document.forms["form1"].s_group != undefined)
  {
	var prava = document.forms["form1"].s_group.options[document.forms["form1"].s_group.selectedIndex].value
	document.forms[form_search].group.value = prava;
  }

  if(isOptionDisabled)
  {
    categoryTree.selectedIndex = 0;//categoryTree.defaultSelectedIndex;
    return false;
  }
  else
	categoryTree.defaultSelectedIndex = categoryTree.selectedIndex;

  document.forms[form_search].s_category.value = categoryTree.options[categoryTree.selectedIndex].value
  document.forms[form_search].submit();
}

function setCalendar(the_form, id, fromto){
	var basename = "box";
	pocetChecked = 0;

	setupValue = document.forms[the_form].elements[id].value ;

	{/literal}
	{foreach name='product' from=$product_list item='product_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.product.iteration}

	min = 1;
	max = {$max_list};

	{literal}

	for (var i = min; i <= max; i++){
		if (typeof(document.forms[the_form].elements[basename + i]) != 'undefined') {
			if (document.forms[the_form].elements[basename + i].checked == true){
				if (fromto == 'from')
					new_id = i * 2 + 1 ;

				if (fromto == 'to')
					new_id = i * 2 + 2 ;
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


function setSelect(the_form, id){
	var basename = "box";
	pocetChecked = 0;

	setupValue = document.forms[the_form].elements[id].value ;

	{/literal}
	{foreach name='product' from=$product_list item='product_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.product.iteration}

	min = 1;
	max = {$max_list};

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


function changeCurrency(select,mcmd,start){
	//alert()

	location.href="./?module=CMS_Catalog&mcmd="+mcmd+"&setup_type=price&currency="+select.options[select.selectedIndex].text+"&start="+start;
}

function changeGroup(select,mcmd,start)
{

	var x = "";

	if(document.forms["form1"].s_category != undefined)
	{
		x = "&s_category="+document.forms["form1"].s_category.value;
	}
	location.href="./?module=CMS_Catalog&mcmd="+mcmd+"&setup_type=price&group="+select.options[select.selectedIndex].value+"&start="+start+x;
}

</script>
{/literal}
{assign var='title' value='Produkty / prehľad'}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_top_menu">
				<tr>
					<td width="90%">{include file="title_menu.tpl"}</td>
					<td class="td_align_right">
						<img class="img_middle" src="../themes/default/images/filter_m_add.png" alt="{insert name='tr' value='filter'}" />
					</td>
					<form method="get" name="form_search" id="form_search" onsubmit="">
					<input type="hidden" name="mcmd" value="{$mcmd}" />
					<input type="hidden" name="module" value="{$module}" />
					<input type="hidden" name="setup_type" value="{$setup_type}" />
					<td class="td_align_right">&nbsp;&nbsp;
					<input type="hidden" name="s_category" value="{$s_category}" />
					<input type="hidden" name="group" value="{$group}" />
					</td>
					<td>
						&nbsp;<input type="text" size="20" name="s_string" value="{$s_string}">&nbsp;
					</td>
					<td>
						<input type="submit" value="{insert name='tr' value='ok'}">
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
			<table class="tb_list2" border="0">
				{assign var="stlpcov" value=6}
				{if $setup_type eq 'valid'}
					{assign var="stlpcov" value=10}
				{elseif $setup_type eq 'image'}
					{assign var="stlpcov" value=8}
				{elseif $setup_type eq 'access'}
					{assign var="stlpcov" value=8}
				{elseif $setup_type eq 'price'}
					{assign var="stlpcov" value=8}
				{elseif $setup_type eq 'stock'}
					{assign var="stlpcov" value=8}
				{/if}
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					{if $setup_type eq 'valid' OR $setup_type eq 'access' OR $setup_type eq 'price' OR $setup_type eq 'stock'}
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form1',1,{$max_list})" /></td>
					{/if}
					<td>{insert name='tr' value='Názov produktu'}</td>

					{if $setup_type neq 'price'}
					<td>{insert name='tr' value='Kód'}</td>
					{/if}

					<td>{insert name='tr' value='Kategória'}</td>
					{if $setup_type eq 'visibility'}
						<td class="td_align_center">{insert name='tr' value='Viditeľnosť produktu'}</td>

						{foreach name='language' from=$LanguageListLocal item='language_id'}
						<td>{$language_id.code}</td>
						{/foreach}

					{elseif $setup_type eq 'valid'}
						<td>{insert name='tr' value='Platnosť od'}</td>
						<td></td>
						<td>{insert name='tr' value='Platnosť do'}</td>
						<td></td>

					{elseif $setup_type eq 'image'}

						<td colspan="3">{insert name='tr' value='Obrázok'}</td>

					{elseif $setup_type eq 'access'}

						<td>{insert name='tr' value='Zobrazovacie práva'}</td>
						<td></td>

					{elseif $setup_type eq 'price'}
						<td>{insert name='tr' value='Kód'}</td>
						<td>{insert name='tr' value='Cena'}</td>
						<td></td>
					{elseif $setup_type eq 'news'}

						<td>{insert name='tr' value='Novinky'}</td>
						<td></td>
					{elseif $setup_type eq 'sale'}

						<td>{insert name='tr' value='Výpredaj'}</td>
						<td></td>
					{elseif $setup_type eq 'stock'}

						<td colspan="2">{insert name='tr' value='Skladom položiek'}</td>
					{/if}
					<td class="td_align_center">{insert name='tr' value='ID'}</td>
				</tr>
			<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="section" name="section" value="product_setup" />
				<input type="hidden" name="setup_type" id="setup_type" value="{$setup_type}" />
				<input type="hidden" id="start" name="start" value="{$start}" />


				{if $setup_type eq 'valid'}
				<tr class="tr_header">
					<td></td>
					<td></td>
					<td colspan="2" ></td>
					<td>
						<select name="s_category" onchange="return checkControl(this,'form_search')">
							<option value="0">{insert name='tr' value='vo všetkých kategóriách'}</option>
							<option value="-1" {if $s_category eq -1}selected="selected"{/if}>{insert name='tr' value='len nepriradené'}</option>
							{insert name='getOptionListBranch' catalog='$catalog_id' select=$s_category type='end'}
						</select>
					</td>
					<td width="160">{insert name=makeCalendar nazov="validfromdefault"}</td>
					<td width="50"><a href="javascript:setCalendar('form1','f-calendar-field-1','from')" title="{insert name='tr' value='prednastav'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
					<td width="160">{insert name=makeCalendar nazov="validtodefault"}</td>
					<td width="22"><a href="javascript:setCalendar('form1','f-calendar-field-2','to')" title="{insert name='tr' value='prednastav'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
					<td></td>
				</tr>
				{elseif $setup_type eq 'access'}
				<tr class="tr_header">
					<td></td>
					<td></td>
					<td colspan="2" ></td>
					<td>
						<select name="s_category" onchange="return checkControl(this,'form_search')">
							<option value="0">{insert name='tr' value='vo všetkých kategóriách'}</option>
							<option value="-1" {if $s_category eq -1}selected="selected"{/if}>{insert name='tr' value='len nepriradené'}</option>
							{insert name='getOptionListBranch' catalog='$catalog_id' select=$s_category type='end'}
						</select>
					</td>
					<td width="100">
							<select name="access_default" id="access_default">
								<option value="{$ACCESS_PUBLIC}" {if $product_id->getAccess() eq $ACCESS_PUBLIC}selected="selected"{/if} >{insert name='tr' value='Verejné'}</option>
								<option value="{$ACCESS_REGISTERED}" {if $product_id->getAccess() eq $ACCESS_REGISTERED}selected="selected"{/if} >{insert name='tr' value='Registrovaným'}</option>
								<option value="{$ACCESS_SPECIAL}" {if $product_id->getAccess() eq $ACCESS_SPECIAL}selected="selected"{/if} >{insert name='tr' value='Skupiny používateľov'}</option>
							</select>
					</td>
					<td width="22"><a href="javascript:setSelect('form1','access_default')" title="{insert name='tr' value='prednastav'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
					<td></td>
				</tr>
				{elseif $setup_type eq 'price'}
				<tr class="tr_header">
					<td></td>

					<td colspan="2" ></td>
					<td>
						<select name="s_category" onchange="return checkControl(this,'form_search')">
							<option value="0">{insert name='tr' value='vo všetkých kategóriách'}</option>
							<option value="-1" {if $s_category eq -1}selected="selected"{/if}>{insert name='tr' value='len nepriradené'}</option>
							{insert name='getOptionListBranch' catalog='$catalog_id' select=$s_category type='end'}
						</select>
						{insert name='tr' value='Práva'}
						<select name="s_group" onchange="return changeGroup(this,{$mcmd},{$start});">
							<option  value="{$ACCESS_PUBLIC}" {if $selected_group eq $ACCESS_PUBLIC} selected="selected" {/if} >{insert name='tr' value='Verejné'}</option>
							<option  value="{$ACCESS_REGISTERED}" {if $selected_group eq $ACCESS_REGISTERED} selected="selected" {/if}>{insert name='tr' value='Registrovaným'}</option>

							{foreach name='group' from=$group_list item=group_detail}
								{$group_detail->setContextLanguage($localLanguage)}
								{assign var=sel_group value=$group_detail->getId()}
								{assign var="button_text" value="`$ACCESS_SPECIAL`-`$sel_group`"}

								<option {if $selected_group eq $button_text  } selected="selected" {/if} value="{$ACCESS_SPECIAL}-{$group_detail->getId()}">{insert name='tr' value='Skupina'}:{$group_detail->getTitle()}</option>
							{/foreach}
						</select>
					</td><td></td>
					<td width="140">
							<input type="text" name="price_default" id="price_default" size="10">
							{insert name="getAvailableCurrencies" assign=currencies}
							<input type="hidden" id="currency" name="currency" value="{$price_currency}" />

							<select name="price_currency" onchange=" changeCurrency(this,{$mcmd},{$start}); return true;">
							{foreach name='currencies' from=$currencies item='currency' }
								{if $smarty.foreach.currencies.iteration eq 1}
								  {assign var=sel_currency value=$currency}
								{/if}
								{if $price_currency eq $currency}
								  {assign var=sel_currency value=$currency}
										<option selected>{$currency}</option>
								{else}
										<option >{$currency}</option>
								{/if}
							{/foreach}
							</select>
					</td>
					<td width="22"><a href="javascript:setSelect('form1','price_default')" title="{insert name='tr' value='prednastav'}">
						<img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
					<td></td>
				</tr>
				{elseif $setup_type eq 'stock'}
				<tr class="tr_header">
					<td></td>
					<td></td>
					<td colspan="2" ></td>
					<td>
						<select name="s_category" onchange="return checkControl(this,'form_search')">
							<option value="0">{insert name='tr' value='vo všetkých kategóriách'}</option>
							<option value="-1" {if $s_category eq -1}selected="selected"{/if}>{insert name='tr' value='len nepriradené'}</option>
							{insert name='getOptionListBranch' catalog='$catalog_id' select=$s_category type='end'}
						</select>
					</td>
					<td width="90" >
							<input type="text" name="stock_default" id="stock_default" size="10">
					</td>
					<td width="22"><a href="javascript:setSelect('form1','stock_default')" title="{insert name='tr' value='prednastav'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
					<td></td>
				</tr>
				{elseif $setup_type eq 'visibility'}
				<tr class="tr_header">
					<td></td>
					<td colspan="2" ></td>
					<td>
						<select name="s_category" onchange="return checkControl(this,'form_search')">
							<option value="0">{insert name='tr' value='vo všetkých kategóriách'}</option>
							<option value="-1" {if $s_category eq -1}selected="selected"{/if}>{insert name='tr' value='len nepriradené'}</option>
							{insert name='getOptionListBranch' catalog='$catalog_id' select=$s_category type='end'}
						</select>
					</td>
					<td class="td_align_center"><input title="vybrať všetko / zrušiť všetko" id="visibility" type="checkbox" name="selectall" value="1" onclick="selectall_2('form1',1,{$max_list},'visibility')" /></td>
					{foreach name='language' from=$LanguageListLocal item='language_id' }
							<td><input title="vybrať všetko / zrušiť všetko" id="language{$language_id.code}" type="checkbox" name="selectall" value="1" onclick="selectall_2('form1',1,{$max_list},'language{$language_id.code}')" /></td>
					{/foreach}
					<td></td>
				</tr>

				{/if}

			{foreach name='product' from=$product_list item='product_id'}

				{assign var='id' value=$product_id->getId()}
				{$product_id->setContextLanguage($localLanguage)}
				{assign var=defaultView value=0}
				{if ($product_id->getTitle() eq '')}
					{$product_id->setContextLanguage($localLanguageDefault)}
					{assign var=defaultView value=1}
				{/if}
				<tr>
					<td colspan="{$stlpcov}" class="td_link_space"><input type="hidden" name="row_id[]" value="{$product_id->getId()}"></td>
					{foreach name='language' from=$LanguageListLocal item='language_id' }
					<td class="td_link_space"></td>
					{/foreach}
				</tr>

				{assign var=showItem value=0}
    			{assign var=showItemEdit value=0}

				{if ($user_login->checkPrivilege(1050002, $privilege_view) eq 1)}
				{assign var=showItem value=1}
				{else}
				{assign var=showItem value=0}
				{/if}

				{if ($user_login_type eq $admin_user)}
					{assign var=showItem value=1 }
				{/if}

				{if ($user_login->checkPrivilege(1050002, $privilege_update) eq 1)}
					{assign var=showItemEdit value=1}
				{else}
					{assign var=showItemEdit value=0}
				{/if}

				{if ($user_login_type eq $admin_user)}
					{assign var=showItemEdit value=1}
				{/if}

				<tr id="row{$smarty.foreach.product.iteration}" >
					<td class="td_align_center" style="line-height:20px;">{$smarty.foreach.product.iteration+$start}</td>
					{if $setup_type eq 'valid' OR $setup_type eq 'access' OR $setup_type eq 'price' OR $setup_type eq 'stock'}
					<td><input onclick="setRowBgColor('form1',{$smarty.foreach.product.iteration})"  id="box{$smarty.foreach.product.iteration}" type="checkbox" name="row_id[]" value="{$product_id->getId()}" /></td>
					{/if}
					<td>
						{if $showItem eq 1}
							<a href="./?module=CMS_Catalog&mcmd=12&row_id[]={$product_id->getId()}">
								{if $defaultView eq 1}{$defaultViewStartTag}{/if}
									{$product_id->getTitle()}
								{if $defaultView eq 1}{$defaultViewEndTag}{/if}
							</a>
						{else}
							{if $defaultView eq 1}{$defaultViewStartTag}{/if}
								{$product_id->getTitle()}
							{if $defaultView eq 1}{$defaultViewEndTag}{/if}
						{/if}
					</td>
					{if $setup_type neq 'price'}
					<td>
						{$product_id->getCode()}
					</td>
					{/if}
					<td>
						{foreach name='category_list' from=$product_id->getParents() item='category_item'}
							{$category_item->setContextLanguage($localLanguage)}
							{$category_item->getTitle()},
						{/foreach}
					</td>
					{if $setup_type eq 'visibility'}

						<td class="td_align_center">
							<input {if $showItemEdit eq 0}disabled="disabled"{/if} id="visibility{$smarty.foreach.product.iteration}" name="visibility[{$product_id->getId()}]" type="checkbox" value="1" {if $product_id->getIsPublished() eq 1}checked="checked"{/if}>
						</td>
						{foreach name='language' from=$LanguageListLocal item='language_id' }
						{assign var=triedaLang value='class="hrefyeslang"'}
						{$product_id->setContextLanguage($language_id.code)}
						{if ($product_id->getTitle() eq '')}{assign var=triedaLang value='class="hrefnolang"'}{/if}
							<td><input {if $showItemEdit eq 0}disabled="disabled"{/if} id="language{$language_id.code}{$smarty.foreach.product.iteration}" type="checkbox" name="a_languageIsVisible{$language_id.code}[{$product_id->getId()}]" value="1" {if $product_id->getLanguageIsVisible() eq 1}checked="checked"{/if}></td>
						{/foreach}

					{elseif $setup_type eq 'valid'}
						<td>{insert name=makeCalendar nazov="validfrom['$id']" id=$smarty.foreach.product.iteration value=$product_id->getValidFrom()}</td>
						<td></td>
						<td>{insert name=makeCalendar nazov="validto['$id']" id=$smarty.foreach.product.iteration value=$product_id->getValidTo()}</td>
						<td></td>
					{elseif $setup_type eq 'image'}

						{php}
							$path = "../mediafiles/".$GLOBALS['smarty']->get_template_vars(product_id)->getImage();
							$name = basename($path);
							$GLOBALS["smarty"]->assign("icon_name",$name);
							$GLOBALS["smarty"]->assign("icon_path",$path);
						{/php}

						<td width="100"><input size=50 type="text" name="image[{$id}]" id="image{$id}" value="{$product_id->getImage()}" /></td>
						<td width="22"><a href="javascript:insertfile('form1','image{$id}')" title="{insert name='tr' value='vlož obrázok'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
						{if ($product_id->getImage() eq '')}
	                     	<td width="22"></td>
	                  	{else}
	                      	<td width="22">&nbsp;<a  href="{$icon_path}" target="_blank" title="{insert name='tr' value='ukáž'}"><img src="../themes/default/images/view_s.png" border="0"></a></td>
	                  	{/if}

					{elseif $setup_type eq 'access'}

						<td>
							<select name="access[{$id}]" id="access{$smarty.foreach.product.iteration}">
								<option value="{$ACCESS_PUBLIC}" {if $product_id->getAccess() eq $ACCESS_PUBLIC}selected="selected"{/if} >{insert name='tr' value='Verejné'}</option>
								<option value="{$ACCESS_REGISTERED}" {if $product_id->getAccess() eq $ACCESS_REGISTERED}selected="selected"{/if} >{insert name='tr' value='Registrovaným'}</option>
								<option value="{$ACCESS_SPECIAL}" {if $product_id->getAccess() eq $ACCESS_SPECIAL}selected="selected"{/if} >{insert name='tr' value='Skupiny používateľov'}</option>
							</select>
						</td>
						<td></td>

					{elseif $setup_type eq 'price'}
					<td>
						{$product_id->getCode()}
					</td>
						{insert name=getPrice id=$id currency=$sel_currency assign=price access=$selected_group}
						<td>
							<input type="text" name="price[{$id}][{$price.id}]" id="access{$smarty.foreach.product.iteration}" size="10" value="{$price.price}">
						</td>
						<td></td>
					{elseif $setup_type eq 'news'}

						<td>
							<input id="news{$smarty.foreach.product.iteration}" name="news[{$product_id->getId()}]" type="checkbox" value="1" {if $product_id->getIsNews() eq 1}checked="checked"{/if}>
						</td>
						<td></td>
					{elseif $setup_type eq 'sale'}

						<td>
							<input id="sale{$smarty.foreach.product.iteration}" name="sale[{$product_id->getId()}]" type="checkbox" value="1" {if $product_id->getIsSale() eq 1}checked="checked"{/if}>
						</td>
						<td></td>
					{elseif $setup_type eq 'stock'}
						<td>
							<input type="text" name="stock[{$product_id->getId()}]" id="access{$smarty.foreach.product.iteration}" size="10" value="{$product_id->getInStock()}">
						</td>
						<td></td>
					{/if}
					<td class="td_align_center">{$product_id->getId()}</td>

				</tr>
			{/foreach}
				</form>
			</table>
				{include file="Proxia:default.pager" list=$product_list}
			<br />
		</td>
	</tr>

	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
