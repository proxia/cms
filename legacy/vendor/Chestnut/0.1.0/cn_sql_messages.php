<?php

if(!defined('CN_SQLMESSAGES_PHP')):
	define('CN_SQLMESSAGES_PHP', TRUE);

class CN_SqlMessages
{
	const INITIALIZATION_FAILED = 1;
	const DATA_SOURCE_SELECTION_FAILED = 2;
	const SQL_QUERY_FAILED = 3;
	const TERMINATION_FAILED = 4;
	const UNKNOWN_QUERY_TYPE = 5;
	const NO_RESULT_DEFINED = 6;
	const SEEK_OUT_OF_RANGE = 7;
	const SET_NAMES_FAILED = 8;
	const DRIVER_NOT_LOADED = 9;


	private function __construct() {}
	private function __destruct() {}
}

endif;

?>