<?php
ini_set('magic_quotes_gpc', 0);
$GLOBALS['project_folder'] = '/www';

ini_set("include_path",ini_get('include_path').PATH_SEPARATOR.realpath('../../../../../../../'));

require_once("../../../../../../../__admin_init__.php");

/*require_once("chestnut/cn_core.php");
$cn_application = CN_Application::getSingleton();
CN_ClassLoader::getSingleton()->addSearchPath('../../../../../../../classes/');
$cn_application->setDebug(false);
$cn_application->utiliseModule('CN_Containers');

CN_ClassLoader::getSingleton()->registerClassPrefix('CMS_');

require_once("../../../../../../../cms_core.php");*/
/*
$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);

include("../../../../../../dblogin.php");

$data->setDataSource("proxia");
$data->open();

$u = CMS_UserLogin::getSingleton();
$u->setUserType(CMS_UserLogin::ADMIN_USER);
$u->autoLogin();

CN_SqlDatabase::removeDatabase();
$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);

include("../../../../../../..".$GLOBALS['project_folder']."/".$_SESSION['user']['name']."/config/dblogin_source.php");
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
	$lang = $project_options->getValue('proxia','default_local_language');
	$default_local_language = $lang["value"];
}catch (CN_Exception $e) {
	$default_local_language = "sk";
}

//echo $default_local_language;

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{$lang_insert_link_title}</title>
	<script language="javascript" type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="../../utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="../../utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="jscripts/link.js"></script>
	<script language="javascript" type="text/javascript">
function zapisLink() {
	var clanok = document.getElementById("article").value;
	var clanokIndex = document.getElementById("article").selectedIndex;
	var clanokText = document.getElementById("article").options[clanokIndex].text;
	if (clanok == 0)
		document.getElementById("href").value = "";
	else{
		document.getElementById("href").value = "./Article:"+clanok;
		document.getElementById("linktitle").value = clanokText;
		}
}

function insertfile(form_name,form_text_name){
		var x1 = 700;
		var y1 = 400;
     	var left = screen.width/2 - x1/2;
     	var top = screen.height/2 - y1/2;
    	window.open("../../../../../../?cmd=29&form_name="+form_name+"&form_text_name="+form_text_name,"prehlad","scrollbars=yes,width="+x1+",height="+y1+",left="+left+",top="+top);
}

</script>
	<base target="_self" />
</head>
<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');" style="display: none">
<form onsubmit="insertLink();return false;" action="#">
	<div class="tabs">
		<ul>
			<li id="general_tab" class="current"><span><a href="javascript:mcTabs.displayTab('general_tab','general_panel');" onmousedown="return false;">{$lang_insert_link_title}</a></span></li>
		</ul>
	</div>

	<div class="panel_wrapper">
		<div id="general_panel" class="panel current">

		<table border="0" cellpadding="4" cellspacing="0">
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
					
										//	echo "<option value=\"".$article_id->getId()."\">".$article_id->getTitle()."</option>";
										}
									?>
								</select>
							</td>
						  </tr>
          <tr>
            <td nowrap="nowrap"><label for="href">{$lang_insert_link_url}</label></td>
            <td><table border="0" cellspacing="0" cellpadding="0"> 
				  <tr> 
					<td><input id="href" name="href" type="text" value="" style="width: 200px" /></td> 
					<td id="hrefbrowsercontainer">&nbsp;</td>
				  </tr> 
				</table></td>
          </tr>
		  <!-- Link list -->
		  <script language="javascript">
			if (typeof(tinyMCELinkList) != "undefined" && tinyMCELinkList.length > 0) {
				var html = "";

				html += '<tr><td><label for="link_list">{$lang_link_list}</label></td>';
				html += '<td><select id="link_list" name="link_list" style="width: 200px" onchange="this.form.href.value=this.options[this.selectedIndex].value;">';
				html += '<option value="">---</option>';

				for (var i=0; i<tinyMCELinkList.length; i++)
					html += '<option value="' + tinyMCELinkList[i][1] + '">' + tinyMCELinkList[i][0] + '</option>';

				html += '</select></td></tr>';

				document.write(html);
			}
		  </script>
		  <!-- /Link list -->
          <tr>
            <td nowrap="nowrap"><label for="target">{$lang_insert_link_target}</label></td>
            <td><select id="target" name="target" style="width: 200px">
                <option value="_self">{$lang_insert_link_target_same}</option>
                <option value="_blank">{$lang_insert_link_target_blank}</option>
				<script language="javascript">
					var html = "";
					var targets = tinyMCE.getParam('theme_advanced_link_targets', '').split(';');

					for (var i=0; i<targets.length; i++) {
						var key, value;

						if (targets[i] == "")
							continue;

						key = targets[i].split('=')[0];
						value = targets[i].split('=')[1];

						html += '<option value="' + value + '">' + key + '</option>';
					}

					document.write(html);
				</script>
            </select></td>
          </tr>
          <tr>
            <td nowrap="nowrap"><label for="linktitle">{$lang_theme_insert_link_titlefield}</label></td>
            <td><input id="linktitle" name="linktitle" type="text" value="" style="width: 200px"></td>
          </tr>
          <tr id="styleSelectRow">
            <td><label for="styleSelect">{$lang_class_name}</label></td>
            <td>
			 <select id="styleSelect" name="styleSelect">
                <option value="" selected>{$lang_theme_style_select}</option>
             </select></td>
          </tr>
        </table>
		</div>
	</div>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="insert" name="insert" value="{$lang_insert}" onclick="insertLink();" />
		</div>

		<div style="float: right">
			<input type="button" id="cancel" name="cancel" value="{$lang_cancel}" onclick="tinyMCEPopup.close();" />
		</div>
	</div>
</form>
</body>
</html>
