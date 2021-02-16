<?php

if(!defined('CN_USERAGENT_PHP')):
	define('CN_USERAGENT_PHP', true);

class CN_UserAgent
{
	private $user_agent = null;

	private $browser = null;
	private $version = null;
	private $os = null;

	private $position = null;


	function __construct()
	{
		$this->user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	}

	function __destruct()
	{
	}


	public function getInfo($user_agent=null)
	{
		if(!is_null($user_agent))
			$this->user_agent = strtolower($user_agent);

		if($this->check('konqueror') !== false)
		{
			$this->browser = 'Konqueror';
			$this->version = substr($this->user_agent, $this->position + 10, 3);
			$this->os = 'Linux';
		}
		elseif($this->check('safari') !== false)
			$this->browser = 'Safari';
		elseif($this->check('omniweb') !== false)
			$this->browser = 'OmniWeb';
		elseif($this->check('opera') !== false)
		{
			$this->browser = 'Opera';
			$this->version = $this->user_agent[$this->position + 6];
		}
		elseif($this->check('webtv') !== false)
			$this->browser = 'WebTV';
		elseif($this->check('icab') !== false)
			$this->browser = 'iCab';
		elseif($this->check('msie') !== false)
		{
			$this->browser = 'Internet Explorer';
			$this->version = substr($this->user_agent, $this->position + 5, 3);
		}
		elseif($this->check('compatibile') === false)
		{
			$this->browser = 'Mozzila';
			$this->version = substr($this->user_agent, 8, 3);
		}
		else
			$this->browser = null;

		if(is_null($this->os))
		{
			if($this->check('linux') !== false)
				$this->os = 'Linux';
			elseif($this->check('x11') !== false)
				$this->os = 'Unix';
			elseif($this->check('mac') !== false)
				$this->os = 'Mac';
			elseif($this->check('win') !== false)
				$this->os = 'Windows';
			else
				$this->os = null;
		}

		$browser_info = array();

		$browser_info['browser'] = $this->browser;
		$browser_info['version'] = $this->version;
		$browser_info['os'] = $this->os;

		return $browser_info;
	}


	final private function check($string)
	{
		$this->position = strpos($this->user_agent, $string);

		return $this->position;
	}
}

endif;

?>