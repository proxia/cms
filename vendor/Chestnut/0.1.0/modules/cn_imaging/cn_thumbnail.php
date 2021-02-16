<?php

if(!defined('CN_THUMBNAIL_PHP')):
	define('CN_THUMBNAIL_PHP', true);

class CN_Thumbnail extends CN_Image
{
	private $thumbnail = null;

	private $quality = 85;
	private $size_x = null;
	private $size_y = null;

	private $background_color = array('r' => 0, 'g' => 0, 'b' => 0);

	private $target_directory = null;
	private $prefix = null;
	private $custom_name = null;


	public function __construct($image=null) { parent::__construct(); }

	public function __destruct()
	{
		parent::__destruct();

		
		if(!is_null($this->thumbnail))
			imagedestroy($this->thumbnail);
	}


	public function setQuality($quality) { $this->quality = $quality; }
	public function setSizeX($size_x) { $this->size_x = $size_x; }
	public function setSizeY($size_y) { $this->size_y = $size_y; }

	public function setBackgroundColor($r, $g, $b)
	{
		$this->background_color['r'] = $r;
		$this->background_color['g'] = $g;
		$this->background_color['b'] = $b;
	}

	public function setTargetDirectory($target_directory)
	{
		$real_target_directory = realpath($target_directory);

		if(!is_dir($real_target_directory))
			throw new CN_Exception(sprintf(_("`%s` isn't directory. Specify valid directory with full path."), $target_directory));
		if(!is_writeable($real_target_directory))
			throw new CN_Exception(sprintf(_("Directory `%s` isn't writeable. Set access permissions correctly."), $target_directory));

		$this->target_directory = $real_target_directory;
	}

	public function setPrefix($prefix) { $this->prefix = $prefix; }
	public function setCustomName($custom_name) { $this->custom_name = $custom_name; }


	public function generate()
	{
		$original_w = $this->getWidth();
		$original_h = $this->getHeight();

		$this->thumbnail = imageCreateTrueColor($this->size_x, $this->size_y);
		$background_color = imageColorAllocate($this->thumbnail, $this->background_color['r'], $this->background_color['g'], $this->background_color['b']);

		imageFill($this->thumbnail, 0, 0, $background_color);

		$ratio = $original_w > $original_h ? $original_w / $original_h : $original_h / $original_w;

		$destination_w = $original_w >= $original_h ? $this->size_x : round($this->size_x / $ratio);
		$destination_h = $original_w <= $original_h ? $this->size_y : round($this->size_y / $ratio);
		$destination_x = round(($this->size_x / 2) - ($destination_w / 2));
		$destination_y = round(($this->size_y / 2) - ($destination_h / 2));

		imageCopyResampled($this->thumbnail, $this->handle, $destination_x, $destination_y, 0, 0, $destination_w, $destination_h, $original_w, $original_h);
	}


	public function save()
	{
		$thumbnail_name = null;

		if(!is_null($this->prefix))
			$thumbnail_name .= $this->prefix;

		if(!is_null($this->custom_name))
			$thumbnail_name .= $this->custom_name;
		else
			$thumbnail_name .= $this->name;

		
		switch($this->type)
		{
			case IMAGETYPE_GIF:
				imagegif($this->thumbnail, $this->target_directory.$thumbnail_name);
				break;

			case IMAGETYPE_JPEG:
				imagejpeg($this->thumbnail, $this->target_directory.$thumbnail_name, $this->quality);
				break;

			case IMAGETYPE_PNG:
				imagepng($this->thumbnail, $this->target_directory.$thumbnail_name);
				break;

			case IMAGETYPE_WBMP:
				imagewbmp($this->thumbnail, $this->target_directory.$thumbnail_name);
				break;

			case IMAGETYPE_XBM:
				imagexbm($this->thumbnail, $this->target_directory.$thumbnail_name);
				break;

			default:
				throw new CN_Exception(_("Unsupported image type."));
		}
	}

	public function saveAs($target_directory, $thumbnail_name)
	{
		$target_directory = realpath($target_directory);

		switch($this->type)
		{
			case IMAGETYPE_GIF:
				imagegif($this->thumbnail, $target_directory.$thumbnail_name);
				break;

			case IMAGETYPE_JPEG:
				imagejpeg($this->thumbnail, $target_directory.$thumbnail_name, $this->quality);
				break;

			case IMAGETYPE_PNG:
				imagepng($this->thumbnail, $target_directory.$thumbnail_name);
				break;

			case IMAGETYPE_WBMP:
				imagewbmp($this->thumbnail, $target_directory.$thumbnail_name);
				break;

			case IMAGETYPE_XBM:
				imagexbm($this->thumbnail, $target_directory.$thumbnail_name);
				break;

			default:
				throw new CN_Exception(_("Unsupported image type."));
		}
	}
}

endif;

?>