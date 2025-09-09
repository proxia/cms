<?php

if(!defined('CN_MODULEMANAGER_PHP')):
	define('CN_MODULEMANAGER_PHP', TRUE);

class CN_ModuleManager extends CN_Singleton
{
	private $module_list = array();


	public function __construct()
	{
		parent::__construct($this);
	}

	public function __destruct()
	{
		$this->removeSingleton(__CLASS__);
	}


	public function insertModule(CN_Module $module)
	{
		$module_name = $module->getName();

		if(!isset($this->module_list[$module_name]))
			$this->module_list[$module_name] = $module;
	}

	public function deleteModule($module_name)
	{
		if(isset($this->module_list[$module_name]))
			unset($this->module_list[$module_name]);
	}


	public function isLoaded($module_name) { return isset($this->module_list[$module_name]); }

	public function getModule($module_name)
	{
		if(isset($this->module_list[$module_name]))
			return $this->module_list[$module_name];
		else
			throw new CN_Exception(sprintf(_("Module `%s` isn't loaded. Use CN_Module::addModule() function to load it."), $module_name));
	}


	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }
}

endif;

?>