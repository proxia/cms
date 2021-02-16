<?php

if(!defined('CN_VECTORITERATOR_PHP')):
	define('CN_VECTORITERATOR_PHP', TRUE);

class CN_VectorIterator implements Iterator
{
	private $vector_data = NULL;
	private $is_live = FALSE;


	public function __construct(CN_Vector $vector, $live=FALSE)
	{
		$this->vector_data = $vector->getRawData();
		$this->is_live = $live;
	}


	public function isLive()
	{
		return $this->is_live;
	}

			
	public function rewind()
	{
		reset($this->vector_data);
	}

	public function current()
	{
		return current($this->vector_data);
	}

	public function key()
	{
		return key($this->vector_data);
	}

	public function next()
	{
		return next($this->vector_data);
	}

	public function valid()
	{
		return ($this->current() !== FALSE);
	}

			
	public function findNext($value)
	{
	}

	public function findPrevious($value)
	{
	}

	public function hasNext()
	{
	}

	public function hasPrevious()
	{
	}

	public function previous()
	{
	}

	public function peekNext()
	{
	}

	public function peekPrevious()
	{
	}

	public function toBack()
	{
	}

	public function toFront()
	{
	}
}

endif;

?>