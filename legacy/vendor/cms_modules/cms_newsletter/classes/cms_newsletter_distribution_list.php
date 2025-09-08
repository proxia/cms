<?php

if(!defined('CMS_NEWSLETTER_DISTRIBUTIONLIST_PHP')):
	define('CMS_NEWSLETTER_DISTRIBUTIONLIST_PHP', true);

# phpmailer
require_once('phpmailer/class.phpmailer.php');
require_once('phpmailer/class.smtp.php');
#

class CMS_Newsletter_DistributionList extends CMS_Entity
{
	const ENTITY_ID = 161;

	const FORMAT_PLAIN_TEXT = 1;
	const FORMAT_HTML = 2;

	private $parent_distribution_list = null;

###################################################################################################
# public
###################################################################################################

	public function __construct($distribution_list_id=null)
	{
		$this->main_table = 'newsletter_distribution_lists';
		$this->lang_table = 'newsletter_distribution_lists_lang';
		$this->id_column_name = 'distribution_list_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $distribution_list_id);
	}

	public function setParentDistributionList(& $obj)
	{
		$this->parent_distribution_list = $obj->getId();
	}

###################################################################################################
# recipients handling #############################################################################

	public function importRecipientsFromCSV($file_path, $field_delimiter, $string_delimiter)
	{
		$file_contents = file($file_path);

		###########################################################################################

		$columns = explode($field_delimiter, $file_contents[0]);
		$columns2 = array();

		foreach($columns as $value)
			$columns2[] = trim($value, $string_delimiter);

		$columns = $columns2;

		###########################################################################################

		$row_count = count($file_contents);

		for($i = 1; $i < $row_count; $i++)
		{
			$data = explode($field_delimiter, $file_contents[$i]);

			$email = trim($data[array_search('email', $columns)], $string_delimiter);
			$first_name = trim($data[array_search('first_name', $columns)], $string_delimiter);
			$family_name = trim($data[array_search('family_name', $columns)], $string_delimiter);
			$note = trim($data[array_search('note', $columns)], $string_delimiter);

			$this->addExternalRecipient($email, $first_name, $family_name, $note);
		}
	}

###################################################################################################

	public function addRecipient($recipient)
	{
		if($this->isInExcludeList($recipient->getEmail()) === true)
			return;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`newsletter_recipients`
		WHERE
			`distribution_list_id` = {$this->id} AND
			`email` = '{$recipient->getEmail()}'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->fetchValue() > 0)
			return;

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`newsletter_recipients`
			(
				`{$this->id_column_name}`,
				`entity_id`,
				`entity_type`
			)
		VALUES
			(
				{$this->id},
				{$recipient->getId()},
				{$recipient->getType()}
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeRecipient($recipient)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`newsletter_recipients`
		WHERE
			`{$this->id_column_name}` = {$this->id} AND
			`entity_id` = {$recipient->getId()} AND
			`entity_type` = {$recipient->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function isRecipient($recipient)
	{
		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`newsletter_recipients`
		WHERE
			`{$this->id_column_name}` = {$this->id} AND
			`entity_id` = {$recipient->getId()} AND
			`entity_type` = {$recipient->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

	public function addExternalRecipient($email, $first_name=null, $family_name=null, $note=null)
	{
		if($this->isInExcludeList($email) === true)
			return;

		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`newsletter_recipients`
		WHERE
			`distribution_list_id` = {$this->id} AND
			`email` = '$email'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->fetchValue() > 0)
			return;

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`newsletter_recipients`
			(
				`{$this->id_column_name}`,
				`first_name`,
				`family_name`,
				`email`,
				`note`
			)
		VALUES
			(
				{$this->id},
				'$first_name',
				'$family_name',
				'$email',
				'$note'
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeExternalRecipient($email)
	{
		$sql =<<<SQL
		DELETE
		FROM
			`newsletter_recipients`
		WHERE
			`{$this->id_column_name}` = {$this->id} AND
			`email` = '$email'
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function isExternalRecipient($email)
	{
		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`newsletter_recipients`
		WHERE
			`email` = '$email' AND
			`{$this->id_column_name}` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

###################################################################################################

	public function getRecipients()
	{
		$recipient_list = array();

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`newsletter_recipients`
		WHERE
			`{$this->id_column_name}` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			if(!is_null($record->getValue('entity_id')))
			{
				$class_name = CMS_Entity::getEntityNameById($record->getValue('entity_type'));

				$recipient = new $class_name($record->getValue('entity_id'));
			}
			else
			{
				$recipient = array();
				$recipient['first_name'] = $record->getValue('first_name');
				$recipient['family_name'] = $record->getValue('family_name');
				$recipient['email'] = $record->getValue('email');
				$recipient['note'] = $record->getValue('note');
			}

			$recipient_list[] = $recipient;
		}

		###########################################################################################

		return $recipient_list;
	}

###################################################################################################
# send ############################################################################################

	public function send($format, $language='en')
	{
		$module = CMS_Module::addModule('CMS_Newsletter');
		$config = $module->getConfig();

		$cancel_link = null;

		###########################################################################################

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'utf-8';

		/*
		$host = $config->getValue('mail_server', 'url');
		$username = $config->getValue('mail_server', 'user');
		$password = $config->getValue('mail_server', 'password');
		*/
		
		$mail->SMTPAuth = true;
		$mail->Host = '';
		$mail->Username = '';
		$mail->Password = '';

		###########################################################################################

		$project_config = CN_Config::loadFromFile($GLOBALS['cms_root'].'/_sub/'.$_SESSION['user']['name'].'/config/config.xml');

		$site_url = $project_config->getValue('site', 'url');

		if($format == self::FORMAT_HTML)
		{
			$mail->IsHTML(true);
			$mail->ContentType = 'text/html';

			$cancel_link =<<<LINK

###################################################################################################
<br /><br />
<a href="{$site_url['value']}/Unsubscribe:{$this->parent_distribution_list}:(u:%s)">
Kliknite sem ak už nechcete odoberať tento newsletter.
</a>
<br /><br />
LINK;
		}
		else
		{
			$mail->IsHTML(false);
			$mail->ContentType = 'text/plain';

			$cancel_link =<<<LINK

###################################################################################################

Kliknite sem ak už nechcete odoberať tento newsletter.
{$site_url['value']}/Unsubscribe:{$this->parent_distribution_list}:(u:%s)

LINK;
		}

		###########################################################################################

		$mail->Sender = $this->getSender();
		$mail->From = $this->getSender();

		if(!is_null($this->getSenderName()))
			$mail->FromName = $this->getSenderName();
		else
			$mail->FromName = 'Proxia Newsletter';

		###########################################################################################

		$template = new CMS_Article($this->getTemplate());
		$template->setContextLanguage($language);

		$mail->Subject = $template->getDescription();

		$attachments = $template->getAttachments();

		foreach($attachments as $attachment)
		{
			$attachment->setContextLanguage($language);

			$file_path = $GLOBALS['cms_root'].'/_sub/'.$_SESSION['user']['name'].'/mediafiles/'.$attachment->getFile();

			$mail->addAttachment($file_path, basename($attachment->getFile()));
		}

		###########################################################################################

		$recipient_list = $this->getRecipients();

		foreach($recipient_list as $recipient)
		{
			$mail->Body = $this->customizeText($template->getText(), $recipient);

			{
				if(is_object($recipient))
					$mail->Body .= sprintf($cancel_link, sha1($recipient->getEmail()));
				else
					$mail->Body .= sprintf($cancel_link, sha1($recipient['email']));
			}

			$mail->Body = str_replace('src="', 'src="'.$site_url['value'], $mail->Body);

			#######################################################################################

			if($recipient instanceof CMS_User)
				$mail->addAddress($recipient->getEmail(), $recipient->getFirstname().' '.$recipient->getFamilyname());
			elseif($recipient instanceof CMS_Company)
				$mail->addAddress($recipient->getEmail(), $recipient->getOfficialName());
			else
				$mail->addAddress($recipient['email'], $recipient['first_name'].' '.$recipient['family_name']);

			$status = (int)$mail->Send();

			if(is_object($recipient))
			{
				$sql =<<<SQL
				UPDATE
					`newsletter_recipients`
				SET
					`newsletter_send` = $status
				WHERE
					`distribution_list_id` = {$this->id} AND
					`entity_id` = {$recipient->getId()} AND
					`entity_type` = {$recipient->getType()}
SQL;

				$query = new CN_SqlQuery($sql);
				$query->execute();
			}
			else
			{
				$sql =<<<SQL
				UPDATE
					`newsletter_recipients`
				SET
					`newsletter_send` = $status
				WHERE
					`distribution_list_id` = {$this->id} AND
					`email` = '{$recipient['email']}'
SQL;

				$query = new CN_SqlQuery($sql);
				$query->execute();
			}

			$mail->clearAddresses();
		}

		###########################################################################################

		$query = new CN_SqlQuery("UPDATE `{$this->main_table}` SET `send_date` = NOW() WHERE `id` = {$this->id}");
		$query->execute();
	}

###################################################################################################
###################################################################################################

	public function cloneDistributionList()
	{
		$new_distribution_list = new CMS_Newsletter_DistributionList();
		$old_context_language = $this->context_language;

		###########################################################################################

		$new_distribution_list->setIsEnabled($this->getIsEnabled());
		$new_distribution_list->setSender($this->getSender());

		foreach($this->current_data[$this->lang_table] as $language => $language_version)
		{
			$this->context_langauge = $language;
			$new_distribution_list->setContextLanguage($language);

			$new_distribution_list->setTitle($this->getTitle());
			$new_distribution_list->setDescription($this->getDescription());
		}

		$new_distribution_list->save();

		###########################################################################################

		$recipient_list = $this->getRecipients();

		foreach($recipient_list as $recipient)
		{
			if(is_object($recipient))
			{
				if(!CMS_Newsletter::isInExcludeList($recipient->getEmail()))
					$new_distribution_list->addRecipient($recipient);
			}
			else
			{
				if(!CMS_Newsletter::isInExcludeList($recipient['email']))
					$new_distribution_list->addExternalRecipient($recipient['email'], $recipient['first_name'], $recipient['family_name'], $recipient['note']);
			}
		}

		###########################################################################################

		return $new_distribution_list;
	}

###################################################################################################

	public function save()
	{
		if(is_null($this->id))
			$this->insertEntity();
		else
			$this->updateEntity();

		$this->updateLanguageVersions();
	}

	public function delete()
	{
		# recipients delete #########################################################################
		$query = new CN_SqlQuery("DELETE FROM `newsletter_recipients` WHERE `{$this->id_column_name}` = {$this->id}");
		$query->execute();

		# language delete #########################################################################
		$query = new CN_SqlQuery("DELETE FROM `{$this->lang_table}` WHERE `{$this->id_column_name}` = {$this->id}");
		$query->execute();

		# main delete #############################################################################
		$query = new CN_SqlQuery("DELETE FROM `{$this->main_table}` WHERE `id` = {$this->id}");
		$query->execute();
	}

###################################################################################################
# private
###################################################################################################

	private function insertEntity()
	{
		$is_enabled = 1;
		$sender = "''";
		$sender_name = 'NULL';
		$template = 0;
		$send_date = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['is_enabled']))
			$is_enabled = $this->new_data[$this->main_table]['is_enabled'] === 'NULL' ? $is_enabled : (int)$this->new_data[$this->main_table]['is_enabled'];
		if(isset($this->new_data[$this->main_table]['sender']))
			$sender = $this->new_data[$this->main_table]['sender'] === 'NULL' ? $sender : "'{$this->new_data[$this->main_table]['sender']}'";
		if(isset($this->new_data[$this->main_table]['sender_name']))
			$sender_name = $this->new_data[$this->main_table]['sender_name'] === 'NULL' ? $sender_name : "'{$this->new_data[$this->main_table]['sender_name']}'";
		if(isset($this->new_data[$this->main_table]['template']))
			$template = $this->new_data[$this->main_table]['template'] === 'NULL' ? $template : $this->new_data[$this->main_table]['template'];
		if(isset($this->new_data[$this->main_table]['send_date']))
			$send_date = $this->new_data[$this->main_table]['send_date'] === 'NULL' ? $send_date : "'{$this->new_data[$this->main_table]['send_date']}'";

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`is_enabled`,
				`sender`,
				`sender_name`,
				`template`,
				`send_date`
			)
		VALUES
			(
				NOW(),
				$is_enabled,
				$sender,
				$sender_name,
				$template,
				$send_date
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateEntity()
	{
		$is_enabled = 1;
		$sender = "''";
		$sender_name = 'NULL';
		$template = 0;
		$send_date = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['is_enabled']))
			$is_enabled = $this->new_data[$this->main_table]['is_enabled'] === 'NULL' ? (int)$is_enabled : (int)$this->new_data[$this->main_table]['is_enabled'];
		else
			$is_enabled = $this->current_data[$this->main_table]['is_enabled'] === 'NULL' ? (int)$is_enabled : (int)$this->current_data[$this->main_table]['is_enabled'];

		if(isset($this->new_data[$this->main_table]['sender']))
			$sender = $this->new_data[$this->main_table]['sender'] === 'NULL' ? $sender : "'{$this->new_data[$this->main_table]['sender']}'";
		else
			$sender = $this->current_data[$this->main_table]['sender'] === 'NULL' ? $sender : "'{$this->current_data[$this->main_table]['sender']}'";

		if(isset($this->new_data[$this->main_table]['sender_name']))
			$sender_name = $this->new_data[$this->main_table]['sender_name'] === 'NULL' ? $sender_name : "'{$this->new_data[$this->main_table]['sender_name']}'";
		else
			$sender_name = $this->current_data[$this->main_table]['sender_name'] === 'NULL' ? $sender_name : "'{$this->current_data[$this->main_table]['sender_name']}'";

		if(isset($this->new_data[$this->main_table]['template']))
			$template = $this->new_data[$this->main_table]['template'] === 'NULL' ? $template : $this->new_data[$this->main_table]['template'];
		else
			$template = $this->current_data[$this->main_table]['template'] === 'NULL' ? $template : $this->current_data[$this->main_table]['template'];

		if(isset($this->new_data[$this->main_table]['send_date']))
			$send_date = $this->new_data[$this->main_table]['send_date'] === 'NULL' ? $send_date : "'{$this->new_data[$this->main_table]['send_date']}'";
		else
			$send_date = $this->current_data[$this->main_table]['send_date'] === 'NULL' ? $send_date : "'{$this->current_data[$this->main_table]['send_date']}'";

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`is_enabled` = $is_enabled,
			`sender` = $sender,
			`sender_name` = $sender_name,
			`template` = $template,
			`send_date` = $send_date
		WHERE
			`id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateLanguageVersions()
	{
		$title = "''";
		$description = 'NULL';

		###########################################################################################

		foreach($this->new_data[$this->lang_table] as $language => $language_version)
		{
			if(isset($language_version['title']))
				$title = $language_version['title'] === 'NULL' ? $title : "'{$language_version['title']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['title']))
				$title = $this->current_data[$this->lang_table][$language]['title'] == 'NULL' ? $title : "'{$this->current_data[$this->lang_table][$language]['title']}'";

			if(isset($language_version['description']))
				$description = $language_version['description'] === 'NULL' ? 'NULL' : "'{$language_version['description']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['description']))
				$description = $this->current_data[$this->lang_table][$language]['description'] === 'NULL' ? $description : "'{$this->current_data[$this->lang_table][$language]['description']}'";

			###########################################################################################

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				`{$this->lang_table}`
			WHERE
				`{$this->id_column_name}` = {$this->id} AND
				`language` = '$language'
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();

			$record_count = $query->fetchValue();

			###########################################################################################

			if($record_count == 0)
			{
				$sql =<<<SQL
				INSERT INTO
					`{$this->lang_table}`
					(
						`{$this->id_column_name}`,
						`language`,
						`title`,
						`description`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$title,
						$description
					)
SQL;
			}
			elseif($record_count == 1)
			{
				$sql =<<<SQL
				UPDATE
					`{$this->lang_table}`
				SET
					`title` = $title,
					`description` = $description
				WHERE
					`{$this->id_column_name}` = {$this->id} AND
					`language` = '$language'
SQL;
			}
			else
				throw new CN_Exception(sprintf(tr("There are loose data in table `%1\$s` for `id` %2\$s.", $this->lang_table, $this->id)), E_ERROR);

			$query = new CN_SqlQuery($sql);
			$query->execute();

			###########################################################################################

			$title = "''";
			$description = 'NULL';
		}

		###############################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}

###################################################################################################

	private function customizeText($text, $recipient)
	{
		$tags = array(
			'<*firstname*>' => array('CMS_User' => 'firstname', 'CMS_Company' => 'officialName', 'array' => 'first_name'),
			'<*familyname*>' => array('CMS_User' => 'familyname', 'CMS_Company' => null, 'array' => 'family_name'),
			'<*fullname*>' => array('CMS_User' => 'firstname;familyname; ', 'CMS_Company' => 'officialName', 'array' => 'first_name;family_name; ')
		);

		###########################################################################################

		$object_logic = is_object($recipient);

		if($object_logic === true)
			$entity_name = CMS_Entity::getEntityNameById($recipient->getType());
		else
			$entity_name = 'array';

		###########################################################################################

		foreach($tags as $tag => $value)
		{
			$replacement_data = $value[$entity_name];
			$replacement_value = '';

			if(strpos($replacement_data, ';') !== false)
			{
				$fields = explode(';', $replacement_data);
				$delimiter = array_pop($fields);

				foreach($fields as $field_name)
				{
					if($object_logic === true)
					{
						$function_name = 'get'.$field_name;

						$replacement_value .= $recipient->$function_name();
					}
					else
						$replacement_value .= $recipient[$field_name];

					$replacement_value .= $delimiter;
				}

				$replacement_value = substr($replacement_value, 0, strlen($replacement_value) - 1);
			}
			elseif(!is_null($replacement_data))
			{
				$field_name = $replacement_data;

				if($object_logic === true)
				{
					$function_name = 'get'.$field_name;

					$replacement_value .= $recipient->$function_name();
				}
				else
					$replacement_value .= $recipient[$field_name];
			}

			#######################################################################################

			$text = str_replace($tag, $replacement_value, $text);
		}

		###########################################################################################

		return $text;
	}
}

endif;

?>