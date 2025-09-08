<?php /* Smarty version 2.6.30, created on 2019-05-17 07:28:54
         compiled from branch_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'tr', 'branch_list.tpl', 94, false),array('insert', 'getOptionListBranch', 'branch_list.tpl', 193, false),array('insert', 'merge', 'branch_list.tpl', 217, false),array('insert', 'getNumChild', 'branch_list.tpl', 321, false),)), $this); ?>
<?php echo '
<script language="JavaScript" type="text/javascript">
var colorRowMouseOver = \'#f5f5f5\';
var colorRowMouseOut = \'#ffffff\';
var coloRowSelectedMouseOut = \'#fbe6e6\';
var coloRowSelectedMouseOver = \'#f7cccc\';

function pozadieIN (the_form, id){
	row_name = "row" + id;
	basename_checkbox = "box";

	if (document.forms[the_form].elements[basename_checkbox + id].checked)
		document.getElementById(row_name).style.background = coloRowSelectedMouseOver;
	else
		document.getElementById(row_name).style.background = colorRowMouseOver;
}

function pozadieOUT (the_form, id){
	row_name = "row" + id;
	basename_checkbox = "box";

	if (document.forms[the_form].elements[basename_checkbox + id].checked)
		document.getElementById(row_name).style.background = coloRowSelectedMouseOut;
	else
		document.getElementById(row_name).style.background = colorRowMouseOut;
}

function setRowBgColor(the_form, id){

	basename_checkbox = "box";
	row_name = "row" + id;
	is_check = document.forms[the_form].elements[basename_checkbox + id].checked;

	if (is_check){
		document.getElementById(row_name).style.background = coloRowSelectedMouseOut;
	}
	else{
		document.getElementById(row_name).style.background = colorRowMouseOut;
	}
}

var sel_value = 1;
function selectall(the_form, min, max){
	basename = "box";
	if (sel_value==2)
		do_check = false;
	if (sel_value==1)
		do_check = true;
    for (var i = min; i <= max; i++) {
        if (typeof(document.forms[the_form].elements[basename + i]) != \'undefined\') {
            document.forms[the_form].elements[basename + i].checked = do_check;
				if (do_check == true)
					sel_value = 2;
				if (do_check == false)
					sel_value = 1;

			setRowBgColor (the_form, i);
        }
    }

    return true;
}

function hiddencombo(id){

	var style=document.getElementById(\'combo\'+id).style;
	style.visibility = "hidden";

}

function showcombo(id){
	'; ?>

		<?php $_from = $this->_tpl_vars['branch_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['branch'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['branch']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['branch_id']):
        $this->_foreach['branch']['iteration']++;
?>
			hiddencombo(<?php echo $this->_foreach['branch']['iteration']; ?>
);
		<?php endforeach; endif; unset($_from); ?>
	<?php echo '
	var style=document.getElementById(\'combo\'+id).style;
	style.visibility = "visible";

}

function ischecked(the_form,min,max,act_type,act_value){
	  var basename = "box";
      pocetChecked = 0;
      for (var i = min; i <= max; i++)
        {
			if (typeof(document.forms[the_form].elements[basename + i]) != \'undefined\') {
            		if (document.forms[the_form].elements[basename + i].checked == true)
						pocetChecked++;
				}
        }
      if(pocetChecked == 0 ){
'; ?>

        	alert("<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Nevybrali ste žiadny záznam na spracovanie')), $this); ?>
!");
<?php echo '
        	return false;
        }
		else{

				if ((act_type == "delete") && (act_value == 1)){
			'; ?>

					var potvrdenie = confirm('<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Pozor táto operácia je nevratná, vybrané položky sa navždy vymažú !!! Vymazať ?')), $this); ?>
')
			<?php echo '
					if (potvrdenie){
							submitform(act_type,act_value,the_form)
							return;
						}
					else
							return false;
				}



			submitform(act_type,act_value)
		}
  }

function listItemTask(the_form,min,max,act_type,act_value,act_type2,act_value2,row){
		document.forms[the_form].elements[row].checked = true;
	  var basename = "box";
      pocetChecked = 0;
      for (var i = min; i <= max; i++)
        {
			if (typeof(document.forms[the_form].elements[basename + i]) != \'undefined\') {
            		if (document.forms[the_form].elements[basename + i].checked == true)
						pocetChecked++;
				}
        }
      if(pocetChecked == 0 ){
'; ?>

        	alert("<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Nevybrali ste žiadny záznam na spracovanie')), $this); ?>
!");
<?php echo '
        	return false;
        }
		else{





			submitform(act_type,act_value,act_type2,act_value2)
		}
  }


function addelement(act_type,act_value){
	var newelement = document.createElement(\'INPUT\');
	newelement.type = \'hidden\';
	newelement.name = act_type;
	newelement.value = act_value;
	document.form1.appendChild(newelement)
}

function submitform(act_type,act_value,act_type2,act_value2){
	addelement(act_type,act_value);
	addelement(act_type2,act_value2);
	try {
		document.form1.onsubmit();
		}
	catch(e){}
		document.form1.submit();
}

function checkControl(categoryTree,form_search){
  var isOptionDisabled = categoryTree.options[categoryTree.selectedIndex].disabled;
  if(isOptionDisabled){
    categoryTree.selectedIndex = 0;//categoryTree.defaultSelectedIndex;
    return false;
  }
  else categoryTree.defaultSelectedIndex = categoryTree.selectedIndex;
  form_search.submit();
}

</script>
'; ?>

<?php $this->assign('title', 'Kategórie / prehľad'); ?>

<table class="tb_middle">
	<tr>
		<td colspan="3">
			<table class="tb_top_menu">
				<tr>
					<td width="90%"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "title_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
					<td class="td_align_right">
						<img class="img_middle" src="../themes/default/images/filter_m_add.png" alt="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'filter')), $this); ?>
" />
					</td>
					<form method="get" name="form_search" id="form_search" onsubmit="">
					<input type="hidden" name="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
					<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['module']; ?>
" />
					<td class="td_align_right">&nbsp;&nbsp;
						<select name="s_category" onchange="return checkControl(this,form_search)">
							<option value="0"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'všetky kategórie')), $this); ?>
</option>
							<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getOptionListBranch', 'catalog' => '$catalog_id', 'select' => $this->_tpl_vars['s_category'], 'type' => 'noend')), $this); ?>

						</select>
					</td>
					</form>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
		<?php 
					ob_start();
				 ?>

				<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getOptionListBranch', 'catalog' => '$catalog_id', 'select' => 0, 'unselect' => 0, 'assign' => 'strom')), $this); ?>

				<?php 
					$GLOBALS['strom'] = ob_get_contents();
					ob_end_clean();
					$GLOBALS["smarty"]->assign("strom",$GLOBALS['strom']);
	 ?>
	<?php $_from = $this->_tpl_vars['branch_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['branch'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['branch']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['branch_id']):
        $this->_foreach['branch']['iteration']++;
?>	 
	<?php endforeach; endif; unset($_from); ?>
	<?php $this->assign('max_list', $this->_foreach['branch']['iteration']); ?>
	<tr>
		<td class="td_middle_left">
		<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'merge', 'value1' => $this->_tpl_vars['path_relative'], 'value2' => 'themes/default/scripts/toolbar.php', 'assign' => 'path_toolbar')), $this); ?>

		<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => $this->_tpl_vars['path_toolbar'], 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

		</td>
		<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list2">
				<?php $this->assign('stlpcov', 8); ?>
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form1',1,<?php echo $this->_tpl_vars['max_list']; ?>
)" /></td>
					<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov')), $this); ?>
</td>
										<?php $this->assign('stlpcov', $this->_tpl_vars['stlpcov']+1); ?>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Poradie')), $this); ?>
</td>
										<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Produkty')), $this); ?>
</td>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Priradenie produktov')), $this); ?>
</td>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Odobranie produktov')), $this); ?>
</td>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Viditeľnosť')), $this); ?>
</td>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ID')), $this); ?>
</td>
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
				<input type="hidden" id="section" name="section" value="branch" />
				<input type="hidden" id="go" name="go" value="list" />
				<input type="hidden" id="s_category" name="s_category" value="<?php echo $this->_tpl_vars['s_category']; ?>
" />
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "divCombo.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<?php 
					ob_start();
				 ?>

				<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getOptionListBranch', 'catalog' => '$catalog_id', 'select' => 0, 'unselect' => 0, 'assign' => 'strom')), $this); ?>

				<?php 
					$GLOBALS['strom'] = ob_get_contents();
					ob_end_clean();
					$GLOBALS["smarty"]->assign("strom",$GLOBALS['strom']);
				 ?>
			<?php $_from = $this->_tpl_vars['branch_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['branch'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['branch']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['branch_id']):
        $this->_foreach['branch']['iteration']++;
?>

				<tr>
					<td colspan="<?php echo $this->_tpl_vars['stlpcov']; ?>
" class="td_link_space"></td>
				</tr>

				<?php $this->assign('showItem', 0); ?>
        		<?php $this->assign('showItemEdit', 0); ?>
        		<?php $this->assign('showProduct', 0); ?>

				<?php if (( $this->_tpl_vars['user_login']->checkPrivilege(1050001,$this->_tpl_vars['privilege_view']) == 1 )): ?>
				<?php $this->assign('showItem', 1); ?>
				<?php else: ?>
				<?php $this->assign('showItem', 0); ?>
				<?php endif; ?>

				<?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
					<?php $this->assign('showItem', 1); ?>
				<?php endif; ?>

				<?php if (( $this->_tpl_vars['user_login']->checkPrivilege(1050002,$this->_tpl_vars['privilege_view']) == 1 )): ?>
				<?php $this->assign('showProduct', 1); ?>
				<?php else: ?>
				<?php $this->assign('showProduct', 0); ?>
				<?php endif; ?>

				<?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
					<?php $this->assign('showProduct', 1); ?>
				<?php endif; ?>

				<?php if (( $this->_tpl_vars['user_login']->checkPrivilege(1050001,$this->_tpl_vars['privilege_update']) == 1 )): ?>
					<?php $this->assign('showItemEdit', 1); ?>
				<?php else: ?>
					<?php $this->assign('showItemEdit', 0); ?>
				<?php endif; ?>

				<?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
					<?php $this->assign('showItemEdit', 1); ?>
				<?php endif; ?>

				<?php if (( ( $this->_tpl_vars['user_login']->checkPrivilege(1050001,$this->_tpl_vars['privilege_update']) == 1 ) || ( $this->_tpl_vars['user_login']->checkPrivilege(1050001,$this->_tpl_vars['privilege_delete']) == 1 ) || ( $this->_tpl_vars['user_login']->checkPrivilege(1050001,$this->_tpl_vars['privilege_add']) == 1 ) )): ?>
					<?php $this->assign('showCheckbox', 1); ?>
				<?php else: ?>
					<?php $this->assign('showCheckbox', 0); ?>
				<?php endif; ?>

				<?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
					<?php $this->assign('showCheckbox', 1); ?>
				<?php endif; ?>


				<tr id="row<?php echo $this->_foreach['branch']['iteration']; ?>
" onmouseover="pozadieIN('form1','<?php echo $this->_foreach['branch']['iteration']; ?>
')" onmouseout="pozadieOUT('form1','<?php echo $this->_foreach['branch']['iteration']; ?>
')">
					<td class="td_align_center"><?php echo $this->_foreach['branch']['iteration']+$this->_tpl_vars['start']; ?>
</td>
					<td><input <?php if ($this->_tpl_vars['showCheckbox'] == 0): ?>disabled="disabled"<?php endif; ?> onclick="setRowBgColor('form1',<?php echo $this->_foreach['branch']['iteration']; ?>
)"  id="box<?php echo $this->_foreach['branch']['iteration']; ?>
" type="checkbox" name="row_id[]" value="<?php echo $this->_tpl_vars['branch_id']['object']['id']; ?>
" /></td>
					<td>
						<?php if ($this->_tpl_vars['showItem'] == 1): ?>
						<a href="./?module=CMS_Catalog&mcmd=6&row_id[]=<?php echo $this->_tpl_vars['branch_id']['object']['id']; ?>
">
							<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
								<?php echo $this->_tpl_vars['branch_id']['object']['title']; ?>

							<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
						</a>
						<?php else: ?>
							<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
								<?php echo $this->_tpl_vars['branch_id']['object']['title']; ?>

							<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
						<?php endif; ?>
					</td>
					<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getNumChild', 'type' => 'product', 'id' => $this->_tpl_vars['branch_id']['object']['id'], 'assign' => 'numProduct')), $this); ?>

					<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getNumChild', 'type' => 'branch', 'id' => $this->_tpl_vars['branch_id']['object']['id'], 'assign' => 'numBranch')), $this); ?>

					   					<td class="td_align_center">
   						<?php if ($this->_tpl_vars['numBranch'] > 0): ?>
							<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
								<a href="./?module=CMS_Catalog&mcmd=27&&row_id[]=<?php echo $this->_tpl_vars['branch_id']['object']['id']; ?>
"><img src="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'merge', 'value1' => $this->_tpl_vars['path_relative'], 'value2' => 'themes/default/images/all_m_restore.png')), $this); ?>
" width="16"/></a>
							<?php else: ?>
								<img src="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'merge', 'value1' => $this->_tpl_vars['path_relative'], 'value2' => 'themes/default/images/all_m_restore.png')), $this); ?>
" width="16" />
							<?php endif; ?>
   						<?php endif; ?>
   						<?php if ($this->_tpl_vars['showProduct'] == 1 && $this->_tpl_vars['numBranch'] == 0): ?>
							<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
								<a href="./?module=CMS_Catalog&mcmd=28&&row_id[]=<?php echo $this->_tpl_vars['branch_id']['object']['id']; ?>
"><img src="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'merge', 'value1' => $this->_tpl_vars['path_relative'], 'value2' => 'themes/default/images/all_m_restore.png')), $this); ?>
" width="16"/></a>
							<?php else: ?>
								<img src="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'merge', 'value1' => $this->_tpl_vars['path_relative'], 'value2' => 'themes/default/images/all_m_restore.png')), $this); ?>
" width="16" />
							<?php endif; ?>
   						<?php endif; ?>

   					</td>
   					
					<td>
						<?php if ($this->_tpl_vars['numBranch'] == 0): ?>
							<?php if ($this->_tpl_vars['showProduct'] == 1): ?>
								<a href="./?mcmd=10&module=<?php echo $this->_tpl_vars['module']; ?>
&s_category=<?php echo $this->_tpl_vars['branch_id']['object']['id']; ?>
"><img src="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'merge', 'value1' => $this->_tpl_vars['path_relative'], 'value2' => 'themes/default/images/product_s.gif')), $this); ?>
" /></a> (<?php echo $this->_tpl_vars['numProduct']; ?>
)
							<?php else: ?>
								<img src="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'merge', 'value1' => $this->_tpl_vars['path_relative'], 'value2' => 'themes/default/images/product_s.gif')), $this); ?>
" /> (<?php echo $this->_tpl_vars['numProduct']; ?>
)
							<?php endif; ?>
						<?php endif; ?>
					</td>
					<?php if ($this->_tpl_vars['numBranch'] == 0): ?>
					<td class="td_align_center" <?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>onclick="showDivCombo(<?php echo $this->_foreach['branch']['iteration']; ?>
)"<?php endif; ?>>
						<img src="../themes/default/images/filter_s.gif" />
					</td>
					<?php else: ?>
					<td></td>
					<?php endif; ?>
					<td class="td_align_center">
						<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
							<a href="./?mcmd=21&module=CMS_Catalog&row_id[]=<?php echo $this->_tpl_vars['branch_id']['object']['id']; ?>
"><img src="../themes/default/images/remove_s.gif" /></a>
						<?php else: ?>
							<img src="../themes/default/images/remove_s.gif" />
						<?php endif; ?>
					</td>
					<td class="td_align_center">
						<?php if ($this->_tpl_vars['branch_id']['object']['is_published'] == 1): ?>
							<?php $this->assign('viewLang', ''); ?>
							<?php $_from = $this->_tpl_vars['LanguageListLocal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_id']):
        $this->_foreach['language']['iteration']++;
?>
								<?php if ($this->_tpl_vars['language_id']['local_visibility'] == 1): ?>
																		<?php if ($this->_tpl_vars['branch_id']['object']['language_is_visible'] == 0): ?><?php $this->assign('viewLang', 'cb'); ?><?php endif; ?>
								<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?>
							<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
								<a href="#" onclick="listItemTask('form1',1,<?php echo $this->_tpl_vars['max_list']; ?>
,'f_isPublished',0,'section','branch','box<?php echo $this->_foreach['branch']['iteration']; ?>
')"><img src="../themes/default/images/visible<?php echo $this->_tpl_vars['viewLang']; ?>
.gif" /></a>
							<?php else: ?>
								<img src="themes/default/images/visible<?php echo $this->_tpl_vars['viewLang']; ?>
.gif" />
							<?php endif; ?>
						<?php else: ?>
							<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
								<a href="#" onclick="listItemTask('form1',1,<?php echo $this->_tpl_vars['max_list']; ?>
,'f_isPublished',1,'section','branch','box<?php echo $this->_foreach['branch']['iteration']; ?>
')"><img src="../themes/default/images/hidden.gif" /></a>
							<?php else: ?>
								<img src="../themes/default/images/hidden.gif" />
							<?php endif; ?>
						<?php endif; ?></td>
					<td class="td_align_center"><?php echo $this->_tpl_vars['branch_id']['object']['id']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
				</form>
			</table>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "Proxia:default.array_pager", 'smarty_include_vars' => array('list' => $this->_tpl_vars['branch_list'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<br />
		</td>
	</tr>

	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>