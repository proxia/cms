<?php

if(!defined('CMS_NEWSLETTER_PHP')):
	define('CMS_NEWSLETTER_PHP', true);

class CMS_Newsletter extends CN_Singleton
{
	const ENTITY_ID = 160;

###################################################################################################
# public
###################################################################################################

	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton() { parent::getSingleton(__CLASS__); }

###################################################################################################
# exclude list ####################################################################################

	public static function addToExcludeList($email)
	{
		$sql =<<<SQL
		INSERT INTO
			`newsletter_exclude_list`
			(
				`email`
			)
		VALUES
			(
				'$email'
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public static function isInExcludeList($email)
	{
		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`newsletter_exclude_list`
		WHERE
			`email` = '$email'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}
}

endif;

?>