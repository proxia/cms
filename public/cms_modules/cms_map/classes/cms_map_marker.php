<?php

if(!defined('CMS_MAP_MARKER_PHP')):
	define('CMS_MAP_MARKER_PHP', true);

class CMS_Map_Marker extends CMS_Entity
{
	const ENTITY_ID = 225;
	
###################################################################################################
# public
###################################################################################################

	public function __construct($entity_id=null)
	{
		$this->main_table = 'map_markers';
		$this->lang_table = 'map_markers_lang';
		$this->id_column_name = 'marker_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $entity_id);
	}


###################################################################################################
# nodes #####################################################################################
   
	public function getNodes( $execute=true)
	{
		$nodes = new CMS_Map_NodeList();
		$nodes->setTableName('map_nodes_bindings');
		$nodes->setIdColumnName('node_id');
		$nodes->addCondition('entity_id', $this->id);
		$nodes->addCondition('entity_type', CMS_Map_Marker::ENTITY_ID);
		
		if($execute === true)
			$nodes->execute();
		
		return $nodes;
	}
	
###################################################################################################
# Attachments #####################################################################################	
	
	public function addAttachment(CMS_Attachment $attachment)
	{
		$order = NULL;

		###########################################################################################

		$sql = <<<SQL
		SELECT
			MAX(`order`)
		FROM
			`attachments_bindings`
		WHERE
		`entity_id` = {$this->id} AND 
		`entity_type` = {$this->type} 

SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$order = $query->fetchValue() + 1;

		###########################################################################################
		
		$sql =<<<SQL
		INSERT INTO
			`attachments_bindings`
			(
				`entity_id`,
				`entity_type`,
				`attachment_id`,
				`order`
			)
		VALUES
			(
				{$this->id},
				{$this->type},
				{$attachment->getId()},
				$order
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
public function getAttachments($offset=null, $limit=null, $execute=true)
	{
		
		$attachment_list = new CMS_AttachmentList($offset, $limit);
		$attachment_list->setTableName('attachments_bindings');
		$attachment_list->setIdColumnName('attachment_id');
		$attachment_list->addCondition('entity_id', $this->id);
		$attachment_list->addCondition('entity_type', $this->type);

		if($execute === true)
			$attachment_list->execute();

		return $attachment_list;
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
		# area bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `map_area_bindings` WHERE `entity_id` = {$this->id} AND `entity_type` = {$this->type}");
		$query->execute();
		
		# main bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `{$this->lang_table}` WHERE `{$this->id_column_name}` = {$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `{$this->main_table}` WHERE `id` = {$this->id}");
		$query->execute();
	
		# attachments bindings ###########################################################################
		$query = new CN_SqlQuery("DELETE FROM	`attachments_bindings` WHERE `entity_id` = {$this->id} AND `entity_type` = {$this->type} ");
		$query->execute();
	}

###################################################################################################
# private
###################################################################################################

	private function insertEntity()
	{
		$is_published = (int)true;
		$author_id = 0;
				
		###########################################################################################
		
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : (int)$this->new_data[$this->main_table]['is_published'];
			
		if(isset($this->new_data[$this->main_table]['author_id']))
			$author_id = $this->new_data[$this->main_table]['author_id'] === 'NULL' ? $author_id : "'{$this->new_data[$this->main_table]['author_id']}'";
			
		###########################################################################################
		
		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`is_published`,
				`author_id`
			)
		VALUES
			(
				NOW(),
				$is_published,
				$author_id
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}
	
	private function updateEntity()
	{
		$is_published = (int)true;
		$author_id = 0;
		
		###########################################################################################
		
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : $this->new_data[$this->main_table]['is_published'];
		else
			$is_published = $this->current_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : $this->current_data[$this->main_table]['is_published'];
			
		if(isset($this->new_data[$this->main_table]['author_id']))
			$author_id = $this->new_data[$this->main_table]['author_id'] === 'NULL' ? $author_id : "'{$this->new_data[$this->main_table]['author_id']}'";
		else
			$author_id = $this->current_data[$this->main_table]['author_id'] === 'NULL' ? $author_id : "'{$this->current_data[$this->main_table]['author_id']}'";
			
		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`is_published` = $is_published,
			`author_id` = $author_id
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
		$language_is_visible = (int)true;

		foreach($this->new_data[$this->lang_table] as $language => $language_version)
		{
			if(isset($language_version['title']))
				$title = $language_version['title'] === 'NULL' ? $title : "'{$language_version['title']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['title']))
				$title = $this->current_data[$this->lang_table][$language]['title'] == 'NULL' ? $title : "'{$this->current_data[$this->lang_table][$language]['title']}'";

			if(isset($language_version['description']))
				$description = $language_version['description'] === 'NULL' ? 'NULL' : "'{$language_version['description']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['description']))
				$description = $this->current_data[$this->lang_table][$language]['description'] === 'NULL' ? $description : "'{$this->current_data[$this->lang_table][$language]['description']}'";

			if(isset($language_version['language_is_visible']))
				$language_is_visible = $language_version['language_is_visible'] === 'NULL' ? $language_is_visible : $language_version['language_is_visible'];
			elseif(isset($this->current_data[$this->lang_table][$language]['language_is_visible']))
				$language_is_visible = $this->current_data[$this->lang_table][$language]['language_is_visible'] === 'NULL' ? $language_is_visible : $this->current_data[$this->lang_table][$language]['language_is_visible'];

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
					`{$this->lang_table}`
				SET
					`title` = $title,
					`description` = $description,
					`language_is_visible` = $language_is_visible
				WHERE
					`{$this->id_column_name}` = {$this->id} AND
					`language` = '$language'
SQL;
			}
			else
				throw new CN_Exception(sprintf(tr("There are loose data in table `%1\$s` for `id` %2\$s."), $this->lang_table, $this->id), E_ERROR);

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$title = "''";
			$description = 'NULL';
			$language_is_visible = (int)true;
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}
}

endif;

?>
