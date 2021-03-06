<?php

class CN_MySqlIDriver extends CN_SqlDriverBase
{

	public function __construct($server, $user, $password, $data_source, $connection_name)
	{
		$this->connection_name = $connection_name;

		parent::__construct($server, $user, $password, $data_source);
	}


	public function open()
	{
		$this->connection = mysqli_connect($this->server, $this->user, $this->password);

		if(!$this->connection)
			throw new CN_SqlException(sprintf(_("Error occured during connection to server `%s`."), $this->server), $this->generateSqlTrace());

		if(strlen($this->data_source) > 0)
		{
			if(!mysqli_select_db($this->connection, $this->data_source))
				throw new CN_Exception(sprintf(_("Can't select datasource `%s`."), $this->data_source));
		}

		if(!mysqli_query($this->connection, "SET NAMES 'utf8'"))
			throw new CN_SqlException(_("Error SET NAMES"), $this->generateSqlTrace());

		return true;
	}

	public function close()
	{
		if(!mysqli_close($this->connection))
			throw new CN_SqlException(sprintf(_("Can't disconnect from server `%s`."), $this->server), $this->generateSqlTrace());
	}


	public function execute(CN_SqlQuery $sql_query)
	{
		$this->current_query = $sql_query;

		$result = mysqli_query($this->connection, $sql_query->getQuery());

		if(!$result)
			throw new CN_SqlException(_("SQL query failed."), $this->generateSqlTrace());

		$object_result = null;

		if($result === true)
			$object_result = new CN_MySqlIResult($this->connection, null, $sql_query->getQueryType());
		else
			$object_result = new CN_MySqlIResult($this->connection, $result, $sql_query->getQueryType());

		return $object_result;
	}


	protected function generateSqlTrace()
	{
		$sql_trace = parent::generateSqlTrace();


		if($this->connection)
		{
			$sql_trace['errno'] = mysqli_errno($this->connection);
			$sql_trace['error'] = mysqli_error($this->connection);
		}
		else
		{
			$sql_trace['errno'] = mysqli_errno($this->connection);
			$sql_trace['error'] = mysqli_error($this->connection);
		}

		return $sql_trace;
	}




	public function getColumnCount($table_name)
	{
		$query = new CN_SqlQuery("SHOW COLUMNS FROM `$table_name`", $this->connection_name);
		$query->execute();

		return $query->getSize();
	}

	public function getColumnList($table_name)
	{
		$column_list = new CN_Vector();

		$query = new CN_SqlQuery("SHOW COLUMNS FROM `$table_name`", $this->connection_name);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$column_info = new CN_SqlColumnInfo($record->getValue('Field'), $table_name, $this->connection_name);
			$column_list->append($column_info);
		}

		return $column_list;
	}
}




class CN_MySqlIResult extends CN_SqlResultBase
{

	function __construct($connection, $result=null, $query_type=null)
	{
		parent::__construct($connection, $result);

		$this->query_type = $query_type;
		$this->current_row = -1;

		if(!is_null($result))
			$this->size = mysqli_num_rows($result);

		$this->affected_rows = mysqli_affected_rows($connection);

		if($query_type == CN_SqlQuery::TYPE_UPDATE || $query_type == CN_SqlQuery::TYPE_DELETE ||
			$query_type == CN_SqlQuery::TYPE_DROP || $query_type == CN_SqlQuery::TYPE_INSERT)
		{
			if($query_type == CN_SqlQuery::TYPE_INSERT)
				$this->insert_id = mysqli_insert_id($connection);
		}
	}


	public function rewind()
	{

	}

	public function current()
	{

	}

	public function next()
	{
		if(is_null($this->result))
			throw new CN_SqlException(_("There is no resultset defined."), null);

		if($this->current_row + 1 <= $this->size - 1)
		{
			$this->current_row += 1;

			return mysqli_data_seek($this->result, $this->current_row);
		}
		else
			return false;
	}

	public function prev()
	{
		if(is_null($this->result))
			throw new CN_SqlException(_("There is no resultset defined."), null);

		if($this->current_row - 1 >= 0)
		{
			$this->current_row -= 1;

			return mysqli_data_seek($this->result, $this->current_row);
		}
		else
			return false;
	}

	public function first()
	{
		if(is_null($this->result))
			throw new CN_SqlException(_("There is no resultset defined."), null);

		$this->current_row = 0;

		return mysqli_data_seek($this->result, $this->current_row);
	}

	public function last()
	{
		if(is_null($this->result))
			throw new CN_SqlException(_("There is no resultset defined."), null);

		$this->current_row = $this->size - 1;

		return mysqli_data_seek($this->result, $this->current_row);
	}

	public function seek($position)
	{
		if(is_null($this->result))
			throw new CN_SqlException(_("There is no resultset defined."), null);

		if($position < 0 || $position >= $this->size)
			throw new CN_SqlException(_("Seek is out of range."), null);

		return mysqli_data_seek($this->result, $position);
	}

	public function valid()
	{

	}


	public function fetchRecord()
	{
		if(is_null($this->result))
			throw new CN_SqlException(_("There is no resultset defined."), null);

		return new CN_SqlRecord(mysqli_fetch_array($this->result, MYSQLI_BOTH));
	}

	public function fetchValue($index=0)
	{
		$this->first();

		$record = mysqli_fetch_array($this->result, MYSQLI_BOTH);

		return $record[$index];
	}

	public function free()
	{
		return mysqli_free_result($this->result);
	}
}
