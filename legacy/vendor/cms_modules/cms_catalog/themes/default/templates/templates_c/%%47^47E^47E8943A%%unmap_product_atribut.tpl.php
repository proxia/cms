<?php /* Smarty version 2.6.30, created on 2019-05-17 10:54:23
         compiled from unmap_product_atribut.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'tr', 'unmap_product_atribut.tpl', 76, false),array('insert', 'merge', 'unmap_product_atribut.tpl', 167, false),array('insert', 'getAttributValue', 'unmap_product_atribut.tpl', 204, false),)), $this); ?>
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
</script>
'; ?>

<?php echo $this->_tpl_vars['detail_product']->setContextLanguage(($this->_tpl_vars['localLanguage'])); ?>

<?php $this->assign('title_product', $this->_tpl_vars['detail_product']->getTitle()); ?>
<?php 
	$title = tr('Vymazanie produktu ') ;
	$title .= $GLOBALS['smarty']->get_template_vars(title_product);
	$title .= tr(' z atribútov');
	$GLOBALS["smarty"]->assign("title",$title);
 ?>

<table class="tb_middle">
	<tr>
		<td colspan="3"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "title_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
	
	<?php $_from = $this->_tpl_vars['attribut_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['attribut'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attribut']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['attribut_id']):
        $this->_foreach['attribut']['iteration']++;
?>
	<?php endforeach; endif; unset($_from); ?>
	<?php $this->assign('max_list', $this->_foreach['attribut']['iteration']); ?>
	<tr>
		<td class="td_middle_left">
		<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'merge', 'value1' => $this->_tpl_vars['path_relative'], 'value2' => 'themes/default/scripts/toolbar.php', 'assign' => 'path_toolbar')), $this); ?>

		<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => $this->_tpl_vars['path_toolbar'], 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

		</td>
		<td class="td_link_h"><img src="../themes/default/images/pixel.gif" width="2" /></td>
		<td class="td_middle_center">
			<table class="tb_list2">
				<?php $this->assign('stlpcov', 6); ?>
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form1',1,<?php echo $this->_tpl_vars['max_list']; ?>
)" /></td>
					<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov atribútu')), $this); ?>
</td>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Hodnota atribútu pre produkt')), $this); ?>
 - <?php echo $this->_tpl_vars['detail_product']->getTitle(); ?>
</td>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ID atribútu')), $this); ?>
</td>
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
				<input type="hidden" id="section" name="section" value="unmapproducttoattribut" />
				<input type="hidden" id="product_id" name="product_id" value="<?php echo $this->_tpl_vars['detail_product']->getId(); ?>
" />
				<input type="hidden" id="start" name="start" value="<?php echo $this->_tpl_vars['start']; ?>
" />
			<?php $_from = $this->_tpl_vars['attribut_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['attribut'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attribut']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['attribut_id']):
        $this->_foreach['attribut']['iteration']++;
?>
				<input type="hidden" name="map_id[<?php echo $this->_tpl_vars['attribut_id']->getAttributeDefinitionId(); ?>
]" value="<?php echo $this->_tpl_vars['attribut_id']->getId(); ?>
" />
				<?php echo $this->_tpl_vars['attribut_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

				<tr>
					<td colspan="<?php echo $this->_tpl_vars['stlpcov']; ?>
" class="td_link_space"></td>
				</tr>
				<tr id="row<?php echo $this->_foreach['attribut']['iteration']; ?>
" onmouseover="pozadieIN('form1','<?php echo $this->_foreach['attribut']['iteration']; ?>
')" onmouseout="pozadieOUT('form1','<?php echo $this->_foreach['attribut']['iteration']; ?>
')">
					<td class="td_align_center"><?php echo $this->_foreach['attribut']['iteration']; ?>
</td>
					<td><input onclick="setRowBgColor('form1',<?php echo $this->_foreach['attribut']['iteration']; ?>
)" id="box<?php echo $this->_foreach['attribut']['iteration']; ?>
" type="checkbox" name="row_id[]" value="<?php echo $this->_tpl_vars['attribut_id']->getAttributeDefinitionId(); ?>
" /></td>
					<td>
						<?php $this->assign('attribut_name', $this->_tpl_vars['attribut_id']->getAttributeDefinitionId()); ?>
						<a href="./?module=CMS_Catalog&mcmd=9&row_id[]=<?php echo $this->_tpl_vars['attribut_id']->getAttributeDefinitionId(); ?>
">
							<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
								<?php echo $this->_tpl_vars['attribut_product_list_title'][$this->_tpl_vars['attribut_name']]; ?>

							<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
						</a>
					</td>
					<td class="td_align_center">
						<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getAttributValue', 'productId' => $this->_tpl_vars['detail_product']->getId(), 'attributId' => $this->_tpl_vars['attribut_id']->getAttributeDefinitionId())), $this); ?>

					</td>
					<td class="td_align_center"><?php echo $this->_tpl_vars['attribut_id']->getAttributeDefinitionId(); ?>
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