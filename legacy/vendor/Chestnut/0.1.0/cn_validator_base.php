<?php

if(!defined('CN_VALIDATORBASE_PHP')):
	define('CN_VALIDATORBASE_PHP', TRUE);

abstract class CN_ValidatorBase
{
	const VALID = 1;
	const INTERMEDIATE = 2;
	const INVALID = 3;

	const TYPE_STRING = 1;
	const TYPE_NUMERIC = 2;
	const TYPE_BOOLEAN = 3;

	const UNLIMITED_SIZE = -1;


	public function __construct()
	{
	}


	abstract public function validate();


	public function isEmail($email_to_check)
	{
		$pattern = '^[-a-z0-9!#$%&\'*+/=?^_<{|}~]+(\.[-a-zA-Z0-9!#$%&\'*+/=?^_<{|}~]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z0-9-]{2,}$';

		return (eregi($pattern, $email_to_check));
	}


	abstract protected function definition();

	final protected function definitionPreprocessor($definition)
	{
		/*foreach($definition as $def)
		{
			switch($def['type'])
			{
				case: self::TYPE_STRING;

					if(!isset($def['max_length']))
						$def['max_length'] = self::UNLIMITED_SIZE;
					if(!isset($def['max_length']))
						$def['exact_length'] = FALSE;
					if(!isset($def['empty']))
						$def['empty'] = TRUE;
					if(!isset($def['empty_fix']))
						$def['empty_fix'] = NULL;

					break;
				case: self::TYPE_NUMERIC;

					if(!isset($def['maximum']))
						$def['maximum'] = self::UNLIMITED_SIZE;
					if(!isset($def['minimum']))
						$def['minimum'] = self::UNLIMITED_SIZE;

					break;
				case: self::TYPE_BOOL;
					if(!isset($def['convert']))
						$def['convert'] = TRUE;

					break;
			}

			if(!isset($def['allow_null']))
				$def['allow_null'] = TRUE;
		}*/
	}
}

endif;

?>