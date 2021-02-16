<?php

if(!defined('CN_FILEFORMAT_PHP')):
	define('CN_FILEFORMAT_PHP', true);

abstract class CN_FileFormat
{
	const TYPE_TEXT = 0x01;
	const TYPE_BINARY = 0x02;


	protected $extension = null;
	protected $mime_type = array();
	protected $type = null;


}

endif;

?>