<?php

//Toute modification effectuée depuis l'admin
if(isset($_POST['secure']) && $_POST['secure']==$rooter->secure_key && isset($_POST['type']) && !empty($_POST['type']))
{
  $rooter->locked = 0; // condition à effectuer sur TOUT fichier present dans php/lib/post
  $type = trim($_POST['type']);
  $file = 'php/lib/post/'.$type.'.php';
  if(file_exists($file))
  {
      include_once($file);
  }
  else
  {
    $rooter->error = 'Le fichier relatif à l\'action demandée est introuvable';
  }
}

//Variable provenant du formulaire de connexion à l'extranet
elseif(isset($_POST['connexion_extranet']))
{
    $file = 'php/lib/post/connexion_extranet.php';
    if(file_exists($file))
    {
        include_once($file);
    }
    else
    {
      $rooter->error = 'Le fichier relatif à l\'action demandée est introuvable';
    }
}
