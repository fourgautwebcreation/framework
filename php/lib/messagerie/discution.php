<?php
set_time_limit(0);
header('Content-Type: application/json');
header("access-control-allow-origin: *");

$destinataire = intval($_GET['destinataire']);
$expediteur = intval($_GET['expediteur']);
$key = $_GET['key'];

$nombre = intval($_GET['count']);
$id_last = intval($_GET['id_last']);
$statut_last = intval($_GET['statut_last']);

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


$_GLOBALS['count'] = '';
$_GLOBALS['changement'] = 0;

//vérification de sécurité
$bdd->select('*','administrateurs',array('admin_id="'.$destinataire.'"','admin_key="'.$key.'"'));
if(!empty($bdd->rep->rowCount()))
{

  //tant que la variable générale $count est égale au nombre de message déja connu, on execute la verification
  while( ( !is_int($_GLOBALS['count']) OR intval($_GLOBALS['count']) == $nombre) && ( intval($_GLOBALS['changement']) == 0) )
  {
    if(isset($messages))
    {
      unset($messages);
    }
    $i = 0;
    $messages = array();

    sleep(1);
    //selection des messages reçus
    $bdd->select('*','messagerie',array('message_destinataire="'.$destinataire.'"','message_expediteur="'.$expediteur.'"'),'ORDER BY message_timestamp ASC');
    while($message = $bdd->rep->fetch())
    {
     $messages[$i]['timestamp'] = $message['message_timestamp'];
     $messages[$i]['text'] = replace_links(smileys($message['message_text']),$message['message_id']);
     $messages[$i]['expediteur'] = $message['message_expediteur'];
     $messages[$i]['id'] = $message['message_id'];
     $messages[$i]['statut'] = intval($message['message_statut']);
     $i++;
    }

    //selection des messages reçus
    $bdd->select('*','messagerie',array('message_expediteur="'.$destinataire.'"','message_destinataire="'.$expediteur.'"'),'ORDER BY message_timestamp ASC');
    while($message = $bdd->rep->fetch())
    {
     $messages[$i]['timestamp'] = $message['message_timestamp'];
     $messages[$i]['text'] = replace_links(smileys($message['message_text']),$message['message_id']);
     $messages[$i]['expediteur'] = $message['message_expediteur'];
     $messages[$i]['id'] = $message['message_id'];
     $messages[$i]['statut'] = intval($message['message_statut']);
     $i++;
    }

    sort($messages);
    $_GLOBALS['count'] = count($messages);
    //affichage des 150 derniers messages
    array_splice($messages, 150);

    //si le compte de messages et different de celui renseigné
    if( intval($_GLOBALS['count']) !== $nombre && is_int($_GLOBALS['count']))
    {
      echo json_encode($messages);
      break;
    }

    //sinon, on vérifie le possible changement de statut du denrier message envoyé renseigné
    elseif( intval($_GLOBALS['count']) == $nombre && is_int($_GLOBALS['count']) && !empty($id_last))
    {
      $bdd->select('*','messagerie',array('message_id="'.$id_last.'"'));
      $mess = $bdd->rep->fetch();
      if( intval($mess['message_statut']) !== $statut_last)
      {
        $_GLOBALS['changement'] = 1;
        echo json_encode($messages);
        break;
      }
    }
  }

}
?>
