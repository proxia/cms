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
	try {
		document.form1.onsubmit();
		}
	catch(e){}
		document.form1.submit();
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
			submitform(act_type,act_value)
		}
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

function insertfile(form_name,form_text_name){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
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
{foreach name='language' from=$LanguageListLocal item='language_id'}
{if $language_id.local_visibility}
	{$weblink_detail->setContextLanguage($language_id.code)}
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

  	if (oForm.elements[i].getAttribute("type") == 'text')
  		sParam += encodeURIComponent(document.getElementById(oForm.elements[i].id).value);
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
					<td><img class="img_middle" src="images/weblink_view_edit.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér odkazov / Úprava odkazu'}</td>
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
			<table>
				<tr>
					<td class="td_valign_top" width="70%">
						<table class="tb_list">
							<tr class="tr_header">
								<td colspan="2">&nbsp;{insert name='tr' value='Detail odkazu'}</td>
							</tr>
							<form name="form1" id="form1" method="post" action="action.php">
							<input type="hidden" name="section" id="section" value="weblink" />
							<input type="hidden" name="s_category" id="s_category" value="{$s_category}" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" name="act" id="act" value="update" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$weblink_detail->getId()}" />
							{$weblink_detail->setContextLanguage($localLanguage)}
							<tr><td colspan="2" class="td_link_space"></td></tr>
							<tr>
								<td nowrap="nowrap">&nbsp;{insert name='tr' value='Názov odkazu'}*&nbsp;</td>
								<td width="85%"><input size="60" type="text" name="f_title" id="f_title" value="{$weblink_detail->getTitle()}" /></td>
							</tr>
							<tr>
								<td>&nbsp;{insert name='tr' value='URL'}</td>
								<td width="85%"><input size="60" type="text" name="f_url" id="f_url" value="{$weblink_detail->getUrl()}" /></td>
							</tr>
							<tr>
								<td>&nbsp;{insert name='tr' value='Cieľ'}</td>
								<td width="85%">
									<select name="f_target" id="f_target">
										<option value="">{insert name='tr' value='None (use implicit)'}</option>
										<option value="_blank" {if $weblink_detail->getTarget() eq '_blank'}selected="selected"{/if}>{insert name='tr' value='New window (_blank)'}</option>
										<option value="_self" {if $weblink_detail->getTarget() eq '_self'}selected="selected"{/if}>{insert name='tr' value='Same frame (_self)'}</option>
										<option value="_top" {if $weblink_detail->getTarget() eq '_top'}selected="selected"{/if}>{insert name='tr' value='Top frame (_top)'}</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td_valign_top">&nbsp;{insert name='tr' value='Popis odkazu'}&nbsp;</td>
								<td width="90%"><textarea cols="80" rows="6" name="f_description" id="f_description">{$weblink_detail->getDescription()}</textarea></td>
							</tr>
						</table>


					<br />
					{foreach name='language' from=$LanguageListLocal item='language_id'}
						{if $language_id.local_visibility}
							{$weblink_detail->setContextLanguage($language_id.code)}
								<div id="lang{$language_id.code}" style="display:none">
									<div class="ukazkaJazyka">
										<span class="bold">{insert name='tr' value='Jazyk'}:&nbsp;</span>
										<span class="nadpis">{$language_id.code}</span><br /><br />
										<span class="bold">{insert name='tr' value='Názov'}:</span><br />
										{$weblink_detail->getTitle()}<br />
									</div>
								</div>
								<br />
						{/if}
					{/foreach}


					</td>
					<td class="td_valign_top">
				<table align="center" class="tb_tabs">
				<tr><td colspan="2"><br /></td></tr>
				<tr class="tr_header_tab">
					<td colspan="2" class="td_tabs_top">
					{$menu}
					</td>
				</tr>
				<tr><td class="td_valign_top" colspan="2">

							<div id="blok1" style="visibility: hidden;">
							<table class="tb_list_in_tab">
								<tr class="tr_header">
									<td colspan="4">&nbsp;{insert name='tr' value='Detailné nastavenia'}</td>
								</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Viditeľnosť'}</td>
									<td width="50%"><input type="checkbox" name="f_isPublished" id="f_isPublished" value="1" {if $weblink_detail->getIsPublished() eq 1}checked="checked"{/if} /></td>
								</tr>
								{php}
									$path = "{$GLOBALS['config']['mediadir']}/".$GLOBALS['smarty']->get_template_vars('weblink_detail')->getImage();
									$name = basename($path);
									$GLOBALS["smarty"]->assign("icon_name",$name);
									$GLOBALS["smarty"]->assign("icon_path",$path);
								{/php}
								<tr>
									<td>&nbsp;{insert name='tr' value='Ikona'}</td>
									<td><input size=40 type="text" name="f_image" id="f_image" value="{$weblink_detail->getImage()}" /></td>
                  					<td><a  href="javascript:insertfile('form1','f_image')" title="{insert name='tr' value='vlož obrázok'}"><img src="images/paste.gif" width="21" height="21" border="0"></a></td>
								</tr>
									{if ($weblink_detail->getImage() neq '')}
										<tr>
										<td>&nbsp;{insert name='tr' value='Obrázok'}</td>
										<td width=22>&nbsp;<a  href="{$icon_path}" target="_blank" title="{insert name='tr' value='ukáž'}"><img src="images/view_s.png" border="0"></a></td>
										</tr>
									{/if}
								<tr>
									<td valign="top">&nbsp;{insert name='tr' value='Zobrazovacie&nbsp;práva'}</td>
									<td>
										<img src="images/access_public_s.gif">&nbsp;<input type='radio' onclick="showGroups(false)" name='f_access' value='{$ACCESS_PUBLIC}' {if $weblink_detail->getAccess() eq $ACCESS_PUBLIC}checked='checked'{/if}>&nbsp;{insert name='tr' value='Verejné'}<br />
										<img src="images/access_registered_s.gif">&nbsp;<input type='radio' onclick="showGroups(false)" name='f_access' value='{$ACCESS_REGISTERED}' {if $weblink_detail->getAccess() eq $ACCESS_REGISTERED}checked='checked'{/if}>&nbsp;{insert name='tr' value='Registrovaným'}<br />
										<img src="images/access_special_s.gif">&nbsp;<input type='radio' onclick="showGroups(true)" name='f_access' value='{$ACCESS_SPECIAL}' {if $weblink_detail->getAccess() eq $ACCESS_SPECIAL}checked='checked'{/if}>&nbsp;{insert name='tr' value='Skupiny používateľov'}<br />
										<!-- PRAVA PRE SKUPINY -->
										{if $weblink_detail->getAccess() eq $ACCESS_SPECIAL}
											<div id="groups" name="groups" style="margin-left:20px;">
										{else}
											<div id="groups" name="groups" style="margin-left:20px;display:none">
										{/if}

										<select multiple size="5" name="f_access_groups[]">
										{foreach name='group' from=$group_list item=group_detail}
											{insert name="isSelectedGroup" groups=$weblink_detail->getAccessGroups() current_group_id=$group_detail->getId() assign="selected_group"}
											<option {$selected_group} value="{$group_detail->getId()}">{$group_detail->getTitle()}</option>
										{/foreach}
										</select>
										</div>
										<!-- PRAVA PRE SKUPINY -->

										<!--select name="f_access" id="f_access">
											<option value="{$ACCESS_PUBLIC}" {if $weblink_detail->getAccess() eq $ACCESS_PUBLIC}selected="selected"{/if} >{insert name='tr' value='Verejné'}</option>
											<option value="{$ACCESS_REGISTERED}" {if $weblink_detail->getAccess() eq $ACCESS_REGISTERED}selected="selected"{/if} >{insert name='tr' value='Registrovaným'}</option>
											<option value="{$ACCESS_SPECIAL}" {if $weblink_detail->getAccess() eq $ACCESS_SPECIAL}selected="selected"{/if} >{insert name='tr' value='Skupiny používateľov'}</option>
										</select-->
									</td>
								</tr>


								</form>
							</table>
							</div>

							<div id="blok2" style="visibility: hidden;">
							{if (($user_login->checkPrivilege(70001, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
							<table class="tb_list_in_tab">
								<tr class="tr_header">
									<td colspan="2">&nbsp;</td>
								</tr>
							<form name="form_bind_menu" id="form_bind_menu" method="post" action="action.php">
							<input type="hidden" name="section" id="section" value="weblink_bindmenu" />
							<input type="hidden" name="s_category" id="s_category" value="{$s_category}" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$weblink_detail->getId()}" />
							<input type="hidden" id="showtable" name="showtable" value="1" />
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
									<td colspan="2">&nbsp;{insert name='tr' value='Existujúce priradenia'}</td>
								</tr>
								<tr>
									<td colspan="2">
										<div id="zoznam_bindmenu">
											{include file="ajax/weblink_edit_bindmenu.tpl"}
										</div>
									</td>
								</tr>							</table>
							{/if}
							</div>
							<div id="blok3" style="visibility: hidden;">
							{if (($user_login->checkPrivilege(70002, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
              				<table class="tb_list_in_tab">
								<tr class="tr_header">
									<td colspan="2">&nbsp;</td>
								</tr>
							<form name="form_bind_category" id="form_bind_category" method="post" action="action.php">
							<input type="hidden" name="section" id="section" value="weblink_bindcategory" />
							<input type="hidden" name="s_category" id="s_category" value="{$s_category}" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$weblink_detail->getId()}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="2" />
								<tr>
									<td colspan="2" class="td_align_center">
										<select type="select" name="add_category_id" id="add_category_id">
											<option value="0">{insert name='tr' value='vyberte kategóriu'}</option>
											{insert name='getOptionListMappedCategory' free='totally'}
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="2" class="td_align_center">
										<br /><input class="button" onclick="updateAjax('form_bind_category','zoznam_bindcategory');" type="button" value="{insert name='tr' value='Priraď ku kategórii'}" /><br /><br />
									</td>
								</tr>
							</form>
							<tr class="tr_header">
									<td colspan="2">&nbsp;{insert name='tr' value='Existujúce priradenia'}</td>
							</tr>
								<tr>
									<td colspan="2">
										<div id="zoznam_bindcategory">
											{include file="ajax/weblink_edit_bindcategory.tpl"}
										</div>
									</td>
								</tr>
							</table>
							{/if}
							</div>
							<div id="item4" style="visibility: hidden;">
								<div id="language_list">
									{include file="ajax/weblink_edit_language_versions.tpl"}
								</div>
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
<script language="JavaScript" type="text/javascript">
	//ukaz('{$showtable}')
</script>
