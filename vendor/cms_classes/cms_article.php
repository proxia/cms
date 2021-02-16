<?php

if(!defined('CMS_ARTICLE_PHP')):
	define('CMS_ARTICLE_PHP', TRUE);

/**
 *
 * Reprezentuje jednen clanok.
 * Obsahuje metody na pristup k hodnotam jednotlivych stlpcov.
 *
 * @package Core
 * @subpackage Articles
 */

class CMS_Article extends CMS_Entity
{
	const ENTITY_ID = 2;

###################################################################################################
# public
###################################################################################################

	/**
	 * Default konstruktor.
	 *
	 * @param int $article_id - cislo clanku
	 */
	public function __construct($article_id=null)
	{
		parent::__construct(self::ENTITY_ID, $article_id);
	}

###################################################################################################

	public function __clone()
	{
		$this->id = null;

		$this->current_data[$this->main_table]['id'] = null;

		if(!is_null($this->lang_table))
			$this->current_data[$this->lang_table][$this->context_language][$this->id_column_name] = null;

		$this->new_data = $this->current_data;

		$this->current_data[$this->main_table] = array();

		if(!is_null($this->lang_table))
			$this->current_data[$this->lang_table] = array();
	}

###################################################################################################

	public function discard()
	{
		$query = new CN_SqlQuery("UPDATE `articles` SET `is_trash` = 1 WHERE `id` = {$this->id}");
		$query->execute();

		$this->setIsTrash(true);
	}

	public function restore()
	{
		$query = new CN_SqlQuery("UPDATE `articles` SET `is_trash` = 0 WHERE `id` = {$this->id}");
		$query->execute();

		$this->setIsTrash(false);
	}

###################################################################################################

	public function archive()
	{
		$query = new CN_SqlQuery("UPDATE `articles` SET `is_archive` = 1, `expiration` = NOW() WHERE `id` = {$this->id}");
		$query->execute();

		$this->readData(CMS::READ_MAIN_DATA);
	}

	public function unarchive()
	{
		$query = new CN_SqlQuery("UPDATE `articles` SET `is_archive` = 0, `expiration` = 'NULL' WHERE `id` = {$this->id}");
		$query->execute();

		$this->setIsArchive(false);
		$this->setExpiration(null);
	}

###################################################################################################

	public function isDisplayable()
	{
		if(($this->getIsPublished() == 0) || ($this->getIsTrash() == 1) || ($this->getIsArchive() == 1))
			return false;

		if(!isset($this->current_data[$this->lang_table][$this->context_language]) || $this->getLanguageIsVisible() == 0)
			return false;

		if($this->getExpiration() !== null)
		{
			if(($this->getExpiration() != '0000-00-00 00:00:00'))
			{
				if(time() > strtotime($this->getExpiration()))
					return false;
			}
		}

		if(CMS_UserLogin::getSingleton()->isUserLogedIn() !== true)
		{
			if($this->getAccess() == CMS::ACCESS_REGISTERED)
				return false;
		}

		if($this->getIsNews() == 1 || $this->getIsFlashNews() == 1)
			return true;
			
		if(CMS_Frontpage::getSingleton()->itemExists($this))
			return true;

		###########################################################################################

		if($this->getMenuList(true)->getSize() == 0)
		{
			$parent_is_displayable = false;

			$parent_list = $this->getParents();

			if($parent_list->getSize() == 0)
				return true;

			foreach($parent_list as $parent)
			{
				if($parent->isDisplayable())
				{
					$parent_is_displayable = true;
					break;
				}
			}

			return $parent_is_displayable;
		}

		###########################################################################################

		return true;
	}

	public function getPath($displayable_only=true)
	{
		$path = array();

		###########################################################################################

		$parent_list = $this->getParents();

		foreach($parent_list as $parent)
		{
			$parent_path = $parent->getPath($displayable_only);

			$article_path = $parent_path[CMS_Category::ENTITY_ID];
			$article_path[] = $parent;

			$path[CMS_Category::ENTITY_ID][] = $article_path;
		}

		###########################################################################################

		$menu_list = $this->getMenuList();

		if($displayable_only === true)
		{
			foreach($menu_list as $menu)
			{
				if($menu->isDisplayable())
					$path[CMS_Menu::ENTITY_ID][] = $menu;
			}
		}
		else
		{
			if(!$menu_list->isEmpty())
				$path[CMS_Menu::ENTITY_ID] = $menu_list->getRawData();
		}

		###########################################################################################

		return $path;
	}

###################################################################################################
# privileges ######################################################################################


	public function checkAccessPrivileges()
	{

	}

	public function checkEditorPrivileges($entity_instance, $logic_entity_id, $privilege)
	{
		$sql =<<<SQL
		SELECT
			*
		FROM
			`privileges`
		WHERE
			`entity_id` = {$entity_instance->getId()} AND
			`entity_type` = {$entity_instance->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->getSize() > 0)
		{

		}

		return false;
	}

###################################################################################################
# items ###########################################################################################

	public function itemExists($item)
	{
		if(!is_subclass_of($item, 'CMS_Entity'))
			throw new CN_Exception(tr("\$item must be some subclass of CMS_Entity."));

		$item_type = $item->getType();

		###########################################################################################

		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`articles_bindings`
		WHERE
			`article_id` = {$this->id} AND
			`item_id` = {$item->getId()} AND
			`item_type` = $item_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

	public function getItems($item_type=null, $displayable_only=false, $offset=null, $limit=null, $execute=true, $sort_direction=null)
	{
		if(is_null($sort_direction))
     		$sort_direction = CMS_EntityList::DIRECTION_ASCENDING;

		$vector = new CN_Vector();

		###########################################################################################

		$where_token = null;

		if(!is_null($item_type))
		{
			$entity_table_name = null;
			$list_class_name = null;

			$display_conditions = null;

			$language = CN_Application::getSingleton()->getLanguage();

			#######################################################################################

			switch($item_type)
			{
				case self::ENTITY_ID:
					$entity_table_name = 'categories, categories_lang';
					$list_class_name = 'CMS_CategoryList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, '`id` = `item_id`' => true, '`category_id`' => '`item_id`', 'language' => "'$language'", 'language_is_visible' => 1);
					break;

				case CMS_Article::ENTITY_ID:
					$entity_table_name = 'articles, articles_lang';
					$list_class_name = 'CMS_ArticleList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, 'is_archive' => 0, '(`expiration` >= CURRENT_DATE OR `expiration` IS NULL)' => true, '`id` = `item_id`' => true, '`article_id` = `item_id`' => true, 'language' => "'$language'", 'language_is_visible' => 1);
					break;

				case CMS_Weblink::ENTITY_ID:
					$entity_table_name = 'weblinks, weblinks_lang';
					$list_class_name = 'CMS_WeblinkList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, '`id` = `item_id`' => true, '`weblink_id`' => '`item_id`', 'language' => "'$language'", 'language_is_visible' => 1);
					break;

				// not good

				case 101:
					$entity_table_name = 'catalog_products';
					$list_class_name = 'CMS_Catalog_ProductList';
					$display_conditions = array('is_published' => 1, 'CURRENT_DATE BETWEEN `valid_from` AND `valid_to`' => true);
					break;

				case 141:
					$entity_table_name = 'job_offer_ads';
					$list_class_name = 'CMS_Job_OfferAdList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, 'CURRENT_DATE BETWEEN `valid_from` AND `valid_to`' => true);
					break;

				case 142:
					$entity_table_name = 'job_search_ads';
					$list_class_name = 'CMS_Job_SearchAdList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, 'CURRENT_DATE BETWEEN `valid_from` AND `valid_to`' => true);
					break;
			}

			#######################################################################################

			$list = new $list_class_name($offset, $limit);
			$list->setTableName('articles_bindings');
			$list->setIdColumnName('item_id');
			$list->setSortBy('item_id');

			$list->addCondition('article_id', $this->id);
			$list->addCondition('item_type', $item_type);

			if($displayable_only === true)
			{
				// strasny hack, bude tot treba prerobit ak bude entitylist v nejakej rozumnej forme

				$list->setTableName('`categories_bindings`, '.$entity_table_name);
				$list->addCondition('id', '`item_id`');

				if(CMS_UserLogin::getSingleton()->isUserLogedIn() === true)
					$list->addCondition('(`access` = '.CMS::ACCESS_PUBLIC.' OR `access` = '.CMS::ACCESS_REGISTERED.')', null, null, true);
				else
					$list->addCondition('access', CMS::ACCESS_PUBLIC);

				foreach($display_conditions as $column => $value)
				{
					if(is_bool($value))
						$list->addCondition($column, null, null, true);
					else
						$list->addCondition($column, $value);
				}
			}

			if($execute === true)
				$list->execute();

			return $list;
		}

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`articles_bindings`
		WHERE
			`article_id` = {$this->id}
			$where_token
		ORDER BY `order` $sort_direction
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		while($query->next())
		{
			$record = $query->fetchRecord();

			#######################################################################################

			$class_name = CMS_Entity::getEntityNameById($record->getValue('item_type'));

			$item = new $class_name($record->getValue('item_id'));

			if($displayable_only === true)
			{
				if($item->isDisplayable())
					$vector->append($item);
			}
			else
				$vector->append($item);
		}

		###########################################################################################

		return $vector;
	}
	
	public function addItem($item)
	{
		if(!is_subclass_of($item, 'CMS_Entity'))
			throw new CN_Exception(tr("\$item must be some subclass of CMS_Entity."));

		$item_type = $item->getType();
		$order = null;

		###########################################################################################

		$sql = <<<SQL
		SELECT
			MAX(`order`)
		FROM
			`articles_bindings`
		WHERE
			`article_id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$order = $query->fetchValue() + 1;

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`articles_bindings`
			(
				`article_id`,
				`item_id`,
				`item_type`,
				`order`
			)
		VALUES
			(
				{$this->id},
				{$item->getId()},
				$item_type,
				$order
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
	public function removeItem($item)
	{
		if(!is_subclass_of($item, 'CMS_Entity'))
			throw new CN_Exception(tr("\$item must be some subclass of CMS_Entity."));

		$item_type = $item->getType();

		###########################################################################################

		$sql =<<<SQL
		DELETE
		FROM
			`articles_bindings`
		WHERE
			`article_id` = {$this->id} AND
			`item_id` = {$item->getId()} AND
			`item_type` = $item_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################
# attachments #####################################################################################

	public function getAttachments($offset=null, $limit=null, $execute=true)
	{
		return CMS_AttachmentList::getArticleAttachments($this, $offset, $limit, $execute);
	}

###################################################################################################

	public function attachmentExists(CMS_Attachment $attachment)
	{
		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`articles_attachments`
		WHERE
			`article_id` = {$this->id} AND
			`attachment_id` = {$attachment->getId()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

###################################################################################################

	public function addAttachment(CMS_Attachment $attachment)
	{
		$sql =<<<SQL
		INSERT INTO
			`articles_attachments`
			(
				`article_id`,
				`attachment_id`
			)
		VALUES
			(
				{$this->id},
				{$attachment->getId()}
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeAttachment(CMS_Attachment $attachment)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`articles_attachments`
		WHERE
			`article_id` = {$this->id} AND
			`attachment_id` = {$attachment->getId()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################

	/**
	 * Zisti ci ma clanok rodicovsku kategoriu alebo nie. Moze ich mat aj viac.
	 *
	 * @return bool
	 */
	public function hasParent()
	{
		$item_type = self::ENTITY_ID;

		$sql =<<<SQL
		SELECT
			COUNT(DISTINCT `category_id`)
		FROM
			`categories_bindings`
		WHERE
			`item_id` = {$this->id} AND
			`item_type` = $item_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

	/**
	 * Vrati pocet kategorii v ktorych je priradeny clanok
	 *
	 * @return int $parent_count
	 */
	public function getParentCount()
	{
		$item_type = self::ENTITY_ID;

		$sql =<<<SQL
		SELECT
			COUNT(DISTINCT `category_id`)
		FROM
			`categories_bindings`
		WHERE
			`item_id` = {$this->id} AND
			`item_type` = $item_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return $query->fetchValue();
	}

	/**
	 * Vrati zoznam objektov kategorii v ktorych je priradeny clanok
	 *
	 * @return CN_Vector $object_list
	 */
	public function getParents($id_only=false)
	{
		$parent_list = new CN_Vector();

		###########################################################################################

		$item_type = self::ENTITY_ID;

		$sql =<<<SQL
		SELECT
			DISTINCT `category_id`
		FROM
			`categories_bindings`
		WHERE
			`item_id` = {$this->id} AND
			`item_type` = $item_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			if($id_only === true)
				$parent_list->append($record->getValue('category_id'));
			else
				$parent_list->append(new CMS_Category($record->getValue('category_id')));
		}

		###########################################################################################

		return $parent_list;
	}

###################################################################################################

	public function getMenuList($id_only=false)
	{
		$menu_list = new CN_Vector();

		###########################################################################################

		$item_type = self::ENTITY_ID;

		$sql =<<<SQL
		SELECT
			DISTINCT `menu_id`
		FROM
			`menus_bindings`
		WHERE
			`item_type` = $item_type AND
			`item_id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			if($id_only === true)
				$menu_list->append($record->getValue('menu_id'));
			else
				$menu_list->append(new CMS_Menu($record->getValue('menu_id')));
		}

		###########################################################################################

		return $menu_list;
	}

###################################################################################################
# move methods ####################################################################################

# move in category ################################################################################

	/**
	 * Posunie clanok o jeden alebo viac stupnov hore. Musi byt nastavene $context_parent_id.
	 *
	 * @param int $move_by - o kolko stupnov hore sa ma clanok posunut
	 * @return int $new_position
	 */
	public function moveUpInCategory($category_id, $move_by=1) { return $this->moveUpInEntity($category_id, 'category_id', 'categories_bindings', $move_by); }

	/**
	 * Posunie clanok o jeden alebo viac stupnov dole. Musi byt nastavene $context_parent_id.
	 *
	 * @param int $move_by - o kolko stupnov sa ma clanok posunut
	 * @return int $new_position
	 */
	public function moveDownInCategory($category_id, $move_by=1) { return $this->moveDownInEntity($category_id, 'category_id', 'categories_bindings', $move_by); }
	
	/**
	 * Posunie clanok na vrch v hierarchii. Musi byt nastavene $context_parent_id.
	 *
	 * @return int $new_position
	 */
	public function moveToTopInCategory($category_id) { return $this->moveToTopInEntity($category_id, 'category_id', 'categories_bindings'); }

	/**
	 * Posunie clanok na spodok v hierarchii. Musi byt nastavene $context_parent_id.
	 *
	 * @return int $new_position
	 */
	public function moveToBottomInCategory($category_id) { return $this->moveToBottomInEntity($category_id, 'category_id', 'categories_bindings'); }

# move in menu ####################################################################################

	public function moveUpInMenu($menu_id, $move_by=1) { return $this->moveUpInEntity($menu_id, 'menu_id', 'menus_bindings', $move_by); }
	public function moveDownInMenu($menu_id, $move_by=1) { return $this->moveDownInEntity($menu_id, 'menu_id', 'menus_bindings', $move_by); }
	public function moveToTopInMenu($menu_id) { return $this->moveToTopInEntity($menu_id, 'menu_id', 'menus_bindings'); }
	public function moveToBottomInMenu($menu_id) { return $this->moveToBottomInEntity($menu_id, 'menu_id', 'menus_bindings'); }
	
###################################################################################################
# galleries #######################################################################################

	public function getGalleries($offset=null, $limit=null, $execute=true) { return CMS_Gallery_Bindings::getSingleton()->getGalleries($this, $offset, $limit, $execute); }
	public function addGallery(CMS_Gallery $gallery) { CMS_Gallery_Bindings::getSingleton()->addGallery($this, $gallery); }
	public function removeGallery(CMS_Gallery $gallery) { CMS_Gallery_Bindings::getSingleton()->removeGallery($this, $gallery); }

###################################################################################################
# event calendar entries ##########################################################################

	public function getEvents($offset=null, $limit=null, $execute=true)
	{
		$event_list = new CMS_EventCalendar_EventList($offset, $limit);
		$event_list->setTableName('articles_bindings');
		$event_list->setIdColumnName('item_id');
		$event_list->addCondition('article_id', $this->id);
		$event_list->addCondition('item_type', CMS_EventCalendar_Event::ENTITY_ID);
		
		if($execute === true)
			$event_list->execute();
			
		return $event_list;
	} 
	
	public function addEvent(CMS_EventCalendar_Event $event)
	{
		$sql =<<<SQL
		SELECT
			MAX(`order`)
		FROM
			`articles_bindings`
		WHERE
			`article_id` = {$this->id} AND
			`item_type` = {$event->getType()}
SQL;
		
		$query = new CN_SqlQuery($sql);
		$query->execute();
		
		$order = $query->fetchValue() + 1;
		
		###########################################################################################
		
		$sql =<<<SQL
		INSERT INTO 
			`articles_bindings`
			(
				`article_id`,
				`item_id`,
				`item_type`,
				`order`
			)
		VALUES
			(
				{$this->id},
				{$event->getId()},
				{$event->getType()},
				$order
			)
SQL;
		
		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
	public function removeEvent(CMS_EventCalendar_Event $event)
	{
		$sql =<<<SQL
		DELETE FROM
			`articles_bindings`
		WHERE
			`article_id` = {$this->id} AND
			`item_id` = {$event->getId()} AND
			`item_type` = {$event->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################
###################################################################################################

	/**
	 * Ulozi vsetky zmeny v hodnotach do databazy.
	 *
	 * @return void
	 */
	public function save()
	{
	    if(is_null($this->id))
			$this->insertArticle();
		else
			$this->updateArticle();

		$this->alterLanguageVersions();
	}

	/**
	 * Odtrani clanok a vsetky vazby z databazy.
	 *
	 * @return void
	 */
	public function delete()
	{
		$query = new CN_SqlQuery("DELETE FROM `statistics` WHERE `entity_id` = {$this->id} AND `entity_type` = ".self::ENTITY_ID);
		$query->execute();

		###########################################################################################

		$query = new CN_SqlQuery("DELETE FROM `frontpage` WHERE `item_id` = {$this->id} AND `item_type` = ".self::ENTITY_ID);
		$query->execute();

		###########################################################################################

		{
			$menu_list = $this->getMenuList(true);

			#######################################################################################

			$query = new CN_SqlQuery("DELETE FROM `menus_bindings` WHERE `item_id`={$this->id} AND `item_type` = ".self::ENTITY_ID);
			$query->execute();

			#######################################################################################

			$iterator = new CN_VectorIterator($menu_list);

			foreach($iterator as $menu_id)
				CMS_Menu::fixMenuOrder($menu_id);
		}

		###########################################################################################

		{
			$parent_list = $this->getParents(true);

			#######################################################################################

			$query = new CN_SqlQuery("DELETE FROM `categories_bindings` WHERE `item_id` = {$this->id} AND `item_type` = ".self::ENTITY_ID);
			$query->execute();

			#######################################################################################

			$iterator = new CN_VectorIterator($parent_list);

			foreach($iterator as $category_id)
				CMS_Category::fixCategoryOrder($category_id);
		}

		###########################################################################################

		$query = new CN_SqlQuery("DELETE FROM `articles_lang` WHERE `article_id` = {$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `articles` WHERE `id` = {$this->id}");
		$query->execute();

		$this->id = null;
		$this->current_data = null;
		$this->new_data = null;
	}

###################################################################################################
# private
###################################################################################################

	private function insertArticle()
	{
		$author_id = 'NULL';
		$update_authors = 'NULL';
		$is_published = 1;
		$is_trash = 0;
		$access = CMS::ACCESS_PUBLIC;
		$access_groups = 'NULL';
		$editors = 'NULL';
		$editors_groups = 'NULL';
		$expiration = 'NULL';
		$image = 'NULL';
		$map_image = 'NULL';
		$map_area_shape= 'NULL';
		$map_area_coordinates = 'NULL';
		$is_news = (int)false;
		$is_flash_news = (int)false;
		$frontpage_show_full_version = 0;
		$usable_by = CMS_Entity::ENTITY_UNIVERSAL;

		###########################################################################################

		if(isset($this->new_data['articles']['author_id']))
			$author_id = $this->new_data['articles']['author_id'] === 'NULL' ? 'NULL' : $this->new_data['articles']['author_id'];
		if(isset($this->new_data['articles']['update_authors']))
			$update_authors = $this->new_data['articles']['update_authors'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['update_authors']}'";
		if(isset($this->new_data['articles']['is_published']))
			$is_published = $this->new_data['articles']['is_published'] === 'NULL' ? 1 : (int)$this->new_data['articles']['is_published'];
		if(isset($this->new_data['articles']['is_trash']))
			$is_trash = $this->new_data['articles']['is_trash'] === 'NULL' ? 0 : (int)$this->new_data['articles']['is_trash'];
		if(isset($this->new_data['articles']['access']))
			$access = $this->new_data['articles']['access'] === 'NULL' ? CMS::ACCESS_PUBLIC : $this->new_data['articles']['access'];
		if(isset($this->new_data['articles']['access_groups']))
			$access_groups = $this->new_data['articles']['access_groups'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['access_groups']}'";
		if(isset($this->new_data['articles']['editors']))
			$editors = $this->new_data['articles']['editors'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['editors']}'";
		if(isset($this->new_data['articles']['editors_groups']))
			$editors_groups = $this->new_data['articles']['editors_groups'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['editors_groups']}'";
		if(isset($this->new_data['articles']['expiration']))
			$expiration = $this->new_data['articles']['expiration'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['expiration']}'";
		if(isset($this->new_data['articles']['image']))
			$image = $this->new_data['articles']['image'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['image']}'";
		if(isset($this->new_data['articles']['map_image']))
			$map_image = $this->new_data['articles']['map_image'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['map_image']}'";
		if(isset($this->new_data['articles']['map_area_shape']))
			$map_area_shape = $this->new_data['articles']['map_area_shape'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['map_area_shape']}'";
		if(isset($this->new_data['articles']['map_area_coordinates']))
			$map_area_coordinates = $this->new_data['articles']['map_area_coordinates'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['map_area_coordinates']}'";
		if(isset($this->new_data['articles']['is_news']))
			$is_news = $this->new_data['articles']['is_news'] === ' NULL' ? $is_news : (int)$this->new_data['articles']['is_news'];
		if(isset($this->new_data['articles']['is_flash_news']))
			$is_flash_news = $this->new_data['articles']['is_flash_news'] === 'NULL' ? $is_flash_news : (int)$this->new_data['articles']['is_flash_news'];
		if(isset($this->new_data['articles']['frontpage_show_full_version']))
			$frontpage_show_full_version = $this->new_data['articles']['frontpage_show_full_version'] === 'NULL' ? $frontpage_show_full_version : (int)$this->new_data['articles']['frontpage_show_full_version'];
		if(isset($this->new_data['articles']['usable_by']))
			$usable_by = $this->new_data['articles']['usable_by'] === 'NULL' ? $usable_by : $this->new_data['articles']['usable_by'];

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
		    `articles`
		    (
				`author_id`,
				`update_authors`,
				`creation`,
				`is_published`,
				`is_trash`,
				`access`,
				`access_groups`,
				`editors`,
				`editors_groups`,
				`expiration`,
				`image`,
				`map_image`,
				`map_area_shape`,
				`map_area_coordinates`,
				`is_news`,
				`is_flash_news`,
				`frontpage_show_full_version`,
				`usable_by`
			)
		VALUES
			(
			    $author_id,
			    $update_authors,
				NOW(),
				$is_published,
				$is_trash,
				$access,
				$access_groups,
				$editors,
				$editors_groups,
				$expiration,
				$image,
				$map_image,
				$map_area_shape,
				$map_area_coordinates,
				$is_news,
				$is_flash_news,
				$frontpage_show_full_version,
				$usable_by
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateArticle()
	{
		# update field `update_authors` ###########################################################

		if(count($this->new_data['articles_lang']) > 0) // ak bol zmeneny obsah nazvu, popisu alebo textu
		{
			if(CMS_UserLogin::getSingleton()->isUserLogedIn())
			{
				$update_authors = is_string($this->getUpdateAuthors()) ? unserialize($this->getUpdateAuthors()) : array();

				$user_id = CMS_UserLogin::getSingleton()->getUser()->getId();

				$update_authors[] = array(
											'user_id' => $user_id,
											'user_type' => CMS_UserLogin::getSingleton()->getUserType(),
											'date' => date('Y-m-d H:i:s')
										);

				$this->setUpdateAuthors(serialize($update_authors));
			}
		}

		###########################################################################################

		$author_id = null;
		$update_authors = 'NULL';
		$is_published = $is_trash = $access = $access_groups = $expiration = $image = NULL;
		$map_image = 'NULL';
		$map_area_shape= 'NULL';
		$map_area_coordinates = 'NULL';
		$editors = 'NULL';
		$editors_groups = 'NULL';
		$is_news = false;
		$is_flash_news = false;
		$frontpage_show_full_version = 0;
		$usable_by = CMS_Entity::ENTITY_UNIVERSAL;
		$seo_title = 'NULL';
		$seo_description = 'NULL';
		###########################################################################################

		if(isset($this->new_data['articles']['author_id']))
			$author_id = $this->new_data['articles']['author_id'] === 'NULL' ? 'NULL' : $this->new_data['articles']['author_id'];
		else
			$author_id = $this->current_data['articles']['author_id'] === 'NULL' ? 'NULL' : $this->current_data['articles']['author_id'];

		if(isset($this->new_data['articles']['update_authors']))
			$update_authors = $this->new_data['articles']['update_authors'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['update_authors']}'";
		else
			$update_authors = $this->current_data['articles']['update_authors'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles']['update_authors']}'";

		if(isset($this->new_data['articles']['is_published']))
			$is_published = $this->new_data['articles']['is_published'] === 'NULL' ? 1 : (int)$this->new_data['articles']['is_published'];
		else
			$is_published = $this->current_data['articles']['is_published'] === 'NULL' ? 1 : (int)$this->current_data['articles']['is_published'];

		if(isset($this->new_data['articles']['is_trash']))
			$is_trash = $this->new_data['articles']['is_trash'] === 'NULL' ? 0 : (int)$this->new_data['articles']['is_trash'];
		else
			$is_trash = $this->current_data['articles']['is_trash'] === 'NULL' ? 0 : (int)$this->current_data['articles']['is_trash'];

		if(isset($this->new_data['articles']['access']))
			$access = $this->new_data['articles']['access'] === 'NULL' ? CMS::ACCESS_PUBLIC : $this->new_data['articles']['access'];
		else
			$access = $this->current_data['articles']['access'] === 'NULL' ? CMS::ACCESS_PUBLIC : $this->current_data['articles']['access'];

		if(isset($this->new_data['articles']['access_groups']))
			$access_groups = $this->new_data['articles']['access_groups'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['access_groups']}'";
		else
			$access_groups = $this->current_data['articles']['access_groups'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles']['access_groups']}'";

		if(isset($this->new_data['articles']['editors']))
			$editors = $this->new_data['articles']['editors'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['editors']}'";
		else
			$editors = $this->current_data['articles']['editors'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles']['editors']}'";

		if(isset($this->new_data['articles']['editors_groups']))
			$editors_groups = $this->new_data['articles']['editors_groups'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['editors_groups']}'";
		else
			$editors_groups = $this->current_data['articles']['editors_groups'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles']['editors_groups']}'";

		if(isset($this->new_data['articles']['expiration']))
			$expiration = $this->new_data['articles']['expiration'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['expiration']}'";
		else
			$expiration = $this->current_data['articles']['expiration'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles']['expiration']}'";

		if(isset($this->new_data['articles']['image']))
			$image = $this->new_data['articles']['image'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['image']}'";
		else
			$image = $this->current_data['articles']['image'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles']['image']}'";
			
		if(isset($this->new_data['articles']['map_image']))
			$map_image = $this->new_data['articles']['map_image'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['map_image']}'";
		else
			$map_image = $this->current_data['articles']['map_image'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles']['map_image']}'";

		if(isset($this->new_data['articles']['map_area_shape']))
			$map_area_shape = $this->new_data['articles']['map_area_shape'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['map_area_shape']}'";
		else
			$map_area_shape = $this->current_data['articles']['map_area_shape'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles']['map_area_shape']}'";		
			
		if(isset($this->new_data['articles']['map_area_coordinates']))
			$map_area_coordinates = $this->new_data['articles']['map_area_coordinates'] === 'NULL' ? 'NULL' : "'{$this->new_data['articles']['map_area_coordinates']}'";
		else
			$map_area_coordinates = $this->current_data['articles']['map_area_coordinates'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles']['map_area_coordinates']}'";

		if(isset($this->new_data['articles']['is_news']))
			$is_news = $this->new_data['articles']['is_news'] === 'NULL' ? (int)$is_news : (int)$this->new_data['articles']['is_news'];
		else
			$is_news = $this->current_data['articles']['is_news'] === 'NULL' ? (int)$is_news : (int)$this->current_data['articles']['is_news'];

		if(isset($this->new_data['articles']['is_flash_news']))
			$is_flash_news = $this->new_data['articles']['is_flash_news'] === 'NULL' ? (int)$is_flash_news : (int)$this->new_data['articles']['is_flash_news'];
		else
			$is_flash_news = $this->current_data['articles']['is_flash_news'] === 'NULL' ? (int)$is_flash_news : (int)$this->current_data['articles']['is_flash_news'];
			
		if(isset($this->new_data['articles']['frontpage_show_full_version']))
			$frontpage_show_full_version = $this->new_data['articles']['frontpage_show_full_version'] === 'NULL' ? (int)$frontpage_show_full_version : (int)$this->new_data['articles']['frontpage_show_full_version'];
		else
			$frontpage_show_full_version = $this->current_data['articles']['frontpage_show_full_version'] === 'NULL' ? (int)$frontpage_show_full_version : (int)$this->current_data['articles']['frontpage_show_full_version'];

		if(isset($this->new_data['articles']['usable_by']))
			$usable_by = $this->new_data['articles']['usable_by'] === 'NULL' ? $usable_by : $this->new_data['articles']['usable_by'];
		else
			$usable_by = $this->current_data['articles']['usable_by'] === 'NULL' ? $usable_by : $this->current_data['articles']['usable_by'];


		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`articles`
		SET
			`author_id` = $author_id,
			`update_authors` = $update_authors,
			`is_published` = $is_published,
			`is_trash` = $is_trash,
			`access` = $access,
			`access_groups` = $access_groups,
			`editors` = $editors,
			`editors_groups` = $editors_groups,
			`expiration` = $expiration,
			`image` = $image,
			`map_image` = $map_image,
			`map_area_shape` = $map_area_shape,
			`map_area_coordinates` = $map_area_coordinates,
			`is_news` = $is_news,
			`is_flash_news` = $is_flash_news,
			`frontpage_show_full_version` = $frontpage_show_full_version,
			`usable_by` = $usable_by
		WHERE
			`id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
		

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function alterLanguageVersions()
	{
		$title = $description = $text = $quick_help = $language_is_visible = null;
		$frontpage_language_is_visible = null;

		foreach($this->new_data['articles_lang'] as $language => $language_version)
		{
			if(isset($language_version['title']))
				$title = $language_version['title'] === 'NULL' ? "''" : "'{$language_version['title']}'";
			elseif(isset($this->current_data['articles_lang'][$language]['title']))
				$title = $this->current_data['articles_lang'][$language]['title'] == 'NULL' ? "''" : "'{$this->current_data['articles_lang'][$language]['title']}'";
			else
				$title = "''";

			if(isset($language_version['description']))
				$description = $language_version['description'] === 'NULL' ? 'NULL' : "'{$language_version['description']}'";
			elseif(isset($this->current_data['articles_lang'][$language]['description']))
				$description = $this->current_data['articles_lang'][$language]['description'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles_lang'][$language]['description']}'";
			else
				$description = 'NULL';

			if(isset($language_version['text']))
				$text = $language_version['text'] === 'NULL' ? "''" : "'".$language_version['text']."'";
			elseif(isset($this->current_data['articles_lang'][$language]['text']))
				$text = $this->current_data['articles_lang'][$language]['text'] === 'NULL' ? "''" : "'".$this->current_data['articles_lang'][$language]['text']."'";
			else
				$text = "''";

			if(isset($language_version['quick_help']))
				$quick_help = $language_version['quick_help'] === 'NULL' ? 'NULL' : "'{$language_version['quick_help']}'";
			elseif(isset($this->current_data['articles_lang'][$language]['quick_help']))
				$quick_help = $this->current_data['articles_lang'][$language]['quick_help'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles_lang'][$language]['quick_help']}'";
			else
				$quick_help = 'NULL';

			if(isset($language_version['language_is_visible']))
				$language_is_visible = $language_version['language_is_visible'] === 'NULL' ? 0 : $language_version['language_is_visible'];
			elseif(isset($this->current_data['articles_lang'][$language]['language_is_visible']))
				$language_is_visible = $this->current_data['articles_lang'][$language]['language_is_visible'] === 'NULL' ? 0 : $this->current_data['articles_lang'][$language]['language_is_visible'];
			else
				$language_is_visible = 0;
				
			if(isset($language_version['frontpage_language_is_visible']))
				$frontpage_language_is_visible = $language_version['frontpage_language_is_visible'] === 'NULL' ? 1 : $language_version['frontpage_language_is_visible'];
			elseif(isset($this->current_data['articles_lang'][$language]['frontpage_language_is_visible']))
				$frontpage_language_is_visible = $this->current_data['articles_lang'][$language]['frontpage_language_is_visible'] === 'NULL' ? 1 : $this->current_data['articles_lang'][$language]['frontpage_language_is_visible'];
			else
				$frontpage_language_is_visible = 1;


			if(isset($language_version['seo_title']))
				$seo_title = $language_version['seo_title'] === 'NULL' ? 'NULL' : "'{$language_version['seo_title']}'";
			elseif(isset($this->current_data['articles_lang'][$language]['seo_title']))
				$seo_title = $this->current_data['articles_lang'][$language]['seo_title'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles_lang'][$language]['seo_title']}'";
			else
				$seo_title = 'NULL';
				
			if(isset($language_version['seo_description']))
				$seo_description = $language_version['seo_description'] === 'NULL' ? 'NULL' : "'{$language_version['seo_description']}'";
			elseif(isset($this->current_data['articles_lang'][$language]['seo_description']))
				$seo_description = $this->current_data['articles_lang'][$language]['seo_description'] === 'NULL' ? 'NULL' : "'{$this->current_data['articles_lang'][$language]['seo_description']}'";
			else
				$seo_description = 'NULL';


			#######################################################################################

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				articles_lang
			WHERE
				article_id = {$this->id} AND
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
					`articles_lang`
					(
						`article_id`,
						`language`,
						`title`,
						`description`,
						`text`,
						`quick_help`,
						`language_is_visible`,
						`frontpage_language_is_visible`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$title,
						$description,
						$text,
						$quick_help,
						$language_is_visible,
						$frontpage_language_is_visible
					)
SQL;
			}
			elseif($record_count == 1)
			{
				$sql =<<<SQL
				UPDATE
					`articles_lang`
				SET
					`title` = $title,
					`description` = $description,
					`text` = $text,
					`quick_help` = $quick_help,
					`language_is_visible` = $language_is_visible,
					`frontpage_language_is_visible` = $frontpage_language_is_visible
				WHERE
					`article_id`={$this->id} AND
					`language`='$language'
SQL;
			}
			else
				die('haluz'); // throw

			$query = new CN_SqlQuery($sql);
			$query->execute();

			//echo $record_count;exit;
			/******** SEO *****/
			if($record_count == 1 && CMS_ProjectConfig::getSingleton()->isSeoArticle())
			{
				$sql =<<<SQL
				UPDATE
					`articles_lang`
				SET
					`seo_title` = $seo_title,
					`seo_description` = $seo_description
				WHERE
					`article_id` = {$this->id} AND
					`language`='$language'
SQL;
				$query = new CN_SqlQuery($sql);
				$query->execute();

			}
		
			#######################################################################################

			$title = $description = $text = $quick_help = $language_is_visible = null;
			$frontpage_language_is_visible = null;
		}

		$this->readData(CMS::READ_LANG_DATA);
	}

###################################################################################################
# public static
###################################################################################################

	public static function fulltextSearch($expression, $offset=null, $limit=null, $displayable_only=false, $language=null, $execute=true)
	{
		$article_list = new CMS_ArticleList($offset, $limit);
		$article_list->setTableName('articles, articles_lang');
		$article_list->setIdColumnName('article_id');
		$article_list->setSortBy('id');
		$article_list->setSortDirection(CMS_EntityList::DIRECTION_DESCENDING);

		$article_list->addCondition('`article_id` = `id`', null, null, true);
		$article_list->addCondition('usable_by', CMS_Entity::ENTITY_UNIVERSAL);
		//$article_list->addCondition("MATCH (`title`, `description`, `text`)", "AGAINST ('$expression' IN BOOLEAN MODE)", null, true);
		$article_list->addCondition("(`title` LIKE '%$expression%' OR `description` LIKE '%$expression%' OR `text` LIKE '%$expression%')", null, null, true);

		if(!is_null($language))
			$article_list->addCondition('language', "'$language'");
		else
			$article_list->addCondition('language', "'".CN_Application::getSingleton()->getLanguage()."'");

		if($displayable_only === true)
		{
			$article_list->addCondition('language_is_visible', 1);			
		
			$article_list->addCondition('is_trash', 0);
			$article_list->addCondition('is_archive', 0);
			$article_list->addCondition('is_published', 1);
			$article_list->addCondition('(`expiration` >= CURRENT_DATE OR `expiration` IS NULL OR `expiration` = \'0000-00-00 00:00:00\') ', null, null, true);

			if(CMS_UserLogin::getSingleton()->isUserLogedIn() === true)
				$article_list->addCondition('(`access` = '.CMS::ACCESS_PUBLIC.' OR `access` = '.CMS::ACCESS_REGISTERED.')', null, null, true);
			else
				$article_list->addCondition('access', CMS::ACCESS_PUBLIC);

			$article_list->addCondition('language_is_visible', 1);
		}

		if($execute === true)
			$article_list->execute();

		return $article_list;
	}
	
	public function getSeoTitle($language='sk')
	{
        return '';
		###########################################################################################
		//$language = CN_Application::getSingleton()->getLanguage();

		$sql =<<<SQL
			Select `seo_title`
			FROM
				`articles_lang`
			WHERE
				`article_id` = {$this->id} AND
				`language`='$language'
SQL;
					
		$query = new CN_SqlQuery($sql);
		$query->execute();

		return $query->fetchValue();
	}
	
	public function getSeoDescription($language)
	{

		###########################################################################################
		//$language = CN_Application::getSingleton()->getLanguage();

		$sql =<<<SQL
			Select `seo_description`
			FROM
				`articles_lang`
			WHERE
				`article_id` = {$this->id} AND
				`language`='$language'
SQL;
					
		$query = new CN_SqlQuery($sql);
		$query->execute();

		return $query->fetchValue();
	}	
	
	public function updateSeo($seo_title,$seo_description,$language)
	{	
	
		$sql =<<<SQL
		UPDATE
			`articles_lang`
		SET
			`seo_title` = '$seo_title',
			`seo_description` = '$seo_description'
		WHERE
			`article_id` = {$this->id} AND
			`language`='$language'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}					
}

endif;

?>