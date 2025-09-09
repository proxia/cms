<?php

function cnFatal()
{
	$message_handler = $GLOBALS['cn_app']->getMessageHandler();

	$arg_list = func_get_args();

	$arg_string;

	foreach($arg_list as $arg)
		$arg_string .= $arg;

	if(is_null($message_handler))
		echo $arg_string;
	else
		$message_handler->fatal($arg_string);
}

function cnWarning()
{
	$message_handler = $GLOBALS['cn_app']->getMessageHandler();

	$arg_list = func_get_args();

	$arg_string;

	foreach($arg_list as $arg)
		$arg_string .= $arg;

	if(is_null($message_handler))
		echo $arg_string;
	else
		$message_handler->warning($arg_string);
}

function cnDebug()
{
	$message_handler = $GLOBALS['cn_app']->getMessageHandler();

	$arg_list = func_get_args();

	$arg_string;

	foreach($arg_list as $arg)
		$arg_string .= $arg;

	if(is_null($message_handler))
		echo $arg_string;
	else
		$message_handler->debug($arg_string);
}

function cnMessage()
{
	$message_handler = $GLOBALS['cn_app']->getMessageHandler();

	$arg_list = func_get_args();

	$arg_string;

	foreach($arg_list as $arg)
		$arg_string .= $arg;

	if(is_null($message_handler))
		echo $arg_string;
	else
		$message_handler->message($arg_string);
}

?>