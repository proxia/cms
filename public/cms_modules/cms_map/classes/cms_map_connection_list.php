<?php

if(!defined('CMS_MAP_CONNECTIONLIST_PHP')):
	define('CMS_MAP_CONNECTIONLIST_PHP', true);

class CMS_Map_ConnectionList extends CMS_EntityList
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

		$this->table_name = 'map_connections';
		$this->entity_class_name = 'CMS_Map_Connection';
	}
}

endif;

?>
