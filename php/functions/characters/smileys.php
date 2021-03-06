<?php

/**
* php/functions/smileys.php
*
* Fonction remplaçant un enchainement de caractère par un smiley correspondant
*
* @param string $text Le texte à traiter
*
* @return $text Le texte retourné une fois les remplacement effectués
*/

function smileys($text)
{
 $text = htmlspecialchars_decode($text);

 $in = array(
  ':@',
  '^^',
  ':s',
  ':D',
  ':)',
  '(l)',
  ':o',
  'xD',
  ':\'(',
  ';)',
  '--\'',
  ':(',
  ':p',
  ':\\'
 );

 $out = array(
  '<i class="em em-angry"></i>',
  '<i class="em em-blush"></i>',
  '<i class="em em-confused"></i>',
  '<i class="em em-grin"></i>',
  '<i class="em em-smiley"></i>',
  '<i class="em em-heart_eyes"></i>',
  '<i class="em em-open_mouth"></i>',
  '<i class="em em-joy"></i>',
  '<i class="em em-sob"></i>',
  '<i class="em em-wink"></i>',
  '<i class="em em-sweat"></i>',
  '<i class="em em-worried"></i>',
  '<i class="em em-stuck_out_tongue_winking_eye"></i>',
  '<i class="em em-neutral_face"></i>'
 );

 $text = str_replace($in,$out,$text);
 return $text;
}
