<?php

if(!defined('CMS_INQUIRY_QUESTIONLIST_PHP')):
	define('CMS_INQUIRY_QUESTIONLIST_PHP', true);

class CMS_Inquiry_QuestionList extends CMS_EntityList
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

		$this->table_name = 'inquiry_inquiries_bindings';
		$this->entity_class_name = 'CMS_Inquiry_Question';
		$this->id_column_name = 'question_id';
		$this->sort_by = 'order';
	}

###################################################################################################
}

endif;

?>