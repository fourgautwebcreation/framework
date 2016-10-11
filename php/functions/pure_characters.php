<?php

/**
* Cette fonction remplace tous les caracteres spéciaux
*
* @param string $chaine La chaine à traiter
*
* @return string $chaine La chaine traitée
*/

function pure_characters($chaine)
{

  $in = array('â','à','ä');
  $out = array('a','a','a');
  $chaine = str_replace($in,$out,$chaine);

  $in = array('ç');
  $out = array('c');
  $chaine = str_replace($in,$out,$chaine);

  $in = array('é','è','ê','ë');
  $out = array('e','e','e','e');
  $chaine = str_replace($in,$out,$chaine);

  $in = array('î','ï');
  $out = array('i','i');
  $chaine = str_replace($in,$out,$chaine);

  $in = array('ô','ö');
  $out = array('o','o');
  $chaine = str_replace($in,$out,$chaine);

  $in = array('ù','û','ü');
  $out = array('u','u','u');
  $chaine = str_replace($in,$out,$chaine);

  $in = array('/','\\','*','{','}','[',']');
  $out = array('-','-','-','-','-','-','-');
  $chaine = str_replace($in,$out,$chaine);

  $in = array(',',';',':','!','.','_','?','%','#');
  $out = array('','','','','','','','pourcent','');
  $chaine = str_replace($in,$out,$chaine);

  $in = array('\'','\""','(',')','<','>','«','»');
  $out = array('-','-','','','','','','');
  $chaine = str_replace($in,$out,$chaine);

  return $chaine;
}
