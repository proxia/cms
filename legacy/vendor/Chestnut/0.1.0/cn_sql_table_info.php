<?php

if(!defined('CN_SQLTABLEINFO_PHP')):
	define('CN_SQLTABLEINFO_PHP', TRUE);

class CN_SqlTableInfo extends CN_Singleton
{
	private $object_driver = NULL;
	private $connection_name = 'default_connection';

	private $name = NULL;

	private $column_cache = array();

	protected static $_metadata_cache = array();


	public function __construct()
	{
		parent::__construct($this);
	}

	public function __destruct() { $this->removeSingleton(__CLASS__); }


	public function setConnectionName($connection_name)
	{
		$this->connection_name = $connection_name;

		$this->init();
	}

	public function setName($name) { $this->name = trim($name); }

	public function getName() { return $this->name; }


	public function getColumnCount()
	{
		if (is_null($this->object_driver))
			$this->init();

		return $this->object_driver->getColumnCount($this->name, $this->connection_name);
	}

	public function getColumnList()
	{
		if (is_null($this->object_driver))
			$this->init();

		if ( self::$_metadata_cache )
			$table_metadata = self::$_metadata_cache->load($this->name);
		else
			$table_metadata = null;

		if ( !$table_metadata )
		{
			$table_metadata = $this->object_driver->getColumnList($this->name, $this->connection_name);

			if ( self::$_metadata_cache )
				self::$_metadata_cache->save($table_metadata, $this->name);
		}

		return $table_metadata;
	}

	private function init()
	{
		$this->object_driver = CN_SqlDatabase::getDatabase($this->connection_name)->getDriverInstance();
	}


	public function getColumnInfo($column_name) { return new CN_SqlColumnInfo($column_name, $this->name, $this->connection_name); }


	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }

	public static function setMetadataCache(Zend_Cache_Core $cache) { self::$_metadata_cache = $cache; }
}

endif;

?>
