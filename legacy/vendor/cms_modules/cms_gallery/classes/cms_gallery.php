<?php

if(!defined('CMS_GALLERY_PHP')):
	define('CMS_GALLERY_PHP', true);

class CMS_Gallery extends CMS_Category
{
	const ENTITY_ID = 170;

###################################################################################################
# public
###################################################################################################

	public function __construct($entity_id=null)
	{
		parent::__construct($entity_id);

		$this->type = self::ENTITY_ID;
		$this->setUsableBy(self::ENTITY_ID);
	}
###################################################################################################
# attachments #####################################################################################

	public function getAttachments($offset=null, $limit=null, $execute=true)
	{
		$attachment_list = new CMS_AttachmentList($offset, $limit);
		$attachment_list->setTableName('categories_bindings');
		$attachment_list->setIdColumnName('item_id');
		$attachment_list->setSortBy('order');
		$attachment_list->addCondition('category_id', $this->id);
		$attachment_list->addCondition('item_type', CMS_Attachment::ENTITY_ID);

		if($execute === true)
			$attachment_list->execute();

		return $attachment_list;
	}

###################################################################################################

	public function attachmentExists(CMS_Attachment $attachment)
	{
		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`categories_bindings`
		WHERE
			`category_id` = {$this->id} AND
			`item_id` = {$attachment->getId()} AND
			`item_type` = {$attachment->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

###################################################################################################

	public function addAttachment(CMS_Attachment $attachment)
	{
		$sql = <<<SQL
		SELECT
			MAX(`order`)
		FROM
			`categories_bindings`
		WHERE
			`category_id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$order = $query->fetchValue() + 1;

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`categories_bindings`
			(
				`category_id`,
				`item_id`,
				`item_type`,
				`order`
			)
		VALUES
			(
				{$this->id},
				{$attachment->getId()},
				{$attachment->getType()},
				$order
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeAttachment(CMS_Attachment $attachment)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`categories_bindings`
		WHERE
			`category_id` = {$this->id} AND
			`item_id` = {$attachment->getId()} AND
			`item_type` = {$attachment->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################
###################################################################################################

	public function getParents()
	{
		$parent_list = array();

		###########################################################################################

		$sql =<<<SQL
		SELECT
			DISTINCT `category_id`,
			`item_type`
		FROM
			`categories_bindings`
		WHERE
			`item_id` = {$this->id} AND
			`item_type` = {$this->type}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$parent_list[] = new CMS_Category($record->getValue('category_id'));
		}

		###########################################################################################

		return $parent_list;
	}

###################################################################################################

	public function isDisplayable()
	{
		if($this->getIsPublished() == 0)
			return false;

		if(!isset($this->current_data[$this->lang_table][$this->context_language]) || $this->getLanguageIsVisible() == 0)
			return false;

		if(CMS_UserLogin::getSingleton()->isUserLogedIn() !== true)
		{
			if($this->getAccess() == CMS::ACCESS_REGISTERED)
				return false;
		}

		return true;
	}

}

endif;

?>
