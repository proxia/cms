{literal}
<script language="JavaScript" type="text/javascript">
function addelement(act_type,act_value){
	var newelement = document.createElement('INPUT');
	newelement.type = 'hidden';
	newelement.name = act_type;
	newelement.value = act_value;
	document.form1.appendChild(newelement)
}

function insertfile(form_name,form_text_name,form_text_title){
		form_text_title = "p__title";
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name+"&form_text_title="+form_text_title,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
	}


function insertMassfile(form_name,form_text_name,form_text_title){
		form_text_title = "p__title";
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?module=CMS_Gallery&mcmd=999&form_name="+form_name+"&form_text_name="+form_text_name+"&form_text_title="+form_text_title,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
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

		file = p__file.toLowerCase();
		if ( (file.indexOf('.jpg') == -1) && (file.indexOf('.jpeg') == -1) && (file.indexOf('.png') == -1) && (file.indexOf('.gif') == -1) ){
	   {/literal}
        alert("{insert name='tr' value='Vyberte si obrázok'} !");
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



function listItemTask(the_form,min,max,act_type,act_value,row){
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
			submitform(act_type,act_value)
		}
  }

function validateForm(form) {

	var elements = form1.elements;

	for (i=0; i<elements.length; i++) {

		var name = elements[i].getAttribute("name");
		var value = elements[i].value;

		if ( (name == null) || (name == "mcmd") || (name == "row_id[]") || (name == "f_isPublished") || (name == "section") )
			continue;

		//var indexfilename = name.indexOf("filename");
		//var indexfile = name.indexOf("file");
		//var isFile = (name.indexOf("file") == 0) ? true : false;


			if (value == "") {
			{/literal}
				alert('{insert name='tr' value='nezadali ste povinnú položku'}');
			{literal}
				return false;
			}
	}

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

		);
</script>
{/literal}
{insert name=check}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="{insert name='merge' value1=$path_relative value2='themes/default/images/gallery_view.png'}" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér Fotogalérií / Fotogaléria'}</td>
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
		{$gallery_detail->setContextLanguage($localLanguage)}
			<table class="tb_list">

				<tr class="tr_header">
					<td >&nbsp;{insert name='tr' value='Detail fotogalérie'} {$gallery_detail->getTitle()}</td>

				</tr>
				<tr>
					<td colspan="2">
						<form method="post" action="/vendor/cms_modules/cms_gallery/action.php" name="form_priloha" onSubmit="return checkpriloha(this)">
							<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
							<input type="hidden" name="section" id="section" value="foto" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$gallery_detail->getId()}" />
							<input type="hidden" name="add_attachment" id="add_attachment" value="1" />
							<table class="tb_list_in_tab" align="center">
							{if (($user_login->checkPrivilege(103, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}
								<tr class="tr_header">
									<td colspan="2">&nbsp;{insert name='tr' value='Prílohy'}</td>
									<td >
										<a style="color:red;font-size:1.2em" href="javascript:insertMassfile('form_priloha','p__file')" title="{insert name='tr' value='vlož obrázok'}">
											{insert name='tr' value='Hromadné pridanie do galérie'}
											<img src="../themes/default/images/paste.gif" width="21" height="21" border="0" align="middle"/>
										</a>
									</td>
								</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Názov'}*</td>
									<td colspan="2"><input type="text" name="p__title" id="p__title" size="30" /></td>
								</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Príloha'}*</td>
									<td>
										<input type="text" name="p__file" id="p__file" size="40" />
										&nbsp;&nbsp;
										<a href="javascript:insertfile('form_priloha','p__file')" title="{insert name='tr' value='vlož obrázok'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a>
									</td>
									<td></td>
								</tr>
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
										<form method="post" action="/vendor/cms_modules/cms_gallery/action.php" name="form1" id="form1">
											<input type="hidden" name="section" id="section" value="foto" />
											<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
											<input type="hidden" id="go" name="go" value="foto" />
											<input type="hidden" name="row_id[]" id="row_id[]" value="{$gallery_detail->getId()}" />
											<input type="hidden" id="update_attachment" name="update_attachment" value="1" />
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td class="bold">{insert name='tr' value='Ukáž'}</td>
												<td class="bold">{insert name='tr' value='Názov'}</td>
												<td class="td_align_center"><b>{insert name='tr' value='Zmaž'}</b></td>
											</tr>
											<tr><td colspan="6"><hr></td></tr>
										{foreach name='attach_list' from=$attach_list item='attach_item_id'}
										{/foreach}
										{assign var=increment value=0}

										{assign var='max_list' value=$smarty.foreach.attach_list.iteration}
										{foreach name='attach_list' from=$attach_list item='attach_item_id'}
											{assign var=increment value=$smarty.foreach.attach_list.iteration}
											{$attach_item_id->setContextLanguage($localLanguage)}
											{assign var=defaultView value=0}
											{assign var=showItemEdit value=1}

												{$attach_item_id->setContextLanguage($localLanguageDefault)}
												{assign var=defaultView value=1}
												{assign var=attachTitleDefault  value=$attach_item_id->getTitle()}

											{$attach_item_id->setContextLanguage($localLanguage)}
											{php}
												$path = "../mediafiles/".$GLOBALS['smarty']->get_template_vars(attach_item_id)->getFile();
												$name = basename($path);
												$size = stat($path);
												$GLOBALS["smarty"]->assign("attach_item_id_size",$size['size']);
												$GLOBALS["smarty"]->assign("attach_item_id_name",$name);
												$GLOBALS["smarty"]->assign("attach_item_id_path",$path);
											{/php}
											<tr>
													<td valign="top"><span style="display:none"><input id="box{$increment}" type="checkbox" name="row_id[]" value="{$attach_item_id->getId()}" /></span></td>
													<td valign="top">
														{if $increment neq $max_list}
							    							{if $showItemEdit eq 1}
							    							<a href="#" onclick="listItemTask('form1',1,{$max_list},'move_down_in_gallery',1,'box{$increment}')"><img alt="{insert name='tr' value='posuň smerom dole'}" src="../themes/default/images/downarrow.png" border="1" /></a>
							    							{else}
							    							<img alt="{insert name='tr' value='posuň smerom dole'}" src="../themes/default/images/downarrow.png" border="1" />
							    							{/if}
							    						{/if}
							    						{if ($increment neq $max_list) and ($increment neq 1)}&nbsp;&nbsp;&nbsp;&nbsp;{/if}
							    						{if $increment neq 1}
							    							{if $showItemEdit eq 1}
							    							<a href="#" onclick="listItemTask('form1',1,{$max_list},'move_up_in_gallery',1,'box{$increment}')"><img alt="{insert name='tr' value='posuň smerom hore'}" src="../themes/default/images/uparrow.png"></a>
							    							{else}
							    							<img alt="{insert name='tr' value='posuň smerom hore'}" src="../themes/default/images/uparrow.png">
							    							{/if}
							    						{/if}
													</td>
													<td><a href="{$attach_item_id_path}" target="_blank"><img src="../admin/img.php?path={$attach_item_id_path}&w=100"></a></td>
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
														{math equation="round(med)" med=$attach_item_id_size/1024} kB
													</td>
													<td valign="top" class="td_align_center">{if (($user_login->checkPrivilege(5, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}<input onclick="return checkdelete('{insert name='tr' value='Naozaj chcete vymazať prílohu '}{$attach_item_id_name} ?')" class="noborder" type="image" name="attach_delete{$attach_item_id->getId()}" value="1" src="../themes/default/images/form_delete.gif" title="{insert name='tr' value='zmazať'}">{/if}</td>
											 </tr>
											 <tr><td colspan="6"><hr></td></tr>
											{/foreach}
											</form>
										</table>
									</td>
							</tr>




							</table>
						</form>
					</td>
				</tr>
			</table>

		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
<form name="massFiles"  method="POST" action="/vendor/cms_modules/cms_gallery/action.php">
	<input type="hidden" id="section" name="section" value="massFiles" />
	<input type="hidden" id="module" name="module" value="CMS_Gallery" />
	<input type="hidden" name="gallery_id" id="gallery_id" value="{$gallery_detail->getId()}" />
	<input type="hidden" id="files" name="files" value="" />
</form>