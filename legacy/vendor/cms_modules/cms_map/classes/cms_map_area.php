<?php

if(!defined('CMS_MAP_AREA_PHP')):
	define('CMS_MAP_AREA_PHP', true);

class CMS_Map_Area extends CMS_Entity
{
	const ENTITY_ID = 220;
	
###################################################################################################
# public
###################################################################################################

	public function __construct($entity_id=null)
	{
		$this->main_table = 'map_areas';
		$this->lang_table = 'map_areas_lang';
		$this->id_column_name = 'area_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $entity_id);
	}
	
###################################################################################################
# routes ##########################################################################################

	public function getRoutes($offset=null, $limit=null, $execute=true)
	{
		$route_list = new CMS_Map_RouteList($offset, $limit);
		$route_list->setTableName('map_area_bindings');
		$route_list->setIdColumnName('entity_id');
		$route_list->addCondition('area_id', $this->id);
		$route_list->addCondition('entity_type', CMS_Map_Route::ENTITY_ID);
		
		if($execute === true)
			$route_list->execute();
		
		return $route_list;
	}
	
	public function addRoute(CMS_Map_Route $route)
	{
		$sql =<<<SQL
		INSERT INTO
			`map_area_bindings`
			(
				`area_id`,
				`entity_id`,
				`entity_type`
			)
		VALUES
			(
				{$this->id},
				{$route->getId()},
				{$route->getType()}
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
	public function removeRoute(CMS_Map_Route $route)
	{
		$sql =<<<SQL
		DELETE 
		FROM
			`map_area_bindings`
		WHERE
			`area_id` = {$this->id} AND
			`entity_id` = {$route->getId()} AND
			`entity_type` = {$route->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
###################################################################################################
# nodes ###########################################################################################
	
	public function getNodes($offset=null, $limit=null, $execute=true)
	{
		$node_list = new CMS_Map_NodeList($offset, $limit);
		$node_list->setTableName('map_area_bindings');
		$node_list->setIdColumnName('entity_id');
		$node_list->addCondition('area_id', $this->id);
		$node_list->addCondition('entity_type', CMS_Map_Node::ENTITY_ID);
		
		if($execute === true)
			$node_list->execute();
		
		return $node_list;
	}
	
	public function addNode(CMS_Map_Node $node)
	{
		$sql =<<<SQL
		INSERT INTO
			`map_area_bindings`
			(
				`area_id`,
				`entity_id`,
				`entity_type`
			)
		VALUES
			(
				{$this->id},
				{$node->getId()},
				{$node->getType()}
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
	public function removeNode(CMS_Map_Node $node)
	{
		$sql =<<<SQL
		DELETE 
		FROM
			`map_area_bindings`
		WHERE
			`area_id` = {$this->id} AND
			`entity_id` = {$node->getId()} AND
			`entity_type` = {$node->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
###################################################################################################
# markers #########################################################################################

	public function getMarkers($offset=null, $limit=null, $execute=true)
	{
		$marker_list = new CMS_Map_MarkerList($offset, $limit);
		$marker_list->setTableName('map_area_bindings');
		$marker_list->setIdColumnName('entity_id');
		$marker_list->addCondition('area_id', $this->id);
		$marker_list->addCondition('entity_type', CMS_Map_Marker::ENTITY_ID);
		
		if($execute === true)
			$marker_list->execute();
		
		return $marker_list;
	}
	
	public function addMarker(CMS_Map_Marker $marker)
	{
		$sql =<<<SQL
		INSERT INTO
			`map_area_bindings`
			(
				`area_id`,
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
			`map_area_bindings`
		WHERE
			`area_id` = {$this->id} AND
			`entity_id` = {$marker->getId()} AND
			`entity_type` = {$marker->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
###################################################################################################
# attractions #####################################################################################

	public function getAttractions($offset=null, $limit=null, $execute=true)
	{
		$attraction_list = new CMS_Map_AttractionList($offset, $limit);
		$attraction_list->setTableName('map_area_bindings');
		$attraction_list->setIdColumnName('entity_id');
		$attraction_list->addCondition('area_id', $this->id);
		$attraction_list->addCondition('entity_type', CMS_Map_Attraction::ENTITY_ID);
		
		if($execute === true)
			$attraction_list->execute();
		
		return $attraction_list;
	}

	public function addAtraction(CMS_Map_Attraction $attraction)
	{
		$sql =<<<SQL
		INSERT INTO
			`map_area_bindings`
			(
				`area_id`,
				`entity_id`,
				`entity_type`
			)
		VALUES
			(
				{$this->id},
				{$attraction->getId()},
				{$attraction->getType()}
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
	public function removeAttraction(CMS_Map_Attraction $attraction)
	{
		$sql =<<<SQL
		DELETE 
		FROM
			`map_area_bindings`
		WHERE
			`area_id` = {$this->id} AND
			`entity_id` = {$attraction->getId()} AND
			`entity_type` = {$attraction->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
###################################################################################################
# articles ########################################################################################

	public function getArticles($offset=null, $limit=null, $execute=true)
	{
		$article_list = new CMS_ArticleList($offset, $limit);
		$article_list->setTableName('map_area_bindings');
		$article_list->setIdColumnName('entity_id');
		$article_list->addCondition('area_id', $this->id);
		$article_list->addCondition('entity_type', CMS_Article::ENTITY_ID);
		
		if($execute === true)
			$article_list->execute();
		
		return $article_list;
	}
	
	public function addArticle(CMS_Article $article)
	{
		$sql =<<<SQL
		INSERT INTO
			`map_area_bindings`
			(
				`area_id`,
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
			`map_area_bindings`
		WHERE
			`area_id` = {$this->id} AND
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
		# bindings ################################################################################
		
		$query = new CN_SqlQuery("DELETE FROM `map_area_bindings` WHERE `{$this->id_column_name}` = {$this->id}");
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
		$image = "''";
		$start_coordinate_x = "''";
		$start_coordinate_y = "''"; 
		$end_coordinate_x = "''";
		$end_coordinate_y = "''";
		
		###########################################################################################
		
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : (int)$this->new_data[$this->main_table]['is_published'];
			
		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
			
		if(isset($this->new_data[$this->main_table]['start_coordinate_x']))
			$start_coordinate_x = $this->new_data[$this->main_table]['start_coordinate_x'] === 'NULL' ? $start_coordinate_x : "'{$this->new_data[$this->main_table]['start_coordinate_x']}'";
			
		if(isset($this->new_data[$this->main_table]['start_coordinate_y']))
			$start_coordinate_y = $this->new_data[$this->main_table]['start_coordinate_y'] === 'NULL' ? $start_coordinate_y : "'{$this->new_data[$this->main_table]['start_coordinate_y']}'";
			
		if(isset($this->new_data[$this->main_table]['end_coordinate_x']))
			$end_coordinate_x = $this->new_data[$this->main_table]['end_coordinate_x'] === 'NULL' ? $end_coordinate_x : "'{$this->new_data[$this->main_table]['end_coordinate_x']}'";
			
		if(isset($this->new_data[$this->main_table]['end_coordinate_y']))
			$end_coordinate_y = $this->new_data[$this->main_table]['end_coordinate_y'] === 'NULL' ? $end_coordinate_y : "'{$this->new_data[$this->main_table]['end_coordinate_y']}'";
			
		###########################################################################################
		
		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`is_published`,
				`image`,
				`start_coordinate_x`,
				`start_coordinate_y`,
				`end_coordinate_x`,
				`end_coordinate_y`
			)
		VALUES
			(
				NOW(),
				$is_published,
				$image,
				$start_coordinate_x,
				$start_coordinate_y,
				$end_coordinate_x,
				$end_coordinate_y
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
		$image = "''";
		$start_coordinate_x = "''";
		$start_coordinate_y = "''"; 
		$end_coordinate_x = "''";
		$end_coordinate_y = "''";
		
		###########################################################################################
		
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : $this->new_data[$this->main_table]['is_published'];
		else
			$is_published = $this->current_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : $this->current_data[$this->main_table]['is_published'];
			
		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
		else
			$image = $this->current_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->current_data[$this->main_table]['image']}'";
			
		if(isset($this->new_data[$this->main_table]['start_coordinate_x']))
			$start_coordinate_x = $this->new_data[$this->main_table]['start_coordinate_x'] === 'NULL' ? $start_coordinate_x : "'{$this->new_data[$this->main_table]['start_coordinate_x']}'";
		else
			$start_coordinate_x = $this->current_data[$this->main_table]['start_coordinate_x'] === 'NULL' ? $start_coordinate_x : "'{$this->current_data[$this->main_table]['start_coordinate_x']}'";
			
		if(isset($this->new_data[$this->main_table]['start_coordinate_y']))
			$start_coordinate_y = $this->new_data[$this->main_table]['start_coordinate_y'] === 'NULL' ? $start_coordinate_y : "'{$this->new_data[$this->main_table]['start_coordinate_y']}'";
		else
			$start_coordinate_y = $this->current_data[$this->main_table]['start_coordinate_y'] === 'NULL' ? $start_coordinate_y : "'{$this->current_data[$this->main_table]['start_coordinate_y']}'";
			
		if(isset($this->new_data[$this->main_table]['end_coordinate_x']))
			$end_coordinate_x = $this->new_data[$this->main_table]['end_coordinate_x'] === 'NULL' ? $end_coordinate_x : "'{$this->new_data[$this->main_table]['end_coordinate_x']}'";
		else
			$end_coordinate_x = $this->current_data[$this->main_table]['end_coordinate_x'] === 'NULL' ? $end_coordinate_x : "'{$this->current_data[$this->main_table]['end_coordinate_x']}'";
			
		if(isset($this->new_data[$this->main_table]['end_coordinate_y']))
			$end_coordinate_y = $this->new_data[$this->main_table]['end_coordinate_y'] === 'NULL' ? $end_coordinate_y : "'{$this->new_data[$this->main_table]['end_coordinate_y']}'";
		else
			$end_coordinate_y = $this->current_data[$this->main_table]['end_coordinate_y'] === 'NULL' ? $end_coordinate_y : "'{$this->current_data[$this->main_table]['end_coordinate_y']}'";
			
		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`is_published` = $is_published,
			`image` = $image,
			`coordinate_x` = $coordinate_x,
			`coordinate_y` = $coordinate_y
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
