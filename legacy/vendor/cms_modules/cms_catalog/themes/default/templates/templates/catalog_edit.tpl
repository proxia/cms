{literal}
<script language="JavaScript" type="text/javascript">

function hiddenlang(id){
	
	var style=document.getElementById(id).style;
	style.display = "none";
	
}

function showlang(id){
	
	var style=document.getElementById(id).style;
	style.display = "block";
	
}

function ukazlang(id){

{/literal}
{foreach name='language' from=$LanguageListLocal item='language_id'}
{if $language_id.local_visibility}
	{$detail_catalog->setContextLanguage($language_id.code)}
		hiddenlang('lang{$language_id.code}');
{/if}
{/foreach}
					
{literal}

	showlang(id);
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

   // zoznam objektov ktore treba kontrolovat
	// E - kontrola na email
	// V - kontrola na retazec
	// N - kontrola na cislo
	// U - kontrola na url
	// H - kontrola na rovnost hesla musia byt dve polia z H alebo ziadne
	// "nazov pola" "min dlzka" "max dlzka" "typ kontroly"
	var pole=new Array(
			"f_title","0","100","V"
		);
</script>
{/literal}
{insert name=check}
{assign var='title' value='Katalóg / detail'}
<table class="tb_middle">
	<tr>
		<td colspan="3">{include file="title_menu.tpl"}</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left">
		{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
		{include_php file=$path_toolbar}
		</td>
	<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table width="100%" border=0>
				<tr>
					<td class="td_valign_top" width="70%">
						<table class="tb_list">
							<tr class="tr_header">
								<td colspan="2">&nbsp;{insert name='tr' value='Detail katalógu'}</td>
							</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="{$detail_catalog->getId()}" />
				<input type="hidden" id="section" name="section" value="catalog" />
				{$detail_catalog->setContextLanguage("$localLanguage")}
				<tr><td colspan="2" class="td_link_space"></td></tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Názov'}*</td>
					<td width="85%"><input size="60" type="text" name="f_title" id="f_title" value="{$detail_catalog->getTitle()}" /></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Popis'}</td>
					<td width="85%"><textarea name="f_description" id="f_description" rows="5" cols="58">{$detail_catalog->getDescription()}</textarea></td>
				</tr>
			</table>
			
					{foreach name='language' from=$LanguageListLocal item='language_id'}
						{if $language_id.local_visibility}
							{$detail_catalog->setContextLanguage($language_id.code)}
								<div id="lang{$language_id.code}" style="display:none">
									<div class="ukazkaJazyka">
										<span class="bold">{insert name='tr' value='Jazyk'}:&nbsp;</span>
										<span class="nadpis">{$language_id.code}</span><br /><br />
										<span class="bold">{insert name='tr' value='Názov'}:</span><br />
										{$detail_catalog->getTitle()}<br /><br />
										<span class="bold">{insert name='tr' value='Popis'}:</span><br />
										{$detail_catalog->getDescription()}<br />
									</div>
								</div>
								<br />
						{/if}
					{/foreach}
					</td>
					<td class="td_valign_top">
					
								<table align="center" class="tb_tabs">
								<tr class="tr_header_tab">
					<td colspan="2" class="td_tabs_top">
					{$menu}
					</td>
				</tr>
				<tr><td class="td_valign_top" colspan="2">
							<div id="item1" style="visibility: hidden;">
							<table class="tb_list_in_tab" border=0>
								<tr class="tr_header">
									<td colspan="4">&nbsp;{insert name='tr' value='Detailné nastavenia'}</td>
								</tr>
								<tr>
									<td width="30%">&nbsp;{insert name='tr' value='Viditeľnosť'}</td>
									<td ><input type="checkbox" name="f_isPublished" id="f_isPublished" value="1" {if $detail_catalog->getIsPublished() eq 1}checked="checked"{/if} /></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;{insert name='tr' value='Zobrazovacie&nbsp;práva'}</td>
									<td>
										<select name="f_access" id="f_access">
											<option value="{$ACCESS_PUBLIC}" {if $detail_catalog->getAccess() eq $ACCESS_PUBLIC}selected="selected"{/if} >{insert name='tr' value='Verejné'}</option>
											<option value="{$ACCESS_REGISTERED}" {if $detail_catalog->getAccess() eq $ACCESS_REGISTERED}selected="selected"{/if} >{insert name='tr' value='Registrovaným'}</option>
											<option value="{$ACCESS_SPECIAL}" {if $detail_catalog->getAccess() eq $ACCESS_SPECIAL}selected="selected"{/if} >{insert name='tr' value='Skupiny používateľov'}</option>
										</select>
									</td>
								</tr>


							</table>
							</form>
							</div>
							<div id="item2" style="visibility: hidden;">
							
							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" name="lang">
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="section" id="section" value="catalog" />
							<input type="hidden" id="showtable" name="showtable" value="1" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_catalog->getId()}" />
							<input type="hidden" name="language_visibility" id="language_visibility" value="1" />
							<table class="tb_list_in_tab" align="center">
								<tr class="tr_header">
									<td colspan="3">&nbsp;{insert name='tr' value='Jazykové verzie'}</td>
								</tr>
								<tr>
									<td>{insert name='tr' value='Názov'}</td>
									<td>{insert name='tr' value='Viditeľnosť'}</td>
									<td>{insert name='tr' value='Náhľad'}</td>
								</tr>
								{foreach name='language' from=$LanguageListLocal item='language_id' }
								{$detail_catalog->setContextLanguage($language_id.code)}
								<tr>
									<td>&nbsp;{$language_id.code}</td>
									<td><input type="checkbox" name="a_languageIsVisible{$language_id.code}" id="f_languageIsVisible{$language_id.code}" value="1" {if $detail_catalog->getLanguageIsVisible() eq 1}checked="checked"{/if} /></td>
									<td><a title="{insert name='tr' value='ukáž'}" href="javascript:ukazlang('lang{$language_id.code}')"><img src="../themes/default/images/view_s.png" /></td>
								</tr>
								{/foreach}
								<tr>
									<td></td>
									<td class="td_center" colspan="2"><br />
			{assign var=showItemEdit value=0}

    		{if ($user_login->checkPrivilege(105, $privilege_update) eq 1)}
                {assign var=showItemEdit value=1}
            {else}
                {assign var=showItemEdit value=0}
            {/if}
           
            {if ($user_login_type eq $admin_user)}
                {assign var=showItemEdit value=1}
            {/if}
            {if $showItemEdit eq 1}
										<input class="button" type="submit" value="{insert name='tr' value='Zmeniť nastavenie'}" />
			{/if}
									</td>
								</tr>
								
							</table>
								</form>
								
							</div>	
							<div id="item3" style="visibility: hidden;">
							
							<table class="tb_list_in_tab">
							<form name="form2" id="form2" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="catalog" />
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_catalog->getId()}" />
							<input type="hidden" id="showtable" name="showtable" value="2" />
								<tr class="tr_header">
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
										<select name="add_menu_id">
											<option value="0">{insert name='tr' value='vyberte menu'}</option>
											{foreach name='menu' from=$menu_list item='menu_id'}
											
											{$menu_id->setContextLanguage($localLanguage)}
											{assign var=defaultView value=0}
											{if ($menu_id->getTitle() eq '')}
												{$menu_id->setContextLanguage($localLanguageDefault)}
												{assign var=defaultView value=1}
											{/if}
											<option value="{$menu_id->getId()}">
											{if $defaultView eq 1}{$defaultViewStartTag}{/if}
												{$menu_id->getTitle()}
											{if $defaultView eq 1}{$defaultViewEndTag}{/if}
											</option>
											{/foreach}
										</select>
									</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
									{if $showItemEdit eq 1}
										<br /><input class="button" type="submit" value="{insert name='tr' value='Priraď k menu'}" /><br /><br />
									{/if}
									</td>
								</tr>
							</form>
								<tr class="tr_header">
									<td colspan="2">&nbsp;{insert name='tr' value='Zoznam priradení'}</td>
								</tr>
								
								{foreach name='menu_list' from=$menu_list_items item='menu_item_id'}
								
								{$menu_item_id->setContextLanguage($localLanguage)}
									{assign var=defaultView value=0}
									{if ($menu_item_id->getTitle() eq '')}
										{$menu_item_id->setContextLanguage($localLanguageDefault)}
										{assign var=defaultView value=1}
									{/if}
							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" onsubmit="return checkdelete('{insert name='tr' value='Naozaj chcete vymazať väzbu fotogalérie s menu '}{$menu_item_id->getTitle()} ?')">
							<input type="hidden" name="section" id="section" value="catalog" />
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="2" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_catalog->getId()}" />
							<input type="hidden" id="remove_menu_id" name="remove_menu_id" value="{$menu_item_id->getId()}" />
								<tr>
									<td>&nbsp;&nbsp;{if $defaultView eq 1}{$defaultViewStartTag}{/if}
										{$menu_item_id->getTitle()}
									{if $defaultView eq 1}{$defaultViewEndTag}{/if}</td>
									<td>
									{if $showItemEdit eq 1}
									<input class="noborder" type="image" src="../themes/default/images/form_delete.gif" title="{insert name='tr' value='zmazať'}">
									{/if}
									</td>
								</tr>
							</form>
								{/foreach}
							</table>
							
							</div>
							<div id="item4" style="visibility: hidden;">
							
							<table class="tb_list_in_tab">
							<form name="form3" id="form3" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="catalog" />
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_catalog->getId()}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="3" />
								<tr class="tr_header">
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>{insert name='getParentCategoryCat' id=$detail_catalog->getId() assign="ParentCategoryId"}
									<td  class="td_align_center">
										<select name="add_category_id" onchange="return checkControl(this)">
											<option value="0">{insert name='tr' value='vyberte kategóriu'}</option>
											{insert name='getOptionListMappedCategory' free='totally' select=$ParentCategoryId zakaz=$detail_catalog->getId()}	
										</select>
									</td>
								</tr>
								<tr>
									<td class="td_align_center">
									{if $showItemEdit eq 1}
										<br /><input class="button" type="submit" value="{insert name='tr' value='Priraď ku kategórii'}" /><br /><br />
									{/if}
									</td>
								</tr>
							</form>
							<tr class="tr_header">
									<td colspan="2">&nbsp;{insert name='tr' value='Zoznam priradení'}</td>
								</tr>
								{foreach name='category_list' from=$category_list_items item='category_item_id'}
									{assign var=objekt value=$category_item_id}
									{$category_item_id->setContextLanguage($localLanguage)}
									{assign var=defaultView value=0}
									{if ($category_item_id->getTitle() eq '')}
										{$category_item_id->setContextLanguage($localLanguageDefault)}
										{assign var=defaultView value=1}
									{/if}
							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" onsubmit="return checkdelete('{insert name='tr' value='Naozaj chcete vymazať väzbu fotogalérie s kategórie '}{$category_item_id->getTitle()} ?')">
							<input type="hidden" name="section" id="section" value="catalog" />
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="3" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_catalog->getId()}" />
							<input type="hidden" id="remove_category_id" name="remove_category_id" value="{$category_item_id->getId()}" />
								<tr>
									<td>&nbsp;&nbsp;{if $defaultView eq 1}{$defaultViewStartTag}{/if}
										{$category_item_id->getTitle()}
									{if $defaultView eq 1}{$defaultViewEndTag}{/if}</td>
									<td>
									{if $showItemEdit eq 1}
									<input class="noborder" type="image" src="../themes/default/images/form_delete.gif" title="{insert name='tr' value='zmazať'}">
									{/if}
									</td>
								</tr>
							</form>
								{/foreach}
							</table>
							
							</div>	
							
							</td></tr>
						</table>
						
					</td>
				</tr>
			</table>

			
			<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>