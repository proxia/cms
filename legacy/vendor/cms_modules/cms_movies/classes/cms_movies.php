<?php

if(!defined('CMS_MOVIES_PHP')):
	define('CMS_MOVIES_PHP', true);

class CMS_Movies extends CMS_Entity
{
	const ENTITY_ID = 220;

###################################################################################################
# public
###################################################################################################

	public function __construct($entity_id=null)
	{
		$this->main_table = 'movies';
		$this->lang_table = 'movies_lang';
		$this->id_column_name = 'movie_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $entity_id);
	}

###################################################################################################

	public function isDisplayable()
	{
		$is_displayable = true;
		$is_time_valid = false;
		
		# time validity check ##################################################################### 
		
		$current_date = strtotime('now');
		$valid_from = strtotime($this->current_data[$this->main_table]['valid_from']);
		$valid_to = strtotime($this->current_data[$this->main_table]['valid_to']);

		if($current_date >= $valid_from && ($valid_to == null || $valid_to == 943916400))
			$is_time_valid = true;
		elseif($current_date <= $valid_to && ($valid_to == null || $valid_to == 943916400))
			$is_time_valid = true;
		elseif(($current_date >= $valid_from) && ($current_date <= $valid_to))
			$is_time_valid = true;
		
		$is_displayable = $is_time_valid;
		
		###########################################################################################
		
		if($this->getIsPublished() == 0)
			$is_displayable = false;
		
		return $is_displayable;
	}

###################################################################################################
# parent handling #################################################################################

# categories ######################################################################################

###################################################################################################
# galleries #######################################################################################

	public function getGalleries($offset=null, $limit=null, $execute=true)
	{
		$gallery_list = new CMS_GalleryList($offset, $limit);
		$gallery_list->setTableName('gallery_bindings');
		$gallery_list->setIdColumnName('gallery_id');
		$gallery_list->removeCondition('usable_by');
		$gallery_list->addCondition('entity_id', $this->id);
		$gallery_list->addCondition('entity_type', $this->getType());

		if($execute === true)
			$gallery_list->execute();

		return $gallery_list;
	}

	public function addGallery(CMS_Gallery & $gallery)
	{
		$sql =<<<SQL
		INSERT INTO
			`gallery_bindings`
			(
				`entity_id`,
				`entity_type`,
				`gallery_id`
			)
		VALUES
			(
				{$this->id},
				{$this->getType()},
				{$gallery->getId()}
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeGallery(CMS_Gallery & $gallery)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`gallery_bindings`
		WHERE
			`entity_id` = {$this->id} AND
			`entity_type` = {$this->getType()} AND
			`gallery_id` = {$gallery->getId()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################
# articles ########################################################################################

	public function getParentArticles($offset=null, $limit=null, $execute=true)
	{
		$article_list = new CMS_ArticleList($offset, $limit);
		$article_list->setTableName('articles_bindings');
		$article_list->setIdColumnName('article_id');
		$article_list->addCondition('item_id', $this->id);
		$article_list->addCondition('item_type', $this->type);
		
		if($execute === true)
			$article_list->execute();
			
		return $article_list;
	}

###################################################################################################
# utility methods #################################################################################

	public function isValid()
	{
		$current_date = strtotime('now');
		$valid_from = strtotime($this->current_data[$this->main_table]['valid_from']);
		$valid_to = strtotime($this->current_data[$this->main_table]['valid_to']);

		if($current_date >= $valid_from && $valid_to == null)
			return true;
		elseif($current_date <= $valid_to && $valid_from == null)
			return true;
		elseif(($current_date >= $valid_from) && ($current_date <= $valid_to))
			return true;

		return false;
	}

###################################################################################################
# move methods  ###################################################################################

# move in articles ################################################################################

	public function moveUpInArticle($article_id, $move_by=1) { return $this->moveUpInEntity($article_id, 'article_id', 'articles_bindings', $move_by); }
	public function moveDownInArticle($article_id, $move_by=1) { return $this->moveDownInEntity($article_id, 'article_id', 'articles_bindings', $move_by); }
	public function moveToTopInArticle($article_id) { return $this->moveToTopInEntity($article_id, 'article_id', 'articles_bindings'); }
	public function moveToBottomInArticle($article_id) { return $this->moveToBottomInEntity($article_id, 'article_id', 'articles_bindings'); }

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
		# gallery bindings ########################################################################

		if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Gallery') === true)
		{
			$gallery_list = $this->getGalleries();

			foreach($gallery_list as $gallery)
				$this->removeGallery($gallery);
		}

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
		$author_id = 0;
		$is_published = (int)true;
		$valid_from = 'NULL';
		$valid_to = 'NULL';
		$real_date_start = 'NULL';
		$real_date_end = 'NULL';
		$image = 'NULL';
		$video = 'NULL';
		$price = 0.0;
		###########################################################################################

		if(isset($this->new_data[$this->main_table]['author_id']))
			$author_id = $this->new_data[$this->main_table]['author_id'] === 'NULL' ? $author_id : $this->new_data[$this->main_table]['author_id'];
			
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : (int)$this->new_data[$this->main_table]['is_published'];
						
		if(isset($this->new_data[$this->main_table]['valid_from']))
			$valid_from = $this->new_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->new_data[$this->main_table]['valid_from']}'";
			
		if(isset($this->new_data[$this->main_table]['valid_to']))
			$valid_to = $this->new_data[$this->main_table]['valid_to'] === 'NULL' ? $valid_to : "'{$this->new_data[$this->main_table]['valid_to']}'";
		
		if(isset($this->new_data[$this->main_table]['real_date_start']))
			$real_date_start = $this->new_data[$this->main_table]['real_date_start'] === 'NULL' ? $real_date_start : "'{$this->new_data[$this->main_table]['real_date_start']}'";
			
		if(isset($this->new_data[$this->main_table]['real_date_end']))
			$real_date_end = $this->new_data[$this->main_table]['real_date_end'] === 'NULL' ? $real_date_end : "'{$this->new_data[$this->main_table]['real_date_end']}'";

		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
			
		if(isset($this->new_data[$this->main_table]['video']))
			$video = $this->new_data[$this->main_table]['video'] === 'NULL' ? $video : "'{$this->new_data[$this->main_table]['video']}'";			
			
		if(isset($this->new_data[$this->main_table]['price']))
			$price = $this->new_data[$this->main_table]['price'] === 'NULL' ? $price : $this->new_data[$this->main_table]['price'];			
		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`author_id`,
				`is_published`,
				`image`,
				`video`,				
				`valid_from`,
				`valid_to`,
				`price`,
				`real_date_start`,
				`real_date_end`
			)
		VALUES
			(
				NOW(),
				$author_id,
				$is_published,
				$image,
				$video,				
				$valid_from,
				$valid_to,
				$price,
				$real_date_start,
				$real_date_end
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
		$author_id = 0;
		$is_published = (int)true;
		$valid_from = 'NULL';
		$valid_to = 'NULL';
		$real_date_start = 'NULL';
		$real_date_end = 'NULL';
		$image = 'NULL';
		$video = 'NULL';
		$price = 0.0;
		###########################################################################################

		if(isset($this->new_data[$this->main_table]['author_id']))
			$author_id = $this->new_data[$this->main_table]['author_id'] === 'NULL' ? $author_id : $this->new_data[$this->main_table]['author_id'];
		else
			$author_id = $this->current_data[$this->main_table]['author_id'] === 'NULL' ? $author_id : $this->current_data[$this->main_table]['author_id'];

		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? (int)$is_published : (int)$this->new_data[$this->main_table]['is_published'];
		else
			$is_published = $this->current_data[$this->main_table]['is_published'] === 'NULL' ? (int)$is_published : (int)$this->current_data[$this->main_table]['is_published'];
			
		if(isset($this->new_data[$this->main_table]['valid_from']))
			$valid_from = $this->new_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->new_data[$this->main_table]['valid_from']}'";
		else
			$valid_from = $this->current_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->current_data[$this->main_table]['valid_from']}'";
		

		if(isset($this->new_data[$this->main_table]['valid_to']))
			$valid_to = $this->new_data[$this->main_table]['valid_to'] === 'NULL' ? $valid_to : "'{$this->new_data[$this->main_table]['valid_to']}'";
		else
			$valid_to = $this->current_data[$this->main_table]['valid_to'] === 'NULL' ? $valid_to : "'{$this->current_data[$this->main_table]['valid_to']}'";

		if(isset($this->new_data[$this->main_table]['real_date_start']))
			$real_date_start = $this->new_data[$this->main_table]['real_date_start'] === 'NULL' ? $real_date_start : "'{$this->new_data[$this->main_table]['real_date_start']}'";
		else
			$real_date_start = $this->current_data[$this->main_table]['real_date_start'] === 'NULL' ? $real_date_start : "'{$this->current_data[$this->main_table]['real_date_start']}'";

		if(isset($this->new_data[$this->main_table]['real_date_end']))
			$real_date_end = $this->new_data[$this->main_table]['real_date_end'] === 'NULL' ? $real_date_end : "'{$this->new_data[$this->main_table]['real_date_end']}'";
		else
			$real_date_end = $this->current_data[$this->main_table]['real_date_end'] === 'NULL' ? $real_date_end : "'{$this->current_data[$this->main_table]['real_date_end']}'";

		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
		else
			$image = $this->current_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->current_data[$this->main_table]['image']}'";

		if(isset($this->new_data[$this->main_table]['video']))
			$video = $this->new_data[$this->main_table]['video'] === 'NULL' ? $video : "'{$this->new_data[$this->main_table]['video']}'";
		else
			$video = $this->current_data[$this->main_table]['video'] === 'NULL' ? $video : "'{$this->current_data[$this->main_table]['video']}'";

		if(isset($this->new_data[$this->main_table]['price']))
			$price = $this->new_data[$this->main_table]['price'] === 'NULL' ? $price : $this->new_data[$this->main_table]['price'];
		else
			$price = $this->current_data[$this->main_table]['price'] === 'NULL' ? $price : $this->current_data[$this->main_table]['price'];

			
		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`author_id` = $author_id,
			`is_published` = $is_published,
			`image` = $image,
			`video` = $video,			
			`valid_from` = $valid_from,
			`valid_to` = $valid_to,
			`price` = $price,
			`real_date_start` = $real_date_start,
			`real_date_end` = $real_date_end
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
				$language_is_visible = $language_version['language_is_visible'] === 'NULL' ? $language_is_visible : (int)$language_version['language_is_visible'];
			elseif(isset($this->current_data[$this->lang_table][$language]['language_is_visible']))
				$language_is_visible = $this->current_data[$this->lang_table][$language]['language_is_visible'] === 'NULL' ? $language_is_visible : (int)$this->current_data[$this->lang_table][$language]['language_is_visible'];

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
				throw new CN_Exception(sprintf(tr("There are loose data in table `%1\$s` for `id` %2\$s.", $this->lang_table, $this->id)), E_ERROR);

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$title = "''";
			$description = 'NULL';
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}
}

endif;

?>