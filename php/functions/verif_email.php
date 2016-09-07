<?php
function verif_email($email)
{
  GLOBAL $countries;
  $ok = 0;
  //vérification de la présence d'un @
  if(strpos($email,'@'))
  {
    $parts = explode('@',$email);
    {
      //avant l'@
      $before = $parts[0];
      //apres l'@
      $after = $parts[1];
      //apres l'@, on découpe la chaine a chaque point
      $domaine = explode('.',$after);
      //on défini la position du dernier point
      $position = count($domaine)-1;
      $domaine = $domaine[$position];
      if($domaine == 'com')
      {
        $ok = 1;
      }
      //on parcours le tableau des pays et verifie si l'extension correspond
      foreach($countries->extensions as $extension)
      {
        if($extension['extension'] == $domaine)
        {
          $ok = 1;
        }
      }
    }
  }
  return $ok;
}
?>
