<?php

if(!defined('CN_MODULEEXCEPTION_PHP')):
	define('CN_MODULEEXCEPTION_PHP', TRUE);

class CN_ModuleException extends CN_Exception
{
	private $module_name = NULL;


	public function __construct($message, $code, $mod_name, $target=CN_Exception::TARGET_DEFAULT)
	{
		parent::__construct($message, $code, $target);

		$this->module_name = $mod_name;
	}


	final public function getModuleName() { return $this->module_name; }
}

endif;

?>