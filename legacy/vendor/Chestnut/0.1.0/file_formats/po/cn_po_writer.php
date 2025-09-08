<?php

if(!defined('CN_POWRITER_PHP')):
	define('CN_POWRITER_PHP', true);

class CN_PoWriter extends CN_FileFormatWriter
{
	private $project_name = null;
	private $project_title = null;
	private $project_version = null;
	private $copyright_holder = null;
	private $copyright_year = null;
	private $first_author = null;
	private $first_author_year = null;
	private $first_author_email = null;
	private $bug_reciever = null;
	private $bug_reciever_email = null;
	private $last_translator = null;
	private $last_translator_email = null;
	private $language_team = null;
	private $language_team_email = null;

	private $data = array();


	public function __construct($target_file=null)
	{
		$this->extension = 'po';
		$this->mime_type[] = 'text/x-gettext-translation';
		$this->type = CN_FileFormat::TYPE_TEXT;

		
		if(!is_null($target_file))
			$this->target_file = $target_file;
	}


	public function setProjectDescription($name, $title=null, $version=null)
	{
		$this->project_name = $name;
		$this->project_title = $title;
		$this->project_version = $version;
	}

	public function setCopyright($holder, $year)
	{
		$this->copyright_holder = $holder;
		$this->copyright_year = $year;
	}

	public function setFirstAuthor($author, $year, $email=null)
	{
		$this->first_author = $author;
		$this->first_author_year = $year;
		$this->first_author_email = $email;
	}

	public function setBugReportReciever($reciever, $email=null)
	{
		$this->bug_reciever = $reciever;
		$this->bug_reciever_email = $email;
	}

	public function setLastTranslator($translator, $email=null)
	{
		$this->last_translator = $translator;
		$this->last_translator_email = $email;
	}

	public function setLanguageTeam($team, $email=null)
	{
		$this->language_team = $team;
		$this->language_team_email = $email;
	}


	public function addData($msgid, $msgstr=null, $flags=null)
	{
		if(!is_null($flags))
		{
			if(!is_array($flags))
				throw new CN_Exception(_("Flags must be an array."), E_ERROR);
			else
				$flags = implode(',', $flags);
		}

		$this->data[$msgid] = array('msgstr' => $msgstr, 'flags' => $flags);
	}


	public function write()
	{
		$current_date = gmdate('Y-m-d G:i+0200'); 
		$header =<<<HEADER
# {$this->project_title}.
# Copyright (C) {$this->copyright_year} {$this->copyright_holder}
# This file is distributed under the same license as the {$this->project_name} package.
# {$this->first_author} <{$this->first_author_email}>, {$this->first_author_year}.
#
#, fuzzy
msgid ""
msgstr ""
"Project-Id-Version: {$this->project_name} {$this->project_version}\\n"
"Report-Msgid-Bugs-To: {$this->bug_reciever} <{$this->bug_reciever_email}>\\n"
"POT-Creation-Date: $current_date\\n"
"PO-Revision-Date: $current_date\\n"
"Last-Translator: {$this->last_translator} <{$this->last_translator_email}>\\n"
"Language-Team: {$this->language_team} <{$this->language_team_email}>\\n"
"MIME-Version: 1.0\\n"
"Content-Type: text/plain; charset=UTF-8\\n"
"Content-Transfer-Encoding: 8bit\\n"
\n
HEADER;

		
		if(is_null($this->target_file))
			throw new CN_Excpetion(_("Target file isn't set."), E_ERROR);

		$file_handle = @fopen($this->target_file, 'w');

		if(!$file_handle)
			throw new CN_Exception(sprintf(_("Couldn't open file `%s` for writing. Check permissions on both file and directory. They must be writable."), $this->target_file), E_ERROR);

		fwrite($file_handle, $header);

		
		foreach($this->data as $msg_key => $msg_data)
		{
			$data = '';

			if(strlen($msg_data['flags']) > 0)
				$data = "#. {$msg_data['flags']}";

			$data .=<<<STRING
msgid "$msg_key"
msgstr "{$msg_data['msgstr']}"
\n
STRING;

			fwrite($file_handle, str_replace("\\", '', $data));
		}

		
		fclose($file_handle);
	}
}

endif;

?>