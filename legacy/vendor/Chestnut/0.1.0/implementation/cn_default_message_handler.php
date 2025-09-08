<?php

if(!defined('CN_DEFAULTMESSAGEHANDLER_PHP')):
	define('CN_DEFAULTMESSAGEHANDLER_PHP', TRUE);

class CN_DefaultMessageHandler extends CN_MessageHandler
{

	public function fatal($message) { echo $message; }
	public function warning($message) { echo $message; }
	public function debug($message) { echo $message; }
	public function message($message) { echo $message; }
}

endif;

?>