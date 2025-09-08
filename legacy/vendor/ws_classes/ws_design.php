<?php

class WS_Design extends CN_Singleton
{
	private $design_file = 'design.xml';

	private $xml = null;

###################################################################################################
# public
###################################################################################################

	public function __construct() {	parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################
# property handling ###############################################################################

	public function setDesignFile($file) { $this->design_file = $file; }

###################################################################################################
# initialization ##################################################################################

	public function loadDesign()
	{
		if(!file_exists($this->design_file))
			return false;

		if(function_exists('ioncube_read_file'))
			$this->xml = simplexml_load_string(ioncube_read_file($this->design_file));
		else
			$this->xml = simplexml_load_file($this->design_file);
	}

###################################################################################################
# component handling ##############################################################################

# block component handling ########################################################################

	public function getBlockComponents()
	{
		$block_components = array();

		###########################################################################################

		foreach($this->xml->components->blocks->block as $component)
			$block_components[] = (string)$component['path'];

		###########################################################################################

		return $block_components;
	}

	public function loadAllBlockComponents($target_script)
	{
		$block_root = WebStorm::getSingleton()->getBlockRoot();
		$block_components = $this->getBlockComponents();

		foreach($block_components as $block_path)
		{

			$valid_block_path = WS_Block::convertBlockPath($block_path);

			$file = null;
			$skip_inclusion = false;

			switch($target_script)
			{
				case WebStorm::TARGET_ACTION:
					$file = 'action.php';
					break;

				case WebStorm::TARGET_STYLESHEET:
					$file = 'style.css';
					break;

				case WebStorm::TARGET_JAVASCRIPT:

					if(is_readable("$block_root/$valid_block_path/javascript"))
					{
						$dir = new DirectoryIterator("$block_root/$valid_block_path/javascript");

						foreach($dir as $entry)
						{
							if($entry->isFile() && (substr($entry, -2) == 'js'))
								include_once("$block_root/$valid_block_path/javascript/$entry");
						}
					}

					$skip_inclusion = true;

					break;

				default:
					$file = 'index.php';
					break;
			}

			if($skip_inclusion === false)
			{
				$file_path = "$block_root/$valid_block_path/$file";

				if(is_readable($file_path))
					include_once($file_path);
			}

			#######################################################################################

			if($target_script === WebStorm::TARGET_INDEX)
			{
				$block_name = substr($block_path, strrpos($block_path, '.') + 1);

				$block = new WS_Block($block_name);

				$params = $block->getParams();

				foreach($params as $param_name => $param_value)
				{
					$var_name = str_replace('.', '_', "par_$block_path.$param_name");

					$GLOBALS['smarty']->assign($var_name, $param_value);
				}
			}

		}

	}

###################################################################################################
# blocks handling #################################################################################

# script loading ##################################################################################

	public function loadBlockIndexScript($block)
	{
		$block_root = WebStorm::getSingleton()->getBlockRoot();
		$block_path = WS_Block::convertBlockPath($block);

		$file_path = "$block_root/$block_path/index.php";

		if(is_readable($file_path))
			include_once($file_path);
	}

	public function loadBlockActionScript($block)
	{
		$block_root = WebStorm::getSingleton()->getBlockRoot();
		$block_path = WS_Block::convertBlockPath($block);

		$file_path = "$block_root/$block_path/action.php";

		if(is_readable($file_path))
			include_once($file_path);
	}

# parameters ######################################################################################

	public function getBlockParams($block_path)
	{
		$params = array();

		###########################################################################################

		list($block_group, $block_subgroup, $block_name) = explode('.', $block_path);

		$xpath = $this->xml->xpath("//groups/group[@name='$block_group']/subgroup[@name='$block_subgroup']/blocks/block[@name='$block_name']/parameters");

		if($xpath === false or !isset($xpath[0]))
			return array(); // ked block nieje definovany vo design.xml

		$children = $xpath[0]->children();

		foreach($children as $param)
		{
			$value = (string)$param['value'];

			if(is_numeric($value))
				$value = (int)$value;
			elseif($value == 'true')
				$value = true;
			elseif($value == 'false')
				$value = false;

			$params[(string)$param['name']] = $value;
		}

		###########################################################################################

		return $params;
	}


###################################################################################################
# templates handling ##############################################################################

# script loading ##################################################################################

	public function loadTemplateActionScript($template)
	{
		$template_root = WebStorm::getSingleton()->getTemplateRoot();
		$template_path = self::convertTemplatePath($template);

		$file_path = "$template_root/$template_path/action.php";

		if(is_readable($file_path))
			include_once($file_path);
	}

###################################################################################################
# cleanup ##############################################################################

	public function cleanup()
	{
		$loaded_blocks = $this->getBlockComponents();

		if(isset($_GET['page']))
		{
			$ws_block = new WS_Block($_GET['page']);
			$loaded_blocks[] = $ws_block->getPath();
		}

		foreach($loaded_blocks as $block_name)
		{
			$block_name = str_replace('.', '_', $block_name);
			$function_name = $block_name."_cleanup";

			if(function_exists($function_name))
				$function_name();
		}
	}

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }

###################################################################################################
# utility methods #################################################################################

	public static function convertTemplatePath($template_path)
	{
		$template_path = explode('.', $template_path);

		foreach($template_path as $index => $value)
			$template_path[$index] = CN_Utils::getRealName($value);

		return implode('/', $template_path);
	}
}
