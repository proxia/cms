<?php

Header("Pragma: no-cache");
Header("Cache-Control: no-cache");

$image_path = "../../../../../../../../../www/{$_GET['project']}/mediafiles/{$_GET['image']}";

list(,,$img_type) = getimagesize($image_path);

switch($img_type)
{
	case IMAGETYPE_GIF:
		Header("Content-type: image/gif");

		$image = imagecreatefromgif($image_path);
		imageGif($image);

		break;

	case IMAGETYPE_JPEG:
		Header("Content-type: image/jpeg");

		$image = imagecreatefromjpeg($image_path);
		imageJpeg($image);

		break;

	case IMAGETYPE_PNG:
		Header("Content-type: image/png");

		$image = imagecreatefrompng($image_path);
		imagePng($image);

		break;
}

?>
