<?php

if(!defined('CMS_PROJECTCONFIG_PHP')):
	define('CMS_PROJECTCONFIG_PHP', true);

class CMS_ProjectConfig extends CN_Singleton
{
	const QUANTITY_UNLIMITED = 0;

	private $xml = null;

###################################################################################################
# public
###################################################################################################

	public function __construct($project_name)
	{
		parent::__construct($this);

		###########################################################################################

		$file = "{$GLOBALS['cms_root']}/../config/prjdef.xml";


		//$file2 = "{$GLOBALS['cms_root']}_sub/$project_name/_config/prjdef.xml";

		if(extension_loaded('ionCube Loader'))
		{
			if(ioncube_file_is_encoded())
				$this->xml = simplexml_load_string(ioncube_read_file($file));
			else
 				$this->xml = simplexml_load_file($file);
		}
		else
			$this->xml = simplexml_load_file($file);

// 		if( !$this->xml )
// 		{
// 		    $this->xml = simplexml_load_file($file2);
// 		}
		//var_dump($this->xml);
	}

	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################

	public function getName()
	{
		return (string)$this->xml->project->name;
	}

	public function getDescription()
	{
		return (string)$this->xml->project->description;
	}

###################################################################################################
# system config ###################################################################################

	public function getSessionId()
	{
		return (string)$this->xml->config->system->session_id;
	}

###################################################################################################

	public function getFtpUser()
	{
		return (string)$this->xml->config->system->ftp['user'];
	}

	public function getFtpPassword()
	{
		return (string)$this->xml->config->system->ftp['password'];
	}

	public function getFtpHost()
	{
		return (string)$this->xml->config->system->ftp['host'];
	}

	public function hasFtp()
	{
		$host = $this->getFtpHost();

		return !!$host;
	}

###################################################################################################

	public function getSqlUser()
	{
		return (string)$this->xml->config->system->sql['user'];
	}

	public function getSqlPassword()
	{
		return (string)$this->xml->config->system->sql['password'];
	}


	public function getSqlDsn()
	{
		return (string)$this->xml->config->system->sql['dsn'];
	}

	public function getHost()
	{
		return (string)$this->xml->config->system->sql['host'];
	}

	public function isSeoArticle()
	{
		return (boolean)$this->xml->config->system->seo['seo-article'];
	}

	public function getAlternateConfig()
	{
		return (boolean)$this->xml->config->system->alternate_config;
	}

###################################################################################################
# modules config ##################################################################################

	public function getAvailableModules()
	{
		$available_modules = array();

		###########################################################################################

		$modules = $this->xml->config->modules[0];

		foreach($modules as $module)
			$available_modules[] = (string)$module['name'];

		###########################################################################################

		return $available_modules;
	}

	public function checkModuleAvailability($module_to_check)
	{
		$module_to_check = CN_Utils::getObjectName($module_to_check, 'CMS_');

		###########################################################################################

		$module = $this->xml->xpath("//config/modules/module[@name='$module_to_check']");

		if(count($module) > 0)
			return true;
		else
			return false;
	}

###################################################################################################
# entities config #################################################################################

	public function getAvailableEntities()
	{
		$available_entities = array();

		###########################################################################################

		$entities = $this->xml->config->entities[0];

		foreach($entities as $entity)
			$available_entities[(string)$entity['id']] = array(
																"name" => (string)$entity['name'],
																"quantum" => (string)$entity['quantum']
																);

		###########################################################################################

		return $available_entities;
	}

	public function getQuantumForEntity($entity_to_check)
	{
		$attr = 'id';

		if(is_string($entity_to_check))
		{
			$entity_to_check = CN_Utils::getObjectName($entity_to_check, 'CMS_');
			$attr = 'name';
		}

		###########################################################################################

		$entity = $this->xml->xpath("//config/entities/entity[@$attr='$entity_to_check']");

		if(count($entity) > 0)
			return (int)$entity[0]['quantum'];
		else
			return null;
	}

	public function checkEntityAvailability($entity_to_check)
	{
		$attr = 'id';

		if(is_string($entity_to_check))
		{
			$entity_to_check = CN_Utils::getObjectName($entity_to_check, 'CMS_');
			$attr = 'name';
		}

		###########################################################################################

		$entity = $this->xml->xpath("//config/entities/entity[@$attr='$entity_to_check']");

		if(count($entity) > 0)
			return true;
		else
			return false;
	}

###################################################################################################
# language versions config ########################################################################

	public function getAvailableTranslations()
	{
		$available_versions = array();

		###########################################################################################

		$versions = $this->xml->config->language_versions[0];

		foreach($versions as $version)
			$available_versions[] = (string)$version['code'];

		###########################################################################################

		return $available_versions;
	}

	public function checkTranslationAvailability($version_to_check)
	{
		$version = $this->xml->xpath("//config/language_versions/version[@code='$version_to_check']");

		if(count($version) > 0)
			return true;
		else
			return false;
	}

###################################################################################################
# client and license info #########################################################################

	public function getClientInfo()
	{
		$raw_client_info = $this->xml->project->client_info[0];
		$client_info = array();

		foreach($raw_client_info as $info_node)
			$client_info[$info_node->getName()] = (string)$info_node;

		return $client_info;
	}

	public function getLicenseInfo()
	{
		$raw_license_info = $this->xml->project->license_info[0];
		$license_info = array();

		foreach($raw_license_info as $info_node)
			$license_info[$info_node->getName()] = (string)$info_node;

		return $license_info;
	}

###################################################################################################
# currency config ##################################################################################

	public function getAvailableCurrencies()
	{
		$available_currencies = array();

		###########################################################################################

		$currencies = $this->xml->config->currencies[0];

		foreach($currencies as $currency)
			$available_currencies[] = (string)$currency['code'];

		###########################################################################################

		return $available_currencies;
	}

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }
}

endif;

?>
