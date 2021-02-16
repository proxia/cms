<?php

if(!defined('CN_CONFIG_PHP')):
	define('CN_CONFIG_PHP', true);

class CN_Config extends CN_Singleton
{
	private $config_file = null;
	private $xml = null;
	private $dom = null;


	public function __construct()
	{
		parent::__construct($this);
	}

	public function __destruct()
	{
		$this->removeSingleton(__CLASS__);
	}


	public function setValue($section_name, $option_name, $option_value)
	{
		$option = $this->xml->xpath("//section[@name='$section_name']/option[@name='$option_name']");

		$option[0]['value'] = trim($option_value);
	}


	public function getAll()
	{
		$config = array();

		
		foreach($this->xml->children() as $section)
		{
			$section_name = (string)$section['name'];

			foreach($section->children() as $option)
			{
				$option_array = array();

				$option_array['name'] = (string)$option['name'];
				$option_array['value'] = (string)$option['value'];
				$option_array['type'] = (string)$option['type'];

				$config[$section_name][] = $option_array;
			}
		}

		
		return $config;
	}

	public function getSection($section_name)
	{
		$section_config = array();

		
		$section = $this->xml->xpath("//section[@name='$section_name']");

		if(count($section) < 1)
			throw new CN_Exception(sprintf(_("Section `%s` isn't defined in config file."), $section_name), E_ERROR);

		foreach($section[0]->children() as $option)
		{
			$option_array = array();

			$option_array['name'] = (string)$option['name'];
			$option_array['value'] = (string)$option['value'];
			$option_array['type'] = (string)$option['type'];

			$section_config[] = $option_array;
		}

		
		return $section_config;
	}

	public function getValue($section_name, $option_name)
	{
		$option = $this->xml->xpath("//section[@name='$section_name']/option[@name='$option_name']");

		if(count($option) < 1)
			throw new CN_Exception(sprintf(_("Option `%1\$s` isn't defined section `%2\$s`."), $option_name, $section_name), E_ERROR);

		$option_array['name'] = (string)$option[0]['name'];
		$option_array['value'] = (string)$option[0]['value'];
		$option_array['type'] = (string)$option[0]['type'];

		return $option_array;
	}


	public function load($config_file='config.xml')
	{
		$this->config_file = realpath($config_file);

		if(!is_readable($this->config_file))
			throw new CN_Exception(sprintf(_("Configuration file `%s` isn't readable, please check permissions."), $config_file), E_ERROR);

		if(function_exists('ioncube_read_file'))
		{
			$this->xml = simplexml_load_string(ioncube_read_file($this->config_file));
		}
		else
			$this->xml = simplexml_load_file($this->config_file);

		// = simplexml_load_file();
	}

	public function save()
	{
		if(!is_writable($this->config_file))
			throw new CN_Exception(sprintf(_("Configuration file `%s` isn't writable, please check permissions."), dirname($this->config_file)));

		file_put_contents($this->config_file, $this->xml->asXml());
	}


	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }


	public static function loadFromFile($file)
	{
		$config = CN_Config::getSingleton();
		$config->load($file);

		return $config;
	}
}

endif;

?>