<?php
function copy_resample($img,$dossier_copy,$width,$extension,$new_name,$delete = 0)
{

  if($extension == 'jpg' OR $extension=='jpeg')
    $new_img = imagecreatefromjpeg($img);
  elseif($extension == 'gif')
    $new_img = imagecreatefromgif($img);
    elseif($extension == 'png')
      $new_img = imagecreatefrompng($img);

  $size_img = getimagesize($img);
  $width_img = $size_img[0];
  $height_img = $size_img[1];
  if($width_img<=$height_img)
  {
    $rapport = $width_img/$height_img;
    $height = $width/$rapport;
  }
  else
  {
    $rapport = $height_img/$width_img;
    $height = $width*$rapport;
  }

  $true_colors = imagecreatetruecolor($width, $height);
  imagecopyresampled($true_colors,$new_img,0, 0, 0, 0, $width, $height, $width_img, $height_img);

  if($extension == 'jpg' OR $extension=='jpeg')
    $sauvegarde = imagejpeg($true_colors, $dossier_copy.$new_name, 100);
  elseif($extension == 'gif')
    $sauvegarde = imagegif($true_colors, $dossier_copy.$new_name);
  elseif($extension == 'png')
    imagealphablending($true_colors, false);
    imagesavealpha($true_colors, true);
    $sauvegarde = imagepng($true_colors, $dossier_copy.$new_name, 9);

  if($delete==1)
  {
    unlink($img);
  }

  return $sauvegarde;
}
?>
