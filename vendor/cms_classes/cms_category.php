<?php

if(!defined('CMS_CATEGORY_PHP')):
	define('CMS_CATEGORY_PHP', true);

/**
 *
 * Reprezentuje jednu kategoriu.
 * Obsahuje metody na pristup k hodnotam jednotlivych stlpcov.
 *
 * @package Core
 * @subpackage Categories
 */

class CMS_Category extends CMS_Entity
{
	const ENTITY_ID = 1;

###################################################################################################
# public
###################################################################################################

	/**
	 * Default konstruktor.
	 *
	 * @param mixed $category_id - cislo alebo nazov kategorie
	 */
	public function __construct($category_id=NULL)
	{
		$this->compound_tables['main_table'] = 'categories';
		$this->compound_tables['lang_table'] = 'categories_lang';

		$this->id_column_name = 'category_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $category_id);
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
		$query = new CN_SqlQuery("UPDATE `categories` SET `is_trash` = 1 WHERE `id` = {$this->id}");
		$query->execute();

		$this->setIsTrash(true);
	}

	public function restore()
	{
		$query = new CN_SqlQuery("UPDATE `categories` SET `is_trash` = 0 WHERE `id` = {$this->id}");
		$query->execute();

		$this->setIsTrash(false);
	}

###################################################################################################

	public function isDisplayable()
	{
		if(($this->getIsPublished() != 1) || ($this->getIsTrash() == 1))
			return false;

		if(!isset($this->current_data[$this->lang_table][$this->context_language]) || $this->getLanguageIsVisible() == 0)
			return false;

		if(CMS_UserLogin::getSingleton()->isUserLogedIn() !== true)
		{
			if($this->getAccess() === CMS::ACCESS_REGISTERED)
				return false;
		}

		###########################################################################################

		$category = $this;

		while($parent = $category->getParent())
		{
			if(!$parent->isDisplayable())
				return false;

			$category = $parent;
		}

		###########################################################################################

		return true;
	}

	public function getPath($displayable_only=true)
	{
		$path = array();

		###########################################################################################

		$category = $this;

		while($parent = $category->getParent())
		{
			if($displayable_only === true)
			{
				if($parent->isDisplayable())
					$path[$this->type][] = $parent;
			}
			else
				$path[$this->type][] = $parent;

			$category = $parent;
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

		###########################################################################################

		if(isset($path[$this->type]) && count($path[$this->type]) > 0)
		{
			$path[$this->type] = array_reverse($path[$this->type]);

			return $path;
		}
		else
			return null;
	}

###################################################################################################

	public function getItems($item_type=null, $displayable_only=false, $offset=null, $limit=null, $execute=true, $sort_direction=null)
	{
	  if(is_null($sort_direction))
      $sort_direction = CMS_EntityList::DIRECTION_ASCENDING;

		$vector = new CN_Vector();

		###########################################################################################

		$where_token = "";

		if(!is_null($item_type))
		{
			$entity_table_name = null;
			$list_class_name = null;

			$display_conditions = null;
			$remove_conditions = array();

			$language = $this->context_language ;//== CN_Application::getSingleton()->getLanguage() or is_null($this->context_language);

			#######################################################################################

			switch($item_type)
			{
				case self::ENTITY_ID:
					$entity_table_name = 'categories, categories_lang';
					$list_class_name = 'CMS_CategoryList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, '`id` = `item_id`' => true, 'categories_lang.category_id=item_id' => true, 'language' => "'$language'", 'language_is_visible' => 1);
					break;

				case CMS_Article::ENTITY_ID:
					$entity_table_name = 'articles, articles_lang';
					$list_class_name = 'CMS_ArticleList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, 'is_archive' => 0, '(`expiration` >= NOW() OR `expiration` IS NULL)' => true, '`id` = `item_id`' => true, '`article_id` = `item_id`' => true, 'language' => "'$language'", 'language_is_visible' => 1);
					break;

				case CMS_Weblink::ENTITY_ID:
					$entity_table_name = 'weblinks, weblinks_lang';
					$list_class_name = 'CMS_WeblinkList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, '`id` = `item_id`' => true, 'weblinks_lang.weblink_id=item_id' => true, 'language' => "'$language'", 'language_is_visible' => 1);
					break;

				// modules and entities

				case 101:
					$entity_table_name = 'catalog_products, catalog_products_lang';
					$list_class_name = 'CMS_Catalog_ProductList';
					$display_conditions = array('is_published' => 1, '(NOW() BETWEEN `valid_from` AND `valid_to` OR (`valid_from` IS NULL AND `valid_to` IS NULL))' => true, '`id` = `catalog_products_lang`.`product_id`' => true, 'language' => "'$language'", 'language_is_visible' => 1);
					break;
				// branch
				case 104:
					$entity_table_name = 'categories, categories_lang';
					$list_class_name = 'CMS_Catalog_BranchList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, '`id` = `categories_lang`.`category_id`' => true, 'language' => "'$language'", 'language_is_visible' => 1);
					$remove_conditions = array('usable_by');
					break;
				// attributes for attributeGroup
				case 103:
					$entity_table_name = 'categories, categories_lang';
					$list_class_name = 'CMS_Catalog_AttributeDefinitionList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, '`id` = `categories_lang`.`category_id`' => true, 'language' => "'$language'", 'language_is_visible' => 1);
					$remove_conditions = array('usable_by');
					break;

				case 141:
					$entity_table_name = 'job_offer_ads';
					$list_class_name = 'CMS_Job_OfferAdList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, 'NOW() BETWEEN `valid_from` AND `valid_to`' => true);
					break;

				case 142:
					$entity_table_name = 'job_search_ads';
					$list_class_name = 'CMS_Job_SearchAdList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, 'NOW() BETWEEN `valid_from` AND `valid_to`' => true);
					break;

				case 270:
					$entity_table_name = 'configurator_configurators';
					$list_class_name = 'CMS_ConfiguratorList';
					$display_conditions = array('is_published' => 1);
					$remove_conditions = array('access');
					break;
			}

			#######################################################################################

			$list = new $list_class_name($offset, $limit);
			$list->setTableName('categories_bindings');
			$list->setIdColumnName('item_id');
			$list->setSortBy('item_id');

			$list->addCondition("categories_bindings.category_id = {$this->id}", null, null, true);
			$list->addCondition('item_type', $item_type);

			foreach($remove_conditions as $condition)
				$list->removeCondition($condition);

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
			`categories_bindings`
		WHERE
			`category_id` = {$this->id}
			$where_token
		ORDER BY `order` $sort_direction
SQL;

		if (!is_null($offset) && !is_null($limit))
			$sql .= " LIMIT $offset, $limit";

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		while($query->next())
		{
			$record = $query->fetchRecord();

			#######################################################################################

			$class_name = CMS_Entity::getEntitynameById($record->getValue('item_type'));

			$item = new $class_name($record->getValue('item_id'));

			if($displayable_only === true)
			{
				if($item->isDisplayable())
					$vector->append($item);
			}
			else
				$vector->append($item);

			/*switch($record->getValue('item_type'))
			{
				case self::ENTITY_ID:
					$category = new CMS_Category($record->getValue('item_id'));

					if($displayable_only === true)
					{
						if($category->isDisplayable())
							$vector->append($category);
					}
					else
						$vector->append($category);

					break;

				case CMS_Article::ENTITY_ID:
					$article = new CMS_Article($record->getValue('item_id'));

					if($displayable_only === true)
					{
						if($article->isDisplayable())
							$vector->append($article);
					}
					else
						$vector->append($article);

					break;

				case CMS_Weblink::ENTITY_ID:
					$weblink = new CMS_Weblink($record->getValue('item_id'));

					if($displayable_only === true)
					{
						if($weblink->isDisplayable())
							$vector->append($weblink);
					}
					else
						$vector->append($weblink);
					break;


				// not good
				case 141:
					$entity = new CMS_Job_Search_Ad($record->getValue('item_id'));

					if($displayable_only === true)
					{
						if($entity->isDisplayable())
							$vector->append($entity);
					}
					else
						$vector->append($entity);
					break;

				case 142:
					$entity = new CMS_Job_Search_Ad($record->getValue('item_id'));

					if($displayable_only === true)
					{
						if($entity->isDisplayable())
							$vector->append($entity);
					}
					else
						$vector->append($entity);
					break;

				default:
					throw new CN_Exception(sprintf(tr("V tabulke `categories_binding` je neplatny zaznam: `item_type` = %s"), $record->getValue('item_type')));
			}*/
		}

		###########################################################################################

		return $vector;
	}

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
			`categories_bindings`
		WHERE
			`category_id` = {$this->id} AND
			`item_id` = {$item->getId()} AND
			`item_type` = $item_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

	public function addItem($item)
	{
		if(!is_subclass_of($item, 'CMS_Entity'))
			throw new CN_Exception(tr("\$item must be some subclass of CMS_Entity."));

		$item_type = $item->getType();
		$order = null;

		###########################################################################################

		if($item instanceof CMS_Category)
		{
			if($this->id == $item->getId())
				throw new CN_Exception(tr("Kategoria nemoze byt navazbena sama v sebe."));
		}

		###########################################################################################

		$sql = <<<SQL
		SELECT
			MAX(`order`)
		FROM
			`categories_bindings`
		WHERE
			`category_id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$order = $query->fetchValue() + 1;

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`categories_bindings`
			(
				`category_id`,
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
			`categories_bindings`
		WHERE
			`category_id` = {$this->id} AND
			`item_id` = {$item->getId()} AND
			`item_type` = $item_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		$this->fixOrder($this->id);
	}

###################################################################################################
# template handling ###############################################################################

	public function getTemplates($offset=null, $limit=null, $execute=true)
	{
		$template_list = new CMS_TemplateList($offset, $limit);
		$template_list->setTableName('templates_bindings');
		$template_list->addCondition('entity_id', $this->id);
		$template_list->addCondition('entity_type', $this->type);

		if($execute === true)
			$template_list->execute();

		return $template_list;
	}

	public function addTemplate(CMS_Template $template)
	{
		$sql =<<<SQL
		INSERT INTO
			`templates_bindings`
			(
				`entity_id`,
				`entity_type`,
				`template_id`
			)
		VALUES
			(
				{$this->id},
				{$this->type},
				'{$template->getId()}'
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeTemplate(CMS_Template $template)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`templates_bindings`
		WHERE
			`entity_id` = {$this->id} AND
			`entity_type` = {$this->type} AND
			`template_id` = '{$template->getId()}'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################
# parent handling #################################################################################

	/**
	 * Zisti ci ma kategoria rodica.
	 *
	 * @return bool
	 */
	public function hasParent()
	{
		$query = new CN_SqlQuery("SELECT COUNT(*) FROM `categories_bindings` WHERE `item_id` = {$this->id} AND (`item_type` = ".CMS_Category::ENTITY_ID." OR `item_type`={$this->type})");
		$query->execute();

		return ($query->fetchValue() > 0);
	}

	public function getParent($id_only=false)
	{
		$class_name = CMS_Entity::getEntityNameById($this->type);

		$query = new CN_SqlQuery("SELECT * FROM `categories_bindings` WHERE `item_id` = {$this->id} AND (`item_type` = ".CMS_Category::ENTITY_ID." OR `item_type`={$this->type})");
		$query->execute();

		if($query->getSize() == 1)
		{
			if($id_only === true)
				return $query->fetchValue("category_id");
			else
				return new $class_name($query->fetchValue("category_id"));
		}
		elseif($query->getSize() == 0)
			return null;
		else
			throw new CN_Exception(sprintf(tr("Kategoria `id = %s` ma viac ako jedneho rodica."), $this->id));
	}

###################################################################################################

	/**
	 * Zisti ci ma kategoria potomkov.
	 *
	 * @return bool
	 */
	public function hasChildren()
	{
		$query = new CN_SqlQuery("SELECT COUNT(*) FROM `categories_bindings` WHERE `category_id` = {$this->id}");
		$query->execute();

		return ($query->fetchValue() > 0);
	}

	/**
	 * Vrati zoznam objektov vsetkych potomkov.
	 *
	 * @return CN_Vector $object_list
	 */
	public function getChildren($displayable_only=false)
	{
		$child_list = new CN_Vector();

		###########################################################################################

		$category_type = CMS_Category::ENTITY_ID;

		$sql =<<<SQL
		SELECT
			*
		FROM
			`categories_bindings`
		WHERE
			`category_id` = {$this->id} AND
			(
				`item_type` = {$this->type}
				OR
				`item_type` = $category_type

			)
		ORDER BY
			`order`
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$category = new CMS_Category($record->getValue('item_id'));

			if($displayable_only === true)
			{
				if($category->isDisplayable())
					$child_list->append($category);
			}
			else
				$child_list->append($category);
		}

		###########################################################################################

		return $child_list;
	}

###################################################################################################

	public function getMenuList($id_only=false)
	{
		$menu_list = new CN_Vector();

		###########################################################################################

		$query = new CN_SqlQuery("SELECT `menu_id` FROM `menus_bindings` WHERE `item_type` = {$this->getType()} AND item_id={$this->id}");
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
	public function moveToTopInCategory()
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
	public function moveToBottomInCategory()
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
###################################################################################################

	/**
	 * Ulozi vsetky zmeny v hodnotach do databazy.
	 *
	 * @return void
	 */
	public function save()
	{
		if(is_null($this->id))
			$this->insertCategory();
		else
			$this->updateCategory();

		$this->alterLanguageVersions();
	}

	/**
	 * Odtrani kategoriu a vsetky vazby z databazy.
	 *
	 * @return void
	 */
	public function delete()
	{

		# gallery bindings ########################################################################

		if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_Gallery') === true)
		{
			$gallery_list = $this->getGalleries();

			foreach($gallery_list as $gallery)
				$this->removeGallery($gallery);
		}

		# template bindings #######################################################################

		$query = new CN_SqlQuery("DELETE FROM `templates_bindings` WHERE `entity_id` = {$this->id} AND `entity_type` = {$this->type}");
		$query->execute();

		###########################################################################################

		{
			$menu_list = $this->getMenuList(true);

			#######################################################################################

			$query = new CN_SqlQuery("DELETE FROM `menus_bindings` WHERE `item_id`={$this->id} AND `item_type` = {$this->type}");
			$query->execute();

			#######################################################################################

			$iterator = new CN_VectorIterator($menu_list);

			foreach($iterator as $menu_id)
				CMS_Menu::fixMenuOrder($menu_id);
		}

		###########################################################################################

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

			if($query->getSize() > 0)
			{
				$parent_id = $query->fetchValue('category_id');

				$sql =<<<SQL
				DELETE
				FROM
					`categories_bindings`
				WHERE
					`item_id` = {$this->id} AND
					`item_type` = {$this->type}
SQL;

				$query = new CN_SqlQuery($sql);
				$query->execute();

				$this->fixOrder($parent_id);
			}
		}

		# main bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `categories_bindings` WHERE `category_id` = {$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `categories_lang` WHERE category_id={$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `categories` WHERE `id` = {$this->id}");
		$query->execute();

		$this->id = null;
		$this->current_data = null;
		$this->new_data = null;
	}

###################################################################################################
# private
###################################################################################################

	private function insertCategory()
	{
		$author_id = 'NULL';
		$is_published = 1;
		$is_trash = 0;
		$access = CMS::ACCESS_PUBLIC;
		$access_groups = 'NULL';
		$editors = 'NULL';
		$image = 'NULL';
		$map_image = 'NULL';
		$map_area_shape= 'NULL';
		$map_area_coordinates = 'NULL';
		$usable_by = self::ENTITY_UNIVERSAL;

		###########################################################################################

		if(isset($this->new_data['categories']['author_id']))
			$author_id = $this->new_data['categories']['author_id'] === 'NULL' ? $author_id : $this->new_data['categories']['author_id'];
		if(isset($this->new_data['categories']['is_published']))
			$is_published = $this->new_data['categories']['is_published'] === 'NULL' ? 1 : (int)$this->new_data['categories']['is_published'];
		if(isset($this->new_data['categories']['is_trash']))
			$is_trash = $this->new_data['categories']['is_trash'] === 'NULL' ? 0 : (int)$this->new_data['categories']['is_trash'];
		if(isset($this->new_data['categories']['access']))
			$access = $this->new_data['categories']['access'] === 'NULL' ? CMS::ACCESS_PUBLIC : $this->new_data['categories']['access'];
		if(isset($this->new_data['categories']['access_groups']))
			$access_groups = $this->new_data['categories']['access_groups'] === 'NULL' ? 'NULL' : "'{$this->new_data['categories']['access_groups']}'";
		if(isset($this->new_data['categories']['editors']))
			$editors = $this->new_data['categories']['editors'] === 'NULL' ? 'NULL' : "'{$this->new_data['categories']['editors']}'";
		if(isset($this->new_data['categories']['image']))
			$image = $this->new_data['categories']['image'] === 'NULL' ? 'NULL' : "'{$this->new_data['categories']['image']}'";
		if(isset($this->new_data['categories']['map_image']))
			$map_image = $this->new_data['categories']['map_image'] === 'NULL' ? 'NULL' : "'{$this->new_data['categories']['map_image']}'";
		if(isset($this->new_data['categories']['map_area_shape']))
			$map_area_shape = $this->new_data['categories']['map_area_shape'] === 'NULL' ? 'NULL' : "'{$this->new_data['categories']['map_area_shape']}'";
		if(isset($this->new_data['categories']['map_area_coordinates']))
			$map_area_coordinates = $this->new_data['categories']['map_area_coordinates'] === 'NULL' ? 'NULL' : "'{$this->new_data['categories']['map_area_coordinates']}'";
		if(isset($this->new_data['categories']['usable_by']))
			$usable_by = $this->new_data['categories']['usable_by'] === 'NULL' ? $usable_by : $this->new_data['categories']['usable_by'];

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`categories`
			(
				`creation`,
				`author_id`,
				`is_published`,
				`is_trash`,
				`access`,
				`access_groups`,
				`editors`,
				`image`,
				`map_image`,
				`map_area_shape`,
				`map_area_coordinates`,
				`usable_by`
			)
		VALUES
			(
				NOW(),
				$author_id,
				$is_published,
				$is_trash,
				$access,
				$access_groups,
				$editors,
				$image,
				$map_image,
				$map_area_shape,
				$map_area_coordinates,
				$usable_by
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateCategory()
	{
		$author_id = 'NULL';
		$is_published = 1;
		$is_trash = 0;
		$access = CMS::ACCESS_PUBLIC;
		$access_groups = 'NULL';
		$editors = 'NULL';
		$image = 'NULL';
		$map_image = 'NULL';
		$map_area_shape= 'NULL';
		$map_area_coordinates = 'NULL';
		$usable_by = self::ENTITY_UNIVERSAL;

		############################################################################################

		if(isset($this->new_data['categories']['author_id']))
			$author_id = $this->new_data['categories']['author_id'] === 'NULL' ? $author_id : $this->new_data['categories']['author_id'];
		else
			$author_id = $this->current_data['categories']['author_id'] === 'NULL' ? $author_id : $this->current_data['categories']['author_id'];

		if(isset($this->new_data['categories']['is_published']))
			$is_published = $this->new_data['categories']['is_published'] === 'NULL' ? 1 : (int)$this->new_data['categories']['is_published'];
		else
			$is_published = $this->current_data['categories']['is_published'] === 'NULL' ? 1 : (int)$this->current_data['categories']['is_published'];

		if(isset($this->new_data['categories']['is_trash']))
			$is_trash = $this->new_data['categories']['is_trash'] === 'NULL' ? 0 : (int)$this->new_data['categories']['is_trash'];
		else
			$is_trash = $this->current_data['categories']['is_trash'] === 'NULL' ? 0 : (int)$this->current_data['categories']['is_trash'];

		if(isset($this->new_data['categories']['access']))
			$access = $this->new_data['categories']['access'] === 'NULL' ? CMS::ACCESS_PUBLIC : $this->new_data['categories']['access'];
		else
			$access = $this->current_data['categories']['access'] === 'NULL' ? CMS::ACCESS_PUBLIC : $this->current_data['categories']['access'];

		if(isset($this->new_data['categories']['access_groups']))
			$access_groups = $this->new_data['categories']['access_groups'] === 'NULL' ? 'NULL' : "'{$this->new_data['categories']['access_groups']}'";
		else
			$access_groups = $this->current_data['categories']['access_groups'] === 'NULL' ? 'NULL' : "'{$this->current_data['categories']['access_groups']}'";

		if(isset($this->new_data['categories']['editors']))
			$editors = $this->new_data['categories']['editors'] === 'NULL' ? 'NULL' : "'{$this->new_data['categories']['editors']}'";
		else
			$editors = $this->current_data['categories']['editors'] === 'NULL' ? 'NULL' : "'{$this->current_data['categories']['editors']}'";

		if(isset($this->new_data['categories']['image']))
			$image = $this->new_data['categories']['image'] === 'NULL' ? 'NULL' : "'{$this->new_data['categories']['image']}'";
		else
			$image = $this->current_data['categories']['image'] === 'NULL' ? 'NULL' : "'{$this->current_data['categories']['image']}'";

		if(isset($this->new_data['categories']['map_image']))
			$map_image = $this->new_data['categories']['map_image'] === 'NULL' ? 'NULL' : "'{$this->new_data['categories']['map_image']}'";
		else
			$map_image = $this->current_data['categories']['map_image'] === 'NULL' ? 'NULL' : "'{$this->current_data['categories']['map_image']}'";

		if(isset($this->new_data['categories']['map_area_shape']))
			$map_area_shape = $this->new_data['categories']['map_area_shape'] === 'NULL' ? 'NULL' : "'{$this->new_data['categories']['map_area_shape']}'";
		else
			$map_area_shape = $this->current_data['categories']['map_area_shape'] === 'NULL' ? 'NULL' : "'{$this->current_data['categories']['map_area_shape']}'";

		if(isset($this->new_data['categories']['map_area_coordinates']))
			$map_area_coordinates = $this->new_data['categories']['map_area_coordinates'] === 'NULL' ? 'NULL' : "'{$this->new_data['categories']['map_area_coordinates']}'";
		else
			$map_area_coordinates = $this->current_data['categories']['map_area_coordinates'] === 'NULL' ? 'NULL' : "'{$this->current_data['categories']['map_area_coordinates']}'";

		if(isset($this->new_data['categories']['usable_by']))
			$usable_by = $this->new_data['categories']['usable_by'] === 'NULL' ? $usable_by : $this->new_data['categories']['usable_by'];
		else
			$usable_by = $this->current_data['categories']['usable_by'] === 'NULL' ? $usable_by : $this->current_data['categories']['usable_by'];

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`categories`
		SET
			`is_published` = $is_published,
			`is_trash` = $is_trash,
			`access` = $access,
			`access_groups` = $access_groups,
			`editors` = $editors,
			`image` = $image,
			`map_image` = $map_image,
			`map_area_shape` = $map_area_shape,
			`map_area_coordinates` = $map_area_coordinates,
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
		$title = $description = $quick_help = $language_is_visible = null;
		$localized_image = 'NULL';

		foreach($this->new_data['categories_lang'] as $language => $language_version)
		{
			if(isset($language_version['title']))
				$title = $language_version['title'] === 'NULL' ? 'NULL' : "'{$language_version['title']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['title']))
				$title = $this->current_data[$this->lang_table][$language]['title'] == 'NULL' ? 'NULL' : "'{$this->current_data[$this->lang_table][$language]['title']}'";
			else
				$title = "''";

			if(isset($language_version['description']))
				$description = $language_version['description'] === 'NULL' ? 'NULL' : "'{$language_version['description']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['description']))
				$description = $this->current_data[$this->lang_table][$language]['description'] === 'NULL' ? 'NULL' : "'{$this->current_data['categories_lang'][$language]['description']}'";
			else
				$description = 'NULL';

			if(isset($language_version['quick_help']))
				$quick_help = $language_version['quick_help'] === 'NULL' ? 'NULL' : "'{$language_version['quick_help']}'";
			elseif(isset($this->current_data['categories_lang'][$language]['quick_help']))
				$quick_help = $this->current_data['categories_lang'][$language]['quick_help'] === 'NULL' ? 'NULL' : "'{$this->current_data['categories_lang'][$language]['quick_help']}'";
			else
				$quick_help = 'NULL';

			if(isset($language_version['language_is_visible']))
				$language_is_visible = $language_version['language_is_visible'] === 'NULL' ? 0 : $language_version['language_is_visible'];
			elseif(isset($this->current_data['categories_lang'][$language]['language_is_visible']))
				$language_is_visible = $this->current_data['categories_lang'][$language]['language_is_visible'] === 'NULL' ? 1 : $this->current_data['categories_lang'][$language]['language_is_visible'];
			else
				$language_is_visible = 1;

			if(isset($language_version['localized_image']))
				$localized_image = $language_version['localized_image'] === 'NULL' ? $localized_image : "'{$language_version['localized_image']}'";
			elseif(isset($this->current_data['categories_lang'][$language]['localized_image']))
				$localized_image = $this->current_data['categories_lang'][$language]['localized_image'] === 'NULL' ? $localized_image : "'{$this->current_data['categories_lang'][$language]['localized_image']}'";

			#######################################################################################

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				categories_lang
			WHERE
				category_id = {$this->id} AND
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
					`categories_lang`
					(
						`category_id`,
						`language`,
						`title`,
						`description`,
						`quick_help`,
						`language_is_visible`,
						`localized_image`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$title,
						$description,
						$quick_help,
						$language_is_visible,
						$localized_image
					)
SQL;
			}
			elseif($record_count == 1)
			{
				$sql =<<<SQL
				UPDATE
					`categories_lang`
				SET
					`title` = $title,
					`description` = $description,
					`quick_help` = $quick_help,
					`language_is_visible` = $language_is_visible,
					`localized_image` = $localized_image
				WHERE
					`category_id` = {$this->id} AND
					`language` = '$language'
SQL;
			}
			else
				throw new CN_Exception(sprintf(tr("There are loose data in table `%1\$s` for `id` %2\$s.", $this->lang_table, $this->id)), E_ERROR);

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$title = $description = $quick_help = $language_is_visible = null;
			$localized_image = 'NULL';
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}

###################################################################################################

	private function fixOrder($category_id)
	{
		$vector = new CN_Vector();

		###########################################################################################

		$query = new CN_SqlQuery("SELECT * FROM `categories_bindings` WHERE `category_id`=$category_id ORDER BY `order`");
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append($record->getValue('item_id'));
		}

		###########################################################################################

		$iterator = new CN_VectorIterator($vector);

		foreach($iterator as $order => $item_id)
		{
			$new_order = $order + 1;

			$query = new CN_SqlQuery("UPDATE `categories_bindings` SET `order`=$new_order WHERE `category_id`=$category_id AND `item_id`=$item_id");
			$query->execute();
		}
	}

###################################################################################################
# public static
###################################################################################################

	public static function fixCategoryOrder($category_id)
	{
		$vector = new CN_Vector();

		###########################################################################################

		$query = new CN_SqlQuery("SELECT * FROM `categories_bindings` WHERE `category_id`=$category_id ORDER BY `order`");
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append($record->getValue('item_id'));
		}

		###########################################################################################

		$iterator = new CN_VectorIterator($vector);

		foreach($iterator as $order => $item_id)
		{
			$new_order = $order + 1;

			$query = new CN_SqlQuery("UPDATE `categories_bindings` SET `order`=$new_order WHERE `category_id`=$category_id AND `item_id`=$item_id");
			$query->execute();
		}
	}


###################################################################################################
# attachments #####################################################################################

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

	public function removeAttachment(CMS_Attachment $attachment)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`attachments_bindings`
		WHERE
			`entity_id` = {$this->id} AND
			`entity_type` = {$this->type} AND
			`attachment_id` = {$attachment->getId()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function getAttachments($offset=null, $limit=null, $execute=true)
	{
		$attachment_list = new CMS_AttachmentList($offset, $limit);
		$attachment_list->setTableName('attachments_bindings');
		$attachment_list->setIdColumnName('attachment_id');
		$attachment_list->addCondition('entity_id', $this->getId());
		$attachment_list->addCondition('entity_type', $this->type);

		if($execute === true)
			$attachment_list->execute();

		return $attachment_list;
	}

	public function attachmentExists(CMS_Attachment $attachment)
	{
		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`attachments`
		WHERE
			(
				`entity_id` = {$this->id} AND
				`entity_type` = {$this->type}
			)
			AND
			(
				`attachment_id` = {$attachment->getId()} AND
				`attachment_type` = 255
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

###################################################################################################

}

endif;

?>
