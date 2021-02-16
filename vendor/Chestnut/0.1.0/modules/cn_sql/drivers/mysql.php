<?php
/*
if(!defined('CN_MYSQLDRIVER_PHP')):
	define('CN_MYSQLDRIVER_PHP', true);

class CN_MySqlDriver extends CN_SqlDriverBase
{
	const KEYWORD_ESCAPE_CHAR = '`';


	private $current_query = null;


	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }


	public function open(CN_SqlDatabase $database)
	{
		$raw_connection = @mysql_connect($database->getServer(), $database->getUser(), $database->getPassword());

		if(!$raw_connection)
			throw new CN_SqlException(sprintf(_("Can't connect to server `%1\$s` as user `%2\$s`. Connection failed."), $database->getServer(), $database->getUser()), $this->generateSqlTrace($database));

		if(!mysql_select_db($database->getDataSource()))
			throw new CN_SqlException(sprintf(_("Can't select datasource `%s`."), $database->getDataSource()), $this->generateSqlTrace($database));

		if(mysql_query("SET NAMES 'utf8'") === false)
			throw new CN_SqlException(sprintf(_("Query `%s` failed to execute."), "SET NAMES 'utf8'"), $this->generateSqlTrace($database));

		$database->setRawConnection($raw_connection);
	}

	public function close(CN_SqlDatabase $database)
	{
		$raw_connection = $database->getRawConnection();

		if(is_resource($raw_connection))
		{
			if(!mysql_close($raw_connection))
				throw new CN_SqlException(sprintf(_("Can't close connection `%s`. That's strange."), $database->getConnectionName()), $this->generateSqlTrace($database));
		}
		else
			throw new CN_Exception(sprintf(_("Can't close connection `%s`. It's not opened"), $database->getConnectionName()));
	}


	public function execute(CN_SqlQuery $sql_query, CN_SqlDatabase $database)
	{
		$this->current_query = $sql_query;

		$raw_result = mysql_query($sql_query->getQuery(), $database->getRawConnection());
		$result = null;

		if(is_resource($raw_result))
		{

		}
		elseif($raw_result === true)
		{

		}
		else
			throw new CN_SqlException(_("SQL query failed to execute."), $this->generateSqlTrace($database));

		$this->current_query = null;

		return $result;
	}


	protected function generateSqlTrace(CN_SqlDatabase $database)
	{
		$sql_trace = array('query' => null, 'error_code' => null, 'error_message' => null);

		if(is_null($database->getRawConnection()))
		{
			$sql_trace['error_code'] = mysql_errno();
			$sql_trace['error_message'] = mysql_error();
		}
		else
		{
			$raw_connection = $database->getRawConnection();

			if(!is_null($this->current_query))
				$sql_trace['query'] = $this->current_query->getQuery();

			$sql_trace['error_code'] = mysql_errno($raw_connection);
			$sql_trace['error_message'] = mysql_error($raw_connection);
		}

		return $sql_trace;
	}


	public static function getSingleton() { return parent::getSingleton(__CLASS__); }
}


class CN_MySqlResult extends CN_SqlResult
{

	public function __construct($raw_result, $raw_connection)
	{
		parent::__construct($raw_result);

		
		if(is_resource($raw_result))
			$this->size = mysql_num_rows($raw_result);
		elseif($raw_result === true)
		{
			$affected_rows = mysql_affected_rows($raw_connection);

			$this->affected_rows = $affected_rows == -1 ? false : $affected_rows;
		}
		else
			throw new CN_Exception(_("Invalid result resource."));
	}
}

endif;
*/
?>