<?php

if(!defined('CMS_BANNERMANAGER_BANNERLIST_PHP')):
	define('CMS_BANNERMANAGER_BANNERLIST_PHP', true);

class CMS_BannerManager_BannerList extends CMS_EntityList
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

		$this->table_name = 'banner_manager_banners';
		$this->entity_class_name = 'CMS_BannerManager_Banner';
	}
}

endif;

?>