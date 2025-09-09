<?php

class MediaMassUpload
{
	protected $_base_media_path = null;
	
	public function __construct($project_folder = null)
	{
			
		if(!empty($project_folder))
		{
			$this->_base_media_path = preg_replace('/\/{2,}/', '/', "$project_folder/");
		}

	}

	
	public function uploadMassFile($max_size = 6000000)
	{
		foreach ($_FILES as $file => $value)
			$_FILES[$file]['name'] = utf2ascii($_FILES[$file]['name']);

		try
		{
			$tmp_dir = $this->_createTmpDir();

			$upload = new CN_FileUpload();
			$upload->setTargetDirectory($tmp_dir);
			$upload->setMaxSize($max_size);
			$upload->upload();

			foreach ($_FILES as $file_id => $file_info)
			{
				$archive = "$tmp_dir/{$file_info['name']}";

				chmod($archive, 0660);

				$extension = strrpos($file_info['name'], '.') !== false ? substr($file_info['name'], strrpos($file_info['name'], '.') + 1) : null;

				if (file_exists($archive) && ($file_info['type'] == 'application/zip' || $extension == 'zip') && class_exists('ZipArchive', false))
				{
					$target_dir = null;

					do
					{
						$target_dir = "$tmp_dir/upload_".uniqid(mt_rand(), true);
					}
					while (file_exists($target_dir));

					$this->unpackZipFile($archive, $target_dir);

					$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($target_dir));

					foreach ($iterator as $entry)
					{
						if ($entry->isFile())
						{
							$target_path = str_replace("$target_dir", '', $entry->getPath());
							$full_target_path = $this->_base_media_path.$target_path;
							$source_path = "$target_dir/$target_path";

							if ( !file_exists("$full_target_path/{$entry->getFileName()}") )
							{
								$this->_createTargetDir($target_path);

								$source_file = "$source_path/{$entry->getFileName()}";
								$target_file = "$full_target_path/{$entry->getFileName()}";

								rename($source_file, $target_file);

								if (file_exists($target_file))
									chmod($target_file, 0660);
							}
						}
					}
				}
			}

			$this->_deleteTmpDir($tmp_dir);
			return null;
		}
		catch (CN_Exception $e)
		{
			return $e->getMessage();
		}
	}

	
	protected function _createTmpDir()
	{
		$tmp_dir = null;

		do
		{
			$tmp_dir = sys_get_temp_dir().'/'.uniqid(mt_rand(), true);
		}
		while (file_exists($tmp_dir));

		mkdir($tmp_dir, 0770);

		return realpath($tmp_dir);
	}
	
	protected function _createTargetDir($target_dir)
	{
		if (!file_exists($target_dir))
		{
			$path = explode(DIRECTORY_SEPARATOR, $target_dir);

			$current_path = $this->_base_media_path;

			foreach ($path as $dir_name)
			{
				$current_path .= "/$dir_name";

				if (!file_exists($current_path))
					mkdir($current_path, 0770);
			}
		}
	}
	
	protected function _deleteTmpDir($dir)
	{
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);

		foreach ($iterator as $entry)
		{
			if ( $entry->getFilename() == '.' or $entry->getFilename() == '..' )
				continue;
			
			if ($entry->isFile())
				unlink($entry->getPathname());

			if ($entry->isDir())
				rmdir($entry->getPathname());
		}

		rmdir($dir);
	}	
	
	public  function UnpackZipFile($pathAndFileName, $targetFolderToUnzipIn) {
		
		//variables
		$pathToUnzipIn = $targetFolderToUnzipIn . '/';
				
		//open zip file
		$zip = new ZipArchive();
		
		if ($zip->open($pathAndFileName)!==TRUE) {
		   throw new Exception('Cannot open the zip file');
		}
		
		//unpack it
		$zip->extractTo($pathToUnzipIn);
		
	}	
}	