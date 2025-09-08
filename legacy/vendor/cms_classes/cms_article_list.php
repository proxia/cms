<?php

class CMS_ArticleList extends CMS_EntityList
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

		$this->table_name = 'articles';
		$this->entity_class_name = 'CMS_Article';
	}

###################################################################################################
# public static
###################################################################################################

	public static function getArchiveArticlesSortedByMostRead($offset=null, $limit=null, $execute=true, $language=null)
	{
		if(is_null($language))
			$language = CN_Application::getSingleton()->getLanguage();

		$article_list = new CMS_ArticleList($offset, $limit);
		$article_list->setTableName('`articles`, `articles_lang`');
		$article_list->addCondition('is_archive', 1);
		$article_list->addCondition('is_published', 1);
		$article_list->setSortBy("(SELECT COUNT(*) FROM `statistics` WHERE `entity_id` = `articles`.`id` AND `entity_type` = ".CMS_Article::ENTITY_ID.")", true);
		$article_list->setSortDirection(CMS_EntityList::DIRECTION_DESCENDING);
		$article_list->addCondition("`id` = `article_id`", null, null, true);
		$article_list->addCondition("language_is_visible", 1);
		$article_list->addCondition("language", "'$language'");

		if($execute === true)
			$article_list->execute();

		return $article_list;
	}

	public static function getFlashNews($offset=null, $limit=null, $language=null, $execute=true)
	{
		if(is_null($language))
			$language = CN_Application::getSingleton()->getLanguage();

		$flash_list = new CMS_ArticleList($offset, $limit);
		$flash_list->setTableName("`articles`, `articles_lang`");
		$flash_list->addCondition('is_archive', 0);
		$flash_list->addCondition('is_trash', 0);
		$flash_list->addCondition('is_news', 1);
		$flash_list->addCondition('is_flash_news', 1);
		$flash_list->addCondition('is_published', 1);
		$flash_list->addCondition("(`expiration` >= NOW() OR `expiration` IS NULL OR `expiration` = '0000-00-00 00:00:00')", null, null, true);
		$flash_list->addCondition("`id` = `article_id`", null, null, true);
		$flash_list->addCondition("language_is_visible", 1);
		$flash_list->addCondition("language", "'$language'");

		if($execute === true)
			$flash_list->execute();

		return $flash_list;
	}

	public static function getNews($offset=null, $limit=null, $language=null, $execute=true)
	{
		if(is_null($language))
			$language = CN_Application::getSingleton()->getLanguage();

		$news_list = new CMS_ArticleList($offset, $limit);
		$news_list->setTableName("`articles`, `articles_lang`");
		$news_list->addCondition('is_archive', 0);
		$news_list->addCondition('is_trash', 0);
		$news_list->addCondition('is_news', 1);
		$news_list->addCondition('is_published', 1);
		$news_list->addCondition("(`expiration` >= NOW() OR `expiration` IS NULL OR `expiration` = '0000-00-00 00:00:00')", null, null, true);
		$news_list->addCondition("`id` = `article_id`", null, null, true);
		$news_list->addCondition("language_is_visible", 1);
		$news_list->addCondition("language", "'$language'");

		if($execute === true)
			$news_list->execute();

		return $news_list;
	}

	public static function getRecentArticles($offset=null, $limit=null, $language=null, $execute=true)
	{
		if(is_null($language))
			$language = CN_Application::getSingleton()->getLanguage();

		$recent_article_list = new CMS_ArticleList($offset, $limit);
		$recent_article_list->setTableName("`articles`, `articles_lang`");
		$recent_article_list->addCondition('is_archive', 0);
		$recent_article_list->addCondition('is_trash', 0);
		$recent_article_list->addCondition('is_published', 1);

		if(CMS_UserLogin::getSingleton()->isUserLogedIn() === false)
			$recent_article_list->addCondition("access", CMS::ACCESS_PUBLIC);

		$recent_article_list->addCondition("(`expiration` >= NOW() OR `expiration` IS NULL OR `expiration` = '0000-00-00 00:00:00')", null, null, true);
		$recent_article_list->addCondition('usable_by', CMS_Entity::ENTITY_UNIVERSAL);
		$recent_article_list->addCondition("`id` = `article_id`", null, null, true);
		$recent_article_list->addCondition("language_is_visible", 1);
		$recent_article_list->addCondition("language", "'$language'");

		if($execute === true)
			$recent_article_list->execute();

		return $recent_article_list;
	}
}
