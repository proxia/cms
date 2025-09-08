<?php /* Smarty version 2.6.30, created on 2019-05-17 11:40:01
         compiled from attribut_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'tr', 'attribut_list.tpl', 94, false),array('insert', 'getOptionListBranch', 'attribut_list.tpl', 175, false),array('insert', 'merge', 'attribut_list.tpl', 186, false),)), $this); ?>
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

		<?php $_from = $this->_tpl_vars['attribut_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['attribut'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attribut']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['attribut_id']):
        $this->_foreach['attribut']['iteration']++;
?>
			hiddencombo(<?php echo $this->_foreach['attribut']['iteration']; ?>
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
</script>
'; ?>

<?php $this->assign('title', 'Atribúty / prehľad'); ?>
<table class="tb_middle">
	<tr>
		<td colspan="3"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "title_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
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
		<td class="td_link_h"><img src="themes/default/images/pixel.gif" width="2" /></td>
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
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Priradiť k produktom')), $this); ?>
</td>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Odobrať z produktov')), $this); ?>
</td>
					<td class="td_align_center"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ID')), $this); ?>
</td>
				</tr>
				<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
				<input type="hidden" id="mcmd" name="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
				<input type="hidden" id="section" name="section" value="attribut" />
				<input type="hidden" id="go" name="go" value="list" />
				
<?php echo '
<script language="javascript">
window.onload = init; 
remo_x_pos = 0;
remo_y_pos = 0;
		
function init() {
 if (window.Event) {
 document.captureEvents(Event.MOUSEMOVE);
 } 
  document.onmousemove = getPosition;
 } 
 
 function getPosition(e) {
     e = e || window.event;
     var cursor = {x:0, y:0};
     if (e.pageX || e.pageY) {
         cursor.x = e.pageX;
         cursor.y = e.pageY;
     }
     else {
         cursor.x = e.clientX +
             (document.documentElement.scrollLeft ||
             document.body.scrollLeft) -
             document.documentElement.clientLeft;
         cursor.y = e.clientY +
             (document.documentElement.scrollTop ||
             document.body.scrollTop) -
             document.documentElement.clientTop;
     }
     remo_x_pos = cursor.x;
     remo_y_pos = cursor.y;

     return cursor;
}

 
function showDivCombo(row_selected){
            //alert (x_pos + " " + y_pos);
       sel_value = 2;
       '; ?>

       selectall('form1', 1,<?php echo $this->_tpl_vars['max_list']; ?>
)
       <?php echo '
       row = \'box\'+row_selected;
       document.forms[\'form1\'].elements[row].checked = true;
      if (document.all) {
        var remo_float_menu = document.all("divko2");
      } else if (document.layers) {
         var remo_float_menu = document.layers("divko2");
      } else if (document.getElementById) {
         var remo_float_menu = document.getElementById("divko2");
      } 
 
      remo_float_menu.style.left = remo_x_pos+"px";
      remo_float_menu.style.top = remo_y_pos-18+"px";  
      remo_float_menu.style.display = \'block\';
      //alert (remo_y_pos);

}
function divko_hidden(){
	  if (document.all) {
        var remo_float_menu = document.all("divko2");
      } else if (document.layers) {
         var remo_float_menu = document.layers("divko2");
      } else if (document.getElementById) {
         var remo_float_menu = document.getElementById("divko2");
      } 
      remo_float_menu.style.display = \'none\';
}
</script>
'; ?>

	<div id="divko2" name="divko2" style="padding:5px;text-align:right;display:none;height:40px;background-color:#f7e2d7;position:absolute;border:1px dotted gray">
		<span all><a href="javascript:divko_hidden()"><img src="../themes/default/images/delete_s.gif" /></a>
		<br />
		<?php if (is_object ( $this->_tpl_vars['attribut_id'] )): ?>
		<select name="filter_branch[<?php echo $this->_tpl_vars['attribut_id']->getId(); ?>
]" onchange="form1.submit()">
			<option value=""></option>
			<option value="nofilter"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'zobraz všetky produkty')), $this); ?>
</option>
			<option value="-1"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'nepriradené produkty')), $this); ?>
</option>
			<optgroup label="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'filter podľa kategórií')), $this); ?>
">
			<?php echo $this->_tpl_vars['strom']; ?>

			</optgroup>
		</select>
		<?php endif; ?>
	</div>
	
	
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

				<tr>
					<td colspan="<?php echo $this->_tpl_vars['stlpcov']; ?>
" class="td_link_space"></td>
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
            
			<?php if (( ( $this->_tpl_vars['user_login']->checkPrivilege(1050002,$this->_tpl_vars['privilege_update']) == 1 ) || ( $this->_tpl_vars['user_login']->checkPrivilege(1050002,$this->_tpl_vars['privilege_delete']) == 1 ) || ( $this->_tpl_vars['user_login']->checkPrivilege(1050002,$this->_tpl_vars['privilege_add']) == 1 ) )): ?>
           		<?php $this->assign('showCheckbox', 1); ?>
        	<?php else: ?>
				<?php $this->assign('showCheckbox', 0); ?>
        	<?php endif; ?>
        	
        	<?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
            	<?php $this->assign('showCheckbox', 1); ?>
       		<?php endif; ?>
       		
				<tr id="row<?php echo $this->_foreach['attribut']['iteration']; ?>
" onmouseover="pozadieIN('form1','<?php echo $this->_foreach['attribut']['iteration']; ?>
')" onmouseout="pozadieOUT('form1','<?php echo $this->_foreach['attribut']['iteration']; ?>
')">
					<td class="td_align_center"><?php echo $this->_foreach['attribut']['iteration']+$this->_tpl_vars['start']; ?>
</td>
					<td><input <?php if ($this->_tpl_vars['showCheckbox'] == 0): ?>disabled="disabled"<?php endif; ?> onclick="setRowBgColor('form1',<?php echo $this->_foreach['attribut']['iteration']; ?>
)"  id="box<?php echo $this->_foreach['attribut']['iteration']; ?>
" type="checkbox" name="row_id[]" value="<?php echo $this->_tpl_vars['attribut_id']->getId(); ?>
" /></td>
					<td>
						<?php if ($this->_tpl_vars['showItem'] == 1): ?>
							<a href="./?module=CMS_Catalog&mcmd=9&row_id[]=<?php echo $this->_tpl_vars['attribut_id']->getId(); ?>
">
								<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
									<?php echo $this->_tpl_vars['attribut_id']->getTitle(); ?>

								<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
							</a>
						<?php else: ?>
							<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewStartTag']; ?>
<?php endif; ?>
								<?php echo $this->_tpl_vars['attribut_id']->getTitle(); ?>

							<?php if ($this->_tpl_vars['defaultView'] == 1): ?><?php echo $this->_tpl_vars['defaultViewEndTag']; ?>
<?php endif; ?>
						<?php endif; ?>
					</td>
					<td class="td_align_center" <?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>onclick="showDivCombo(<?php echo $this->_foreach['attribut']['iteration']; ?>
)"<?php endif; ?>>
						<img src="../themes/default/images/filter_s.gif" />
					</td>
					<td class="td_align_center">
						<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
							<a href="./?mcmd=14&module=CMS_Catalog&row_id[]=<?php echo $this->_tpl_vars['attribut_id']->getId(); ?>
"><img src="../themes/default/images/remove_s.gif" /></a>
						<?php else: ?>
							<img src="../themes/default/images/remove_s.gif" />
						<?php endif; ?>
					</td>
					<td class="td_align_center"><?php echo $this->_tpl_vars['attribut_id']->getId(); ?>
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