<?php

if(!defined('CN_STRING_PHP')):
	define('CN_STRING_PHP', TRUE);

class CN_String
{
	const OCCURANCE_ALL = 1;
	const OCCURANCE_FIRST = 2;
	const OCCURANCE_LAST = 3;

	private $raw_string = '';


	public function __construct($raw_string)
	{
		$this->raw_string = trim($raw_string);
	}

	public function __toString() { return $this->raw_string; }


	public function getRawString() { return $this->raw_string; }


	public function length()
	{
		return strlen($this->raw_string);
	}

	public function isEmpty()
	{
		return (strlen($this->raw_string) == 0);
	}


	public function trim()
	{
		$this->raw_string = trim($this->raw_string);
	}


	public function insert($position, $string)
	{
		$tmp_string = '';
		$index = 0;

		$splitted = str_split($this->raw_string);

		foreach($splitted as $char)
		{
			if($index == $position)
				$tmp_string .= $string;

			$tmp_string .= $char;

			++$index;
		}

		$this->raw_string = $tmp_string;
	}

	public function insertBefore($before, $string, $occurance=OCCURANCE_ALL)
	{
	}

	public function insertAfter($after, $string, $occurance=OCCURANCE_ALL)
	{
	}

	public function	prepend($string)
	{
		if($string instanceof CN_String)
			$string = $string->getRawString();

		$this->raw_string = $string.$this->raw_string;
	}

	public function append($string)
	{
		$this->raw_string .= $string;
	}


	


	public static function isUppercase($string)
	{
		if(strlen($string) == 1)
			return (ord($string) == ord(strtoupper($string)));
		else
			return (crc32($string) == crc32(strtoupper($string)));
	}

	public static function isLowercase($string)
	{
		if(strlen($string) == 1)
			return (ord($string) == ord(strtolower($string)));
		else
			return (crc32($string) == crc32(strtolower($string)));
	}
}

endif;

?>