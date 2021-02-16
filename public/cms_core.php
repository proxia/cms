<?php

$file_list = get_required_files();

foreach($file_list as $file_path)
{
	if(strpos($file_path, 'cms_core') !== false)
	{
		$file_path = str_replace('cms_core.php', '', $file_path);

		$GLOBALS['cms_root'] = realpath($file_path).'/../';

		break;
	}

	unset($file_list); // dont want it in $GLOBALS variable
}
