<?php
function documentation()
{
  GLOBAL $rooter;
  $documentation = '';

  $array = array();
  $dossiers = scandir($rooter->dossier.'php/lib/documentation/');
  sort($dossiers);
  $i = 0;
  //lecture des sous dossiers contenus

  $documentation .= '<ul>';
  //$documentation .= '<li><a href="/">Retour</a></li>';
  foreach($dossiers as $sous_dossier)
  {
    if($sous_dossier!=='.' && $sous_dossier!=='..')
    {
      $documentation .=
      '
      <li><a href="#'.$sous_dossier.'">'.ucfirst($sous_dossier).'</a></li>
      ';
    }
  }
  $documentation .= '<li class="download"><a href="'.$rooter->dossier.'framework.zip" download>Télécharger</a>';
  $documentation .= '</ul>';
  $documentation .= '<div class="content">';


  $documentation .=
  '
  <div class="sous_dossier">
    <img src="/img/documentation.png" alt="" />
  </div>  
  ';

  foreach($dossiers as $sous_dossier)
  {
    $fichiers = array();
    if($sous_dossier!=='.' && $sous_dossier!=='..')
    {
      $this_dossier = opendir($rooter->dossier.'php/lib/documentation/'.$sous_dossier.'/');
      $documentation .= '<div id="'.$sous_dossier.'" class="sous_dossier">';
        $documentation .= '<h2>'.ucfirst($sous_dossier).'</h2>';
        while (false !== ($fichier = readdir($this_dossier)))
        {
        $fichiers[] = $fichier;
        }
        sort($fichiers);
        foreach($fichiers as $fichier)
        {
          if ($fichier  != "." && $fichier  != ".." )
          {
            $name = explode('.',$fichier);
            $documentation .= '<h3><span data-div="#'.$i.'">'.$name[0].'</span></h3>';
            $documentation .= '
            <div id="'.$i.'" class="details">
              <p>'.nl2br(file_get_contents(htmlspecialchars($rooter->dossier.'php/lib/documentation/'.$sous_dossier.'/'.$fichier))).'
              </p>
            </div>';
            $i++;
          }
        }
      $documentation .= '</div>';
    }
  }
  $documentation .= '</div>';
  return $documentation;
}
?>
