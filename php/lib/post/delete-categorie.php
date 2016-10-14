<?php

/*
* Suppression d'une catégorie
*
* Page : /admin/page=categories
*/


if( $rooter->locked == 0 )
{
    if(!empty($_POST['id']))
    {
      $id = intval($_POST['id']);

      //passage des produits de cette catégorie en non classés
      $bdd->update('produits',array('produit_categorie="1"','produit_sous_categorie="0"'),array('produit_categorie="'.$id.'"'));
      $bdd->delete('categories',array('categorie_id="'.$id.'"'));
      header('location:/admin/page=categories');
      exit;
    }
    else
    {
      $rooter->error = 'L\'identifiant de la catégorie est vide';
    }
}
