<?php

if(!defined('WEBSTORM_PHP')):
	define('WEBSTORM_PHP', true);

###################################################################################################
# smarty resource plugin ##########################################################################

# blocks ##########################################################################################

	function WebStorm_Block_getTemplate($block_path, &$tpl_source, &$smarty)
	{
		$tpl_source = WebStorm::getSingleton()->block_getTemplate($block_path);

		return true;
	}

	function WebStorm_Block_getTimestamp($block_path, &$tpl_timestamp, &$smarty)
	{
		$tpl_timestamp = WebStorm::getSingleton()->block_getTimestamp($block_path);

		return true;
	}

	function WebStorm_Block_isSecure($block_path, &$smarty) { return WebStorm::getSingleton()->block_isSecure($block_path); }
	function WebStorm_Block_isTrusted($block_path, &$smarty) { return WebStorm::getSingleton()->block_isTrusted($block_path); }

# templates #######################################################################################

	function WebStorm_Template_getTemplate($template_path, &$tpl_source, &$smarty)
	{
		$tpl_source = WebStorm::getSingleton()->template_getTemplate($template_path);

		return true;
	}

	function WebStorm_Template_getTimestamp($template_path, &$tpl_timestamp, &$smarty)
	{
		$tpl_timestamp = WebStorm::getSingleton()->template_getTimestamp($template_path);

		return true;
	}

	function WebStorm_Template_isSecure($template_path, &$smarty) { return WebStorm::getSingleton()->template_isSecure($template_path); }
	function WebStorm_Template_isTrusted($template_path, &$smarty) { return WebStorm::getSingleton()->template_isTrusted($template_path); }

###################################################################################################

class WebStorm extends CN_Singleton
{
	const TARGET_INDEX = 1;
	const TARGET_ACTION = 2;
	const TARGET_STYLESHEET = 3;
	const TARGET_JAVASCRIPT = 4;

	private $block_root = null;
	private $template_root = null;
	
###################################################################################################
# public
###################################################################################################

	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################
# property handling ###############################################################################

	public function setBlockRoot($block_root) { $this->block_root = $block_root; }
	public function setTemplateRoot($template_root) { $this->template_root = $template_root; }
	
	public function getBlockRoot() { return $this->block_root; }
	public function getTemplateRoot() { return $this->template_root; }

###################################################################################################
# smarty resource handling ########################################################################

# blocks ##########################################################################################

	public function block_getTemplate($block_path)
	{
		$valid_path = WS_Block::convertBlockPath($block_path);
		
		###########################################################################################

		if(!is_readable("{$this->block_root}/$valid_path"))
			throw new CN_Exception(tr(sprintf("Block at path `%s` doeasn't exists.", $block_path)), E_ERROR);

		###########################################################################################
		
		if(function_exists('ioncube_read_file'))
			return ioncube_read_file("{$this->block_root}/$valid_path/block.tpl");
		else
			return file_get_contents("{$this->block_root}/$valid_path/block.tpl");
	}

	public function block_getTimestamp($block_path)
	{
		$valid_path = WS_Block::convertBlockPath($block_path);
		
		###########################################################################################

		if(!is_readable("{$this->block_root}/$valid_path"))
			throw new CN_Exception(tr(sprintf("Block at path `%s` doeasn't exists.", $block_path)), E_ERROR);

		###########################################################################################

		return filemtime("{$this->block_root}/$valid_path/block.tpl");
	}

	public function block_isSecure($block_path) { return true; }
	public function block_isTrusted($block_path) { return true; }

# templates #######################################################################################

	public function template_getTemplate($template_path)
	{
		$valid_path = WS_Design::convertTemplatePath($template_path);

		###########################################################################################

		if(!is_readable("{$this->template_root}/$valid_path"))
			throw new CN_Exception(tr(sprintf("Template at path `%s` doeasn't exists.", $template_path)), E_ERROR);

		###########################################################################################

		if(function_exists('ioncube_read_file'))
			return ioncube_read_file("{$this->template_root}/$valid_path/template.tpl");
		else
			return file_get_contents("{$this->template_root}/$valid_path/template.tpl");
	}

	public function template_getTimestamp($template_path)
	{
		$valid_path = WS_Design::convertTemplatePath($template_path);
		
		###########################################################################################

		if(!is_readable("{$this->template_root}/$valid_path"))
			throw new CN_Exception(tr(sprintf("Template at path `%s` doeasn't exists.", $template_path)), E_ERROR);

		###########################################################################################

		return filemtime("{$this->template_root}/$valid_path/template.tpl");
	}

	public function template_isSecure($block_path) { return true; }
	public function template_isTrusted($block_path) { return true; }

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }
	
###################################################################################################
# utility methods #################################################################################

	public static function rewriteUrl($query_string)
	{
		$page = null;
		$entity_id = null;
		
		$params = explode('&', $query_string);
		
		foreach($params as $param)
		{
			if(strpos($param, '=') === false)
				break;
			
			list($param_name, $param_value) = explode('=', $param);
			
			switch($param_name)
			{
				case 'page':
					$page = $param_value;
					break;
					
				case 'entity_id':
					$entity_id = $param_value;
					break;
			}
		}
		
		$url = $page;
		$url .= $entity_id !== null ? ":$entity_id" : null;
		
		return $url;
	}
	
	public static function encodeArray($decoded_array)
	{
		$encoded_array = null;
		
		###########################################################################################
		
		foreach($decoded_array as $p_name => $p_value)
			$encoded_array .= "$p_name:$p_value,";
				
		$encoded_array = '('.rtrim($encoded_array, ',').')';
		
		return $encoded_array;
	}
	
	public static function decodeArray($encoded_array)
	{
		$decoded_array = array();
		
		###########################################################################################
		
		$encoded_array = str_replace('(', '', $encoded_array);		
		$encoded_array = str_replace(')', '', $encoded_array);
		
		$encoded_array = explode(',', $encoded_array);
		
		foreach($encoded_array as $item)
		{
			list($p_name, $p_value) = explode(':', $item);
			
			$decoded_array[$p_name] = $p_value;
		}
		
		return $decoded_array;
	}
}

endif;

?>