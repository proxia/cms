<?php

if(!defined('CMS_STATISTICS_PHP')):
	define('CMS_STATISTICS_PHP', true);

class CMS_Statistics extends CN_Singleton
{
###################################################################################################
# public
###################################################################################################

	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################

	public function getMostViewed($entity_type, $limit=5, $displayable_only=true)
	{
		$count_data = array();
		$return_data = new CN_Vector();
		$class_name = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			DISTINCT `entity_id`
		FROM
			`statistics`
		WHERE
			`entity_type` = $entity_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				`statistics`
			WHERE
				`entity_id` = {$record->getValue('entity_id')} AND
				`entity_type` = $entity_type
SQL;

			$query_2 = new CN_SqlQuery($sql);
			$query_2->execute();

			$view_count = $query_2->fetchValue();

			$count_data[$record->getValue('entity_id')] = $view_count;
		}

		arsort($count_data);

		$i = 0;

		foreach($count_data as $entity_id => $count)
		{
			if($i++ == $limit)
				break;

			$article = new CMS_Article($entity_id);

			if($displayable_only === true)
			{
				if(!$article->isDisplayable())
				{
					--$i;
					continue;
				}
			}

			$return_data->append($article);
		}

		return $return_data;
	}

	public function getViewCount($entity_id, $entity_type)
	{
		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`statistics`
		WHERE
			`entity_id` = $entity_id AND
			`entity_type` = $entity_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return $query->fetchValue();
	}

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton() { return parent::getSingleton(__CLASS__); }

###################################################################################################

	public static function addEntry($entity_id, $entity_type, $user_id=null, $user_agent=null)
	{
		if(!is_numeric($user_id))
			return;
		
		if(is_null($user_id) && is_null($user_agent))
			$user_agent = 'NULL';
		elseif(!is_null($user_id) && is_null($user_agent))
			$user_agent = $_SERVER['HTTP_USER_AGENT'];

		if(is_null($user_id))
			$user_id = 'NULL';

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`statistics`
			(
				`date`,
				`entity_id`,
				`entity_type`,
				`user_id`,
				`user_agent`
			)
		VALUES
			(
				NOW(),
				$entity_id,
				$entity_type,
				$user_id,
				'$user_agent'
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################

	public static function getSiteLastUpdate($language=null)
	{
		if(is_null($language))
			$language = CN_Application::getSingleton()->getLanguage();

		###########################################################################################

		$date_list = array();

		$sql =<<<SQL
		SELECT
			`update_authors`
		FROM
			`articles`,
			`articles_lang`
		WHERE
			`id` = `article_id` AND
			`language` = '$language'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$update_authors = $record->getValue('update_authors');

			if(strlen($update_authors) <= 0)
				continue;

			$update_authors = unserialize($update_authors);

			foreach($update_authors as $value)
				$date_list[] = strtotime($value['date']);
		}

		###########################################################################################

		$date_list = array_unique($date_list);

		if(count($date_list) == 0)
			return null;
		else
			return max($date_list);
	}
}

endif;

?>