<?php
if(!defined('CN_SQLQUERY_PHP')):
	define('CN_SQLQUERY_PHP', TRUE);



class CN_SqlQuery
{
	const TYPE_SELECT = 1;
	const TYPE_INSERT = 2;
	const TYPE_DELETE = 3;
	const TYPE_UPDATE = 4;
	const TYPE_DROP = 5;
	const TYPE_SHOW = 6;
	const TYPE_DESCRIBE = 7;
	const TYPE_EXPLAIN = 8;

	private $object_driver = NULL;
	private $object_result = NULL;

	private $sql_query = NULL;
	private $query_type = NULL;
	private $query_prepared = FALSE;
	private $connection_name = 'default_connection';

	function __construct($sql_query, $connection_name=null)
	{
		if (!is_null($connection_name))
			$this->connection_name = $connection_name;

		$this->object_driver = CN_SqlDatabase::getDatabase($this->connection_name)->getDriverInstance();

		$this->sql_query = trim($sql_query);
		$this->sql_query = str_replace("\n", ' ', $this->sql_query);
		$this->resolveQueryType();
	}


	public function getQuery() { return $this->sql_query; }
	public function getQueryType() { return $this->query_type; }
	public function getConnectionName() { return $this->connection_name; }


	public function prepare($sql_query) {}

	public function execute()
	{
		if(is_null($this->object_driver))
			throw new CN_SqlException(_("No SQL driver is loaded."), null);

		$this->object_result = $this->object_driver->execute($this);
	}


	public function getRawResult() { return $this->object_result->getRawResult(); }
	public function getSize() { return $this->object_result->getSize(); }
	public function getAffectedRows() { return $this->object_result->getAffectedRows(); }
	public function getInsertId() { return $this->object_result->getInsertId(); }
	public function hasResult() { return $this->object_result->hasResult(); }


	public function next() { return $this->object_result->next(); }
	public function prev() { return $this->object_result->prev(); }
	public function first() { return $this->object_result->first(); }
	public function last() { return $this->object_result->last(); }
	public function seek($position) { return $this->object_result->seek($position); }


	public function fetchRecord() { return $this->object_result->fetchRecord(); }
	public function fetchValue($index=0) { return $this->object_result->fetchValue($index); }

	public function free() { return $this->object_result->free(); }

	private function resolveQueryType()
	{
		list($statement) = explode(' ', $this->sql_query);

		$statement = strtolower($statement);

		switch($statement)
		{
			case 'select':
				$this->query_type = self::TYPE_SELECT;

				break;
			case 'insert':
				$this->query_type = self::TYPE_INSERT;

				break;
			case 'delete':
				$this->query_type = self::TYPE_DELETE;

				break;
			case 'update':
				$this->query_type = self::TYPE_UPDATE;

				break;
			case 'drop':
				$this->query_type = self::TYPE_DROP;

				break;
			case 'show':
				$this->query_type = self::TYPE_SHOW;

				break;
			case 'describe':
				$this->query_type = self::TYPE_DESCRIBE;

				break;
			case 'explain':
				$this->query_type = self::TYPE_EXPLAIN;

				break;

			default:
				//throw new CN_SqlException(_("Unknown query type."), null);
				break;
		}
	}
}

endif;

?>