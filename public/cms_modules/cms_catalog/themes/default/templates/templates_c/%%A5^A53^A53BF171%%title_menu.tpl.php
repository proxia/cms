<?php /* Smarty version 2.6.30, created on 2019-05-16 19:49:49
         compiled from title_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'merge', 'title_menu.tpl', 3, false),array('insert', 'tr', 'title_menu.tpl', 11, false),)), $this); ?>
<table class="tb_top_menu">
	<tr>
		<td width="72" rowspan="2"><img class="img_middle" src="<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'merge', 'value1' => $this->_tpl_vars['path_relative'], 'value2' => 'themes/default/images/catalog_view.png')), $this); ?>
" alt="" /><td>
		<td>&nbsp;&nbsp;</td>
		<td>
			<table border="0" cellpadding="5" cellspacing="3" class="tab_title_menu">
				<tr>
					<td rowspan="3" class="nadpis" nowrap>&nbsp;&nbsp;Katalóg</td>
				</tr>
				<tr>
					<td class="bold" nowrap style="line-height:20px;"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Názov katalógu')), $this); ?>
</td>
					<td class="red" nowrap style="line-height:20px;"><?php echo $this->_tpl_vars['catalog_title']; ?>
</td>
				</tr>
				<tr>
					<td class="bold" nowrap style="line-height:20px;"><?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'tr', 'value' => 'Sekcia')), $this); ?>
</td>
					<td class="red" nowrap" style="line-height:20px;"><?php echo $this->_tpl_vars['title']; ?>
</td>
				</tr>
			</table>
		</td>
	</tr>
</table>