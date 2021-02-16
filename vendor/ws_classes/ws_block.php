<?php

if(!defined('WS_BLOCK_PHP')):
	define('WS_BLOCK_PHP', true);

class WS_Block
{
	private $name = null;
	private $path = null;
	private $full_path = null;
	private $aliases = array();
	
	private $group_id = null;
	
	private $properties = array();
	
	private $default_params = array();
	private $project_params = array();

###################################################################################################

	private static $xml_block_map = null;

###################################################################################################
# public
###################################################################################################

	public function __construct($block_name)
	{
		if(strpos($block_name, '.') !== false)
			$block_name = substr($block_name, strrpos($block_name, '.') + 1);;
				
		$xml_block = self::$xml_block_map->xpath("//blocks/block[@name='$block_name' or @alias='$block_name']");
		
		if(count($xml_block) <= 0)
			throw new CN_Exception(tr(sprintf("Block `%s` is not defined.", $block_name)), E_ERROR);
		
		$this->name = (string)$xml_block[0]['name'];
		
		# path resolving ##########################################################################
		
		$sub_group_id = (string)$xml_block[0]['group_id'];
		$this->group_id = $sub_group_id;
		
		list($main_group_id) = explode('.', $sub_group_id);

		$xpath = self::$xml_block_map->xpath("//groups/group[@id='$main_group_id']");
		$main_group = (string)$xpath[0]['name'];
		
		$xpath = self::$xml_block_map->xpath("//groups/group[@id='$main_group_id']/group[@id='$sub_group_id']");
		$sub_group = (string)$xpath[0]['name'];
		
		$this->path = "$main_group.$sub_group.$block_name";
		
		# valid path resolving ####################################################################
		
		$this->full_path = WebStorm::getSingleton()->getBlockRoot().'/'.self::convertBlockPath($this->path);
		
		# block properties ########################################################################
		
		if(isset($xml_block[0]->properties[0]))
		{
			foreach($xml_block[0]->properties[0] as $property)
				$this->properties[(string)$property['name']] = (string)$property['value'];
		}

		###########################################################################################
		# block parameters ########################################################################
		
		# default parameters ######################################################################
		
		if(isset($xml_block[0]->parameters[0]))
		{
			foreach($xml_block[0]->parameters[0] as $param)
			{
				$default_value = (string)$param['default'];

				if(is_numeric($default_value))
					$default_value = (int)$default_value;
				elseif($default_value == 'true')
					$default_value = true;
				elseif($default_value == 'false')
					$default_value = false;
					
				$this->default_params[(string)$param['name']] = $default_value;
			}
		}
		
		# project parameters ######################################################################
		
		$this->project_params = WS_Design::getSingleton()->getBlockParams($this->path);
	}

###################################################################################################
# property handling ###############################################################################

	public function getName() { return $this->name; }
	public function getPath() { return $this->path; }
	public function getFullPath() { return $this->full_path; }
	public function getGroupId() { return $this->group_id; }
	
	public function getAlias() {  }

# block properties ################################################################################

	public function getProperties() { return $this->properties; }

	public function getProperty($property)
	{
		if(isset($this->properties[$property]))
			return $this->properties[$property];
		else
			return null;
	}
	
# block parameters ################################################################################

	public function getDefaultParams() { return $this->default_params; }
	public function getProjectParams() { return $this->project_params; }
	public function getParams() { return array_merge($this->default_params, $this->project_params); }
	
	public function getParam($param)
	{
		if(isset($this->project_params[$param]))
			return $this->project_params[$param];
		elseif(isset($this->default_params[$param]))
			return $this->default_params[$param];
		else
			return null;
	}

###################################################################################################
# template handling ###############################################################################

	public function getCentralTemplate($entity_id)
	{
		if(!isset($this->properties['entity_type']))
			return null;
		
		$central_template = null;
		
		$template_list = new CMS_TemplateList();
		$template_list->setTableName('templates_bindings');
		$template_list->setIdColumnName('template_id');
		$template_list->setSortBy('template_id');
		$template_list->addCondition('entity_id', $entity_id);
		$template_list->addCondition('entity_type', $this->properties['entity_type']);
		$template_list->execute();
		
		foreach($template_list as $template)
		{
			if($template->checkConditions() === true)
			{
				$entity_name = CMS_Entity::getEntityNameById($this->properties['entity_type']);
				$entity_name = strtolower(substr($entity_name, 4));
				
				$central_template = "$entity_name.{$template->getTemplate()}";
			
				break;
			}
		}
		
		return $central_template;
	}
	
###################################################################################################
# loading methods #################################################################################

# param loading ###################################################################################

	public function loadParams()
	{
		$params = $this->getParams();

		foreach($params as $param_name => $param_value)
		{
			$var_name = str_replace('.', '_', "par_$this->path.$param_name");

			$GLOBALS['smarty']->assign($var_name, $param_value);
		}
	}

# script loading ##################################################################################

	public function loadIndexScript()
	{
		$file_path = "{$this->full_path}/index.php";

		if(is_readable($file_path))
			include_once($file_path);
	}
	
	public function loadActionScript()
	{
		$file_path = "{$this->full_path}/action.php";

		if(is_readable($file_path))
			include_once($file_path);
	}
	
	public function loadCentralScript($central_template)
	{
		$template_root = WebStorm::getSingleton()->getTemplateRoot();
		$template_path = WS_Design::getSingleton()->convertTemplatePath($central_template);
		
		$file_path = "$template_root/$template_path/index.php";
		
		if(is_readable($file_path))
			include_once($file_path);
	}
	
# main file loading ###############################################################################

	public function loadStylesheet()
	{
		$file_path = "{$this->full_path}/style.css";

		if(is_readable($file_path))
			include_once($file_path);
	}	

###################################################################################################
# public static
###################################################################################################

###################################################################################################
# utility methods #################################################################################

	public static function initialise()
	{
		if(self::$xml_block_map === null)
		{
			$file = $GLOBALS['cms_root'].'/data/block_map.xml';
			
			if(function_exists('ioncube_read_file'))
				self::$xml_block_map = simplexml_load_string(ioncube_read_file($file));
			else			
				self::$xml_block_map = simplexml_load_file($file);
		}
	}

	public static function convertBlockPath($block_path)
	{
		$block_path = explode('.', $block_path);

		foreach($block_path as $index => $value)
			$block_path[$index] = CN_Utils::getRealName($value);

		return implode('/', $block_path);
	}

###################################################################################################
# search methods ##################################################################################

	public static function resolveBlockName($block_name)
	{
		$xpath = self::$xml_block_map->xpath("//blocks/block[@name='$block_name' or @alias='$block_name']");
		
		if(count($xpath) <= 0)
			throw new CN_Exception(sprintf(tr("Block `%s` doesn't exists."), $block_name), E_ERROR);
		
		return new WS_Block((string)$xpath[0]['name']);		
	}
}

endif;

?>