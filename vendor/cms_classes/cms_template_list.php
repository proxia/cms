<?php
/*
 * Created on Sep 28, 2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

if(!defined('CMS_TEMPLATELIST_PHP')):
	define('CMS_TEMPLATELIST_PHP', true);

class CMS_TemplateList extends CMS_EntityList
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

		$this->table_name = 'templates';
		$this->entity_class_name = 'CMS_Template';
	}
	
###################################################################################################
# public static
###################################################################################################

	public static function getMainTemplates($offset=null, $limit=null, $execute=true)
	{
		$template_list = new CMS_TemplateList($offset, $limit);
		$template_list->setTableName('templates_bindings');
		$template_list->addCondition('`entity_id` IS NULL', null, null, true);
		$template_list->addCondition('`entity_type` IS NULL', null, null, true);
		
		if($execute === true)
			$template_list->execute();
		
		return $template_list;
	}
}

endif;

?>
