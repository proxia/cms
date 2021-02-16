<?php
/*
if(!defined('CN_DATABASEMANAGER_PHP')):
	define('CN_DATABASEMANAGER_PHP', true);



class CN_DatabaseManager extends CN_Singleton
{
	private $database_list = array();


	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }


	public function insertDatabase(CN_SqlDatabase $database)
	{
		$connection_name = $database->getConnectionName();

		if(!isset($this->database_list[$connection_name]))
			$this->database_list[$connection_name] = $database;
		else
			throw new CN_Exception(_("Database connections must have different names."));
	}

	public function deleteDatabase($connection_name)
	{
		if(isset($this->database_list[$connection_name]))
			unset($this->database_list[$connection_name]);
	}


	public function getDatabase($connection_name='default_connection')
	{
		if(isset($this->database_list[$connection_name]))
			return $this->database_list[$connection_name];
		else
			throw new CN_Exception(sprintf(_("Connection `%s` is not opened. Use CN_SqlDatabase::addDatabase() function to open it."), $connection_name));
	}


	public static function getSingleton() { return parent::getSingleton(__CLASS__); }
}

endif;
*/
?>