<?php

if(!defined('CMS_TRASH_PHP')):
	define('CMS_TRASH_PHP', true);

class CMS_Trash extends CN_Singleton
{
###################################################################################################
# public
###################################################################################################

	public function __construct()
	{
		parent::__construct($this);
	}

	public function __destruct()
	{
		$this->removeSingleton(__CLASS__);
	}

###################################################################################################

	public function getCategoryList($offset=null, $limit=null)
	{
		$category_list = new CMS_CategoryList($offset, $limit);
		$category_list->addCondition('is_trash', 1);

		if(!is_null($limit))
			$category_list->setLimit($limit);

		if(!is_null($offset))
			$category_list->setOffset($offset);

		$category_list->execute();

		return $category_list;
	}

	public function getArticleList($offset=null, $limit=null)
	{
		$article_list = new CMS_ArticleList($offset, $limit);
		$article_list->addCondition('is_trash', 1);

		if(!is_null($limit))
			$article_list->setLimit($limit);

		if(!is_null($offset))
			$article_list->setOffset($offset);

		$article_list->execute();

		return $article_list;
	}

	public function getWeblinkList($offset=null, $limit=null)
	{
		$weblink_list = new CMS_WeblinkList($offset, $limit);
		$weblink_list->addCondition('is_trash', 1);

		if(!is_null($limit))
			$weblink_list->setLimit($limit);

		if(!is_null($offset))
			$weblink_list->setOffset($offset);

		$weblink_list->execute();

		return $weblink_list;
	}

	public function getMenuList($offset=null, $limit=null)
	{
		$menu_list = new CMS_MenuList($offset, $limit);
		$menu_list->addCondition('is_trash', 1);

		if(!is_null($limit))
			$menu_list->setLimit($limit);

		if(!is_null($offset))
			$menu_list->setOffset($offset);

		$menu_list->execute();

		return $menu_list;
	}

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton() { return parent::getSingleton(__CLASS__); }
}

endif;

?>