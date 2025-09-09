<?php

if(!defined('CMS_CATALOG_PRICELIST_PHP')):
	define('CMS_CATALOG_PRICELIST_PHP', true);

class CMS_Catalog_PriceList extends CMS_EntityList
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

		$this->table_name = 'catalog_prices';
		$this->entity_class_name = 'CMS_Catalog_Price';
	}

###################################################################################################
}

endif;

?>