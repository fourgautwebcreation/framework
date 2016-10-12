<?php

/**
* php/functions/accepted_extensions.php
*
* Cette fonction est utilisée afin de valider l'extension d'un fichier fourni.
* Elle passe en revue un tableau d'extensions renseigné dans la variable $accepted
* et compare ses valeurs à l'extension à vérifier
*
* @param string $extension L'extension a valider
*
* @return int $ok 0 pour non valide, 1 pour valide
*/

function accepted_extensions($extension)
{
  $accepted = array('jpg','jpeg','gif','png');
  $ok = 0;
  foreach($accepted as $a)
  {
    if($a == $extension)
    {
      $ok = 1;
    }
  }
  return $ok;
}
