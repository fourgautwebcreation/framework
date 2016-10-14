<?php
/*
* Update d'une catégorie
*
* Page : /admin/page=categories
*/


if( $rooter->locked == 0 )
{
    if(!empty($_POST['nom']))
    {
      $id = intval($_POST['id']);
      $nom = trim(htmlspecialchars($_POST['nom']));
      $bdd->select('*','categories',array('categorie_nom="'.$nom.'"'));
      $count = $bdd->rep->rowCount();
      if(empty($count))
      {
        $bdd->update('categories',array('categorie_nom="'.$nom.'"'),array('categorie_id="'.$id.'"'));
        header('location:/admin/page=categories');
        exit;
      }
      else
      {
        $rooter->error = 'Ce nom est déjà utilisé';
      }
    }
    else
    {
      $rooter->error = 'Le nom de la catégorie est vide';
    }
}
