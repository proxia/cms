<?php

if(!defined('CMS_MAP_AREALIST_PHP')):
	define('CMS_MAP_AREALIST_PHP', true);

class CMS_Map_AreaList extends CMS_EntityList
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

		$this->table_name = 'map_areas';
		$this->entity_class_name = 'CMS_Map_Area';
	}
}

endif;

?>
