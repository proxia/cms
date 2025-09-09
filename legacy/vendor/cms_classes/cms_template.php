<?php

if(!defined('CMS_TEMPLATE_PHP')):
	define('CMS_TEMPLATE_PHP', true);

class CMS_Template extends CMS_Entity
{
	const ENTITY_ID = 10;

###################################################################################################
# public
###################################################################################################

	public function __construct($entity_id=null)
	{
		$this->main_table = 'templates';
		$this->lang_table = 'templates_lang';
		$this->id_column_name = 'template_id';
	
		###########################################################################################
	
		parent::__construct(self::ENTITY_ID, $entity_id);
	}

###################################################################################################
# conditions checking #############################################################################

	public function checkConditions()
	{
		$USER_ID = null;
		$GROUPS = null;
		
		if(CMS_UserLogin::getSingleton()->isUserLogedIn())
		{
			$user = CMS_UserLogin::getSingleton()->getUser();
			
			$USER_ID = $user->getId();
			$GROUPS = $user->getGroups();
		}
		
		###########################################################################################
		
		if(strlen($this->getConditions()) > 0)
		{
			$result = null;
			$conditions = "\$result = ({$this->getConditions()});";	
			
			eval($conditions);
			
			return $result;
		}
		else
			return true;
	}

###################################################################################################
# save and delete #################################################################################

	public function save()
	{
		if(is_null($this->id))
			$this->insertEntity();
		else
			$this->updateEntity();
			
		$this->updateLanguageVersions();
	}

	public function delete()
	{
		# main bindings ###########################################################################
		
		$query = new CN_SqlQuery("DELETE FROM `templates_bindings` WHERE `{$this->id_column_name}` = {$this->id}");
		$query->execute();
		
		$query = new CN_SqlQuery("DELETE FROM `{$this->lang_table}` WHERE `{$this->id_column_name}` = {$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `{$this->main_table}` WHERE `id` = {$this->id}");
		$query->execute();
	}

###################################################################################################
# private
###################################################################################################

	private function insertEntity()
	{
		$template = "''";
		$conditions = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['template']))
			$template = $this->new_data[$this->main_table]['template'] == 'NULL' ? $template : "'{$this->new_data[$this->main_table]['template']}'";
			
		if(isset($this->new_data[$this->main_table]['conditions']))
			$conditions = $this->new_data[$this->main_table]['conditions'] == 'NULL' ? $conditions : $this->new_data[$this->main_table]['conditions'];

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`template`,
				`conditions`
			)
		VALUES
			(
				NOW(),
				$template,
				$conditions
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData();
	}

	private function updateEntity()
	{
		$template = "''";
		$conditions = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['template']))
			$template = $this->new_data[$this->main_table]['template'] == 'NULL' ? $template : "'{$this->new_data[$this->main_table]['template']}'";
		else
			$template = $this->current_data[$this->main_table]['template'] == 'NULL' ? $template : "'{$this->current_data[$this->main_table]['template']}'";

		if(isset($this->new_data[$this->main_table]['conditions']))
			$conditions = $this->new_data[$this->main_table]['conditions'] == 'NULL' ? $conditions : $this->new_data[$this->main_table]['conditions'];
		else
			$conditions = $this->current_data[$this->main_table]['conditions'] == 'NULL' ? $conditions : $this->current_data[$this->main_table]['conditions'];

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`template` = $template,
			`conditions` = $conditions
		WHERE
			`id` = {$this->id}
SQL;

		$query = new Cn_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		$this->readData();
	}
	
	private function updateLanguageVersions()
	{
		$title = "''"; 
		$description = 'NULL';

		foreach($this->new_data[$this->lang_table] as $language => $language_version)
		{
			if(isset($language_version['title']))
				$title = $language_version['title'] === 'NULL' ? $title : "'{$language_version['title']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['title']))
				$title = $this->current_data[$this->lang_table][$language]['title'] == 'NULL' ? $title : "'{$this->current_data[$this->lang_table][$language]['title']}'";
			
			if(isset($language_version['description']))
				$description = $language_version['description'] === 'NULL' ? $description : "'{$language_version['description']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['description']))
				$description = $this->current_data[$this->lang_table][$language]['description'] === 'NULL' ? $description : "'{$this->current_data[$this->lang_table][$language]['description']}'";
			
			#######################################################################################

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				`{$this->lang_table}`
			WHERE
				`$this->id_column_name` = {$this->id} AND
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
						`title`,
						`description`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$title,
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
					`title` = $title,
					`description` = $description
				WHERE
					`{$this->id_column_name}` = {$this->id} AND
					`language` = '$language'
SQL;
			}
			else
				die('haluz'); // throw

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$title = "''";
			$description = 'NULL';
		}

		$this->readData(CMS::READ_LANG_DATA);
	}
}

endif;

?>