<?php

class CN_ClassLoader extends CN_Singleton
{
	const TYPE_CORE_COMPOUND = 1;
	const TYPE_OTHER = 2;

	private $prefix_list = array();

	private $chestnut_search_path = array();
	public $search_path = array();

	private $class_name = null;

	private $class_type = null;
	private $file_name = null;

	private $file_cache = array();


	public function __construct()
	{
		parent::__construct($this);

		
		$this->setupSearchPath();
	}

	public function __destruct()
	{
		$this->removeSingleton(__CLASS__);
	}


	public function registerClassPrefix($prefix)
	{
		if(!in_array($prefix, $this->prefix_list))
			$this->prefix_list[] = $prefix;
	}


	public function addSearchPath($search_path, $subdir_search=true)
	{
		$path_found = false;
		$real_search_path = @realpath($search_path).DIRECTORY_SEPARATOR;

		if(is_dir($real_search_path) && is_readable($real_search_path) && strpos($real_search_path, $search_path) !== false)
		{
			$path_found = true;
			$this->search_path[$real_search_path] = $subdir_search;
		}
		else
		{
			$include_path = explode(PATH_SEPARATOR, get_include_path());

			foreach($include_path as $path_compound)
			{
				if(is_dir("$path_compound/$search_path") && is_readable("$path_compound/$search_path"))
				{
					$path_found = true;
					$this->search_path["$path_compound/$search_path/"] = $subdir_search;
					break;
				}
			}
		}

		if($path_found === false)
			throw new CN_Exception(sprintf(_("Path `%s` can't be added to search path because it doesn't exists or is not readable."), $search_path));
	}

	public function removeSearchPath($search_path)
	{
		$search_path = realpath($search_path).DIRECTORY_SEPARATOR;

		if(isset($this->search_path[$search_path]))
			unset($this->search_path[$search_path]);
	}


	final public function loadClass($class_name)
	{
		$prefix = null;
		$this->class_name = $class_name;

		foreach($this->prefix_list as $prefix_value)
		{
			if(strpos($class_name, $prefix_value) !== false)
			{
				$prefix = $prefix_value;
				break;
			}
		}

		
		if(is_null($prefix))
			$this->file_name = CN_Utils::getRealName($this->class_name).'.php';
		else
			$this->file_name = CN_Utils::getRealName($this->class_name, $prefix).'.php';

		
		if(isset($this->file_cache[$this->file_name]))
		{
			require_once($this->file_cache[$this->file_name].$this->file_name);

			return;
		}

		
		$this->identifyClassType();

		if($this->class_type == self::TYPE_CORE_COMPOUND)
		{
			foreach($this->chestnut_search_path as $path => $subdir_search)
				$this->findFile($path, (bool)$subdir_search);

			if(!class_exists($class_name, false))
			{
				foreach($this->search_path as $path => $subdir_search)
					$this->findFile($path, $subdir_search);
			}
		}
		else
		{
			foreach($this->search_path as $path => $subdir_search)
				$this->findFile($path, $subdir_search);
		}

		if(!class_exists($class_name, false))
			die(sprintf(_("Can't load class `%s`. File `%s` isn't in search path."), $class_name, $this->file_name));
	}


	private function setupSearchPath()
	{
		

		$this->chestnut_search_path[CN_Info::getSingleton()->getInstallPath()] = false;
		$this->chestnut_search_path[CN_Info::getSingleton()->getInstallPath().'exceptions'.DIRECTORY_SEPARATOR] = true;
		$this->chestnut_search_path[CN_Info::getSingleton()->getInstallPath().'iterators'.DIRECTORY_SEPARATOR] = true;
		$this->chestnut_search_path[CN_Info::getSingleton()->getInstallPath().'internals'.DIRECTORY_SEPARATOR] = true;
		$this->chestnut_search_path[CN_Info::getSingleton()->getInstallPath().'file_formats'.DIRECTORY_SEPARATOR] = true;

				

		$this->search_path['./'] = false;
		$this->search_path['./classes'.DIRECTORY_SEPARATOR] = true;
	}


	private function findFile($path, $subdir_search)
	{
		if(is_dir($path) && is_readable($path))
		{
			if(file_exists($path.$this->file_name))
			{
				if(!isset($this->file_cache[$this->file_name]))
				{
					$directory = dir($path);

					while(($entry = $directory->read()) !== false)
					{
						if($entry == '.' || $entry == '..')
							continue;

						if(is_file($directory->path.$entry))
							$this->file_cache[$entry] = $directory->path;
					}
				}

				require_once($path.$this->file_name);
			}
			elseif($subdir_search === true)
			{
				$directory = dir($path);

				while(($entry = $directory->read()) !== false)
				{
					if($entry == '.' || $entry == '..')
						continue;

					$this->file_cache[$entry] = $directory->path;

					if(is_dir($directory->path.$entry) && is_readable($directory->path.$entry))
						$this->findFile($directory->path.$entry.DIRECTORY_SEPARATOR, $subdir_search);
				}
			}
		}
	}


	final private function identifyClassType()
	{
		if(strpos($this->class_name, 'CN_') !== false)
			$this->class_type = self::TYPE_CORE_COMPOUND;
		else
			$this->class_type = self::TYPE_OTHER;
	}


	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }
}
