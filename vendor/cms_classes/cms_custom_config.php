<?php

if(!defined('CMS_CUSTOMCONFIG_PHP')):
	define('CMS_CUSTOMCONFIG_PHP', true);

class CMS_CustomConfig extends CN_Singleton
{
###################################################################################################
# public
###################################################################################################

	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################

	public function setValue($entity_instance, $key, $value)
	{
		$sql =<<<SQL
		SELECT
			*
		FROM
			`custom_config`
		WHERE
			`entity_id` = {$entity_instance->getId()} AND
			`entity_type` = {$entity_instance->getType()} AND
			`key` = '$key'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->getSize() == 0)
		{
			$sql =<<<SQL
			INSERT INTO
				`custom_config`
				(
					`entity_id`,
					`entity_type`,
					`key`,
					`value`
				)
			VALUES
				(
					{$entity_instance->getId()},
					{$entity_instance->getType()},
					'$key',
					'$value'
				)
SQL;
		}
		else
		{
			$sql =<<<SQL
			UPDATE
				`custom_config`
			SET
				`value` = '$value'
			WHERE
				`entity_id` = {$entity_instance->getId()} AND
				`entity_type` = {$entity_instance->getType()} AND
				`key` = '$key'
SQL;
		}

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function getValue($entity_instance, $key)
	{
		$sql =<<<SQL
		SELECT
			*
		FROM
			`custom_config`
		WHERE
			`entity_id` = {$entity_instance->getId()} AND
			`entity_type` = {$entity_instance->getType()} AND
			`key` = '$key'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->getSize() > 0)
			return $query->fetchValue('value');
		else
			return null;
	}

###################################################################################################

	public function getAll($entity_instance)
	{
		$custom_config = array();

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`custom_config`
		WHERE
			`entity_id` = {$entity_instance->getId()} AND
			`entity_type` = {$entity_instance->getType()} AND
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$custom_config[$record->getValue('key')] = $record->getValue('value');
		}

		###########################################################################################

		return $custom_config;
	}

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton() { return parent::getSingleton(__CLASS__); }
}

endif;

?>