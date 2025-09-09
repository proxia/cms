<?php /* Smarty version 2.6.30, created on 2019-05-17 10:20:01
         compiled from product_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'tr', 'product_edit.tpl', 104, false),array('insert', 'check', 'product_edit.tpl', 153, false),array('insert', 'merge', 'product_edit.tpl', 162, false),array('insert', 'makeCalendar', 'product_edit.tpl', 244, false),array('insert', 'getExistsAttribut', 'product_edit.tpl', 308, false),array('insert', 'getOptionListBranch', 'product_edit.tpl', 457, false),array('insert', 'getAvailableCurrencies', 'product_edit.tpl', 620, false),array('insert', 'getSelectedGroup', 'product_edit.tpl', 788, false),array('modifier', 'date_format', 'product_edit.tpl', 754, false),)), $this); ?>
<?php echo '
<script language="JavaScript" type="text/javascript">

function listItemTask(the_form,min,max,act_type,act_value,act_type2,act_value2){
	submitform2(the_form,act_type,act_value,act_type2,act_value2)
}

function addelement2(the_form,act_type,act_value){
	var newelement = document.createElement(\'INPUT\');
	newelement.type = \'hidden\';
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
	var newelement = document.createElement(\'INPUT\');
	newelement.type = \'hidden\';
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

'; ?>

<?php $_from = $this->_tpl_vars['LanguageList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_id']):
        $this->_foreach['language']['iteration']++;
?>
<?php if ($this->_tpl_vars['language_id']['local_visibility']): ?>
	<?php echo $this->_tpl_vars['detail_product']->setContextLanguage($this->_tpl_vars['language_id']['code']); ?>

		hiddenlang('lang<?php echo $this->_tpl_vars['language_id']['code']; ?>
');
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>

<?php echo '

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
	  	'; ?>

        alert("<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Nezadali ste povinnú položku')), $this); ?>
 !");
		<?php echo '
		form.p__title.focus();
        return false;
        }

	   if(p__file==""){
	   '; ?>

        alert("<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Nezadali ste povinnú položku')), $this); ?>
 !");
		<?php echo '
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
'; ?>

<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'check')), $this); ?>

<?php $this->assign('title', 'Produkt / detail'); ?>
<table class="tb_middle">
	<tr>
		<td colspan="3"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "title_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	<tr>
		<td class="td_middle_left">
		<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'merge', 'value1' => $this->_tpl_vars['path_relative'], 'value2' => 'themes/default/scripts/toolbar.php', 'assign' => 'path_toolbar')), $this); ?>

		<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => $this->_tpl_vars['path_toolbar'], 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

		</td>
		<td class="td_link_h"><img src="../themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
		<table width="100%">
			<tr>
				<td class="td_valign_top">

			<table class="tb_list">

				<tr class="tr_header">
					<td colspan="2">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Detail produktu')), $this); ?>
</td>
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />
				<input type="hidden" id="section" name="section" value="product" />
				<input type="hidden" id="only_detail" name="only_detail" value="true" />
				<input type="hidden" id="showtable" name="showtable" value="0" />
				<input type="hidden" name="act" id="act" value="update" />
				<?php echo $this->_tpl_vars['detail_product']->setContextLanguage(($this->_tpl_vars['localLanguage'])); ?>

				<tr><td colspan="2" class="td_link_space"></td></tr>
				<tr>
					<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Kód')), $this); ?>
*</td>
					<td width="85%"><input size="30" type="text" name="f_code" id="f_code" value="<?php echo $this->_tpl_vars['detail_product']->getCode(); ?>
" /></td>
				</tr>
				<tr>
					<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov')), $this); ?>
*</td>
					<td width="85%"><input size="60" type="text" name="f_title" id="f_title" value="<?php echo $this->_tpl_vars['detail_product']->getTitle(); ?>
" /></td>
				</tr>
				<tr>
					<td class="td_valign_top">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Popis')), $this); ?>
</td>
					<td width="85%"><textarea style="width:100%" name="f_description" id="f_description" rows="15" cols="60"><?php echo $this->_tpl_vars['detail_product']->getDescription(); ?>
</textarea></td>
				</tr>
				<tr>
					<td class="td_valign_top">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Popis 2')), $this); ?>
</td>
					<td width="85%"><textarea style="width:100%" name="f_descriptionExtended" id="f_descriptionExtended" rows="20" cols="60"><?php echo $this->_tpl_vars['detail_product']->getDescriptionExtended(); ?>
</textarea></td>
				</tr>
			</table>
					<?php $_from = $this->_tpl_vars['LanguageListLocal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_id']):
        $this->_foreach['language']['iteration']++;
?>
						<?php if ($this->_tpl_vars['language_id']['local_visibility']): ?>
							<?php echo $this->_tpl_vars['detail_product']->setContextLanguage($this->_tpl_vars['language_id']['code']); ?>

										<div id="lang<?php echo $this->_tpl_vars['language_id']['code']; ?>
" style="display:none">
								<div class="ukazkaJazyka">
									<span class="bold"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Jazyk')), $this); ?>
:&nbsp;</span>
									<span class="nadpis"><?php echo $this->_tpl_vars['language_id']['code']; ?>
</span><br /><br />
									<span class="bold"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov')), $this); ?>
:</span><br />
									<?php echo $this->_tpl_vars['detail_product']->getTitle(); ?>
<br /><br />
									<span class="bold"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Popis')), $this); ?>
:</span><br />
									<?php echo $this->_tpl_vars['detail_product']->getDescription(); ?>
<br /><br />
									<span class="bold"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Popis 2')), $this); ?>
:</span><br />
									<?php echo $this->_tpl_vars['detail_product']->getDescriptionExtended(); ?>
<br />
								</div>
								</div>
								<br />
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>

			</td>
			<td class="td_valign_top" width="500">

				<table align="center" class="tb_tabs">
				<tr><td colspan="2"><br /></td></tr>
				<tr class="tr_header_tab">
					<td colspan="2" class="td_tabs_top">
					<?php echo $this->_tpl_vars['menu']; ?>

					</td>
				</tr>
				<tr><td class="td_valign_top" colspan="2">

							<div id="item1" style="visibility: hidden;">
							<table class="tb_list_in_tab">
								<tr class="tr_header">
									<td colspan="4">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Detailné nastavenia')), $this); ?>
</td>
								</tr>
								<tr>
									<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Viditeľnosť')), $this); ?>
</td>
									<td width="50%" colspan="3"><input type="checkbox" name="f_isPublished" id="f_isPublished" value="1" <?php if ($this->_tpl_vars['detail_product']->getIsPublished() == 1): ?>checked="checked"<?php endif; ?> /></td>
								</tr>
								<tr>
									<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Platnosť od')), $this); ?>
</td>
									<td width="50%" colspan="3"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'makeCalendar', 'nazov' => 'f_valid_from', 'value' => $this->_tpl_vars['detail_product']->getValidFrom())), $this); ?>
</td>
								</tr>
								<tr>
									<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Platnosť do')), $this); ?>
</td>
									<td width="50%" colspan="3"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'makeCalendar', 'nazov' => 'f_valid_to', 'value' => $this->_tpl_vars['detail_product']->getValidTo())), $this); ?>
</td>
								</tr>
								<tr>
									<td valign="top">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zobrazovacie&nbsp;práva')), $this); ?>
</td>
									<td colspan="3">
										<select name="f_access" id="f_access">
											<option value="<?php echo $this->_tpl_vars['ACCESS_PUBLIC']; ?>
" <?php if ($this->_tpl_vars['detail_product']->getAccess() == $this->_tpl_vars['ACCESS_PUBLIC']): ?>selected="selected"<?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Verejné')), $this); ?>
</option>
											<option value="<?php echo $this->_tpl_vars['ACCESS_REGISTERED']; ?>
" <?php if ($this->_tpl_vars['detail_product']->getAccess() == $this->_tpl_vars['ACCESS_REGISTERED']): ?>selected="selected"<?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Registrovaným')), $this); ?>
</option>
											<option value="<?php echo $this->_tpl_vars['ACCESS_SPECIAL']; ?>
" <?php if ($this->_tpl_vars['detail_product']->getAccess() == $this->_tpl_vars['ACCESS_SPECIAL']): ?>selected="selected"<?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Skupiny používateľov')), $this); ?>
</option>
										</select>
									</td>
								</tr>
								<?php 
									$path = "../mediafiles/".$GLOBALS['smarty']->get_template_vars(detail_product)->getImage();
									$name = basename($path);
									$GLOBALS["smarty"]->assign("icon_name",$name);
									$GLOBALS["smarty"]->assign("icon_path",$path);
								 ?>
								<tr>
									<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Obrázok')), $this); ?>
</td>
									<td width="30%"><input size=35 type="text" name="f_image" id="f_image" value="<?php echo $this->_tpl_vars['detail_product']->getImage(); ?>
" /></td>
                 					<td width=22><a href="javascript:insertfile('form1','f_image')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vlož obrázok')), $this); ?>
"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
									<?php if (( $this->_tpl_vars['detail_product']->getImage() == '' )): ?>
                     					<td width=22>&nbsp;</td>
                  					<?php else: ?>
                      					<td width=22>&nbsp;<a  href="<?php echo $this->_tpl_vars['icon_path']; ?>
" target="_blank" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ukáž')), $this); ?>
"><img src="../themes/default/images/view_s.png" border="0"></a></td>
                  					<?php endif; ?>
                  				</tr>
								<tr>
									<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Video')), $this); ?>
 (flv,mov,wmv)</td>
									<td width="30%"><input size=35 type="text" name="f_video" id="f_video" value="<?php echo $this->_tpl_vars['detail_product']->getVideo(); ?>
" /></td>
                 					<td width=22><a href="javascript:insertfile('form1','f_video')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'prilep cestu k video')), $this); ?>
"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
                  				</tr>
							</table>
							</form>
							</div>

							<div id="item2" style="visibility: hidden;">
							<table class="tb_list_in_tab">
							<form name="form2" id="form2" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" name="cmd" id="cmd" value="<?php echo $this->_tpl_vars['cmd']; ?>
" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="1" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />
								<tr class="tr_header">
										<td colspan="6">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Priradenie k atribútu')), $this); ?>
</td>
								</tr>
								<tr><td colspan="6"><br><br></td></tr>
								<tr>
									<td>&nbsp;&nbsp;
										<select name="add_attribut_id">
											<option value="0"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vyberte atribút')), $this); ?>
</option>
											<?php $_from = $this->_tpl_vars['attribut_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['attribut'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attribut']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['attribut_id']):
        $this->_foreach['attribut']['iteration']++;
?>
												<?php echo $this->_tpl_vars['attribut_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

												<?php $this->assign('defaultView', 0); ?>
												<?php if (( $this->_tpl_vars['attribut_id']->getTitle() == '' )): ?>
													<?php echo $this->_tpl_vars['attribut_id']->setContextLanguage($this->_tpl_vars['localLanguageDefault']); ?>

													<?php $this->assign('defaultView', 1); ?>
												<?php endif; ?>
												<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getExistsAttribut', 'productId' => $this->_tpl_vars['detail_product']->getId(), 'attributId' => $this->_tpl_vars['attribut_id']->getId(), 'assign' => 'is_existsAttribut')), $this); ?>

												<?php if (( ! $this->_tpl_vars['is_existsAttribut'] )): ?>
													<option value="<?php echo $this->_tpl_vars['attribut_id']->getId(); ?>
">
													<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
														<?php echo $this->_tpl_vars['attribut_id']->getTitle(); ?>

													<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
													</option>
												<?php endif; ?>
											<?php endforeach; endif; unset($_from); ?>
										</select>

									</td>
									<td><input type="text" name="add_attribut_value" id="add_attribut_value" size="30" maxlength="255"></td>
									<td></td>
									<td class="td_align_center"></td>
									<td></td>
								</tr>
								<tr>
									<td>&nbsp;&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'obrázok hodnoty')), $this); ?>
 (<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'nepoviné')), $this); ?>
)</td>
									<td>
										<input size="30" type="text" name="add_attribut_value_image" id="add_attribut_value_image" />
									</td>
									<td><a href="javascript:insertfile('form2','add_attribut_value_image')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vlož obrázok')), $this); ?>
"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td>
									<?php $this->assign('showItemEdit', 0); ?>

									<?php if (( $this->_tpl_vars['user_login']->checkPrivilege(1050002,$this->_tpl_vars['privilege_update']) == 1 )): ?>
										<?php $this->assign('showItemEdit', 1); ?>
									<?php else: ?>
										<?php $this->assign('showItemEdit', 0); ?>
									<?php endif; ?>

									<?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
										<?php $this->assign('showItemEdit', 1); ?>
									<?php endif; ?>
									<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
										<input class="button" type="submit" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Priraď k produktu')), $this); ?>
" />
									<?php endif; ?>
									</td>
								</tr>
								<tr><td colspan="6"><br><br></td></tr>
							</form>
							<tr>
								<td colspan="6">
								<table>
								<tr class="tr_header">
									<td colspan="4">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zoznam atribútov')), $this); ?>
</td>
									<td  class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zmazať')), $this); ?>
</td>
									<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Poradie')), $this); ?>
</td>
								</tr>
							<form method="post" id="attribut" name="attribut" action="/vendor/cms_modules/cms_catalog/action.php" >
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" name="cmd" id="cmd" value="<?php echo $this->_tpl_vars['cmd']; ?>
" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />
							<input type="hidden" id="showtable" name="showtable" value="1" />
							<input type="hidden" id="update_attribut" name="update_attribut" value="1" />
								<?php $_from = $this->_tpl_vars['attribut_product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['attribut_product'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attribut_product']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['attribut_product_id']):
        $this->_foreach['attribut_product']['iteration']++;
?>
								<?php endforeach; endif; unset($_from); ?>
								<?php $this->assign('max_list', $this->_foreach['attribut_product']['iteration']); ?>

								<?php $_from = $this->_tpl_vars['attribut_product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['attribut_product'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attribut_product']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['attribut_product_id']):
        $this->_foreach['attribut_product']['iteration']++;
?>

								<?php echo $this->_tpl_vars['attribut_product_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>


								<?php if (strlen ( $this->_tpl_vars['attribut_product_id']->getValue() ) == 0): ?>
									<?php echo $this->_tpl_vars['attribut_product_id']->setContextLanguage($this->_tpl_vars['localLanguageDefault']); ?>

								<?php endif; ?>

								<?php $this->assign('attribut_name', $this->_tpl_vars['attribut_product_id']->getAttributeDefinitionId()); ?>
								<tr>
									<td class="bold">&nbsp;&nbsp;<?php echo $this->_tpl_vars['attribut_product_list_title'][$this->_tpl_vars['attribut_name']]; ?>
</td>
									<td colspan="2"><input type="text" name="update_attribut_value[<?php echo $this->_tpl_vars['attribut_product_id']->getId(); ?>
]" id="add_attribut_value" size="30" maxlength="255" value="<?php echo $this->_tpl_vars['attribut_product_id']->getValue(); ?>
"></td>
									<td></td>
									<td class="td_align_center"><input type="checkbox" name="remove_attribut_id[]" id="remove_attribut_id" value="<?php echo $this->_tpl_vars['attribut_product_id']->getId(); ?>
"></td>
									<td class="td_align_center">
				   						<?php if ($this->_foreach['attribut_product']['iteration'] != $this->_tpl_vars['max_list']): ?>
				   							<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
				       							<a href="#" onclick="listItemTask('attribut',1,<?php echo $this->_tpl_vars['max_list']; ?>
,'move_down_attribut',<?php echo $this->_tpl_vars['attribut_product_id']->getId(); ?>
,'section','product')"><img alt="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'posuň smerom dole')), $this); ?>
" src="../themes/default/images/downarrow.png" /></a>
				   							<?php else: ?>
				   								<img alt="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'posuň smerom dole')), $this); ?>
" src="../themes/default/images/downarrow.png" />
				   							<?php endif; ?>
				   						<?php endif; ?>
				   						<?php if (( $this->_foreach['attribut_product']['iteration'] != $this->_tpl_vars['max_list'] ) && ( $this->_foreach['attribut_product']['iteration'] != 1 )): ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endif; ?>
				   						<?php if ($this->_foreach['attribut_product']['iteration'] != 1): ?>
				   							<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
				   								<a href="#" onclick="listItemTask('attribut',1,<?php echo $this->_tpl_vars['max_list']; ?>
,'move_up_attribut',<?php echo $this->_tpl_vars['attribut_product_id']->getId(); ?>
,'section','product')"><img alt="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'posuň smerom hore')), $this); ?>
" src="../themes/default/images/uparrow.png" /></a>
				   							<?php else: ?>
				   								<img alt="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'posuň smerom hore')), $this); ?>
" src="../themes/default/images/uparrow.png" />
				   							<?php endif; ?>
				   						<?php endif; ?>
				   					</td>
								</tr>
								<?php 
									$path = "../mediafiles/".$GLOBALS['smarty']->get_template_vars(attribut_product_id)->getImage();
									$name = basename($path);
									$GLOBALS["smarty"]->assign("icon_name",$name);
									$GLOBALS["smarty"]->assign("icon_path",$path);
								 ?>
								<tr>
									<td>&nbsp;&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'obrázok hodnoty')), $this); ?>
</td>
									<td>
										<input size="30" type="text" name="update_attribut_value_image[<?php echo $this->_tpl_vars['attribut_product_id']->getId(); ?>
]" id="attribut_image<?php echo $this->_tpl_vars['attribut_product_id']->getId(); ?>
" value="<?php echo $this->_tpl_vars['attribut_product_id']->getImage(); ?>
" />

									</td>
									<td><a href="javascript:insertfile('attribut','attribut_image<?php echo $this->_tpl_vars['attribut_product_id']->getId(); ?>
')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vlož obrázok')), $this); ?>
"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
									<?php if (( $this->_tpl_vars['attribut_product_id']->getImage() == '' )): ?>
           					<td width=22>&nbsp;</td>
        					<?php else: ?>
            					<td width=22>&nbsp;<a  href="<?php echo $this->_tpl_vars['icon_path']; ?>
" target="_blank" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ukáž')), $this); ?>
"><img src="../themes/default/images/view_s.png" border="0"></a></td>
        					<?php endif; ?>
									<td></td>
									<td></td>
								</tr>
								<tr><td colspan="6"><hr></td></tr>

								<?php endforeach; endif; unset($_from); ?>

								<tr><td colspan="6"  class="td_align_center"><br>
								<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
								<input type="button" class="button" onclick="checkdeleteAttribute('attribut','<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zapísať zmeny ')), $this); ?>
 ?')" name="attach_update" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zapíš zmeny v atribútoch')), $this); ?>
">
								<?php endif; ?>
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
							<input type="hidden" name="mcmd" id="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="2" />
								<tr class="tr_header">
										<td colspan="2">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Priradenie ku kategórii')), $this); ?>
</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
										<select name="map_to_branch">
											<option value="0"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vyberte si kategóriu')), $this); ?>
</option>
											<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getOptionListBranch', 'catalog' => '$catalog_id', 'select' => 0)), $this); ?>

										</select>
									</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
									<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
										<br /><input class="button" type="submit" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Priraď ku kategórii')), $this); ?>
" /><br /><br />
									<?php endif; ?>
									</td>
								</tr>
							</form>
								<tr class="tr_header">
									<td colspan="2">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zoznam priradení')), $this); ?>
</td>
								</tr>
								<?php $_from = $this->_tpl_vars['category_list_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['category_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['category_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['category_item_id']):
        $this->_foreach['category_list']['iteration']++;
?>
									<?php echo $this->_tpl_vars['category_item_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

									<?php $this->assign('defaultView', 0); ?>
									<?php if (( $this->_tpl_vars['category_item_id']->getTitle() == '' )): ?>
										<?php echo $this->_tpl_vars['category_item_id']->setContextLanguage($this->_tpl_vars['localLanguageDefault']); ?>

										<?php $this->assign('defaultView', 1); ?>
									<?php endif; ?>
							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" onsubmit="return checkdelete('<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Naozaj chcete vymazať väzbu produktu s kategóriou ')), $this); ?>
<?php echo $this->_tpl_vars['category_item_id']->getTitle(); ?>
 ?')">
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" name="cmd" id="cmd" value="<?php echo $this->_tpl_vars['cmd']; ?>
" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />
							<input type="hidden" id="unmap_to_branch" name="unmap_to_branch" value="<?php echo $this->_tpl_vars['category_item_id']->getId(); ?>
" />
							<input type="hidden" id="showtable" name="showtable" value="2" />
								<tr>
									<td width="150">&nbsp;&nbsp;
									<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
										<?php echo $this->_tpl_vars['category_item_id']->getTitle(); ?>

									<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
									</td>
									<td width="200">
									<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
									<input class="noborder" type="image" src="../themes/default/images/form_delete.gif" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'zmazať')), $this); ?>
">
									<?php endif; ?>
									</td>
								</tr>
							</form>
								<?php endforeach; endif; unset($_from); ?>
							</table>
							</div>
							<div id="item4" style="visibility: hidden;">

							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" name="lang">
							<input type="hidden" name="mcmd" id="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" id="showtable" name="showtable" value="3" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />
							<input type="hidden" name="language_visibility" id="language_visibility" value="1" />
							<table class="tb_list_in_tab" >
								<tr class="tr_header">
									<td colspan="3">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Jazykové verzie')), $this); ?>
</td>
								</tr>
								<tr>
									<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov')), $this); ?>
</td>
									<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Viditeľnosť')), $this); ?>
</td>
									<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Náhľad')), $this); ?>
</td>
								</tr>
								<?php $_from = $this->_tpl_vars['LanguageListLocal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_id']):
        $this->_foreach['language']['iteration']++;
?>
								<?php echo $this->_tpl_vars['detail_product']->setContextLanguage($this->_tpl_vars['language_id']['code']); ?>

								<tr>
									<td>&nbsp;<?php echo $this->_tpl_vars['language_id']['code']; ?>
</td>
									<td><input type="checkbox" name="a_languageIsVisible<?php echo $this->_tpl_vars['language_id']['code']; ?>
" id="f_languageIsVisible<?php echo $this->_tpl_vars['language_id']['code']; ?>
" value="1" <?php if ($this->_tpl_vars['detail_product']->getLanguageIsVisible() == 1): ?>checked="checked"<?php endif; ?> /></td>
									<td><a title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ukáž')), $this); ?>
" href="javascript:ukazlang('lang<?php echo $this->_tpl_vars['language_id']['code']; ?>
')"><img src="../themes/default/images/view_s.png" /></td>
								</tr>
								<?php endforeach; endif; unset($_from); ?>
								<tr>
									<td></td>
									<td class="td_center" colspan="2"><br />
									<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
										<input class="button" type="submit" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zmeniť nastavenie')), $this); ?>
" />
									<?php endif; ?>
									</td>
								</tr>

							</table>
								</form>

							</div>

							<div id="item5" style="visibility: hidden;">
							<table class="tb_list_in_tab">
							<form name="form3" id="form3" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" name="mcmd" id="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="4" />
								<tr class="tr_header">
										<td colspan="2">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Priradenie fotogalérie')), $this); ?>
</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
										<select name="map_gallery">
											<option value="0"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vyberte si fotogalériu')), $this); ?>
</option>
											<?php $_from = $this->_tpl_vars['gallery_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['gallery_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gallery_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['gallery_id']):
        $this->_foreach['gallery_list']['iteration']++;
?>
												<?php echo $this->_tpl_vars['gallery_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

												<?php $this->assign('defaultView', 0); ?>
												<?php if (( $this->_tpl_vars['gallery_id']->getTitle() == '' )): ?>
													<?php echo $this->_tpl_vars['gallery_id']->setContextLanguage($this->_tpl_vars['localLanguageDefault']); ?>

													<?php $this->assign('defaultView', 1); ?>
												<?php endif; ?>
												<option value="<?php echo $this->_tpl_vars['gallery_id']->getId(); ?>
"><?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?><?php echo $this->_tpl_vars['gallery_id']->getTitle(); ?>
<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?></option>
											<?php endforeach; endif; unset($_from); ?>
										</select>
									</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
									<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
										<br /><input class="button" type="submit" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Priraď ku galérii')), $this); ?>
" /><br /><br />
									<?php endif; ?>
									</td>
								</tr>
							</form>
								<tr class="tr_header">
									<td colspan="2">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zoznam priradení')), $this); ?>
</td>
								</tr>
								<?php $_from = $this->_tpl_vars['gallery_list_product']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['gallery_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gallery_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['gallery_id']):
        $this->_foreach['gallery_list']['iteration']++;
?>
									<?php echo $this->_tpl_vars['gallery_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

									<?php $this->assign('defaultView', 0); ?>
									<?php if (( $this->_tpl_vars['gallery_id']->getTitle() == '' )): ?>
										<?php echo $this->_tpl_vars['gallery_id']->setContextLanguage($this->_tpl_vars['localLanguageDefault']); ?>

										<?php $this->assign('defaultView', 1); ?>
									<?php endif; ?>
							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" onsubmit="return checkdelete('<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Naozaj chcete vymazať väzbu produktu s galérie ')), $this); ?>
 ?')">
							<input type="hidden" name="section" id="section" value="product" />
							<input type="hidden" name="cmd" id="cmd" value="<?php echo $this->_tpl_vars['cmd']; ?>
" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />
							<input type="hidden" id="unmap_to_branch" name="unmap_gallery" value="<?php echo $this->_tpl_vars['gallery_id']->getId(); ?>
" />
							<input type="hidden" id="showtable" name="showtable" value="4" />
								<tr>
									<td width="150">&nbsp;&nbsp;
									<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
										<?php echo $this->_tpl_vars['gallery_id']->getTitle(); ?>

									<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
									</td>
									<td width="200">
									<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
									<input class="noborder" type="image" src="../themes/default/images/form_delete.gif" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'zmazať')), $this); ?>
">
									<?php endif; ?>
									</td>
								</tr>
							</form>
								<?php endforeach; endif; unset($_from); ?>
							</table>
							</div>

							<div id="item6" style="visibility: hidden;">

							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" name="lang">
							<input type="hidden" name="mcmd" id="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
							<input type="hidden" name="section" id="section" value="product_price" />
							<input type="hidden" id="showtable" name="showtable" value="5" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="product_id" id="product_id" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />

							<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getAvailableCurrencies', 'assign' => 'currencies')), $this); ?>


							<?php if (( $this->_tpl_vars['user_login']->checkPrivilege(1050002,$this->_tpl_vars['privilege_update']) == 1 )): ?>
	                <?php $this->assign('showItemEdit', 1); ?>
	            <?php else: ?>
	                <?php $this->assign('showItemEdit', 0); ?>
	            <?php endif; ?>
	            <?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
	                <?php $this->assign('showItemEdit', 1); ?>
	            <?php endif; ?>
							<table class="tb_list_in_tab">
								<tr class="tr_header">
									<td colspan="4">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Nová cena')), $this); ?>
</td>
								</tr>
								<tr>
									<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Viditeľnosť ceny')), $this); ?>
</td>
									<td width="50%" colspan="3"><input type="checkbox" name="priceIsPublished" id="priceIsPublished" value="1" checked /></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Cena')), $this); ?>
</td>
									<td colspan="3">
										<input type="text" name="new_price" id="new_price" size="10" value="">
										<select name="price_currency">
										<?php $_from = $this->_tpl_vars['currencies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['currency']):
?>
											<option><?php echo $this->_tpl_vars['currency']; ?>
</option>
										<?php endforeach; endif; unset($_from); ?>
										</select>
									</td>
								</tr>
								<tr>
									<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Platnosť od')), $this); ?>
</td>
									<td width="50%" colspan="3"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'makeCalendar', 'nazov' => 'price_valid_from', 'value' => $this->_tpl_vars['detail_product']->getValidFrom())), $this); ?>
</td>
								</tr>
								<tr>
									<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Platnosť do')), $this); ?>
</td>
									<td width="50%" colspan="3"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'makeCalendar', 'nazov' => 'price_valid_to', 'value' => $this->_tpl_vars['detail_product']->getValidTo())), $this); ?>
</td>
								</tr>
								<tr>
									<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Poznámka k cene')), $this); ?>
</td>
									<td width="50%" colspan="3"><input type="text" name="price_note" id="price_note" size="35" value=""></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zobrazovacie&nbsp;práva')), $this); ?>
</td>
									<td>
										<img src="../themes/default/images/access_public_s.gif">&nbsp;<input type='radio' onclick="showGroups(false,'price_groups')" name='price_access' value='<?php echo $this->_tpl_vars['ACCESS_PUBLIC']; ?>
' checked>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Verejné')), $this); ?>
<br />
										<img src="../themes/default/images/access_registered_s.gif">&nbsp;<input type='radio' onclick="showGroups(false,'price_groups')" name='price_access' value='<?php echo $this->_tpl_vars['ACCESS_REGISTERED']; ?>
' >&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Registrovaným')), $this); ?>
<br />
										<img src="../themes/default/images/access_special_s.gif">&nbsp;<input type='radio' onclick="showGroups(true,'price_groups')" name='price_access' value='<?php echo $this->_tpl_vars['ACCESS_SPECIAL']; ?>
' >&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Skupiny používateľov')), $this); ?>
<br />
										<!-- PRAVA PRE SKUPINY -->
										<div id="price_groups" name="price_groups" style="margin-left:20px;display:none">

										<select multiple size="5" name="price_access_groups[]">
										<?php $_from = $this->_tpl_vars['group_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['group'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['group']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['group_detail']):
        $this->_foreach['group']['iteration']++;
?>
											<?php echo $this->_tpl_vars['group_detail']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

											<option  value="<?php echo $this->_tpl_vars['group_detail']->getId(); ?>
"><?php echo $this->_tpl_vars['group_detail']->getTitle(); ?>
</option>
										<?php endforeach; endif; unset($_from); ?>
										</select>
										</div>
										<!-- PRAVA PRE SKUPINY -->
									</td>
								</tr>
								<tr>
									<td></td>
									<td class="td_center" colspan="2"><br />
									<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
										<input class="button" type="submit" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Vytvoriť novú cenu')), $this); ?>
" />
									<?php endif; ?>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>

								<table class="tb_list_in_tab" border=0>
								<tr class="tr_header">
									<td colspan="3">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Aktuálne ceny pre produkt')), $this); ?>
</td>
								</tr>
								</form>
								<tr class="tr_header">
									<td  class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Viditeľnosť')), $this); ?>
</td>
									<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zoznam cien')), $this); ?>
</td>
									<td  class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zmazať')), $this); ?>
</td>
								</tr>
								<form method="post" id="price" name="price" action="/vendor/cms_modules/cms_catalog/action.php" >
								<input type="hidden" name="section" id="section" value="product_price" />
								<input type="hidden" name="cmd" id="cmd" value="<?php echo $this->_tpl_vars['cmd']; ?>
" />
								<input type="hidden" id="go" name="go" value="edit" />
							  	<input type="hidden" name="product_id" id="product_id" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />
								<input type="hidden" id="showtable" name="showtable" value="5" />
								<input type="hidden" id="update_price" name="update_price" value="1" />

								<?php $_from = $this->_tpl_vars['price_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['price_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['price_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['price_id']):
        $this->_foreach['price_list']['iteration']++;
?>
								<?php 
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
								 ?>

								<tr>

									<td class="td_align_center"><input type="checkbox" name="publish_price_id[]" id="publish_price_id" value="<?php echo $this->_tpl_vars['price_id']->getId(); ?>
" <?php if ($this->_tpl_vars['price_id']->getIsPublished() == 1): ?>checked="checked"<?php endif; ?>></td>
									<td ><input type="text" name="update_price_value[<?php echo $this->_tpl_vars['price_id']->getId(); ?>
]" id="add_price_value" size="10" maxlength="15" value="<?php echo $this->_tpl_vars['price_id']->getPrice(); ?>
"> <?php echo $this->_tpl_vars['price_id']->getCurrency(); ?>
</td>
									<td class="td_align_center"><input type="checkbox" name="remove_price_id[]" id="remove_price_id" value="<?php echo $this->_tpl_vars['price_id']->getId(); ?>
"></td>
								</tr>
								<tr>
									<td colspan=3>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Platnosť od')), $this); ?>
:
									<span style="<?php echo $this->_tpl_vars['color_to']; ?>
">
									<?php if ($this->_tpl_vars['price_id']->getValidFrom()): ?>
										<i><?php echo ((is_array($_tmp=$this->_tpl_vars['price_id']->getValidFrom())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%d.%m.%Y %H:%M:%S")); ?>
</i>
									<?php else: ?>
										-
									<?php endif; ?>
									</span>
									<br>
									&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Platnosť do')), $this); ?>
:
									<span style="<?php echo $this->_tpl_vars['color_to']; ?>
">
									<?php if ($this->_tpl_vars['price_id']->getValidTo()): ?>
										<i><?php echo ((is_array($_tmp=$this->_tpl_vars['price_id']->getValidTo())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%d.%m.%Y %H:%M:%S")); ?>
</i>
									<?php else: ?>
										-
									<?php endif; ?>
									</span>
									</td>
								</tr>
								<tr  >
									<td colspan=3>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Poznámka')), $this); ?>
:
										<span style="<?php echo $this->_tpl_vars['color_to']; ?>
">
										<input type="text" name="price_note[<?php echo $this->_tpl_vars['price_id']->getId(); ?>
]" id="price_note" size="35" maxlength="100" value="<?php echo $this->_tpl_vars['price_id']->getNote(); ?>
">
										</span>
									</td>
								</tr>
								<tr >
									<td colspan=3>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zobrazovacie&nbsp;práva')), $this); ?>
:
									<br>&nbsp;
									<span style="<?php echo $this->_tpl_vars['color_to']; ?>
">
									<i>
									<?php if ($this->_tpl_vars['price_id']->getAccess() == 1): ?>
										<img src="../themes/default/images/access_public_s.gif" align="absmiddle"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Verejné')), $this); ?>

									<?php elseif ($this->_tpl_vars['price_id']->getAccess() == 2): ?>
											<img src="../themes/default/images/access_registered_s.gif" align="absmiddle">	<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Registrovaným')), $this); ?>

									<?php elseif ($this->_tpl_vars['price_id']->getAccess() == 3): ?>
										<img src="../themes/default/images/access_special_s.gif" align="absmiddle"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Skupiny používateľov')), $this); ?>

										<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getSelectedGroup', 'groups' => $this->_tpl_vars['price_id']->getAccessGroups(), 'assign' => 'selected_group')), $this); ?>

										: <?php echo $this->_tpl_vars['selected_group']; ?>

									<?php endif; ?>

									</i>
									</span>
									</td>
								</tr>
								<tr><td colspan="3"><hr></td></tr>

								<?php endforeach; endif; unset($_from); ?>

								<tr><td colspan="3"  class="td_align_center"><br>
								<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
									<input type="submit" class="button" name="attach_update" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Aktualizovať ceny')), $this); ?>
">
								<?php endif; ?>
								<br><br></td></tr>
								</form>
								</table>

							</div>

								<!--PRILOHY-->
								<div id="item7" style="visibility: hidden;">
									<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" name="form_priloha" onSubmit="return checkpriloha('form_priloha')">
									<input type="hidden" name="section" id="section" value="product_attachment" />
									<input type="hidden" name="cmd" id="cmd" value="<?php echo $this->_tpl_vars['cmd']; ?>
" />
									<input type="hidden" id="go" name="go" value="edit" />
								  <input type="hidden" name="product_id" id="product_id" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />
									<input type="hidden" id="showtable" name="showtable" value="6" />
									<input type="hidden" id="add_attachment" name="add_attachment" value="1" />

									<table class="tb_list_in_tab" align="left">

										<tr class="tr_header">
											<td colspan="3">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Prílohy')), $this); ?>
</td>
										</tr>
										<tr>
											<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov')), $this); ?>
</td>
											<td colspan="2"><input type="text" name="p__title" id="p__title" size="30" /></td>
										</tr>
										<tr>
											<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Príloha')), $this); ?>
</td>
											<td>
												<input type="text" name="p__file" id="p__file" size="40" />
											</td>
											<td><a href="javascript:insertfile('form_priloha','p__file','p__title')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vlož obrázok')), $this); ?>
"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
										</tr>
										<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
											<tr>
												<td></td>
												<td><input class="button" type="submit" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Prilož prílohu')), $this); ?>
" /></td>
												<td></td>
											</tr>
										<?php endif; ?>
										</form>
										<tr class="tr_header">
											<td colspan="3">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zoznam príloh')), $this); ?>
</td>
										</tr>
										<tr>
											<td colspan="3">
												<table width="100%">
												<form method="post" action="/vendor/cms_modules/cms_catalog/action.php">
													<input type="hidden" name="section" id="section" value="product_attachment" />
													<input type="hidden" name="cmd" id="cmd" value="<?php echo $this->_tpl_vars['cmd']; ?>
" />
													<input type="hidden" id="go" name="go" value="edit" />
													<input type="hidden" name="product_id" id="product_id" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />
													<input type="hidden" id="showtable" name="showtable" value="6" />
													<input type="hidden" id="rename_attachment" name="update_attachment" value="1" />
													<tr>
														<td class="bold"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Ukáž')), $this); ?>
</td>
														<td class="bold"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov')), $this); ?>
</td>
														<td class="td_align_center"><b><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zmaž')), $this); ?>
</b></td>
													</tr>
													<tr><td colspan="3"><hr></td></tr>
												<?php $this->assign('isExistAttach', 0); ?>
												<?php $_from = $this->_tpl_vars['detail_product']->getAttachments(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['attach_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attach_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['attach_item_id']):
        $this->_foreach['attach_list']['iteration']++;
?>
													<?php $this->assign('isExistAttach', 1); ?>
													<?php echo $this->_tpl_vars['attach_item_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

													<?php $this->assign('defaultView', 0); ?>

														<?php echo $this->_tpl_vars['attach_item_id']->setContextLanguage($this->_tpl_vars['localLanguageDefault']); ?>

														<?php $this->assign('defaultView', 1); ?>
														<?php $this->assign('attachTitleDefault', $this->_tpl_vars['attach_item_id']->getTitle()); ?>

													<?php echo $this->_tpl_vars['attach_item_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

													<?php 
														$path = "../mediafiles/".$GLOBALS['smarty']->get_template_vars(attach_item_id)->getFile();
														$name = basename($path);
														$size = stat($path);
														$GLOBALS["smarty"]->assign("attach_item_id_size",round($size['size']/1024,2));
														$GLOBALS["smarty"]->assign("attach_item_id_name",$name);
														$GLOBALS["smarty"]->assign("attach_item_id_path",$path);
													 ?>

													<tr>
															<td valign="top"><input type="checkbox" name="language_visibility<?php echo $this->_tpl_vars['attach_item_id']->getId(); ?>
" value="1" <?php if ($this->_tpl_vars['attach_item_id']->getLanguageIsVisible() == 1): ?>checked="checked"<?php endif; ?>></td>
															<td valign="top">
																<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
																	<?php echo $this->_tpl_vars['attachTitleDefault']; ?>

																<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
																<br />
																<input name="p__title<?php echo $this->_tpl_vars['attach_item_id']->getId(); ?>
" id="p__title<?php echo $this->_tpl_vars['attach_item_id']->getId(); ?>
" type="text" size="40" value="<?php echo $this->_tpl_vars['attach_item_id']->getTitle(); ?>
">
																<br />
																<a href="<?php echo $this->_tpl_vars['attach_item_id_path']; ?>
" target="_blank"><?php echo $this->_tpl_vars['attach_item_id_name']; ?>
</a>
																<br />
																<?php echo $this->_tpl_vars['attach_item_id_size']; ?>
 kB
															</td>
															<td valign="top" class="td_align_center"><?php if ($this->_tpl_vars['showItemEdit'] == 1): ?><input onclick="return checkdelete('<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Naozaj chcete vymazať prílohu ')), $this); ?>
<?php echo $this->_tpl_vars['attach_item_id_name']; ?>
 ?')" class="noborder" type="image" name="attach_delete<?php echo $this->_tpl_vars['attach_item_id']->getId(); ?>
" value="1" src="../themes/default/images/form_delete.gif" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'zmazať')), $this); ?>
"><?php endif; ?></td>
													 </tr>
													 <tr><td colspan="3"><hr></td></tr>
													<?php endforeach; endif; unset($_from); ?>
													<?php if ($this->_tpl_vars['isExistAttach'] == 1 && $this->_tpl_vars['showItemEdit'] == 1): ?>
													<tr><td></td><td colspan="2"><input class="button" type="submit" name="attach_update" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zapíš zmeny')), $this); ?>
"></td></tr>
													<?php endif; ?>
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