<?php

/*
* Ajout d'un produit
*
* Page : /admin/page=produits
*/


if( $rooter->locked == 0 )
{
    if(!empty($_POST['nom']) && !empty($_POST['prix']))
    {
      $nom = trim(htmlspecialchars($_POST['nom']));
      $prix = floatval($_POST['prix']);
      $quantite = floatval($_POST['quantite']);
      $categorie = intval($_POST['categorie']);
      $sous_categorie = intval($_POST['sous_categorie']);
      $illustration = '';

      if(isset($_FILES['illustration']['tmp_name']) && !empty($_FILES['illustration']['tmp_name']))
      {
        $tmp = $_FILES['illustration']['tmp_name'];
        $name = $_FILES['illustration']['name'];
        $extension = pathinfo($name,PATHINFO_EXTENSION);
        $new_name = time().'.'.$extension;
        $dossier = $rooter->dossier_root.'img/produits/';
        if(!is_dir($dossier))
        {
        mkdir($dossier);
        }

        if(is_uploaded_file($tmp))
        {
          if(move_uploaded_file($tmp,$dossier.$new_name))
          {
            $illustration = '/img/produits/'.$new_name;
          }
        }
      }

      $bdd->insert('produits',
                    array('produit_prix','produit_nom','produit_quantite','produit_illustration','produit_categorie','produit_sous_categorie','produit_timestamp'),
                    array('"'.$prix.'"','"'.$nom.'"','"'.$quantite.'"','"'.$illustration.'"','"'.$categorie.'"','"'.$sous_categorie.'"','"'.time().'"')
                  );
      header('location:/admin/page=produits');
      exit;
    }
    else
    {
      $rooter->error = 'Merci de renseigner au minimum le nom et le prix';
    }
}
