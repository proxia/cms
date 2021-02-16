<?php
/*
if(!defined('CN_SQLEXCEPTION_PHP')):
	define('CN_SQLEXCEPTION_PHP', TRUE);



class CN_SqlException extends CN_Exception
{
	private $sql_trace = array();


	public function __construct($message, $sql_trace, $code=null)
	{
		parent::__construct($message, $code);

		$this->sql_trace = $sql_trace;
	}


	final public function getSqlQuery() { return $this->sql_trace['query']; }
	final public function getErrorCode() { return $this->sql_trace['error_code']; }
	final public function getErrorString() { return $this->sql_trace['error_message']; }


	final public function getSqlTrace() { return $this->sql_trace; }
}

endif;
*/
?>