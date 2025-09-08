<?php

if(!defined('CMS_CATALOG_PRODUCTLIST_PHP')):
	define('CMS_CATALOG_PRODUCTLIST_PHP', true);

class CMS_Catalog_ProductList extends CMS_EntityList
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

		$this->table_name = 'catalog_products';
		$this->entity_class_name = 'CMS_Catalog_Product';
	}

	public static function getNews($offset=null, $limit=null, $language=null, $execute=true)
	{
		if(is_null($language))
			$language = CN_Application::getSingleton()->getLanguage();

		$news_list = new CMS_Catalog_ProductList($offset, $limit);
		$news_list->setTableName("`catalog_products`, `catalog_products_lang`");
		$news_list->addCondition('is_news', 1);
		$news_list->addCondition('is_published', 1);
		$news_list->addCondition("( (`valid_from` <= NOW() AND `valid_to` IS NULL) OR (`valid_from` IS NULL AND `valid_to` >= NOW()) OR (`valid_from` <= NOW() AND `valid_to` >= NOW()) OR (`valid_from` IS NULL AND `valid_to` IS NULL) )", null, null, true);		
		$news_list->addCondition("`id` = `product_id`", null, null, true);
		$news_list->addCondition("language_is_visible", 1);
		$news_list->addCondition("language", "'$language'");

		if($execute === true)
			$news_list->execute();

		return $news_list;
	}
###################################################################################################
}

endif;

?>
