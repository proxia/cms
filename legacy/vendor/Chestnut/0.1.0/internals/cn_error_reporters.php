<?php

function cn_error_handler($errno, $errstr, $errfile, $errline)
{
	if(strpos($errfile, 'Smarty'))
		return;

	if($GLOBALS['cn_app']->getDebug() === TRUE)
	{
		$ignored_errors = array();

		if(in_array($errno, $ignored_errors))
			return;

		$type = 'error';
		$file_path = $GLOBALS['cn_path'].'implementation'.DIRECTORY_SEPARATOR.'html'.DIRECTORY_SEPARATOR.'default_error.php';

		require_once($file_path);

		exit();
	}
}

function cn_exception_handler(CN_Exception $e)
{
	
}

?>