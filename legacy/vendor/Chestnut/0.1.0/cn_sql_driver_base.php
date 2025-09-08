<?php

if(!defined('CN_SQLDRIVERBASE_PHP')):
	define('CN_SQLDRIVERBASE_PHP', TRUE);



abstract class CN_SqlDriverBase
{
	protected $connection = NULL;

	protected $server = NULL;
	protected $user = NULL;
	protected $password = NULL;
	protected $data_source = NULL;
	protected $connection_name = NULL;

	protected $current_query = NULL;


	public function __construct($server, $user, $password, $data_source)
	{
		$this->server = $server;
		$this->user = $user;
		$this->password = $password;
		$this->data_source = $data_source;
	}

	public function getRawConnection() { return $this->connection; }

	abstract public function open();
	abstract public function close();
	abstract public function execute(CN_SqlQuery $query);


	protected function generateSqlTrace()
	{
		$sql_trace = array();

		$sql_trace['data_source'] = $this->data_source;

		if(is_object($this->current_query))
			$sql_trace['query'] = $this->current_query->getQuery();

		return $sql_trace;
	}




	abstract public function getColumnCount($table_name);
	abstract public function getColumnList($table_name);
}

endif;

?>