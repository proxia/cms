<?php

class CMS_Gallery_Bindings extends CN_Singleton
{
###################################################################################################
# public
###################################################################################################

	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################

	public function getGalleries(CMS_Entity $parent_entity, $offset=null, $limit=null, $execute=true)
	{
		$gallery_list = new CMS_GalleryList($offset, $limit);
		$gallery_list->setTableName('gallery_bindings');
		$gallery_list->setIdColumnName('gallery_id');
		$gallery_list->removeCondition('usable_by');
		$gallery_list->addCondition('entity_id', $parent_entity->getId());
		$gallery_list->addCondition('entity_type', $parent_entity->getType());

		if($execute === true)
			$gallery_list->execute();

		return $gallery_list;
	}

###################################################################################################

	public function addGallery(CMS_Entity $parent_entity, CMS_Gallery $gallery)
	{
		$sql =<<<SQL
		INSERT INTO
			`gallery_bindings`
			(
				`entity_id`,
				`entity_type`,
				`gallery_id`
			)
		VALUES
			(
				{$parent_entity->getId()},
				{$parent_entity->getType()},
				{$gallery->getId()}
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeGallery(CMS_Entity $parent_entity, CMS_Gallery $gallery)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`gallery_bindings`
		WHERE
			`entity_id` = {$parent_entity->getId()} AND
			`entity_type` = {$parent_entity->getType()} AND
			`gallery_id` = {$gallery->getId()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }
}
