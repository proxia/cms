<?php

class CN_Application extends CN_Singleton
{
	private $debug_mode = false;
	private $language = null;

	private $message_handler = null;


	public function __construct()
	{
		parent::__construct($this);

		$this->setLanguage('en');
	}


	public function __destruct()
	{
		$this->removeSingleton(__CLASS__);
	}


	public function __toString()
	{
		if($this->debug_mode === true)
		{
			return '<pre style="text-align: left;">'.print_r($this, true).'</pre>';
		}

		return '';
	}



	public function setDebug($bool)
	{
		if($bool)
		{
            error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);
            ini_set('display_errors', 1);

			$this->debug_mode = true;
		}
		else
		{
			error_reporting(0);
            ini_set('display_errors', 0);

			$this->debug_mode = false;
		}
	}


	public function setLanguage($language)
	{
		setlocale(LC_ALL, $language);
		putenv("LC_ALL=$language");

		$domain = 'chestnut';

		bindtextdomain($domain, CN_Info::getSingleton()->getInstallPath().'translations');
		bind_textdomain_codeset($domain, 'UTF-8');
		textdomain($domain);


		$this->language = $language;
	}



	public function getDebug() { return $this->debug_mode; }


	public function getLanguage() { return $this->language; }


	public function getMessageHandler() { return $this->message_handler; }



	public function installMessageHandler(CN_MessageHandler $message_handler)
	{
		$this->message_handler = $message_handler;
	}



	public function getAvailableModules()
	{
		$module_list = array();


		$module_path = array(
								Chestnut::MODULE_SCOPE_GLOBAL => CN_Info::getSingleton()->getInstallPath().'modules',
								Chestnut::MODULE_SCOPE_LOCAL => '.'.DIRECTORY_SEPARATOR.'modules'
							);

		foreach($module_path as $scope => $path)
		{
			if(is_dir($path) && is_readable($path))
			{
				$directory = dir($path);

				while(($entry = $directory->read()) !== false)
				{
					if($entry == '.' || $entry == '..')
						continue;

					if(is_dir($path.DIRECTORY_SEPARATOR.$entry) && is_readable($path.DIRECTORY_SEPARATOR.$entry))
						$module_list[$entry] = new CN_Module($entry, $scope);
				}
			}
		}

		return $module_list;
	}

	public function utiliseModule($name)
	{
		CN_Module::addModule($name)->utilise();
	}

	public static function getSingleton($name = __CLASS__): self { return parent::getSingleton($name); }
}
