<?php

/*
* Connexion à l'extranet
*
* Page : /admin/
*
*/

if(isset($_POST['pseudo']) && !empty($_POST['pseudo']) && isset($_POST['pass']) && !empty($_POST['pass']))
{
  $pseudo = trim($_POST['pseudo']);
  $pass = md5(trim($_POST['pass']));

  $key = create_secure_key();
  $_SESSION['secure_key'] = $key;

  $bdd->select('*','administrateurs',array('admin_pseudo="'.$pseudo.'"','admin_pass="'.$pass.'"'));
  $count = $bdd->rep->rowCount();
  if(!empty($count))
  {
    $rep = $bdd->rep->fetch();
    $_SESSION['admin'] = $rep['admin_id'];
    $_SESSION['admin_pseudo'] = $rep['admin_pseudo'];
    $_SESSION['admin_pass'] = $rep['admin_pass'];
    $bdd->update('administrateurs',array('admin_connexion="'.time().'"','admin_key="'.$key.'"'),array('admin_id="'.$rep['admin_id'].'"'));

    header('location:'.$rooter->dossier.'admin');
    exit;
  }
  else
  {
    $rooter->error = 'Ce compte n\'est pas reconnu';
  }
}

else
{
    $rooter->error = 'Il manque des informations de connexion';
}
