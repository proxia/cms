<?php

if(!defined('CN_SQLDATABASE_PHP')):
	define('CN_SQLDATABASE_PHP', TRUE);



class CN_SqlDatabase
{
	const DRIVER_ODBC = 'Odbc';
	const DRIVER_MYSQL = 'MySql';
	const DRIVER_MYSQLI = 'MySqli';
	const DRIVER_POSTGRESQL = 'PostgreSql';
	const DRIVER_MSQL = 'MSql';
	const DRIVER_SQLITE = 'SQLite';
	const DRIVER_MSSQL = 'MSsql';

	private $object_driver = NULL;

	private $driver = NULL;
	private $server = 'webhost.nameserver.sk';
	private $user = NULL;
	private $password = NULL;
	private $data_source = NULL;

	private $connection_name = NULL;

	private $is_open = FALSE;


	public function __destruct() {}


	public function setServer($server)
	{
		$this->server = $server;
	}

	public function setUser($user)
	{
		$this->user = $user;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function setDataSource($data_source)
	{
		$this->data_source = $data_source;
	}


	public function getDriverInstance() { return $this->object_driver; }
	public function getRawConnection() { return $this->object_driver->getRawConnection(); }


	public function isOpen() { return $this->is_open; }


	public function open()
	{
		if(!is_object($this->object_driver))
		{
			$driver = 'CN_'.$this->driver.'Driver';
			$driver_file = CN_Info::getSingleton()->getInstallPath().'internals'.DIRECTORY_SEPARATOR.'sql_drivers'.DIRECTORY_SEPARATOR;
			$driver_file .= 'cn_'.strtolower($this->driver).'_driver.php';

			require_once($driver_file);

			$this->object_driver = new $driver($this->server, $this->user, $this->password, $this->data_source, $this->connection_name);
		}

		$this->is_open = $this->object_driver->open();
	}

	public function close()
	{
		if($this->is_open)
			$this->is_open = !$this->object_driver->close();
	}


	public function execute(CN_SqlQuery $sql_query)	{ return $this->object_driver->execute($sql_query); }


	protected function __construct($driver, $connection_name)
	{
		$this->driver = $driver;
		$this->connection_name = $connection_name;
	}


	static public function addDatabase($driver, $connection_name='default_connection')
	{

		$object = new CN_SqlDatabase($driver, $connection_name);

		CN_DatabaseManager::getSingleton()->insertDatabase($connection_name, $object);

		return self::getDatabase($connection_name);
	}

	static public function removeDatabase($connection_name='default_connection')
	{
		$object = self::getDatabase($connection_name);

		if(is_object($object))
			$object->close();

		CN_DatabaseManager::getSingleton()->deleteDatabase($connection_name);
	}

	static public function getDatabase($connection_name='default_connection')
	{
		return CN_DatabaseManager::getSingleton()->getDatabase($connection_name);
	}
}

endif;

?>
