<?php

if(!defined('CN_VECTOR_PHP')):
	define('CN_VECTOR_PHP', true);

class CN_Vector implements Iterator, Countable
{
	private $data = array();


	public function __construct() {}


	public function __toString()
	{
		ob_start();

		print_r($this->data);

		$data = ob_get_contents();

		ob_end_clean();

		$readable_vector = '<pre style="text-align: left;">'.$data.'</pre>';

		return $readable_vector;
	}


	public function isEmpty() { return (!count($this->data)); }
	public function clear() { $this->data = array(); }
	public function getSize() { return count($this->data); }
	public function getRawData() { return $this->data; }


	public function insert($index, $element)
	{
		if($index == 0)
		{
			array_unshift($this->data, $element);
			return;
		}

		if($index >= count($this->data))
		{
			$this->data[] = $element;
			return;
		}

		$tmp_data = array();

		foreach($this->data as $i => $val)
		{
			if($i == $index)
			{
				$tmp_data[] = $element;
				$tmp_data[] = $val;
			}
			else
				$tmp_data[] = $val;
		}

		$this->data = $tmp_data;
	}

	public function remove($index)
	{
		array_splice($this->data, $index, 1);
	}

	public function prepend($element)
	{
		array_unshift($this->data, $element);
	}

	public function append($element)
	{
		$this->data[] = $element;
	}

	public function replace($index, $element)
	{
		array_splice($this->data, $index, 1, $element);
	}

	public function swap($index1, $index2)
	{
		$element1 = $this->data[$index1];
		$element2 = $this->data[$index2];

		$this->data[$index1] = $element2;
		$this->data[$index2] = $element1;
	}

	public function move($index1, $index2)
	{
		$element = $this->data[$index1];

		$this->remove($index1);
		$this->insert($index2, $element);
	}


	public function pop_front()
	{
		array_shift($this->data);
	}

	public function pop_back()
	{
		array_pop($this->data);
	}


	public function indexOf($element) { return array_search($element, $this->data); }

	public function at($index)
	{
		if(isset($this->data[$index]))
			return $this->data[$index];
		else
			return FALSE;
	}


	public function removeDuplicates()
	{
		$this->data = array_unique($this->data);
		$this->reindex();
	}

    #[\ReturnTypeWillChange]
	public function rewind()
	{
		reset($this->data);
	}

    #[\ReturnTypeWillChange]
	public function current()
	{
		return current($this->data);
	}

    #[\ReturnTypeWillChange]
	public function key()
	{
		return key($this->data);
	}

    #[\ReturnTypeWillChange]
	public function next()
	{
		return next($this->data);
	}

    #[\ReturnTypeWillChange]
	public function valid()
	{
		return ($this->current() !== false);
	}

	private function reindex()
	{
		$tmp_data = array();

		foreach($this->data as $val)
			$tmp_data[] = $val;

		$this->data = $tmp_data;
	}

    #[\ReturnTypeWillChange]
    public function count()
    {
        return count($this->data);
    }
}

endif;

?>
