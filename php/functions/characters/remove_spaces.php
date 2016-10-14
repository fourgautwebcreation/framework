<?php

/**
* php/functions/remove_spaces.php
*
* Cette fonction supprime tous les retours chariots et sauts de lignes
*
* @param $string $chaine La chaine de caractères à traiter
*
* @return string $chaine La chaine traitée
*/

function remove_spaces($chaine)
{
  $chaine = nl2br(html_entity_decode($chaine));
  $returns = array('<br>','<br/>','<br />',"\n","\t","\r","\0","\x0B",'&#13;');
  $spaces = array('',' ',' ',' ',' ',' ',' ',' ',' ');
  $chaine = str_replace($returns,$spaces,$chaine);
  return $chaine;
}

/**
* php/functions/remove_spaces.php
*
* Cette fonction supprime tous les sauts de ligne html de type <br>,<br />...
*
* @param $string $chaine La chaine de caractères à traiter
*
* @return string $chaine La chaine traitée
*/

function hide_spaces($chaine)
{
  $chaine = nl2br(html_entity_decode($chaine));
  $returns = array('<br>','<br/>','<br />');
  $spaces = array('','','');
  $chaine = str_replace($returns,$spaces,$chaine);
  return $chaine;
}

/**
* php/functions/remove_spaces.php
*
* Cette fonction décode le htmlspecialchars
*
* @param $string $chaine La chaine de caractères à traiter
*
* @return string $chaine La chaine traitée
*/
function convert_spaces($chaine)
{
  $chaine = htmlspecialchars_decode($chaine);
  return $chaine;
}
