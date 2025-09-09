<?php  ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'default_error.tpl', 54, false),array('modifier', 'default', 'default_error.tpl', 55, false),)), $this); ?>
<html>
	<head>
		<?php echo '
		<style type="text/css">

		body
		{
			margin: 0 0 0 0;
			padding: 1em 1em 1em 1em;

			background-color: rgb(237, 58, 58);
		}

		div
		{
			width: 100%;
			margin-bottom: 1em;
			padding: 0.3em 0.3em 0.3em 0.3em;

			border: 2px dashed black;

			background-color: rgb(237, 213, 190);
		}

		div.title
		{
			margin-bottom: 0.5em;
			padding: 0 0 0 0;

			border: none;
			border-bottom: 1px solid black;

			font-weight: bold;
			font-size: 0.8em;
		}

		span.left_caption
		{
			padding-right: 0.5em;

			font-weight: bold;
			font-size: 1.1em;
		}

		</style>
		'; ?>


		<title>Chestnut default error</title>
	</head>

	<body>

		<div>
			<span class="left_caption">Triggered by:</span> <?php echo ((is_array($_tmp=$this->_tpl_vars['type'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
<br />
			<span class="left_caption">Severity:</span> <?php echo ((is_array($_tmp=@$this->_tpl_vars['severity'])) ? $this->_run_mod_handler('default', true, $_tmp, 'undefined') : smarty_modifier_default($_tmp, 'undefined')); ?>
<br /><br />
			<span class="left_caption">Code:</span> <?php echo $this->_tpl_vars['code']; ?>
<br />
			<span class="left_caption">Message:</span> <?php echo $this->_tpl_vars['message']; ?>

		</div>

<!--#############################################################################################-->

		<?php if ($this->_tpl_vars['type'] == 'exception'): ?>

		<div>
			<div class="title">Throwed from</div>

			<span class="left_caption">File:</span> <?php echo $this->_tpl_vars['throwed_from_file']; ?>
<br />
			<span class="left_caption">Line:</span> <?php echo $this->_tpl_vars['throwed_from_line']; ?>
<br />
			<span class="left_caption">By call of:</span> <?php echo ((is_array($_tmp=@$this->_tpl_vars['throwed_from_by_call'])) ? $this->_run_mod_handler('default', true, $_tmp, 'undefined') : smarty_modifier_default($_tmp, 'undefined')); ?>
()
		</div>

	<!--#############################################################################################-->

		<?php if ($this->_tpl_vars['is_sql_exception'] === TRUE): ?>

		<div>
			<div class="title">SQL Exception</div>

			<span class="left_caption">SQL Query:</span> <?php echo $this->_tpl_vars['sql_query']; ?>
<br />
			<span class="left_caption">Error number:</span> <?php echo $this->_tpl_vars['sql_errno']; ?>
<br />
			<span class="left_caption">Error string:</span> <?php echo $this->_tpl_vars['sql_error']; ?>

		</div>

		<?php endif; ?>

	<!--#############################################################################################-->

		<div>
			<div class="title">Hardcoded in</div>

			<span class="left_caption">File:</span> <?php echo $this->_tpl_vars['hardcoded_in_file']; ?>
<br />
			<span class="left_caption">Line:</span> <?php echo $this->_tpl_vars['hardcoded_in_line']; ?>
<br />
			<span class="left_caption">Function:</span> <?php echo ((is_array($_tmp=@$this->_tpl_vars['hardcoded_in_function'])) ? $this->_run_mod_handler('default', true, $_tmp, 'undefined') : smarty_modifier_default($_tmp, 'undefined')); ?>
()
		</div>

<!--#############################################################################################-->

		<?php elseif ($this->_tpl_vars['type'] == 'error'): ?>

		<div>
			<span class="left_caption">File:</span> <?php echo $this->_tpl_vars['file']; ?>
<br />
			<span class="left_caption">Line:</span> <?php echo $this->_tpl_vars['line']; ?>

		</div>

		<?php endif; ?>

<!--#############################################################################################-->

	</body>
</html>