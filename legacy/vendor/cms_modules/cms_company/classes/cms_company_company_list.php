<?php

if(!defined('CMS_COMPANY_COMPANYLIST_PHP')):
	define('CMS_COMPANY_COMPANYLIST_PHP', true);

class CMS_Company_CompanyList extends CMS_EntityList
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

		$this->table_name = 'company_companies';
		$this->entity_class_name = 'CMS_Company';
	}
}

endif;

?>