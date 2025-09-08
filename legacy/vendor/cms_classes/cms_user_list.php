<?php

if(!defined('CMS_USERLIST_PHP')):
	define('CMS_USERLIST_PHP', TRUE);

class CMS_UserList extends CMS_EntityList
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

		$this->table_name = 'users';
		$this->entity_class_name = 'CMS_User';
	}
}

endif;

?>