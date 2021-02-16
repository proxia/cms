<?php

if(!defined('CMS_MAP_CONNECTION_PHP')):
	define('CMS_MAP_CONNECTION_PHP', true);

class CMS_Map_Connection extends CMS_Entity
{
	const ENTITY_ID = 224;
	
###################################################################################################
# public
###################################################################################################

	public function __construct($entity_id=null)
	{
		$this->main_table = 'map_connections';
		$this->lang_table = 'map_connections_lang';
		$this->id_column_name = 'connection_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $entity_id);
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
		$is_published = (int)true;
		$route_id = 0;
		$node_1 = 0;
		$node_2 = 0;
		$connection_type = "''";
		$distance = 'NULL';
		
		###########################################################################################
		
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : (int)$this->new_data[$this->main_table]['is_published'];
			
		if(isset($this->new_data[$this->main_table]['route_id']))
			$route_id = $this->new_data[$this->main_table]['route_id'] === 'NULL' ? $route_id : $this->new_data[$this->main_table]['route_id'];
			
		if(isset($this->new_data[$this->main_table]['node_1']))
			$node_1 = $this->new_data[$this->main_table]['node_1'] === 'NULL' ? $node_1 : $this->new_data[$this->main_table]['node_1'];
			
		if(isset($this->new_data[$this->main_table]['node_2']))
			$node_2 = $this->new_data[$this->main_table]['node_2'] === 'NULL' ? $node_2 : $this->new_data[$this->main_table]['node_2'];
			
		if(isset($this->new_data[$this->main_table]['connection_type']))
			$connection_type = $this->new_data[$this->main_table]['connection_type'] === 'NULL' ? $connection_type : "'{$this->new_data[$this->main_table]['connection_type']}'";
			
		if(isset($this->new_data[$this->main_table]['distance']))
			$distance = $this->new_data[$this->main_table]['distance'] === 'NULL' ? $distance : "'{$this->new_data[$this->main_table]['distance']}'";
			
		###########################################################################################
		
		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`is_published`,
				`route_id`,
				`node_1`,
				`node_2`,
				`connection_type`,
				`distance`
			)
		VALUES
			(
				NOW(),
				$is_published,
				$route_id,
				$node_1,
				$node_2,
				$connection_type,
				$distance
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
		$route_id = 0;
		$node_1 = 0;
		$node_2 = 0;
		$connection_type = "''";
		$distance = 'NULL';
		
		###########################################################################################
		
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : $this->new_data[$this->main_table]['is_published'];
		else
			$is_published = $this->current_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : $this->current_data[$this->main_table]['is_published'];
			
		if(isset($this->new_data[$this->main_table]['route_id']))
			$route_id = $this->new_data[$this->main_table]['route_id'] === 'NULL' ? $route_id : $this->new_data[$this->main_table]['route_id'];
		else
			$route_id = $this->current_data[$this->main_table]['route_id'] === 'NULL' ? $route_id : $this->current_data[$this->main_table]['route_id'];
			
		if(isset($this->new_data[$this->main_table]['node_1']))
			$node_1 = $this->new_data[$this->main_table]['node_1'] === 'NULL' ? $node_1 : $this->new_data[$this->main_table]['node_1'];
		else
			$node_1 = $this->current_data[$this->main_table]['node_1'] === 'NULL' ? $node_1 : $this->current_data[$this->main_table]['node_1'];
			
		if(isset($this->new_data[$this->main_table]['node_2']))
			$node_2 = $this->new_data[$this->main_table]['node_2'] === 'NULL' ? $node_2 : $this->new_data[$this->main_table]['node_2'];
		else
			$node_2 = $this->current_data[$this->main_table]['node_2'] === 'NULL' ? $node_2 : $this->current_data[$this->main_table]['node_2'];
			
		if(isset($this->new_data[$this->main_table]['connection_type']))
			$connection_type = $this->new_data[$this->main_table]['connection_type'] === 'NULL' ? $connection_type : "'{$this->new_data[$this->main_table]['connection_type']}'";
		else
			$connection_type = $this->current_data[$this->main_table]['connection_type'] === 'NULL' ? $connection_type : "'{$this->current_data[$this->main_table]['connection_type']}'";
			
		if(isset($this->new_data[$this->main_table]['distance']))
			$distance = $this->new_data[$this->main_table]['distance'] === 'NULL' ? $distance : "'{$this->new_data[$this->main_table]['distance']}'";
		else
			$distance = $this->current_data[$this->main_table]['distance'] === 'NULL' ? $distance : "'{$this->current_data[$this->main_table]['distance']}'";
			
		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`is_published` = $is_published,
			`route_id` = $route_id,
			`node_1` = $node_1,
			`node_2` = $node_2,
			`connection_type` = $connection_type,
			`distance` = $distance
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
