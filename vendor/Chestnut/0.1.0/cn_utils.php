<?php

if(!defined('CN_UTILS_PHP')):
	define('CN_UTILS_PHP', true);

class CN_Utils
{

	private function __construct() {}


	public static function getRealName($object_name, $prefix=Chestnut::CHESTNUT_PREFIX)
	{
		$real_name = '';

		
		if(ctype_upper($object_name)) return strtolower($object_name);

		if(stripos($object_name, $prefix) !== false)
		{
			$object_name = str_ireplace($prefix, '', $object_name);
			$real_name .= strtolower($prefix);
		}

		$object_name = str_split($object_name);

		foreach($object_name as $letter)
		{
			if(ctype_upper($letter) && ctype_alpha($letter))
			{
				if(!empty($real_name) && $real_name[strlen($real_name) - 1] != '_')
					$real_name .= '_';

				$real_name .= strtolower($letter);
			}
			else
				$real_name .= $letter;
		}

		
		return $real_name;
	}

	public static function getObjectName($real_name, $prefix=Chestnut::CHESTNUT_PREFIX)
	{
		$object_name = '';

		
		if(ctype_upper($real_name)) return strtoupper($object_name);

		if(stripos($real_name, $prefix) !== false)
		{
			$real_name = str_ireplace($prefix, '', $real_name);
			$object_name .= strtoupper($prefix);
		}

		$real_name = str_split($real_name);

		$loop_count = count($real_name);

		for($i = 0; $i < $loop_count; $i++)
		{
			if($real_name[$i] == '_' || $i == 0)
			{
				if($i == 0)
					$object_name .= strtoupper($real_name[$i]);
				else
				{
					$object_name .= strtoupper($real_name[$i + 1]);
					$i++;
				}
			}
			else
				$object_name .= $real_name[$i];
		}

		
		return $object_name;
	}
}

endif;

?>