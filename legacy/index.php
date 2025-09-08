<?php

if (!isset($_SESSION['user']) && !isset($_GET['session'])) {
    $site_name = "";
    if (isset($_GET['site_name']))
        $site_name = "&site_name=" . $_GET['site_name'];
    Header("Location: ./?session=expired" . $site_name);
    exit;
}


if (!isset($_GET['cmd'])) $_GET['cmd'] = false;
if (!isset($_GET['message'])) $_GET['message'] = false;
if (!isset($_GET['mcmd'])) $_GET['mcmd'] = 1;
if (!isset($_GET['module'])) $_GET['module'] = false;
if (!isset($_GET['form_name'])) $_GET['form_name'] = "form1";
if (!isset($_GET['form_text_name'])) $_GET['form_text_name'] = "img";
if (!isset($_GET['m_directory'])) $_GET['m_directory'] = false;
if (!isset($_REQUEST['cmd'])) $_REQUEST['cmd'] = false;
if (!isset($_REQUEST['s_category'])) $_REQUEST['s_category'] = false;
if (!isset($_GET['s_author'])) $_GET['s_author'] = false;
if (!isset($_GET['setSite'])) $_GET['setSite'] = false;
if (!isset($_GET['start'])) $_GET['start'] = 0;
if (!isset($_GET['setLocalLanguage'])) $_GET['setLocalLanguage'] = false;
if (!isset($_GET['setPreferedLanguage'])) $_GET['setPreferedLanguage'] = false;
if (!isset($_GET['site_name'])) $_GET['site_name'] = false;
if ($_GET['start'] == "") $_GET['start'] = 0;
if (!isset($_GET['q'])) $_GET['q'] = false;
if (!isset($_GET['perpage'])) $_GET['perpage'] = false;
if (!isset($_GET['order'])) $_GET['order'] = false;
if (!isset($_GET['setup_type'])) $_GET['setup_type'] = false;
if (!isset($_GET['setMediaView'])) $_GET['setMediaView'] = false;
if (!isset($_GET['setExpandTree'])) $_GET['setExpandTree'] = false;
if (!isset($_GET['setProxia'])) $_GET['setProxia'] = false;
if (!isset($_GET['setCatalog'])) $_GET['setCatalog'] = false;
if (!isset($GLOBALS['proxiaType'])) $GLOBALS['proxiaType'] = 'web';

if ($_GET['order']) {
    $explode = explode("_", $_GET['order']);
    $GLOBALS['sortby'] = strtolower($explode[0]);
    $GLOBALS['direction'] = strtoupper($explode[1]);
}

require_once("vendor/smarty/Smarty.class.php");

include("scripts/class.php");

include("scripts/config.php");

// test
include("scripts/classes/tpl_list.php");

$cn_application = CN_Application::getSingleton();

/*$mod = CMS_Module::addModule('cms_modules\cms_gallery\classes\CMS_Gallery');
$mod->utilise();*/
####################################################################################################

$GLOBALS['project_folder'] = "/www";

$smarty = new Smarty();

$GLOBALS['smarty'] = $smarty;

$smarty->register_resource('Proxia', array(
    'Proxia_getTemplate',
    'Proxia_getTimestamp',
    'Proxia_isSecure',
    'Proxia_isTrusted'
));

$smarty->plugins_dir[] = 'smarty_plugins';

$smarty->template_dir = "templates/templates";
$smarty->compile_dir = "templates/templates_c";
$smarty->cache_dir = "templates/cache";
$smarty->config_dir = "templates/configs";

$smarty->assign("project_folder", $GLOBALS['project_folder']);
$smarty->assign("theme_path", "./");

$smarty->assign("cmd", $_GET['cmd']);
$smarty->assign("mcmd", $_GET['mcmd']);
$smarty->assign("message", urldecode($_GET['message']));
$smarty->assign("module", $_GET['module']);
$smarty->assign("start", $_GET['start']);
$smarty->assign("site_name", $_GET['site_name']);
$smarty->assign("s_category", $_REQUEST['s_category']);
$smarty->assign("ACCESS_PUBLIC", CMS::ACCESS_PUBLIC);
$smarty->assign("ACCESS_REGISTERED", CMS::ACCESS_REGISTERED);
$smarty->assign("ACCESS_SPECIAL", CMS::ACCESS_SPECIAL);

$smarty->assign("proxia", $GLOBALS['proxia']);


$u = CMS_UserLogin::getSingleton();

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['type'] == CMS_UserLogin::ADMIN_USER) {
        $u->setUserType(CMS_UserLogin::ADMIN_USER);
        $u->autoLogin();
    } elseif ($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER) {
        //include("../www/".$_SESSION['user']['name']."/config/dblogin_source.php");
        /*if (!isset($GLOBALS['project_config']))
            $GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);*/

        $u->setUserType(CMS_UserLogin::REGULAR_USER);
        $u->autoLogin();
    }
}


if ($_GET['cmd'] == 'logout') {
    if ($u->getUserType() == CMS_UserLogin::REGULAR_USER)
        $smarty->assign('site_name', $_SESSION['user']['name']);

    if ($u->getUserType() != null)
        $u->logout();
}

if ($u->isuserLogedIn() === false) {

    $smarty->assign("is_login", 0);
    $smarty->display("header.tpl");
    $smarty->display("login.tpl");

} else {

    $site_name = null;

    //$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);


    if ($_SESSION['user']['type'] == CMS_UserLogin::ADMIN_USER) {
        $sites = $u->getAvailableSites();

        if (!isset($_SESSION['user']['dsn']))
            $_SESSION['user']['dsn'] = false;

        if (!isset($_SESSION['user']['site_name']))
            $_SESSION['user']['site_name'] = false;

        $smarty->assign("sites", $sites);
        $num_sites = 0;

        foreach ($sites as $value) {
            $dsn[] = $value['dsn'];
            $site_name[] = $value['site_name'];
            $name[] = $value['name'];
            $num_sites++;

            if ($_GET['setSite'] == $value['site_name']) {

                $_SESSION['user']['dsn'] = $value['dsn'];
                $_SESSION['user']['site_name'] = $value['site_name'];
                $_SESSION['user']['name'] = $value['name'];
                $_SESSION['history'] = null;
            }
        }

        if ($num_sites == 0)
            exit;

        if ($num_sites == 1) {
            $_SESSION['user']['dsn'] = $dsn[0];
            $_SESSION['user']['site_name'] = $site_name[0];
            $_SESSION['user']['name'] = $name[0];
        }

        if (($num_sites > 1) && (!$_SESSION['user']['dsn'])) {
            $smarty->display("header.tpl");
            $smarty->display("sites.tpl");
            $smarty->display("bottom.tpl");
            exit;
        }
    }

    if ($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER) {
        $_SESSION['user']['dsn'] = $GLOBALS['project_config']->getSqlDsn();
        $_SESSION['user']['name'] = $_SESSION['user']['name'];
        $_SESSION['user']['site_name'] = $GLOBALS['project_config']->getName();
    }

    $smarty->assign("site_name_selected", $_SESSION['user']['site_name']);
    $smarty->assign("site_name_name", $_SESSION['user']['name']);
    $smarty->assign("is_login", 1);

    //  START POSLEDNEJ DB
    if (!isset($GLOBALS['project_config']))
        $GLOBALS['project_config'] = new CMS_ProjectConfig($_SESSION['user']['name']);
//echo


    // zaciatok zobrazovania

    // NASTAVENIE PREMENNYCH PRE PRAVA   ######################################################################

    $GLOBALS['user_login_type'] = $_SESSION['user']['type'];
    $smarty->assign("user_login_type", $GLOBALS['user_login_type']);

    $smarty->assign("privilege_access", CMS_Privileges::ACCESS_PRIVILEGE);
    $smarty->assign("privilege_view", CMS_Privileges::VIEW_PRIVILEGE);
    $smarty->assign("privilege_add", CMS_Privileges::ADD_PRIVILEGE);
    $smarty->assign("privilege_delete", CMS_Privileges::DELETE_PRIVILEGE);
    $smarty->assign("privilege_update", CMS_Privileges::UPDATE_PRIVILEGE);
    $smarty->assign("privilege_restore", CMS_Privileges::RESTORE_PRIVILEGE);

    $GLOBALS['user_login'] = CMS_UserLogin::getSingleton()->getUser();
    $smarty->assign("user_login", $GLOBALS['user_login']);

    $smarty->assign("regular_user", CMS_UserLogin::REGULAR_USER);
    $smarty->assign("admin_user", CMS_UserLogin::ADMIN_USER);

    // ########################################################################################################
    $smarty->assign("currentUserName", $GLOBALS['user_login']->getFirstname() . "&nbsp;" . $GLOBALS['user_login']->getFamilyname());

    $GLOBALS["config_all"] = CN_Config::loadFromFile("../config/config.xml");

    if (isset($_GET['setPerPage']))
        $_SESSION['perpage'] = $_GET['setPerPage'];

    if (isset($_SESSION['perpage'])) {
        if ($_SESSION['perpage'] > 0) {
            $GLOBALS["perpage"] = $_SESSION['perpage'];

        }
    } else
        $GLOBALS['perpage'] = getConfig('proxia', 'records_per_page');

    if (!isset($GLOBALS['perpage'])) $GLOBALS['perpage'] = null;

    if ($GLOBALS['perpage'] == 'null')
        $GLOBALS['perpage'] = null;

    // NASTAVENIE JAZYKOV

    //nacitanie zoznamu jazykov z db
    $GLOBALS['menuLang'] = CMS_Languages::getSingleton("CMS_Languages");

    $GLOBALS['LanguageList'] = $GLOBALS['menuLang']->getList();

    $GLOBALS['LanguageListLocal'] = array();

    foreach ($GLOBALS['LanguageList'] as $value) {
        if ($value['local_visibility']) {
            $a[$value['code']] = $value;
            $GLOBALS['LanguageListLocal'] = array_merge($GLOBALS['LanguageListLocal'], $a);
        }
    }

    $smarty->assign("LanguageListLocal", $GLOBALS['LanguageListLocal']);
    $smarty->assign("LanguageList", $GLOBALS['LanguageList']);

    // zmena jazyka zobrazujuceho obsah
    if ($_GET['setLocalLanguage']) {
        $user_detail = CMS_UserLogin::getSingleton()->getUser();
        $user_detail->setConfigValue('default_local_language', $_GET['setLocalLanguage']);
    }

    // zmena jazyka aplikacie
    if ($_GET['setPreferedLanguage']) {
        $user_detail = CMS_UserLogin::getSingleton()->getUser();
        $user_detail->setConfigValue('prefered_language', $_GET['setPreferedLanguage']);

        // ak existuje jazyk obsahu ako sa prave nastavil jazyk aplikacie tak ho nastavi

        foreach ($GLOBALS['LanguageList'] as $value) {
            if (($value['code'] == $_GET['setPreferedLanguage']) && ($value['local_visibility'] == 1)) {
                $user_detail->setConfigValue('default_local_language', $_GET['setPreferedLanguage']);
            }
        }
    }

    // nastavenie prave zobrazujuceho jazyka obsahu
    $user_detail = CMS_UserLogin::getSingleton()->getUser();
    $GLOBALS['localLanguage'] = $user_detail->getConfigValue('default_local_language');

    if (!$GLOBALS['localLanguage'])
        $GLOBALS['localLanguage'] = getConfig('proxia', 'default_local_language');

    $_SESSION['localLanguage'] = $GLOBALS['localLanguage'];
    $smarty->assign("localLanguage", $GLOBALS['localLanguage']);

    // nastavenie jazyka aplikacie
    $GLOBALS['preferedLanguage'] = $user_detail->getConfigValue('prefered_language');
    if (!$GLOBALS['preferedLanguage'])
        $GLOBALS['preferedLanguage'] = getConfig('proxia', 'prefered_language');

    $cn_application->setLanguage($GLOBALS['preferedLanguage']);
    $GLOBALS['preferedLanguageDefault'] = $user_detail->getConfigValue('prefered_language');

    // nastavenie predvoleneho (default) jazyka, pouziva sa ak nie je definovany prave zobrazujuci jazyk obsahu
    $GLOBALS['localLanguageDefault'] = getConfig('proxia', 'default_local_language');
    $smarty->assign("localLanguageDefault", $GLOBALS['localLanguageDefault']);

    // nastavenie vyznacenia zobrazenia default jazyka ak nie je naplneny prave pozadovany zobrazovany jazyk obsahu
    $GLOBALS['defaultViewStartTag'] = '[';
    $GLOBALS['defaultViewEndTag'] = ']';

    $smarty->assign("defaultViewStartTag", $GLOBALS['defaultViewStartTag']);
    $smarty->assign("defaultViewEndTag", $GLOBALS['defaultViewEndTag']);

    // END JAZYKY


    // zmena media view
    if ($_GET['setMediaView']) {
        $user_detail = CMS_UserLogin::getSingleton()->getUser();
        $user_detail->setConfigValue('media_view', $_GET['setMediaView']);
    }


    // nacitanie media view
    $user_detail = CMS_UserLogin::getSingleton()->getUser();
    $GLOBALS['mediaView'] = $user_detail->getConfigValue('media_view');

    if (!$GLOBALS['mediaView'])
        $GLOBALS['mediaView'] = getConfig('proxia', 'prefered_media_view');

    $smarty->assign("mediaView", $GLOBALS['mediaView']);


    // zmena expandTree
    if ($_GET['setExpandTree']) {
        $user_detail = CMS_UserLogin::getSingleton()->getUser();
        if ($_GET['setExpandTree'] == 'show')
            $user_detail->setConfigValue('expand_tree', 1);
        elseif ($_GET['setExpandTree'] == 'hidden')
            $user_detail->setConfigValue('expand_tree', 0);
    }

    // nacitanie expand tree
    $user_detail = CMS_UserLogin::getSingleton()->getUser();
    $GLOBALS['expandTree'] = $user_detail->getConfigValue('expand_tree');

    if (!$GLOBALS['expandTree'])
        $GLOBALS['expandTree'] = getConfig('proxia', 'prefered_expand_tree');

    $smarty->assign("expandTree", $GLOBALS['expandTree']);


    $smarty->assign("currentSiteName", $_SESSION['user']['site_name']);
    $smarty->assign("session_time", floor((ini_get('session.gc_maxlifetime') - 60) / 60));
    if (isset($_SESSION['history']))
        $smarty->assign("history_table", array_reverse($_SESSION['history']));


    if (CMS_ProjectConfig::getSingleton()->checkModuleAvailability('cms_modules\cms_gallery\classes\CMS_Gallery')) {

    }

    $GLOBALS['proxiaCatalog'] = 0;
    $GLOBALS['proxiaType'] = 'web';

    if (CMS_ProjectConfig::getSingleton()->checkModuleAvailability('cms_modules\cms_catalog\classes\CMS_Catalog')) {
        $module = CMS_Module::addModule('cms_modules\cms_catalog\classes\CMS_Catalog');
        $module->utilise();

        // zmena Proxia_type
        if ($_GET['setProxia']) {
            $user_detail = CMS_UserLogin::getSingleton()->getUser();
            if ($_GET['setProxia'] == 'web')
                $user_detail->setConfigValue('proxia_type', 'web');
            elseif ($_GET['setProxia'] == 'catalog')
                $user_detail->setConfigValue('proxia_type', 'catalog');

            if (isset($_SESSION['currentCatalog'])) unset ($_SESSION['currentCatalog']);

        }

        // nacitanie Proxia type
        $user_detail = CMS_UserLogin::getSingleton()->getUser();
        $GLOBALS['proxiaType'] = $user_detail->getConfigValue('proxia_type');

        if (!$GLOBALS['proxiaType'])
            $GLOBALS['proxiaType'] = 'web';


        $GLOBALS['proxiaCatalog'] = 1;

        if ($_GET['setCatalog']) {
            $_SESSION['currentCatalog'] = $_GET['setCatalog'];
        }

        if (isset($_SESSION['currentCatalog'])) {
            $catalog = new CMS_Catalog($_SESSION['currentCatalog']);
            $catalog->setContextLanguage($GLOBALS['localLanguage']);
            $GLOBALS["smarty"]->assign("catalog_title", $catalog->getTitle());
            $GLOBALS["smarty"]->assign("catalog_id", $catalog->getId());
        }

    }

    $smarty->assign("proxiaType", $GLOBALS['proxiaType']);
    $smarty->assign("proxiaCatalog", $GLOBALS['proxiaCatalog']);

    if (($GLOBALS['proxiaType'] == 'catalog') && !($_GET['module']) && ($_GET['cmd'] != 29) && ($_GET['cmd'] != 30)) {
        $_GET['module'] = 'cms_modules\cms_catalog\classes\CMS_Catalog';
        $_REQUEST['module'] = 'cms_modules\cms_catalog\classes\CMS_Catalog';
        $_GET['cmd'] = null;
    }

    if ($GLOBALS['proxiaType'] == 'catalog') {
        $GLOBALS['expandTree'] = 'hidden';
        $smarty->assign("expandTree", $GLOBALS['expandTree']);
    }

    if (CMS_ProjectConfig::getSingleton()->checkModuleAvailability('cms_modules\cms_inquiry\classes\CMS_Inquiry')) {
        $module = CMS_Module::addModule('cms_modules\cms_inquiry\classes\CMS_Inquiry');
        $module->utilise();

    }

    if (CMS_ProjectConfig::getSingleton()->checkModuleAvailability('CMS_EventCalendar')) {
        $module = CMS_Module::addModule('CMS_EventCalendar');
        $module->utilise();

    }

    $GLOBALS["current_link"] = urlGet();
    $smarty->assign("current_link", $GLOBALS["current_link"]);

    $smarty->display("header.tpl");

    // vypnutie menu pri moduloch
    $GLOBALS['use_module'] = 0;//($_GET['module']) ? 1 : 0 ;


    // nahlad obrazkov
    if ($_REQUEST['cmd'] == 29) {
        if ($_GET['m_directory'] === false) {
            if ((isset ($_SESSION['last_m_directory'])) && ($_SESSION['last_m_directory'] != ''))
                $_GET['m_directory'] = $_SESSION['last_m_directory'];
            else {
                $_GET['m_directory'] = "/";
                $_SESSION['last_m_directory'] = $_GET['m_directory'];
            }
        } else {
            if (($_GET['m_directory'] == '') || ($_GET['m_directory'] === false))
                $_GET['m_directory'] = "/";
            else
                $_SESSION['last_m_directory'] = $_GET['m_directory'];

        }


        if (($_GET['m_directory'] == '') || ($_GET['m_directory'] === false))
            $_GET['m_directory'] = "/";

        $_SESSION['last_m_directory'] = $_GET['m_directory'];

        $directory = urldecode($_GET['m_directory']);
        $GLOBALS["smarty"]->assign("media_list", getDirectoryList($directory));
        $GLOBALS["smarty"]->assign("m_directory", $_GET['m_directory']);
        $GLOBALS["smarty"]->assign("form_name", $_GET['form_name']);
        $GLOBALS["smarty"]->assign("form_text_name", $_GET['form_text_name']);
        if (isset($_GET['form_text_title']))
            $GLOBALS["smarty"]->assign("form_text_title", $_GET['form_text_title']);
        else
            $GLOBALS["smarty"]->assign("form_text_title", "no_support");

        if (isset($_GET['media_path_output']))
            $GLOBALS["smarty"]->assign("media_path_output", $_GET['media_path_output']);
        else
            $GLOBALS["smarty"]->assign("media_path_output", "no_support");

        $GLOBALS["smarty"]->display("media_list_paste.tpl");
    } elseif ($_GET['cmd'] == 30) {
        $smarty->display("preview.tpl");
    } elseif ($_GET['module']) {
        //echo $_GET['mcmd'];
        $smarty->display("main_module.tpl");
    } else
        $smarty->display("main.tpl");

}

$smarty->display("bottom.tpl");
