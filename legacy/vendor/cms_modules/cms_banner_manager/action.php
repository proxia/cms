<?php

require_once("../../__admin_init__.php");

try
{
	require_once("themes/{$GLOBALS['current_theme']}/action.php");
}
catch(CN_Exception $e)
{
	echo $e->displayDetails();
}

?>