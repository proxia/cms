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

function addelement(act_type,act_value)
{
	var newelement = document.createElement('INPUT');
	newelement.type = 'hidden';
	newelement.name = act_type;
	newelement.value = act_value;
	document.form1.appendChild(newelement)
}

function insertfile(form_name,form_text_name,form_text_title)
{
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name+"&form_text_title="+form_text_title,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
}

function submitform(act_type,act_value)
{
	addelement(act_type,act_value);

	try {
		document.form1.onsubmit();
		}
	catch(e){}
		document.form1.submit();
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
{foreach name='language' from=$LanguageList item='language_id'}
{if $language_id.local_visibility}
	{$detail_product->setContextLanguage($language_id.code)}
		hiddenlang('lang{$language_id.code}');
{/if}
{/foreach}

{literal}

	showlang(id);
}


   // zoznam objektov ktore treba kontrolovat
	// E - kontrola na email
	// V - kontrola na retazec
	// N - kontrola na cislo
	// U - kontrola na url
	// H - kontrola na rovnost hesla musia byt dve polia z H alebo ziadne
	// "nazov pola" "min dlzka" "max dlzka" "typ kontroly"
	var pole=new Array(
			"f_code","0","100","V",
			"f_title","0","100","V"
		);



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

function showGroups(bool,objekt){
	var groups=document.getElementById(objekt);
	if(bool == true)
		groups.style.display = "block";
	else
		groups.style.display = "none";
}

function checkdelete(msg){
     var is_confirmed = confirm(msg);
   	 return is_confirmed;
  }

function checkdeleteAttribute(objekt,msg){

     var is_confirmed = confirm(msg);
     if(is_confirmed)
     {
		try
		{
		document.forms[objekt].onsubmit();
		}
		catch(e)
		{
		document.forms[objekt].submit();
		}

	 }
  }

</script>
{/literal}
{insert name=check}
{assign var='title' value='Produkt / detail'}
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
		<td class="td_link_h"><img src="../themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
		<table width="100%">
			<tr>
				<td class="td_valign_top">

			<table class="tb_list">

				<tr class="tr_header">
					<td colspan="2">&nbsp;{insert name='tr' value='Detail produktu'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="{$detail_product->getId()}" />
				<input type="hidden" id="section" name="section" value="product" />
				<input type="hidden" id="only_detail" name="only_detail" value="true" />
				<input type="hidden" id="showtable" name="showtable" value="0" />
				<input type="hidden" name="act" id="act" value="update" />
				{$detail_product->setContextLanguage("$localLanguage")}
				<tr><td colspan="2" class="td_link_space"></td></tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Kód'}*</td>
					<td width="85%"><input size="30" type="text" name="f_code" id="f_code" value="{$detail_product->getCode()}" /></td>
				</tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Názov'}*</td>
					<td width="85%"><input size="60" type="text" name="f_title" id="f_title" value="{$detail_product->getTitle()}" /></td>
				</tr>
				<tr>
					<td class="td_valign_top">&nbsp;{insert name='tr' value='Popis'}</td>
					<td width="85%"><textarea style="width:100%" name="f_description" id="f_description" rows="15" cols="60">{$detail_product->getDescription()}</textarea></td>
				</tr>
				<tr>
					<td class="td_valign_top">&nbsp;{insert name='tr' value='Popis 2'}</td>
					<td width="85%"><textarea style="width:100%" name="f_descriptionExtended" id="f_descriptionExtended" rows="20" cols="60">{$detail_product->getDescriptionExtended()}</textarea></td>
				</tr>
			</table>
					{foreach name='language' from=$LanguageListLocal item='language_id'}
						{if $language_id.local_visibility}
							{$detail_product->setContextLanguage($language_id.code)}
										<div id="lang{$language_id.code}" style="display:none">
								<div class="ukazkaJazyka">
									<span class="bold">{insert name='tr' value='Jazyk'}:&nbsp;</span>
									<span class="nadpis">{$language_id.code}</span><br /><br />
									<span class="bold">{insert name='tr' value='Názov'}:</span><br />
									{$detail_product->getTitle()}<br /><br />
									<span class="bold">{insert name='tr' value='Popis'}:</span><br />
									{$detail_product->getDescription()}<br /><br />
									<span class="bold">{insert name='tr' value='Popis 2'}:</span><br />
									{$detail_product->getDescriptionExtended()}<br />
								</div>
								</div>
								<br />
						{/if}
					{/foreach}

			</td>
			<td class="td_valign_top" width="500">

				<table align="center" class="tb_tabs">
				<tr><td colspan="2"><br /></td></tr>
				<tr class="tr_header_tab">
					<td colspan="2" class="td_tabs_top">
					{$menu}
					</td>
				</tr>
				<tr><td class="td_valign_top" colspan="2">

							<div id="item1" style="visibility: hidden;">
							<table class="tb_list_in_tab">
								<tr class="tr_header">
									<td colspan="4">&nbsp;{insert name='tr' value='Detailné nastavenia'}</td>
								</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Viditeľnosť'}</td>
									<td width="50%" colspan="3"><input type="checkbox" name="f_isPublished" id="f_isPublished" value="1" {if $detail_product->getIsPublished() eq 1}checked="checked"{/if} /></td>
								</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Platnosť od'}</td>
									<td width="50%" colspan="3">{insert name=makeCalendar nazov="f_valid_from" value=$detail_product->getValidFrom()}</td>
								</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Platnosť do'}</td>
									<td width="50%" colspan="3">{insert name=makeCalendar nazov="f_valid_to" value=$detail_product->getValidTo()}</td>
								</tr>
								<tr>
									<td valign="top">&nbsp;{insert name='tr' value='Zobrazovacie&nbsp;práva'}</td>
									<td colspan="3">
										<select name="f_access" id="f_access">
											<option value="{$ACCESS_PUBLIC}" {if $detail_product->getAccess() eq $ACCESS_PUBLIC}selected="selected"{/if} >{insert name='tr' value='Verejné'}</option>
											<option value="{$ACCESS_REGISTERED}" {if $detail_product->getAccess() eq $ACCESS_REGISTERED}selected="selected"{/if} >{insert name='tr' value='Registrovaným'}</option>
											<option value="{$ACCESS_SPECIAL}" {if $detail_product->getAccess() eq $ACCESS_SPECIAL}selected="selected"{/if} >{insert name='tr' value='Skupiny používateľov'}</option>
										</select>
									</td>
								</tr>
								{php}
									$path = "../mediafiles/".$GLOBALS['smarty']->get_template_vars(detail_product)->getImage();
									$name = basename($path);
									$GLOBALS["smarty"]->assign("icon_name",$name);
									$GLOBALS["smarty"]->assign("icon_path",$path);
								{/php}
								<tr>
									<td>&nbsp;{insert name='tr' value='Obrázok'}</td>
									<td width="30%"><input size=35 type="text" name="f_image" id="f_image" value="{$detail_product->getImage()}" /></td>
                 					<td width=22><a href="javascript:insertfile('form1','f_image')" title="{insert name='tr' value='vlož obrázok'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
									{if ($detail_product->getImage() eq '')}
                     					<td width=22>&nbsp;</td>
                  					{else}
                      					<td width=22>&nbsp;<a  href="{$icon_path}" target="_blank" title="{insert name='tr' value='ukáž'}"><img src="../themes/default/images/view_s.png" border="0"></a></td>
                  					{/if}
                  				</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Video'} (flv,mov,wmv)</td>
									<td width="30%"><input size=35 type="text" name="f_video" id="f_video" value="{$detail_product->getVideo()}" /></td>
                 					<td width=22><a href="javascript:insertfile('form1','f_video')" title="{insert name='tr' value='prilep cestu k video'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
                  				</tr>
							</table>
							</form>
							</div>

							<div id="item2" style="visibility: hidden;">
							<table class="tb_list_in_tab">
							<form name="form2" id="form2" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="1" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_product->getId()}" />
								<tr class="tr_header">
										<td colspan="6">&nbsp;{insert name='tr' value='Priradenie k atribútu'}</td>
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
												{insert name='getExistsAttribut' productId=$detail_product->getId() attributId=$attribut_id->getId() assign='is_existsAttribut'}
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
									<td><input type="text" name="add_attribut_value" id="add_attribut_value" size="30" maxlength="255"></td>
									<td></td>
									<td class="td_align_center"></td>
									<td></td>
								</tr>
								<tr>
									<td>&nbsp;&nbsp;{insert name='tr' value='obrázok hodnoty'} ({insert name='tr' value='nepoviné'})</td>
									<td>
										<input size="30" type="text" name="add_attribut_value_image" id="add_attribut_value_image" />
									</td>
									<td><a href="javascript:insertfile('form2','add_attribut_value_image')" title="{insert name='tr' value='vlož obrázok'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td>
									{assign var=showItemEdit value=0}

									{if ($user_login->checkPrivilege(1050002, $privilege_update) eq 1)}
										{assign var=showItemEdit value=1}
									{else}
										{assign var=showItemEdit value=0}
									{/if}

									{if ($user_login_type eq $admin_user)}
										{assign var=showItemEdit value=1}
									{/if}
									{if $showItemEdit eq 1}
										<input class="button" type="submit" value="{insert name='tr' value='Priraď k produktu'}" />
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
									<td class="td_align_center">{insert name='tr' value='Poradie'}</td>
								</tr>
							<form method="post" id="attribut" name="attribut" action="/vendor/cms_modules/cms_catalog/action.php" >
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_product->getId()}" />
							<input type="hidden" id="showtable" name="showtable" value="1" />
							<input type="hidden" id="update_attribut" name="update_attribut" value="1" />
								{foreach name='attribut_product' from=$attribut_product_list item='attribut_product_id'}
								{/foreach}
								{assign var='max_list' value=$smarty.foreach.attribut_product.iteration}

								{foreach name='attribut_product' from=$attribut_product_list item='attribut_product_id'}

								{$attribut_product_id->setContextLanguage($localLanguage)}

								{if strlen($attribut_product_id->getValue()) == 0}
									{$attribut_product_id->setContextLanguage($localLanguageDefault)}
								{/if}

								{assign var='attribut_name' value=$attribut_product_id->getAttributeDefinitionId()}
								<tr>
									<td class="bold">&nbsp;&nbsp;{$attribut_product_list_title.$attribut_name}</td>
									<td colspan="2"><input type="text" name="update_attribut_value[{$attribut_product_id->getId()}]" id="add_attribut_value" size="30" maxlength="255" value="{$attribut_product_id->getValue()}"></td>
									<td></td>
									<td class="td_align_center"><input type="checkbox" name="remove_attribut_id[]" id="remove_attribut_id" value="{$attribut_product_id->getId()}"></td>
									<td class="td_align_center">
				   						{if $smarty.foreach.attribut_product.iteration neq $max_list}
				   							{if $showItemEdit eq 1}
				       							<a href="#" onclick="listItemTask('attribut',1,{$max_list},'move_down_attribut',{$attribut_product_id->getId()},'section','product')"><img alt="{insert name='tr' value='posuň smerom dole'}" src="../themes/default/images/downarrow.png" /></a>
				   							{else}
				   								<img alt="{insert name='tr' value='posuň smerom dole'}" src="../themes/default/images/downarrow.png" />
				   							{/if}
				   						{/if}
				   						{if ($smarty.foreach.attribut_product.iteration neq $max_list) and ($smarty.foreach.attribut_product.iteration neq 1)}&nbsp;&nbsp;&nbsp;&nbsp;{/if}
				   						{if $smarty.foreach.attribut_product.iteration neq 1}
				   							{if $showItemEdit eq 1}
				   								<a href="#" onclick="listItemTask('attribut',1,{$max_list},'move_up_attribut',{$attribut_product_id->getId()},'section','product')"><img alt="{insert name='tr' value='posuň smerom hore'}" src="../themes/default/images/uparrow.png" /></a>
				   							{else}
				   								<img alt="{insert name='tr' value='posuň smerom hore'}" src="../themes/default/images/uparrow.png" />
				   							{/if}
				   						{/if}
				   					</td>
								</tr>
								{php}
									$path = "../mediafiles/".$GLOBALS['smarty']->get_template_vars(attribut_product_id)->getImage();
									$name = basename($path);
									$GLOBALS["smarty"]->assign("icon_name",$name);
									$GLOBALS["smarty"]->assign("icon_path",$path);
								{/php}
								<tr>
									<td>&nbsp;&nbsp;{insert name='tr' value='obrázok hodnoty'}</td>
									<td>
										<input size="30" type="text" name="update_attribut_value_image[{$attribut_product_id->getId()}]" id="attribut_image{$attribut_product_id->getId()}" value="{$attribut_product_id->getImage()}" />

									</td>
									<td><a href="javascript:insertfile('attribut','attribut_image{$attribut_product_id->getId()}')" title="{insert name='tr' value='vlož obrázok'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
									{if ($attribut_product_id->getImage() eq '')}
           					<td width=22>&nbsp;</td>
        					{else}
            					<td width=22>&nbsp;<a  href="{$icon_path}" target="_blank" title="{insert name='tr' value='ukáž'}"><img src="../themes/default/images/view_s.png" border="0"></a></td>
        					{/if}
									<td></td>
									<td></td>
								</tr>
								<tr><td colspan="6"><hr></td></tr>

								{/foreach}

								<tr><td colspan="6"  class="td_align_center"><br>
								{if $showItemEdit eq 1}
								<input type="button" class="button" onclick="checkdeleteAttribute('attribut','{insert name='tr' value='Zapísať zmeny '} ?')" name="attach_update" value="{insert name='tr' value='Zapíš zmeny v atribútoch'}">
								{/if}
								<br><br></td></tr>
							</form>
							</table>
							</td>
							</tr>
							</table>
							</div>
							<div id="item3" style="visibility: hidden;">
							<table class="tb_list_in_tab">
							<form name="form3" id="form3" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_product->getId()}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="2" />
								<tr class="tr_header">
										<td colspan="2">&nbsp;{insert name='tr' value='Priradenie ku kategórii'}</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
										<select name="map_to_branch">
											<option value="0">{insert name='tr' value='vyberte si kategóriu'}</option>
											{insert name='getOptionListBranch' catalog='$catalog_id' select=0}
										</select>
									</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
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
									{$category_item_id->setContextLanguage($localLanguage)}
									{assign var=defaultView value=0}
									{if ($category_item_id->getTitle() eq '')}
										{$category_item_id->setContextLanguage($localLanguageDefault)}
										{assign var=defaultView value=1}
									{/if}
							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" onsubmit="return checkdelete('{insert name='tr' value='Naozaj chcete vymazať väzbu produktu s kategóriou '}{$category_item_id->getTitle()} ?')">
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_product->getId()}" />
							<input type="hidden" id="unmap_to_branch" name="unmap_to_branch" value="{$category_item_id->getId()}" />
							<input type="hidden" id="showtable" name="showtable" value="2" />
								<tr>
									<td width="150">&nbsp;&nbsp;
									{if $defaultView eq 1}{$defaultViewStartTag}{/if}
										{$category_item_id->getTitle()}
									{if $defaultView eq 1}{$defaultViewEndTag}{/if}
									</td>
									<td width="200">
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

							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" name="lang">
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" id="showtable" name="showtable" value="3" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_product->getId()}" />
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
								{$detail_product->setContextLanguage($language_id.code)}
								<tr>
									<td>&nbsp;{$language_id.code}</td>
									<td><input type="checkbox" name="a_languageIsVisible{$language_id.code}" id="f_languageIsVisible{$language_id.code}" value="1" {if $detail_product->getLanguageIsVisible() eq 1}checked="checked"{/if} /></td>
									<td><a title="{insert name='tr' value='ukáž'}" href="javascript:ukazlang('lang{$language_id.code}')"><img src="../themes/default/images/view_s.png" /></td>
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

							<div id="item5" style="visibility: hidden;">
							<table class="tb_list_in_tab">
							<form name="form3" id="form3" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_product->getId()}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="4" />
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
								{foreach name='gallery_list' from=$gallery_list_product item='gallery_id'}
									{$gallery_id->setContextLanguage($localLanguage)}
									{assign var=defaultView value=0}
									{if ($gallery_id->getTitle() eq '')}
										{$gallery_id->setContextLanguage($localLanguageDefault)}
										{assign var=defaultView value=1}
									{/if}
							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" onsubmit="return checkdelete('{insert name='tr' value='Naozaj chcete vymazať väzbu produktu s galérie '} ?')">
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_product->getId()}" />
							<input type="hidden" id="unmap_to_branch" name="unmap_gallery" value="{$gallery_id->getId()}" />
							<input type="hidden" id="showtable" name="showtable" value="4" />
								<tr>
									<td width="150">&nbsp;&nbsp;
									{if $defaultView eq 1}{$defaultViewStartTag}{/if}
										{$gallery_id->getTitle()}
									{if $defaultView eq 1}{$defaultViewEndTag}{/if}
									</td>
									<td width="200">
									{if $showItemEdit eq 1}
									<input class="noborder" type="image" src="../themes/default/images/form_delete.gif" title="{insert name='tr' value='zmazať'}">
									{/if}
									</td>
								</tr>
							</form>
								{/foreach}
							</table>
							</div>

							<div id="item6" style="visibility: hidden;">

							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" name="lang">
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" name="section" id="section" value="product_price" />
							<input type="hidden" id="showtable" name="showtable" value="5" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="product_id" id="product_id" value="{$detail_product->getId()}" />

							{insert name="getAvailableCurrencies" assign=currencies}

							{if ($user_login->checkPrivilege(1050002, $privilege_update) eq 1)}
	                {assign var=showItemEdit value=1}
	            {else}
	                {assign var=showItemEdit value=0}
	            {/if}
	            {if ($user_login_type eq $admin_user)}
	                {assign var=showItemEdit value=1}
	            {/if}
							<table class="tb_list_in_tab">
								<tr class="tr_header">
									<td colspan="4">&nbsp;{insert name='tr' value='Nová cena'}</td>
								</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Viditeľnosť ceny'}</td>
									<td width="50%" colspan="3"><input type="checkbox" name="priceIsPublished" id="priceIsPublished" value="1" checked /></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;{insert name='tr' value='Cena'}</td>
									<td colspan="3">
										<input type="text" name="new_price" id="new_price" size="10" value="">
										<select name="price_currency">
										{foreach from=$currencies item='currency' }
											<option>{$currency}</option>
										{/foreach}
										</select>
									</td>
								</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Platnosť od'}</td>
									<td width="50%" colspan="3">{insert name=makeCalendar nazov="price_valid_from" value=$detail_product->getValidFrom()}</td>
								</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Platnosť do'}</td>
									<td width="50%" colspan="3">{insert name=makeCalendar nazov="price_valid_to" value=$detail_product->getValidTo()}</td>
								</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Poznámka k cene'}</td>
									<td width="50%" colspan="3"><input type="text" name="price_note" id="price_note" size="35" value=""></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;{insert name='tr' value='Zobrazovacie&nbsp;práva'}</td>
									<td>
										<img src="../themes/default/images/access_public_s.gif">&nbsp;<input type='radio' onclick="showGroups(false,'price_groups')" name='price_access' value='{$ACCESS_PUBLIC}' checked>&nbsp;{insert name='tr' value='Verejné'}<br />
										<img src="../themes/default/images/access_registered_s.gif">&nbsp;<input type='radio' onclick="showGroups(false,'price_groups')" name='price_access' value='{$ACCESS_REGISTERED}' >&nbsp;{insert name='tr' value='Registrovaným'}<br />
										<img src="../themes/default/images/access_special_s.gif">&nbsp;<input type='radio' onclick="showGroups(true,'price_groups')" name='price_access' value='{$ACCESS_SPECIAL}' >&nbsp;{insert name='tr' value='Skupiny používateľov'}<br />
										<!-- PRAVA PRE SKUPINY -->
										<div id="price_groups" name="price_groups" style="margin-left:20px;display:none">

										<select multiple size="5" name="price_access_groups[]">
										{foreach name='group' from=$group_list item=group_detail}
											{$group_detail->setContextLanguage($localLanguage)}
											<option  value="{$group_detail->getId()}">{$group_detail->getTitle()}</option>
										{/foreach}
										</select>
										</div>
										<!-- PRAVA PRE SKUPINY -->
									</td>
								</tr>
								<tr>
									<td></td>
									<td class="td_center" colspan="2"><br />
									{if $showItemEdit eq 1}
										<input class="button" type="submit" value="{insert name='tr' value='Vytvoriť novú cenu'}" />
									{/if}
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>

								<table class="tb_list_in_tab" border=0>
								<tr class="tr_header">
									<td colspan="3">&nbsp;{insert name='tr' value='Aktuálne ceny pre produkt'}</td>
								</tr>
								</form>
								<tr class="tr_header">
									<td  class="td_align_center">{insert name='tr' value='Viditeľnosť'}</td>
									<td>&nbsp;{insert name='tr' value='Zoznam cien'}</td>
									<td  class="td_align_center">{insert name='tr' value='Zmazať'}</td>
								</tr>
								<form method="post" id="price" name="price" action="/vendor/cms_modules/cms_catalog/action.php" >
								<input type="hidden" name="section" id="section" value="product_price" />
								<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
								<input type="hidden" id="go" name="go" value="edit" />
							  	<input type="hidden" name="product_id" id="product_id" value="{$detail_product->getId()}" />
								<input type="hidden" id="showtable" name="showtable" value="5" />
								<input type="hidden" id="update_price" name="update_price" value="1" />

								{foreach name='price_list' from=$price_list item='price_id'}
								{php}
									$time_valid_to = $GLOBALS['smarty']->get_template_vars(price_id)->getValidTo();
									$time_valid_from = $GLOBALS['smarty']->get_template_vars(price_id)->getValidFrom();
									$now = time();
									if($time_valid_to){
										$year = substr($time_valid_to, 0,4);
										$month = substr($time_valid_to, 5, 2);
										$day = substr($time_valid_to, 8, 2);
										$hours = substr($time_valid_to, 11, 2);
										$minutes = substr($time_valid_to, 14, 2);
										$seconds = substr($time_valid_to, 17, 2);
										$time_to = mktime($hours, $minutes, $seconds, $month, $day, $year);
									}else{
										$time_to = $now+(24 * 60 * 60);	//pridam jeden den
									}
									if($time_valid_from){
										$year = substr($time_valid_from, 0,4);
										$month = substr($time_valid_from, 5, 2);
										$day = substr($time_valid_from, 8, 2);
										$hours = substr($time_valid_from, 11, 2);
										$minutes = substr($time_valid_from, 14, 2);
										$seconds = substr($time_valid_from, 17, 2);
										$time_from = mktime($hours, $minutes, $seconds, $month, $day, $year);
									}else{
										$time_from = $now-(24 * 60 * 60);	//dam spat jeden den
									}
									if($time_from < $now && $time_to > $now)
											$GLOBALS["smarty"]->assign("color_to","color:blue");
									else
											$GLOBALS["smarty"]->assign("color_to","color:red");
								{/php}

								<tr>

									<td class="td_align_center"><input type="checkbox" name="publish_price_id[]" id="publish_price_id" value="{$price_id->getId()}" {if $price_id->getIsPublished() eq 1}checked="checked"{/if}></td>
									<td ><input type="text" name="update_price_value[{$price_id->getId()}]" id="add_price_value" size="10" maxlength="15" value="{$price_id->getPrice()}"> {$price_id->getCurrency()}</td>
									<td class="td_align_center"><input type="checkbox" name="remove_price_id[]" id="remove_price_id" value="{$price_id->getId()}"></td>
								</tr>
								<tr>
									<td colspan=3>&nbsp;{insert name='tr' value='Platnosť od'}:
									<span style="{$color_to}">
									{if $price_id->getValidFrom()}
										<i>{$price_id->getValidFrom()|date_format:"%d.%m.%Y %H:%M:%S"}</i>
									{else}
										-
									{/if}
									</span>
									<br>
									&nbsp;{insert name='tr' value='Platnosť do'}:
									<span style="{$color_to}">
									{if $price_id->getValidTo()}
										<i>{$price_id->getValidTo()|date_format:"%d.%m.%Y %H:%M:%S"}</i>
									{else}
										-
									{/if}
									</span>
									</td>
								</tr>
								<tr  >
									<td colspan=3>&nbsp;{insert name='tr' value='Poznámka'}:
										<span style="{$color_to}">
										<input type="text" name="price_note[{$price_id->getId()}]" id="price_note" size="35" maxlength="100" value="{$price_id->getNote()}">
										</span>
									</td>
								</tr>
								<tr >
									<td colspan=3>&nbsp;{insert name='tr' value='Zobrazovacie&nbsp;práva'}:
									<br>&nbsp;
									<span style="{$color_to}">
									<i>
									{if $price_id->getAccess() eq 1}
										<img src="../themes/default/images/access_public_s.gif" align="absmiddle">{insert name='tr' value='Verejné'}
									{elseif $price_id->getAccess() eq 2}
											<img src="../themes/default/images/access_registered_s.gif" align="absmiddle">	{insert name='tr' value='Registrovaným'}
									{elseif $price_id->getAccess() eq 3}
										<img src="../themes/default/images/access_special_s.gif" align="absmiddle">{insert name='tr' value='Skupiny používateľov'}
										{insert name="getSelectedGroup" groups=$price_id->getAccessGroups() assign="selected_group"}
										: {$selected_group}
									{/if}

									</i>
									</span>
									</td>
								</tr>
								<tr><td colspan="3"><hr></td></tr>

								{/foreach}

								<tr><td colspan="3"  class="td_align_center"><br>
								{if $showItemEdit eq 1}
									<input type="submit" class="button" name="attach_update" value="{insert name='tr' value='Aktualizovať ceny'}">
								{/if}
								<br><br></td></tr>
								</form>
								</table>

							</div>

								<!--PRILOHY-->
								<div id="item7" style="visibility: hidden;">
									<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" name="form_priloha" onSubmit="return checkpriloha('form_priloha')">
									<input type="hidden" name="section" id="section" value="product_attachment" />
									<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
									<input type="hidden" id="go" name="go" value="edit" />
								  <input type="hidden" name="product_id" id="product_id" value="{$detail_product->getId()}" />
									<input type="hidden" id="showtable" name="showtable" value="6" />
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
											<td><a href="javascript:insertfile('form_priloha','p__file','p__title')" title="{insert name='tr' value='vlož obrázok'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
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
												<form method="post" action="/vendor/cms_modules/cms_catalog/action.php">
													<input type="hidden" name="section" id="section" value="product_attachment" />
													<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
													<input type="hidden" id="go" name="go" value="edit" />
													<input type="hidden" name="product_id" id="product_id" value="{$detail_product->getId()}" />
													<input type="hidden" id="showtable" name="showtable" value="6" />
													<input type="hidden" id="rename_attachment" name="update_attachment" value="1" />
													<tr>
														<td class="bold">{insert name='tr' value='Ukáž'}</td>
														<td class="bold">{insert name='tr' value='Názov'}</td>
														<td class="td_align_center"><b>{insert name='tr' value='Zmaž'}</b></td>
													</tr>
													<tr><td colspan="3"><hr></td></tr>
												{assign var=isExistAttach value=0}
												{foreach name='attach_list' from=$detail_product->getAttachments() item='attach_item_id'}
													{assign var=isExistAttach value=1}
													{$attach_item_id->setContextLanguage($localLanguage)}
													{assign var=defaultView value=0}

														{$attach_item_id->setContextLanguage($localLanguageDefault)}
														{assign var=defaultView value=1}
														{assign var=attachTitleDefault  value=$attach_item_id->getTitle()}

													{$attach_item_id->setContextLanguage($localLanguage)}
													{php}
														$path = "../mediafiles/".$GLOBALS['smarty']->get_template_vars(attach_item_id)->getFile();
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
															<td valign="top" class="td_align_center">{if $showItemEdit eq 1}<input onclick="return checkdelete('{insert name='tr' value='Naozaj chcete vymazať prílohu '}{$attach_item_id_name} ?')" class="noborder" type="image" name="attach_delete{$attach_item_id->getId()}" value="1" src="../themes/default/images/form_delete.gif" title="{insert name='tr' value='zmazať'}">{/if}</td>
													 </tr>
													 <tr><td colspan="3"><hr></td></tr>
													{/foreach}
													{if $isExistAttach eq 1 && $showItemEdit eq 1}
													<tr><td></td><td colspan="2"><input class="button" type="submit" name="attach_update" value="{insert name='tr' value='Zapíš zmeny'}"></td></tr>
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



		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
