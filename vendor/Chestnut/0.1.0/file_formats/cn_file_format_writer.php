<?php

if(!defined('CN_FILEFORMATWRITER_PHP')):
	define('CN_FILEFORMATWRITER_PHP', true);

abstract class CN_FileFormatWriter extends CN_FileFormat
{
	protected $target_file = null;


	public function setTargetFile($target_file) { $this->target_file = $target_file; }

	abstract public function write();

}

endif;

?>