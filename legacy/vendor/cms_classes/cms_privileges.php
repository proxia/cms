<?php

if(!defined('CMS_PRIVILEGES_PHP')):
	define('CMS_PRIVILEGES_PHP', true);

class CMS_Privileges extends CN_Singleton
{
	const ACCESS_PRIVILEGE = 1;
	const VIEW_PRIVILEGE = 2;
	const ADD_PRIVILEGE = 4;
	const DELETE_PRIVILEGE = 8;
	const UPDATE_PRIVILEGE = 16;
	const RESTORE_PRIVILEGE = 32;


	const ALL_PRIVILEGES = 63; // sum of all above privileges

###################################################################################################
# public
###################################################################################################

	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################

	public function grantPrivileges($requester, $logic_entity_id, $privileges)
	{
		switch($requester->getType())
		{
			case CMS_User::ENTITY_ID:
			case CMS_Group::ENTITY_ID:
				break;

			default:
				throw new CN_Exception(tr('You must pass valid instance of `CMS_User` or `CMS_Group`.'), E_ERROR);
				break;
		}

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`privileges`
		WHERE
			`entity_id` = {$requester->getId()} AND
			`entity_type` = {$requester->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		if($query->getSize() == 0)
		{
			$serialized_privileges = serialize(array($logic_entity_id => $privileges));

			$sql =<<<SQL
			INSERT INTO
				`privileges`
				(
					`entity_id`,
					`entity_type`,
					`privileges`
				)
			VALUES
				(
					{$requester->getId()},
					{$requester->getType()},
					'$serialized_privileges'
				)
SQL;
		}
		elseif($query->getSize() == 1)
		{
			$current_privileges = unserialize($query->fetchValue('privileges'));
			$current_privileges[$logic_entity_id] = $privileges;

			$serialized_privileges = serialize($current_privileges);

			#######################################################################################

			$sql =<<<SQL
			UPDATE
				`privileges`
			SET
				`privileges` = '$serialized_privileges'
			WHERE
				`entity_id` = {$requester->getId()} AND
				`entity_type` = {$requester->getType()}
SQL;
		}
		else
			throw new CN_Exception(tr("Loose data in table `privileges`."), E_ERROR);

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function revokePrivileges($requester, $logic_entity_id)
	{
		switch($requester->getType())
		{
			case CMS_User::ENTITY_ID:
			case CMS_Group::ENTITY_ID:
				break;

			default:
				throw new CN_Exception(tr('You must pass valid instance of CMS_User or CMS_Group'), E_ERROR);
				break;
		}

		###########################################################################################

		$sql =<<<SQL
		SELECT
			`privileges`
		FROM
			`privileges`
		WHERE
			`entity_id` = {$requester->getId()} AND
			`entity_type` = {$requester->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->getSize() == 1)
		{
			$current_privileges = unserialize($query->fetchValue('privileges'));

			if(isset($current_privileges[$logic_entity_id]))
				unset($current_privileges[$logic_entity_id]);

			$serialized_privileges = serialize($current_privileges);

			$sql =<<<SQL
			UPDATE
				`privileges`
			SET
				`privileges` = '$serialized_privileges'
			WHERE
				`entity_id` = {$requester->getId()} AND
				`entity_type` = {$requester->getType()}
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}
		elseif($query->getSize() == 0)
			throw new CN_Exception(tr("Requester not found in table `privileges`."), E_ERROR);
		else
			throw new CN_Exception(tr("Loose data in table `privileges`."), E_ERROR);
	}

	public function revokeAllPrivileges($requester)
	{
		switch($requester->getType())
		{
			case CMS_User::ENTITY_ID:
			case CMS_Group::ENTITY_ID:
				break;

			default:
				throw new CN_Exception(tr('You must pass valid instance of CMS_User or CMS_Group'), E_ERROR);
				break;
		}

		###########################################################################################

		$sql =<<<SQL
		DELETE
		FROM
			`privileges`
		WHERE
			`entity_id` = {$requester->getId()} AND
			`entity_type` = {$requester->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################

	public function getPrivileges($requester)
	{
		$privileges = array();

		###########################################################################################

		$sql =<<<SQL
		SELECT
			`privileges`
		FROM
			`privileges`
		WHERE
			`entity_id` = {$requester->getId()} AND
			`entity_type` = {$requester->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->getSize() == 1)
			$privileges = unserialize($query->fetchValue());

		###########################################################################################

		return $privileges;
	}

###################################################################################################

	public function checkPrivilege($requester, $logic_entity_id, $privilege_to_check)
	{
		if($requester instanceof CMS_User)
		{
			$user_privileges = $this->getPrivileges($requester);

			if(isset($user_privileges[$logic_entity_id]))
			{
				if($user_privileges[$logic_entity_id] & $privilege_to_check)
					return true;
			}

			#######################################################################################

			$group_list = $requester->getGroups();

			foreach($group_list as $group)
			{
				$group_privileges = $this->getPrivileges($group);

				if(isset($group_privileges[$logic_entity_id]))
				{
					if($group_privileges[$logic_entity_id] & $privilege_to_check)
						return true;
				}
			}
		}
		###########################################################################################
		elseif($requester instanceof CMS_Group)
		{
			$group_privileges = $requester->getPrivileges();

			if(isset($group_privileges[$logic_entity_id]))
			{
				if($group_privileges[$logic_entity_id] & $privilege_to_check)
					return true;
			}
		}
		else
			throw new CN_Exception(tr('You must pass valid instance of CMS_User or CMS_Group'), E_ERROR);

		return false;
	}

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }
	
	public static function checkWebAccessPrivilege(CMS_Entity & $entity)
	{
		$passed_privilege_check = true;
		
		switch($entity->getAccess())
		{
			case CMS::ACCESS_REGISTERED:
				if(!CMS_UserLogin::getSingleton()->isUserLogedIn())
					$passed_privilege_check = false;			
				break;
				
			case CMS::ACCESS_SPECIAL:
				$user_login = CMS_UserLogin::getSingleton();
			
				if(!$user_login->isUserLogedIn())
					$passed_privilege_check = false;
				else
				{
					$passed_privilege_check = false;
					
					$category_groups = unserialize($entity->getAccessGroups());
					$user_groups = $user_login->getUser()->getGroups();
					
					foreach($user_groups as $user_group)
					{
						if(in_array($user_group->getId(), $category_groups))
							$passed_privilege_check = true;
					}
				}
				break;
		}
		
		return $passed_privilege_check;
	}

###################################################################################################
}

endif;

?>