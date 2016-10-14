<?php

/*
* Ajout d'une catégorie
*
* Page : /admin/page=categories
*/


if( $rooter->locked == 0 )
{
    if(!empty($_POST['nom']))
    {
      $nom = trim(htmlspecialchars($_POST['nom']));
      $bdd->select('*','categories',array('categorie_nom="'.$nom.'"'));
      $count = $bdd->rep->rowCount();
      if(empty($count))
      {
        $bdd->insert('categories',array('categorie_nom','categorie_modifiable'),array('"'.$nom.'"','1'));
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
