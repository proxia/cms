<?php

if(!defined('CMS_CATALOG_PRODUCTATTRIBUTELIST_PHP')):
	define('CMS_CATALOG_PRODUCTATTRIBUTELIST_PHP', true);

class CMS_Catalog_ProductAttributeList extends CMS_EntityList
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

		$this->table_name = 'catalog_product_attributes';
		$this->entity_class_name = 'CMS_Catalog_ProductAttribute';
	}

###################################################################################################
}

endif;

?>