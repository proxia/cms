{literal}
<script type="text/javascript" src="themes/default/js/prototype.js"></script>
<script language="JavaScript" type="text/javascript">
function addelement(act_type,act_value){
	var newelement = document.createElement('INPUT');
	newelement.type = 'hidden';
	newelement.name = act_type;
	newelement.value = act_value;
	document.form1.appendChild(newelement)
}

function checkdelete(msg){
	{/literal}
     var is_confirmed = confirm(msg);
   	 return is_confirmed;
	{literal}
  }


function submitform(act_type,act_value){
	addelement(act_type,act_value);
	try {
		document.form1.onsubmit();
		}
	catch(e){}
		document.form1.submit();
}

		var numRows = 1;
		var scrollCount = 0;


   // zoznam objektov ktore treba kontrolovat
	// E - kontrola na email
	// V - kontrola na retazec
	// N - kontrola na cislo
	// U - kontrola na url
	// H - kontrola na rovnost hesla musia byt dve polia z H alebo ziadne
	// "nazov pola" "min dlzka" "max dlzka" "typ kontroly"
	var pole=new Array(
			"c_title","0","100","V"
		);

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
	{$detail_movie->setContextLanguage($language_id.code)}
		hiddenlang('lang{$language_id.code}');
{/if}
{/foreach}

{literal}

	showlang(id);
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

function insertfile(form_name,form_text_name){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
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
	var url = '../modules/cms_movies/action.php';

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
					<td><img class="img_middle" src="{insert name='merge' value1=$path_relative value2='themes/default/images/movies.png'}" alt="" />&nbsp;&nbsp;{insert name='tr' value='Kino - program'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	{assign var=showItemEdit value=1}
	<tr>
		<td class="td_middle_left">
		{insert name='merge' value1=$path_relative value2='themes/default/scripts/toolbar.php' assign='path_toolbar'}
		{include_php file=$path_toolbar}
		</td>
		<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="2" /></td>
			<td class="td_middle_center">
			<table width="100%">
			<tr>
				<td class="td_valign_top">
					<table class="tb_list">
						<tr class="tr_header">
							<td colspan="2">&nbsp;{insert name='tr' value='Detail'}</td>
						</tr>
				<form name="form1" id="form1" method="post" action="../modules/cms_movies/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="{$detail_movie->getId()}" />
				<input type="hidden" id="section" name="section" value="update" />
						{$detail_movie->setContextLanguage("$localLanguage")}
						<tr><td class="td_link_space"></td></tr>

						<tr>
							<td>
							{insert name='tr' value='Názov'}*<br />
							<input maxlength="255" size="79" type="text" name="c_title" id="c_title" value="{$detail_movie->getTitle()}"  /></td>
						</tr>
						<tr>
							<td><br />{insert name='tr' value='Popis'}<br />
							<textarea style="width:100%" cols="200" rows="20" name="c_description" id="c_description">{$detail_movie->getDescription()}</textarea></td>
						</tr>

					</table>
					{foreach name='language' from=$LanguageListLocal item='language_id'}
						{if $language_id.local_visibility}
							{$detail_movie->setContextLanguage($language_id.code)}
								<div id="lang{$language_id.code}" style="display:none">
									<div class="ukazkaJazyka">
										<span class="bold">{insert name='tr' value='Jazyk'}:&nbsp;</span>
										<span class="nadpis">{$language_id.code}</span><br /><br />
										<span class="bold">{insert name='tr' value='Názov'}:</span><br />
										{$detail_movie->getTitle()}<br /><br />
										<span class="bold">{insert name='tr' value='Popis'}:</span><br />
										{$detail_movie->getDescription()}<br />
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
									<td ><input type="checkbox" name="c_isPublished" id="c_isPublished" value="1" {if $detail_movie->getIsPublished() eq 1}checked="checked"{/if} /></td>
								</tr>
								<tr>
									<td width="30%">&nbsp;{insert name='tr' value='Viditeľný od'}</td>
									<td>{insert name=makeCalendar nazov="c_valid_from" value=$detail_movie->getValidFrom()}</td>
								</tr>
<!--								<tr>
									<td width="30%">&nbsp;{insert name='tr' value='Platnosť do'}</td>
									<td>{insert name=makeCalendar nazov="c_valid_to" value=$detail_movie->getValidTo()}</td>
								</tr>-->
								<tr>
									<td width="30%">&nbsp;{insert name='tr' value='Začiatok premietania'}</td>
									<td>{insert name=makeCalendar nazov="c_real_date_start" value=$detail_movie->getRealDateStart()}</td>
								</tr>
<!--								<tr>
									<td width="30%">&nbsp;{insert name='tr' value='Koniec podujatia'}</td>
									<td>{insert name=makeCalendar nazov="c_real_date_end" value=$detail_movie->getRealDateEnd()}</td>
								</tr>-->
								{php}
									$path = "..{$GLOBALS['project_folder']}/".$_SESSION['user']['name']."/mediafiles/".$GLOBALS['smarty']->get_template_vars(detail_movie)->getImage();
									$name = basename($path);
									$GLOBALS["smarty"]->assign("icon_name",$name);
									$GLOBALS["smarty"]->assign("icon_path",$path);
								{/php}
								<tr>
									<td>&nbsp;{insert name='tr' value='Obrázok'}</td>
									<td width="30%"><input size=35 type="text" name="f_image" id="f_image" value="{$detail_movie->getImage()}" /></td>
                 					<td width=22><a href="javascript:insertfile('form1','f_image')" title="{insert name='tr' value='vlož obrázok'}"><img src="themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
									{if ($detail_movie->getImage() eq '')}
                     					<td width=22>&nbsp;</td>
                  					{else}
                      					<td width=22>&nbsp;<a  href="{$icon_path}" target="_blank" title="{insert name='tr' value='ukáž'}"><img src="themes/default/images/view_s.png" border="0"></a></td>
                  					{/if}
                  				</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Video'} (flv,mov,wmv)</td>
									<td width="30%"><input size=35 type="text" name="f_video" id="f_video" value="{$detail_movie->getVideo()}" /></td>
                 					<td width=22><a href="javascript:insertfile('form1','f_video')" title="{insert name='tr' value='prilep cestu k video'}"><img src="themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
                  				</tr>

								<tr>
									<td>&nbsp;{insert name='tr' value='Cena'}</td>
									<td width="30%"><input type="text" name="c_price" id="c_price" size="10" maxlength="15" value="{$detail_movie->getPrice()}"> EUR</td>
								</tr>
						
							</table>
							</form>
							</div>

							<!--PHOTOGALERY-->

							<div id="item2" style="visibility: hidden;">
								<table class="tb_list_in_tab">
									<form name="form_bind_gallery" id="form_bind_gallery" method="post" action="../modules/cms_movies/action.php">
									<input type="hidden" name="section" id="section" value="event_bindgallery" />
									<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
									<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_movie->getId()}" />
									<input type="hidden" id="go" name="go" value="edit" />
									<input type="hidden" id="showtable" name="showtable" value="1" />
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
											{if $showItemEdit eq 1}
												<br /><input class="button" onclick="updateAjax('form_bind_gallery','zoznam_bindgallery');" type="button" value="{insert name='tr' value='Priraďiť'}" /><br /><br />
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
													{include file="ajax/movie_edit_bindgallery.tpl"}
												</div>
											</td>
										</tr>
										</table>
							</div>
							<div id="item3" style="visibility: hidden;">
								<div id="language_list">
									{include file="ajax/movie_edit_language_versions.tpl"}
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