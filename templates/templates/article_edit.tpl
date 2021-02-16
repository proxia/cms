{literal}
<script type="text/javascript" src="js/prototype.js"></script>
<script language="JavaScript" type="text/javascript">
function addelement(act_type,act_value){
	var newelement = document.createElement('INPUT');
	newelement.type = 'hidden';
	newelement.name = act_type;
	newelement.value = act_value;
	document.form1.appendChild(newelement)
}

function submitform(act_type,act_value){
	addelement(act_type,act_value);
	//document.form1.submit();
	//alert (document.form1.f_text.value);

	try {
		document.forms['form1'].onsubmit();
		}
	catch(e){}
		document.forms['form1'].submit();

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


function insertfile(form_name,form_text_name,form_text_title){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name+"&form_text_title="+form_text_title,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
	}

 function checkpriloha(form){
      var p__title = document.forms[form].p__title.value;
	  var p__file = document.forms[form].p__file.value;
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

function checkdelete(msg){
	{/literal}
     var is_confirmed = confirm(msg);
   	 return is_confirmed;
	{literal}
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
	{$article_detail->setContextLanguage($language_id.code)}
		hiddenlang('lang{$language_id.code}');
{/if}
{/foreach}

{literal}

	showlang(id);
}

function checkControl(categoryTree){
  var isOptionDisabled = categoryTree.options[categoryTree.selectedIndex].disabled;
  if(isOptionDisabled){
    categoryTree.selectedIndex = 0;//categoryTree.defaultSelectedIndex;
    return false;
  }
  else categoryTree.defaultSelectedIndex = categoryTree.selectedIndex;
  return true;
}

function showGroups(bool){
	var groups=document.getElementById("groups");
	if(bool == true)
		groups.style.display = "block";
	else
		groups.style.display = "none";
}

function removeOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>0;i--)
	{
		if(selectbox.options[i].selected)
			selectbox.remove(i);
	}
}

function addOption(selectbox,text,value)
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;
	selectbox.options.add(optn);
}

function getRequestBody(form_name)
{
  var oForm = document.forms[form_name];
  if(oForm == undefined)
  	return "";
  var aParams = new Array();

  for (var i=0 ; i < oForm.elements.length; i++)
  {
	var element_id = $(oForm.elements[i]).id;
  	if (((oForm.elements[i].getAttribute("type") == 'checkbox') || (oForm.elements[i].getAttribute("type") == 'radio')) && (oForm.elements[i].checked == false))
  		continue;

  	//alert('start' + i + 'name' + document.getElementById(element_id).name);

  	var sParam = encodeURIComponent(oForm.elements[i].getAttribute('name'));
  	sParam += "=";
//alert(oForm.elements[i].getAttribute("type"));
  	if (oForm.elements[i].getAttribute("type") == 'text')
  		sParam += encodeURIComponent(document.getElementById(oForm.elements[i].id).value);
  	else if(oForm.elements[i].getAttribute("type") == 'textarea')	
		sParam += encodeURIComponent(oForm.elements[i].innerHTML);
  	else if(oForm.elements[i].getAttribute("type") == 'select')
  		{
  		sParam += encodeURIComponent($(element_id).options[$(element_id).selectedIndex].value);
  		}
  	else
  		sParam += encodeURIComponent(oForm.elements[i].getAttribute('value'));

  	aParams.push(sParam);
  	//alert('end' + i);
  }

  return aParams.join("&");
}

// PARAMETRE
// form_name - nazov formu ktory sa ma odoslat
// replace_div - nazov div, ktoremu sa vymeni obsah
// dalej sa udavaju parametre ktore chcem odoslat ako post vzdy vo dvojic nazov - hodnota funkcia arguments

function updateAjax(form_name,replace_div)
{

	sBody = getRequestBody(form_name);
	
	var url = 'action.php';
	if((form_name == 'form_priloha_new') )
	{
		if (checkpriloha(form_name) == false)
			return;
	}

	if(arguments[3] == 'delete')
	{
		{/literal}
			if (!checkdelete('{insert name='tr' value='Naozaj chcete vymazať vybranú položku'} ?'))
				return;
		{literal}
	}

	if(arguments.length > 3)
	{

		var aParams = new Array();

        for (var i=2 ; i < arguments.length; i=i+2)
        {
        	var sParam = encodeURIComponent(arguments[i]);
          	sParam += "=";
          	sParam += encodeURIComponent(arguments[i+1]);
          	aParams.push(sParam);
        }

        var endString = aParams.join("&");

        sBody = sBody + '&' + endString;

	}
	sBody = sBody + '&goAjax=1';

	if(form_name == 'form_priloha_new')
	{
		document.getElementById('p__title').value = '';
		document.getElementById('p__file').value = '';
	}

	{/literal}
		$(replace_div).update('<center><br /><br /><strong>{insert name='tr' value='aktualizujem údaje'}</strong><br /><br /><br /><br /></center>');
	{literal}

	new Ajax.Updater(replace_div,url, {
		parameters: sBody
	});
}


</script>

{/literal}
{insert name=check}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/article_view_edit.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér článkov / Úprava článku'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left">
			{include_php file="../scripts/toolbar.php"}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
		<table width="100%">
			<tr>
				<td class="td_valign_top">
					<table class="tb_list">
						<tr class="tr_header">
							<td>&nbsp;{insert name='tr' value='Detail článku'}</td>
						</tr>
						<form name="form1" id="form1" method="post" action="action.php">
						<input type="hidden" name="section" id="section" value="article" />
						<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
						<input type="hidden" name="row_id[]" id="row_id[]" value="{$article_detail->getId()}" />
						<input type="hidden" name="act" id="act" value="update" />
						<input type="hidden" name="start" id="start" value="{$start}" />
						{$article_detail->setContextLanguage($localLanguage)}
						<tr><td class="td_link_space"></td></tr>
						<tr>
							<td>
								<span class="bold">{insert name='tr' value='Názov článku'}*</span><br />
								<input size="80" type="text" name="f_title" id="f_title" value="{$article_detail->getTitle()}"/><br /><br />
							</td>
						</tr>
						<tr>
							<td>
								<span class="bold">{insert name='tr' value='Popis článku'}</span><br />
								<textarea class="mceArticleDesc"  name="f_description" id="f_description" cols="80" rows="3" style="width:99%">{$article_detail->getDescription()}</textarea>
								<br /><br />
							</td>
						</tr>
						<tr>
							<td >
								<span class="bold">{insert name='tr' value='Text článku'}</span><br />
								{if (($user_login->checkPrivilege(5, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}
									<textarea class="mceArticleText" rows="50" cols="80" style="width:99%" name="f_text" id="f_text">{$article_detail->getText()}</textarea>
								{else}<hr />
									{$article_detail->getText()}
								{/if}
							</td>
						</tr>
					</table>
					<br />
					{foreach name='language' from=$LanguageListLocal item='language_id'}
						{if $language_id.local_visibility}
							{$article_detail->setContextLanguage($language_id.code)}
										<div id="lang{$language_id.code}" style="display:none">
								<div class="ukazkaJazyka">
									<span class="bold">{insert name='tr' value='Jazyk'}:&nbsp;</span>
									<span class="nadpis">{$language_id.code}</span><br /><br />
									<span class="bold">{insert name='tr' value='Názov'}:</span><br />
									{$article_detail->getTitle()}<br /><br />
									<span class="bold">{insert name='tr' value='Popis'}:</span><br />
									{$article_detail->getDescription()}<br /><br />
									<span class="bold">{insert name='tr' value='Text'}:</span><br />
									{$article_detail->getText()}<br />
								</div>
								</div>
								<br />
						{/if}
					{/foreach}
				</td>

				<td class="td_valign_top">

				<table align="center" class="tb_tabs" border=0>
				<tr><td colspan="2"><br /></td></tr>
				<tr class="tr_header_tab">
					<td colspan="2" class="td_tabs_top">
					{$menu}
					</td>
				</tr>
				<tr><td class="td_valign_top" colspan="2">
							<!--INFO-->
							<div id="item1" style="visibility: hidden;">
							<table class="tb_list_in_tab" border="0" >
								<tr class="tr_header">
									<td colspan="2">&nbsp;{insert name='tr' value='Detailné nastavenia'}</td>
								</tr>
								{if (($user_login->checkPrivilege(50002, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}

								<tr>
									<td colspan="2">
									<div style="margin:5px">
									<table class="detail_article_frontpage" border="0">
										<tr>
											<td colspan="2">&nbsp;<b><i>{insert name='tr' value='Úvodná stránka'}</i></b></td>
										</tr>
										<tr>
											<td>&nbsp;{insert name='tr' value='Ukáž na úvodnej stránke'}</td>
											<td width="50%"><input type="checkbox" name="frontpage" id="frontpage" value="1" {if $is_frontpage eq 1}checked="checked"{/if} /></td>
										</tr>
										<tr>
											<td>&nbsp;{insert name='tr' value='Zobraziť celý článok'}</td>
											<td width="50%"><input type="checkbox" name="f_frontpage_show_full_version" id="f_frontpage_show_full_version" value="1" {if $article_detail->getFrontpageShowFullVersion() eq 1}checked="checked"{/if} /></td>
										</tr>
									</table>
									</div>
									</td>
								</tr>

								{/if}
								<tr>
									<td>&nbsp;{insert name='tr' value='Viditeľnosť'}</td>
									<td width="50%"><input type="checkbox" name="f_isPublished" id="f_isPublished" value="1" {if $article_detail->getIsPublished() eq 1}checked="checked"{/if} /></td>
								</tr>
								{if (($user_login->checkPrivilege(50001, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
								<tr>
									<td>&nbsp;{insert name='tr' value='Novinka'}</td>
									<td width="50%"><input type="checkbox" name="f_isNews" id="f_isNews" value="1" {if $article_detail->getIsNews() eq 1}checked="checked"{/if} /></td>
								</tr>
								{/if}
								<!--
								<tr>
									<td>&nbsp;{insert name='tr' value='Flash novinka'}</td>
									<td width="50%"><input type="checkbox" name="f_isFlashNews" id="f_isFlashNews" value="1" {if $article_detail->getIsFlashNews() eq 1}checked="checked"{/if} /></td>
								</tr>
								-->
								<tr>
									<td><div style="margin:4px 0 0 3px;border-top:1px solid silver;">{insert name='tr' value='Vytvorenie'}</div></td>
									<td width="50%"><div style="margin:4px 0 0 3px;border-top:1px solid silver;">{$article_detail->getCreation()}</div></td>
								</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Platnosť'}</td>
									<td width="50%">{insert name=makeCalendar nazov="f_expiration" value=$article_detail->getExpiration()}</td>
								</tr>
																{php}
									$path = "{$GLOBALS['config']['mediadir']}/".$GLOBALS['smarty']->get_template_vars('article_detail')->getImage();
									$name = basename($path);
									$GLOBALS["smarty"]->assign("icon_name",$name);
									$GLOBALS["smarty"]->assign("icon_path",$path);
								{/php}
								<tr>
									<td colspan="2"><div style="margin:4px 0 0 3px;border-top:1px solid silver;">{insert name='tr' value='Ikona'}</div></td>
								</tr>
								<tr>
									<td colspan="2">
									<div style="margin:0 3px 4px 3px;"><input size=40 type="text" name="f_image" id="f_image" value="{$article_detail->getImage()}" />
									&nbsp;<a href="javascript:insertfile('form1','f_image')" title="{insert name='tr' value='vlož obrázok'}"><img src="images/paste.gif" width="21" height="21" border="0"></a>
									{if ($article_detail->getImage() eq '')}
					                	&nbsp;
					                {else}
					                	&nbsp;<a  href="{$icon_path}" target="_blank" title="{insert name='tr' value='ukáž'}"><img src="images/view_s.png" border="0"></a>
					                {/if}
					                </div>
									</td>
								</tr>
								<tr>
									<td valign="top"><div style="margin:4px 0 0 3px;border-top:1px solid silver;">{insert name='tr' value='Zobrazovacie&nbsp;práva'}</div></td>
									<td><div style="margin:4px 0 0 3px;border-top:1px solid silver;">
										<img src="images/access_public_s.gif">&nbsp;<input type='radio' onclick="showGroups(false)" name='f_access' value='{$ACCESS_PUBLIC}' {if $article_detail->getAccess() eq $ACCESS_PUBLIC}checked='checked'{/if}>&nbsp;{insert name='tr' value='Verejné'}<br />
										<img src="images/access_registered_s.gif">&nbsp;<input type='radio' onclick="showGroups(false)" name='f_access' value='{$ACCESS_REGISTERED}' {if $article_detail->getAccess() eq $ACCESS_REGISTERED}checked='checked'{/if}>&nbsp;{insert name='tr' value='Registrovaným'}<br />
										<img src="images/access_special_s.gif">&nbsp;<input type='radio' onclick="showGroups(true)" name='f_access' value='{$ACCESS_SPECIAL}' {if $article_detail->getAccess() eq $ACCESS_SPECIAL}checked='checked'{/if}>&nbsp;{insert name='tr' value='Skupiny používateľov'}<br />
										<!-- PRAVA PRE SKUPINY -->
										{if $article_detail->getAccess() eq $ACCESS_SPECIAL}
											<div id="groups" name="groups" style="margin-left:20px;">
										{else}
											<div id="groups" name="groups" style="margin-left:20px;display:none">
										{/if}

										<select multiple size="5" name="f_access_groups[]">
										{foreach name='group' from=$group_list item=group_detail}
											{insert name="isSelectedGroup" groups=$article_detail->getAccessGroups() current_group_id=$group_detail->getId() assign="selected_group"}
											<option {$selected_group} value="{$group_detail->getId()}">{$group_detail->getTitle()}</option>
										{/foreach}
										</select>
										</div>
										<!-- PRAVA PRE SKUPINY -->
										</div>
									</td>
								</tr>
							</table>
							</form>
							</div>
							<!--MENU-->
							<div id="item2" style="visibility: hidden;">
							{if (($user_login->checkPrivilege(50003, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
							<table class="tb_list_in_tab">
							<form name="form_bind_menu" id="form_bind_menu" method="post" action="action.php">
							<input type="hidden" name="section" id="section" value="article_bindmenu" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="2" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$article_detail->getId()}" />
								<tr class="tr_header">
										<td colspan="2">&nbsp;{insert name='tr' value='Priradenie k menu'}</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
										<select type="select" name="add_menu_id" id="add_menu_id">
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
										<br /><input class="button" onclick="updateAjax('form_bind_menu','zoznam_bindmenu');" type="button" value="{insert name='tr' value='Priraď k menu'}" /><br /><br />
									</td>
								</tr>
							</form>
								<tr class="tr_header">
									<td colspan="2">&nbsp;{insert name='tr' value='Zoznam priradení'}</td>
								</tr>
								<tr>
									<td colspan="2">
										<div id="zoznam_bindmenu">
											{include file="ajax/article_edit_bindmenu.tpl"}
										</div>
									</td>
								</tr>


							</table>
							{/if}
							</div>
							<!--CATEGORY-->
							<div id="item3" style="visibility: hidden;">
							{if (($user_login->checkPrivilege(50004, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
								<table class="tb_list_in_tab">
								<form name="form_bind_category" id="form_bind_category" method="post" action="action.php">
								<input type="hidden" name="section" id="section" value="article_bindcategory" />
								<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
								<input type="hidden" name="row_id[]" id="row_id[]" value="{$article_detail->getId()}" />
								<input type="hidden" id="go" name="go" value="edit" />
								<input type="hidden" id="showtable" name="showtable" value="3" />
								<tr class="tr_header">
										<td colspan="2">&nbsp;{insert name='tr' value='Priradenie ku kategórii'}</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
										<select type="select" name="add_category_id" id="add_category_id">
											<option value="0">{insert name='tr' value='vyberte kategóriu'}</option>
											{insert name='getOptionListMappedCategory' free='totally'}
										</select>
									</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
										<br /><input class="button" value="{insert name='tr' value='Priraď ku kategórii'}" onclick="updateAjax('form_bind_category','zoznam_bindcategory');" type="button" value="{insert name='tr' value='Priraď k menu'}"/><br /><br />
									</td>
								</tr>
								</form>
								<tr class="tr_header">
									<td colspan="2">&nbsp;{insert name='tr' value='Zoznam priradení'}</td>
								</tr>
								<tr>
									<td colspan="2">
										<div id="zoznam_bindcategory">
											{include file="ajax/article_edit_bindcategory.tpl"}
										</div>
									</td>
								</tr>
								</table>
							{/if}
							</div>
							<!--PRILOHY-->
							<div id="item4" style="visibility: hidden;">
								<form method="post" action="action.php" name="form_priloha_new" id="form_priloha_new">
								<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
								<input type="hidden" id="go" name="go" value="edit" />
								<input type="hidden" name="section" id="section" value="article_attachments" />
								<input type="hidden" id="showtable" name="showtable" value="1" />
								<input type="hidden" name="row_id[]" id="row_id[]" value="{$article_detail->getId()}" />
								<input type="hidden" name="goIn" id="goIn" value="insert" />
								<table class="tb_list_in_tab" align="left">
								{if (($user_login->checkPrivilege(5, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}
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
										<td><a href="javascript:insertfile('form_priloha_new','p__file','p__title')" title="{insert name='tr' value='vložiť súbor'}"><img src="images/paste.gif" width="21" height="21" border="0"></a></td>
									</tr>
									<tr>
										<td></td>
										<td><input class="button" type="button" onclick="updateAjax('form_priloha_new','zoznam_priloh');" value="{insert name='tr' value='Prilož prílohu'}" /></td>
										<td></td>
									</tr>
								{/if}
								</form>
								<tr class="tr_header">
									<td colspan="3">&nbsp;{insert name='tr' value='Zoznam príloh'}</td>
								</tr>
								<tr>
									<td colspan="3">
										<div id="zoznam_priloh">
											{include file="ajax/article_edit_zoznam_priloh.tpl"}
										</div>
									</td>
								</tr>
								</table>

							</div>

							<!--LANGUAGE-->

							<div id="item5" style="visibility: hidden;">
								<div id="language_list">
									{include file="ajax/article_edit_language_versions.tpl"}
								</div>

							</div>

							<!--ACTIVITY EDITORS-->

							<div id="item8" style="display: none;">
							<table class="tb_list_in_tab"  >
								<tr class="tr_header">
									<td >&nbsp;{insert name='tr' value='Aktivity editorov'}</td>
								</tr>

								<tr>
									<td ><div style="color:darkred;margin:5px">{insert name='tr' value='Článok vytvoril'}&nbsp;::&nbsp;{$article_author->getFirstname()} {$article_author->getFamilyname()} {$article_detail->getCreation()|date_format:"%d.%m.%Y %H:%M:%S"}</div></td>
								</tr>
								<tr>
									<td ><div style="font-weight: bold;margin-top:5px;margin-bottom:5px;margin-left:5px;">{insert name='tr' value='Článok aktualizoval'}</div></td>
								</tr>
								<tr>
									<td ><div style="margin-left:5px;margin-bottom:5px;">{$activity_editors}</div></td>
								</tr>
							</table>
							</div>

							<!--PHOTOGALERY-->

							<div id="item6" style="visibility: hidden;">
							<table class="tb_list_in_tab">
							<form name="form_bind_gallery" id="form_bind_gallery" method="post" action="action.php">
							<input type="hidden" name="section" id="section" value="article_bindgallery" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$article_detail->getId()}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="5" />
								<tr class="tr_header">
										<td colspan="2">&nbsp;{insert name='tr' value='Priradenie fotogalérie'}</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
										<select type="select" name="map_gallery" id="map_gallery">
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
									{if (($user_login->checkPrivilege(5, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}
										<br /><input class="button" onclick="updateAjax('form_bind_gallery','zoznam_bindgallery');" type="button" value="{insert name='tr' value='Priraď ku článku'}" /><br /><br />
									{/if}
									</td>
								</tr>
							</form>
								<tr class="tr_header">
									<td colspan="2">&nbsp;{insert name='tr' value='Zoznam priradení'}</td>
								</tr>
								<tr>
									<td colspan="2">
										<div id="zoznam_bindgallery">
											{include file="ajax/article_edit_bindgallery.tpl"}
										</div>
									</td>
								</tr>
							</table>
							</div>

							<!--PODUJATIA-->

							<div id="item7" style="visibility: hidden;">
							<table class="tb_list_in_tab" >
							<form name="form_bind_event" id="form_bind_event" method="post" action="action.php">
							<input type="hidden" name="section" id="section" value="article_bindevent" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$article_detail->getId()}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="6" />
								<tr class="tr_header">
										<td colspan="2">&nbsp;{insert name='tr' value='Priradenie podujatia'}</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
										<select type="select" id="map_event" name="map_event">
											<option value="0">{insert name='tr' value='vyberte si podujatie'}</option>
											{foreach name='event_list' from=$event_list item='event_id'}
												{$event_id->setContextLanguage($localLanguage)}
												{assign var=defaultView value=0}
												{if ($event_id->getTitle() eq '')}
													{$event_id->setContextLanguage($localLanguageDefault)}
													{assign var=defaultView value=1}
												{/if}
												<option value="{$event_id->getId()}">{if $defaultView eq 1}{$defaultViewStartTag}{/if}{$event_id->getTitle()}{if $defaultView eq 1}{$defaultViewEndTag}{/if}</option>
											{/foreach}
										</select>
									</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
									{if (($user_login->checkPrivilege(5, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}
										<br /><input class="button" onclick="updateAjax('form_bind_event','zoznam_bindevent');" type="button" value="{insert name='tr' value='Priraď ku článku'}" /><br /><br />
									{/if}
									</td>
								</tr>
							</form>
								<tr class="tr_header">
									<td colspan="2">&nbsp;{insert name='tr' value='Zoznam priradení'}</td>
								</tr>
								<tr>
									<td colspan="2">
										<div id="zoznam_bindevent">
											{include file="ajax/article_edit_bindevent.tpl"}
										</div>
									</td>
								</tr>

							</table>
							</div>

							<!--SEO DATA-->
							<div id="item9" style="visibility: hidden;">{$article_detail->getSeoTitle()}
								<form method="post" action="action.php" name="form_seo" id="form_seo">
								<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
								<input type="hidden" id="go" name="go" value="edit" />
								<input type="hidden" name="section" id="section" value="article_seo" />
								<input type="hidden" id="showtable" name="showtable" value="1" />
								<input type="hidden" name="row_id[]" id="row_id[]" value="{$article_detail->getId()}" />
								<input type="hidden" name="goIn" id="goIn" value="edit" />
								<table class="tb_list_in_tab" align="left">
								{if (($user_login->checkPrivilege(5, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}
									<tr class="tr_header">
										<td colspan="2">&nbsp;{insert name='tr' value='SEO podpora'}</td>
									</tr>
									<tr>
										<td>&nbsp;{insert name='tr' value='Title v URL'}</td>
										<td ><input type="text" name="seo__title" id="seo__title" size="20" value="{$article_seo_title}"/></td>
									</tr>
									<tr>
										<td>&nbsp;{insert name='tr' value='Description v META'}</td>
										<td>
											<input type="text" name="seo__description" id="seo__description" value="{$article_seo_description}" size="20" />
										</td>
									</tr>
									<tr>
										<td></td>
										<td><input class="button" type="button" onclick="updateAjax('form_seo','seo_message');" value="{insert name='tr' value='Uložiť'}" /></td>
				
									</tr>
									<tr>
										<td colspan="2" id="seo_message"></td>

									</tr>
									
								{/if}
								</form>

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
