{literal}
<script type="text/javascript" src="library/cms_classes/apytmenu.js"></script>
<script type="text/javascript" src="library/cms_classes/apytmenu_ss.js"></script>
<script language="JavaScript" type="text/javascript">
// start tabulator ***************************************************************
var name_form = "form1";

function showtd(id){
	var style=document.getElementById(id).style;
	style.backgroundColor = "#ffffff";
	style.borderBottom = "0px";
}

function showtdhref(id){
	var style=document.getElementById(id).style;
	style.backgroundColor = "#ffffff";
	style.fontWeight = "normal";
	style.color = "#cc3333";
}

function hiddentd(id){
	var style=document.getElementById(id).style;
	style.backgroundColor = "#dedede";
	style.borderBottomWidth = "1px";
	style.borderStyle = "solid";
	style.borderColor = "#bcbcbc";
}

function hiddentdhref(id){
	var style=document.getElementById(id).style;
	style.backgroundColor = "#dedede";
	style.fontWeight = "normal";
	style.color = "#000000";
}

function hiddenblok(id){
	var style=document.getElementById(id).style;
	style.display = "none";
}

function showblok(id){
	//alert(id);
	var style=document.getElementById(id).style;
	style.display = "block";
}

function view(id){
	//alert(id);
	var style=document.getElementById(id).style;
	style.display = "block";
}

function ukaz(id,num_block){

	for (block=0;block<num_block;block=block+1){

			var b = "b"+block;
		//	hiddentd(b);
			var bh = "bh"+block;
		//	hiddentdhref(bh);
			var blok = "blok"+block;
			hiddenblok(blok);
		}
	var pid = "b"+id;
	var pid2 = "bh"+id;
	var pid3 = "blok"+id;

	//showtd(pid);
	//showtdhref(pid2);
	showblok(pid3);

	if(id == 0){
			name_form = "form1";
		}

	if(id == 1){
			name_form = "form2";
		}

	if(id == 2){
			name_form = "form3";
		}

	if(id == 3){
			name_form = "form4";
		}

	if(id == 4){
			name_form = "form5";
		}

}
// end tabulator ***************************************************************

function addelement(act_type,act_value,the_form){
	var newelement = document.createElement('INPUT');
	newelement.type = 'hidden';
	newelement.name = act_type;
	newelement.value = act_value;
	document.forms[the_form].appendChild(newelement)
}

function submitform(the_form,act_type,act_value){
	addelement(act_type,act_value,the_form);
	try {
		document.forms[the_form].onsubmit();
		}
	catch(e){}
		document.forms[the_form].submit();
}

   // zoznam objektov ktore treba kontrolovat
	// E - kontrola na email
	// V - kontrola na retazec
	// N - kontrola na cislo
	// U - kontrola na url
	// H - kontrola na rovnost hesla musia byt dve polia z H alebo ziadne
	// "nazov pola" "min dlzka" "max dlzka" "typ kontroly"
	var pole=new Array(
		//	"f_firstname","0","100","V",
		//	"f_familyname","0","100","V",
		//	"f_login","0","100","V"
		);
</script>
{/literal}
{insert name=checkMoreForm}
<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_title">
				<tr>
					<td><img class="img_middle" src="images/user_view_edit.png" alt="" />&nbsp;&nbsp;{insert name='tr' value='Manažér používateľov / Úprava používateľa'} [{$user_detail->getFirstname()} {$user_detail->getFamilyname()}]</td>
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


		<!--table width="100%" border=0>
			<tr>
				<td class="td_valign_top"-->


				<table width="100%" border=0 class="tb_tabs">
				<tr><td ><br /></td></tr>
				<tr class="tr_header_tab">
					<td  class="td_tabs_top">
					{$menu}
					</td>
				</tr>
				<tr><td class="td_valign_top" >

				  <div id="blok0" style="display: none;">
					<table class="tb_list" border="0">
						<tr class="tr_header">
							<td colspan="3">&nbsp;{insert name='tr' value='Detail používateľa'}</td>

						</tr>
						<form name="form1" id="form1" method="post" action="action.php">
						<input type="hidden" name="section" id="section" value="user" />
						<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
						<input type="hidden" name="row_id[]" id="row_id[]" value="{$user_detail->getId()}" />
						<input type="hidden" name="act" id="act" value="update" />
						<input type="hidden" id="showtable" name="showtable" value="0" />

						<tr><td colspan="3" class="td_link_space"></td></tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Titul'}</td>
							<td><input maxlength="30" size="5" type="text" name="f_title" id="f_title" value="{$user_detail->getTitle()}" /></td>
							<td width="30%"></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Meno'}*</td>
							<td><input size="20" maxlength="30" type="text" name="f_firstname" id="f_firstname" value="{$user_detail->getFirstname()}" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Priezvisko'}*</td>
							<td><input size="30" maxlength="30" type="text"  name="f_familyname" id="f_familyname" value="{$user_detail->getFamilyname()}" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Nick'}</td>
							<td><input size="20" maxlength="30" type="text" name="f_nickname" id="f_nickname" value="{$user_detail->getNickname()}" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Prihlasovacie meno'}*</td>
							<td><input maxlength="30" type="text" name="f_login" id="f_login" value="{$user_detail->getLogin()}" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Heslo'}</td>
							<td><input maxlength="30" type="password" name="f_password" id="f_password" /></td>
						</tr>
						<tr><td colspan="3"><hr /></td></tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Ulica'}</td>
							<td><input size="30" maxlength="30" type="text" name="f_street" id="f_street" value="{$user_detail->getStreet()}" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Mesto'}</td>
							<td><input size="20" maxlength="30" type="text" name="f_city" id="f_city" value="{$user_detail->getCity()}" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='PSČ'}</td>
							<td><input size="6" maxlength="10" type="text" name="f_zip" id="f_zip" value="{$user_detail->getZip()}" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Krajina'}</td>
							<td><input type="text" name="f_country" id="f_country" value="{$user_detail->getCountry()}" /></td>
						</tr>
						<tr><td colspan="3"><hr /></td></tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Telefón'}</td>
							<td><input size="20" maxlength="20" type="text" name="f_phone" id="f_phone" value="{$user_detail->getPhone()}" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Fax'}</td>
							<td><input size="20" maxlength="20" type="text" name="f_fax" id="f_fax" value="{$user_detail->getFax()}" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Mobil'}</td>
							<td><input size="20" maxlength="20" type="text" name="f_cell" id="f_cell" value="{$user_detail->getCell()}" /></td>
						</tr>
						<tr>
							<td>&nbsp;{insert name='tr' value='Email'}</td>
							<td><input size="30" maxlength="50" type="text" name="f_email" id="f_email" value="{$user_detail->getEmail()}" /></td>
						</tr>

							{insert name='buildUserExtensionForm' value=$user_detail}
          </form>
					</table>
					</div>

					{if $user_login_type eq $admin_user}

					<div id="blok1" style="display: none;">
						<form name="form2" id="form2" method="post" action="action.php">
						<input type="hidden" name="section" id="section" value="user" />
						<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
						<input type="hidden" name="row_id[]" id="row_id[]" value="{$user_detail->getId()}" />
						<input type="hidden" name="act" id="act" value="update" />
						<input type="hidden" id="showtable" name="showtable" value="1" />

						<input type="hidden" name="privileges" value="null" />
						<table border="0" width=400 cellpadding=0 cellspacing=0 style="border:1px solid gray">

							<tr style="background-color:silver">
								<th>{insert name='tr' value='Logicka Entita'}</th>
								<th>{insert name='tr' value='Access'}</th>
								<th>{insert name='tr' value='View'}</th>
								<th>{insert name='tr' value='Add'}</th>
								<th>{insert name='tr' value='Delete'}</th>
								<th>{insert name='tr' value='Update'}</th>
								<th>{insert name='tr' value='Restore'}</th>
							</tr>

							{foreach item=entity from=$privileges_core}

							<tr>
								<td style="border-bottom:1px solid gray" style="padding-left: 5px; padding-right: 5px;">{$entity.name}</td>

								<td style="border-bottom:1px solid gray" style="text-align: center;">
									{if $entity.valid_privileges & $privileges_access}
										{if (isset($entity.set_privileges)) && ($entity.set_privileges & $privileges_access) }
											<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_access}" checked="checked" />
										{else}
											<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_access}" />
										{/if}
									{/if}
									&nbsp;
								</td>

								<td style="border-bottom:1px solid gray" style="text-align: center;">
									{if $entity.valid_privileges & $privileges_view}
										{if (isset($entity.set_privileges)) && ($entity.set_privileges & $privileges_view) }
											<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_view}" checked="checked" />
										{else}
											<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_view}" />
										{/if}
									{/if}
									&nbsp;
								</td>

								<td style="border-bottom:1px solid gray" style="text-align: center;">
									{if $entity.valid_privileges & $privileges_add}
										{if (isset($entity.set_privileges)) && ($entity.set_privileges & $privileges_add) }
											<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_add}" checked="checked" />
										{else}
											<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_add}" />
										{/if}
									{/if}
									&nbsp;
								</td>

								<td style="border-bottom:1px solid gray" style="text-align: center;">
									{if $entity.valid_privileges & $privileges_delete}
										{if (isset($entity.set_privileges)) && ($entity.set_privileges & $privileges_delete) }
											<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_delete}" checked="checked" />
										{else}
											<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_delete}" />
										{/if}
									{/if}
									&nbsp;
								</td>

								<td style="border-bottom:1px solid gray" style="text-align: center;">
									{if $entity.valid_privileges & $privileges_update}
										{if (isset($entity.set_privileges)) && ($entity.set_privileges & $privileges_update) }
											<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_update}" checked="checked" />
										{else}
											<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_update}" />
										{/if}
									{/if}
									&nbsp;
								</td>

								<td style="border-bottom:1px solid gray" style="text-align: center;">
									{if $entity.valid_privileges & $privileges_restore}
										{if (isset($entity.set_privileges)) && ($entity.set_privileges & $privileges_restore) }
											<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_restore}" checked="checked" />
										{else}
											<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_restore}" />
										{/if}
									{/if}
									&nbsp;
								</td>

							</tr>

							{if isset($entity.subentities)}
								{foreach item=subentity from=$entity.subentities}

								<tr>
									<td style="border-bottom:1px solid silver" style="padding-left: 20px; padding-right: 5px;">{$subentity.name}</td>

									<td style="border-bottom:1px solid silver" style="text-align: center;">
										{if $subentity.valid_privileges & $privileges_access}
											{if (isset($subentity.set_privileges)) && ($subentity.set_privileges & $privileges_access) }
												<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_access}" checked="checked" />
											{else}
												<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_access}" />
											{/if}
										{/if}
									&nbsp;
									</td>

									<td style="border-bottom:1px solid silver" style="text-align: center;">
										{if $subentity.valid_privileges & $privileges_view}
											{if (isset($subentity.set_privileges)) && ($subentity.set_privileges & $privileges_view) }
												<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_view}" checked="checked" />
											{else}
												<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_view}" />
											{/if}
										{/if}
									&nbsp;
									</td>

									<td style="border-bottom:1px solid silver" style="text-align: center;">
										{if $subentity.valid_privileges & $privileges_add}
											{if (isset($subentity.set_privileges)) && ($subentity.set_privileges & $privileges_add) }
												<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_add}" checked="checked" />
											{else}
												<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_add}" />
											{/if}
										{/if}
									&nbsp;
									</td>

									<td style="border-bottom:1px solid silver" style="text-align: center;">
										{if $subentity.valid_privileges & $privileges_delete}
											{if (isset($subentity.set_privileges)) && ($subentity.set_privileges & $privileges_delete) }
												<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_delete}" checked="checked" />
											{else}
												<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_delete}" />
											{/if}
										{/if}
									&nbsp;
									</td>

									<td style="border-bottom:1px solid silver" style="text-align: center;">
										{if $subentity.valid_privileges & $privileges_update}
											{if (isset($subentity.set_privileges)) && ($subentity.set_privileges & $privileges_update) }
												<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_update}" checked="checked" />
											{else}
												<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_update}" />
											{/if}
										{/if}
									&nbsp;
									</td>

									<td style="border-bottom:1px solid silver" style="text-align: center;">
										{if $subentity.valid_privileges & $privileges_restore}
											{if (isset($subentity.set_privileges)) && ($subentity.set_privileges & $privileges_restore) }
												<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_restore}" checked="checked" />
											{else}
												<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_restore}" />
											{/if}
										{/if}
									&nbsp;
									</td>

								</tr>

								{/foreach}
							{/if}

							{/foreach}
						</table>

						<!-- vypis prav pre moduly -->

						{foreach key=module_name item=module_entities from=$privileges_modules}

							<br />

							<table border="0" width=400 cellpadding=0 cellspacing=0 style="border:1px solid gray">

								<thead>

									<caption>Modul {$module_name}</caption>

									<tr style="background-color:silver">
										<th>{insert name='tr' value='Logicka Entita'}</th>
										<th>{insert name='tr' value='Access'}</th>
										<th>{insert name='tr' value='View'}</th>
										<th>{insert name='tr' value='Add'}</th>
										<th>{insert name='tr' value='Delete'}</th>
										<th>{insert name='tr' value='Update'}</th>
										<th>{insert name='tr' value='Restore'}</th>
									</tr>

								</thead>

								</tbody>

									{foreach item=entity from=$module_entities}

										<tr>
											<td style="padding-left: 5px; padding-right: 5px;">{$entity.name}</td>

											<td style="text-align: center;">
												{if $entity.valid_privileges & $privileges_access}
													{if (isset($entity.set_privileges)) && ($entity.set_privileges & $privileges_access) }
														<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_access}" checked="checked" />
													{else}
														<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_access}" />
													{/if}
												{/if}
									     &nbsp;
											</td>

											<td style="text-align: center;">
												{if $entity.valid_privileges & $privileges_view}
													{if (isset($entity.set_privileges)) && ($entity.set_privileges & $privileges_view) }
														<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_view}" checked="checked" />
													{else}
														<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_view}" />
													{/if}
												{/if}
									     &nbsp;
											</td>

											<td style="text-align: center;">
												{if $entity.valid_privileges & $privileges_add}
													{if (isset($entity.set_privileges)) && ($entity.set_privileges & $privileges_add) }
														<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_add}" checked="checked" />
													{else}
														<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_add}" />
													{/if}
												{/if}
									     &nbsp;
											</td>

											<td style="text-align: center;">
												{if $entity.valid_privileges & $privileges_delete}
													{if (isset($entity.set_privileges)) && ($entity.set_privileges & $privileges_delete) }
														<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_delete}" checked="checked" />
													{else}
														<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_delete}" />
													{/if}
												{/if}
									     &nbsp;
											</td>

											<td style="text-align: center;">
												{if $entity.valid_privileges & $privileges_update}
													{if (isset($entity.set_privileges)) && ($entity.set_privileges & $privileges_update) }
														<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_update}" checked="checked" />
													{else}
														<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_update}" />
													{/if}
												{/if}
									     &nbsp;
											</td>

											<td style="text-align: center;">
												{if $entity.valid_privileges & $privileges_restore}
													{if (isset($entity.set_privileges)) && ($entity.set_privileges & $privileges_restore) }
														<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_restore}" checked="checked" />
													{else}
														<input class=noborder type="checkbox" name="privileges[{$entity.id}][]" value="{$privileges_restore}" />
													{/if}
												{/if}
									     &nbsp;
											</td>

										</tr>

										{if isset($entity.subentities)}
											{foreach item=subentity from=$entity.subentities}

												<tr>
													<td style="border-bottom:1px solid silver"  style="padding-left: 20px; padding-right: 5px;">{$subentity.name}</td>

													<td style="border-bottom:1px solid silver"  style="text-align: center;">
														{if $subentity.valid_privileges & $privileges_access}
															{if (isset($subentity.set_privileges)) && ($subentity.set_privileges & $privileges_access) }
																<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_access}" checked="checked" />
															{else}
																<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_access}" />
															{/if}
														{/if}
									         &nbsp;
													</td>

													<td style="border-bottom:1px solid silver"  style="text-align: center;">
														{if $subentity.valid_privileges & $privileges_view}
															{if (isset($subentity.set_privileges)) && ($subentity.set_privileges & $privileges_view) }
																<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_view}" checked="checked" />
															{else}
																<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_view}" />
															{/if}
														{/if}
									         &nbsp;
													</td>

													<td style="border-bottom:1px solid silver"  style="text-align: center;">
														{if $subentity.valid_privileges & $privileges_add}
															{if (isset($subentity.set_privileges)) && ($subentity.set_privileges & $privileges_add) }
																<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_add}" checked="checked" />
															{else}
																<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_add}" />
															{/if}
														{/if}
									         &nbsp;
													</td>

													<td style="border-bottom:1px solid silver"  style="text-align: center;">
														{if $subentity.valid_privileges & $privileges_delete}
															{if (isset($subentity.set_privileges)) && ($subentity.set_privileges & $privileges_delete) }
																<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_delete}" checked="checked" />
															{else}
																<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_delete}" />
															{/if}
														{/if}
									         &nbsp;
													</td>

													<td style="border-bottom:1px solid silver"  style="text-align: center;">
														{if $subentity.valid_privileges & $privileges_update}
															{if (isset($subentity.set_privileges)) && ($subentity.set_privileges & $privileges_update) }
																<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_update}" checked="checked" />
															{else}
																<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_update}" />
															{/if}
														{/if}
									         &nbsp;
													</td>

													<td style="border-bottom:1px solid silver"  style="text-align: center;">
														{if $subentity.valid_privileges & $privileges_restore}
															{if (isset($subentity.set_privileges)) && ($subentity.set_privileges & $privileges_restore) }
																<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_restore}" checked="checked" />
															{else}
																<input class=noborder type="checkbox" name="privileges[{$subentity.id}][]" value="{$privileges_restore}" />
															{/if}
														{/if}
									         &nbsp;
													</td>

												</tr>

											{/foreach}
										{/if}

									{/foreach}

								</tbody>
							</table>

						{/foreach}

            </form>
						<!--/ vypis prav pre moduly -->



					</div>

					<div id="blok2" style="display: none;">
						<form name="form3" id="form3" method="post" action="action.php">
							<input type="hidden" name="section" id="section" value="user" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$user_detail->getId()}" />
							<input type="hidden" name="act" id="act" value="update" />
							<input type="hidden" id="showtable" name="showtable" value="2" />
							<input type="hidden" name="category_privileges" value="null" />

							<table>
								<tr>
									<td>{$tree_menu}</td>
									<td valign=top style="font-size:13px;">
										{insert name='tr' value='Poznámka:'}
										<div style="font-size:13px;padding:4px;color:red">
											{insert name='tr' value='Označte kategórie, ktoré sú zakázané pre používateľa'}
										</div>
									</td>
								</tr>
							</table>
						</form>
					</div>


					<!-- tab prava na clanky -->

					<div id="blok3" style="display: none;">

						<form name="form4" id="form4" method="post" action="action.php">
							<input type="hidden" name="section" id="section" value="user" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$user_detail->getId()}" />
							<input type="hidden" name="act" id="act" value="update" />
							<input type="hidden" id="showtable" name="showtable" value="3" />
							<input type="hidden" name="article_privileges" value="null" />

							<table>
							<tr>
							<td>
							<table border="0" cellpadding="2" cellspacing="1" bgcolor="#d0d0d0">

								{foreach item=article from=$privileges_article_list}

									{if $article.privilege_set eq 1}
										{assign var="checked" value='checked="checked"'}
									{else}
										{assign var="checked" value=''}
									{/if}

									<tr>
										<td><input type="checkbox" name="article_privileges[]" value="{$article.article_object->getId()}" {$checked} /></td>
										<td>{$article.article_object->getTitle()}</td>
									</tr>

								{/foreach}

							</table>
							</td>
							<td valign=top style="font-size:13px;">
								{insert name='tr' value='Poznámka:'}
								<div style="font-size:13px;padding:4px;color:red">
									{insert name='tr' value='Označte články, ktoré sú zakázané pre používateľa'}
								</div>
							</td>
							</table>
						</form>

					</div>

					<!-- tab prava na menu -->

					<div id="blok4" style="display: none;">

						<form name="form5" id="form5" method="post" action="action.php">
							<input type="hidden" name="section" id="section" value="user" />
							<input type="hidden" name="cmd" id="cmd" value="{$cmd}" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="{$user_detail->getId()}" />
							<input type="hidden" name="act" id="act" value="update" />
							<input type="hidden" id="showtable" name="showtable" value="4" />
							<input type="hidden" name="menu_privileges" value="null" />

							<table>
							<tr>
							<td>
							<table border="0" cellpadding="2" cellspacing="1" bgcolor="#d0d0d0">

								{foreach item=menu from=$privileges_menu_list}

									{if $menu.privilege_set eq 1}
										{assign var="checked" value='checked="checked"'}
									{else}
										{assign var="checked" value=''}
									{/if}

									<tr>
										<td><input type="checkbox" name="menu_privileges[]" value="{$menu.menu_object->getId()}" {$checked} /></td>
										<td>{$menu.menu_object->getTitle()}</td>
									</tr>

								{/foreach}

							</table>
							</td>
							<td valign=top style="font-size:13px;">
								{insert name='tr' value='Poznámka:'}
								<div style="font-size:13px;padding:4px;color:red">
									{insert name='tr' value='Označte menu, ktoré je zakázané pre používateľa'}
								</div>
							</td>
							</table>
						</form>

					</div>

					{/if}

				</td>


			</tr>
		</table>


		<br />
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>
<script language="JavaScript" type="text/javascript">
	ukaz('{$showtable}','1')
</script>
