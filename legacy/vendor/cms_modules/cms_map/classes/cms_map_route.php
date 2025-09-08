<?php

if(!defined('CMS_MAP_ROUTE_PHP')):
	define('CMS_MAP_ROUTE_PHP', true);

class CMS_Map_Route extends CMS_Entity
{
	const ENTITY_ID = 222;
	
###################################################################################################
# public
###################################################################################################

	public function __construct($entity_id=null)
	{
		$this->main_table = 'map_routes';
		$this->lang_table = 'map_routes_lang';
		$this->id_column_name = 'route_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $entity_id);
	}
	
###################################################################################################
# nodes ###########################################################################################
	
	public function getNodes($offset=null, $limit=null, $execute=true)
	{
		$node_list = new CMS_Map_NodeList($offset, $limit);
		$node_list->setTableName('map_route_bindings');
		$node_list->setIdColumnName('entity_id');
		$node_list->addCondition('route_id', $this->id);
		$node_list->addCondition('entity_type', CMS_Map_Node::ENTITY_ID);
		
		if($execute === true)
			$node_list->execute();
		
		return $node_list;
	}
	
	public function addNode(CMS_Map_Node $node)
	{
		$sql =<<<SQL
		INSERT INTO
			`map_route_bindings`
			(
				`route_id`,
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
			`map_route_bindings`
		WHERE
			`route_id` = {$this->id} AND
			`entity_id` = {$node->getId()} AND
			`entity_type` = {$node->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
###################################################################################################
# articles ########################################################################################

	public function getArticles($offset=null, $limit=null, $execute=true)
	{
		$article_list = new CMS_ArticleList($offset, $limit);
		$article_list->setTableName('map_routes_bindings');
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
			`map_routes_bindings`
			(
				`route_id`,
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
			`map_routes_bindings`
		WHERE
			`route_id` = {$this->id} AND
			`entity_id` = {$article->getId()} AND
			`entity_type` = {$article->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
###################################################################################################
# get Area #################################################################################	
	public function getArea()
	{
		$area_list = new CMS_Map_AreaList();
		$area_list->setTableName('map_area_bindings');
		$area_list->setIdColumnName('area_id');
		$area_list->addCondition('entity_id', $this->id);
		$area_list->addCondition('entity_type', CMS_Map_Route::ENTITY_ID);
		$area_list->execute();

		foreach($area_list as $area){
			//$area = new CMS_Map_Area($area);
		}		
		return $area;
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
	}

###################################################################################################
# private
###################################################################################################

	private function insertEntity()
	{
		$is_published = (int)true;
		$route_type = 'NULL';
		$path = "''";
		$color = "''";
		
		###########################################################################################
		
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : (int)$this->new_data[$this->main_table]['is_published'];
			
		if(isset($this->new_data[$this->main_table]['route_type']))
			$route_type = $this->new_data[$this->main_table]['route_type'] === 'NULL' ? $route_type : "'{$this->new_data[$this->main_table]['route_type']}'";
			
		if(isset($this->new_data[$this->main_table]['path']))
			$path = $this->new_data[$this->main_table]['path'] === 'NULL' ? $path : "'{$this->new_data[$this->main_table]['path']}'";
			
		if(isset($this->new_data[$this->main_table]['color']))
			$color = $this->new_data[$this->main_table]['path'] === 'NULL' ? $color : "'{$this->new_data[$this->main_table]['color']}'";
			
		###########################################################################################
		
		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`is_published`,
				`route_type`,
				`path`,
				`color`
			)
		VALUES
			(
				NOW(),
				$is_published,
				$route_type,
				$path,
				$color
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
		$route_type = 0;
		$path = "''";
		$color = "''";
		
		###########################################################################################
		
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : $this->new_data[$this->main_table]['is_published'];
		else
			$is_published = $this->current_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : $this->current_data[$this->main_table]['is_published'];
			
		if(isset($this->new_data[$this->main_table]['route_type']))
			$route_type = $this->new_data[$this->main_table]['route_type'] === 'NULL' ? $route_type : "'{$this->new_data[$this->main_table]['route_type']}'";
		else
			$route_type = $this->current_data[$this->main_table]['route_type'] === 'NULL' ? $route_type : "'{$this->current_data[$this->main_table]['route_type']}'";
			
		if(isset($this->new_data[$this->main_table]['path']))
			$path = $this->new_data[$this->main_table]['path'] === 'NULL' ? $path : "'{$this->new_data[$this->main_table]['path']}'";
		else
			$path = $this->current_data[$this->main_table]['path'] === 'NULL' ? $path : "'{$this->current_data[$this->main_table]['path']}'";
			
		if(isset($this->new_data[$this->main_table]['color']))
			$color = $this->new_data[$this->main_table]['color'] === 'NULL' ? $path : "'{$this->new_data[$this->main_table]['color']}'";
		else
			$color = $this->current_data[$this->main_table]['color'] === 'NULL' ? $path : "'{$this->current_data[$this->main_table]['color']}'";
			
		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`is_published` = $is_published,
			`route_type` = $route_type,
			`path` = $path,
			`color` = $color
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
