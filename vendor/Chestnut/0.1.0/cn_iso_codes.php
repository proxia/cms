<?php

if(!defined('CN_ISOCODES_PHP')):
	define('CN_ISOCODES_PHP', true);

class CN_IsoCodes extends CN_Singleton
{
	const LIST_FULL = 1;
	const LIST_ISO_3166 = 2;
	const LIST_ISO_3166_2 = 4;
	const LIST_ISO_3166_3 = 8;
	const LIST_ISO_4217 = 16;
	const LIST_ISO_639 = 36;


	private $data_iso_3166 = null;
	private $data_iso_3166_2 = null;
	private $data_iso_3166_3 = null;
	private $data_iso_4217 = null;
	private $data_iso_639 = null;

	private $list_flags = null;

	private $info_list = null;
	private $isos_to_fetch = array();


	public function __construct()
	{
		parent::__construct($this);

		
		$this->info_list = array
		(
			self::LIST_ISO_3166 => array
				(
					'iso_number' => 'iso_3166',
					'file' => CN_Info::getSingleton()->getInstallPath().'data'.DIRECTORY_SEPARATOR.'iso-codes'.DIRECTORY_SEPARATOR.'iso_3166.xml',
					'data_array' => &$this->data_iso_3166,
					'attributes' => 'alpha_2_code, alpha_3_code, numeric_code, _name, _official_name',
					'key_attribute' => 'alpha_2_code'
				),

			self::LIST_ISO_4217 => array
				(
					'iso_number' => 'iso_4217',
					'file' => CN_Info::getSingleton()->getInstallPath().'data'.DIRECTORY_SEPARATOR.'iso-codes'.DIRECTORY_SEPARATOR.'iso_4217.xml',
					'data_array' => &$this->data_iso_4217,
					'attributes' => 'letter_code, numeric_code, _currency_name',
					'key_attribute' => 'letter_code'
				),

			self::LIST_ISO_639 => array
				(
					'iso_number' => 'iso_639',
					'file' => CN_Info::getSingleton()->getInstallPath().'data'.DIRECTORY_SEPARATOR.'iso-codes'.DIRECTORY_SEPARATOR.'iso_639.xml',
					'data_array' => &$this->data_iso_639,
					'attributes' => 'iso_639_2B_code, iso_639_2T_code, iso_639_1_code, _name',
					'key_attribute' => 'iso_639_2T_code'
				)
		);
	}

	public function __destruct() { $this->removeSingleton(__CLASS__); }


	public function getList($list_flags=self::LIST_FULL, $native_language=false)
	{
		$this->list_flags = $list_flags;

		if($list_flags & self::LIST_FULL)
			die('LIST_FULL not implemented, hahaha ;-)');

		if($list_flags & self::LIST_ISO_3166)
			$this->isos_to_fetch[] = self::LIST_ISO_3166;
		if($list_flags & self::LIST_ISO_4217)
			$this->isos_to_fetch[] = self::LIST_ISO_4217;
		if($list_flags & self::LIST_ISO_639)
			$this->isos_to_fetch[] = self::LIST_ISO_639;

		$this->fetchISOData($native_language);

		return $this->info_list[$this->isos_to_fetch[0]]['data_array'];
	}


	private function fetchISOData($native_language)
	{
		foreach($this->isos_to_fetch as $iso)
		{
			if(!is_null($this->info_list[$iso]['data_array']))
				continue;

			$iso_number = $this->info_list[$iso]['iso_number'];
			$iso_entry_name = $iso_number.'_entry';

			$original_language = CN_Application::getSingleton()->getLanguage();

			bindtextdomain($iso_number, CN_Info::getSingleton()->getInstallPath().'translations');
			textdomain($iso_number);
			bind_textdomain_codeset($iso_number, 'UTF-8');

			$xml = simplexml_load_file($this->info_list[$iso]['file']);

			foreach($xml->$iso_entry_name as $iso_entry)
			{
				$data = array();

				$attrs = explode(', ', $this->info_list[$iso]['attributes']);

				$current_language = null;

				foreach($attrs as $attr_name)
				{
					if($attr_name{0} == '_')
					{
						if($native_language === true)
						{
							CN_Application::getSingleton()->setLanguage($current_language);
							
							textdomain($iso_number);
						}
					
						$attr_name = substr($attr_name, 1);

						$data[$attr_name] =  isset($iso_entry[$attr_name]) ? _((string)$iso_entry[$attr_name]) : null;
					}
					else
					{
						if($attr_name == 'iso_639_1_code')
							$current_language = $iso_entry[$attr_name];
					
						$data[$attr_name] = isset($iso_entry[$attr_name]) ? (string)$iso_entry[$attr_name] : null;
					}
				}

				$this->info_list[$iso]['data_array'][(string)$iso_entry[$this->info_list[$iso]['key_attribute']]] = $data;
			}
		}

		if($native_language === true)
			CN_Application::getSingleton()->setLanguage($original_language);
			
		textdomain('chestnut');
	}


	public static function getSIngleton() { return parent::getSingleton(__CLASS__); }

}

endif;

?>