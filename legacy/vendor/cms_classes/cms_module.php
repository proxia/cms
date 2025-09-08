<?php

if(!defined('CMS_MODULE_PHP')):
	define('CMS_MODULE_PHP', true);

class CMS_Module extends CN_Module
{
###################################################################################################
# public
###################################################################################################

	public function activate($theme='default')
	{
		if(!isset($GLOBALS['smarty']))
			throw new CN_Exception(tr("Smarty must be available under global variable `smarty`, and it's not."));

		$GLOBALS['smarty']->template_dir = $this->getPath()."themes/$theme/templates/templates";
		$GLOBALS['smarty']->compile_dir = $this->getPath()."themes/$theme/templates/templates_c";
		$GLOBALS['smarty']->cache_dir = $this->getPath()."themes/$theme/templates/cache";
		$GLOBALS['smarty']->config_dir = $this->getPath()."themes/$theme/templates/configs";
	}

###################################################################################################

	public function display($theme='default') { include($this->getPath()."themes/$theme/index.php"); }

###################################################################################################
# protected
###################################################################################################

	protected function __construct($name, $scope)
	{
		$this->registerPrefix('CMS_');

		parent::__construct($name, $scope);
	}

###################################################################################################
# public static
###################################################################################################

	public static function getAvailableModules()
	{
	    global $moduleDir;

		$available_modules = new CN_Vector();

		###########################################################################################

		//$modules_dir = new DirectoryIterator($GLOBALS['cms_root'].DIRECTORY_SEPARATOR.'modules');
        $modules_dir = new DirectoryIterator($moduleDir);


		foreach($modules_dir as $module_name)
		{
			if($module_name->isDot() || substr($module_name, 0, 3) != 'cms')
				continue;

			$module = self::addModule(CN_Utils::getObjectName($module_name, 'CMS_'));

			$available_modules->append($module);
		}

		###########################################################################################

		return $available_modules;
	}

###################################################################################################

	public static function addModule($name, $scope = null)
	{
		$module = new CMS_Module($name, Chestnut::MODULE_SCOPE_LOCAL);

		CN_ModuleManager::getSingleton()->insertModule($module);

		return $module;
	}
}

endif;

?>
