<?php

class CMS_SortTable_Item
{
	protected $_public = array
	(
		'data' => null,
		
		'thumbnail' => null,
		
		'column_1' => null,
		'column_2' => null,
		'column_3' => null
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
}

?>