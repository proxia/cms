<?php /* Smarty version 2.6.30, created on 2019-05-16 20:37:59
         compiled from Proxia:default.sort_table_catalog_branch */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'tr', 'Proxia:default.sort_table_catalog_branch', 15, false),array('insert', 'merge', 'Proxia:default.sort_table_catalog_branch', 70, false),)), $this); ?>
<?php echo '<script type="text/javascript" src="js/prototype.js"></script><script type="text/javascript" src="js/SortTable.js"></script><style type="text/css">@import url(\'css/SortTable.css\');</style>'; ?><?php echo '
<script language="JavaScript" type="text/javascript">

'; ?><?php echo 'var parent_id = '; ?><?php echo $this->_tpl_vars['parent_id']; ?><?php echo ';var parent_type = '; ?><?php echo $this->_tpl_vars['entity_type']; ?><?php echo ';var message_saved_text 	= \''; ?><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Údaje boli aktualizované!')), $this); ?><?php echo '\';var message_saving_text = \''; ?><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Aktualizujem údaje')), $this); ?><?php echo '\';var path_relative		= \''; ?><?php echo $this->_tpl_vars['path_relative']; ?><?php echo '\';'; ?><?php echo '

function sortItems()
{
	var url = path_relative+\'action.php\';
	sort_items = SortTableManipulator.getItems();
	var params = "&section=sort_items&entity_id="+parent_id+"&entity_type="+parent_type+sort_items;
	params	   += "&goAjax=1";
	new Ajax.Updater(\'entity_view_content\',url, {
		parameters: params,
		evalScripts: true,
		onLoading: function(){
			setMessage(true,message_saving_text)
		},
		onSuccess: function(){
			setMessage(true,message_saved_text,true)
		},
		onFailure: \'Error\'

	});
}

function setMessage(show,message,close){
	var vystup = $("system_message");
	if(show == true)
	{
		vystup.innerHTML = message;
		vystup.style.display = "block"
	}
	else{
		vystup.style.display = "none"
	}

	if(close){
	  self.setTimeout(\'setMessage(false)\', 3000);
	}
}
</script>
'; ?><?php echo '<table class="tb_middle"><tr><td colspan="3"><div id=\'system_message\'></div><table class="tb_title"><tr><td style="height:35px;"><img class="img_middle" src="images/all_m_restore.png" alt="gallery" />&nbsp;&nbsp;'; ?><?php echo $this->_tpl_vars['section_title']; ?><?php echo '</td></tr></table></td></tr><tr><td colspan="3" class="td_link_v"></td></tr><tr><td class="td_middle_left">'; ?><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'merge', 'value1' => $this->_tpl_vars['path_relative'], 'value2' => 'themes/default/scripts/toolbar.php', 'assign' => 'path_toolbar')), $this); ?><?php echo ''; ?><?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => $this->_tpl_vars['path_toolbar'], 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?><?php echo '</td><td class="td_link_h"><img src="images/pixel.gif" width="1" /></td><td class="td_middle_center"><div id="SortTable"><ul id="Content">'; ?><?php $_from = $this->_tpl_vars['sort_table_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['order'] => $this->_tpl_vars['item']):
?><?php echo '<li	class="catalog" px:original_order="'; ?><?php echo $this->_tpl_vars['order']+1; ?><?php echo '" px:item_id="'; ?><?php echo $this->_tpl_vars['item']->data->getId(); ?><?php echo '" px:item_type="'; ?><?php echo $this->_tpl_vars['item']->data->getType(); ?><?php echo '">'; ?><?php if ($this->_tpl_vars['item']->thumbnail): ?><?php echo '<div class="image_frame" style="background-image: url(\''; ?><?php echo $this->_tpl_vars['item']->thumbnail; ?><?php echo '\');"></div>'; ?><?php endif; ?><?php echo '<div class="column"><strong>'; ?><?php echo $this->_tpl_vars['item']->column_1; ?><?php echo '</strong></div>'; ?><?php if ($this->_tpl_vars['item']->column_2): ?><?php echo '<div>'; ?><?php echo $this->_tpl_vars['item']->column_2; ?><?php echo '</div>'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['item']->column_3): ?><?php echo '<div>'; ?><?php echo $this->_tpl_vars['item']->column_3; ?><?php echo '</div>'; ?><?php endif; ?><?php echo '<div class="controlls"><img src="images/Icons/16x16/arrow_up.png" title="'; ?><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Posunúť hore')), $this); ?><?php echo '" alt="" /><img src="images/Icons/16x16/arrow_down.png" title="'; ?><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Posunúť dole')), $this); ?><?php echo '" alt="" /><input disabled type="text" value="'; ?><?php echo $this->_tpl_vars['order']+1; ?><?php echo '" /><img src="images/Icons/16x16/arrow_top.png" title="'; ?><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Presunúť navrch')), $this); ?><?php echo '" alt="" /><img src="images/Icons/16x16/arrow_bottom.png" title="'; ?><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Presunúť naspodok')), $this); ?><?php echo '" alt="" /></div><span class="spacer"></span></li>'; ?><?php endforeach; endif; unset($_from); ?><?php echo '</ul>'; ?><?php echo '</div></td></tr><tr><td colspan="3" class="td_link_v"></td></tr></table><div id="entity_view_content"></div>'; ?>