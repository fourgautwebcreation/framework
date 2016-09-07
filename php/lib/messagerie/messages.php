<?php
set_time_limit(0);
header('Content-Type: application/json');
header("access-control-allow-origin: *");
$id = intval($_GET['id']);
include_once '../../class/bdd.php';
$bdd = new bdd;
$bdd->connect();

$non_lus = array();
$dossier = 'non_lus/'.$id.'/';
$i = 0;


while(empty($non_lus))
{
  if(file_exists($dossier))
  {
    $handle = opendir($dossier);
    while (false !== ($entry = readdir($handle)))
    {
      if($entry !== '.' && $entry!=='..')
      {
        $expediteur = str_replace('.txt','',$entry);
        $non_lus[$i]['expediteur'] = $expediteur;
        $i++;
      }
    }
  }
 if(!empty($non_lus))
 {
   echo json_encode($non_lus);
   break;
 }
}


?>
