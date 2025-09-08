{literal}
<script language="JavaScript" type="text/javascript">

function addelement(act_type,act_value){
	var newelement = document.createElement('INPUT'); 
	newelement.type = 'hidden'; 
	newelement.name = act_type; 
	newelement.value = act_value;
	document.form1.appendChild(newelement)
} 

function insertfile(form_name,form_text_name){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
} 

function submitform(act_type,act_value){
	addelement(act_type,act_value);
	
	try {
		document.form1.onsubmit();
		}
	catch(e){}
		document.form1.submit();
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
{assign var='title' value='Skupina atribútov / detail'}
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
			<table width="100%" border="0">
				<tr>
					<td class="td_valign_top" width="70%">
							<table class="tb_list"  >
							<tr class="tr_header">
								<td colspan="4">&nbsp;{insert name='tr' value='Detail skupiny atribútov'}</td>
							</tr>
							<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
							<input type="hidden" id="mcmd" name="mcmd" value="{$mcmd}" />
							<input type="hidden" id="row_id[]" name="row_id[]" value="{$detail_attribut->getId()}" />
							<input type="hidden" id="section" name="section" value="group_attribute" />
							{$detail_attribut->setContextLanguage("$localLanguage")}
							<tr><td colspan="4" class="td_link_space"></td></tr>
							<tr>
								<td>&nbsp;{insert name='tr' value='Názov'}*</td>
								<td width="85%" colspan="4"><input size="60" type="text" name="f_title" id="f_title" value="{$detail_attribut->getTitle()}" /></td>
							</tr>
							<tr>
								<td>&nbsp;{insert name='tr' value='Popis'}</td>
								<td width="85%" colspan="4"><input size="60" type="text" name="f_description" id="f_description" value="{$detail_attribut->getDescription()}" /></td>
							</tr>
							{php}
								$path = "..{$GLOBALS['project_folder']}/".$_SESSION['user']['name']."/mediafiles/".$GLOBALS['smarty']->get_template_vars(detail_attribut)->getImage();
								$name = basename($path);
								$GLOBALS["smarty"]->assign("icon_name",$name);
								$GLOBALS["smarty"]->assign("icon_path",$path);
							{/php} 
							<tr>
								<td>&nbsp;{insert name='tr' value='Obrázok'}</td>
								<td width="30%"><input size="40" type="text" name="f_image" id="f_image" value="{$detail_attribut->getImage()}" /></td>
				            	<td width="22"><a href="javascript:insertfile('form1','f_image')" title="{insert name='tr' value='vlož obrázok'}"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
								{if ($detail_attribut->getImage() eq '')}
			            	<td width=22>&nbsp;</td>
			         	{else}
			             	<td width="50%">&nbsp;<a  href="{$icon_path}" target="_blank" title="{insert name='tr' value='ukáž'}"><img src="../themes/default/images/view_s.png" border="0"></a></td>
			         	{/if}
				       </tr>
						</form>
						</table>
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
								<table class="tb_list_in_tab">
								<form name="form5" id="form5" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
								<input type="hidden" name="section" id="section" value="map_attribute_to_group" />
								<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
								<input type="hidden" id="showtable" name="showtable" value="0" />
								<input type="hidden" name="group_id" id="group_id" value="{$detail_attribut->getId()}" />
								<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_attribut->getId()}" />								
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
													{insert name='getExistsAttribut' groupId=$detail_attribut->getId() attributId=$attribut_id->getId() assign='is_existsAttribut'}
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
												<input class="button" type="submit" value="{insert name='tr' value='Priraďiť ku skupine'}" />
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
								<form method="post" id="attribut" name="attribut" action="/vendor/cms_modules/cms_catalog/action.php" onsubmit="return checkdelete(this,'{insert name='tr' value='Zrušiť väzbu '} ?','{insert name='tr' value='Žiadan položka nie je vybratá!'}')">
								<input type="hidden" name="section" id="section" value="unmap_attribute_to_group" />
								<input type="hidden" name="mcmd" id="mcmd" value="{$mcmd}" />
								<input type="hidden" name="group_id" id="group_id" value="{$detail_attribut->getId()}" />								
								<input type="hidden" name="row_id[]" id="row_id[]" value="{$detail_attribut->getId()}" />
								<input type="hidden" id="showtable" name="showtable" value="1" />
									{foreach name='attribut_branch' from=$attribut_branch_list item='attribut_branch_id'}
									{/foreach}
									{assign var='max_list' value=$smarty.foreach.attribut_branch.iteration}
		
									{foreach name='attribut_branch' from=$attribut_branch_list item='attribut_branch_id'}
									
									{assign var='attribut_name' value=$attribut_branch_id->getAttributeDefinitionId()}
									<tr>
										<td class="bold">&nbsp;&nbsp;<a href="./?mcmd=9&module=CMS_Catalog&row_id[]={$attribut_branch_id->getId()}">{$attribut_branch_list_title.$attribut_name}</a></td>
										<td colspan="2"></td>
										<td></td>
										<td class="td_align_center"><input type="checkbox" name="remove_attribut_id[]" id="remove_attribut_id" value="{$attribut_branch_id->getId()}"></td>
	
									</tr>
					
									<tr><td colspan="6"><hr></td></tr>
								
									{/foreach}
								
									<tr><td colspan="6"  class="td_align_center"><br>
									{if $showItemEdit eq 1}
									<input type="submit" name="attach_update" value="{insert name='tr' value='Označené položky vymazať'}">
									{/if}
									<br><br></td></tr>
								</form>
								</table>
								</td>
								</tr>
								</table>
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
