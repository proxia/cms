<?php

if(!defined('CMS_COMPANY_PHP')):
	define('CMS_COMPANY_PHP', true);

class CMS_Company extends CMS_Entity
{
	const ENTITY_ID = 150;

###################################################################################################
# public
###################################################################################################

	public function __construct($company_id=null)
	{
		$this->main_table = 'company_companies';
		$this->lang_table = 'company_companies_lang';
		$this->id_column_name = 'company_id';
		$this->class_name = __CLASS__;

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $company_id);
	}

###################################################################################################

	public function getUsers($offset=null, $limit=null, $execute=true)
	{
		$user_list = new CMS_UserList($offset, $limit);
		$user_list->addCondition('company_id', $this->id);

		if($execute === true)
			$user_list->execute();

		return $user_list;
	}

	public function addUser(CMS_User $user)
	{
		$user->setCompanyId($this->id);
		$user->save();
	}

	public function removeUser(CMS_User $user)
	{
		$user->setCompanyId(null);
		$user->save();
	}

	public function purgeUsers()
	{
		$query = new CN_SqlQuery("UPDATE `users` SET `company_id` = NULL WHERE `company_id` = {$this->id}");
		$query->execute();
	}

###################################################################################################

	public function save()
	{
		if(is_null($this->id))
			$this->insertCompany();
		else
			$this->updateCompany();

		$this->updateLanguageVersions();
	}

	public function delete()
	{
		$query = new CN_SqlQuery("UPDATE `users` SET `company_id` = NULL WHERE `company_id` = {$this->id}");
		$query->execute();

		# main bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `{$this->lang_table}` WHERE `{$this->id_column_name}` = {$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `{$this->main_table}` WHERE `id` = {$this->id}");
		$query->execute();
	}

###################################################################################################
# private
###################################################################################################

	private function insertCompany()
	{
		$official_name = "''";
		$employee_count = 'NULL';
		$street = 'NULL';
		$city = 'NULL';
		$zip = 'NULL';
		$country = 'NULL';
		$phone = 'NULL';
		$fax = 'NULL';
		$cell = 'NULL';
		$email = 'NULL';
		$website = 'NULL';
		$ico = 'NULL';
		$dic = 'NULL';
		$icdph = 'NULL';
		$is_enabled = (int)true;

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['official_name']))
			$official_name = $this->new_data[$this->main_table]['official_name'] === 'NULL' ? $official_name : "'{$this->new_data[$this->main_table]['official_name']}'";
		if(isset($this->new_data[$this->main_table]['employee_count']))
			$employee_count = $this->new_data[$this->main_table]['employee_count'] === 'NULL' ? $employee_count : $this->new_data[$this->main_table]['employee_count'];
		if(isset($this->new_data[$this->main_table]['street']))
			$street = $this->new_data[$this->main_table]['street'] === 'NULL' ? $street : "'{$this->new_data[$this->main_table]['street']}'";
		if(isset($this->new_data[$this->main_table]['city']))
			$city = $this->new_data[$this->main_table]['city'] === 'NULL' ? $city : "'{$this->new_data[$this->main_table]['city']}'";
		if(isset($this->new_data[$this->main_table]['zip']))
			$zip = $this->new_data[$this->main_table]['zip'] === 'NULL' ? $zip : "'{$this->new_data[$this->main_table]['zip']}'";
		if(isset($this->new_data[$this->main_table]['country']))
			$country = $this->new_data[$this->main_table]['country'] === 'NULL' ? $country : "'{$this->new_data[$this->main_table]['country']}'";
		if(isset($this->new_data[$this->main_table]['phone']))
			$phone = $this->new_data[$this->main_table]['phone'] === 'NULL' ? $phone : "'{$this->new_data[$this->main_table]['phone']}'";
		if(isset($this->new_data[$this->main_table]['fax']))
			$fax = $this->new_data[$this->main_table]['fax'] === 'NULL' ? $fax : "'{$this->new_data[$this->main_table]['fax']}'";
		if(isset($this->new_data[$this->main_table]['cell']))
			$cell = $this->new_data[$this->main_table]['cell'] === 'NULL' ? $cell : "'{$this->new_data[$this->main_table]['cell']}'";
		if(isset($this->new_data[$this->main_table]['email']))
			$email = $this->new_data[$this->main_table]['email'] === 'NULL' ? $email : "'{$this->new_data[$this->main_table]['email']}'";
		if(isset($this->new_data[$this->main_table]['website']))
			$website = $this->new_data[$this->main_table]['website'] === 'NULL' ? $website : "'{$this->new_data[$this->main_table]['website']}'";
		if(isset($this->new_data[$this->main_table]['ico']))
			$ico = $this->new_data[$this->main_table]['ico'] === 'NULL' ? $ico : "'{$this->new_data[$this->main_table]['ico']}'";
		if(isset($this->new_data[$this->main_table]['dic']))
			$dic = $this->new_data[$this->main_table]['dic'] === 'NULL' ? $dic : "'{$this->new_data[$this->main_table]['dic']}'";
		if(isset($this->new_data[$this->main_table]['icdph']))
			$icdph = $this->new_data[$this->main_table]['icdph'] === 'NULL' ? $icdph : "'{$this->new_data[$this->main_table]['icdph']}'";
		if(isset($this->new_data[$this->main_table]['is_enabled']))
			$is_enabled = $this->new_data[$this->main_table]['is_enabled'] === 'NULL' ? $is_enabled : (int)$this->new_data[$this->main_table]['is_enabled'];

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`official_name`,
				`employee_count`,
				`street`,
				`city`,
				`zip`,
				`country`,
				`phone`,
				`fax`,
				`cell`,
				`email`,
				`website`,
				`ico`,
				`dic`,
				`icdph`,
				`is_enabled`
			)
		VALUES
			(
				NOW(),
				$official_name,
				$employee_count,
				$street,
				$city,
				$zip,
				$country,
				$phone,
				$fax,
				$cell,
				$email,
				$website,
				$ico,
				$dic,
				$icdph,
				$is_enabled
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateCompany()
	{
		$official_name = "''";
		$employee_count = 'NULL';
		$street = 'NULL';
		$city = 'NULL';
		$zip = 'NULL';
		$country = 'NULL';
		$phone = 'NULL';
		$fax = 'NULL';
		$cell = 'NULL';
		$email = 'NULL';
		$website = 'NULL';
		$ico = 'NULL';
		$dic = 'NULL';
		$icdph = 'NULL';
		$is_enabled = (int)true;

		###########################################################################################



		if(isset($this->new_data[$this->main_table]['official_name']))
			$official_name = $this->new_data[$this->main_table]['official_name'] === 'NULL' ? $official_name : "'{$this->new_data[$this->main_table]['official_name']}'";
		else
			$official_name = $this->current_data[$this->main_table]['official_name'] === 'NULL' ? $official_name : "'{$this->current_data[$this->main_table]['official_name']}'";

		if(isset($this->new_data[$this->main_table]['employee_count']))
			$employee_count = $this->new_data[$this->main_table]['employee_count'] === 'NULL' ? $employee_count : $this->new_data[$this->main_table]['employee_count'];
		else
			$employee_count = $this->current_data[$this->main_table]['employee_count'] === 'NULL' ? $employee_count : $this->current_data[$this->main_table]['employee_count'];

		if(isset($this->new_data[$this->main_table]['street']))
			$street = $this->new_data[$this->main_table]['street'] === 'NULL' ? $street : "'{$this->new_data[$this->main_table]['street']}'";
		else
			$street = $this->current_data[$this->main_table]['street'] === 'NULL' ? $street : "'{$this->current_data[$this->main_table]['street']}'";

		if(isset($this->new_data[$this->main_table]['city']))
			$city = $this->new_data[$this->main_table]['city'] === 'NULL' ? $city : "'{$this->new_data[$this->main_table]['city']}'";
		else
			$city = $this->current_data[$this->main_table]['city'] === 'NULL' ? $city : "'{$this->current_data[$this->main_table]['city']}'";

		if(isset($this->new_data[$this->main_table]['zip']))
			$zip = $this->new_data[$this->main_table]['zip'] === 'NULL' ? $zip : "'{$this->new_data[$this->main_table]['zip']}'";
		else
			$zip = $this->current_data[$this->main_table]['zip'] === 'NULL' ? $zip : "'{$this->current_data[$this->main_table]['zip']}'";

		if(isset($this->new_data[$this->main_table]['country']))
			$country = $this->new_data[$this->main_table]['country'] === 'NULL' ? $country : "'{$this->new_data[$this->main_table]['country']}'";
		else
			$country = $this->current_data[$this->main_table]['country'] === 'NULL' ? $country : "'{$this->current_data[$this->main_table]['country']}'";

		if(isset($this->new_data[$this->main_table]['phone']))
			$phone = $this->new_data[$this->main_table]['phone'] === 'NULL' ? $phone : "'{$this->new_data[$this->main_table]['phone']}'";
		else
			$phone = $this->current_data[$this->main_table]['phone'] === 'NULL' ? $phone : "'{$this->current_data[$this->main_table]['phone']}'";

		if(isset($this->new_data[$this->main_table]['fax']))
			$fax = $this->new_data[$this->main_table]['fax'] === 'NULL' ? $fax : "'{$this->new_data[$this->main_table]['fax']}'";
		else
			$fax = $this->current_data[$this->main_table]['fax'] === 'NULL' ? $fax : "'{$this->current_data[$this->main_table]['fax']}'";

		if(isset($this->new_data[$this->main_table]['cell']))
			$cell = $this->new_data[$this->main_table]['cell'] === 'NULL' ? $cell : "'{$this->new_data[$this->main_table]['cell']}'";
		else
			$cell = $this->current_data[$this->main_table]['cell'] === 'NULL' ? $cell : "'{$this->current_data[$this->main_table]['cell']}'";

		if(isset($this->new_data[$this->main_table]['email']))
			$email = $this->new_data[$this->main_table]['email'] === 'NULL' ? $email : "'{$this->new_data[$this->main_table]['email']}'";
		else
			$email = $this->current_data[$this->main_table]['email'] === 'NULL' ? $email : "'{$this->current_data[$this->main_table]['email']}'";

		if(isset($this->new_data[$this->main_table]['website']))
			$website = $this->new_data[$this->main_table]['website'] === 'NULL' ? $website : "'{$this->new_data[$this->main_table]['website']}'";
		else
			$website = $this->current_data[$this->main_table]['website'] === 'NULL' ? $website : "'{$this->current_data[$this->main_table]['website']}'";

		if(isset($this->new_data[$this->main_table]['ico']))
			$ico = $this->new_data[$this->main_table]['ico'] === 'NULL' ? $ico : "'{$this->new_data[$this->main_table]['ico']}'";
		else
			$ico = $this->current_data[$this->main_table]['ico'] === 'NULL' ? $ico : "'{$this->current_data[$this->main_table]['ico']}'";

		if(isset($this->new_data[$this->main_table]['dic']))
			$dic = $this->new_data[$this->main_table]['dic'] === 'NULL' ? $dic : "'{$this->new_data[$this->main_table]['dic']}'";
		else
			$dic = $this->current_data[$this->main_table]['dic'] === 'NULL' ? $dic : "'{$this->current_data[$this->main_table]['dic']}'";

		if(isset($this->new_data[$this->main_table]['icdph']))
			$icdph = $this->new_data[$this->main_table]['icdph'] === 'NULL' ? $icdph : "'{$this->new_data[$this->main_table]['icdph']}'";
		else
			$icdph = $this->current_data[$this->main_table]['icdph'] === 'NULL' ? $icdph : "'{$this->current_data[$this->main_table]['icdph']}'";

		if(isset($this->new_data[$this->main_table]['is_enabled']))
			$is_enabled = $this->new_data[$this->main_table]['is_enabled'] === 'NULL' ? (int)$is_enabled : (int)$this->new_data[$this->main_table]['is_enabled'];
		else
			$is_enabled = $this->current_data[$this->main_table]['is_enabled'] === 'NULL' ? (int)$is_enabled : (int)$this->current_data[$this->main_table]['is_enabled'];

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`official_name` = $official_name,
			`employee_count` = $employee_count,
			`street` = $street,
			`city` = $city,
			`zip` = $zip,
			`country` = $country,
			`phone` = $phone,
			`fax` = $fax,
			`cell` = $cell,
			`email` = $email,
			`website` = $website,
			`ico` = $ico,
			`dic` = $dic,
			`icdph` = $icdph,
			`is_enabled` = $is_enabled
		WHERE
			`id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateLanguageVersions()
	{
		$localized_name = 'NULL';
		$description = 'NULL';

		###########################################################################################

		foreach($this->new_data[$this->lang_table] as $language => $language_version)
		{
			if(isset($language_version['localized_name']))
				$localized_name = $language_version['localized_name'] == 'NULL' ? $localized_name : "'{$language_version['localized_name']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['localized_name']))
				$localized_name = $this->current_data[$this->lang_table][$language]['localized_name'] == 'NULL' ? $localized_name : "'{$this->current_data[$this->lang_table][$language]['localized_name']}'";

			if(isset($language_version['description']))
				$description = $language_version['description'] == 'NULL' ? $description : "'{$language_version['description']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['description']))
				$description = $this->current_data[$this->lang_table][$language]['description'] == 'NULL' ? $description : "'{$this->current_data[$this->lang_table][$language]['description']}'";

			#######################################################################################

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				`{$this->lang_table}`
			WHERE
				`{$this->id_column_name}` = {$this->id} AND
				`language` = '$language'
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();

			$record_count = $query->fetchValue();

			#######################################################################################

			if($record_count == 0)
			{
				$sql =<<<SQL
				INSERT INTO
					`{$this->lang_table}`
					(
						`{$this->id_column_name}`,
						`language`,
						`localized_name`,
						`description`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$localized_name,
						$description
					)
SQL;
			}
			elseif($record_count == 1)
			{
				$sql =<<<SQL
				UPDATE
					`{$this->lang_table}`
				SET
					`localized_name` = $localized_name,
					`description` = $description
				WHERE
					`{$this->id_column_name}` = {$this->id} AND
					`language` = '$language'
SQL;
			}
			else
				throw new CN_Exception(sprintf(tr("There are loose data in table `%1\$s` for `id` %2\$s.", $this->lang_table, $this->id)), E_ERROR);

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$localized_name = 'NULL';
			$description = 'NULL';
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}
}

endif;

?>