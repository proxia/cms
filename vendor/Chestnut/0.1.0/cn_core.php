<?php

spl_autoload_register(function ($class_name) {
	CN_ClassLoader::getSingleton()->loadClass(trim($class_name));
});

{
	$file_list = get_required_files();

	foreach($file_list as $file_path)
	{
		if(strpos($file_path, 'cn_core') !== false)
		{
			$file_path = str_replace('cn_core.php', '', $file_path);

			require_once($file_path.'cn_singleton.php');
			require_once($file_path.'cn_info.php');

			CN_Info::getSingleton()->setInstallPath($file_path);

			break;
		}
	}

	unset($GLOBALS['file_list']);
}

require_once(CN_Info::getSingleton()->getInstallPath().'chestnut.php');
require_once(CN_Info::getSingleton()->getInstallPath().'cn_utils.php');
require_once(CN_Info::getSingleton()->getInstallPath().'cn_class_loader.php');
