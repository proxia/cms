{literal}
<script language="JavaScript" type="text/javascript">

function listItemTask(the_form,min,max,act_type,act_value,act_type2,act_value2){
	submitform2(the_form,act_type,act_value,act_type2,act_value2)
}

function addelement2(the_form,act_type,act_value){
	var newelement = document.createElement('INPUT');
	newelement.type = 'hidden';
	newelement.name = act_type;
	newelement.value = act_value;
	document.forms[the_form].appendChild(newelement)
}

function submitform2(the_form,act_type,act_value,act_type2,act_value2){
	addelement2(the_form,act_type,act_value);
	addelement2(the_form,act_type2,act_value2);
	try {
		document.forms[the_form].onsubmit();
		}
	catch(e){}
		document.forms[the_form].submit();
}

function sureDelete(msg){
     var is_confirmed = confirm(msg);
   	 return is_confirmed;
}
function checkdelete(form,msg,msg2){
		isChecked = false;
		for(i=0;i<form.remove_attribut_id.length;i++){
			if(form.remove_attribut_id[i].checked){
				isChecked = true;
			}
		}
		if(isChecked){
     var is_confirmed = confirm(msg);
   	 return is_confirmed;
		}

		alert(msg2)
		return false;
  }


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
	{$category_detail->setContextLanguage($language_id.code)}
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


 function checkpriloha(form){
      var p__title = form.p__title.value;
	  var p__file = form.p__file.value;
      if(p__title==""){
	  	{/literal}
        alert("{insert name='tr' value='Nezadali ste povinnú položku'} !");
		{literal}
		form.p__title.focus();
        return false;
        }

	   if(p__file==""){
	   {/literal}
        alert("{insert name='tr' value='Nezadali ste povinnú položku'} !");
		{literal}
		form.p__file.focus();
        return false;
        }


  }

function insertfile(form_name,form_text_name,form_text_title){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name+"&form_text_title="+form_text_title,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
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
{assign var='title' value='Kategória / detail'}
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
								<td colspan="2">&nbsp;{insert name='tr' value='Detail kategórie'}</td>
							</tr>
							<form name="form1" id="form1" method="post" action="../modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="branch" />
							<input type="hidden" name="status" id="status" value="update" />
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$category_detail->getId()}" />
							{$category_detail->setContextLanguage($localLanguage)}
							<tr><td colspan="2" class="td_link_space"></td></tr>
							<tr>
								<td nowrap="nowrap">&nbsp;{insert name='tr' value='Názov kategórie'}*&nbsp;</td>
								<td width="85%"><input size="70" maxlength="255" type="text" name="f_title" id="f_title" value="{$category_detail->getTitle()}" /></td>
							</tr>
							<tr>
								<td class="td_valign_top">&nbsp;{insert name='tr' value='Popis kategórie'}&nbsp;</td>
								<td ><textarea style="width:100%" cols="70" rows="10" name="f_description" id="f_description">{$category_detail->getDescription()}</textarea></td>
							</tr>
						</table>

						{foreach name='language' from=$LanguageListLocal item='language_id'}
							{if $language_id.local_visibility}
								{$category_detail->setContextLanguage($language_id.code)}
									<div id="lang{$language_id.code}" style="display:none">
										<div class="ukazkaJazyka">
											<span class="bold">{insert name='tr' value='Jazyk'}:&nbsp;</span>
											<span class="nadpis">{$language_id.code}</span><br /><br />
											<span class="bold">{insert name='tr' value='Názov'}:</span><br />
											{$category_detail->getTitle()}<br /><br />
											<span class="bold">{insert name='tr' value='Popis'}:</span><br />
											{$category_detail->getDescription()}<br />
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
							{$menu2}
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
									<td ><input type="checkbox" name="f_isPublished" id="f_isPublished" value="1" {if $category_detail->getIsPublished() eq 1}checked="checked"{/if} /></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;{insert name='tr' value='Zobrazovacie&nbsp;práva'}</td>
									<td>
										<select name="f_access" id="f_access">
											<option value="{$ACCESS_PUBLIC}" {if $category_detail->getAccess() eq $ACCESS_PUBLIC}selected="selected"{/if} >{insert name='tr' value='Verejné'}</option>
											<option value="{$ACCESS_REGISTERED}" {if $category_detail->getAccess() eq $ACCESS_REGISTERED}selected="selected"{/if} >{insert name='tr' value='Registrovaným'}</option>
											<option value="{$ACCESS_SPECIAL}" {if $category_detail->getAccess() eq $ACCESS_SPECIAL}selected="selected"{/if} >{insert name='tr' value='Skupiny používateľov'}</option>
										</select>
									</td>
								</tr>
								{php}
									$path = "..{$GLOBALS['project_folder']}/".$_SESSION['user']['name']."/mediafiles/".$GLOBALS['smarty']->get_template_vars(category_detail)->getImage();
									$name = basename($path);
									$GLOBALS["smarty"]->assign("icon_name",$name);
									$GLOBALS["smarty"]->assign("icon_path",$path);
								{/php}
								<tr>
									<td>&nbsp;{insert name='tr' value='Ikona'}</td>
									<td width="30%"><input size="35" type="text" name="f_image" id="f_image" value="{$category_detail->getImage()}" /></td>
									<td width="22"><a href="javascript:insertfile('form1','f_image')" title="{insert name='tr' value='vlož obrázok'}"><img src="themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
									{if $category_detail->getImage() eq ''}
										<td width="22">&nbsp;</td>
									{else}
										<td width="22">&nbsp;<a  href="{$icon_path}" target="_blank" title="{insert name='tr' value='ukáž'}"><img src="themes/default/images/view_s.png" border="0"></a></td>
									{/if}


								</tr>

							</table>
							</form>
							</div>

							<div id="item2" style="visibility: hidden;">

							<table class="tb_list_in_tab">
							<form name="form3" id="form3" method="post" action="../modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="branch" />
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$category_detail->getId()}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="1" />
								<tr class="tr_header">
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>{insert name='getParentCategoryBranch' id=$category_detail->getId() assign="ParentCategoryId"}
									<td  class="td_align_center">
										<select name="map_to_branch">
											<option value="-1">{insert name='tr' value='katalóg'} {$catalog_title}</option>
											{insert name='getOptionListBranch' catalog='$catalog_id' select=$ParentCategoryId zakaz=$category_detail->getId()}
										</select>
									</td>
								</tr>
								<tr>
									<td class="td_align_center">
										<br />
										{assign var=showItemEdit value=0}

										{if ($user_login->checkPrivilege(1050001, $privilege_update) eq 1)}
											{assign var=showItemEdit value=1}
										{else}
											{assign var=showItemEdit value=0}
										{/if}

										{if ($user_login_type eq $admin_user)}
											{assign var=showItemEdit value=1}
										{/if}
 									{if $showItemEdit eq 1}
										<input class="button" type="submit" value="{insert name='tr' value='Priraď'}" /><br /><br />
									{/if}
									</td>
								</tr>
							</form>
							</table>

							</div>

							<div id="item3" style="visibility: hidden;">

							<form method="post" action="../modules/cms_catalog/action.php" name="lang">
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="section" id="section" value="branch" />
							<input type="hidden" id="showtable" name="showtable" value="3" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$category_detail->getId()}" />
							<input type="hidden" name="language_visibility" id="language_visibility" value="1" />
							<table class="tb_list_in_tab" >
								<tr class="tr_header">
									<td colspan="3">&nbsp;{insert name='tr' value='Jazykové verzie'}</td>
								</tr>
								<tr>
									<td>{insert name='tr' value='Názov'}</td>
									<td>{insert name='tr' value='Viditeľnosť'}</td>
									<td>{insert name='tr' value='Náhľad'}</td>
								</tr>
								{foreach name='language' from=$LanguageListLocal item='language_id' }
								{$category_detail->setContextLanguage($language_id.code)}
								<tr>
									<td>&nbsp;{$language_id.code}</td>
									<td><input type="checkbox" name="a_languageIsVisible{$language_id.code}" id="f_languageIsVisible{$language_id.code}" value="1" {if $category_detail->getLanguageIsVisible() eq 1}checked="checked"{/if} /></td>
									<td><a title="{insert name='tr' value='ukáž'}" href="javascript:ukazlang('lang{$language_id.code}')"><img src="themes/default/images/view_s.png" /></td>
								</tr>
								{/foreach}
								<tr>
									<td></td>
									<td class="td_center" colspan="2"><br />
										{if $showItemEdit eq 1}
											<input class="button" type="submit" value="{insert name='tr' value='Zmeniť nastavenie'}" />
										{/if}
									</td>
								</tr>

							</table>
								</form>

							</div>

							<div id="item4" style="visibility: hidden;">
							<table class="tb_list_in_tab">
							<form name="form4" id="form4" method="post" action="../modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="branch" />
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$category_detail->getId()}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="2" />

								<tr class="tr_header">
										<td colspan="2">&nbsp;{insert name='tr' value='Priradenie fotogalérie'}</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
										<select name="map_gallery">
											<option value="0">{insert name='tr' value='vyberte si fotogalériu'}</option>
											{foreach name='gallery_list' from=$gallery_list item='gallery_id'}
												{$gallery_id->setContextLanguage($localLanguage)}
												{assign var=defaultView value=0}
												{if ($gallery_id->getTitle() eq '')}
													{$gallery_id->setContextLanguage($localLanguageDefault)}
													{assign var=defaultView value=1}
												{/if}
												<option value="{$gallery_id->getId()}">{if $defaultView eq 1}{$defaultViewStartTag}{/if}{$gallery_id->getTitle()}{if $defaultView eq 1}{$defaultViewEndTag}{/if}</option>
											{/foreach}
										</select>
									</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
									{if $showItemEdit eq 1}
										<br /><input class="button" type="submit" value="{insert name='tr' value='Priraď ku galérii'}" /><br /><br />
									{/if}
									</td>
								</tr>
							</form>
								<tr class="tr_header">
									<td colspan="2">&nbsp;{insert name='tr' value='Zoznam priradení'}</td>
								</tr>
								{foreach name='gallery_list' from=$gallery_branch_list item='gallery_id'}
									{$gallery_id->setContextLanguage($localLanguage)}
									{assign var=defaultView value=0}
									{if ($gallery_id->getTitle() eq '')}
										{$gallery_id->setContextLanguage($localLanguageDefault)}
										{assign var=defaultView value=1}
									{/if}
									<form method="post" action="../modules/cms_catalog/action.php" onsubmit="return checkdelete('{insert name='tr' value='Naozaj chcete vymazať väzbu produktu s galérie '} ?')">
									<input type="hidden" name="section" id="section" value="branch" />
									<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
									<input type="hidden" id="go" name="go" value="edit" />
									<input type="hidden" name="row_id[]" id="row_id[]" value="{$category_detail->getId()}" />
									<input type="hidden" id="unmap_to_branch" name="unmap_gallery" value="{$gallery_id->getId()}" />
									<input type="hidden" id="showtable" name="showtable" value="2" />
										<tr>
											<td width="150">&nbsp;&nbsp;
											{if $defaultView eq 1}{$defaultViewStartTag}{/if}
												{$gallery_id->getTitle()}
											{if $defaultView eq 1}{$defaultViewEndTag}{/if}
											</td>
											<td width="200">
											{if $showItemEdit eq 1}
											<input class="noborder" type="image" src="themes/default/images/form_delete.gif" title="{insert name='tr' value='zmazať'}">
											{/if}
											</td>
										</tr>
									</form>
								{/foreach}
							</table>
							</div>



							<div id="item5" style="visibility: hidden;">
							<table class="tb_list_in_tab">
							<form name="form5" id="form5" method="post" action="../modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="branch" />
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="4" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$category_detail->getId()}" />
								<tr class="tr_header">
										<td colspan="6">&nbsp;{insert name='tr' value='Priradenie atribútu'}</td>
								</tr>
								<tr><td colspan="6"><br><br></td></tr>
								<tr>
									<td>&nbsp;&nbsp;
										<select name="add_attribut_id">
											<option value="0">{insert name='tr' value='vyberte atribút'}</option>
											{foreach name='attribut' from=$attribut_list item='attribut_id' }
												{$attribut_id->setContextLanguage($localLanguage)}
												{assign var=defaultView value=0}
												{if ($attribut_id->getTitle() eq '')}
													{$attribut_id->setContextLanguage($localLanguageDefault)}
													{assign var=defaultView value=1}
												{/if}
												{insert name='getExistsAttribut' branchId=$category_detail->getId() attributId=$attribut_id->getId() assign='is_existsAttribut'}
												{if (!$is_existsAttribut)}
													<option value="{$attribut_id->getId()}">
													{if $defaultView eq 1}{$defaultViewStartTag}{/if}
														{$attribut_id->getTitle()}
													{if $defaultView eq 1}{$defaultViewEndTag}{/if}
													</option>
												{/if}
											{/foreach}
										</select>

									</td>
									<td>
									{assign var=showItemEdit value=0}

			    				{if ($user_login->checkPrivilege(1050001, $privilege_update) eq 1)}
			                {assign var=showItemEdit value=1}
			            {else}
			                {assign var=showItemEdit value=0}
			            {/if}

			            {if ($user_login_type eq $admin_user)}
			                {assign var=showItemEdit value=1}
			            {/if}
			            {if $showItemEdit eq 1}
											<input class="button" type="submit" value="{insert name='tr' value='Priraď ku kategórii'}" />
									{/if}
									</td>
								</tr>

								<tr><td colspan="6"><br><br></td></tr>
							</form>
							<tr>
								<td colspan="6">
								<table>
								<tr class="tr_header">
									<td colspan="4">&nbsp;{insert name='tr' value='Zoznam atribútov'}</td>
									<td  class="td_align_center">{insert name='tr' value='Zmazať'}</td>

								</tr>
							<form method="post" id="attribut" name="attribut" action="../modules/cms_catalog/action.php" onsubmit="return checkdelete(this,'{insert name='tr' value='Naozaj chcete vymazať attribúty? '} ?','{insert name='tr' value='Žiadan položka nie je vybratá!'}')">
							<input type="hidden" name="section" id="section" value="branch" />
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$category_detail->getId()}" />
							<input type="hidden" id="showtable" name="showtable" value="4" />
							<input type="hidden" id="update_attribut" name="update_attribut" value="1" />
								{foreach name='attribut_branch' from=$attribut_branch_list item='attribut_branch_id'}
								{/foreach}
								{assign var='max_list' value=$smarty.foreach.attribut_branch.iteration}

								{foreach name='attribut_branch' from=$attribut_branch_list item='attribut_branch_id'}

								{assign var='attribut_name' value=$attribut_branch_id->getAttributeDefinitionId()}
								<tr>
									<td class="bold">&nbsp;&nbsp;{$attribut_branch_list_title.$attribut_name}</td>
									<td colspan="2"></td>
									<td></td>
									<td class="td_align_center"><input type="checkbox" name="remove_attribut_id[]" id="remove_attribut_id" value="{$attribut_branch_id->getId()}"></td>

								</tr>

								<tr><td colspan="6"><hr></td></tr>

								{/foreach}

								<tr><td colspan="6"  class="td_align_center"><br>
								{if $showItemEdit eq 1}
								<input type="submit"  class="button" name="attach_update" value="{insert name='tr' value='Označené položky vymazať'}">
								{/if}
								<br><br></td></tr>
							</form>
							</table>
							</td>
							</tr>
							</table>
							</div>

								<!--PRILOHY-->
								<div id="item6" style="visibility: hidden;">
									<form method="post" action="../modules/cms_catalog/action.php" name="form_priloha" onSubmit="return checkpriloha(this)">
									<input type="hidden" name="section" id="section" value="branch_attachment" />
									<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
									<input type="hidden" id="go" name="go" value="edit" />
								  <input type="hidden" name="branch_id" id="branch_id" value="{$category_detail->getId()}" />
									<input type="hidden" id="showtable" name="showtable" value="5" />
									<input type="hidden" id="add_attachment" name="add_attachment" value="1" />

									<table class="tb_list_in_tab" align="left">

										<tr class="tr_header">
											<td colspan="3">&nbsp;{insert name='tr' value='Prílohy'}</td>
										</tr>
										<tr>
											<td>&nbsp;{insert name='tr' value='Názov'}</td>
											<td colspan="2"><input type="text" name="p__title" id="p__title" size="30" /></td>
										</tr>
										<tr>
											<td>&nbsp;{insert name='tr' value='Príloha'}</td>
											<td>
												<input type="text" name="p__file" id="p__file" size="40" />
											</td>
											<td><a href="javascript:insertfile('form_priloha','p__file','p__title')" title="{insert name='tr' value='vlož prílohu'}"><img src="themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
										</tr>
										{if $showItemEdit eq 1}
											<tr>
												<td></td>
												<td><input class="button" type="submit" value="{insert name='tr' value='Prilož prílohu'}" /></td>
												<td></td>
											</tr>
										{/if}
										</form>
										<tr class="tr_header">
											<td colspan="3">&nbsp;{insert name='tr' value='Zoznam príloh'}</td>
										</tr>
										<tr>
											<td colspan="3">
												<table width="100%">
												<form method="post" action="../modules/cms_catalog/action.php">
													<input type="hidden" name="section" id="section" value="branch_attachment" />
													<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
													<input type="hidden" id="go" name="go" value="edit" />
													<input type="hidden" name="branch_id" id="branch_id" value="{$category_detail->getId()}" />
													<input type="hidden" id="showtable" name="showtable" value="5" />
													<input type="hidden" id="rename_attachment" name="update_attachment" value="1" />
													<tr>
														<td class="bold">{insert name='tr' value='Ukáž'}</td>
														<td class="bold">{insert name='tr' value='Názov'}</td>
														<td class="td_align_center"><b>{insert name='tr' value='Zmaž'}</b></td>
													</tr>
													<tr><td colspan="3"><hr></td></tr>
												{assign var=isExistAttach value=0}
												{foreach name='attach_list' from=$category_detail->getAttachments() item='attach_item_id'}
													{assign var=isExistAttach value=1}
													{$attach_item_id->setContextLanguage($localLanguage)}
													{assign var=defaultView value=0}

														{$attach_item_id->setContextLanguage($localLanguageDefault)}
														{assign var=defaultView value=1}
														{assign var=attachTitleDefault  value=$attach_item_id->getTitle()}

													{$attach_item_id->setContextLanguage($localLanguage)}
													{php}
														$path = "..{$GLOBALS['project_folder']}/".$_SESSION['user']['name']."/mediafiles/".$GLOBALS['smarty']->get_template_vars(attach_item_id)->getFile();
														$name = basename($path);
														$size = stat($path);
														$GLOBALS["smarty"]->assign("attach_item_id_size",round($size['size']/1024,2));
														$GLOBALS["smarty"]->assign("attach_item_id_name",$name);
														$GLOBALS["smarty"]->assign("attach_item_id_path",$path);
													{/php}

													<tr>
															<td valign="top"><input type="checkbox" name="language_visibility{$attach_item_id->getId()}" value="1" {if $attach_item_id->getLanguageIsVisible() eq 1}checked="checked"{/if}></td>
															<td valign="top">
																{if $defaultView eq 1}{$defaultViewStartTag}{/if}
																	{$attachTitleDefault}
																{if $defaultView eq 1}{$defaultViewEndTag}{/if}
																<br />
																<input name="p__title{$attach_item_id->getId()}" id="p__title{$attach_item_id->getId()}" type="text" size="40" value="{$attach_item_id->getTitle()}">
																<br />
																<a href="{$attach_item_id_path}" target="_blank">{$attach_item_id_name}</a>
																<br />
																{$attach_item_id_size} kB
															</td>
															<td valign="top" class="td_align_center">{if $showItemEdit eq 1}<input onclick="return sureDelete('{insert name='tr' value='Naozaj chcete vymazať prílohu '}{$attach_item_id_name} ?')" class="noborder" type="image" name="attach_delete{$attach_item_id->getId()}" value="1" src="themes/default/images/form_delete.gif" title="{insert name='tr' value='zmazať'}">{/if}</td>
													 </tr>
													 <tr><td colspan="3"><hr></td></tr>
													{/foreach}
													{if $isExistAttach eq 1 && $showItemEdit eq 1}
													<tr><td></td><td colspan="2"><input  class="button" type="submit" name="attach_update" value="{insert name='tr' value='Zapíš zmeny'}"></td></tr>
													{/if}
													</form>
												</table>
											</td>
									</tr>

									</table>
										</form>
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
