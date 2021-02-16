<?php

if(!defined('CN_TOKENITERATOR_PHP')):
	define('CN_TOKENITERATOR_PHP', TRUE);



class CN_TokenIterator extends ArrayIterator
{

	function __construct($array)
	{
		parent::__construct($array);
	}
}

endif;

?>