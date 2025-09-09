<?php

if(!defined('XINHA_PHP')):
	define('XINHA_PHP', true);

class Xinha
{
	private $path = null;
	private $language = null;

	private $editors = array();
	private $plugins_to_load = array();
	private $global_plugins = array();
	private $global_params = array();
	private $editor_plugins = array();
	private $editor_params = array();

####################################################################################################
# public
####################################################################################################

	public function Xinha($path, $language='en')
	{
	//	if($path[strlen($path) - 1] != DIRECTORY_SEPARATOR)
		//	$path .= DIRECTORY_SEPARATOR;

		$this->path = $path;
		$this->language = $language;
	}

####################################################################################################

	public function setPath($path)
	{
		$this->path = $path;
	}

	public function setLanguage($language)
	{
		$this->language = $language;
	}

	public function getPath()
	{
		return $this->path;
	}

	public function getLanguage()
	{
		return $this->language;
	}

####################################################################################################

	public function addEditor($editor)
	{
		if(!in_array($editor, $this->editors))
			$this->editors[] = $editor;
	}

	public function removeEditor($editor)
	{
		$key = array_search($editor, $this->editors);

		if($key !== FALSE)
			unset($this->editors[$key]);
	}

	public function getEditors()
	{
		return $this->editors;
	}

####################################################################################################

	public function addGlobalPlugin($plugin)
	{
		$this->addPluginToLoad($plugin);

		if(!in_array($plugin, $this->global_plugins))
			$this->global_plugins[] = $plugin;
	}

	public function removeGlobalPlugin($global_plugin)
	{
		$key = array_search($global_plugin, $this->global_plugins);

		if($key !== FALSE)
			unset($this->global_plugins[$key]);
	}

	public function getGlobalPlugins()
	{
		return $this->global_plugins;
	}

####################################################################################################

	public function setGlobalParam($param, $value)
	{
		$this->global_params[$param] = $value;
	}

	public function getGlobalParams()
	{
		return $this->global_params;
	}

####################################################################################################

	public function addEditorPlugin($editor, $plugin)
	{
		$this->addPluginToLoad($plugin);

		if(isset($this->editor_plugins[$editor]))
		{
			if(is_array($this->editor_plugins[$editor]))
			{
				if(in_array($plugin, $this->editor_plugins[$editor]))
					return;
			}
		}

		$this->editor_plugins[$editor][] = $plugin;
	}

	public function getEditorPlugins($editor)
	{
		return $this->editor_plugins[$editor];
	}

####################################################################################################

	public function setEditorParam($editor, $param, $value)
	{
		$this->editor_params[$editor][$param] = $value;
	}

	public function getEditorParams($editor)
	{
		return $this->editor_params[$editor];
	}

####################################################################################################

	public function getMainScript($direct_output=FALSE)
	{
		$main_script =<<<MAIN_SCRIPT
	<script type="text/javascript">
	_editor_url = "{$this->path}";
	_editor_lang = "{$this->language}";
	</script>
	<script type="text/javascript" src="{$this->path}htmlarea.js"></script>
MAIN_SCRIPT;

		if($direct_output)
			echo $main_script;

		return $main_script;
	}

	public function getConfig($script_tags=TRUE, $direct_output=FALSE)
	{
		$editors = '';
		$plugins_to_load = '';
		$global_plugins = '';
		$global_params = '';
		$editor_plugins = '';
		$editor_params = '';

		############################################################################################

		foreach($this->editors as $editor)
			$editors .= "'$editor',";

		$editors = rtrim($editors, ',');

		############################################################################################

		foreach($this->plugins_to_load as $plugin)
			$plugins_to_load .= "'$plugin',";

		$plugins_to_load = rtrim($plugins_to_load, ',');

		############################################################################################

		foreach($this->global_plugins as $global_plugin)
			$global_plugins .= "'$global_plugin',";

		$global_plugins = rtrim($global_plugins, ',');

		############################################################################################

		foreach($this->global_params as $param => $value)
			$global_params .= "xinha_config.$param='$value';";

		############################################################################################

		foreach($this->editor_plugins as $name => $plugin_list)
		{
			$editor_plugins .= "xinha_editors['$name'].registerPlugins([$global_plugins";

			foreach($plugin_list as $plugin)
				$editor_plugins .= ",'$plugin'";

			if($global_plugins)
				$editor_plugins = ltrim($editor_plugins, ',');

			$editor_plugins .= "]);";
		}

		############################################################################################

		foreach($this->editor_params as $name => $config)
		{
			foreach($config as $param => $value)
				$editor_params .= "xinha_editors.$name.config.$param='$value';";
		}

		############################################################################################

		$config =<<<XINHA_CONFIG
	xinha_editors = null;
	xinha_init = null;
	xinha_config = null;
	xinha_plugins_to_load = null;
	xinha_plugins = null;

	xinha_init = xinha_init ? xinha_init : function()
	{
		xinha_plugins_to_load = [$plugins_to_load];

		if(!HTMLArea.loadPlugins(xinha_plugins_to_load, xinha_init)) return;

		xinha_editors = xinha_editors ? xinha_editors : [$editors];

		xinha_config = new HTMLArea.Config();
		$global_params

		xinha_editors = HTMLArea.makeEditors(xinha_editors, xinha_config);
		$editor_plugins
		$editor_params

		HTMLArea.startEditors(xinha_editors);
	}

	window.onload = xinha_init;
XINHA_CONFIG;

		if($script_tags)
			$config = '<script type="text/javascript">'."\n".$config."\n".'</script>';

		if($direct_output)
			echo $config;

		return $config;
	}

####################################################################################################
# private
####################################################################################################

	private function addPLuginToLoad($plugin)
	{
		if(!in_array($plugin, $this->plugins_to_load))
			$this->plugins_to_load[] = $plugin;
	}
}

endif;

?>