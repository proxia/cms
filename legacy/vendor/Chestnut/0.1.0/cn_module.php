<?php

class CN_Module
{
	protected $name = null;
	protected $directory = null;
	protected $path = null;

	protected $scope = null;

	protected $init_script_presents = false;
	protected $install_script_presents = false;
	protected $config_file_presents = false;

	protected $prefix_list = array();


	protected static $search_path = array();


	public function __toString()
	{
		if(CN_Application::getSingleton()->getDebug() === true)
		{
			$scope = $this->scope == Chestnut::MODULE_SCOPE_GLOBAL ? 'global' : 'local';
			$init_script_presents = $this->init_script_presents === true ? 'yes' : 'no';
			$install_script_presents = $this->install_script_presents === true ? 'yes' : 'no';
			$config_file_presents = $this->config_file_presents === true ? 'yes' : 'no';
			$meta_info_presents = is_readable($this->path.'meta_info.xml') === true ? 'yes' : 'no';

			$string =<<<STRING
			<pre style="text-align: left; padding: 0.5em; border: 1px solid black;">
			<strong>Module name</strong>: `{$this->name}`
			<strong>Module directory</strong>: `{$this->directory}`
			<strong>Module path</strong>: `{$this->path}`

			<strong>Module scope</strong>: $scope

			<strong>Init script presents</strong>: $init_script_presents
			<strong>Install script presents</strong>: $install_script_presents
			<strong>Config file presents</strong>: $config_file_presents
			<strong>Meta info presents</strong>: $meta_info_presents
			</pre>
STRING;

			return str_replace("\t", "", $string);
		}
		else
			return $this->name;
	}


	public function registerPrefix($prefix)
	{
		if(!in_array($prefix, $this->prefix_list))
			$this->prefix_list[] = $prefix;
	}


	public function getName() { return $this->name; }
	public function getPath() { return $this->path; }

	public function getRelativePath()
	{
		//echo getcwd().' - '.$this->getPath().'<br>';


		return str_replace(getcwd().DIRECTORY_SEPARATOR, '', $this->getPath());
	}

	public function getScope() { return $this->scope; }


	public function getFileList()
	{
		$file_list = array();


		$directory = dir($this->path);

		while(($entry = $directory->read()) !== false)
		{
			if($entry == '.' || $entry == '..')
				continue;

			if(is_file($directory->path.$entry) && is_readable($directory->path.$entry))
				$file_list[] = $entry;
		}


		return $file_list;
	}


	public function utilise()
	{
		CN_ClassLoader::getSingleton()->addSearchPath($this->path);

		if($this->init_script_presents === true)
			require_once $this->path.'__init__.php';
	}

	public function load()
	{
	}


	public function hasConfig() { return $this->config_file_presents; }

	public function getConfig()
	{
		if($this->config_file_presents === true)
			return CN_Config::loadFromFile($this->path.'config.xml');
		else
			return false;
	}


	public function getMetaInfo()
	{
		$meta_info = array();

		if(!is_readable($this->path.'meta_info.xml'))
			throw new CN_Exception(sprintf(_("Module `%s` don't have any meta info available."), $this->name), E_ERROR);

		if(function_exists('ioncube_read_file'))
			$xml = simplexml_load_string(ioncube_read_file($this->path.'meta_info.xml'));
		else
			$xml = simplexml_load_file($this->path.'meta_info.xml');

		foreach($xml->children() as $section)
		{
			$section_name = (string)$section['name'];

			foreach($section->children() as $content)
				$meta_info[$section_name][(string)$content['language']] = (string)$content;
		}



		return $meta_info;
	}


	public function __construct($name, $scope)
	{
		$module_prefix = Chestnut::CHESTNUT_PREFIX;

		foreach($this->prefix_list as $prefix)
		{
			if(stripos($name, $prefix) !== false)
			{
				$module_prefix = $prefix;
				break;
			}
		}


		$this->name = $name;
		$this->directory = CN_Utils::getRealName($name, $module_prefix);

		$this->scope = $scope;

		$this->findModule();


		if(is_readable($this->path.'__init__.php'))
			$this->init_script_presents = true;

		if(is_readable($this->path.'__install__.php'))
			$this->install_script_presents = true;

		if(is_readable($this->path.'config.xml'))
			$this->config_file_presents = true;
	}


	private function findModule()
	{
		if(!is_null($this->scope))
		{
			switch($this->scope)
			{
				case Chestnut::MODULE_SCOPE_GLOBAL:
					if(is_dir(CN_Info::getSingleton()->getInstallPath().'modules'.DIRECTORY_SEPARATOR.$this->directory) && is_readable(CN_Info::getSingleton()->getInstallPath().'modules'.DIRECTORY_SEPARATOR.$this->directory))
						$this->path = CN_Info::getSingleton()->getInstallPath().'modules'.DIRECTORY_SEPARATOR.$this->directory.DIRECTORY_SEPARATOR;
					else
						throw new CN_Exception(sprintf(_("Module `%s` cannot be found. It's probably not installed or name is incorrect."), $this->name));

					break;

				case Chestnut::MODULE_SCOPE_LOCAL:

					foreach(self::$search_path as $search_path)
					{
						if(is_dir($search_path.$this->directory) && is_readable($search_path.$this->directory))
						{
							$this->path = $search_path.$this->directory.DIRECTORY_SEPARATOR;

							break;
						}
						else
							throw new CN_Exception(sprintf(_("Module `%s` cannot be found. It's probably not installed or name is incorrect."), $this->name));
					}

					break;

				default:
					break;
			}
		}
		else
		{
			$module_found = false;

			if(is_dir(CN_Info::getSingleton()->getInstallPath().'modules'.DIRECTORY_SEPARATOR.$this->directory) && is_readable(CN_Info::getSingleton()->getInstallPath().'modules'.DIRECTORY_SEPARATOR.$this->directory))
			{
				$this->path = CN_Info::getSingleton()->getInstallPath().'modules'.DIRECTORY_SEPARATOR.$this->directory.DIRECTORY_SEPARATOR;
				$this->scope = Chestnut::MODULE_SCOPE_GLOBAL;

				$module_found = true;
			}
			else
			{
				foreach(self::$search_path as $search_path)
				{
					if(is_dir($search_path.'modules'.DIRECTORY_SEPARATOR.$this->directory) && is_readable($search_path.'modules'.DIRECTORY_SEPARATOR.$this->directory))
					{
						$this->path = $search_path.'modules'.DIRECTORY_SEPARATOR.$this->directory.DIRECTORY_SEPARATOR;
						$this->scope = Chestnut::MODULE_SCOPE_LOCAL;

						echo $this->path.'<br>';

						$module_found = true;

						break;
					}
				}
			}

			if($module_found === false)
				throw new CN_Exception(sprintf(_("Module `%s` cannot be found. It's probably not installed or name is incorrect."), $this->name));
		}
	}


	public static function addSearchPath($search_path)
	{
		$search_path = realpath($search_path).DIRECTORY_SEPARATOR;

		if(!in_array($search_path, self::$search_path))
			self::$search_path[] = $search_path;
	}


	public static function addModule($name, $scope=null)
	{
		$module = new CN_Module($name, $scope);

		CN_ModuleManager::getSingleton()->insertModule($module);

		return $module;
	}

	public static function getModule($name, $load_if_nonexistent=true)
	{
		if($load_if_nonexistent === true)
		{
			if(!CN_ModuleManager::getSingleton()->isLoaded($name))
				self::addModule($name);
		}

		return CN_ModuleManager::getSingleton()->getModule($name);
	}
}
