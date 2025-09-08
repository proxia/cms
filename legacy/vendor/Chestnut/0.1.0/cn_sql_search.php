<?php

if(!defined('CN_SQL_SEARCH_PHP')):
	define('CN_SQL_SEARCH_PHP', true);

class CN_SqlSearch
{
	const ENGINE_FULLTEXT = 0x01;
	const ENGINE_REGEXP = 0x02;
	const ENGINE_MATCH = 0x03;


	protected $tables = array();
	protected $columns_select = array();


	public function __construct()
	{

	}


	
	public function setTables($tables)
	{
		if(!is_array($tables))
			throw new CN_Exception("Wrong parameter type. Expecting array.", E_ERROR);

		foreach($tables as $table)
		{
			$table = "`$table`";

			if(!in_array($table, $this->tables))
				$this->tables[] = $table;
		}
	}

	public function getTables() { return $this->tables; }

	public function addTable($table)
	{
		$table = "`$table`";

		if(!in_array($table, $this->tables))
			$this->tables[] = $table;
	}

	public function removeTable($table)
	{
		$table = "`$table`";

		if(($key = array_search($table, $this->tables)) !== false)
			unset($this->tables[$key]);
	}

	
	public function setSelectColumns($select_columns)
	{

	}

	public function getSelectColumns() { return $this->columns_select; }

	public function addSelectColumn($column, $table=null)
	{
		$column = "`$column`";

		if(!is_null($table))
			$column = "`$table`.".$column;

		if(!in_array($column, $this->columns_select))
			$this->columns_select[] = $column;
	}

	public function removeSelectColumn($column, $table=null)
	{

	}

}

endif;

?>