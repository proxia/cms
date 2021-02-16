<?php

if(!defined('CN_SESSION_PHP')):
	define('CN_SESSION_PHP', TRUE);

class CN_Session extends CN_Singleton
{
	private $is_running = false;

	private $name = null;


	public function __construct()
	{
		parent::__construct($this);

		
		$this->name = session_name();
	}

	public function __destruct()
	{
		$this->removeSingleton(__CLASS__);
	}


	public function setName($name) { $this->name = $name; }


	public function start()
	{
		session_name($this->name);
		session_start();

		$this->is_running = true;
	}

	public function stop($kill_cookie=false)
	{
		if($kill_cookie === true)
		{
			if(isset($_COOKIE[session_name()]))
				setcookie(session_name(), '', time() - 42000, '/');
		}

		session_unset();
		session_destroy();

		$this->is_running = false;
	}


	public function register($name, $value)
	{
		$_SESSION[$name] = $value;
	}

	public function unregister($name)
	{
		if(isset($_SESSION[$name]))
			unset($_SESSION[$name]);
	}

	public function clear()
	{
		$_SESSION = array();
	}


	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }
}

endif;

?>