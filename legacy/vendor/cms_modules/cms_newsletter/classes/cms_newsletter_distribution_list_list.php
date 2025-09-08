<?php

if(!defined('CMS_NEWSLETTER_DISTRIBUTIONLISTLIST_PHP')):
	define('CMS_NEWSLETTER_DISTRIBUTIONLISTLIST_PHP', true);

class CMS_Newsletter_DistributionListList extends CMS_EntityList
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

		$this->table_name = 'newsletter_distribution_lists';
		$this->entity_class_name = 'CMS_Newsletter_DistributionList';
	}

###################################################################################################
}

endif;

?>