<?php /* Smarty version 2.6.30, created on 2019-05-17 14:14:36
         compiled from product_list_setup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'tr', 'product_list_setup.tpl', 111, false),array('insert', 'merge', 'product_list_setup.tpl', 290, false),array('insert', 'getOptionListBranch', 'product_list_setup.tpl', 376, false),array('insert', 'makeCalendar', 'product_list_setup.tpl', 379, false),array('insert', 'getAvailableCurrencies', 'product_list_setup.tpl', 434, false),array('insert', 'getPrice', 'product_list_setup.tpl', 610, false),)), $this); ?>
<?php echo '
<script language="JavaScript" type="text/javascript">
var colorRowMouseOver = \'#f5f5f5\';
var colorRowMouseOut = \'#ffffff\';
var coloRowSelectedMouseOut = \'#fbe6e6\';
var coloRowSelectedMouseOver = \'#f7cccc\';

function pozadieIN (the_form, id){
	row_name = "row" + id;
	basename_checkbox = "box";
	'; ?>

	<?php if (( $this->_tpl_vars['setup_type'] == 'valid' || $this->_tpl_vars['setup_type'] == 'access' )): ?>
	if (document.forms[the_form].elements[basename_checkbox + id].checked)
		document.getElementById(row_name).style.background = coloRowSelectedMouseOver;
	else
	<?php endif; ?>
	<?php echo '
		document.getElementById(row_name).style.background = colorRowMouseOver;
}

function pozadieOUT (the_form, id){
	row_name = "row" + id;
	basename_checkbox = "box";
	'; ?>

	<?php if (( $this->_tpl_vars['setup_type'] == 'valid' || $this->_tpl_vars['setup_type'] == 'access' )): ?>
	if (document.forms[the_form].elements[basename_checkbox + id].checked)
		document.getElementById(row_name).style.background = coloRowSelectedMouseOut;
	else
	<?php endif; ?>
	<?php echo '
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

function insertfile(form_name,form_text_name){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
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

  if(document.forms["form1"].s_group != undefined)
  {
	var prava = document.forms["form1"].s_group.options[document.forms["form1"].s_group.selectedIndex].value
	document.forms[form_search].group.value = prava;
  }

  if(isOptionDisabled)
  {
    categoryTree.selectedIndex = 0;//categoryTree.defaultSelectedIndex;
    return false;
  }
  else
	categoryTree.defaultSelectedIndex = categoryTree.selectedIndex;

  document.forms[form_search].s_category.value = categoryTree.options[categoryTree.selectedIndex].value
  document.forms[form_search].submit();
}

function setCalendar(the_form, id, fromto){
	var basename = "box";
	pocetChecked = 0;

	setupValue = document.forms[the_form].elements[id].value ;

	'; ?>

	<?php $_from = $this->_tpl_vars['product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['product'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['product']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product_id']):
        $this->_foreach['product']['iteration']++;
?>
	<?php endforeach; endif; unset($_from); ?>
	<?php $this->assign('max_list', $this->_foreach['product']['iteration']); ?>

	min = 1;
	max = <?php echo $this->_tpl_vars['max_list']; ?>
;

	<?php echo '

	for (var i = min; i <= max; i++){
		if (typeof(document.forms[the_form].elements[basename + i]) != \'undefined\') {
			if (document.forms[the_form].elements[basename + i].checked == true){
				if (fromto == \'from\')
					new_id = i * 2 + 1 ;

				if (fromto == \'to\')
					new_id = i * 2 + 2 ;
				document.forms[the_form].elements["f-calendar-field-" + new_id].value = setupValue;
				pocetChecked++;
			}

		}
	}

	if(pocetChecked == 0 ){
		'; ?>

        	alert("<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Nevybrali ste žiadny záznam na spracovanie')), $this); ?>
!");
		<?php echo '
    }
}


function setSelect(the_form, id){
	var basename = "box";
	pocetChecked = 0;

	setupValue = document.forms[the_form].elements[id].value ;

	'; ?>

	<?php $_from = $this->_tpl_vars['product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['product'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['product']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product_id']):
        $this->_foreach['product']['iteration']++;
?>
	<?php endforeach; endif; unset($_from); ?>
	<?php $this->assign('max_list', $this->_foreach['product']['iteration']); ?>

	min = 1;
	max = <?php echo $this->_tpl_vars['max_list']; ?>
;

	<?php echo '

	for (var i = min; i <= max; i++){
		if (typeof(document.forms[the_form].elements[basename + i]) != \'undefined\') {
			if (document.forms[the_form].elements[basename + i].checked == true){
				document.forms[the_form].elements["access" + i].value = setupValue;
				pocetChecked++;
			}

		}
	}

	if(pocetChecked == 0 ){
		'; ?>

        	alert("<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Nevybrali ste žiadny záznam na spracovanie')), $this); ?>
!");
		<?php echo '
    }
}


function changeCurrency(select,mcmd,start){
	//alert()

	location.href="./?module=CMS_Catalog&mcmd="+mcmd+"&setup_type=price&currency="+select.options[select.selectedIndex].text+"&start="+start;
}

function changeGroup(select,mcmd,start)
{

	var x = "";

	if(document.forms["form1"].s_category != undefined)
	{
		x = "&s_category="+document.forms["form1"].s_category.value;
	}
	location.href="./?module=CMS_Catalog&mcmd="+mcmd+"&setup_type=price&group="+select.options[select.selectedIndex].value+"&start="+start+x;
}

</script>
'; ?>

<?php $this->assign('title', 'Produkty / prehľad'); ?>
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
					<input type="hidden" name="setup_type" value="<?php echo $this->_tpl_vars['setup_type']; ?>
" />
					<td class="td_align_right">&nbsp;&nbsp;
					<input type="hidden" name="s_category" value="<?php echo $this->_tpl_vars['s_category']; ?>
" />
					<input type="hidden" name="group" value="<?php echo $this->_tpl_vars['group']; ?>
" />
					</td>
					<td>
						&nbsp;<input type="text" size="20" name="s_string" value="<?php echo $this->_tpl_vars['s_string']; ?>
">&nbsp;
					</td>
					<td>
						<input type="submit" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ok')), $this); ?>
">
					</td>
					</form>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>

	<?php $_from = $this->_tpl_vars['product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['product'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['product']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product_id']):
        $this->_foreach['product']['iteration']++;
?>
	<?php endforeach; endif; unset($_from); ?>
	<?php $this->assign('max_list', $this->_foreach['product']['iteration']); ?>
	<tr>
		<td class="td_middle_left">
		<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'merge', 'value1' => $this->_tpl_vars['path_relative'], 'value2' => 'themes/default/scripts/toolbar.php', 'assign' => 'path_toolbar')), $this); ?>

		<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => $this->_tpl_vars['path_toolbar'], 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

		</td>
		<td class="td_link_h"><img src="../themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list2" border="0">
				<?php $this->assign('stlpcov', 6); ?>
				<?php if ($this->_tpl_vars['setup_type'] == 'valid'): ?>
					<?php $this->assign('stlpcov', 10); ?>
				<?php elseif ($this->_tpl_vars['setup_type'] == 'image'): ?>
					<?php $this->assign('stlpcov', 8); ?>
				<?php elseif ($this->_tpl_vars['setup_type'] == 'access'): ?>
					<?php $this->assign('stlpcov', 8); ?>
				<?php elseif ($this->_tpl_vars['setup_type'] == 'price'): ?>
					<?php $this->assign('stlpcov', 8); ?>
				<?php elseif ($this->_tpl_vars['setup_type'] == 'stock'): ?>
					<?php $this->assign('stlpcov', 8); ?>
				<?php endif; ?>
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<?php if ($this->_tpl_vars['setup_type'] == 'valid' || $this->_tpl_vars['setup_type'] == 'access' || $this->_tpl_vars['setup_type'] == 'price' || $this->_tpl_vars['setup_type'] == 'stock'): ?>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form1',1,<?php echo $this->_tpl_vars['max_list']; ?>
)" /></td>
					<?php endif; ?>
					<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov produktu')), $this); ?>
</td>

					<?php if ($this->_tpl_vars['setup_type'] != 'price'): ?>
					<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Kód')), $this); ?>
</td>
					<?php endif; ?>

					<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Kategória')), $this); ?>
</td>
					<?php if ($this->_tpl_vars['setup_type'] == 'visibility'): ?>
						<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Viditeľnosť produktu')), $this); ?>
</td>

						<?php $_from = $this->_tpl_vars['LanguageListLocal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_id']):
        $this->_foreach['language']['iteration']++;
?>
						<td><?php echo $this->_tpl_vars['language_id']['code']; ?>
</td>
						<?php endforeach; endif; unset($_from); ?>

					<?php elseif ($this->_tpl_vars['setup_type'] == 'valid'): ?>
						<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Platnosť od')), $this); ?>
</td>
						<td></td>
						<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Platnosť do')), $this); ?>
</td>
						<td></td>

					<?php elseif ($this->_tpl_vars['setup_type'] == 'image'): ?>

						<td colspan="3"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Obrázok')), $this); ?>
</td>

					<?php elseif ($this->_tpl_vars['setup_type'] == 'access'): ?>

						<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zobrazovacie práva')), $this); ?>
</td>
						<td></td>

					<?php elseif ($this->_tpl_vars['setup_type'] == 'price'): ?>
						<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Kód')), $this); ?>
</td>
						<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Cena')), $this); ?>
</td>
						<td></td>
					<?php elseif ($this->_tpl_vars['setup_type'] == 'news'): ?>

						<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Novinky')), $this); ?>
</td>
						<td></td>
					<?php elseif ($this->_tpl_vars['setup_type'] == 'sale'): ?>

						<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Výpredaj')), $this); ?>
</td>
						<td></td>
					<?php elseif ($this->_tpl_vars['setup_type'] == 'stock'): ?>

						<td colspan="2"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Skladom položiek')), $this); ?>
</td>
					<?php endif; ?>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ID')), $this); ?>
</td>
				</tr>
			<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
				<input type="hidden" id="section" name="section" value="product_setup" />
				<input type="hidden" name="setup_type" id="setup_type" value="<?php echo $this->_tpl_vars['setup_type']; ?>
" />
				<input type="hidden" id="start" name="start" value="<?php echo $this->_tpl_vars['start']; ?>
" />


				<?php if ($this->_tpl_vars['setup_type'] == 'valid'): ?>
				<tr class="tr_header">
					<td></td>
					<td></td>
					<td colspan="2" ></td>
					<td>
						<select name="s_category" onchange="return checkControl(this,'form_search')">
							<option value="0"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vo všetkých kategóriách')), $this); ?>
</option>
							<option value="-1" <?php if ($this->_tpl_vars['s_category'] == -1): ?>selected="selected"<?php endif; ?>><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'len nepriradené')), $this); ?>
</option>
							<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getOptionListBranch', 'catalog' => '$catalog_id', 'select' => $this->_tpl_vars['s_category'], 'type' => 'end')), $this); ?>

						</select>
					</td>
					<td width="160"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'makeCalendar', 'nazov' => 'validfromdefault')), $this); ?>
</td>
					<td width="50"><a href="javascript:setCalendar('form1','f-calendar-field-1','from')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'prednastav')), $this); ?>
"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
					<td width="160"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'makeCalendar', 'nazov' => 'validtodefault')), $this); ?>
</td>
					<td width="22"><a href="javascript:setCalendar('form1','f-calendar-field-2','to')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'prednastav')), $this); ?>
"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
					<td></td>
				</tr>
				<?php elseif ($this->_tpl_vars['setup_type'] == 'access'): ?>
				<tr class="tr_header">
					<td></td>
					<td></td>
					<td colspan="2" ></td>
					<td>
						<select name="s_category" onchange="return checkControl(this,'form_search')">
							<option value="0"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vo všetkých kategóriách')), $this); ?>
</option>
							<option value="-1" <?php if ($this->_tpl_vars['s_category'] == -1): ?>selected="selected"<?php endif; ?>><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'len nepriradené')), $this); ?>
</option>
							<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getOptionListBranch', 'catalog' => '$catalog_id', 'select' => $this->_tpl_vars['s_category'], 'type' => 'end')), $this); ?>

						</select>
					</td>
					<td width="100">
							<select name="access_default" id="access_default">
								<option value="<?php echo $this->_tpl_vars['ACCESS_PUBLIC']; ?>
" <?php if ($this->_tpl_vars['product_id']->getAccess() == $this->_tpl_vars['ACCESS_PUBLIC']): ?>selected="selected"<?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Verejné')), $this); ?>
</option>
								<option value="<?php echo $this->_tpl_vars['ACCESS_REGISTERED']; ?>
" <?php if ($this->_tpl_vars['product_id']->getAccess() == $this->_tpl_vars['ACCESS_REGISTERED']): ?>selected="selected"<?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Registrovaným')), $this); ?>
</option>
								<option value="<?php echo $this->_tpl_vars['ACCESS_SPECIAL']; ?>
" <?php if ($this->_tpl_vars['product_id']->getAccess() == $this->_tpl_vars['ACCESS_SPECIAL']): ?>selected="selected"<?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Skupiny používateľov')), $this); ?>
</option>
							</select>
					</td>
					<td width="22"><a href="javascript:setSelect('form1','access_default')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'prednastav')), $this); ?>
"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
					<td></td>
				</tr>
				<?php elseif ($this->_tpl_vars['setup_type'] == 'price'): ?>
				<tr class="tr_header">
					<td></td>

					<td colspan="2" ></td>
					<td>
						<select name="s_category" onchange="return checkControl(this,'form_search')">
							<option value="0"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vo všetkých kategóriách')), $this); ?>
</option>
							<option value="-1" <?php if ($this->_tpl_vars['s_category'] == -1): ?>selected="selected"<?php endif; ?>><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'len nepriradené')), $this); ?>
</option>
							<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getOptionListBranch', 'catalog' => '$catalog_id', 'select' => $this->_tpl_vars['s_category'], 'type' => 'end')), $this); ?>

						</select>
						<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Práva')), $this); ?>

						<select name="s_group" onchange="return changeGroup(this,<?php echo $this->_tpl_vars['mcmd']; ?>
,<?php echo $this->_tpl_vars['start']; ?>
);">
							<option  value="<?php echo $this->_tpl_vars['ACCESS_PUBLIC']; ?>
" <?php if ($this->_tpl_vars['selected_group'] == $this->_tpl_vars['ACCESS_PUBLIC']): ?> selected="selected" <?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Verejné')), $this); ?>
</option>
							<option  value="<?php echo $this->_tpl_vars['ACCESS_REGISTERED']; ?>
" <?php if ($this->_tpl_vars['selected_group'] == $this->_tpl_vars['ACCESS_REGISTERED']): ?> selected="selected" <?php endif; ?>><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Registrovaným')), $this); ?>
</option>

							<?php $_from = $this->_tpl_vars['group_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['group'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['group']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['group_detail']):
        $this->_foreach['group']['iteration']++;
?>
								<?php echo $this->_tpl_vars['group_detail']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

								<?php $this->assign('sel_group', $this->_tpl_vars['group_detail']->getId()); ?>
								<?php $this->assign('button_text', ($this->_tpl_vars['ACCESS_SPECIAL'])."-".($this->_tpl_vars['sel_group'])); ?>

								<option <?php if ($this->_tpl_vars['selected_group'] == $this->_tpl_vars['button_text']): ?> selected="selected" <?php endif; ?> value="<?php echo $this->_tpl_vars['ACCESS_SPECIAL']; ?>
-<?php echo $this->_tpl_vars['group_detail']->getId(); ?>
"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Skupina')), $this); ?>
:<?php echo $this->_tpl_vars['group_detail']->getTitle(); ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
						</select>
					</td><td></td>
					<td width="140">
							<input type="text" name="price_default" id="price_default" size="10">
							<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getAvailableCurrencies', 'assign' => 'currencies')), $this); ?>

							<input type="hidden" id="currency" name="currency" value="<?php echo $this->_tpl_vars['price_currency']; ?>
" />

							<select name="price_currency" onchange=" changeCurrency(this,<?php echo $this->_tpl_vars['mcmd']; ?>
,<?php echo $this->_tpl_vars['start']; ?>
); return true;">
							<?php $_from = $this->_tpl_vars['currencies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['currencies'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['currencies']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['currency']):
        $this->_foreach['currencies']['iteration']++;
?>
								<?php if ($this->_foreach['currencies']['iteration'] == 1): ?>
								  <?php $this->assign('sel_currency', $this->_tpl_vars['currency']); ?>
								<?php endif; ?>
								<?php if ($this->_tpl_vars['price_currency'] == $this->_tpl_vars['currency']): ?>
								  <?php $this->assign('sel_currency', $this->_tpl_vars['currency']); ?>
										<option selected><?php echo $this->_tpl_vars['currency']; ?>
</option>
								<?php else: ?>
										<option ><?php echo $this->_tpl_vars['currency']; ?>
</option>
								<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?>
							</select>
					</td>
					<td width="22"><a href="javascript:setSelect('form1','price_default')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'prednastav')), $this); ?>
">
						<img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
					<td></td>
				</tr>
				<?php elseif ($this->_tpl_vars['setup_type'] == 'stock'): ?>
				<tr class="tr_header">
					<td></td>
					<td></td>
					<td colspan="2" ></td>
					<td>
						<select name="s_category" onchange="return checkControl(this,'form_search')">
							<option value="0"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vo všetkých kategóriách')), $this); ?>
</option>
							<option value="-1" <?php if ($this->_tpl_vars['s_category'] == -1): ?>selected="selected"<?php endif; ?>><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'len nepriradené')), $this); ?>
</option>
							<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getOptionListBranch', 'catalog' => '$catalog_id', 'select' => $this->_tpl_vars['s_category'], 'type' => 'end')), $this); ?>

						</select>
					</td>
					<td width="90" >
							<input type="text" name="stock_default" id="stock_default" size="10">
					</td>
					<td width="22"><a href="javascript:setSelect('form1','stock_default')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'prednastav')), $this); ?>
"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
					<td></td>
				</tr>
				<?php elseif ($this->_tpl_vars['setup_type'] == 'visibility'): ?>
				<tr class="tr_header">
					<td></td>
					<td colspan="2" ></td>
					<td>
						<select name="s_category" onchange="return checkControl(this,'form_search')">
							<option value="0"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vo všetkých kategóriách')), $this); ?>
</option>
							<option value="-1" <?php if ($this->_tpl_vars['s_category'] == -1): ?>selected="selected"<?php endif; ?>><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'len nepriradené')), $this); ?>
</option>
							<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getOptionListBranch', 'catalog' => '$catalog_id', 'select' => $this->_tpl_vars['s_category'], 'type' => 'end')), $this); ?>

						</select>
					</td>
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

				<?php endif; ?>

			<?php $_from = $this->_tpl_vars['product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['product'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['product']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product_id']):
        $this->_foreach['product']['iteration']++;
?>

				<?php $this->assign('id', $this->_tpl_vars['product_id']->getId()); ?>
				<?php echo $this->_tpl_vars['product_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

				<?php $this->assign('defaultView', 0); ?>
				<?php if (( $this->_tpl_vars['product_id']->getTitle() == '' )): ?>
					<?php echo $this->_tpl_vars['product_id']->setContextLanguage($this->_tpl_vars['localLanguageDefault']); ?>

					<?php $this->assign('defaultView', 1); ?>
				<?php endif; ?>
				<tr>
					<td colspan="<?php echo $this->_tpl_vars['stlpcov']; ?>
" class="td_link_space"><input type="hidden" name="row_id[]" value="<?php echo $this->_tpl_vars['product_id']->getId(); ?>
"></td>
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

				<?php if (( $this->_tpl_vars['user_login']->checkPrivilege(1050002,$this->_tpl_vars['privilege_view']) == 1 )): ?>
				<?php $this->assign('showItem', 1); ?>
				<?php else: ?>
				<?php $this->assign('showItem', 0); ?>
				<?php endif; ?>

				<?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
					<?php $this->assign('showItem', 1); ?>
				<?php endif; ?>

				<?php if (( $this->_tpl_vars['user_login']->checkPrivilege(1050002,$this->_tpl_vars['privilege_update']) == 1 )): ?>
					<?php $this->assign('showItemEdit', 1); ?>
				<?php else: ?>
					<?php $this->assign('showItemEdit', 0); ?>
				<?php endif; ?>

				<?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
					<?php $this->assign('showItemEdit', 1); ?>
				<?php endif; ?>

				<tr id="row<?php echo $this->_foreach['product']['iteration']; ?>
" >
					<td class="td_align_center" style="line-height:20px;"><?php echo $this->_foreach['product']['iteration']+$this->_tpl_vars['start']; ?>
</td>
					<?php if ($this->_tpl_vars['setup_type'] == 'valid' || $this->_tpl_vars['setup_type'] == 'access' || $this->_tpl_vars['setup_type'] == 'price' || $this->_tpl_vars['setup_type'] == 'stock'): ?>
					<td><input onclick="setRowBgColor('form1',<?php echo $this->_foreach['product']['iteration']; ?>
)"  id="box<?php echo $this->_foreach['product']['iteration']; ?>
" type="checkbox" name="row_id[]" value="<?php echo $this->_tpl_vars['product_id']->getId(); ?>
" /></td>
					<?php endif; ?>
					<td>
						<?php if ($this->_tpl_vars['showItem'] == 1): ?>
							<a href="./?module=CMS_Catalog&mcmd=12&row_id[]=<?php echo $this->_tpl_vars['product_id']->getId(); ?>
">
								<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
									<?php echo $this->_tpl_vars['product_id']->getTitle(); ?>

								<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
							</a>
						<?php else: ?>
							<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
								<?php echo $this->_tpl_vars['product_id']->getTitle(); ?>

							<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
						<?php endif; ?>
					</td>
					<?php if ($this->_tpl_vars['setup_type'] != 'price'): ?>
					<td>
						<?php echo $this->_tpl_vars['product_id']->getCode(); ?>

					</td>
					<?php endif; ?>
					<td>
						<?php $_from = $this->_tpl_vars['product_id']->getParents(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['category_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['category_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['category_item']):
        $this->_foreach['category_list']['iteration']++;
?>
							<?php echo $this->_tpl_vars['category_item']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

							<?php echo $this->_tpl_vars['category_item']->getTitle(); ?>
,
						<?php endforeach; endif; unset($_from); ?>
					</td>
					<?php if ($this->_tpl_vars['setup_type'] == 'visibility'): ?>

						<td class="td_align_center">
							<input <?php if ($this->_tpl_vars['showItemEdit'] == 0): ?>disabled="disabled"<?php endif; ?> id="visibility<?php echo $this->_foreach['product']['iteration']; ?>
" name="visibility[<?php echo $this->_tpl_vars['product_id']->getId(); ?>
]" type="checkbox" value="1" <?php if ($this->_tpl_vars['product_id']->getIsPublished() == 1): ?>checked="checked"<?php endif; ?>>
						</td>
						<?php $_from = $this->_tpl_vars['LanguageListLocal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_id']):
        $this->_foreach['language']['iteration']++;
?>
						<?php $this->assign('triedaLang', 'class="hrefyeslang"'); ?>
						<?php echo $this->_tpl_vars['product_id']->setContextLanguage($this->_tpl_vars['language_id']['code']); ?>

						<?php if (( $this->_tpl_vars['product_id']->getTitle() == '' )): ?><?php $this->assign('triedaLang', 'class="hrefnolang"'); ?><?php endif; ?>
							<td><input <?php if ($this->_tpl_vars['showItemEdit'] == 0): ?>disabled="disabled"<?php endif; ?> id="language<?php echo $this->_tpl_vars['language_id']['code']; ?>
<?php echo $this->_foreach['product']['iteration']; ?>
" type="checkbox" name="a_languageIsVisible<?php echo $this->_tpl_vars['language_id']['code']; ?>
[<?php echo $this->_tpl_vars['product_id']->getId(); ?>
]" value="1" <?php if ($this->_tpl_vars['product_id']->getLanguageIsVisible() == 1): ?>checked="checked"<?php endif; ?>></td>
						<?php endforeach; endif; unset($_from); ?>

					<?php elseif ($this->_tpl_vars['setup_type'] == 'valid'): ?>
						<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'makeCalendar', 'nazov' => "validfrom['".($this->_tpl_vars['id'])."']", 'id' => $this->_foreach['product']['iteration'], 'value' => $this->_tpl_vars['product_id']->getValidFrom())), $this); ?>
</td>
						<td></td>
						<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'makeCalendar', 'nazov' => "validto['".($this->_tpl_vars['id'])."']", 'id' => $this->_foreach['product']['iteration'], 'value' => $this->_tpl_vars['product_id']->getValidTo())), $this); ?>
</td>
						<td></td>
					<?php elseif ($this->_tpl_vars['setup_type'] == 'image'): ?>

						<?php 
							$path = "../mediafiles/".$GLOBALS['smarty']->get_template_vars(product_id)->getImage();
							$name = basename($path);
							$GLOBALS["smarty"]->assign("icon_name",$name);
							$GLOBALS["smarty"]->assign("icon_path",$path);
						 ?>

						<td width="100"><input size=50 type="text" name="image[<?php echo $this->_tpl_vars['id']; ?>
]" id="image<?php echo $this->_tpl_vars['id']; ?>
" value="<?php echo $this->_tpl_vars['product_id']->getImage(); ?>
" /></td>
						<td width="22"><a href="javascript:insertfile('form1','image<?php echo $this->_tpl_vars['id']; ?>
')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vlož obrázok')), $this); ?>
"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
						<?php if (( $this->_tpl_vars['product_id']->getImage() == '' )): ?>
	                     	<td width="22"></td>
	                  	<?php else: ?>
	                      	<td width="22">&nbsp;<a  href="<?php echo $this->_tpl_vars['icon_path']; ?>
" target="_blank" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ukáž')), $this); ?>
"><img src="../themes/default/images/view_s.png" border="0"></a></td>
	                  	<?php endif; ?>

					<?php elseif ($this->_tpl_vars['setup_type'] == 'access'): ?>

						<td>
							<select name="access[<?php echo $this->_tpl_vars['id']; ?>
]" id="access<?php echo $this->_foreach['product']['iteration']; ?>
">
								<option value="<?php echo $this->_tpl_vars['ACCESS_PUBLIC']; ?>
" <?php if ($this->_tpl_vars['product_id']->getAccess() == $this->_tpl_vars['ACCESS_PUBLIC']): ?>selected="selected"<?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Verejné')), $this); ?>
</option>
								<option value="<?php echo $this->_tpl_vars['ACCESS_REGISTERED']; ?>
" <?php if ($this->_tpl_vars['product_id']->getAccess() == $this->_tpl_vars['ACCESS_REGISTERED']): ?>selected="selected"<?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Registrovaným')), $this); ?>
</option>
								<option value="<?php echo $this->_tpl_vars['ACCESS_SPECIAL']; ?>
" <?php if ($this->_tpl_vars['product_id']->getAccess() == $this->_tpl_vars['ACCESS_SPECIAL']): ?>selected="selected"<?php endif; ?> ><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Skupiny používateľov')), $this); ?>
</option>
							</select>
						</td>
						<td></td>

					<?php elseif ($this->_tpl_vars['setup_type'] == 'price'): ?>
					<td>
						<?php echo $this->_tpl_vars['product_id']->getCode(); ?>

					</td>
						<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getPrice', 'id' => $this->_tpl_vars['id'], 'currency' => $this->_tpl_vars['sel_currency'], 'assign' => 'price', 'access' => $this->_tpl_vars['selected_group'])), $this); ?>

						<td>
							<input type="text" name="price[<?php echo $this->_tpl_vars['id']; ?>
][<?php echo $this->_tpl_vars['price']['id']; ?>
]" id="access<?php echo $this->_foreach['product']['iteration']; ?>
" size="10" value="<?php echo $this->_tpl_vars['price']['price']; ?>
">
						</td>
						<td></td>
					<?php elseif ($this->_tpl_vars['setup_type'] == 'news'): ?>

						<td>
							<input id="news<?php echo $this->_foreach['product']['iteration']; ?>
" name="news[<?php echo $this->_tpl_vars['product_id']->getId(); ?>
]" type="checkbox" value="1" <?php if ($this->_tpl_vars['product_id']->getIsNews() == 1): ?>checked="checked"<?php endif; ?>>
						</td>
						<td></td>
					<?php elseif ($this->_tpl_vars['setup_type'] == 'sale'): ?>

						<td>
							<input id="sale<?php echo $this->_foreach['product']['iteration']; ?>
" name="sale[<?php echo $this->_tpl_vars['product_id']->getId(); ?>
]" type="checkbox" value="1" <?php if ($this->_tpl_vars['product_id']->getIsSale() == 1): ?>checked="checked"<?php endif; ?>>
						</td>
						<td></td>
					<?php elseif ($this->_tpl_vars['setup_type'] == 'stock'): ?>
						<td>
							<input type="text" name="stock[<?php echo $this->_tpl_vars['product_id']->getId(); ?>
]" id="access<?php echo $this->_foreach['product']['iteration']; ?>
" size="10" value="<?php echo $this->_tpl_vars['product_id']->getInStock(); ?>
">
						</td>
						<td></td>
					<?php endif; ?>
					<td class="td_align_center"><?php echo $this->_tpl_vars['product_id']->getId(); ?>
</td>

				</tr>
			<?php endforeach; endif; unset($_from); ?>
				</form>
			</table>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "Proxia:default.pager", 'smarty_include_vars' => array('list' => $this->_tpl_vars['product_list'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<br />
		</td>
	</tr>

	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>