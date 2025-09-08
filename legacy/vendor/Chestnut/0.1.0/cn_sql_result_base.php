<?php

if(!defined('CN_SQLRESULTBASE_PHP')):
	define('CN_SQLRESULTBASE_PHP', true);



abstract class CN_SqlResultBase
{
	protected $connection = NULL;
	protected $result = NULL;

	protected $query_type = NULL;

	protected $size = NULL;
	protected $affected_rows = NULL;
	protected $insert_id = NULL;

	protected $current_row = NULL;


	function __construct($connection, $result)
	{
		$this->connection = $connection;
		$this->result = $result;
	}


	public function getRawResult() { return $this->result; }
	public function getSize() { return $this->size; }
	public function getAffectedRows() { return $this->affected_rows; }
	public function getInsertId() { return $this->insert_id; }


	public function hasResult()
	{
		if(
			$this->query_type == CN_SqlQuery::TYPE_SELECT ||
			$this->query_type == CN_SqlQuery::TYPE_SHOW ||
			$this->query_type == CN_SqlQuery::TYPE_DESCRIBE ||
			$this->query_type == CN_SqlQuery::TYPE_EXPLAIN &&
			!is_null($this->result)
			)
			return TRUE;
		else
			return FALSE;
	}


	abstract public function next();
	abstract public function prev();
	abstract public function first();
	abstract public function last();
	abstract public function seek($position);


	abstract public function fetchRecord();
	abstract public function fetchValue($index=0);
}

endif;

?>