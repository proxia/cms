<?php

if(!defined('CN_EXCEPTION_PHP')):
	define('CN_EXCEPTION_PHP', TRUE);



class CN_Exception extends Exception
{

	function __construct($message, $code=null)
	{
		parent::__construct($message, $code);
	}


	public function __toString()
	{
		return __CLASS__.": [{$this->code}] {$this->message}\n";
	}


	final public function displayDetails($theme='default')
	{
		/*$e = $this;

		$type = 'exception';

		$file_path = CN_Info::getSingleton()->getInstallPath().DIRECTORY_SEPARATOR.'implementation'.DIRECTORY_SEPARATOR.'ui'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR.'exception_detail.php';

		require_once($file_path);
		exit;*/
	}
}

endif;

?>
