<?php

if(!defined('CMS_ATTACHMENTLIST_PHP')):
	define('CMS_ATTACHMENTLIST_PHP', true);

class CMS_AttachmentList extends CMS_EntityList
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

		$this->table_name = 'attachments';
		$this->entity_class_name = 'CMS_Attachment';
	}

###################################################################################################

###################################################################################################
# public static
###################################################################################################

	public static function getArticleAttachments(CMS_Article $article, $offset=null, $limit=null, $execute=true)
	{
		$attachment_list = new CMS_AttachmentList($offset, $limit);
		$attachment_list->setTableName('articles_attachments');
		$attachment_list->setIdColumnName('attachment_id');
		$attachment_list->addCondition('article_id', $article->getId());

		if($execute === true)
			$attachment_list->execute();

		return $attachment_list;
	}
}

endif;

?>