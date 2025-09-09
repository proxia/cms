<?php

class CMS_SortTable_SaveHandler
{
	protected $_table = null;

	protected $_parent_column = null;
	protected $_child_id_column = null;
	protected $_child_type_column = null;
	protected $_order_column = null;
	const BINDINGS_TYPE_SHORT = 11;
	const BINDINGS_TYPE_STANDART = 22;
	const BINDINGS_TYPE_EDHANCED = 33;

	protected $_bindings_type = CMS_SortTable_SaveHandler::BINDINGS_TYPE_STANDART;

	protected $_public = array
	(
		'items' => array(),
		'parent_entity' => null
	);

###################################################################################################
# public
###################################################################################################

	public function __set($v_name, $v_value)
	{
		if ( array_key_exists($v_name, $this->_public) )
			$this->_public[$v_name] = $v_value;
    }

	public function __get($v_name)
	{
		if ( array_key_exists($v_name, $this->_public) )
			return $this->_public[$v_name];
		else
			return null;
    }

	public function __isset($v_name)
	{
		return isset($this->_public[$v_name]);
    }

	public function __unset($v_name)
	{
		unset($this->_public[$v_name]);
    }

    public function save()
    {

    	foreach ( $this->items as $order => $item )
    	{
    		if($this->_bindings_type == CMS_SortTable_SaveHandler::BINDINGS_TYPE_STANDART) // for example (category_id,item_id,item_type,order)
    		{
			$sql = "Update {$this->_table} SET `{$this->_order_column}` = {$order} Where {$this->_parent_column} = {$this->_public['parent_entity']->getId()} AND {$this->_child_type_column} = {$item->data->getType()} AND {$this->_child_id_column} = {$item->data->getId()}";
			$query = new CN_SqlQuery($sql);
			$query->execute();
			}

    		if($this->_bindings_type == CMS_SortTable_SaveHandler::BINDINGS_TYPE_SHORT) // for example (catalog_id,branch_id,order)
    		{
			$sql = "Update {$this->_table} SET `{$this->_order_column}` = {$order} Where {$this->_parent_column} = {$this->_public['parent_entity']->getId()}  AND {$this->_child_id_column} = {$item->data->getId()}";
			$query = new CN_SqlQuery($sql);
			$query->execute();
			}
    	}
    }
}

?>