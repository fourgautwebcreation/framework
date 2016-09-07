<?php
include_once '../../class/bdd.php';
$bdd = new bdd;
$bdd->connect();

$expediteur = intval($_POST['expediteur']);
$destinataire = intval($_POST['destinataire']);
$message = htmlspecialchars($_POST['message']);
$key = $_POST['key'];
//vérification de sécurité
$bdd->select('*','administrateurs',array('admin_id="'.$expediteur.'"','admin_key="'.$key.'"'));
if(!empty($bdd->rep->rowCount()))
{
            if(!empty($message) && !empty($expediteur) && !empty($destinataire))
            {
                        $bdd->insert('messagerie',
                                     array(
                                      'message_expediteur',
                                      'message_destinataire',
                                      'message_text',
                                      'message_timestamp',
                                      'message_statut'
                                        ),
                                     array(
                                      '"'.$expediteur.'"',
                                      '"'.$destinataire.'"',
                                      '"'.$message.'"',
                                      '"'.time().'"',
                                      '"0"'
                                     )
                                    );
            }
}
$dossier = 'non_lus/'.$destinataire.'/';
$fichier = 'non_lus/'.$destinataire.'/'.$expediteur.'.txt';

if(!file_exists($dossier))
{
mkdir($dossier,777);
}

if(file_exists($fichier))
{
            $fx = fopen($fichier,'w+');
            fputs($fx,'1');
            fclose($fx);
}
else
{
            $fx = fopen($fichier,'x+');
            fputs($fx,'1');
            fclose($fx);
}
?>
