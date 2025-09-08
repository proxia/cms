<?php
//var_dump($_POST);EXIT;

if(!isset($_POST['go']))$_POST['go'] = false;
if(!isset($_POST['pu__odpoved']))$_POST['pu__odpoved'] = false;
if(!isset($_POST['pu__image']))$_POST['pu__image'] = false;
if(!isset($_POST['qu_question']))$_POST['qu_question'] = false;
if(!isset($_POST['delete']))$_POST['delete'] = false;
if(!isset($_POST['delete_answer']))$_POST['delete_answer'] = false;

try
{
	ini_set("include_path",ini_get('include_path').PATH_SEPARATOR.realpath('../../'));

	$GLOBALS['project_folder']="/_sub";

	##############################################
	# login

	if(isset($_SESSION['user'])){
		$u = CMS_UserLogin::getSingleton();

		if($_SESSION['user']['type'] == CMS_UserLogin::ADMIN_USER){
			$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);

			include("admin/dblogin.php");

			$data->setDataSource("proxia");
			$data->open();

			$u->setUserType(CMS_UserLogin::ADMIN_USER);
			$u->autoLogin();
		}
		elseif($_SESSION['user']['type'] == CMS_UserLogin::REGULAR_USER){
			$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);

			if (!isset($GLOBALS['project_config']))
				$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);

			$data->setUser($GLOBALS['project_config']->getSqlUser());
			$data->setPassword($GLOBALS['project_config']->getSqlPassword());
			$data->setDataSource($GLOBALS['project_config']->getSqlDsn());
			$data->open();

			$u->setUserType(CMS_UserLogin::REGULAR_USER);
			$u->autoLogin();
		}

		CN_SqlDatabase::removeDatabase();
	}

	##############################################

	$data = CN_SqlDatabase::addDatabase(CN_SqlDatabase::DRIVER_MYSQL);

	include ("admin/themes/{$GLOBALS['current_theme']}/scripts/functions.php");

	$path = "../../".$GLOBALS['project_folder']."/".$_SESSION['user']['name']."/config";

	//  START DB
	if (!isset($GLOBALS['project_config']))
		$GLOBALS['project_config']= new CMS_ProjectConfig($_SESSION['user']['name']);

	$data->setUser($GLOBALS['project_config']->getSqlUser());
	$data->setPassword($GLOBALS['project_config']->getSqlPassword());

	$data->setDataSource($_SESSION['user']['dsn']);
	$data->open();

	$GLOBALS["config_all"] = CN_Config::loadFromFile($path."/config.xml");

	// LANGUAGE LOCAL
	$user_detail = CMS_UserLogin::getSingleton()->getUser();
	$GLOBALS['localLanguage'] = $user_detail->getConfigValue('default_local_language');
	if (!$GLOBALS['localLanguage'])
		$GLOBALS['localLanguage'] = getConfig('proxia','default_local_language');
	####################################################################################################

	CN_ClassLoader::getSingleton()->addSearchPath('classes/');
	$module_detail = CMS_Module::addModule('CMS_Inquiry');
	$module_detail->utilise();
	if($_POST['section'] == 'new'):
		if (is_Array($_POST['row_id'])){

			// PRESMERUJE NA UPDATE CATEGORY
			if($_POST['go']==3){
				$ignore = array ("mcmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				$link = urlPost($ignore);
				Header("Location: ../../admin/?mcmd=3&module=CMS_Inquiry$link");
				exit;
			}

			foreach ($_POST['row_id'] as $name => $id){
				$ankety = $id === '0' ? new CMS_Inquiry() : new CMS_Inquiry($id);
				$ankety->setContextLanguage($GLOBALS['localLanguage']);

				foreach($_POST as $column_name => $value){

					if(strpos($column_name, 'f_') !== FALSE){

						$column_name = str_replace('f_', '', $column_name);

						$function = 'set'.ucfirst($column_name);

						$ankety->$function($value);
					}
				}// END FOREACH F_

				$ankety->save();
				$quest = new CMS_Inquiry_Question();
				$quest->setContextLanguage($GLOBALS['localLanguage']);

				foreach($_POST as $column_name => $value){
					if(strpos($column_name, 'q_') !== FALSE){

						$column_name = str_replace('q_', '', $column_name);

						$function = 'set'.ucfirst($column_name);

						$quest->$function($value);

					}
				}

				$quest->save();
				$ankety->addQuestion($quest);
				$new_id = $quest->getId();

				foreach($_POST as $column_name => $value){
					if(strpos($column_name, 'p__') !== FALSE){
						//$column_name = str_replace('p__', '', $column_name);
						$code = substr($column_name,10);
						$answer = new CMS_Inquiry_Answer();
						$answer->setContextLanguage($GLOBALS['localLanguage']);
						$answer->setQuestionId($new_id);
						$answer->setAnswer($value);
						$answer->setImage($_POST['i__image'.$code]);
						$answer->save();
					}
				}

			}// END FOREACH ROW_ID

		}// END IF $_POST['row_id']
	endif;

	############################################################################################################

	if($_POST['section'] == 'language_visibility'):
		if (is_Array($_POST['row_id'])){


				$anketa = new CMS_Inquiry($_POST['row_id'][0]);
				$anketa->setContextLanguage($_POST['language']);
				$anketa->setLanguage_is_visible($_POST['language_is_visible']);
				$anketa->save();

		}
	endif;
	############################################################################################################

	if($_POST['section'] == 'edit'):
		if (is_Array($_POST['row_id'])){

			// PRESMERUJE NA UPDATE CATEGORY

			if($_POST['go']==3){
				$ignore = array ("mcmd","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
				$link = urlPost($ignore);
				Header("Location: ../../admin/?mcmd=3&module=CMS_Inquiry$link");
				exit;
			}

			foreach ($_POST['row_id'] as $name => $id){
				$ankety = $id === '0' ? new CMS_Inquiry() : new CMS_Inquiry($id);
				$ankety->setContextLanguage($GLOBALS['localLanguage']);

				foreach($_POST as $column_name => $value){

					if(strpos($column_name, 'f_') !== FALSE){

						$column_name = str_replace('f_', '', $column_name);

						$function = 'set'.ucfirst($column_name);

						$ankety->$function($value);

					}
				}// END FOREACH F_

				$ankety->save();


				if(is_array($_POST['qu_question'])){
					foreach($_POST['qu_question'] as $question_id => $value){
						$quest = new CMS_Inquiry_Question($question_id);
						$quest->setContextLanguage($GLOBALS['localLanguage']);
						$quest->setQuestion($value);
						$quest->save();
					}
				}

				if(is_array($_POST['pu__odpoved'])){
					foreach($_POST['pu__odpoved'] as $answer_id => $value){
						$answer = new CMS_Inquiry_Answer($answer_id);
						$answer->setContextLanguage($GLOBALS['localLanguage']);
						$answer->setAnswer($value);
						$answer->save();
					}
				}

				if(is_array($_POST['pu__image'])){
					foreach($_POST['pu__image'] as $answer_id => $value){
						$answer = new CMS_Inquiry_Answer($answer_id);
						$answer->setContextLanguage($GLOBALS['localLanguage']);
						$answer->setImage($value);
						$answer->save();
					}
				}

				foreach($_POST as $column_name => $value){
					if(strpos($column_name, 'p__') !== FALSE){
						//$column_name = str_replace('p__', '', $column_name);
						$code = substr($column_name,10);
						$answer = new CMS_Inquiry_Answer();
						$answer->setContextLanguage($GLOBALS['localLanguage']);
						$answer->setQuestionId($question_id);
						$answer->setAnswer($value);
						$answer->setImage($_POST['i__image'.$code]);
						$answer->save();
					}
				}

				if($_POST['delete']==1){
					$ankety->delete();
				}
			}// END FOREACH ROW_ID

			if (is_Array($_POST['delete_answer'])){
				foreach($_POST['delete_answer'] as $column_name => $value){
					$answer = new CMS_Inquiry_Answer($value);
					$answer->delete();
				}
			}

		}// END IF $_POST['row_id']
	endif;


	if ($_POST['go'] == 'list') {
		Header("Location: ../../admin/?mcmd=1&module=CMS_Inquiry");
		exit;
	}

	if ($_POST['go'] == 'edit') {
		$ignore = array ("row_id","cmd","f_parent_id","section","go","add_menu_id","add_category_id","remove_menu_id","remove_category_id","restore","delete","trash","move_down","move_up","act","f_title","f_description","f_isPublished");
		$link = urlPost($ignore);
		Header("Location: ../../admin/?mcmd=3&module=CMS_Inquiry&row_id[]=$new_id$link");
		exit;
	}

	Header("Location: ../../admin/?module=CMS_Inquiry&mcmd=1");
	exit;

}
catch(CN_Exception $e){
	echo $e->displayDetails();
}
?>
