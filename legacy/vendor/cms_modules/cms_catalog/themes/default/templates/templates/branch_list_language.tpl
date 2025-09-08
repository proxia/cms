{literal}
<script language="JavaScript" type="text/javascript">
function pozadie (farba,idd){
		idd.style.background = farba;
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
{assign var='title' value='Kategórie / nastavenie viditeľnosti'}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_top_menu">
				<tr>
					<td width="90%">{include file="title_menu.tpl"}</td>
					<td class="td_align_right">
						<img class="img_middle" src="themes/default/images/filter_m_add.png" alt="{insert name='tr' value='filter'}" />
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
				{assign var="stlpcov" value=4}
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td>{insert name='tr' value='Názov kategórie'}</td>
					<td class="td_align_center">{insert name='tr' value='Viditeľnosť kategórie'}</td>
					{foreach name='language' from=$LanguageListLocal item='language_id'}
					<td>{$language_id.code}</td>
					{/foreach}

					<td class="td_align_center">{insert name='tr' value='ID'}</td>

				</tr>
			<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="section" name="section" value="branch_language" />
				<input type="hidden" name="language_visibility" id="language_visibility" value="1" />
				<input type="hidden" id="start" name="start" value="{$start}" />
				<tr class="tr_header">
					<td></td>
					<td></td>
					<td class="td_align_center"><input title="vybrať všetko / zrušiť všetko" id="visibility" type="checkbox" name="selectall" value="1" onclick="selectall_2('form1',1,{$max_list},'visibility')" /></td>
					{foreach name='language' from=$LanguageListLocal item='language_id' }
							<td><input title="vybrať všetko / zrušiť všetko" id="language{$language_id.code}" type="checkbox" name="selectall" value="1" onclick="selectall_2('form1',1,{$max_list},'language{$language_id.code}')" /></td>
					{/foreach}
					<td></td>
				</tr>


			{foreach name='branch' from=$branch_list item='branch_id'}
				<input type="hidden" name="row_id[]" value="{$branch_id.object.id}">

				<tr>
					<td colspan="{$stlpcov}" class="td_link_space"></td>
					{foreach name='language' from=$LanguageListLocal item='language_id' }
					<td class="td_link_space"></td>
					{/foreach}
				</tr>
				{assign var=showItem value=0}
        		{assign var=showItemEdit value=0}

            {if ($user_login->checkPrivilege(1050001, $privilege_view) eq 1)}
               {assign var=showItem value=1}
            {else}
               {assign var=showItem value=0}
            {/if}

            {if ($user_login_type eq $admin_user)}
                {assign var=showItem value=1 }
            {/if}

    		{if ($user_login->checkPrivilege(1050001, $privilege_update) eq 1)}
                {assign var=showItemEdit value=1}
            {else}
                {assign var=showItemEdit value=0}
            {/if}

            {if ($user_login_type eq $admin_user)}
                {assign var=showItemEdit value=1}
            {/if}


				<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
					<td class="td_align_center">{$smarty.foreach.branch.iteration}</td>
					<td>
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
					<td class="td_align_center">
						<input {if $showItemEdit eq 0}disabled="disabled"{/if} id="visibility{$smarty.foreach.branch.iteration}" name="visibility[{$branch_id.object.id}]" type="checkbox" value="1" {if $branch_id.object.is_published eq 1}checked="checked"{/if}>
					</td>
					{foreach name='language' from=$LanguageListLocal item='language_id' }
					{assign var=triedaLang value='class="hrefyeslang"'}
					{*$branch_id.object->setContextLanguage($language_id.code)*}
					{if ($branch_id.object.title eq '')}{assign var=triedaLang value='class="hrefnolang"'}{/if}
						<td><input {if $showItemEdit eq 0} disabled="disabled" {/if} id="language{$language_id.code}{$smarty.foreach.branch.iteration}" type="checkbox" name="a_languageIsVisible{$language_id.code}[{$branch_id.object.id}]" value="1" {if $branch_id.object.language_is_visible eq 1} checked="checked"{/if}></td>
					{/foreach}

					<td class="td_align_center">{$branch_id.object.id}</td>

				</tr>
			{/foreach}
				</form>
			</table>


			<br />
		</td>
	</tr>

	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>