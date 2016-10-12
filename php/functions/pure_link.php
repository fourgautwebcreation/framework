<?php

/**
* php/functions/pure_link.php
*
* Cette fonction épure un lien en faisant appel à la fonction pure_characters,
* la convertit en minuscules et supprime les espaces afin de retourner un lien
*
* @param string $lien Le lien a épurer
*
* @return string $lien Le lien épuré
*/

function pure_link($lien)
{
  $lien = trim(pure_characters($lien));
  $lien = mb_strtolower($lien,'UTF-8');
  $lien = str_replace(' ','-',$lien);
  return $lien;
}
