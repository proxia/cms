 <?php

if(!defined('CMS_USER_PHP')):
	define('CMS_USER_PHP', TRUE);

class CMS_User extends CMS_Entity
{
	const ENTITY_ID = 6;

	const SEX_MALE = 1;
	const SEX_FEMALE = 2;

###################################################################################################
# public
###################################################################################################

	public function __construct($user_id=null)
	{
		if(is_null($this->main_table))
			$this->main_table = 'users';
					
		if(is_null($this->id_column_name))
			$this->id_column_name = 'user_id';

		###########################################################################################
	
		parent::__construct(self::ENTITY_ID, $user_id);
	}

###################################################################################################

	public function getArticlesChangedByUser()
	{
		$uid = $this->id;
		$uid_length = strlen($uid);
		$type_editor = CMS_UserLogin::REGULAR_USER;
		
		$articles = new CMS_ArticleList();
		$articles->addCondition("`update_authors` REGEXP ':{s:7:\"user_id\";s:$uid_length:\"$uid\";s:9:\"user_type\";i:$type_editor;.*}'", null, null, true);
		$articles->execute();
		
		return $articles;
	}

	public function saveLoginDate($date=null)
	{
		if(is_null($date))
			$date = date("Y-m-d H:i:s");
			
		$sql =<<<SQL
		INSERT INTO
			`statistics_user_login`
			(
				`user_id`,
				`login_time`
			)
		VALUES
			(
				{$this->id},
				'$date'
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
	public function saveLogoutDate($login_time)
	{
		$current_date = date("Y-m-d H:i:s");
		
		$sql = <<<SQL
		UPDATE
			`statistics_user_login`
		SET
			`logout_time` = '$current_date'
		WHERE
			`login_time` = '$login_time'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function getLoginHistory($order="login_time")
	{
		$login_history = array();
		
		$sql =<<<SQL
		SELECT
			*
		FROM
			`statistics_user_login`
		WHERE
			`user_id`	= $this->id	
		order by $order	
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
		
		while($query->next())
		{
			$record = $query->fetchRecord();
			
			$current_record = array();
			$current_record['login_time'] = $record->getValue('login_time');
			$current_record['logout_time'] = $record->getValue('logout_time');
			
			$login_history[] = $current_record;
		}
		
		return $login_history;
	}

	public function getGroups()
	{
		$vector = new CN_Vector();

		###########################################################################################

		$sql =<<<SQL
		SELECT
			`group_id`
		FROM
			`users_bindings`
		WHERE
			`user_id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append(new CMS_Group($record->getValue('group_id')));
		}

		###########################################################################################

		return $vector;
	}

	public function getCompany()
	{
		$sql =<<<SQL
		SELECT
			`company_id`
		FROM
			`users`
		WHERE
			`id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if(is_null($query->fetchValue()))
			return null;

		return new CMS_Company($query->fetchValue());
	}

###################################################################################################
# custom config ###################################################################################

	public function setConfigValue($key, $value) { CMS_CustomConfig::getSingleton()->setValue($this, $key, $value); }
	public function getConfigValue($key) { return CMS_CustomConfig::getSingleton()->getValue($this, $key); }
	public function getAllConfig() { return CMS_CustomConfig::getSingleton()->getAll($this); }

###################################################################################################
# privileges ######################################################################################

	public function grantPrivileges($logic_entity_id, $privileges) { CMS_Privileges::getSingleton()->grantPrivileges($this, $logic_entity_id, $privileges); }
	public function revokePrivileges($logic_entity_id) { CMS_Privileges::getSingleton()->revokePrivileges($this, $logic_entity_id); }
	public function revokeAllPrivileges() { CMS_Privileges::getSingleton()->revokeAllPrivileges($this); }
	public function getPrivileges() { return CMS_Privileges::getSingleton()->getPrivileges($this); }
	public function checkPrivilege($logic_entity_id, $privilege) {return CMS_Privileges::getSingleton()->checkPrivilege($this, $logic_entity_id, $privilege); }

	public function checkEditorPrivilege($entity_to_check, $deep_search=true)
	{
	
		if($entity_to_check instanceof CMS_Article || $entity_to_check instanceof CMS_Weblink)
		{
			if($entity_to_check instanceof CMS_Weblink)
				;
			else
			{
				// najskor checkuje ci je entita priamo zakazana

				$editors = strlen($entity_to_check->getEditors()) > 0 ? unserialize($entity_to_check->getEditors()) : array();

				if(in_array($this->id, $editors))
					return false;
			}

			#######################################################################################

			// potom ci je zakazane nadradene menu

			$parent_menus = $entity_to_check->getMenuList();

			foreach($parent_menus as $menu)
			{
				$editors = strlen($menu->getEditors()) > 0 ? unserialize($menu->getEditors()) : array();

				if(in_array($this->id, $editors))
					return false;
			}

			#######################################################################################

			// potom ci je zakazana nadradena kategoria

			$parents = $entity_to_check->getParents();

			if($deep_search === true)
			{
				foreach($parents as $parent_category)
					return $this->checkEditorPrivilege($parent_category, $deep_search);
			}
			else
			{
				foreach($parents as $parent_category)
				{
					$editors = strlen($parent_category->getEditors()) > 0 ? unserialize($parent_category->getEditors()) : array();

					if(in_array($this->id, $editors))
						return false;
				}
			}

			#######################################################################################

			return true; // vykona sa vtedy ked nema ziadneho parenta
		}
		elseif($entity_to_check instanceof CMS_Category)
		{
			// check na nadradene menu

			$parent_menus = $entity_to_check->getMenuList();

			foreach($parent_menus as $menu)
			{
				$editors = strlen($menu->getEditors()) > 0 ? unserialize($menu->getEditors()) : array();

				if(in_array($this->id, $editors))
					return false;
			}

			#######################################################################################

			$editors = strlen($entity_to_check->getEditors()) > 0 ? unserialize($entity_to_check->getEditors()) : array();

			if(in_array($this->id, $editors))
				return false;
			else
			{
				$parent_category = $entity_to_check->getParent();

				if(!is_null($parent_category) && $deep_search === true)
					return $this->checkEditorPrivilege($parent_category, $deep_search);
				else
					return true;
			}
		}
		elseif($entity_to_check instanceof CMS_Menu)
		{
			$editors = strlen($entity_to_check->getEditors()) > 0 ? unserialize($entity_to_check->getEditors()) : array();

			if(in_array($this->id, $editors))
				return false;
	
		}
		return true;
	}

###################################################################################################

	/**
	 * Ulozi vsetky zmeny v hodnotach do databazy.
	 *
	 * @return void
	 */
	public function save()
	{
		if(is_null($this->id))
			$this->insertUser();
		else
			$this->updateUser();
	}

	/**
	 * Odtrani pouzivatela a vsetky vazby z databazy.
	 *
	 * @return void
	 */
	public function delete()
	{
		$query = new CN_SqlQuery("DELETE FROM `users_bindings` WHERE `user_id`={$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM users WHERE id={$this->id}");
		$query->execute();

		$this->current_data = array();
		$this->new_data = array();
	}

###################################################################################################
# private
###################################################################################################

	private function insertUser()
	{
		$company_id = 'NULL';
		$last_login = 'NULL';
		$login = 'NULL';
		$password = 'NULL';
		$nickname = 'NULL';
		$avatar = 'NULL';
		$firstname = 'NULL';
		$familyname = 'NULL';
		$age = 'NULL';
		$sex = 'NULL';
		$title = 'NULL';
		$street = 'NULL';
		$city = 'NULL';
		$zip = 'NULL';
		$country = 'NULL';
		$phone = 'NULL';
		$fax = 'NULL';
		$cell = 'NULL';
		$email = 'NULL';
		$website = 'NULL';
		$is_enabled = 1;
		$is_editor = 0;
		$send_newsletter = 1;

		###########################################################################################

		if(isset($this->new_data['users']['company_id']))
			$company_id = $this->new_data['users']['company_id'] == 'NULL' ? 'NULL' : $this->new_data['users']['company_id'];
		if(isset($this->new_data['users']['last_login']))
			$last_login = $this->new_data['users']['last_login'] == 'NULL' ? 'NULL' : $this->new_data['users']['last_login'];
		if(isset($this->new_data['users']['login']))
			$login = $this->new_data['users']['login'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['login']}'";
		if(isset($this->new_data['users']['password']))
			$password = $this->new_data['users']['password'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['password']}'";
		if(isset($this->new_data['users']['nickname']))
			$nickname = $this->new_data['users']['nickname'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['nickname']}'";
		if(isset($this->new_data['users']['avatar']))
			$avatar = $this->new_data['users']['avatar'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['avatar']}'";
		if(isset($this->new_data['users']['firstname']))
			$firstname = $this->new_data['users']['firstname'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['firstname']}'";
		if(isset($this->new_data['users']['familyname']))
			$familyname = $this->new_data['users']['familyname'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['familyname']}'";
		if(isset($this->new_data['users']['age']))
			$age = $this->new_data['users']['age'] == 'NULL' ? 'NULL' : $this->new_data['users']['age'];
		if(isset($this->new_data['users']['sex']))
			$sex = $this->new_data['users']['sex'] == 'NULL' ? 'NULL' : $this->new_data['users']['sex'];
		if(isset($this->new_data['users']['title']))
			$title = $this->new_data['users']['title'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['title']}'";
		if(isset($this->new_data['users']['street']))
			$street = $this->new_data['users']['street'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['street']}'";
		if(isset($this->new_data['users']['city']))
			$city = $this->new_data['users']['city'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['city']}'";
		if(isset($this->new_data['users']['zip']))
			$zip = $this->new_data['users']['zip'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['zip']}'";
		if(isset($this->new_data['users']['country']))
			$country = $this->new_data['users']['country'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['country']}'";
		if(isset($this->new_data['users']['phone']))
			$phone = $this->new_data['users']['phone'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['phone']}'";
		if(isset($this->new_data['users']['fax']))
			$fax = $this->new_data['users']['fax'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['fax']}'";
		if(isset($this->new_data['users']['cell']))
			$cell = $this->new_data['users']['cell'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['cell']}'";
		if(isset($this->new_data['users']['email']))
			$email = $this->new_data['users']['email'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['email']}'";
		if(isset($this->new_data['users']['website']))
			$website = $this->new_data['users']['website'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['website']}'";
		if(isset($this->new_data['users']['is_enabled']))
			$is_enabled = $this->new_data['users']['is_enabled'] == 'NULL' ? 1 : (int)$this->new_data['users']['is_enabled'];
		if(isset($this->new_data['users']['is_editor']))
			$is_editor = $this->new_data['users']['is_editor'] == 'NULL' ? $is_editor : (int)$this->new_data['users']['is_editor'];
		if(isset($this->new_data['users']['send_newsletter']))
			$send_newsletter = $this->new_data['users']['send_newsletter'] == 'NULL' ? $send_newsletter : (int)$this->new_data['users']['send_newsletter'];

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			users
			(
				`creation`,
				`company_id`,
				`last_login`,
				`login`,
				`password`,
				`nickname`,
				`avatar`,
				`firstname`,
				`familyname`,
				`age`,
				`sex`,
				`title`,
				`street`,
				`city`,
				`zip`,
				`country`,
				`phone`,
				`fax`,
				`cell`,
				`email`,
				`website`,
				`is_enabled`,
				`is_editor`,
				`send_newsletter`
			)
		VALUES
			(
				NOW(),
				$company_id,
				$last_login,
				$login,
				$password,
				$nickname,
				$avatar,
				$firstname,
				$familyname,
				$age,
				$sex,
				$title,
				$street,
				$city,
				$zip,
				$country,
				$phone,
				$fax,
				$cell,
				$email,
				$website,
				$is_enabled,
				$is_editor,
				$send_newsletter
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################
		
		if(!is_null($this->ext_table))
		{
			$this->new_data[$this->ext_table][$this->id_column_name] = $this->id;			
		
			$sql = $this->createExtQuery(CN_SqlQuery::TYPE_INSERT);
			
			$query = new CN_SqlQuery($sql);
			$query->execute();

		}
		
		###########################################################################################

		$this->readData();
	}

	private function updateUser()
	{
		$company_id = $last_login = $login = $password = $nickname = $avatar = $firstname = $familyname = $age = $sex = $title = $street = NULL;
		$city = $zip = $country = $phone = $fax = $cell = $email = $website = $is_enabled = NULL;
		$is_editor = 0;

		$send_newsletter = 1;

		###########################################################################################

		if(isset($this->new_data['users']['company_id']))
			$company_id = $this->new_data['users']['company_id'] == 'NULL' ? 'NULL' : $this->new_data['users']['company_id'];
		else
			$company_id = $this->current_data['users']['company_id'] == 'NULL' ? 'NULL' : $this->current_data['users']['company_id'];

		if(isset($this->new_data['users']['last_login']))
			$last_login = $this->new_data['users']['last_login'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['last_login']}'";
		else
			$last_login = $this->current_data['users']['last_login'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['last_login']}'";

		if(isset($this->new_data['users']['login']))
			$login = $this->new_data['users']['login'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['login']}'";
		else
			$login = $this->current_data['users']['login'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['login']}'";

		if(isset($this->new_data['users']['password']))
			$password = $this->new_data['users']['password'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['password']}'";
		else
			$password = $this->current_data['users']['password'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['password']}'";

		if(isset($this->new_data['users']['nickname']))
			$nickname = $this->new_data['users']['nickname'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['nickname']}'";
		else
			$nickname = $this->current_data['users']['nickname'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['nickname']}'";
			
		if(isset($this->new_data['users']['avatar']))
			$avatar = $this->new_data['users']['avatar'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['avatar']}'";
		else
			$avatar = $this->current_data['users']['avatar'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['avatar']}'";

		if(isset($this->new_data['users']['firstname']))
			$firstname = $this->new_data['users']['firstname'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['firstname']}'";
		else
			$firstname = $this->current_data['users']['firstname'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['firstname']}'";

		if(isset($this->new_data['users']['familyname']))
			$familyname = $this->new_data['users']['familyname'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['familyname']}'";
		else
			$familyname = $this->current_data['users']['familyname'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['familyname']}'";

		if(isset($this->new_data['users']['age']))
			$age = $this->new_data['users']['age'] == 'NULL' ? 'NULL' : $this->new_data['users']['age'];
		else
			$age = $this->current_data['users']['age'] == 'NULL' ? 'NULL' : $this->current_data['users']['age'];

		if(isset($this->new_data['users']['sex']))
			$sex = $this->new_data['users']['sex'] == 'NULL' ? 'NULL' : $this->new_data['users']['sex'];
		else
			$sex = $this->current_data['users']['sex'] == 'NULL' ? 'NULL' : $this->current_data['users']['sex'];

		if(isset($this->new_data['users']['title']))
			$title = $this->new_data['users']['title'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['title']}'";
		else
			$title = $this->current_data['users']['title'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['title']}'";

		if(isset($this->new_data['users']['street']))
			$street = $this->new_data['users']['street'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['street']}'";
		else
			$street = $this->current_data['users']['street'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['street']}'";

		if(isset($this->new_data['users']['city']))
			$city = $this->new_data['users']['city'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['city']}'";
		else
			$city = $this->current_data['users']['city'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['city']}'";

		if(isset($this->new_data['users']['zip']))
			$zip = $this->new_data['users']['zip'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['zip']}'";
		else
			$zip = $this->current_data['users']['zip'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['zip']}'";

		if(isset($this->new_data['users']['country']))
			$country = $this->new_data['users']['country'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['country']}'";
		else
			$country = $this->current_data['users']['country'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['country']}'";

		if(isset($this->new_data['users']['phone']))
			$phone = $this->new_data['users']['phone'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['phone']}'";
		else
			$phone = $this->current_data['users']['phone'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['phone']}'";

		if(isset($this->new_data['users']['fax']))
			$fax = $this->new_data['users']['fax'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['fax']}'";
		else
			$fax = $this->current_data['users']['fax'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['fax']}'";

		if(isset($this->new_data['users']['cell']))
			$cell = $this->new_data['users']['cell'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['cell']}'";
		else
			$cell = $this->current_data['users']['cell'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['cell']}'";

		if(isset($this->new_data['users']['email']))
			$email = $this->new_data['users']['email'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['email']}'";
		else
			$email = $this->current_data['users']['email'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['email']}'";

		if(isset($this->new_data['users']['website']))
			$website = $this->new_data['users']['website'] == 'NULL' ? 'NULL' : "'{$this->new_data['users']['website']}'";
		else
			$website = $this->current_data['users']['website'] == 'NULL' ? 'NULL' : "'{$this->current_data['users']['website']}'";

		if(isset($this->new_data['users']['is_enabled']))
			$is_enabled = $this->new_data['users']['is_enabled'] == 'NULL' ? 1 : (int)$this->new_data['users']['is_enabled'];
		else
			$is_enabled = $this->current_data['users']['is_enabled'] == 'NULL' ? 1 : (int)$this->current_data['users']['is_enabled'];

		if(isset($this->new_data['users']['is_editor']))
			$is_editor = $this->new_data['users']['is_editor'] == 'NULL' ? $is_editor : (int)$this->new_data['users']['is_editor'];
		else
			$is_editor = $this->current_data['users']['is_editor'] == 'NULL' ? $is_editor : (int)$this->current_data['users']['is_editor'];

		if(isset($this->new_data['users']['send_newsletter']))
			$send_newsletter = $this->new_data['users']['send_newsletter'] == 'NULL' ? $send_newsletter : (int)$this->new_data['users']['send_newsletter'];
		else
			$send_newsletter = $this->current_data['users']['send_newsletter'] == 'NULL' ? $send_newsletter : (int)$this->current_data['users']['send_newsletter'];

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`users`
		SET
			`company_id` = $company_id,
			`last_login` = $last_login,
			`login` = $login,
			`password` = $password,
			`nickname` = $nickname,
			`avatar` = $avatar,
			`firstname` = $firstname,
			`familyname` = $familyname,
			`age` = $age,
			`sex` = $sex,
			`title` = $title,
			`street` = $street,
			`city` = $city,
			`zip` = $zip,
			`country` = $country,
			`phone` = $phone,
			`fax` = $fax,
			`cell` = $cell,
			`email` = $email,
			`website` = $website,
			`is_enabled` = $is_enabled,
			`is_editor` = $is_editor,
			`send_newsletter` = $send_newsletter
		WHERE
			id={$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################
		
		if(!is_null($this->ext_table))
		{
			$sql = $this->createExtQuery(CN_SqlQuery::TYPE_UPDATE);

			$query = new CN_SqlQuery($sql);
			$query->execute();

		}
		
		###########################################################################################

		$this->readData();
	}

###################################################################################################
# public static
###################################################################################################

	public static function userExists($login)
	{
		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`users`
		WHERE
			`login` = '$login'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}
}

endif;

?>
