<?php

/**
* php/functions/build_link.php
*
* Cette fonction est utilisée pour créer un lien de page en adéquation avec un url rewriting
* Appelant la fonction pure_link, elle retourne une url au format id-titre.html
*
* @param string $titre Le titre de l'article
*
* @param int $id L'id de la page
*
* @return string $lien Le lien créé
*/

function build_link($titre,$id)
{
  $explode = explode('/',$titre);
  $count = count($explode);
  $titre = str_replace('.php','',$explode[$count-1]);
  $titre = pure_link($titre);
  $lien = '/'.$id.'-'.$titre.'.html';
  return $lien;
}
