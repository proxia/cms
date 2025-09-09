<?php
/*
if(!defined('CN_SQLDATABASE_PHP')):
	define('CN_SQLDATABASE_PHP', true);



class CN_SqlDatabase
{
	const DRIVER_ODBC = 'Odbc';
	const DRIVER_MYSQL = 'MySql';
    const DRIVER_MYSQLI = 'MySqli';
	const DRIVER_POSTGRESQL = 'PostgreSql';
	const DRIVER_MSQL = 'MSql';
	const DRIVER_SQLITE = 'SQLite';
	const DRIVER_MSSQL = 'MsSql';


	private $driver_type = null;
	private $driver = null;

	private $connection_name = null;
	private $server = 'localhost';
	private $user = null;
	private $password = null;
	private $data_source = null;

	private $raw_connection = null;


	public function setRawConnection($raw_connection) { $this->raw_connection = $raw_connection; }

	public function setServer($server) { $this->server = $server; }
	public function setUser($user) { $this->user = $user; }
	public function setPassword($password) { $this->password = $password; }
	public function setDataSource($data_source) { $this->data_source = $data_source; }


	public function getDriverType() { return $this->driver_type; }
	public function getDriver() { return $this->driver; }

	public function getConnectionName() { return $this->connection_name; }
	public function getRawConnection() { return $this->raw_connection; }

	public function getServer() { return $this->server; }
	public function getUser() { return $this->user; }
	public function getPassword() { return $this->password; }
	public function getDataSource() { return $this->data_source; }


	public function isOpen() { return !is_null($this->raw_connection); }


	public function open()
	{
		if(is_null($this->raw_connection))
			$this->driver->open($this);
	}

	public function close()
	{
		if(!is_null($this->raw_connection))
			$this->driver->close($this);

		$this->raw_connection = null;
	}


	protected function __construct($driver_type, $connection_name)
	{
		$this->driver_type = $driver_type;
		$this->connection_name = $connection_name;

		
		$driver_class_name = 'CN_'.$driver_type.'Driver';

		if(!class_exists($driver_class_name, false))
		{
			$module_path = CN_Module::getModule('CN_Sql')->getPath();

			require_once($module_path.'drivers'.DIRECTORY_SEPARATOR.strtolower($driver_type).'.php');

			$this->driver = call_user_func(array($driver_class_name, 'getSingleton'));
		}
	}


	public static function addDatabase($driver, $connection_name='defualt_connection')
	{

		$database = new CN_SqlDatabase($driver, $connection_name);

		CN_DatabaseManager::getSingleton()->insertDatabase($database);

		return $database;
	}

	public static function removeDatabase($connection_name='defualt_connection')
	{

	}

	public static function getDatabase($connection_name='defualt_connection')
	{
		return CN_DatabaseManager::getSingleton()->getDatabase($connection_name);
	}
}

endif;
*/
?>