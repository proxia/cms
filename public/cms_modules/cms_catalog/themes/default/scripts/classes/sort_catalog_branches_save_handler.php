<?php

class SortCatalogBranchesSaveHandler extends CMS_SortTable_SaveHandler
{

	public function __construct()
	{
		$this->_table = "catalog_branch_bindings";
		$this->_parent_column = "catalog_id";
		$this->_child_id_column = "branch_id";
		$this->_child_type_column = null;
		$this->_order_column = "order";
		$this->_bindings_type = CMS_SortTable_SaveHandler::BINDINGS_TYPE_SHORT;
	}

}

?>