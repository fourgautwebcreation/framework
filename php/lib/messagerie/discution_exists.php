<?php
include_once '../../class/bdd.php';

$bdd = new bdd;
$bdd->connect();

$destinataire = intval($_GET['destinataire']);
$expediteur = intval($_GET['expediteur']);
$key = $_GET['key'];;

//vérification de sécurité
$bdd->select('*','administrateurs',array('admin_id="'.$destinataire.'"','admin_key="'.$key.'"'));
if(!empty($bdd->rep->rowCount()))
{
$bdd->select('*','messagerie',array('message_destinataire="'.$destinataire.'"','message_expediteur="'.$expediteur.'"'));
$count_1 = $bdd->rep->rowCount();

$bdd->select('*','messagerie',array('message_destinataire="'.$expediteur.'"','message_expediteur="'.$destinataire.'"'));
$count_2 = $bdd->rep->rowCount();

echo $count_1+$count_2;
}
?>
