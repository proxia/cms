<?php 

$legacyVendorDir = dirname(__FILE__) . '/../vendor';
$appDir = realpath(dirname(__FILE__) . '/../');
$moduleDir = "$appDir/public/cms_modules";

$include_path = array
(
    $legacyVendorDir,
    "$legacyVendorDir/ws_classes",
    $moduleDir,
);

set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $include_path));

try
{

    require_once('Chestnut/0.1.0/cn_core.php');

	require_once(dirname(__FILE__).'/cms_core.php');
	require_once "$appDir/config/config.php";

####################################################################################################

	$current_theme = 'default';

####################################################################################################
# initialize core systems ##########################################################################

	$cn_application = CN_Application::getSingleton();
	$cn_application->setDebug($config['debug'] ?? false);
	$cn_application->utiliseModule('CN_Containers');

####################################################################################################

	CN_ClassLoader::getSingleton()->registerClassPrefix('CMS_');
	CN_ClassLoader::getSingleton()->registerClassPrefix('WS_');
	CN_ClassLoader::getSingleton()->addSearchPath("../vendor/cms_classes");
	CN_ClassLoader::getSingleton()->addSearchPath("../ws_classes");
    CN_ClassLoader::getSingleton()->addSearchPath($moduleDir);

    CN_Module::addSearchPath($moduleDir);
	CN_Translator::getSingleton()->addDomain("proxia", dirname(__FILE__)."/locales");

####################################################################################################

	$session = CN_Session::getSingleton();
	$session->setName("SID_CMS");
	$session->start();

#####################################################################################################

	$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQLI);
	$data->setServer($config['host']);
	$data->setDataSource($config['dbname']);
	$data->setUser($config['dbuser']);
	$data->setPassword($config['dbpassword']);
	$data->open();

#####################################################################################################
}
catch(CN_Exception $e)
{
	echo $e->displayDetails();
}
