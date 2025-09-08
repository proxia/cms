<?php
/*
if(!defined('CN_SQLQUERY_PHP')):
	define('CN_SQLQUERY_PHP', true);



class CN_SqlQuery {
	const TYPE_SELECT = 1;
	const TYPE_INSERT = 2;
	const TYPE_DELETE = 3;
	const TYPE_UPDATE = 4;
	const TYPE_DROP = 5;
	const TYPE_SHOW = 6;
	const TYPE_DESCRIBE = 7;
	const TYPE_EXPLAIN = 8;


	private $connection = null;

	private $sql_query = null;
	private $query_type = null;


	public function __construct($sql_query, $connection='defualt_connection')
	{
		$sql_query = trim($sql_query);
		$sql_query = str_replace("\n", ' ', $sql_query);

		$this->sql_query = $sql_query;

		if(is_object($connection))
		{
			if($connection instanceof CN_SqlDatabase)
				$this->connection = $connection;
			else
				throw new CN_Exception(sprintf(_("Argument `\$connection` must be of type CN_SqlDatabase and not `%s`"), get_class($connection)));
		}
		elseif(is_string($connection))
			$this->connection = CN_SqlDatabase::getDatabase($connection);
		else
			throw new CN_Exception(_("Argument `\$connection` must be string or CN_SqlDatabase object."));

		$this->resolveQueryType();
	}


	public function getQuery() { return $this->sql_query; }
	public function getQueryType() { return $this->query_type; }


	public function execute()
	{
		$this->connection->getDriver()->execute($this, $this->connection->getRawConnection());
	}


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
				throw new CN_SqlException(_("Unknown query type."));
				break;
		}
	}


}

endif;
*/
?>