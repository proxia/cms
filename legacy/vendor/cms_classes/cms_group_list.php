<?php

if(!defined('CMS_GROUPLIST_PHP')):
	define('CMS_GROUPLIST_PHP', true);

class CMS_GroupList extends CMS_EntityList
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

		$this->table_name = 'groups';
		$this->entity_class_name = 'CMS_Group';
	}
}

endif;

?>