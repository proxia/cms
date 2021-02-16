<?php

if(!defined('CMS_INQUIRYLIST_PHP')):
	define('CMS_INQUIRYLIST_PHP', TRUE);

class CMS_InquiryList extends CMS_EntityList
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

		$this->table_name = 'inquiry_inquiries';
		$this->entity_class_name = 'CMS_Inquiry';
	}

	###################################################################################################
	# public static
	###################################################################################################

	public static function getInquiries($offset=null, $limit=null, $execute=true, $language=null)
	{
		if(is_null($language))
			$language = CN_Application::getSingleton()->getLanguage();
	
		$inquiry_list = new CMS_InquiryList($offset, $limit);
		$inquiry_list->setTableName('`inquiry_inquiries`, `inquiry_inquiries_lang`');
		$inquiry_list->addCondition('is_published', 1);
		$inquiry_list->addCondition("language_is_visible", 1);
		$inquiry_list->addCondition("`id` = `inquiry_id`", null, null, true);		
		$inquiry_list->addCondition("language", "'$language'");
						
		if($execute === true)
			$inquiry_list->execute();

		return $inquiry_list;
	}
}

endif;

?>
