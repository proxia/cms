<?php

if(!defined('CMS_GROUP_PHP')):
	define('CMS_GROUP_PHP', true);

class CMS_Group extends CMS_Entity
{
	const ENTITY_ID = 7;

###################################################################################################
# public
###################################################################################################

	public function __construct($group_id=NULL)
	{
		parent::__construct(self::ENTITY_ID, $group_id);
	}

###################################################################################################

	public function addUser(CMS_User $user)
	{
		$sql =<<<SQL
		INSERT INTO
			`users_bindings`
			(
				`group_id`,
				`user_id`
			)
		VALUES
			(
				{$this->id},
				{$user->getId()}
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeUser(CMS_User $user)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`users_bindings`
		WHERE
			`group_id` = {$this->id} AND
			`user_id` = {$user->getId()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################

	public function getUsers()
	{
		$vector = new CN_Vector();

		###########################################################################################

		$sql =<<<SQL
		SELECT
			`user_id`
		FROM
			`users_bindings`
		WHERE
			`group_id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append(new CMS_User($record->getValue('user_id')));
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
# privileges ######################################################################################

	public function grantPrivileges($logic_entity_id, $privileges) { CMS_Privileges::getSingleton()->grantPrivileges($this, $logic_entity_id, $privileges); }
	public function revokePrivileges($logic_entity_id) { CMS_Privileges::getSingleton()->revokePrivileges($this, $logic_entity_id); }
	public function revokeAllPrivileges() { CMS_Privileges::getSingleton()->revokeAllPrivileges($this); }
	public function getPrivileges() { return CMS_Privileges::getSingleton()->getPrivileges($this); }
	public function checkPrivilege($logic_entity_id, $privilege) { return CMS_Privileges::getSingleton()->checkPrivilege($this, $logic_entity_id, $privilege); }

###################################################################################################

	public function save()
	{
		if(is_null($this->id))
			$this->insertGroup();
		else
			$this->updateGroup();
			
		$this->alterLanguageVersions();
				
	}

	public function delete()
	{
		$query = new CN_SqlQuery("DELETE FROM `users_bindings` WHERE group_id={$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM groups WHERE id={$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM groups_lang WHERE group_id={$this->id}");
		$query->execute();
		
		$this->current_data = array();
		$this->new_data = array();
	}

###################################################################################################
# private
###################################################################################################

	private function insertGroup()
	{
		$name = '';
		$is_enabled = 1;

		###########################################################################################

		if(isset($this->new_data['groups']['name']))
			$name = $this->new_data['groups']['name'] == 'NULL' ? '' : "'{$this->new_data['groups']['name']}'";
		if(isset($this->new_data['groups']['is_published']))
			$is_enabled = $this->new_data['groups']['is_published'] == 'NULL' ? 1 : (int)$this->new_data['groups']['is_published'];

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			groups
			(
				creation,
				name,
				is_published
			)
		VALUES
			(
				NOW(),
				$name,
				$is_enabled
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData();
	}

	private function updateGroup()
	{
		$name = $is_enabled = null;

		###########################################################################################

		if(isset($this->new_data['groups']['name']))
			$name = $this->new_data['groups']['name'] == 'NULL' ? 'NULL' : "'{$this->new_data['groups']['name']}'";
		else
			$name = $this->current_data['groups']['name'] == 'NULL' ? 'NULL' : "'{$this->current_data['groups']['name']}'";

		if(isset($this->new_data['groups']['is_published']))
			$is_published = $this->new_data['groups']['is_published'] == 'NULL' ? 1 : (int)$this->new_data['groups']['is_published'];
		else
			$is_published = $this->current_data['groups']['is_published'] == 'NULL' ? 1 : (int)$this->current_data['groups']['is_published'];

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			groups
		SET
			name=$name,
			is_published=$is_published
		WHERE
			id={$this->id}
SQL;

		$query = new Cn_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		$this->readData();
	}
	
	

	private function alterLanguageVersions()
	{
		$title = $description = $text  = $language_is_visible = null;

		foreach($this->new_data['groups_lang'] as $language => $language_version)
		{
			if(isset($language_version['title']))
				$title = $language_version['title'] === 'NULL' ? "''" : "'{$language_version['title']}'";
			elseif(isset($this->current_data['groups_lang'][$language]['title']))
				$title = $this->current_data['groups_lang'][$language]['title'] == 'NULL' ? "''" : "'{$this->current_data['groups_lang'][$language]['title']}'";
			else
				$title = "''";

			if(isset($language_version['description']))
				$description = $language_version['description'] === 'NULL' ? 'NULL' : "'{$language_version['description']}'";
			elseif(isset($this->current_data['groups_lang'][$language]['description']))
				$description = $this->current_data['groups_lang'][$language]['description'] === 'NULL' ? 'NULL' : "'{$this->current_data['groups_lang'][$language]['description']}'";
			else
				$description = 'NULL';

			if(isset($language_version['language_is_visible']))
				$language_is_visible = $language_version['language_is_visible'] === 'NULL' ? 0 : $language_version['language_is_visible'];
			elseif(isset($this->current_data['groups_lang'][$language]['language_is_visible']))
				$language_is_visible = $this->current_data['groups_lang'][$language]['language_is_visible'] === 'NULL' ? 0 : $this->current_data['groups_lang'][$language]['language_is_visible'];
			else
				$language_is_visible = 0;

			#######################################################################################

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				groups_lang
			WHERE
				group_id = {$this->id} AND
				language = '$language'
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();

			$record_count = $query->fetchValue();

			#######################################################################################

			if($record_count == 0)
			{
				$sql =<<<SQL
				INSERT INTO
					`groups_lang`
					(
						`group_id`,
						`language`,
						`title`,
						`description`,
						`language_is_visible`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$title,
						$description,
						$language_is_visible
					)
SQL;
			}
			elseif($record_count == 1)
			{
				$sql =<<<SQL
				UPDATE
					`groups_lang`
				SET
					`title` = $title,
					`description` = $description,
					`language_is_visible` = $language_is_visible
				WHERE
					`group_id`={$this->id} AND
					`language`='$language'
SQL;
			}
			else
				die('haluz'); // throw

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$title = $description = $text = $language_is_visible = null;
		}

		$this->readData(CMS::READ_LANG_DATA);
	}	
	
	
}

endif;

?>
