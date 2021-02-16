<?php 
require_once 'config/config.php';

// resize
				$image_path = "{$config['mediadir']}/".$_GET['path'];

				$img = null;
				$er = explode('.', $image_path);
  				$ext = strtolower(end($er));
  				if ($ext == 'jpg' || $ext == 'jpeg') {
					$img = imagecreatefromjpeg($image_path);
				}
  				elseif
				($ext == 'png') {
					$img = @imagecreatefrompng($image_path);
 					 # Only if your version of GD includes GIF support
  				} elseif ($ext == 'gif') {
					$img = @imagecreatefromgif($image_path);
				}
  				# If an image was successfully loaded, test the image for size
  				if ($img) {
  					# Get image size and scale ratio
					$width = imagesx($img); 	$height = imagesy($img);


					// zarovnanie na sirku
  					$new_width = $_GET['w'];
					if ($_GET['w']>$width)$new_width = $width;
  					$new_height = (int) (($new_width / $width) * $height);
					/*
					// zarovnanie na vysku
  					$new_height = $_GET['w'];
					if ($_GET['w']>$height)$new_height = $height;
  					$new_width = (int) (($new_height / $height) * $width);
					*/
  					# Create a new temporary image
  					$tmp_img = imagecreatetruecolor($new_width, $new_height);
  					# Copy and resize old image into new image
  					imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
  					imagedestroy($img);
					$img = $tmp_img;
				}
  				# Display the image
  					header("Content-type: image/jpeg"); imagejpeg($img); imagedestroy($img);
