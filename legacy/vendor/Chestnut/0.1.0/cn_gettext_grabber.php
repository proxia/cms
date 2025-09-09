<?php

if(!defined('CN_GETTEXTGRABBER_PHP')):
	define('CN_GETTEXTGRABBER_PHP', true);

class CN_GettextGrabber
{
	private $directory_to_scan = null;

	private $directories_to_skip = array();
	private $files_to_skip = array();
	private $file_types_to_skip = array();

	private $files_to_scan = array();
	private $translation_list = array();


	public function __construct($project_name=null, $directory_to_scan=null)
	{
		if(!is_null($project_name))
			$this->project_name = $project_name;
		if(!is_null($directory_to_scan))
			$this->directory_to_scan = $directory_to_scan;
	}


	public function setDirectoryToScan($directory) { $this->directory_to_scan = $directory; }

	public function setDirectoriesToSkip($directories)
	{
		if(is_array($directories))
			$this->directories_to_skip = $directories;
		else
		{
			$args = func_get_args();

			foreach($args as $directory)
			{
				if(!in_array($directory, $this->directories_to_skip))
					$this->directories_to_skip[] = $directory;
			}
		}
	}

	public function setFilesToSkip($files)
	{
		if(is_array($files))
			$this->files_to_skip = $files;
		else
		{
			$args = func_get_args();

			foreach($args as $file)
			{
				if(!in_array($file, $this->files_to_skip))
					$this->files_to_skip[] = $file;
			}
		}
	}

	public function setFilesTypesToSkip($file_types)
	{
		if(is_array($file_types))
			$this->file_types_to_skip = $file_types;
		else
		{
			$args = func_get_args();

			foreach($args as $file_type)
			{
				if(!in_array($file_type, $this->file_types_to_skip))
					$this->file_types_to_skip[] = $file_type;
			}
		}
	}


	public function grab()
	{
		$this->reset();

		$this->findFilesToScan();
		$this->grabTranslation();

		return $this->translation_list;
	}


	private function reset()
	{
		$this->files_to_scan = array();
		$this->translation_list = array();
	}


	private function findFilesToScan($directory_to_scan=null)
	{
		if(is_null($directory_to_scan))
			$directory_to_scan = realpath($this->directory_to_scan);

		$dir = new DirectoryIterator($directory_to_scan);

		foreach($dir as $dir_entry)
		{
			if($dir_entry->isDot())
				continue;

			if($dir_entry->isDir())
			{
				if(in_array($dir_entry->getFileName(), $this->directories_to_skip))
					continue;

				$this->findFilesToScan($dir_entry->getPath().DIRECTORY_SEPARATOR.$dir_entry->getFileName());
			}
			else
			{
				if($dir_entry->isReadable())
				{
					if(in_array($dir_entry->getFileName(), $this->files_to_skip))
						continue;

					if(in_array(substr($dir_entry, strrpos($dir_entry, '.') + 1), $this->file_types_to_skip))
						continue;

					$this->files_to_scan[] = $dir_entry->getPath().DIRECTORY_SEPARATOR.$dir_entry->getFileName();
				}
			}
		}
	}

	private function grabTranslation()
	{
		foreach($this->files_to_scan as $file)
		{
			if(substr($file, -3) == 'tpl')
			{
				$this->grabTranslationFromTpl($file);

				continue;
			}

			$file_contents = file_get_contents($file);
			$token_list = token_get_all($file_contents);
			$token_found = false;


			foreach($token_list as $token)
			{
				if(is_array($token))
				{
					list($token_id, $token_text) = $token;

					switch($token_id)
					{
						case T_STRING:
							if($token_text == '_' || $token_text == 'tr')
								$token_found = true;
							break;

						case T_CONSTANT_ENCAPSED_STRING:
							if($token_found === true)
							{
								$token_text = trim(substr($token_text, 1, strlen($token_text) - 2));

								if(!in_array($token_text, $this->translation_list))
									$this->translation_list[] =$token_text;

								$token_found = false;
							}
							break;

						default:
							$token_found = false;
							break;
					}
				}
			}
		}
	}


	private function grabTranslationFromTpl($file)
	{
		$file_contents = file_get_contents($file);

		$raw_tpl_translations = array();
		$pattern = '{\{insert name=\'tr\' (.*?)\}}';

		preg_match_all($pattern, $file_contents, $raw_tpl_translations);

		foreach($raw_tpl_translations[0] as $raw_translation)
		{
			$translation = substr($raw_translation, 25, strlen($raw_translation) - 27);

			if(!in_array($translation, $this->translation_list))
				$this->translation_list[] =$translation;
		}

		##

		$raw_tpl_translations = array();
		$pattern = '{\{insert name=\"tr\" (.*?)\}}';

		preg_match_all($pattern, $file_contents, $raw_tpl_translations);

		foreach($raw_tpl_translations[0] as $raw_translation)
		{
			$translation = substr($raw_translation, 25, strlen($raw_translation) - 27);

			if(!in_array($translation, $this->translation_list))
				$this->translation_list[] =$translation;
		}
	}
}

endif;

?>