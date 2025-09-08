<?php

if(!defined('CMS_INQUIRY_ANSWERLIST_PHP')):
	define('CMS_INQUIRY_ANSWERLIST_PHP', true);

class CMS_Inquiry_AnswerList extends CMS_EntityList
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

		$this->table_name = 'inquiry_answers';
		$this->entity_class_name = 'CMS_Inquiry_Answer';
		$this->sort_by = 'order';
	}

###################################################################################################
}

endif;

?>