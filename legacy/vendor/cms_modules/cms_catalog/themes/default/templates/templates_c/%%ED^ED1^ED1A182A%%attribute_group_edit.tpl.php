<?php /* Smarty version 2.6.30, created on 2019-05-17 14:32:13
         compiled from attribute_group_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'check', 'attribute_group_edit.tpl', 58, false),array('insert', 'merge', 'attribute_group_edit.tpl', 67, false),array('insert', 'tr', 'attribute_group_edit.tpl', 77, false),array('insert', 'getExistsAttribut', 'attribute_group_edit.tpl', 145, false),)), $this); ?>
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

function checkdelete(form,msg,msg2){
		isChecked = false;
		for(i=0;i<form.remove_attribut_id.length;i++){
			if(form.remove_attribut_id[i].checked){
				isChecked = true;
			}
		}
		if(isChecked){
     var is_confirmed = confirm(msg);
   	 return is_confirmed;		
		}

		alert(msg2)
		return false;
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

<?php $this->assign('title', 'Skupina atribútov / detail'); ?>
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
			<table width="100%" border="0">
				<tr>
					<td class="td_valign_top" width="70%">
							<table class="tb_list"  >
							<tr class="tr_header">
								<td colspan="4">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Detail skupiny atribútov')), $this); ?>
</td>
							</tr>
							<form name="form1" id="form1" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
							<input type="hidden" id="mcmd" name="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
							<input type="hidden" id="row_id[]" name="row_id[]" value="<?php echo $this->_tpl_vars['detail_attribut']->getId(); ?>
" />
							<input type="hidden" id="section" name="section" value="group_attribute" />
							<?php echo $this->_tpl_vars['detail_attribut']->setContextLanguage(($this->_tpl_vars['localLanguage'])); ?>

							<tr><td colspan="4" class="td_link_space"></td></tr>
							<tr>
								<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov')), $this); ?>
*</td>
								<td width="85%" colspan="4"><input size="60" type="text" name="f_title" id="f_title" value="<?php echo $this->_tpl_vars['detail_attribut']->getTitle(); ?>
" /></td>
							</tr>
							<tr>
								<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Popis')), $this); ?>
</td>
								<td width="85%" colspan="4"><input size="60" type="text" name="f_description" id="f_description" value="<?php echo $this->_tpl_vars['detail_attribut']->getDescription(); ?>
" /></td>
							</tr>
							<?php 
								$path = "..{$GLOBALS['project_folder']}/".$_SESSION['user']['name']."/mediafiles/".$GLOBALS['smarty']->get_template_vars(detail_attribut)->getImage();
								$name = basename($path);
								$GLOBALS["smarty"]->assign("icon_name",$name);
								$GLOBALS["smarty"]->assign("icon_path",$path);
							 ?> 
							<tr>
								<td>&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Obrázok')), $this); ?>
</td>
								<td width="30%"><input size="40" type="text" name="f_image" id="f_image" value="<?php echo $this->_tpl_vars['detail_attribut']->getImage(); ?>
" /></td>
				            	<td width="22"><a href="javascript:insertfile('form1','f_image')" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'vlož obrázok')), $this); ?>
"><img src="../themes/default/images/paste.gif" width="21" height="21" border="0"></a></td>
								<?php if (( $this->_tpl_vars['detail_attribut']->getImage() == '' )): ?>
			            	<td width=22>&nbsp;</td>
			         	<?php else: ?>
			             	<td width="50%">&nbsp;<a  href="<?php echo $this->_tpl_vars['icon_path']; ?>
" target="_blank" title="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'ukáž')), $this); ?>
"><img src="../themes/default/images/view_s.png" border="0"></a></td>
			         	<?php endif; ?>
				       </tr>
						</form>
						</table>
					</td>

					<td class="td_valign_top">
						<table align="center" class="tb_tabs">
							<tr class="tr_header_tab">
							<td colspan="2" class="td_tabs_top">
							<?php echo $this->_tpl_vars['menu2']; ?>

							</td>
							</tr>
							<tr><td class="td_valign_top" colspan="2">

								<div id="item1" style="visibility: hidden;">
								<table class="tb_list_in_tab">
								<form name="form5" id="form5" method="post" action="/vendor/cms_modules/cms_catalog/action.php">
								<input type="hidden" name="section" id="section" value="map_attribute_to_group" />
								<input type="hidden" name="mcmd" id="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
								<input type="hidden" id="showtable" name="showtable" value="0" />
								<input type="hidden" name="group_id" id="group_id" value="<?php echo $this->_tpl_vars['detail_attribut']->getId(); ?>
" />
								<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_attribut']->getId(); ?>
" />								
									<tr class="tr_header">
											<td colspan="6">&nbsp;<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Priradenie atribútu')), $this); ?>
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
echo smarty_core_run_insert_handler(array('args' => array('name' => 'getExistsAttribut', 'groupId' => $this->_tpl_vars['detail_attribut']->getId(), 'attributId' => $this->_tpl_vars['attribut_id']->getId(), 'assign' => 'is_existsAttribut')), $this); ?>

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
										<td>
										<?php $this->assign('showItemEdit', 0); ?>
							
				    				<?php if (( $this->_tpl_vars['user_login']->checkPrivilege(1050001,$this->_tpl_vars['privilege_update']) == 1 )): ?>
				                <?php $this->assign('showItemEdit', 1); ?>
				            <?php else: ?>
				                <?php $this->assign('showItemEdit', 0); ?>
				            <?php endif; ?>
	
				            <?php if (( $this->_tpl_vars['user_login_type'] == $this->_tpl_vars['admin_user'] )): ?>
				                <?php $this->assign('showItemEdit', 1); ?>
				            <?php endif; ?>
				            <?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
												<input class="button" type="submit" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Priraďiť ku skupine')), $this); ?>
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
	
									</tr>
								<form method="post" id="attribut" name="attribut" action="/vendor/cms_modules/cms_catalog/action.php" onsubmit="return checkdelete(this,'<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Zrušiť väzbu ')), $this); ?>
 ?','<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Žiadan položka nie je vybratá!')), $this); ?>
')">
								<input type="hidden" name="section" id="section" value="unmap_attribute_to_group" />
								<input type="hidden" name="mcmd" id="mcmd" value="<?php echo $this->_tpl_vars['mcmd']; ?>
" />
								<input type="hidden" name="group_id" id="group_id" value="<?php echo $this->_tpl_vars['detail_attribut']->getId(); ?>
" />								
								<input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $this->_tpl_vars['detail_attribut']->getId(); ?>
" />
								<input type="hidden" id="showtable" name="showtable" value="1" />
									<?php $_from = $this->_tpl_vars['attribut_branch_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['attribut_branch'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attribut_branch']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['attribut_branch_id']):
        $this->_foreach['attribut_branch']['iteration']++;
?>
									<?php endforeach; endif; unset($_from); ?>
									<?php $this->assign('max_list', $this->_foreach['attribut_branch']['iteration']); ?>
		
									<?php $_from = $this->_tpl_vars['attribut_branch_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['attribut_branch'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attribut_branch']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['attribut_branch_id']):
        $this->_foreach['attribut_branch']['iteration']++;
?>
									
									<?php $this->assign('attribut_name', $this->_tpl_vars['attribut_branch_id']->getAttributeDefinitionId()); ?>
									<tr>
										<td class="bold">&nbsp;&nbsp;<a href="./?mcmd=9&module=CMS_Catalog&row_id[]=<?php echo $this->_tpl_vars['attribut_branch_id']->getId(); ?>
"><?php echo $this->_tpl_vars['attribut_branch_list_title'][$this->_tpl_vars['attribut_name']]; ?>
</a></td>
										<td colspan="2"></td>
										<td></td>
										<td class="td_align_center"><input type="checkbox" name="remove_attribut_id[]" id="remove_attribut_id" value="<?php echo $this->_tpl_vars['attribut_branch_id']->getId(); ?>
"></td>
	
									</tr>
					
									<tr><td colspan="6"><hr></td></tr>
								
									<?php endforeach; endif; unset($_from); ?>
								
									<tr><td colspan="6"  class="td_align_center"><br>
									<?php if ($this->_tpl_vars['showItemEdit'] == 1): ?>
									<input type="submit" name="attach_update" value="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Označené položky vymazať')), $this); ?>
">
									<?php endif; ?>
									<br><br></td></tr>
								</form>
								</table>
								</td>
								</tr>
								</table>
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