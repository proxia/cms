<?php /* Smarty version 2.6.30, created on 2019-05-17 14:33:03
         compiled from map_atribut_product.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'tr', 'map_atribut_product.tpl', 75, false),array('insert', 'merge', 'map_atribut_product.tpl', 166, false),array('insert', 'getMapId', 'map_atribut_product.tpl', 187, false),array('insert', 'getAttributValue', 'map_atribut_product.tpl', 216, false),)), $this); ?>
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

<?php echo $this->_tpl_vars['detail_attribut']->setContextLanguage(($this->_tpl_vars['localLanguage'])); ?>

<?php $this->assign('title_attrib', $this->_tpl_vars['detail_attribut']->getTitle()); ?>
<?php 
	$title = tr('Priradenie atribútu ') ;
	$title .= $GLOBALS['smarty']->get_template_vars(title_attrib);
	$title .= tr(' k produktom');
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
			<table class="tb_list2">
				<?php $this->assign('stlpcov', 7); ?>
				<tr class="tr_header">
					<td class="td_align_center">#</td>
					<td><input title="vybrať všetko / zrušiť všetko" id="ab" type="checkbox" name="selectall" value="1" onclick="selectall('form1',1,<?php echo $this->_tpl_vars['max_list']; ?>
)" /></td>
					<td></td>
					<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov produktu')), $this); ?>
</td>
					<td><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Kód')), $this); ?>
</td>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Hodnota atribútu')), $this); ?>
 - <?php echo $this->_tpl_vars['detail_attribut']->getTitle(); ?>
</td>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ID produktu')), $this); ?>
</td>
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
				<input type="hidden" id="section" name="section" value="mapattributtoproduct" />
				<input type="hidden" id="attribut_id" name="attribut_id" value="<?php echo $this->_tpl_vars['detail_attribut']->getId(); ?>
" />
			<?php $_from = $this->_tpl_vars['product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['product'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['product']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product_id']):
        $this->_foreach['product']['iteration']++;
?>
					<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getMapId', 'productId' => $this->_tpl_vars['product_id']->getId(), 'attributId' => $this->_tpl_vars['detail_attribut']->getId(), 'assign' => 'mapId')), $this); ?>

				<input type="hidden" name="map_id[<?php echo $this->_tpl_vars['product_id']->getId(); ?>
]" value="<?php echo $this->_tpl_vars['mapId']; ?>
" />
				<?php echo $this->_tpl_vars['product_id']->setContextLanguage($this->_tpl_vars['localLanguage']); ?>

				<?php $this->assign('defaultView', 0); ?>
				<?php if (( $this->_tpl_vars['product_id']->getTitle() == '' )): ?>
					<?php echo $this->_tpl_vars['product_id']->setContextLanguage($this->_tpl_vars['localLanguageDefault']); ?>

					<?php $this->assign('defaultView', 1); ?>
				<?php endif; ?>

				<tr>
					<td colspan="<?php echo $this->_tpl_vars['stlpcov']; ?>
" class="td_link_space"></td>
				</tr>
				<tr id="row<?php echo $this->_foreach['product']['iteration']; ?>
" onmouseover="pozadieIN('form1','<?php echo $this->_foreach['product']['iteration']; ?>
')" onmouseout="pozadieOUT('form1','<?php echo $this->_foreach['product']['iteration']; ?>
')">
					<td class="td_align_center"><?php echo $this->_foreach['product']['iteration']; ?>
</td>
					<td><input onclick="setRowBgColor('form1',<?php echo $this->_foreach['product']['iteration']; ?>
)" id="box<?php echo $this->_foreach['product']['iteration']; ?>
" type="checkbox" name="row_id[]" value="<?php echo $this->_tpl_vars['product_id']->getId(); ?>
" /></td>
					<td>
						<?php if ($this->_tpl_vars['mapId'] > 0): ?>
							<img src="../themes/default/images/weblink_s.gif" />
						<?php endif; ?>
					</td>
					<td>
						<a href="./?module=CMS_Catalog&mcmd=12&row_id[]=<?php echo $this->_tpl_vars['product_id']->getId(); ?>
">
							<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
								<?php echo $this->_tpl_vars['product_id']->getTitle(); ?>

							<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
						</a>
					</td>
					<td><?php echo $this->_tpl_vars['product_id']->getCode(); ?>
</td>
					<td class="td_align_center">
						<input type="text" name="attribut_value[<?php echo $this->_tpl_vars['product_id']->getId(); ?>
]" size="30" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getAttributValue', 'productId' => $this->_tpl_vars['product_id']->getId(), 'attributId' => $this->_tpl_vars['detail_attribut']->getId())), $this); ?>
">
					</td>
					<td class="td_align_center"><?php echo $this->_tpl_vars['product_id']->getId(); ?>
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