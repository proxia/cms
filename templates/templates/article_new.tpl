{literal}
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
</script>
{/literal}
{insert name=check}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/article_view_add.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér článkov / Nový článok'}</td>
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
			<table class="tb_list" >

				<tr class="tr_header">
					<td colspan="4">&nbsp;{insert name='tr' value='Detail článku'}</td>
				</tr>
				<form name="form1" id="form1" method="post" action="action.php">
				<input type="hidden" id="section" name="section" value="article" />
				<input type="hidden" id="cmd" name="cmd" value="{$cmd}" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="0" />
				<input type="hidden" id="f_language_is_visible" name="f_language_is_visible" value="1" />
				<tr><td colspan="4" class="td_link_space"></td></tr>
				<tr>
					<td>&nbsp;{insert name='tr' value='Názov článku'}*</td>
					<td><input size="80" type="text" name="f_title" id="f_title" /></td>
					<td>
            {if (($user_login->checkPrivilege(50003, $privilege_add) eq 1) OR ($user_login_type eq $admin_user))}
            &nbsp;{insert name='tr' value='Vyberte menu'}
            {/if}
          </td>
					<td>
					{if (($user_login->checkPrivilege(50003, $privilege_add) eq 1) OR ($user_login_type eq $admin_user))}
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
						{/if}
					</td>
				</tr>
				<tr>
					<td valign="top">&nbsp;{insert name='tr' value='Popis článku'}</td>
					<td><textarea class="mceArticleDesc" name="f_description" id="f_description" cols="80" rows="3" style="width:99%"></textarea></td>
					<td>
            {if (($user_login->checkPrivilege(50004, $privilege_add) eq 1) OR ($user_login_type eq $admin_user))}
            &nbsp;{insert name='tr' value='Vyberte kategóriu'}
            {/if}
          </td>
					<td>
					{if (($user_login->checkPrivilege(50004, $privilege_add) eq 1) OR ($user_login_type eq $admin_user))}
										<select name="add_category_id">
											<option value="0">{insert name='tr' value='vyberte kategóriu'}</option>
											{insert name='getOptionListMappedCategory' free='totally'}
										</select>
					{/if}
					</td>
				</tr>
				<tr>
					<td valign="top">&nbsp;{insert name='tr' value='Zobrazovacie&nbsp;práva'}</td>
					<td colspan="3">
						<select name="f_access" id="f_access">
							<option value="{$ACCESS_PUBLIC}">{insert name='tr' value='Verejné'}</option>
							<option value="{$ACCESS_REGISTERED}">{insert name='tr' value='Registrovaným'}</option>
							<option value="{$ACCESS_SPECIAL}">{insert name='tr' value='Skupiny používateľov'}</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="td_valign_top">&nbsp;{insert name='tr' value='Text článku'}*</td>
					<td><textarea class="mceArticleText" rows="70" cols="80" style="width:99%" name="f_text" id="f_text"></textarea></td>
					<td colspan="2"></td>
				</tr>
				</form>
			</table>
			<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
