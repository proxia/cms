<?php

if(!defined('CN_INFO_PHP')):
	define('CN_INFO_PHP', true);

class CN_Info extends CN_Singleton
{
	private $install_path;


	public function __construct()
	{
		parent::__construct($this);

			}

	public function __destruct()
	{
		$this->removeSingleton(__CLASS__);
	}


	public function setInstallPath($install_path)
	{
		//$this->install_path = realpath($install_path).DIRECTORY_SEPARATOR;
		$this->install_path = $install_path;
	}

	public function getInstallPath() { return $this->install_path; }


	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }
}

endif;

?>