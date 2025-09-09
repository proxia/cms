<?php

if(!defined('CN_FILEUPLOAD_PHP')):
	define('CN_FILEUPLOAD_PHP', true);

class CN_FileUpload extends CN_Singleton
{
	const TYPE_IMAGES = 1;
	const TYPE_DOCUMENTS = 2;


	private $type_images = array
							(
								'jpg' => array('image/jpeg'),
								'jpeg' => array('image/jpeg'),
								'png' => array('image/png'),
								'gif' => array('image/gif'),
								'bmp' => array('image/bmp'),
								'xpm' => array('application/octet-stream')
							);

	private $type_documents = array
							(
								'doc' => array('application/msword'),
								'xls' => array('application/msexcel')
							);


	private $target_directory = null;

	private $accept_only = null;
	private $file_types = array();
	private $max_size = null;


	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }


	public function setTargetDirectory($target_directory)
	{
		$real_target_directory = realpath($target_directory);

		if(!is_dir($real_target_directory))
			throw new CN_Exception(sprintf(_("`%s` isn't directory. Specify valid directory with full path."), $target_directory), E_ERROR);
		if(!is_writeable($real_target_directory))
			throw new CN_Exception(sprintf(_("Directory `%s` isn't writeable. Set access permissions correctly."), $target_directory), E_ERROR);

		$this->target_directory = $real_target_directory;
	}

	public function setAcceptOnly($type) { $this->accept_only = $type; }
	public function setMaxSize($max_size) { $this->max_size = $max_size; }


	public function getTargetDirectory() { return $this->target_directory; }
	public function getAcceptOnly() { return $this->accept_only; }
	public function getMaxSize() { return $this->max_size; }


	public function addType($extension)
	{
		if(!isset($this->file_types[$extension]))
		{
			$mime_types = func_get_args();
			array_shift($mime_types);

			if(is_array($mime_types[0]))
				$mime_types = $mime_types[0];

			$this->file_types[$extension] = $mime_types;
		}
	}

	public function removeType($extension)
	{
		if(isset($this->file_types[$extension]))
			unset($this->file_types[$extension]);
	}

	public function resetTypes() { $this->file_types = array(); }


	public function upload()
	{
		$file_names = func_get_args();
		$files_to_upload = $_FILES;

		if(count($file_names) > 0)
		{
			$files_to_upload = array();

			foreach($file_names as $name)
				$files_to_upload[] = $_FILES[$name];
		}


		foreach($files_to_upload as $file)
		{
			$extension = substr($file['name'], strlen($file['name']) - 3);

			if(strlen($file['name']) == 0)
				continue;

			if($file['error'] != UPLOAD_ERR_OK )
			{

				switch($file['error'])
				{
					case UPLOAD_ERR_INI_SIZE:
						throw new CN_Exception(sprintf(_("Uploaded file size exceeds maximum system file size %s."), ini_get('upload_max_filesize')), E_USER_ERROR);
						break;
					case UPLOAD_ERR_PARTIAL:
						throw new CN_Exception(_("File was uploaded incorretly. Please try again."), E_USER_ERROR);
						break;
					case UPLOAD_ERR_NO_FILE:
						throw new CN_Exception(_("File was uploaded incorretly. Please try again."), E_USER_ERROR);
						break;
					case UPLOAD_ERR_NO_TMP_DIR:
						throw new CN_Exception(_("Temporary folder is missing. Blame system administrator."), E_USER_ERROR);
						break;
					case UPLOAD_ERR_CANT_WRITE:
						throw new CN_Exception(_("Can't write file to disk. Check permissions."), E_USER_ERROR);
						break;
				}
			}


			if(!is_null($this->accept_only))
			{
				$type_array = null;

				if($this->accept_only == self::TYPE_IMAGES)
					$type_array = $this->type_images;
				elseif($this->accept_only == self::TYPE_DOCUMENTS)
					$type_array = $this->type_documents;

				if(isset($type_array[$extension]))
				{
					if(!in_array($file['type'], $type_array[$extension]))
						throw new CN_Exception(_("Uploaded file must have correct extension and be of apropriate type."), E_USER_ERROR);
				}
				else
					throw new CN_Exception(_("Uploaded file must have correct extension and be of apropriate type."), E_USER_ERROR);
			}


			if(count($this->file_types) > 0)
			{
				if(isset($this->file_types[$extension]))
				{
					if(!in_array($file['type'], $this->file_types[$extension]))
						throw new CN_Exception(_("Uploaded file must have correct extension and be of apropriate type."), E_USER_ERROR);
				}
				else
					throw new CN_Exception(_("Uploaded file must have correct extension and be of apropriate type."), E_USER_ERROR);
			}


			if(!is_null($this->max_size))
			{
				if($file['size'] > $this->max_size)
					throw new CN_Exception(sprintf(_("Maximum file size allowed is %1\$s. Uploaded file id of size %2\$s."), $this->max_size, $file['size']), E_USER_ERROR);
			}


			$target_file = $this->target_directory.DIRECTORY_SEPARATOR.basename($file['name']);

			if(!move_uploaded_file($file['tmp_name'], $target_file))
				throw new CN_Exception(_("File upload failed."));
		}
	}


	public static function getSingleton() { return parent::getSingleton(__CLASS__); }
}

endif;

?>