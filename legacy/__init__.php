<?php

/** @var \App\Controller\LegacyController $contextController */
$contextController = $this;

$appDir = realpath(dirname(__FILE__) . '/../');
$moduleDir = "$appDir/legacy/vendor/cms_modules";

$GLOBALS['moduleDir'] = $moduleDir;

$config = require_once "$appDir/config/config.php";

$GLOBALS['config'] = $config;
$GLOBALS['cms_root'] = $contextController->getParameterBag()->get('app.legacy_dir');

####################################################################################################

$current_theme = 'default';

####################################################################################################
# initialize core systems ##########################################################################

$cn_application = CN_Application::getSingleton();
$cn_application->setDebug($config['debug'] ?? false);

CN_Translator::getSingleton()->addDomain("proxia", dirname(__FILE__)."/locales");

####################################################################################################

CN_ClassLoader::getSingleton()->addSearchPath($moduleDir);

CN_Module::addSearchPath($moduleDir);

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
