<?php

class SortCatalogBranchesToBranchSaveHandler extends CMS_SortTable_SaveHandler
{

	public function __construct()
	{
		$this->_table = "categories_bindings";
		$this->_parent_column = "category_id";
		$this->_child_id_column = "item_id";
		$this->_child_type_column = "item_type";
		$this->_order_column = "order";
	}

}

?>