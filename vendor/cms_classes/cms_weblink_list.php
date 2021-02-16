<?php

if(!defined('CMS_WEBLINKLIST_PHP')):
	define('CMS_WEBLINKLIST_PHP', TRUE);

class CMS_WeblinkList extends CMS_EntityList
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

		$this->table_name = 'weblinks';
		$this->entity_class_name = 'CMS_Weblink';
	}
}

endif;

?>