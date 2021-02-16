<?php

if(!defined('CMS_CATALOG_BRANCHLIST_PHP')):
	define('CMS_CATALOG_BRANCHLIST_PHP', true);

class CMS_Catalog_BranchList extends CMS_EntityList
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
		$this->entity_class_name = 'CMS_Catalog_Branch';

		###########################################################################################

		$this->addCondition('usable_by', CMS_Catalog::ENTITY_ID);
	}

###################################################################################################
}

endif;

?>