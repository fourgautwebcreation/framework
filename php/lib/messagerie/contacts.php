<?php
set_time_limit(30);
header('Content-Type: application/json');
header("access-control-allow-origin: *");

// Appel de la configuration
require '../../includes/config.php';

// Appel du rooter
require '../../class/rooter.php';
$rooter = new rooter($_GET);

// Appel de la class autoload des class
require '../../class/autoload.php';
$autoloader = new Autoloader();
// Autoload des class
$autoloader->register();

// Enregistrement des fonctions
$autoloader->loadFunctions('../../functions');
// Appel des fonctions
$autoloader->callFunctions();

// Connection à la base de données
$bdd = new bdd;
$bdd->connect();

$membres = array();

$id = intval($_GET['id']);
$key = trim($_GET['key']);

//vérification de sécurité
$bdd->select('*','administrateurs',array('admin_id="'.$id.'"','admin_key="'.$key.'"'));
if(!empty($bdd->rep->rowCount()))
{
  $bdd->select('*','administrateurs',array('admin_id<>"'.$id.'"'));
  while($membre = $bdd->rep->fetch())
  {
   $i = $membre['admin_id'];
   $membres[$i]['statut'] = 0;
   $membres[$i]['time'] = convert_timestamp($membre['admin_deconnexion']);

   if( $membre['admin_connexion']>$membre['admin_deconnexion'] && !empty($membre['admin_connexion']) )
   {
    //si la derniere activité était il y'a moins de 10 minutes
    if( (time()-$membre['admin_connexion']) < (60*5))
    {
      $membres[$i]['statut'] = 1;
      $membres[$i]['time'] = '';
    }
   }

   $membres[$i]['prenom'] = '';
   $membres[$i]['nom'] = $membre['admin_pseudo'];
   $membres[$i]['avatar'] = $membre['admin_avatar'];
   if(empty($membre['admin_avatar']))
   {
     $membres[$i]['avatar'] = '/img/membres/no-avatar.png';
   }
   $membres[$i]['id'] = $membre['admin_id'];
  }

  arsort($membres);
  echo json_encode($membres);
}
?>
