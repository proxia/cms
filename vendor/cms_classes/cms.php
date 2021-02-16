<?php

if(!defined('CMS_PHP')):
	define('CMS_PHP', TRUE);

class CMS
{
	const ACCESS_PUBLIC = 1;
	const ACCESS_REGISTERED = 2;
	const ACCESS_SPECIAL = 3;

	const READ_ALL = 1;
	const READ_MAIN_DATA = 2;
	const READ_LANG_DATA = 3;
	const READ_BINDINGS = 4;
	const READ_ANSWERS = 5;
	
	const MAP_SHAPE_RECT = 'rect';
	const MAP_SHAPE_CIRCLE = 'circle';
	const MAP_SHAPE_POLY = 'poly';
	const MAP_SHAPE_DEFAULT = 'default';

####################################################################################################
# private
####################################################################################################

	private function __construct() {}
}

endif;

?>