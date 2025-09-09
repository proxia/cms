<?php

if(!defined('CMS_ADMIN_USER_PHP')):
	define('CMS_ADMIN_USER_PHP', true);

class CMS_AdminUser extends CMS_Entity
{
	const ENTITY_ID = 9;

###################################################################################################
# public
###################################################################################################

	public function __construct($admin_user_id=null)
	{
		$this->main_table = 'admin_users';
		$this->id_column_name = 'admin_user_id';

		parent::__construct(self::ENTITY_ID, $admin_user_id);
	}

###################################################################################################

	public function addForkData($dsn, $site_name)
	{
		$sql =<<<SQL
		INSERT INTO
			`admin_user_fork_data`
			(
				`{$this->id_column_name}`,
				`dsn`,
				`site_name`
			)
		VALUES
			(
				{$this->id},
				'$dsn',
				'$site_name'
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeForkData($dsn)
	{
		$sql =<<<SQL
		DELETE FROM
			`admin_users_fork_data`
		WHERE
			`{$this->id_column_name}` = {$this->id} AND
			`dsn` = '$dsn';
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function getForkData($order = 'name')
	{
		$vector = new CN_Vector();

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`admin_users_fork_data`
		WHERE
			`{$this->id_column_name}` = {$this->id}
		ORDER BY `$order`
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$fork_data['dsn'] = $record->getValue('dsn');
			$fork_data['name'] = $record->getValue('name');
			$fork_data['site_name'] = $record->getValue('site_name');

			$vector->append($fork_data);
		}

		###########################################################################################

		return $vector;
	}

###################################################################################################
# custom config ###################################################################################

	public function setConfigValue($key, $value) { CMS_CustomConfig::getSingleton()->setValue($this, $key, $value); }
	public function getConfigValue($key) { return CMS_CustomConfig::getSingleton()->getValue($this, $key); }
	public function getAllConfig() { return CMS_CustomConfig::getSingleton()->getAll($this); }

###################################################################################################

	public function save()
	{
		if(is_null($this->id))
			$this->insertAdminUser();
		else
			$this->updateAdminUser();
	}

	public function delete()
	{
		# fork bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `admin_users_fork_data` WHERE `{$this->id_column_name}` = {$this->id}");
		$query->execute();

		# main bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `admin_users` WHERE `id` = {$this->id}");
		$query->execute();
	}

###################################################################################################
# private
###################################################################################################

	private function insertAdminUser()
	{
		$last_login = 'NULL';
		$login = "''";
		$password = "''";
		$firstname = "''";
		$familyname = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['last_login']))
			$last_login = $this->new_data[$this->main_table]['last_login'] === 'NULL' ? $last_login : "'{$this->new_data[$this->main_table]['last_login']}'";
		if(isset($this->new_data[$this->main_table]['login']))
			$login = $this->new_data[$this->main_table]['login'] === 'NULL' ? $login : "'{$this->new_data[$this->main_table]['login']}'";
		if(isset($this->new_data[$this->main_table]['password']))
			$password = $this->new_data[$this->main_table]['password'] === 'NULL' ? $password : "'{$this->new_data[$this->main_table]['password']}'";
		if(isset($this->new_data[$this->main_table]['firstname']))
			$firstname = $this->new_data[$this->main_table]['firstname'] === 'NULL' ? $firstname : "'{$this->new_data[$this->main_table]['firstname']}'";
		if(isset($this->new_data[$this->main_table]['familyname']))
			$familyname = $this->new_data[$this->main_table]['familyname'] === 'NULL' ? $familyname : "'{$this->new_data[$this->main_table]['familyname']}'";

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`admin_users`
			(
				`creation`,
				`last_login`,
				`login`,
				`password`,
				`firstname`,
				`familyname`
			)
		VALUES
			(
				NOW(),
				$last_login,
				$login,
				$password,
				$firstname,
				$familyname
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateAdminUser()
	{
		$last_login = 'NULL';
		$login = "''";
		$password = "''";
		$firstname = "''";
		$familyname = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['last_login']))
			$last_login = $this->new_data[$this->main_table]['last_login'] === 'NULL' ? $last_login : "'{$this->new_data[$this->main_table]['last_login']}'";
		else
			$last_login = $this->current_data[$this->main_table]['last_login'] === 'NULL' ? $last_login : "'{$this->current_data[$this->main_table]['last_login']}'";

		if(isset($this->new_data[$this->main_table]['login']))
			$login = $this->new_data[$this->main_table]['login'] === 'NULL' ? $login : "'{$this->new_data[$this->main_table]['login']}'";
		else
			$login = $this->current_data[$this->main_table]['login'] === 'NULL' ? $login : "'{$this->current_data[$this->main_table]['login']}'";

		if(isset($this->new_data[$this->main_table]['password']))
			$password = $this->new_data[$this->main_table]['password'] === 'NULL' ? $password : "'{$this->new_data[$this->main_table]['password']}'";
		else
			$password = $this->current_data[$this->main_table]['password'] === 'NULL' ? $password : "'{$this->current_data[$this->main_table]['password']}'";

		if(isset($this->new_data[$this->main_table]['firstname']))
			$firstname = $this->new_data[$this->main_table]['firstname'] === 'NULL' ? $firstname : "'{$this->new_data[$this->main_table]['firstname']}'";
		else
			$firstname = $this->current_data[$this->main_table]['firstname'] === 'NULL' ? $firstname : "'{$this->current_data[$this->main_table]['firstname']}'";

		if(isset($this->new_data[$this->main_table]['familyname']))
			$familyname = $this->new_data[$this->main_table]['familyname'] === 'NULL' ? $familyname : "'{$this->new_data[$this->main_table]['familyname']}'";
		else
			$familyname = $this->current_data[$this->main_table]['familyname'] === 'NULL' ? $familyname : "'{$this->current_data[$this->main_table]['familyname']}'";

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`admin_users`
		SET
			`last_login` = $last_login,
			`login` = $login,
			`password` = $password,
			`firstname` = $firstname,
			`familyname` = $familyname
		WHERE
			`id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}
}

endif;

?>