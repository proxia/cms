<?php

if(!defined('CMS_CATALOG_PHP')):
	define('CMS_CATALOG_PHP', true);

class CMS_Catalog extends CMS_Entity
{
	const ENTITY_ID = 100;

###################################################################################################
# public
###################################################################################################

	public function __construct($catalog_id=null)
	{
		$this->main_table = 'catalog_catalogs';
		$this->lang_table = 'catalog_catalogs_lang';
		$this->id_column_name = 'catalog_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $catalog_id);
	}

###################################################################################################

	public function isDisplayable()
	{
		if($this->getIsPublished() != 1)
			return false;

		if(!isset($this->current_data[$this->lang_table][$this->context_language]) || $this->getLanguageIsVisible() == 0)
			return false;

		if(CMS_UserLogin::getSingleton()->isUserLogedIn() !== true)
		{
			if($this->getAccess() === CMS::ACCESS_REGISTERED)
				return false;
		}

		###########################################################################################

		return true;
	}

###################################################################################################

	public function getChildren($offset=null, $limit=null, $execute=true)
	{
		$branch_list = new CMS_Catalog_BranchList($offset, $limit);
		$branch_list->removeCondition('usable_by');
		$branch_list->setTableName('catalog_branch_bindings');
		$branch_list->setIdColumnName('branch_id');
		$branch_list->setSortBy('catalog_id,branch_id');
		$branch_list->addCondition('catalog_id', $this->id);

		if($execute === true)
			$branch_list->execute();

		return $branch_list;
	}

	public function addBranch(CMS_Catalog_Branch $branch)
	{
		$sql =<<<SQL
		SELECT
			MAX(`order`)
		FROM
			`catalog_branch_bindings`
		WHERE
			`catalog_id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$order = $query->fetchValue() + 1;

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`catalog_branch_bindings`
			(
				`catalog_id`,
				`branch_id`,
				`order`
			)
		VALUES
			(
				{$this->id},
				{$branch->getId()},
				$order
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeBranch(CMS_Catalog_Branch $branch)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`catalog_branch_bindings`
		WHERE
			`catalog_id` = {$this->id} AND
			`branch_id` = {$branch->getId()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################

	public function addItem($sub_entity)
	{
		$sql =<<<SQL
		SELECT
			MAX(`order`)
		FROM
			`entity_bindings`
		WHERE
			`parent_id` = {$this->id} AND
			`parent_type` = {$this->type}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$order = $query->fetchValue() + 1;

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`entity_bindings`
			(
				`parent_id`,
				`parent_type`,
				`child_id`,
				`child_type`,
				`order`
			)
		VALUES
			(
				{$this->id},
				{$this->type},
				{$sub_entity->getId()},
				{$sub_entity->getType()},
				$order
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeItem($sub_entity)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`entity_bindings`
		WHERE
			`parent_id` = {$this->id} AND
			`parent_type` = {$this->type} AND
			`child_id` = {$sub_entity->getId()} AND
			`child_type` = {$sub_entity->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}


	public function getItems($item_type=null, $displayable_only=false, $offset=null, $limit=null, $execute=true, $sort_direction=null)
	{

	  if(is_null($sort_direction))
      $sort_direction = CMS_EntityList::DIRECTION_ASCENDING; // nie je aplikovana

		if(!is_null($item_type))
		{
			$entity_table_name = null;
			$list_class_name = null;

			$display_conditions = null;
			$remove_conditions = array();

			$language = $this->context_language ;//$language = CN_Application::getSingleton()->getLanguage();

			#######################################################################################

			switch($item_type)
			{

				case 106:
					$entity_table_name = 'categories, categories_lang';
					$list_class_name = 'CMS_Catalog_AttributeGroupList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, '`id` = `categories_lang`.`category_id`' => true, 'language' => "'$language'", 'language_is_visible' => 1);
					$remove_conditions = array('usable_by');
					break;

			}

			#######################################################################################

			$list = new $list_class_name($offset, $limit);
			$list->setTableName('entity_bindings');
			$list->setIdColumnName('child_id');
			$list->setSortBy('order');

			$list->addCondition("entity_bindings.parent_id = {$this->id}", null, null, true);
			$list->addCondition("entity_bindings.parent_type = {$this->type}", null, null, true);
			$list->addCondition('child_type', $item_type);

			foreach($remove_conditions as $condition)
				$list->removeCondition($condition);

			if($displayable_only === true)
			{
				$list->setTableName('`entity_bindings`, '.$entity_table_name);
				$list->addCondition('id', '`child_id`');

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
		}else{
			throw new CN_Exception(tr("Nemôžete volať túto metódu bez konkrétneho typu podpoložiek."));
		}

}
###################################################################################################

	public function getAllProducts($offset=null, $limit=null, $execute=true)
	{
		$product_list = new CMS_Catalog_ProductList($offset, $limit);
		$product_list->addCondition('catalog_id', $this->id);

		if($execute === true)
			$product_list->execute();

		return $product_list;
	}

	public function getFreeProducts($offset=null, $limit=null, $execute=true)
	{
		$item_type = CMS_Catalog_Product::ENTITY_ID;

		$product_list = new CMS_Catalog_ProductList($offset, $limit);
		$product_list->addCondition('catalog_id', $this->id);
		$product_list->addCondition("`id` NOT IN (SELECT `item_id` FROM `categories_bindings` WHERE `item_id`=`id` AND `item_type`=$item_type)", null, null, true);

		if($execute === true)
			$product_list->execute();

		return $product_list;
	}

###################################################################################################

	public function getMenuList($offset=null, $limit=null, $execute=true)
	{
		$menu_list = new CMS_MenuList($offset, $limit);
		$menu_list->setTableName('menus_bindings');
		$menu_list->setIdColumnName('menu_id');
		$menu_list->addCondition('item_id', $this->id);
		$menu_list->addCondition('item_type', self::ENTITY_ID);

		if($execute === true)
			$menu_list->execute();

		return $menu_list;
	}

	public function getParents($offset=null, $limit=null, $execute=true)
	{
		$parent_list = new CMS_CategoryList($offset, $limit);
		$parent_list->setTableName('categories_bindings');
		$parent_list->setIdColumnName('category_id');
		$parent_list->addCondition('item_id', $this->id);
		$parent_list->addCondition('item_type', self::ENTITY_ID);

		if($execute === true)
			$parent_list->execute();

		return $parent_list;
	}

###################################################################################################
# move methods ####################################################################################

# move in category ################################################################################

	public function moveUpInCategory($category_id, $move_by=1) { return $this->moveUpInEntity($category_id, 'category_id', 'categories_bindings', $move_by); }
	public function moveDownInCategory($category_id, $move_by=1) { return $this->moveDownInEntity($category_id, 'category_id', 'categories_bindings', $move_by); }
	public function moveToTopInCategory($category_id) { return $this->moveToTopInEntity($category_id, 'category_id', 'categories_bindings'); }
	public function moveToBottomInCategory($category_id) { return $this->moveToBottomInEntity($category_id, 'category_id', 'categories_bindings'); }

# move in menu ####################################################################################

	public function moveUpInMenu($menu_id, $move_by=1) { return $this->moveUpInEntity($menu_id, 'menu_id', 'menus_bindings', $move_by); }
	public function moveDownInMenu($menu_id, $move_by=1) { return $this->moveDownInEntity($menu_id, 'menu_id', 'menus_bindings', $move_by); }
	public function moveToTopInMenu($menu_id) { return $this->moveToTopInEntity($menu_id, 'menu_id', 'menus_bindings'); }
	public function moveToBottomInMenu($menu_id) { return $this->moveToBottomInEntity($menu_id, 'menu_id', 'menus_bindings'); }

###################################################################################################
# search in catalog ###############################################################################

	public function fulltextSearch($expression, $search_in_attributes=false, $offset=null, $limit=null, $displayable_only=false, $language=null, $execute=true)
	{
		if($search_in_attributes === true)
		{
			#######################################################################################
			# search in products and attributes ###################################################

			$product_list = new CMS_Catalog_ProductList($offset, $limit);
			$product_list->setTableName('catalog_products, catalog_products_lang, catalog_product_attributes, catalog_product_attributes_lang');
			$product_list->setSortBy('catalog_products.id');
			$product_list->setIdColumnName('product_id');
			$product_list->setSortDirection(CMS_EntityList::DIRECTION_DESCENDING);

			# conditions ##########################################################################

			$language = !is_null($language) ? $language : CN_Application::getSingleton()->getLanguage();
			$condition = null;

			if($displayable_only === true)
			{

			}
			else
			{
				$condition =<<<SQL
				(
					(
						catalog_products.id = catalog_products_lang.product_id
						AND
						(
							catalog_products_lang.`title` LIKE '%$expression%'
							OR
							catalog_products_lang.`description` LIKE '%$expression%'
							OR
							catalog_products_lang.`description_extended` LIKE '%$expression%'
							OR
							catalog_products.code LIKE '%$expression%'
						)
						AND
						catalog_products_lang.language = '$language'
					)
					OR
					(
						catalog_product_attributes.id = catalog_product_attributes_lang.product_attribute_id
						AND
						catalog_products.id = catalog_product_attributes.product_id
						AND
						catalog_product_attributes_lang.value LIKE '%$expression%'
						AND
						catalog_product_attributes_lang.language = '$language'
					)
				)
				GROUP BY catalog_products.id
SQL;
			}

			$product_list->addCondition('catalog_id', $this->id);
			$product_list->addCondition($condition, null, null, true);

			/*if($displayable_only === true)
			{
				$valid_condition =<<<SQL
				(
					(`valid_from` >= CURRENT_DATE AND `valid_to` IS NULL)
					OR
					(`valid_from` IS NULL AND `valid_to` <= CURRENT_DATE)
					OR
					(`valid_from` >= CURRENT_DATE AND `valid_to` <= CURRENT_DATE)
					OR
					(`valid_from` IS NULL AND `valid_to` IS NULL)
				)
SQL;

				$product_list->addCondition('is_published', 1);
				$product_list->addCondition($valid_condition, null, null, true);
				$product_list->addCondition('language_is_visible', 1);

				if(CMS_UserLogin::getSingleton()->isUserLogedIn() !== true)
					$product_list->addCondition('(`access` = '.CMS::ACCESS_PUBLIC.' OR `access` = '.CMS::ACCESS_REGISTERED.')', null, null, true);
				else
					$product_list->addCondition('access', CMS::ACCESS_PUBLIC);
			}*/

			if($execute === true)
				$product_list->execute();

			return $product_list;
		}
		else
		{
			#######################################################################################
			# search in products only #############################################################

			$product_list = new CMS_Catalog_ProductList($offset, $limit);
			$product_list->setTableName('catalog_products, catalog_products_lang');
			$product_list->setSortBy('catalog_products.id');
			$product_list->setIdColumnName('product_id');
			$product_list->setSortDirection(CMS_EntityList::DIRECTION_DESCENDING);

			# conditions ##########################################################################

			$product_list->addCondition('id = product_id', null, null, true);
			$product_list->addCondition('catalog_id', $this->id);
			$product_list->addCondition("(`title` LIKE '%$expression%' OR `description` LIKE '%$expression%' OR `description_extended` LIKE '%$expression%' OR `code` LIKE '%$expression%')", null, null, true);

			if(!is_null($language))
				$product_list->addCondition('language', "'$language'");
			else
				$product_list->addCondition('language', "'".CN_Application::getSingleton()->getLanguage()."'");

			if($displayable_only === true)
			{
				$valid_condition =<<<SQL
				(
					(`valid_from` >= CURRENT_DATE AND `valid_to` IS NULL)
					OR
					(`valid_from` IS NULL AND `valid_to` <= CURRENT_DATE)
					OR
					(`valid_from` >= CURRENT_DATE AND `valid_to` <= CURRENT_DATE)
					OR
					(`valid_from` IS NULL AND `valid_to` IS NULL)
				)
SQL;

				$product_list->addCondition('is_published', 1);
				$product_list->addCondition($valid_condition, null, null, true);
				$product_list->addCondition('language_is_visible', 1);

				if(CMS_UserLogin::getSingleton()->isUserLogedIn() !== true)
					$product_list->addCondition('(`access` = '.CMS::ACCESS_PUBLIC.' OR `access` = '.CMS::ACCESS_REGISTERED.')', null, null, true);
				else
					$product_list->addCondition('access', CMS::ACCESS_PUBLIC);
			}

			if($execute === true)
				$product_list->execute();

			return $product_list;
		}
	}

###################################################################################################
# save and delete #################################################################################

	public function save()
	{
		if(is_null($this->id))
			$this->insertCatalog();
		else
			$this->updateCatalog();

		$this->updateLanguageVersions();
	}

	public function delete()
	{
		# branch bindings #########################################################################

		$branch_list = $this->getChildren();

		foreach($branch_list as $branch)
		{
			$this->removeBranch($branch);
			$branch->delete();
		}

		# product bindings ########################################################################

		$product_list = $this->getAllProducts();

		foreach($product_list as $product)
			$product->delete();

		# main bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `{$this->lang_table}` WHERE `catalog_id` = {$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `{$this->main_table}` WHERE `id` = {$this->id}");
		$query->execute();
	}

###################################################################################################
# private
###################################################################################################

	private function insertCatalog()
	{
		$is_published = (int)true;
		$access = CMS::ACCESS_PUBLIC;
		$access_groups = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : (int)$this->new_data[$this->main_table]['is_published'];
		if(isset($this->new_data[$this->main_table]['access']))
			$access = $this->new_data[$this->main_table]['access'] === 'NULL' ? $access : $this->new_data[$this->main_table]['access'];
		if(isset($this->new_data[$this->main_table]['access_groups']))
			$access_groups = $this->new_data[$this->main_table]['access_groups'] === 'NULL' ? $access_groups : "'{$this->new_data[$this->main_table]['access_groups']}'";

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`is_published`,
				`access`,
				`access_groups`
			)
		VALUES
			(
				NOW(),
				$is_published,
				$access,
				$access_groups
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateCatalog()
	{
		$is_published = true;
		$access = CMS::ACCESS_PUBLIC;
		$access_groups = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? (int)$is_published : (int)$this->new_data[$this->main_table]['is_published'];
		else
			$is_published = $this->current_data[$this->main_table]['is_published'] === 'NULL' ? (int)$is_published : (int)$this->current_data[$this->main_table]['is_published'];

		if(isset($this->new_data[$this->main_table]['access']))
			$access = $this->new_data[$this->main_table]['access'] === 'NULL' ? $access : $this->new_data[$this->main_table]['access'];
		else
			$access = $this->current_data[$this->main_table]['access'] === 'NULL' ? $access : $this->current_data[$this->main_table]['access'];

		if(isset($this->new_data[$this->main_table]['access_groups']))
			$access_groups = $this->new_data[$this->main_table]['access_groups'] === 'NULL' ? $access_groups : "'{$this->new_data[$this->main_table]['access_groups']}'";
		else
			$access_groups = $this->current_data[$this->main_table]['access_groups'] === 'NULL' ? $access_groups : "'{$this->current_data[$this->main_table]['access_groups']}'";

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`is_published` = $is_published,
			`access` = $access,
			`access_groups` = $access_groups
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
		$language_is_visible = true;

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
				$language_is_visible = $language_version['language_is_visible'] === 'NULL' ? (int)$language_is_visible : (int)$language_version['language_is_visible'];
			elseif(isset($this->current_data[$this->lang_table][$language]['language_is_visible']))
				$language_is_visible = $this->current_data[$this->lang_table][$language]['language_is_visible'] === 'NULL' ? (int)$language_is_visible : (int)$this->current_data[$this->lang_table][$language]['language_is_visible'];

			#######################################################################################

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				`{$this->lang_table}`
			WHERE
				`catalog_id` = {$this->id} AND
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
						`catalog_id`,
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
					`catalog_id` = {$this->id} AND
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
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}
}

endif;

?>
