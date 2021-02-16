<?php /* Smarty version 2.6.30, created on 2019-05-16 19:56:46
         compiled from catalog_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'check', 'catalog_edit.tpl', 63, false),array('insert', 'merge', 'catalog_edit.tpl', 72, false),array('insert', 'tr', 'catalog_edit.tpl', 82, false),array('insert', 'getParentCategoryCat', 'catalog_edit.tpl', 287, false),array('insert', 'getOptionListMappedCategory', 'catalog_edit.tpl', 291, false),)), $this); ?>
<?php echo '
<script language="JavaScript" type="text/javascript">

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

<?php $_from = $this->_tpl_vars['LanguageListLocal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_id']):
        $this->_foreach['language']['iteration']++;
?>
<?php if ($this->_tpl_vars['language_id']['local_visibility']): ?>
	<?php echo $this->_tpl_vars['detail_catalog']->setContextLanguage($this->_tpl_vars['language_id']['code']); ?>

		hiddenlang('lang<?php echo $this->_tpl_vars['language_id']['code']; ?>
');
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
					
<?php echo '

	showlang(id);
}

function addelement(act_type,act_value){
	var newelement = document.createElement(\'INPUT\'); 
	newelement.type = \'hidden\'; 
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
'; ?>

<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'check')), $this); ?>

<?php $this->assign('title', 'Katalóg / detail'); ?>
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
	<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table width="100%" border=0>
				<tr>
					<td class="td_valign_top" width="70%">
						<table class="tb_list">
							<tr class="tr_header">
								<td colspan="2">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Detail katalógu')), $this); ?>
</td>
							</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="<?php echo $this->_tpl_vars['detail_catalog']->getId(); ?>
" />
				<input type="hidden" id="section" name="section" value="catalog" />
				<?php echo $this->_tpl_vars['detail_catalog']->setContextLanguage(($this->_tpl_vars['localLanguage'])); ?>

				<tr><td colspan="2" class="td_link_space"></td></tr>
				<tr>
					<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov')), $this); ?>
*</td>
					<td width="85%"><input size="60" type="text" name="f_title" id="f_title" value="<?php echo $this->_tpl_vars['detail_catalog']->getTitle(); ?>
" /></td>
				</tr>
				<tr>
					<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Popis')), $this); ?>
</td>
					<td width="85%"><textarea name="f_description" id="f_description" rows="5" cols="58"><?php echo $this->_tpl_vars['detail_catalog']->getDescription(); ?>
</textarea></td>
				</tr>
			</table>
			
					<?php $_from = $this->_tpl_vars['LanguageListLocal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_id']):
        $this->_foreach['language']['iteration']++;
?>
						<?php if ($this->_tpl_vars['language_id']['local_visibility']): ?>
							<?php echo $this->_tpl_vars['detail_catalog']->setContextLanguage($this->_tpl_vars['language_id']['code']); ?>

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
										<?php echo $this->_tpl_vars['detail_catalog']->getTitle(); ?>
<br /><br />
										<span class="bold"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Popis')), $this); ?>
:</span><br />
										<?php echo $this->_tpl_vars['detail_catalog']->getDescription(); ?>
<br />
									</div>
								</div>
								<br />
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					</td>
					<td class="td_valign_top">
					
								<table align="center" class="tb_tabs">
								<tr class="tr_header_tab">
					<td colspan="2" class="td_tabs_top">
					<?php echo $this->_tpl_vars['menu']; ?>

					</td>
				</tr>
				<tr><td class="td_valign_top" colspan="2">
							<div id="item1" style="visibility: hidden;">
							<table class="tb_list_in_tab" border=0>
								<tr class="tr_header">
									<td colspan="4">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Detailné nastavenia')), $this); ?>
</td>
								</tr>
								<tr>
									<td width="30%">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Viditeľnosť')), $this); ?>
</td>
									<td ><input type="checkbox" name="f_isPublished" id="f_isPublished" value="1" <?php if ($this->_tpl_vars['detail_catalog']->getIsPublished() == 1): ?>checked="checked"<?php endif; ?> /></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zobrazovacie&nbsp;práva')), $this); ?>
</td>
									<td>
										<select name="f_access" id="f_access">
											<option value="<?php echo $this->_tpl_vars['ACCESS_PUBLIC']; ?>
" <?php if ($this->_tpl_vars['detail_catalog']->getAccess() == $this->_tpl_vars['ACCESS_PUBLIC']): ?>selected="selected"<?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Verejné')), $this); ?>
</option>
											<option value="<?php echo $this->_tpl_vars['ACCESS_REGISTERED']; ?>
" <?php if ($this->_tpl_vars['detail_catalog']->getAccess() == $this->_tpl_vars['ACCESS_REGISTERED']): ?>selected="selected"<?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Registrovaným')), $this); ?>
</option>
											<option value="<?php echo $this->_tpl_vars['ACCESS_SPECIAL']; ?>
" <?php if ($this->_tpl_vars['detail_catalog']->getAccess() == $this->_tpl_vars['ACCESS_SPECIAL']): ?>selected="selected"<?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Skupiny používateľov')), $this); ?>
</option>
										</select>
									</td>
								</tr>


							</table>
							</form>
							</div>
							<div id="item2" style="visibility: hidden;">
							
							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" name="lang">
							<input type="hidden" name="mcmd" id="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="section" id="section" value="catalog" />
							<input type="hidden" id="showtable" name="showtable" value="1" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_catalog']->getId(); ?>
" />
							<input type="hidden" name="language_visibility" id="language_visibility" value="1" />
							<table class="tb_list_in_tab" align="center">
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
								<?php echo $this->_tpl_vars['detail_catalog']->setContextLanguage($this->_tpl_vars['language_id']['code']); ?>

								<tr>
									<td>&nbsp;<?php echo $this->_tpl_vars['language_id']['code']; ?>
</td>
									<td><input type="checkbox" name="a_languageIsVisible<?php echo $this->_tpl_vars['language_id']['code']; ?>
" id="f_languageIsVisible<?php echo $this->_tpl_vars['language_id']['code']; ?>
" value="1" <?php if ($this->_tpl_vars['detail_catalog']->getLanguageIsVisible() == 1): ?>checked="checked"<?php endif; ?> /></td>
									<td><a title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ukáž')), $this); ?>
" href="javascript:ukazlang('lang<?php echo $this->_tpl_vars['language_id']['code']; ?>
')"><img src="../themes/default/images/view_s.png" /></td>
								</tr>
								<?php endforeach; endif; unset($_from); ?>
								<tr>
									<td></td>
									<td class="td_center" colspan="2"><br />
			<?php $this->assign('showItemEdit', 0); ?>

    		<?php if (( $this->_tpl_vars['user_login']->checkPrivilege(105,$this->_tpl_vars['privilege_update']) == 1 )): ?>
                <?php $this->assign('showItemEdit', 1); ?>
            <?php else: ?>
                <?php $this->assign('showItemEdit', 0); ?>
            <?php endif; ?>
           
            <?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
                <?php $this->assign('showItemEdit', 1); ?>
            <?php endif; ?>
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
							<div id="item3" style="visibility: hidden;">
							
							<table class="tb_list_in_tab">
							<form name="form2" id="form2" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="catalog" />
							<input type="hidden" name="mcmd" id="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_catalog']->getId(); ?>
" />
							<input type="hidden" id="showtable" name="showtable" value="2" />
								<tr class="tr_header">
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
										<select name="add_menu_id">
											<option value="0"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vyberte menu')), $this); ?>
</option>
											<?php $_from = $this->_tpl_vars['menu_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menu'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menu']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['menu_id']):
        $this->_foreach['menu']['iteration']++;
?>
											
											<?php echo $this->_tpl_vars['menu_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

											<?php $this->assign('defaultView', 0); ?>
											<?php if (( $this->_tpl_vars['menu_id']->getTitle() == '' )): ?>
												<?php echo $this->_tpl_vars['menu_id']->setContextLanguage($this->_tpl_vars['localLanguageDefault']); ?>

												<?php $this->assign('defaultView', 1); ?>
											<?php endif; ?>
											<option value="<?php echo $this->_tpl_vars['menu_id']->getId(); ?>
">
											<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
												<?php echo $this->_tpl_vars['menu_id']->getTitle(); ?>

											<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
											</option>
											<?php endforeach; endif; unset($_from); ?>
										</select>
									</td>
								</tr>
								<tr>
									<td class="td_align_center" colspan="2">
									<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
										<br /><input class="button" type="submit" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Priraď k menu')), $this); ?>
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
								
								<?php $_from = $this->_tpl_vars['menu_list_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menu_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menu_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['menu_item_id']):
        $this->_foreach['menu_list']['iteration']++;
?>
								
								<?php echo $this->_tpl_vars['menu_item_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

									<?php $this->assign('defaultView', 0); ?>
									<?php if (( $this->_tpl_vars['menu_item_id']->getTitle() == '' )): ?>
										<?php echo $this->_tpl_vars['menu_item_id']->setContextLanguage($this->_tpl_vars['localLanguageDefault']); ?>

										<?php $this->assign('defaultView', 1); ?>
									<?php endif; ?>
							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" onsubmit="return checkdelete('<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Naozaj chcete vymazať väzbu fotogalérie s menu ')), $this); ?>
<?php echo $this->_tpl_vars['menu_item_id']->getTitle(); ?>
 ?')">
							<input type="hidden" name="section" id="section" value="catalog" />
							<input type="hidden" name="mcmd" id="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="2" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_catalog']->getId(); ?>
" />
							<input type="hidden" id="remove_menu_id" name="remove_menu_id" value="<?php echo $this->_tpl_vars['menu_item_id']->getId(); ?>
" />
								<tr>
									<td>&nbsp;&nbsp;<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
										<?php echo $this->_tpl_vars['menu_item_id']->getTitle(); ?>

									<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?></td>
									<td>
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
							
							<table class="tb_list_in_tab">
							<form name="form3" id="form3" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
							<input type="hidden" name="section" id="section" value="catalog" />
							<input type="hidden" name="mcmd" id="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_catalog']->getId(); ?>
" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="3" />
								<tr class="tr_header">
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getParentCategoryCat', 'id' => $this->_tpl_vars['detail_catalog']->getId(), 'assign' => 'ParentCategoryId')), $this); ?>

									<td  class="td_align_center">
										<select name="add_category_id" onchange="return checkControl(this)">
											<option value="0"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vyberte kategóriu')), $this); ?>
</option>
											<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getOptionListMappedCategory', 'free' => 'totally', 'select' => $this->_tpl_vars['ParentCategoryId'], 'zakaz' => $this->_tpl_vars['detail_catalog']->getId())), $this); ?>
	
										</select>
									</td>
								</tr>
								<tr>
									<td class="td_align_center">
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
									<?php $this->assign('objekt', $this->_tpl_vars['category_item_id']); ?>
									<?php echo $this->_tpl_vars['category_item_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

									<?php $this->assign('defaultView', 0); ?>
									<?php if (( $this->_tpl_vars['category_item_id']->getTitle() == '' )): ?>
										<?php echo $this->_tpl_vars['category_item_id']->setContextLanguage($this->_tpl_vars['localLanguageDefault']); ?>

										<?php $this->assign('defaultView', 1); ?>
									<?php endif; ?>
							<form method="post" action="/vendor/cms_modules/cms_catalog/action.php" onsubmit="return checkdelete('<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Naozaj chcete vymazať väzbu fotogalérie s kategórie ')), $this); ?>
<?php echo $this->_tpl_vars['category_item_id']->getTitle(); ?>
 ?')">
							<input type="hidden" name="section" id="section" value="catalog" />
							<input type="hidden" name="mcmd" id="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
							<input type="hidden" id="go" name="go" value="edit" />
							<input type="hidden" id="showtable" name="showtable" value="3" />
							<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_catalog']->getId(); ?>
" />
							<input type="hidden" id="remove_category_id" name="remove_category_id" value="<?php echo $this->_tpl_vars['category_item_id']->getId(); ?>
" />
								<tr>
									<td>&nbsp;&nbsp;<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
										<?php echo $this->_tpl_vars['category_item_id']->getTitle(); ?>

									<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?></td>
									<td>
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