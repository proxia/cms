<?php /* Smarty version 2.6.30, created on 2019-05-17 14:32:30
         compiled from attribut_new.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'tr', 'attribut_new.tpl', 45, false),array('insert', 'check', 'attribut_new.tpl', 105, false),array('insert', 'merge', 'attribut_new.tpl', 114, false),)), $this); ?>
<?php echo '
<script language="JavaScript" type="text/javascript">
function addelement(act_type,act_value){
	var newelement = document.createElement(\'INPUT\'); 
	newelement.type = \'hidden\'; 
	newelement.name = act_type; 
	newelement.value = act_value;
	document.form1.appendChild(newelement)
} 

function insertfile(form_name,form_text_name){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("./?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
} 

function submitform(act_type,act_value){
	addelement(act_type,act_value);
	try {
		document.form1.onsubmit();
		}
	catch(e){}
		document.form1.submit();
}

		var numRows = 1;
		var scrollCount = 0;

function addRow(id, addheight, skip_add) {
	var html = "";

	//if (!skip_add)
		numRows++;

	scrollCount++;

	var elm = document.createElement("div");
	elm.id = \'row_\' + numRows;
			
		html += \'	<table class="tb_list">\';
			html += \'	<tr>\';
			'; ?>

				html += '	<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Odpoveď')), $this); ?>
 '+numRows+'* </td>';
				<?php echo '
				html += \'	<td width="85%"><input size="50" type="text" name="p__odpoved\' +  numRows + \'" id="p__odpoved" />&nbsp;&nbsp;<a href="javascript:delRow(\\\'row_\'+ numRows +\'\\\')">&nbsp;<img src="themes/default/images/form_delete.gif" alt="Remove" title="Remove" border="0" /></a></td>\';
			html += \'	</tr>\';
			html += \'</table>\';

	elm.innerHTML = html;

	document.getElementById(id).appendChild(elm);
	document.forms[\'uploadForm\'].numfiles.value = numRows;
}

function delRow(id) {
	var elm = document.getElementById(id);
	if (elm) {
		elm.parentNode.removeChild(elm);
		scrollCount--;
		document.forms[\'uploadForm\'].numfiles.value = (document.forms[\'uploadForm\'].numfiles.value - 1);
	}
}

function validateForm(form) {

	var elements = form1.elements;

	for (i=0; i<elements.length; i++) {
	
		var name = elements[i].getAttribute("name");
		var value = elements[i].value;

		if ( (name == null) || (name == "mcmd") || (name == "row_id[]") || (name == "f_isPublished") || (name == "section") )
			continue;

		//var indexfilename = name.indexOf("filename");
		//var indexfile = name.indexOf("file");
		//var isFile = (name.indexOf("file") == 0) ? true : false;
		

			if (value == "") {
			'; ?>

				alert('<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'nezadali ste povinnú položku')), $this); ?>
');
			<?php echo '
				return false;			
			}
	}

	form1.submit();
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

<?php $this->assign('title', 'Atribút / nový'); ?>
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
			<table class="tb_list">

				<tr class="tr_header">
					<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Detail atribútu')), $this); ?>
</td>
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
				<input type="hidden" id="row_id[]" name="row_id[]" value="0" />
				<input type="hidden" id="section" name="section" value="attribut" />
				<tr><td class="td_link_space"></td></tr>
				<tr>
					<td>
						<table>
							<tr>
								<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov')), $this); ?>
*</td>
								<td colspan="2"><input size="60" type="text" name="f_title" id="f_title" /></td>
							</tr>
							<tr>
								<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Popis')), $this); ?>
*</td>
								<td colspan="2"><input size="60" type="text" name="f_description" id="f_description" /></td>
							</tr>
							<tr>
								<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Obrázok')), $this); ?>
*</td>
								<td>
									<input size="40" type="text" name="f_image" id="f_image" />
								</td>
								<td width="22"><a href="javascript:insertfile('form1','f_image')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vlož obrázok')), $this); ?>
"><img src="themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
							</tr>
						</table>
					</td>
				</tr>
				
			</table>
			</form>
		</td>
	</tr>
	<tr><td colspan="3" class="td_link_v"></td></tr>
</table>