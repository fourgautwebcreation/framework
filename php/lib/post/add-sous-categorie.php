<?php

/*
* Ajout d'une sous catégorie
*
* Page : /admin/page=sous_categories
*/


if( $rooter->locked == 0 )
{
    if(!empty($_POST['nom']))
    {
      $nom = trim(htmlspecialchars($_POST['nom']));
      $bdd->select('*','sous_categories',array('sous_categorie_nom="'.$nom.'"'));
      $count = $bdd->rep->rowCount();
      if(empty($count))
      {
        $bdd->insert('sous_categories',array('sous_categorie_nom','sous_categorie_modifiable'),array('"'.$nom.'"','1'));
        header('location:/admin/page=sous_categories');
        exit;
      }
      else
      {
        $rooter->error = 'Ce nom est déjà utilisé';
      }
    }
    else
    {
      $rooter->error = 'Le nom de la sous catégorie est vide';
    }
}
