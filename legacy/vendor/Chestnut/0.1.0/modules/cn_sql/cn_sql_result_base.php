<?php

if(!defined('CN_SQLRESULTBASE_PHP')):
	define('CN_SQLRESULTBASE_PHP', true);



abstract class CN_SqlResult
{
	protected $raw_result = null;

	protected $size = null;
	protected $affected_rows = null;
	protected $insert_id = null;


	public function __construct($raw_result)
	{
		$this->raw_result = $raw_result;
	}


	public function getRawResult() { return $this->raw_result; }
	public function getSize() { return $this->size; }
	public function getAffectedRows() { return $this->affected_rows; }
	public function getInsertId() { return $this->insert_id; }


	public function hasResult() { return is_resource($this->raw_result); }


}

endif;

?>