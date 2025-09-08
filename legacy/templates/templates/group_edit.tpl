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
			"f_name","0","50","V",
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
	{$group_detail->setContextLanguage($language_id.code)}
		hiddenlang('lang{$language_id.code}');
{/if}
{/foreach}

{literal}

	showlang(id);
}

function validateForm(form,act_type,act_value) {
	form = eval(form);
	var elements = document.form1.elements;
	for (i=0; i<elements.length; i++) {
		//alert(elements[i].type + ":" + elements[i].name + ":" + elements[i].value);
		//alert(elements[i].getAttribute("name"));
		var name = elements[i].name;
		var value = elements[i].value;

		if ( (name == null) || (name == "row_id[]") || (name == "f_description") || (name == "f_isPublished") || (name == "section") || (name.indexOf("users")!=-1) || (name.indexOf("grp_users")!=-1) )
			continue;

			if (value == "") {
			{/literal}
				alert('{insert name='tr' value='nezadali ste povinnú položku'}');
			{literal}
				return false;
			}
	}

	addelement(act_type,act_value,form);

	selectAll();
	document.form1.submit();
}
function selectAll(){

    var frmMap = document.forms["form1"];
    var selectLeft = frmMap.grp_users;
    var pocetLeft = selectLeft.length;
    for(i=0;i<pocetLeft;i++)
        selectLeft.options[i].selected = true;

    return true;
  }

// Dual list move function
function moveDualList( srcList, destList, moveAll )
{
  // Do nothing if nothing is selected
  if (  ( srcList.selectedIndex == -1 ) && ( moveAll == false )   )
  {return;}
  newDestList = new Array( destList.options.length );
  var len = 0;
  for( len = 0; len < destList.options.length; len++ )
  {
    if ( destList.options[ len ] != null )
    {
      newDestList[ len ] = new Option( destList.options[ len ].text, destList.options[ len ].value, destList.options[ len ].defaultSelected, destList.options[ len ].selected );
    }
  }
  for( var i = 0; i < srcList.options.length; i++ )
  {
    if ( srcList.options[i] != null && ( srcList.options[i].selected == true || moveAll ) )
    {
       // Statements to perform if option is selected
       // Incorporate into new list
       newDestList[ len ] = new Option( srcList.options[i].text, srcList.options[i].value, srcList.options[i].defaultSelected, srcList.options[i].selected );
       len++;
    }
  }
  // Sort out the new destination list
//  newDestList.sort( compareOptionValues );   // BY VALUES
  //newDestList.sort( compareOptionText );   // BY TEXT
  // Populate the destination with the items from the new array
  for ( var j = 0; j < newDestList.length; j++ )
  {
    if ( newDestList[ j ] != null )
    {
      destList.options[ j ] = newDestList[ j ];
    }
  }
  // Erase source list selected elements
  for( var i = srcList.options.length - 1; i >= 0; i-- )
  {
    if ( srcList.options[i] != null && ( srcList.options[i].selected == true || moveAll ) )
    {
       // Erase Source
       //srcList.options[i].value = "";
       //srcList.options[i].text  = "";
       srcList.options[i]       = null;
    }
  }
} // End of moveDualList()

</script>
{/literal}
{insert name=check}
{$group_detail->setContextLanguage($localLanguage)}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/group_view_edit.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér skupín / Úprava skupiny'}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left">
			{include_php file="scripts/toolbar.php"}
		</td>
		<td class="td_link_h"><img src="images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table width="100%">
				<tr>
					<td class="td_valign_top" width="70%">
						<table class="tb_list">
							<tr class="tr_header">
								<td colspan="2">&nbsp;{insert name='tr' value='Detail skupiny'}</td>
							</tr>
							<form name="form1" id="form1" method="post" action="action.php">

							<input type="hidden" name="section" id="section" value="groups" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" name="act" id="act" value="update" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$group_detail->getId()}" />

							<tr><td colspan="2" class="td_link_space"></td></tr>
							<tr>
								<td nowrap="nowrap">&nbsp;{insert name='tr' value='Kód skupiny'}*&nbsp;</td>
								<td width="85%"><input size="60" type="text" name="f_name" id="f_name" value="{$group_detail->getName()}" /></td>
							</tr>
							<tr>
								<td nowrap="nowrap">&nbsp;{insert name='tr' value='Názov skupiny'}*&nbsp;</td>
								<td width="85%"><input size="60" type="text" name="f_title" id="f_title" value="{$group_detail->getTitle()}" /></td>
							</tr>
							<tr>
								<td class="td_valign_top">&nbsp;{insert name='tr' value='Popis skupiny'}&nbsp;</td>
								<td width="90%"><textarea cols="80" rows="6" name="f_description" id="f_description">{$group_detail->getDescription()}</textarea></td>
							</tr>
							<tr>
							</tr>
							<tr>
								<td></td>
								<td>

									<table cellpadding="2" cellspacing="1" border="0">
										<th class="bold">{insert name='tr' value='Priradení používatelia'}</th><th></th><th class="bold">{insert name='tr' value='Zoznam používateľov'}</th>
										<tr>
											<td>

												<select id="grp_users"  name="grp_users[]" multiple size="10" style="width:170">

												{foreach name='grp_user_name' from=$group_detail->getUsers() item='grp_user'}
													{insert name=getUser value=$grp_user->getId() assign=user_detail}
													<option value="{$grp_user->getId()}">{$user_detail.name}</option>
												{/foreach}
												</select>
											</td>
											<td width="50" align="center">
												<input onclick="moveDualList( this.form.grp_users,  this.form.users, false )"   type="button" value="  -->  "><br>
												<input onclick="moveDualList( this.form.users,  this.form.grp_users, false )"   type="button" value="  <--  ">
											</td>
											<td>
												<select id="users" name="users[]" multiple size="10" style="width:170">
												{foreach name='user' from=$user_list item='user_id'}
													<option value="{$user_id->getId()}">{$user_id->getFirstname()}&nbsp;{$user_id->getFamilyname()}</option>
												{/foreach}
												</select>
											</td>
										</tr>
									</table>



								</td>
							</tr>
						</table>

					<br />
					{foreach name='language' from=$LanguageListLocal item='language_id'}
						{if $language_id.local_visibility}
							{$group_detail->setContextLanguage($language_id.code)}
								<div id="lang{$language_id.code}" style="display:none">
									<div class="ukazkaJazyka">
										<span class="bold">{insert name='tr' value='Jazyk'}:&nbsp;</span>
										<span class="nadpis">{$language_id.code}</span><br /><br />
										<span class="bold">{insert name='tr' value='Názov'}:</span><br />
										{$group_detail->getTitle()}<br />
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

							<div id="item1" style="visibility: hidden;">
							<table class="tb_list_in_tab">
								<tr class="tr_header">
									<td colspan="4">&nbsp;{insert name='tr' value='Detailné nastavenia'}</td>
								</tr>
								<tr>
									<td>&nbsp;{insert name='tr' value='Viditeľnosť'}</td>
									<td width="50%"><input type="checkbox" name="f_isPublished" id="f_isPublished" value="1" {if $group_detail->getIsPublished() eq 1}checked="checked"{/if} /></td>
								</tr>

								</form>
							</table>
							</div>


							<div id="item2" style="visibility: hidden;">
							<form method="post" action="action.php" name="lang">
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="section" id="section" value="groups" />
							<input type="hidden" id="showtable" name="showtable" value="1" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$group_detail->getId()}" />
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
								{$group_detail->setContextLanguage($language_id.code)}
								<tr>
									<td>&nbsp;{$language_id.code}</td>
									<td><input type="checkbox" name="a_languageIsVisible{$language_id.code}" id="f_languageIsVisible{$language_id.code}" value="1" {if $group_detail->getLanguageIsVisible() eq 1}checked="checked"{/if} /></td>
									<td><a title="{insert name='tr' value='ukáž'}" href="javascript:ukazlang('lang{$language_id.code}')"><img src="images/view_s.png" /></td>
								</tr>
								{/foreach}
								<tr>
									<td></td>
									<td class="td_center" colspan="2"><br />
									{if (($user_login->checkPrivilege(12, $privilege_update) eq 1) OR ($user_login_type eq $admin_user))}
										<input class="button" type="submit" value="{insert name='tr' value='Zmeniť nastavenie'}" />
									{/if}
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
<script language="JavaScript" type="text/javascript">
	//ukaz('{$showtable}')
</script>
