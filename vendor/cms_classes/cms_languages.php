<?php

if(!defined('CMS_LANGUAGES_PHP')):
	define('CMS_LANGUAGES_PHP', true);

class CMS_Languages extends CN_Singleton
{
###################################################################################################
# public
###################################################################################################

	public function __construct() { parent::__construct($this); }
	public function __destruct() {  $this->removeSingleton(__CLASS__); }

###################################################################################################

	public function getList()
	{
		$language_list = array();

		$query = new CN_SqlQuery("SELECT * FROM `languages`");
		$query->execute();

		while($query->next())
		{
			$language_detail = array();
			$record = $query->fetchRecord();

			$language_detail['code'] = $record->getValue('code');
			$language_detail['native_name'] = $record->getValue('native_name');
			$language_detail['global_visibility'] = $record->getValue('global_visibility');
			$language_detail['local_visibility'] = $record->getValue('local_visibility');

			$language_list[$record->getValue('code')] = $language_detail;
		}

		return $language_list;
	}

	public function getGlobalLanguages()
	{
		$language_list = array();

		$query = new CN_SqlQuery("SELECT * FROM `languages` WHERE `global_visibility` = 1");
		$query->execute();

		while($query->next())
		{
			$language_detail = array();
			$record = $query->fetchRecord();

			$language_detail['code'] = $record->getValue('code');
			$language_detail['native_name'] = $record->getValue('native_name');
			$language_detail['global_visibility'] = $record->getValue('global_visibility');
			$language_detail['local_visibility'] = $record->getValue('local_visibility');

			$language_list[$record->getValue('code')] = $language_detail;
		}

		return $language_list;
	}

	public function getLocalLanguages()
	{
		$language_list = array();

		$query = new CN_SqlQuery("SELECT * FROM `languages` WHERE `local_visibility` = 1");
		$query->execute();

		while($query->next())
		{
			$language_detail = array();
			$record = $query->fetchRecord();

			$language_detail['code'] = $record->getValue('code');
			$language_detail['native_name'] = $record->getValue('native_name');
			$language_detail['global_visibility'] = $record->getValue('global_visibility');
			$language_detail['local_visibility'] = $record->getValue('local_visibility');

			$language_list[$record->getValue('code')] = $language_detail;
		}

		return $language_list;
	}

###################################################################################################

	public function addLanguage($code, $native_name)
	{
		$sql =<<<SQL
		INSERT INTO
			`languages`
			(
				`code`,
				`native_name`
			)
		VALUES
			(
				'$code',
				'$native_name'
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeLanguage($code)
	{
		$query = new CN_SqlQuery("DELETE FROM `languages` WHERE `code`='$code'");
		$query->execute();
	}

###################################################################################################

	public function setValue($code, $column_name, $value)
	{
		if(is_string($value))
			$value = "'$value'";
		else
			$value = (int)$value;

		$sql =<<<SQL
		UPDATE
			`languages`
		SET
			`$column_name` = $value
		WHERE
			`code` = '$code'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton() { return parent::getSingleton(__CLASS__); }

###################################################################################################

	public static function getAvailableTranslations($path_to_project_project)
	{
		$available_translations = array();

		###########################################################################################

		$dir = new DirectoryIterator($path_to_project_project.DIRECTORY_SEPARATOR.'locales');

		foreach($dir as $translation)
		{
			if($translation->isDot())
				continue;

			$available_translations[] = $translation->getFileName();
		}

		###########################################################################################

		return $available_translations;
	}
}

endif;

?>