<?php

if(!defined('CMS_USER_LOGIN_PHP')):
	define('CMS_USER_LOGIN_PHP', true);

class CMS_UserLogin extends CN_Singleton
{
	const ADMIN_USER = 1;
	const REGULAR_USER = 2;

###################################################################################################

	private $user_id = null;
	private $user_type = null;
	private $user_instance = null;

	private $available_sites = null;

###################################################################################################
# public
###################################################################################################

	public function __construct()
	{
		parent::__construct($this);

		###########################################################################################
	}

	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################

	public function setUserType($user_type)
	{
		$this->user_type = $user_type;

		CN_Session::getSingleton()->setName($user_type == self::ADMIN_USER ? 'SID_CMS' : 'SID_PROJECT_'.CMS_ProjectConfig::getSingleton()->getSessionId());
	}

###################################################################################################

	public function isUserLogedIn() { return !is_null($this->user_id); }
	public function getUserType() { return $this->user_type; }
	public function	getUser() { return $this->user_instance; }

###################################################################################################

	public function autoLogin()
	{
		if(!isset($_SESSION))
			CN_Session::getSingleton()->start();

		if(isset($_SESSION['user']))
		{
			$this->user_id = $_SESSION['user']['id'];
			$this->user_type = $_SESSION['user']['type'];

			#######################################################################################

			switch($this->user_type)
			{
				case self::ADMIN_USER:
					$this->user_instance = new CMS_AdminUser($this->user_id);
					$this->available_sites = $this->user_instance->getForkData();
					break;

				default:
					$this->user_instance = new CMS_User($this->user_id);
					break;
			}

			$this->user_instance->setLastLogin(date("Y-m-d H:i:s"));
			$this->user_instance->save();
		}
	}

	public function login($login, $password, $calculate_md5=true)
	{
	
		$md5_password = null;
		$table_name = null;

		###########################################################################################

		if($calculate_md5 === true)
			$md5_password = md5($password);
		else
			$md5_password = $password;

		###########################################################################################

		switch($this->user_type)
		{
			case self::ADMIN_USER:
				$table_name = 'admin_users';
				break;

			default:
				$table_name = 'users';
				break;
		}

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`$table_name`
		WHERE
			`login` = '$login' AND
			`password` = '$md5_password' AND
			`is_enabled` = 1
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->getSize() != 1)
			throw new CN_Exception(tr("Prihlásenie zlyhalo. Skontrolujte meno a heslo."), E_WARNING);
		elseif ($query->getSize() > 1)
			throw new CN_Exception(tr("Viac používateľov má rovnake meno a heslo. Kontaktuje administrátora systmu."), E_WARNING);

		$this->user_id = $query->fetchValue('id');

		###########################################################################################

		$user = array(
						'id' => $this->user_id,
						'type' => $this->user_type
					);

		CN_Session::getSingleton()->register('user', $user);

		###########################################################################################

		switch($this->user_type)
		{
			case self::ADMIN_USER:
				$this->user_instance = new CMS_AdminUser($this->user_id);
				$this->available_sites = $this->user_instance->getForkData();
				break;

			default:
				$this->user_instance = new CMS_User($this->user_id);
				break;
		}

		$current_date = date("Y-m-d H:i:s");
		$_SESSION['user']['login_date'] = $current_date;
					
		$this->user_instance->setLastLogin($current_date);
		$this->user_instance->save();

		$this->user_instance->saveLoginDate($current_date);		
	}

###################################################################################################

	public function logout()
	{
		$this->user_instance->saveLogoutDate($_SESSION['user']['login_date']);
			
		unset($_SESSION['user']);

		$this->user_id = null;
		$this->user_type = null;
		$this->user_instance = null;
		$this->available_sites = null;
	}

###################################################################################################

	public function getAvailableSites() { return $this->available_sites; }

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }
}

endif;

?>
