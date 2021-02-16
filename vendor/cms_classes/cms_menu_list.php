<?php

if(!defined('CMS_MENULIST_PHP')):
	define('CMS_MENULIST_PHP', TRUE);

class CMS_MenuList extends CMS_EntityList
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

		$this->table_name = 'menus';
		$this->entity_class_name = 'CMS_Menu';
	}
}

endif;

?>