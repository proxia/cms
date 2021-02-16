<?php

class CMS_SortTable
{
	protected $_items = array();

	protected $_parent_entity = null;
	protected $_save_handler = null;

###################################################################################################
# public
###################################################################################################

	public function __construct() {}

###################################################################################################
# accessor methods ################################################################################

	public function setParentEntity(CMS_Entity & $parent_entity) { $this->_parent_entity = $parent_entity; }

	public function setSaveHandler(CMS_SortTable_SaveHandler & $save_handler) { $this->_save_handler = $save_handler; }

###################################################################################################
# items handling methods ##########################################################################

	public function & getItems()
	{
		return $this->_items;
    }

	public function addItem(CMS_SortTable_Item & $i_item)
	{
		$this->_items[] = $i_item;
    }

###################################################################################################
# save related methods ############################################################################

	public function save()
	{
		$this->_save_handler->items = $this->_items;
		$this->_save_handler->parent_entity = $this->_parent_entity;

		$this->_save_handler->save();
    }
}

?>