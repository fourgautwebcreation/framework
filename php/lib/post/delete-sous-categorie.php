<?php

/*
* Delete d'une sous catégorie
*
* Page : /admin/page=sous_categories
*/


if( $rooter->locked == 0 )
{
    if(!empty($_POST['id']))
    {
      $id = intval($_POST['id']);

      //passage des produits de cette sous catégorie en null
      $bdd->delete('sous_categories',array('sous_categorie_id="'.$id.'"'));
      header('location:/admin/page=sous_categories');
      exit;
    }
    else
    {
      $rooter->error = 'L\'identifiant de la sous catégorie est vide';
    }
}
