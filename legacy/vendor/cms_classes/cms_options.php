<?php

if(!defined('CMS_OPTIONS_PHP')):
	define('CMS_OPTIONS_PHP', true);

class CMS_Options extends CN_Singleton
{
###################################################################################################
# public
###################################################################################################

	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################

	public function keyExists($key)
	{
		$sql =<<<SQL
		SELECT
			`value`
		FROM
			`options`
		WHERE
			key = '$key'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->getSize() > 1)
			throw new CN_Exception(sprintf(tr("Key `%s` have duplicate entries in database. Only one entry is allowed."), $key));

		return ($query->getSize() > 0);
	}

###################################################################################################

	public function getAllKeys()
	{
		$options = array();

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`options`
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$options[$record->getValue('key')] = $record->getValue('value');
		}

		###########################################################################################

		return $options;
	}

	public function getValue($key)
	{
		$sql =<<<SQL
		SELECT
			`value`
		FROM
			`options`
		WHERE
			key = '$key'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->getSize() <= 0)
			throw new CN_Exception(sprintf(tr("Key `%s` was not found in database."), $key));
		elseif($query->getSize() > 1)
			throw new CN_Exception(sprintf(tr("Key `%s` have duplicate entries in database. Only one entry is allowed."), $key));

		return $query->fetchValue();
	}

	public function setValue($key, $value)
	{
		if(!$this->keyExists($key))
			throw new CN_Exception(sprintf(tr("Key `%s` was not found in database."), $key));

		$sql =<<<SQL
		UPDATE
			`options`
		SET
			value = '$value'
		WHERE
			key = '$key'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton() { return parent::getSingleton(__CLASS__); }
}

endif;

?>