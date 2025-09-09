<?php

if(!defined('CMS_CATALOG_BRANCH_PHP')):
	define('CMS_CATALOG_BRANCH_PHP', true);

class CMS_Catalog_Branch extends CMS_Category
{
	const ENTITY_ID = 104;

###################################################################################################
# public
###################################################################################################

	public function __construct($branch_id=null)
	{
		parent::__construct($branch_id);

		$this->type = self::ENTITY_ID;
		$this->setUsableBy(CMS_Catalog::ENTITY_ID);
	}

	public function getParentCatalog($execute=true)
	{
		$catalogs = new CMS_Catalog_List();
		$catalogs->setTableName('`catalog_branch_bindings`');
		$catalogs->setIdColumnName('catalog_id');
		$catalogs->setSortBy('order');
		$catalogs->addCondition('branch_id', $this->id);

		if($execute === true)
			$catalogs->execute();

		return $catalogs;
	}

###################################################################################################
# configurator methods ############################################################################

	public function hasConfigurator()
	{
		$configurator_entity_id = CMS_Configurator::ENTITY_ID;

		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`categories_bindings`
		WHERE
			`category_id` = {$this->id} AND
			`item_type` = $configurator_entity_id
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue(0) > 0);
	}

###################################################################################################
# move methods ####################################################################################

# move in catalog #################################################################################

	public function moveUpInCatalog($catalog_id, $move_by=1) { return $this->moveUpInEntity($catalog_id, 'catalog_id', 'catalog_branch_bindings', $move_by); }
	public function moveDownInCatalog($catalog_id, $move_by=1) { return $this->moveDownInEntity($catalog_id, 'catalog_id', 'catalog_branch_bindings', $move_by); }
	public function moveToTopInCatalog($catalog_id) { return $this->moveToTopInEntity($catalog_id, 'catalog_id', 'catalog_branch_bindings'); }
	public function moveToBottomInCatalog($catalog_id) { return $this->moveToBottomInEntity($catalog_id, 'catalog_id', 'catalog_branch_bindings'); }

###################################################################################################


# prida do branch novy atribut . pouziva sa tabulka entity bindings lebo category_bindings sa neda.
	public function addAttribute(CMS_Catalog_AttributeDefinition $item){
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
				{$item->getId()},
				{$item->getType()},
				$order
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

# odobere zo skupiny novy atribut
	public function removeAttribute(CMS_Catalog_AttributeDefinition $item){
		$sql =<<<SQL
		DELETE
		FROM
			`entity_bindings`
		WHERE
			`parent_id` = {$this->id} AND
			`parent_type` = {$this->type} AND
			`child_id` = {$item->getId()} AND
			`child_type` = {$item->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}



	public function attributeExists(CMS_Catalog_AttributeDefinition $item)
	{
		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`entity_bindings`
		WHERE
			`parent_id` = {$this->id} AND
			`parent_type` = {$this->type} AND
			`child_id` = {$item->getId()} AND
			`child_type` = {$item->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

# zisti ci ma branch produkty
	public function hasProducts(){

		$products =  $this->getItems(CMS_Catalog_Product::ENTITY_ID);
		return $products->getSize() > 0 ? true: false;
	}

# vrati zoznam attributov
	public function getAttributes($displayable_only=false, $offset=null, $limit=null, $execute=true, $sort_direction=null){

		return $this->getItems(CMS_Catalog_AttributeDefinition::ENTITY_ID, $displayable_only, $offset, $limit, $execute, $sort_direction);

	}

# vrati zoznam attributov
	public function getItems($item_type=null, $displayable_only=false, $offset=null, $limit=null, $execute=true, $sort_direction=null)
	{

		# ak je attribut tak budem spracovavat samostatne! inak zavolam rodicovsku metodu v cms_category
		if($item_type != 103)
		{
			$vector = parent::getItems($item_type, $displayable_only, $offset, $limit, $execute, $sort_direction);
			return $vector;
		}

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
			# toto je pre buduce pouzitie kejsovane
			switch($item_type)
			{

				case 103:
					$entity_table_name = 'categories, categories_lang';
					$list_class_name = 'CMS_Catalog_AttributeDefinitionList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, 'language_is_visible' => 1);
					$remove_conditions = array('usable_by');
					break;

			}

			#######################################################################################

			$list = new $list_class_name($offset, $limit);
		//	$list->setTableName('entity_bindings');
			$list->setTableName('entity_bindings, '.$entity_table_name);

			$list->setIdColumnName('child_id');
			$list->setSortBy('order');

			$list->addCondition('id', '`parent_id`');
			$list->addCondition('id', '`category_id`');
			$list->addCondition('language', "'$language'");
			$list->addCondition("entity_bindings.parent_id = {$this->id}", null, null, true);
			$list->addCondition("entity_bindings.parent_type = {$this->type}", null, null, true);
			$list->addCondition('child_type', $item_type);

			foreach($remove_conditions as $condition)
				$list->removeCondition($condition);

			if($displayable_only === true)
			{
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
			throw new CN_Exception(tr("Tato hlaska by sa nemamla nikdy vyskytnut! .. cms_catalog_branch.php.."));
		}

}

###################################################################################################

	public function delete()
	{
		# branch bindings #########################################################################

		$branch_list = $this->getChildren();

		foreach($branch_list as $branch)
			$branch->delete();

		$sql =<<<SQL
		DELETE
		FROM
			`catalog_branch_bindings`
		WHERE
			`branch_id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		# product bindings ########################################################################

		$product_list = $this->getItems();

		foreach($product_list as $product)
			$product->delete();

		###########################################################################################

		parent::delete();
	}

	public function getChildrenArray($locale,$displayable_only=false)
	{
		$child_list = array();

		###########################################################################################

		$category_type = CMS_Category::ENTITY_ID;

		$sql =<<<SQL
		SELECT
			*
		FROM
			`categories_bindings`,`categories_lang`,`categories`
		WHERE
			`categories_bindings`.`item_id` = `categories_lang`.`category_id` AND
			`categories_bindings`.`item_id` = `categories`.`id` AND
			`categories_lang`.`language` = '{$locale}' AND
			`categories_bindings`.`category_id` = {$this->id} AND
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
			$index = count($child_list);
			$record = $query->fetchRecord();
			$child_list[$index]["id"] = $record->getValue('item_id');
			$child_list[$index]["title"] = $record->getValue('title');
			$child_list[$index]["language_is_visible"] = $record->getValue('language_is_visible');
			$child_list[$index]["is_published"] = $record->getValue('is_published');
		}

		###########################################################################################

		return $child_list;
	}
}

endif;

?>
