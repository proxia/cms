<?php
ini_set('magic_quotes_gpc', 0);
$GLOBALS['project_folder'] = '/www';

ini_set("include_path",ini_get('include_path').PATH_SEPARATOR.realpath('../../../../../../'));

require_once("../../../../../../__admin_init__.php");

/*require_once("chestnut/cn_core.php");
$cn_application = CN_Application::getSingleton();
CN_ClassLoader::getSingleton()->addSearchPath('../../../../../../classes/');
$cn_application->setDebug(false);
$cn_application->utiliseModule('CN_Containers');

CN_ClassLoader::getSingleton()->registerClassPrefix('CMS_');

require_once("../../../../../../cms_core.php");*/
/*
$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);

include("../../../../../dblogin.php");

$data->setDataSource("proxia");
$data->open();

$u = CMS_UserLogin::getSingleton();
$u->setUserType(CMS_UserLogin::ADMIN_USER);
$u->autoLogin();

CN_SqlDatabase::removeDatabase();
$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);

include("../../../../../..".$GLOBALS['project_folder']."/".$_SESSION['user']['name']."/config/dblogin_source.php");
*/

$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);

$GLOBALS['project_folder']="/www";

//include ("scripts/functions.php");

 //  START DB
if (!isset($GLOBALS['project_config']))
	$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);
$data->setUser($GLOBALS['project_config']->getSqlUser());
$data->setPassword($GLOBALS['project_config']->getSqlPassword());

$data->setDataSource($_SESSION['user']['dsn']);

$data->open();

$article = new CMS_ArticleList();
$article->addCondition("is_archive", 0);
$article->addCondition("is_trash", 0);
$article->addCondition("usable_by",CMS_Entity::ENTITY_UNIVERSAL);
$article->execute();

if($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER)
	$u = new CMS_User($_SESSION['user']['id']);
	
try{
	$project_options = CN_Config::loadFromFile($GLOBALS['cms_root']."www/".$_SESSION['user']['name'].'/config/config.xml');
	$lang = $project_options->getValue('proxia', 'default_local_language');
	$default_local_language = $lang["value"];
}catch (CN_Exception $e) {
	$default_local_language = "sk";
}
	

?>
<html>

<head>
  <title>Insert/Modify Link</title>
  <script type="text/javascript" src="popup.js"></script>
  <link rel="stylesheet" type="text/css" href="popup.css" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <script type="text/javascript">
    window.resizeTo(400, 200);

HTMLArea = window.opener.HTMLArea;

function i18n(str) {
  return (HTMLArea._lc(str, 'HTMLArea'));
}

function onTargetChanged() {
  var f = document.getElementById("f_other_target");
  if (this.value == "_other") {
    f.style.visibility = "visible";
    f.select();
    f.focus();
  } else f.style.visibility = "hidden";
}

function Init() {
  __dlg_translate('HTMLArea');
  __dlg_init();

  // Make sure the translated string appears in the drop down. (for gecko)
  document.getElementById("f_target").selectedIndex = 1;
  document.getElementById("f_target").selectedIndex = 0;

  var param = window.dialogArguments;
  var href  = (param["f_href"]=="") ? "http://" : param["f_href"] ;
  var target_select = document.getElementById("f_target");
  var use_target = true;
  if (param) {
    if ( typeof param["f_usetarget"] != "undefined" ) {
      use_target = param["f_usetarget"];
    }
    if ( typeof param["f_href"] != "undefined" ) {
      document.getElementById("f_href").value = href;
      document.getElementById("f_title").value = param["f_title"];
      comboSelectValue(target_select, param["f_target"]);
      if (target_select.value != param.f_target) {
        var opt = document.createElement("option");
        opt.value = param.f_target;
        opt.innerHTML = opt.value;
        target_select.appendChild(opt);
        opt.selected = true;
      }
    }
  }
  if (! use_target) {
    document.getElementById("f_target_label").style.visibility = "hidden";
    document.getElementById("f_target").style.visibility = "hidden";
    document.getElementById("f_target_other").style.visibility = "hidden";
  }
  var opt = document.createElement("option");
  opt.value = "_other";
  opt.innerHTML = i18n("Other");
  target_select.appendChild(opt);
  target_select.onchange = onTargetChanged;
  document.getElementById("f_href").focus();
  document.getElementById("f_href").select();
}

function onOK() {
  var required = {
    // f_href shouldn't be required or otherwise removing the link by entering an empty
    // url isn't possible anymore.
    // "f_href": i18n("You must enter the URL where this link points to")
  };
  for (var i in required) {
    var el = document.getElementById(i);
    if (!el.value) {
      alert(required[i]);
      el.focus();
      return false;
    }
  }
  // pass data back to the calling window
  var fields = ["f_href", "f_title", "f_target" ];
  var param = new Object();
  for (var i in fields) {
    var id = fields[i];
    var el = document.getElementById(id);
    param[id] = el.value;
  }
  if (param.f_target == "_other")
    param.f_target = document.getElementById("f_other_target").value;
  __dlg_close(param);
  return false;
}

function onCancel() {
  __dlg_close(null);
  return false;
}

function zapisLink() {
	var clanok = document.getElementById("article").value;
	var clanokIndex = document.getElementById("article").selectedIndex;
	var clanokText = document.getElementById("article").options[clanokIndex].text;
	if (clanok == 0)
		document.getElementById("f_href").value = "";
	else{
		document.getElementById("f_href").value = "./Article:"+clanok;
		document.getElementById("f_title").value = clanokText;
		}
}

function insertfile(form_name,form_text_name){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("../../../../../?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
}
</script>

</head>

<body class="dialog" onload="Init()">
<div class="title">Insert/Modify Link</div>
<form name='form_popup'>
<table border="0" style="width: 100%;">
   <tr>
    <td class="label">Article:</td>
    <td>
		<select name="article" onchange="zapisLink()">
			<option value="0">select article</option>
			<?
				foreach ($article as $article_id){

					if($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER)
					{
						if($u->checkEditorPrivilege($article_id,false) === false)
							continue;
					}
					$article_id->setContextLanguage($_SESSION['localLanguage']);
					$curent_language = $article_id->getContextLanguage(); 

					if($article_id->getTitle()==""){
							$article_id->setContextLanguage($default_local_language);
							echo "<option value=\"".$article_id->getId()."\">[".$article_id->getTitle()."]</option>";							
					}else{
							echo "<option value=\"".$article_id->getId()."\">".$article_id->getTitle()."</option>";					
					}		

					$article_id->setContextLanguage($curent_language);
				}
			?>
		</select>
	</td>
  </tr>
  <tr>
    <td valign="top" class="label">URL:</td>
    <td>
    	<input type="text" id="f_href"  style="width: 100%"  />
    	<a href="javascript:insertfile('form_popup','f_href')" title="{insert name='tr' value='vlož obrázok'}"><img src="../../../images/paste.gif" width="21" height="21" border="0"></a>
    </td>
  </tr>
  <tr>
    <td class="label">Title (tooltip):</td>
    <td><input type="text" id="f_title" style="width: 100%" /></td>
  </tr>
  <tr>
    <td class="label"><span id="f_target_label">Target:</span></td>
    <td><select id="f_target">
      <option value="">None (use implicit)</option>
      <option value="_blank">New window (_blank)</option>
      <option value="_self">Same frame (_self)</option>
      <option value="_top">Top frame (_top)</option>
    </select>
    <input type="text" name="f_other_target" id="f_other_target" size="10" style="visibility: hidden" />
    </td>
  </tr>
</table>

<div id="buttons">
  <button type="submit" name="ok" onclick="return onOK();">OK</button>
  <button type="button" name="cancel" onclick="return onCancel();">Cancel</button>
</div>
</form>
</body>
</html>
