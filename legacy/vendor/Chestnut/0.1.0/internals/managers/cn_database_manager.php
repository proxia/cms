<?php

if(!defined('CN_DATABASEMANAGER_PHP')):
	define('CN_DATABASEMANAGER_PHP', true);



class CN_DatabaseManager extends CN_Singleton
{
	private $database_list = null;


	public function __construct()
	{
		parent::__construct($this);


		$this->database_list = array();
	}

	public function __destruct()
	{
		$this->removeSingleton(__CLASS__);
	}


	public function insertDatabase($connection_name, CN_SqlDatabase $database)
	{
		if(!isset($this->database_list[$connection_name]))
			$this->database_list[$connection_name] = $database;
		else
			throw new CN_Exception(_("Database connections must have different names."));
	}

	public function deleteDatabase($connection_name)
	{
		$this->database_list[$connection_name]->__destruct();
		unset($this->database_list[$connection_name]);
	}


	public function getDatabase($connection_name)
	{
		if(isset($this->database_list[$connection_name]))
			return $this->database_list[$connection_name];
		else
			return null;
	}


	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }
}

endif;

?>
