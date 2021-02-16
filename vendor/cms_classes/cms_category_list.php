<?php

if(!defined('CMS_CATEGORYLIST_PHP')):
	define('CMS_CATEGORYLIST_PHP', TRUE);

class CMS_CategoryList extends CMS_EntityList
{
###################################################################################################
# public
###################################################################################################

	public function __construct($offset=null, $limit=null)
	{
		parent::__construct();

		###########################################################################################

		if(!is_null($offset))
			$this->offset = $offset;
		if(!is_null($limit))
			$this->limit = $limit;

		$this->table_name = 'categories';
		$this->entity_class_name = 'CMS_Category';
	}

###################################################################################################
# public static
###################################################################################################

	public static function getFreeCategories($offset=null, $limit=null, $execute=true)
	{
		$item_type = CMS_Entity::ENTITY_CATEGORY;

		$category_list = new CMS_CategoryList($offset, $limit);
		$category_list->addCondition('usable_by', CMS_Entity::ENTITY_UNIVERSAL);
		$category_list->addCondition("id", "(SELECT `item_id` FROM `categories_bindings` WHERE `item_type` = $item_type)", "NOT IN");

		if($execute === true)
			$category_list->execute();

		###########################################################################################

		return $category_list;
	}

	public static function getTotalyFreeCategories($offset=null, $limit=null, $execute=true)
	{
		$item_type = CMS_Entity::ENTITY_CATEGORY;

		$category_list = new CMS_CategoryList($offset, $limit);
		$category_list->addCondition('usable_by', CMS_Entity::ENTITY_UNIVERSAL);
		$category_list->addCondition("id", "(SELECT `item_id` FROM `categories_bindings` WHERE `item_type` = $item_type)", "NOT IN");
		$category_list->addCondition("id", "(SELECT `item_id` FROM `menus_bindings` WHERE `item_type` = $item_type)", "NOT IN");

		if($execute === true)
			$category_list->execute();

		###########################################################################################

		return $category_list;
	}
}

endif;

?>