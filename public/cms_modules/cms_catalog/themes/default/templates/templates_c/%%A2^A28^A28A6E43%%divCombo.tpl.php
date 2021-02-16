<?php /* Smarty version 2.6.30, created on 2019-05-17 09:49:46
         compiled from divCombo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'tr', 'divCombo.tpl', 79, false),)), $this); ?>
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
		<?php if (is_object ( $this->_tpl_vars['branch_id']['object'] )): ?>
		<select id="filter_branch<?php echo $this->_tpl_vars['branch_id']['object']->getId(); ?>
" name="filter_branch[<?php echo $this->_tpl_vars['branch_id']['object']->getId(); ?>
]" onchange="return checkControl(this,form1)">
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