<?php

if(!defined('CMS_MAP_NODE_PHP')):
	define('CMS_MAP_NODE_PHP', true);

class CMS_Map_Node extends CMS_Entity
{
	const ENTITY_ID = 223;
	
###################################################################################################
# public
###################################################################################################

	public function __construct($entity_id=null)
	{
		$this->main_table = 'map_nodes';
		$this->lang_table = 'map_nodes_lang';
		$this->id_column_name = 'node_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $entity_id);
	}
	
###################################################################################################
# connections #####################################################################################

	public function getConnections($route_id=null, $offset=null, $limit=null, $execute=true)
	{
		$connection_list = new CMS_Map_ConnectionList($offset, $limit);
		$connection_list->addCondition("(`node_1`={$this->id} OR `node_2`={$this->id})", null, null, true);
		
		if($route_id !== null)
			$connection_list->addCondition('route_id', $route_id);
					
		if($execute === true)
			$connection_list->execute();
			
		return $connection_list;
	}


###################################################################################################
# next connection #####################################################################################

	public function getPrevConnection($route_id=null, $offset=null, $limit=null, $execute=true)
	{
		$connection_list = new CMS_Map_ConnectionList($offset, $limit);
		$connection_list->addCondition("(`node_2`={$this->id})", null, null, true);
		
		if($route_id !== null)
			$connection_list->addCondition('route_id', $route_id);
					
		if($execute === true)
			$connection_list->execute();
			
		return $connection_list;
	}
	
		
###################################################################################################
# markers #########################################################################################

	public function getMarkers($offset=null, $limit=null, $execute=true)
	{
		$markers = new CMS_ArticleList($offset, $limit);
		$markers->setTableName('map_nodes_bindings');
		$markers->setIdColumnName('entity_id');
		$markers->addCondition('node_id', $this->id);
		$markers->addCondition('entity_type', CMS_Map_Marker::ENTITY_ID);
		
		if($execute === true)
			$markers->execute();
		
		return $markers;
	}
	
	public function addMarker(CMS_Map_Marker $marker)
	{
		$sql =<<<SQL
		INSERT INTO
			`map_nodes_bindings`
			(
				`node_id`,
				`entity_id`,
				`entity_type`
			)
		VALUES
			(
				{$this->id},
				{$marker->getId()},
				{$marker->getType()}
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
	public function removeMarker(CMS_Map_Marker $marker)
	{
		$sql =<<<SQL
		DELETE 
		FROM
			`map_nodes_bindings`
		WHERE
			`node_id` = {$this->id} AND
			`entity_id` = {$marker->getId()} AND
			`entity_type` = {$marker->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
###################################################################################################
# articles ########################################################################################

	public function getArticles($offset=null, $limit=null, $execute=true)
	{
		$article_list = new CMS_ArticleList($offset, $limit);
		$article_list->setTableName('map_nodes_bindings');
		$article_list->setIdColumnName('entity_id');
		$article_list->addCondition('node_id', $this->id);
		$article_list->addCondition('entity_type', CMS_Article::ENTITY_ID);
		
		if($execute === true)
			$article_list->execute();
		
		return $article_list;
	}
	
	public function addArticle(CMS_Article $article)
	{
		$sql =<<<SQL
		INSERT INTO
			`map_nodes_bindings`
			(
				`node_id`,
				`entity_id`,
				`entity_type`
			)
		VALUES
			(
				{$this->id},
				{$article->getId()},
				{$article->getType()}
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
	public function removeArticle(CMS_Article $article)
	{
		$sql =<<<SQL
		DELETE 
		FROM
			`map_nodes_bindings`
		WHERE
			`node_id` = {$this->id} AND
			`entity_id` = {$article->getId()} AND
			`entity_type` = {$article->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
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
		# connection bindings #####################################################################
		
		$connection_list = $this->getConnections();
		
		foreach($connection_list as $conection)
			$connection->delete();

		# area bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `map_area_bindings` WHERE `entity_id` = {$this->id} AND `entity_type` = {$this->type}");
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

	private function insertEntity()
	{
		$is_published = (int)true;
		$coordinate_x = "''";
		$coordinate_y = "''"; 
		$altitude = 0;
		$node_type = "''";
		
		###########################################################################################
		
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : (int)$this->new_data[$this->main_table]['is_published'];
			
		if(isset($this->new_data[$this->main_table]['coordinate_x']))
			$coordinate_x = $this->new_data[$this->main_table]['coordinate_x'] === 'NULL' ? $coordinate_x : "'{$this->new_data[$this->main_table]['coordinate_x']}'";
			
		if(isset($this->new_data[$this->main_table]['coordinate_y']))
			$coordinate_y = $this->new_data[$this->main_table]['coordinate_y'] === 'NULL' ? $coordinate_y : "'{$this->new_data[$this->main_table]['coordinate_y']}'";
			
		if(isset($this->new_data[$this->main_table]['altitude']))
			$altitude = $this->new_data[$this->main_table]['altitude'] === 'NULL' ? $altitude : $this->new_data[$this->main_table]['altitude'];
			
		if(isset($this->new_data[$this->main_table]['node_type']))
			$node_type = $this->new_data[$this->main_table]['node_type'] === 'NULL' ? $node_type : "'{$this->new_data[$this->main_table]['node_type']}'";
			
		###########################################################################################
		
		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`is_published`,
				`coordinate_x`,
				`coordinate_y`,
				`altitude`,
				`node_type`
			)
		VALUES
			(
				NOW(),
				$is_published,
				$coordinate_x,
				$coordinate_y,
				$altitude,
				$node_type
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
		$coordinate_x = "''";
		$coordinate_y = "''"; 
		$altitude = 'NULL';
		$node_type = "''";
		
		###########################################################################################
		
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : $this->new_data[$this->main_table]['is_published'];
		else
			$is_published = $this->current_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : $this->current_data[$this->main_table]['is_published'];
			
		if(isset($this->new_data[$this->main_table]['coordinate_x']))
			$coordinate_x = $this->new_data[$this->main_table]['coordinate_x'] === 'NULL' ? $coordinate_x : "'{$this->new_data[$this->main_table]['coordinate_x']}'";
		else
			$coordinate_x = $this->current_data[$this->main_table]['coordinate_x'] === 'NULL' ? $coordinate_x : "'{$this->current_data[$this->main_table]['coordinate_x']}'";
			
		if(isset($this->new_data[$this->main_table]['coordinate_y']))
			$coordinate_y = $this->new_data[$this->main_table]['coordinate_y'] === 'NULL' ? $coordinate_y : "'{$this->new_data[$this->main_table]['coordinate_y']}'";
		else
			$coordinate_y = $this->current_data[$this->main_table]['coordinate_y'] === 'NULL' ? $coordinate_y : "'{$this->current_data[$this->main_table]['coordinate_y']}'";
			
		if(isset($this->new_data[$this->main_table]['altitude']))
			$altitude = $this->new_data[$this->main_table]['altitude'] === 'NULL' ? $altitude : $this->new_data[$this->main_table]['altitude'];
		else
			$altitude = $this->current_data[$this->main_table]['altitude'] === 'NULL' ? $altitude : $this->current_data[$this->main_table]['altitude'];
			
		if(isset($this->new_data[$this->main_table]['node_type']))
			$node_type = $this->new_data[$this->main_table]['node_type'] === 'NULL' ? $node_type : "'{$this->new_data[$this->main_table]['node_type']}'";
		else
			$node_type = $this->current_data[$this->main_table]['node_type'] === 'NULL' ? $node_type : "'{$this->current_data[$this->main_table]['node_type']}'";
			
		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`is_published` = $is_published,
			`coordinate_x` = $coordinate_x,
			`coordinate_y` = $coordinate_y,
			`altitude` = $altitude,
			`node_type` = $node_type
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
