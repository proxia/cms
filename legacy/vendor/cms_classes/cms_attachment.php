<?php

if(!defined('CMS_ATACHEMENT_PHP')):
	define('CMS_ATACHEMENT_PHP', true);

class CMS_Attachment extends CMS_Entity
{
	const ENTITY_ID = 8;

###################################################################################################
# public
###################################################################################################

	public function __construct($attachment_id=null)
	{
		$this->main_table = 'attachments';
		$this->lang_table = 'attachments_lang';
		$this->id_column_name = 'attachment_id';

		parent::__construct(self::ENTITY_ID, $attachment_id);
	}

###################################################################################################

	public function save()
	{
		if(is_null($this->id))
			$this->insertAttachment();
		else
			$this->updateAttachment();

		$this->updateLanguageVersions();
	}

	public function delete()
	{
		# category bindings #######################################################################

		$query = new CN_SqlQuery("DELETE FROM `categories_bindings` WHERE `item_id` = {$this->id} AND `item_type` = ".CMS_Attachment::ENTITY_ID);
		$query->execute();

		# article bindings ########################################################################

		$query = new CN_SqlQuery("DELETE FROM `articles_attachments` WHERE `{$this->id_column_name}` = {$this->id}");
		$query->execute();

		# main bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `{$this->lang_table}` WHERE `{$this->id_column_name}` = {$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `{$this->main_table}` WHERE `id` = {$this->id}");
		$query->execute();
	}

###################################################################################################
# move in category ################################################################################

	/**
	 * Posunie kategoriu o jeden alebo viac stupnov hore.
	 *
	 * @param int $move_by - posunut o kolko stupnov hore v hierarchii
	 * @return int $new_position
	 */
	public function moveUpInCategory($move_by=1)
	{
		$sql =<<<SQL
		SELECT
			*
		FROM
			`categories_bindings`
		WHERE
			`item_id` = {$this->id} AND
			`item_type` = {$this->type}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->getSize() <= 0)
			return null;

		$category_id = $query->fetchValue('category_id');

		###########################################################################################

		return $this->moveUpInEntity($category_id, 'category_id', 'categories_bindings', $move_by);
	}

	/**
	 * Posunie kategoriu o jeden alebo viac stupnov dole.
	 *
	 * @param int $move_by - posunut o kolko stupnov dole v hierarchii
	 * @return int $new_position
	 */
	public function moveDownInCategory($move_by=1)
	{
		$sql =<<<SQL
		SELECT
			*
		FROM
			`categories_bindings`
		WHERE
			`item_id` = {$this->id} AND
			`item_type` = {$this->type}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->getSize() <= 0)
			return null;

		$category_id = $query->fetchValue('category_id');

		###########################################################################################

		return $this->moveDownInEntity($category_id, 'category_id', 'categories_bindings', $move_by);
	}

	/**
	 * Posunie kategoriu na vrch v hierarchii.
	 *
	 * @return int $new_position
	 */
	public function moveToTopInCategory($category_id)
	{
		$sql =<<<SQL
		SELECT
			*
		FROM
			`categories_bindings`
		WHERE
			`item_id` = {$this->id} AND
			`item_type` = {$this->type}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->getSize() <= 0)
			return null;

		$category_id = $query->fetchValue('category_id');

		###########################################################################################

		return $this->moveToTopInEntity($category_id, 'category_id', 'categories_bindings');
	}

	/**
	 * Posunie kategoriu na spodok v hierarchii.
	 *
	 * @return int $new_position
	 */
	public function moveToBottomInCategory($category_id)
	{
		$sql =<<<SQL
		SELECT
			*
		FROM
			`categories_bindings`
		WHERE
			`item_id` = {$this->id} AND
			`item_type` = {$this->type}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->getSize() <= 0)
			return null;

		$category_id = $query->fetchValue('category_id');

		###########################################################################################

		return $this->moveToBottomInEntity($category_id, 'category_id', 'categories_bindings');
	}

###################################################################################################
# private
###################################################################################################

	private function insertAttachment()
	{
		$file = "''";

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['file']))
			$file = $this->new_data[$this->main_table]['file'] === 'NULL' ? $file : "'{$this->new_data[$this->main_table]['file']}'";

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`attachments`
			(
				`creation`,
				`file`
			)
		VALUES
			(
				NOW(),
				$file
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateAttachment()
	{
		$file = "''";

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['file']))
			$file = $this->new_data[$this->main_table]['file'] === 'NULL' ? $file : "'{$this->new_data[$this->main_table]['file']}'";
		else
			$file = $this->current_data[$this->main_table]['file'] === 'NULL' ? $file : "'{$this->current_data[$this->main_table]['file']}'";

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`attachments`
		SET
			`file` = $file
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
		$title = "''";
		$description = 'NULL';
		$language_is_visible = 1;

		#######################################################################################

		foreach($this->new_data[$this->lang_table] as $language => $language_version)
		{
			if(isset($language_version['title']))
				$title = $language_version['title'] === 'NULL' ? $title : "'{$language_version['title']}'";
			elseif(isset($this->current_data['menus_lang'][$language]['title']))
				$title = $this->current_data['menus_lang'][$language]['title'] == 'NULL' ? $title : "'{$this->current_data['menus_lang'][$language]['title']}'";

			if(isset($language_version['description']))
				$description = $language_version['description'] === 'NULL' ? $description : "'{$language_version['description']}'";
			elseif(isset($this->current_data['menus_lang'][$language]['description']))
				$description = $this->current_data['menus_lang'][$language]['description'] === 'NULL' ? $description : "'{$this->current_data['menus_lang'][$language]['description']}'";

			if(isset($language_version['language_is_visible']))
				$language_is_visible = $language_version['language_is_visible'] === 'NULL' ? $language_is_visible : $language_version['language_is_visible'];
			elseif(isset($this->current_data['menus_lang'][$language]['language_is_visible']))
				$language_is_visible = $this->current_data['menus_lang'][$language]['language_is_visible'] == 'NULL' ? $language_is_visible : $this->current_data['menus_lang'][$language]['language_is_visible'];

			#######################################################################################

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				`attachments_lang`
			WHERE
				`attachment_id` = {$this->id} AND
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
					`attachments_lang`
					(
						`attachment_id`,
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
					`attachments_lang`
				SET
					`title` = $title,
					`description` = $description,
					`language_is_visible` = $language_is_visible
				WHERE
					`attachment_id` = {$this->id} AND
					`language` = '$language'
SQL;
			}
			else
				die('haluz');

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$title = "''";
			$description = 'NULL';
		}

		$this->readData(CMS::READ_LANG_DATA);
	}

###################################################################################################
# public static
###################################################################################################

	public static function deleteByFileName($file_name)
	{
		$query = new CN_SqlQuery("SELECT * FROM `attachments` WHERE `file` = '$file_name'");
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$attachment = new CMS_Attachment($record->getValue('id'));
			$attachment->delete();
		}
	}
}

endif;

?>