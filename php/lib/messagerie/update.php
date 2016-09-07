<?php
include_once '../../class/bdd.php';
$bdd = new bdd;
$bdd->connect();

$type = $_POST['type'];
$expediteur = intval($_POST['expediteur']);
$destinataire = intval($_POST['destinataire']);
$key = $_POST['key'];

//vérification de sécurité
$bdd->select('*','administrateurs',array('admin_id="'.$destinataire.'"','admin_key="'.$key.'"'));
if(!empty($bdd->rep->rowCount()))
{

            if($type == 'vue')
            {
            $bdd->update('messagerie',
                         array(
                          'message_statut="1"',
                            ),
                         array(
                          'message_expediteur="'.$expediteur.'"',
                          'message_destinataire="'.$destinataire.'"'
                         )
                        );
            }

            $dossier = 'non_lus/'.$destinataire.'/';
            $fichier = 'non_lus/'.$destinataire.'/'.$expediteur.'.txt';

            if(file_exists($dossier) && file_exists($fichier))
            {
            unlink($fichier);
            }
}


?>
