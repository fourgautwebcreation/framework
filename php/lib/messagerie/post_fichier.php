<?php
include_once '../../class/bdd.php';
include_once '../../functions/pure_characters.php';
$bdd = new bdd;
$bdd->connect();


$expediteur = intval($_POST['expediteur']);
$destinataire = intval($_POST['destinataire']);
$key = $_POST['key'];

//vérification de sécurité
$bdd->select('*','administrateurs',array('admin_id="'.$expediteur.'"','admin_key="'.$key.'"'));
if(!empty($bdd->rep->rowCount()))
{
  $tmp = $_FILES['file']['tmp_name'];
  $name = $_FILES['file']['name'];

  //construction du dossier
  $dossier = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
  $dossier_short = '/uploads/';

  if(!file_exists($dossier))
  {
   mkdir($dossier);
  }

  //purification du titre
  $explode = explode('.',$name);
  $pure_name = str_replace( $explode[count($explode)-1],'',$name );
  $titre = pure_characters($pure_name);
  $titre = str_replace(' ','_',$titre);

  //définition de l'extension
  $extension = pathinfo($name,PATHINFO_EXTENSION);

  //nouveau titre
  $titre = $titre.'-'.time().'.'.$extension;

  if(is_uploaded_file($tmp))
  {
   if(move_uploaded_file($tmp,$dossier.$titre))
   {
    $text = '<a href=\"'.$dossier_short.$titre.'\" download>';
    $text .= '<i class=\"fa fa-file\"></i> '.$titre.'</a>';
    $bdd->insert('messagerie',
    array(
       'message_expediteur','message_destinataire','message_text','message_timestamp','message_statut'
      ),
      array('"'.$expediteur.'"','"'.$destinataire.'"','"'.$text.'"','"'.time().'"','"0"')
    );

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
    echo $bdd->result;
   }
  }
}
?>
