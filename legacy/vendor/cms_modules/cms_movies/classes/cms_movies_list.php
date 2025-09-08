<?php

if(!defined('CMS_MOVIES_LIST_PHP')):
	define('CMS_MOVIES_LIST_PHP', true);

class CMS_Movies_List extends CMS_EntityList
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

		$this->table_name = 'movies';
		$this->entity_class_name = 'CMS_Movies';
	}

###################################################################################################
}

endif;

?>