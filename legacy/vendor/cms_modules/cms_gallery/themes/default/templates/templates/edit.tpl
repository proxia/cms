{literal}
<script type="text/javascript" src="../themes/default/js/prototype.js"></script>
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


		var scrollCount = 0;


function validateForm(form) {

	var elements = form1.elements;

	for (i=0; i<elements.length; i++) {

		var name = elements[i].getAttribute("name");
		var value = elements[i].value;

		if ( (name == null) || (name == "mcmd") || (name == "row_id[]") || (name == "f_isPublished") || (name == "section") || (name.indexOf("users")!=-1) || (name.indexOf("lek_")!=-1) )
			continue;

		//var indexfilename = name.indexOf("filename");
		//var indexfile = name.indexOf("file");
		//var isFile = (name.indexOf("file") == 0) ? true : false;


			if (value == "") {
			{/literal}
				alert('{insert name='tr' value='nezadali ste povinnú položku'}'+name);
			{literal}
				return false;
			}
	}
	selectAll();
	form1.submit();
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

function checkdelete(msg){
	{/literal}
     var is_confirmed = confirm(msg);
   	 return is_confirmed;
	{literal}
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
    var url = '/vendor/cms_modules/cms_gallery/action.php';

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
//alert(sBody)

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
					<td><img class="img_middle" src="{insert name='merge' value1=$path_relative value2='themes/default/images/gallery_view.png'}" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér Fotogalérií / Úprava fotogalérie'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left">
		{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
		{include_php file=$path_toolbar}
		</td>
		<td class="td_link_h"><img src="../themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table width="100%" border=0>
				<tr>
					<td class="td_valign_top" width="70%">
						<table class="tb_list">
							<tr class="tr_header">
								<td colspan="2">&nbsp;{insert name='tr' value='Detail fotogalérie'}</td>
							</tr>
							<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_gallery/action.php">
							<input type="hidden" name="section" id="section" value="edit" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$gallery_detail->getId()}" />
							{$gallery_detail->setContextLanguage($localLanguage)}
							<tr><td colspan="2" class="td_link_space"></td></tr>
							<tr>
								<td nowrap="nowrap">&nbsp;{insert name='tr' value='Názov fotogalérie'}*&nbsp;</td>
								<td width="85%"><input size="70" maxlength="255" type="text" name="f_title" id="f_title" value="{$gallery_detail->getTitle()}" /></td>
							</tr>
							<tr>
								<td class="td_valign_top">&nbsp;{insert name='tr' value='Popis fotogalérie'}&nbsp;</td>
								<td ><textarea style="width:100%" cols="70" rows="20" name="f_description" id="f_description">{$gallery_detail->getDescription()}</textarea></td>
							</tr>
						</table>
						{foreach name='language' from=$LanguageListLocal item='language_id'}
							{if $language_id.local_visibility}
								{$gallery_detail->setContextLanguage($language_id.code)}
									<div id="lang{$language_id.code}" style="display:none">
										<div class="ukazkaJazyka">
											<span class="bold">{insert name='tr' value='Jazyk'}:&nbsp;</span>
											<span class="nadpis">{$language_id.code}</span><br /><br />
											<span class="bold">{insert name='tr' value='Názov'}:</span><br />
											{$gallery_detail->getTitle()}<br /><br />
											<span class="bold">{insert name='tr' value='Popis'}:</span><br />
											{$gallery_detail->getDescription()}<br />
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
									<td ><input type="checkbox" name="f_isPublished" id="f_isPublished" value="1" {if $gallery_detail->getIsPublished() eq 1}checked="checked"{/if} /></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;{insert name='tr' value='Zobrazovacie&nbsp;práva'}</td>
									<td>
										<select name="f_access" id="f_access">
											<option value="{$ACCESS_PUBLIC}" {if $gallery_detail->getAccess() eq $ACCESS_PUBLIC}selected="selected"{/if} >{insert name='tr' value='Verejné'}</option>
											<option value="{$ACCESS_REGISTERED}" {if $gallery_detail->getAccess() eq $ACCESS_REGISTERED}selected="selected"{/if} >{insert name='tr' value='Registrovaným'}</option>
											<option value="{$ACCESS_SPECIAL}" {if $gallery_detail->getAccess() eq $ACCESS_SPECIAL}selected="selected"{/if} >{insert name='tr' value='Skupiny používateľov'}</option>
										</select>
									</td>
								</tr>


							</table>
							</form>
							</div>

							<!--MENU-->


							<div id="item2" style="visibility: hidden;">
							{if (($user_login->checkPrivilege(103, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
							<table class="tb_list_in_tab">
							<form  name="form_bind_menu" id="form_bind_menu" method="post" action="/vendor/cms_modules/cms_gallery/action.php">
							<input type="hidden" name="section" id="section" value="gallery_bindmenu" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$gallery_detail->getId()}" />
							<input type="hidden" id="showtable" name="showtable" value="1" />
								<tr class="tr_header">
									<td colspan="2">&nbsp;</td>
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
											{include file="ajax/gallery_edit_bindmenu.tpl"}
										</div>
									</td>
								</tr>
							</table>
							{/if}
							</div>
							<div id="item3" style="visibility: hidden;">
							{if (($user_login->checkPrivilege(103, $privilege_access) eq 1) OR ($user_login_type eq $admin_user))}
							<table class="tb_list_in_tab">
							<form name="form_bind_category" id="form_bind_category" method="post" action="/vendor/cms_modules/cms_gallery/action.php">
							<input type="hidden" name="section" id="section" value="gallery_bindcategory" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$gallery_detail->getId()}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="2" />
								<tr class="tr_header">
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>{insert name='getParentCategoryCat' id=$gallery_detail->getId() assign="ParentCategoryId"}
									<td  class="td_align_center">
										<select type="select" name="add_category_id" id="add_category_id">
											<option value="0">{insert name='tr' value='vyberte kategóriu'}</option>
											{insert name='getOptionListMappedCategory' free='totally' select=$ParentCategoryId zakaz=$gallery_detail->getId()}
										</select>
									</td>
								</tr>
								<tr>
									<td class="td_align_center">
										<br /><input class="button" onclick="updateAjax('form_bind_category','zoznam_bindcategory');" type="button" value="{insert name='tr' value='Priraď ku kategórii'}" /><br /><br />
									</td>
								</tr>
							</form>
							<tr class="tr_header">
								<td colspan="2">&nbsp;{insert name='tr' value='Zoznam priradení'}</td>
							</tr>
							<tr>
								<td colspan="2">
									<div id="zoznam_bindcategory">
										{include file="ajax/gallery_edit_bindcategory.tpl"}
									</div>
								</td>
							</tr>
							</table>
							{/if}
							</div>
							<div id="item4" style="visibility: hidden;">
								<div id="language_list">
									{include file="ajax/gallery_edit_language_versions.tpl"}
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