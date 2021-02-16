<?php

if(!defined('CN_IMAGE_PHP')):
	define('CN_IMAGE_PHP', true);

abstract class CN_Image
{
	protected $path = null;
	protected $name = null;
	protected $extension = null;
	protected $type = null;
	protected $mime_type = null;

	protected $handle = null;


	public function __construct($image=null)
	{
		if(!is_null($image))
			$this->setImage($image);
	}

	public function __destruct()
	{
		if(!is_null($this->handle)) imagedestroy($this->handle);
	}


	public function setImage($image)
	{
		if(!is_null($this->handle))
		{
			imagedestroy($this->handle);
			$this->handle = null;
		}

		
		if(!file_exists($image))
			throw new CN_Exception(sprintf(_("Image `%s` doesn't exsists."), basename($image)));
		if(!is_readable($image))
			throw new CN_Exception(sprintf(_("Can't access image `%s`. Set permissions properly."), basename($image)));

		
		$this->path = realpath(dirname($image));
		$this->name = basename($image);
		$this->extension = substr($this->name, strlen($this->name) - 3);
		$this->type = exif_imagetype($image);
		$this->mime_type = image_type_to_mime_type($this->type);

		switch($this->type)
		{
			case IMAGETYPE_GIF:
				if(imagetypes() & IMAGETYPE_GIF)
					$this->handle = imagecreatefromgif($image);
				else
					throw new CN_Exception(sprintf(_("Operations on image will be disabled because you don't have %s support instaled"), strtoupper($this->extension)));
				break;

			case IMAGETYPE_JPEG:
				if(imagetypes() & IMAGETYPE_JPEG)
					$this->handle = imagecreatefromjpeg($image);
				else
					throw new CN_Exception(sprintf(_("Operations on image will be disabled because you don't have %s support instaled"), strtoupper($this->extension)));
				break;

			case IMAGETYPE_PNG:
				if(imagetypes() & IMAGETYPE_PNG)
					$this->handle = imagecreatefrompng($image);
				else
					throw new CN_Exception(sprintf(_("Operations on image will be disabled because you don't have %s support instaled"), strtoupper($this->extension)));
				break;

			case IMAGETYPE_WBMP:
				if(imagetypes() & IMAGETYPE_WBMP)
					$this->handle = imagecreatefromwbmp($image);
				else
					throw new CN_Exception(sprintf(_("Operations on image will be disabled because you don't have %s support instaled"), strtoupper($this->extension)));
				break;

			case IMAGETYPE_XBM:
				if(imagetypes() & IMAGETYPE_XBM)
					$this->handle = imagecreatefromxbm($image);
				else
					throw new CN_Exception(sprintf(_("Operations on image will be disabled because you don't have %s support instaled"), strtoupper($this->extension)));
				break;

			default:
				throw new CN_Exception(_("Unsupported image type."));
		}
	}


	public function getPath() { return $this->path; }
	public function getName() { return $this->name; }
	public function getExtension() { return $this->extension; }
	public function getType() { return $this->type; }
	public function getMimeType() { return $this->mime_type; }
	public function getHandle() { return $this->handle; }


	public function getWidth() { return imagesx($this->handle); }
	public function getHeight() { return imagesy($this->handle); }
}

endif;

?>