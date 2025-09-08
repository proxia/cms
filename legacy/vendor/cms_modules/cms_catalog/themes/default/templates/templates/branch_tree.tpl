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
{assign var='title' value='Kategórie / prehľad'}
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
					<td class="td_align_right">&nbsp;&nbsp;
						<select name="s_category" onchange="return checkControl(this,form_search)">
							<option value="0">{insert name='tr' value='všetky kategórie'}</option>
							{insert name='getOptionListBranch' catalog='$catalog_id' select=$s_category type='noend'}
						</select>
					</td>
					</form>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	{php}
					ob_start();
				{/php}

				{insert name='getOptionListBranch' catalog='$catalog_id' select=0 unselect=0 assign='strom'}
				{php}
					$GLOBALS['strom'] = ob_get_contents();
					ob_end_clean();
					$GLOBALS["smarty"]->assign("strom",$GLOBALS['strom']);
	{/php}
	{foreach name='branch' from=$branch_list item='branch_id' }
	{/foreach}
	{assign var='max_list' value=$smarty.foreach.branch.iteration}
	<tr>
		<td class="td_middle_left">
		{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
		{include_php file=$path_toolbar}
		</td>
		<td class="td_link_h"><img src="../themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list2">
				{assign var="stlpcov" value=8}
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form1',1,{$max_list})" /></td>
					<td>{insert name='tr' value='Názov'}</td>
					<td class="td_align_center">{insert name='tr' value='Poradie'}</td>
					<td>{insert name='tr' value='Produkty'}</td>
					<td class="td_align_center">{insert name='tr' value='Priradenie produktov'}</td>
					<td class="td_align_center">{insert name='tr' value='Odobranie produktov'}</td>
					<td class="td_align_center">{insert name='tr' value='Viditeľnosť'}</td>
					<td class="td_align_center">{insert name='tr' value='ID'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="section" name="section" value="branch" />
				{include file="divCombo.tpl"}
			{foreach name='branch' from=$branch_list item='branch_id'}


				{assign var=uroven value=$branch_id.uroven}
				{assign var=space value='-'}
				{php}
					$uroven = $GLOBALS['smarty']->get_template_vars(uroven);
					$space = "-";
					$odstup = "";
					for ($f=0;$f<$uroven;$f++){
						$odstup .= $space;
					}
					$GLOBALS["smarty"]->assign("odstup",$odstup);
				{/php}
				<tr>
					<td colspan="{$stlpcov}" class="td_link_space"></td>
				</tr>
				{assign var=showItem value=0}
        		{assign var=showItemEdit value=0}
        		{assign var=showProduct value=0}

				{if ($user_login->checkPrivilege(1050001, $privilege_view) eq 1)}
				{assign var=showItem value=1}
				{else}
				{assign var=showItem value=0}
				{/if}

				{if ($user_login_type eq $admin_user)}
					{assign var=showItem value=1 }
				{/if}

				{if ($user_login->checkPrivilege(1050002, $privilege_view) eq 1)}
				{assign var=showProduct value=1}
				{else}
				{assign var=showProduct value=0}
				{/if}

				{if ($user_login_type eq $admin_user)}
					{assign var=showProduct value=1 }
				{/if}

				{if ($user_login->checkPrivilege(1050001, $privilege_update) eq 1)}
					{assign var=showItemEdit value=1}
				{else}
					{assign var=showItemEdit value=0}
				{/if}

				{if ($user_login_type eq $admin_user)}
					{assign var=showItemEdit value=1}
				{/if}

				{if (($user_login->checkPrivilege(1050001, $privilege_update) eq 1) OR ($user_login->checkPrivilege(1050001, $privilege_delete) eq 1) OR ($user_login->checkPrivilege(1050001, $privilege_add) eq 1))}
					{assign var=showCheckbox value=1}
				{else}
					{assign var=showCheckbox value=0}
				{/if}

				{if ($user_login_type eq $admin_user)}
					{assign var=showCheckbox value=1 }
				{/if}

				<tr id="row{$smarty.foreach.branch.iteration}" onmouseover="pozadieIN('form1','{$smarty.foreach.branch.iteration}')" onmouseout="pozadieOUT('form1','{$smarty.foreach.branch.iteration}')">
					<td class="td_align_center">{$smarty.foreach.branch.iteration+$start}</td>
					<td><input onclick="setRowBgColor('form1',{$smarty.foreach.branch.iteration})" id="box{$smarty.foreach.branch.iteration}" type="checkbox" name="row_id[]" value="{$branch_id.object.id}" /></td>
					<td>{$odstup}
					{if $showItem eq 1}
						<a href="./?module=CMS_Catalog&mcmd=6&row_id[]={$branch_id.object.id}">
							{if $defaultView eq 1}{$defaultViewStartTag}{/if}
								{$branch_id.object.title}
							{if $defaultView eq 1}{$defaultViewEndTag}{/if}
						</a>
					{else}
						{if $defaultView eq 1}{$defaultViewStartTag}{/if}
							{$branch_id.object.title}
						{if $defaultView eq 1}{$defaultViewEndTag}{/if}
					{/if}
					</td>
					{insert name='getNumChild' type='product' id=$branch_id.object.id assign='numProduct'}
					{insert name='getNumChild' type='branch' id=$branch_id.object.id assign='numBranch'}

					<td>
   						{if $numBranch > 0}
							{if $showItemEdit eq 1}
								<a href="./?module=CMS_Catalog&mcmd=27&&row_id[]={$branch_id.object.id}"><img src="../themes/default/images/all_m_restore.png" width="16"/></a>
							{else}
								<img src="../themes/default/images/all_m_restore.png" width="16" />
							{/if}
   						{/if}
   						{if $showProduct eq 1 && $numBranch eq 0}
							{if $showItemEdit eq 1}
								<a href="./?module=CMS_Catalog&mcmd=28&&row_id[]={$branch_id.object.id}"><img src="../themes/default/images/all_m_restore.png" width="16"/></a>
							{else}
								<img src="../themes/default/images/all_m_restore.png" width="16" />
							{/if}
   						{/if}
					</td>

					<td>
						{if $numBranch eq 0}
							{if $showProduct eq 1}
								<a href="./?mcmd=10&module={$module}&s_category={$branch_id.object.id}"><img src="../themes/default/images/product_s.gif" /></a> ({$numProduct})
							{else}
								<img src="../themes/default/images/article_s.gif" /> ({$numProduct})
							{/if}
						{/if}
					</td>
					{if $numBranch eq 0}
					<td class="td_align_center" {if $showItemEdit eq 1}onclick="showDivCombo({$smarty.foreach.branch.iteration})"{/if}>
						<img src="../themes/default/images/filter_s.gif" />
					</td>
					{else}
					<td></td>
					{/if}
					<td class="td_align_center">
						{if $showItemEdit eq 1}
							<a href="./?mcmd=21&module=CMS_Catalog&row_id[]={$branch_id.object.id}"><img src="../themes/default/images/remove_s.gif" /></a>
						{else}
							<img src="../themes/default/images/remove_s.gif" />
						{/if}
					</td>
					<td class="td_align_center">
						{if $branch_id.object.is_published eq 1}
							{assign var=viewLang value=''}
							{foreach name='language' from=$LanguageListLocal item='language_id'}
								{if $language_id.local_visibility eq 1}
									{*$branch_id.object->setContextLanguage($language_id.code)*}
									{if $branch_id.object.language_is_visible eq 0}{assign var=viewLang value='cb'}{/if}
								{/if}
							{/foreach}
							{if $showItemEdit eq 1}
								<a href="#" onclick="listItemTask('form1',1,{$max_list},'f_isPublished',0,'section','branch','box{$smarty.foreach.branch.iteration}')"><img src="../themes/default/images/visible{$viewLang}.gif" /></a>
							{else}
								<img src="../themes/default/images/visible{$viewLang}.gif" />
							{/if}
						{else}
							{if $showItemEdit eq 1}
								<a href="#" onclick="listItemTask('form1',1,{$max_list},'f_isPublished',1,'section','branch','box{$smarty.foreach.branch.iteration}')"><img src="../themes/default/images/hidden.gif" /></a>
							{else}
								<img src="../themes/default/images/hidden.gif" />
							{/if}
						{/if}</td>
					<td class="td_align_center">{$branch_id.object.id}</td>
				</tr>
			{/foreach}
				</form>
			</table>
			{include file="Proxia:default.array_pager" list=$branch_list}
			<br />
		</td>
	</tr>

	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
