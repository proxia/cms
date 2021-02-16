<?php

if(!defined('CN_TRANSLATOR_PHP')):
	define('CN_TRANSLATOR_PHP', true);


function tr($string)
{
	return CN_Translator::getSingleton()->translate($string);
}

function insert_tr($string)
{
	if ( isset($GLOBALS['overide_default_translator']) and $GLOBALS['overide_default_translator'] === true and isset($GLOBALS['custom_translator']) )
	{
		return $GLOBALS['custom_translator']->_($string['value']);
	}

	return CN_Translator::getSingleton()->translate($string['value']);
}


class CN_Translator extends CN_Singleton
{
	private $domain_list = array();


	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }


	public function addDomain($name, $path)
	{
		if(!isset($this->domain_list[$name]))
		{
			$path = realpath($path);

			bindtextdomain($name, $path);
			bind_textdomain_codeset($name, 'UTF-8');

			$this->domain_list[$name] = $path;
		}
	}

	public function removeDomain($name)
	{
		if(!isset($this->domain_list[$name]))
			unset($this->domain_list[$name]);
	}


	public function translate($string)
	{
		$translation_found = false;
		$default_translation = _($string);
		$custom_translation = $default_translation;


		if($string == $default_translation)
		{
			foreach($this->domain_list as $domain => $path)
			{
				textdomain($domain);

				$default_translation = _($string);

				if($string != $default_translation)
				{
					$custom_translation = $default_translation;
					$translation_found = true;

					break;
				}
			}
		}
		else
			return $default_translation;

		textdomain('chestnut');


		if(!$translation_found && CN_Application::getSingleton()->getDebug() === true)
			$custom_translation = '!'.$custom_translation.'!';

		return $custom_translation;
	}


	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }

}

endif;

?>