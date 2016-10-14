<?php

/*
* Update des options
*
* Page : /admin/page=options
*/


if( $rooter->locked == 0 )
{
    $bdd->select('*','options');
    $rep = $bdd->rep->fetch();
    $illustration = $rep['option_illustration'];

    $titre = trim(htmlspecialchars($_POST['titre']));
    $description = trim(htmlspecialchars($_POST['description']));
    $langue = intval($_POST['langue']);
    $facebook = trim(htmlspecialchars($_POST['facebook']));
    $twitter = trim(htmlspecialchars($_POST['twitter']));
    $maintenance = intval($_POST['maintenance']);
    $messagerie = intval($_POST['messagerie']);

    if(isset($_FILES['illustration']['tmp_name']) && !empty($_FILES['illustration']['tmp_name']))
    {
      $tmp = $_FILES['illustration']['tmp_name'];
      $name = $_FILES['illustration']['name'];
      $extension = pathinfo($name,PATHINFO_EXTENSION);
      $new_name = time().'.'.$extension;
      if(is_uploaded_file($tmp))
      {
        if(move_uploaded_file($tmp,$rooter->dossier_root.'img/'.$new_name))
        {
          if(file_exists($rooter->dossier_root.$illustration) && !empty($illustration) && unlink($rooter->dossier_root.$illustration))
          {
            $illustration = '/img/'.$new_name;
          }
          else
          {
            $illustration = '/img/'.$new_name;
          }
        }
      }
    }

    $bdd->update('options',
                  array(
                    'option_titre="'.$titre.'"','option_description="'.$description.'"','option_illustration="'.$illustration.'"',
                    'option_cible="'.$langue.'"','option_facebook="'.$facebook.'"','option_twitter="'.$twitter.'"',
                    'option_maintenance="'.$maintenance.'"','option_messagerie="'.$messagerie.'"'
                        )
                );
    header('location:/admin/page=options');
    exit;
}
