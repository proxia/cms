<?php

if(!class_exists('Smarty', false))
{
	require_once('smarty/Smarty.class.php');
}

$dir_prefix = CN_Info::getSingleton()->getInstallPath().'implementation'.DIRECTORY_SEPARATOR.'ui'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR;

$class_smarty = new Smarty();

$class_smarty->template_dir = $dir_prefix.'templates';
$class_smarty->compile_dir = $dir_prefix.'templates_c';
$class_smarty->cache_dir = $dir_prefix.'cache';
$class_smarty->config_dir = $dir_prefix.'configs';


$class_smarty->assign('type', $type); $class_smarty->assign('prefix', $dir_prefix);

if($type == 'exception')
{
	$is_sql_exception = ($e instanceof CN_SqlException);

	$trace = $e->getTrace();
	$throwed_from_trace = end($trace);

	$class_smarty->assign('is_sql_exception', $is_sql_exception);

	$class_smarty->assign('severity', '');
	$class_smarty->assign('code', $e->getCode());
	$class_smarty->assign('message', $e->getMessage());

	$class_smarty->assign('throwed_from_file', $throwed_from_trace['file']);
	$class_smarty->assign('throwed_from_line', $throwed_from_trace['line']);
	$class_smarty->assign('throwed_from_by_call', ($throwed_from_trace['class'] ?? null).' '.($throwed_from_trace['type'] ?? null).' '.$throwed_from_trace['function']);

	$class_smarty->assign('hardcoded_in_file', $trace[0]['file']);
	$class_smarty->assign('hardcoded_in_line', $trace[0]['line']);
	$class_smarty->assign('hardcoded_in_function', $trace[0]['class'].' '.$trace[0]['type'].' '.$trace[0]['function']);

	if($is_sql_exception)
	{
		$class_smarty->assign('sql_query', $e->getSqlQuery());
		$class_smarty->assign('sql_errno', $e->getErrorCode());
		$class_smarty->assign('sql_error', $e->getErrorString());
	}
}
elseif($type == 'error')
{
	$error_severity = array(
								E_ERROR => 'Fatal error',
								E_WARNING => 'Warning',
								E_PARSE => 'Parse error',
								E_NOTICE => 'Notice',
								E_CORE_ERROR => 'Core fatal error',
								E_CORE_WARNING => 'Core warning',
								E_COMPILE_ERROR => 'Compile error',
								E_COMPILE_WARNING => 'Compile warning',
								E_USER_ERROR => 'User error',
								E_USER_NOTICE => 'User notice',
								E_STRICT => 'Strict error'
							);

	$class_smarty->assign('severity', $error_severity[$errno]);
	$class_smarty->assign('code', $errno);
	$class_smarty->assign('message', $errstr);

	$class_smarty->assign('file', $errfile);
	$class_smarty->assign('line', $errline);
}


$class_smarty->display('default_error.tpl');

?>
