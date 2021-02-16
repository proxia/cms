<?php /* Smarty version 2.6.30, created on 2019-05-17 11:22:40
         compiled from branch_list_language.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'tr', 'branch_list_language.tpl', 40, false),array('insert', 'getOptionListBranch', 'branch_list_language.tpl', 101, false),array('insert', 'merge', 'branch_list_language.tpl', 116, false),)), $this); ?>
<?php echo '
<script language="JavaScript" type="text/javascript">
function pozadie (farba,idd){
		idd.style.background = farba;
	}


function selectall_2(the_form, min, max,basename){
	//basename = "box";
    for (var i = min; i <= max; i++) {
        if (typeof(document.forms[the_form].elements[basename + i]) != \'undefined\') {
            document.forms[the_form].elements[basename + i].checked = document.forms[the_form].elements[basename].checked;
			//setRowBgColor (the_form, i);
        }
    }

    return true;
}

//pozor
function ischecked(the_form,min,max,act_type,act_value){

			submitform(act_type,act_value)

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

<?php $this->assign('title', 'Kategórie / nastavenie viditeľnosti'); ?>
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
						<img class="img_middle" src="themes/default/images/filter_m_add.png" alt="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
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
				<?php $this->assign('stlpcov', 4); ?>
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov kategórie')), $this); ?>
</td>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Viditeľnosť kategórie')), $this); ?>
</td>
					<?php $_from = $this->_tpl_vars['LanguageListLocal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_id']):
        $this->_foreach['language']['iteration']++;
?>
					<td><?php echo $this->_tpl_vars['language_id']['code']; ?>
</td>
					<?php endforeach; endif; unset($_from); ?>

					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ID')), $this); ?>
</td>

				</tr>
			<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
				<input type="hidden" id="section" name="section" value="branch_language" />
				<input type="hidden" name="language_visibility" id="language_visibility" value="1" />
				<input type="hidden" id="start" name="start" value="<?php echo $this->_tpl_vars['start']; ?>
" />
				<tr class="tr_header">
					<td></td>
					<td></td>
					<td class="td_align_center"><input title="vybrať všetko / zrušiť všetko" id="visibility" type="checkbox" name="selectall" value="1" onclick="selectall_2('form1',1,<?php echo $this->_tpl_vars['max_list']; ?>
,'visibility')" /></td>
					<?php $_from = $this->_tpl_vars['LanguageListLocal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_id']):
        $this->_foreach['language']['iteration']++;
?>
							<td><input title="vybrať všetko / zrušiť všetko" id="language<?php echo $this->_tpl_vars['language_id']['code']; ?>
" type="checkbox" name="selectall" value="1" onclick="selectall_2('form1',1,<?php echo $this->_tpl_vars['max_list']; ?>
,'language<?php echo $this->_tpl_vars['language_id']['code']; ?>
')" /></td>
					<?php endforeach; endif; unset($_from); ?>
					<td></td>
				</tr>


			<?php $_from = $this->_tpl_vars['branch_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['branch'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['branch']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['branch_id']):
        $this->_foreach['branch']['iteration']++;
?>
				<input type="hidden" name="row_id[]" value="<?php echo $this->_tpl_vars['branch_id']['object']['id']; ?>
">

				<tr>
					<td colspan="<?php echo $this->_tpl_vars['stlpcov']; ?>
" class="td_link_space"></td>
					<?php $_from = $this->_tpl_vars['LanguageListLocal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_id']):
        $this->_foreach['language']['iteration']++;
?>
					<td class="td_link_space"></td>
					<?php endforeach; endif; unset($_from); ?>
				</tr>
				<?php $this->assign('showItem', 0); ?>
        		<?php $this->assign('showItemEdit', 0); ?>

            <?php if (( $this->_tpl_vars['user_login']->checkPrivilege(1050001,$this->_tpl_vars['privilege_view']) == 1 )): ?>
               <?php $this->assign('showItem', 1); ?>
            <?php else: ?>
               <?php $this->assign('showItem', 0); ?>
            <?php endif; ?>

            <?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
                <?php $this->assign('showItem', 1); ?>
            <?php endif; ?>

    		<?php if (( $this->_tpl_vars['user_login']->checkPrivilege(1050001,$this->_tpl_vars['privilege_update']) == 1 )): ?>
                <?php $this->assign('showItemEdit', 1); ?>
            <?php else: ?>
                <?php $this->assign('showItemEdit', 0); ?>
            <?php endif; ?>

            <?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
                <?php $this->assign('showItemEdit', 1); ?>
            <?php endif; ?>


				<tr onmouseover="pozadie('#f5f5f5',this)" onmouseout="pozadie('#ffffff',this)">
					<td class="td_align_center"><?php echo $this->_foreach['branch']['iteration']; ?>
</td>
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
					<td class="td_align_center">
						<input <?php if ($this->_tpl_vars['showItemEdit'] == 0): ?>disabled="disabled"<?php endif; ?> id="visibility<?php echo $this->_foreach['branch']['iteration']; ?>
" name="visibility[<?php echo $this->_tpl_vars['branch_id']['object']['id']; ?>
]" type="checkbox" value="1" <?php if ($this->_tpl_vars['branch_id']['object']['is_published'] == 1): ?>checked="checked"<?php endif; ?>>
					</td>
					<?php $_from = $this->_tpl_vars['LanguageListLocal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_id']):
        $this->_foreach['language']['iteration']++;
?>
					<?php $this->assign('triedaLang', 'class="hrefyeslang"'); ?>
										<?php if (( $this->_tpl_vars['branch_id']['object']['title'] == '' )): ?><?php $this->assign('triedaLang', 'class="hrefnolang"'); ?><?php endif; ?>
						<td><input <?php if ($this->_tpl_vars['showItemEdit'] == 0): ?> disabled="disabled" <?php endif; ?> id="language<?php echo $this->_tpl_vars['language_id']['code']; ?>
<?php echo $this->_foreach['branch']['iteration']; ?>
" type="checkbox" name="a_languageIsVisible<?php echo $this->_tpl_vars['language_id']['code']; ?>
[<?php echo $this->_tpl_vars['branch_id']['object']['id']; ?>
]" value="1" <?php if ($this->_tpl_vars['branch_id']['object']['language_is_visible'] == 1): ?> checked="checked"<?php endif; ?>></td>
					<?php endforeach; endif; unset($_from); ?>

					<td class="td_align_center"><?php echo $this->_tpl_vars['branch_id']['object']['id']; ?>
</td>

				</tr>
			<?php endforeach; endif; unset($_from); ?>
				</form>
			</table>


			<br />
		</td>
	</tr>

	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>