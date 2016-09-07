<?php
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
?>
