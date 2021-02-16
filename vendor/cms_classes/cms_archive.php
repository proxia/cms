<?php

if(!defined('CMS_ARCHIVE_PHP')):
	define('CMS_ARCHIVE_PHP', true);

class CMS_Archive extends CN_Singleton
{
###################################################################################################
# public
###################################################################################################

	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################

	public function getArticleList($limit=null, $offset=null)
	{
		$article_list = new CMS_ArticleList();
		$article_list->addCondition('is_archive', 1);

		if(!is_null($limit))
			$article_list->setLimit($limit);

		if(!is_null($offset))
			$article_list->setOffset($offset);

		return $article_list->getList();
	}

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton() { return parent::getSingleton(__CLASS__); }
}

endif;

?>