<?php

if(!defined('CMS_CATALOG_ATTRIBUTEGROUPLIST_PHP')):
	define('CMS_CATALOG_ATTRIBUTEGROUPLIST_PHP', true);

class CMS_Catalog_AttributeGroupList extends CMS_EntityList
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
		$this->entity_class_name = 'CMS_Catalog_AttributeGroup';

		###########################################################################################

		$this->addCondition('usable_by', CMS_Catalog_AttributeGroup::ENTITY_ID);
	}

###################################################################################################
}

endif;

?>
