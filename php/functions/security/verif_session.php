<?php

/**
* php/functions/verif_session.php
*
* Fonction vérifiant l'existence d'une session php donnée
*
* @param string $session Le nom de la session
*
* @return int La validité de la session. 0 pour non, 1 pour oui
*/

function verif_session($session)
{
  if(!isset($_SESSION[$session]) OR isset($_SESSION[$session]) && empty($_SESSION[$session]))
  {
    return 0;
  }
  elseif(isset($_SESSION[$session]) && !empty($_SESSION[$session]))
  {
    return 1;
  }
}
