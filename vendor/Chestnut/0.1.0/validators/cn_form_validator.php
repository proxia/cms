<?php

if(!defined('CN_FORMVALIDATOR')):
	define('CN_FORMVALIDATOR', TRUE);

class CN_FormValidator extends CN_ValidatorBase
{

	public function __construct()
	{
	}


	public function validate($definition)
	{
		foreach($definition as $def)
		{
			$field_name = $def['name'];

			if(!isset($_POST[$field_name]) && $def['allow_null'] === FALSE)
				throw new CN_FormValidatorException();
		}
	}


	protected function definition()
	{
		$definition = array();

		$definition[] = array('name' => 'login', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 30);
		$definition[] = array('name' => 'password', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 30);
		$definition[] = array('name' => 'nickname', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 30);
		$definition[] = array('name' => 'firstname', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 30);
		$definition[] = array('name' => 'familyname', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 30);
		$definition[] = array('name' => 'title', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 30);
		$definition[] = array('name' => 'street', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 30);
		$definition[] = array('name' => 'city', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 30);
		$definition[] = array('name' => 'zip', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 10);
		$definition[] = array('name' => 'country', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 3, 'exact_length' => TRUE);
		$definition[] = array('name' => 'phone', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 20);
		$definition[] = array('name' => 'fax', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 20);
		$definition[] = array('name' => 'cell', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 20);
		$definition[] = array('name' => 'email', 'type' => CN_ValidatorBase::TYPE_STRING, 'max_length' => 50);
		$definition[] = array('name' => 'group_id', 'type' => CN_ValidatorBase::TYPE_NUMERIC, 'minimum' => 1, 'maximum' => 99);
		$definition[] = array('name' => 'company_id', 'type' => CN_ValidatorBase::TYPE_NUMERIC, 'minimum' => 1, 'maximum' => 9999);
		$definition[] = array('name' => 'is_enabled', 'type' => CN_ValidatorBase::TYPE_BOOLEAN, 'convert' => TRUE);

		return $definition;
	}
}

endif;

?>