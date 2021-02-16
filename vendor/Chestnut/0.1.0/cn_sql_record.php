<?php

if(!defined('CN_SQLRECORD_PHP')):
	define('CN_SQLRECORD_PHP', TRUE);

class CN_SqlRecord
{
	private $values = array();


	public function __construct($values)
	{
		$this->values = $values;
	}


	public function getCount() { return count($this->values) / 2; }
	public function isNull($index) { return is_null($this->values[$index]); }


	public function getPosition($column_name)
	{
		$is_column_found = FALSE;
		$index = 0;

		foreach($this->values as $key => $value)
		{
			if(is_string($key))
			{
				if(strcmp($key, $column_name) == 0)
				{
					$is_column_found = TRUE;
					break;
				}

				++$index;
			}
		}

		if($is_column_found)
			return $index;
		else
			return FALSE;
	}

	public function getName($index)
	{
		$column_name = FALSE;
		$index_tmp = 0;

		foreach($this->values as $key => $value)
		{
			if(is_string($key))
			{
				if($index_tmp == $index)
					$column_name = $key;

				++$index_tmp;
			}
		}

		return $column_name;
	}


	public function getValue($index)
	{
		if(!isset($this->values[$index]))
			;

		return $this->values[$index];
	}


}

endif;

?>