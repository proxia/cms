<?php

if(!defined('CMS_LOGICENTITY_PHP')):
	define('CMS_LOGICENTITY_PHP', true);

class CMS_LogicEntity extends CN_Singleton
{
	private $xml = null;

###################################################################################################
# public
###################################################################################################

	public function __construct()
	{
		parent::__construct($this);

		###########################################################################################

		$file = $GLOBALS['cms_root'].'/data/logic_entity_map.xml';

		if(function_exists('ioncube_read_file'))
			$this->xml = simplexml_load_string(ioncube_read_file($file));
		else
			$this->xml = simplexml_load_file($file);
	}

	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################

	public function getNameById($id)
	{
		$node = $this->xml->xpath("/logic_entity_map/module/entity[@id='$id']");

		if(count($node) > 0)
			return (string)$node[0]['name'];
		else
		{
			$node = $this->xml->xpath("/logic_entity_map/module/entity/subentity[@id='$id']");

			if(count($node) > 0)
				return (string)$node[0]['name'];
			else
				return null;
		}
	}

	public function getIdByName($name)
	{
		$node = $this->xml->xpath("/logic_entity_map/module/entity[@name='$name']");

		if(count($node) > 0)
			return (string)$node[0]['id'];
		else
		{
			$node = $this->xml->xpath("/logic_entity_map/module/entity/subentity[@name='$name']");

			if(count($node) > 0)
				return (string)$node[0]['id'];
			else
				return null;
		}
	}

###################################################################################################

	public function getLogicEntities($module)
	{
		$logic_entities = array();

		###########################################################################################

		$node = $this->xml->xpath("/logic_entity_map/module[@name='$module']");

		if(count($node) > 0)
		{
			foreach($node[0] as $logic_entity)
			{
				$single_entity = array();

				$single_entity['id'] = (string)$logic_entity['id'];
				$single_entity['name'] = (string)$logic_entity['name'];
				$single_entity['valid_privileges'] = (string)$logic_entity['valid_privileges'];

				if(count($logic_entity->subentity) > 0);
				{
					foreach($logic_entity as $subentity)
					{
						$single_subentity['id'] = (string)$subentity['id'];
						$single_subentity['name'] = (string)$subentity['name'];
						$single_subentity['valid_privileges'] = (string)$subentity['valid_privileges'];

						$single_entity['subentities'][$single_subentity['id']] = $single_subentity;
					}
				}

				$logic_entities[$single_entity['id']] = $single_entity;
			}
		}

		###########################################################################################

		return $logic_entities;
	}

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton() { return parent::getSingleton(__CLASS__); }
}

endif;

?>
