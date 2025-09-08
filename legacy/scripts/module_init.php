<?php
global $moduleDir;

$module_detail = CMS_Module::addModule($_REQUEST['module']);

//$GLOBALS["smarty"]->assign("path_relative",$module_detail->getRelativePath());

// docasne riesenie
$module_name_folder = CN_Utils::getRealName($_REQUEST['module'],'CMS_');
$GLOBALS['path_relative'] = "$moduleDir/$module_name_folder/";
$GLOBALS["smarty"]->assign("path_relative", $GLOBALS['path_relative']);
// end

$module_detail->utilise();
$module_detail->activate();
$module_detail->display();

$GLOBALS["smarty"]->template_dir = "../templates/templates";
$GLOBALS["smarty"]->compile_dir = "../templates/templates_c";
$GLOBALS["smarty"]->cache_dir = "../templates/cache";
$GLOBALS["smarty"]->config_dir = "../templates/configs";

