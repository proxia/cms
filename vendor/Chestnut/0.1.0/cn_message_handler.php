<?php

if(!defined('CN_MESSAGEHANDLER_PHP')):
	define('CN_MESSAGEHANDLER_PHP', TRUE);

abstract class CN_MessageHandler
{
	abstract public function fatal($message);
	abstract public function warning($message);
	abstract public function debug($message);
	abstract public function message($message);
}

endif;

?>