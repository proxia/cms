<?php

if(!defined('CMS_GALLERY_LIST_PHP')):
	define('CMS_GALLERY_LIST_PHP', true);

class CMS_GalleryList extends CMS_EntityList
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
		$this->entity_class_name = 'CMS_Gallery';

		$this->addCondition('usable_by', CMS_Gallery::ENTITY_ID);
	}
}

endif;

?>