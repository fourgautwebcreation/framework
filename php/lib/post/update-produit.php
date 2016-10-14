<?php
/*
* Update d'un produit
*
* Page : /admin/page=produits
*/


if( $rooter->locked == 0 )
{
    if(isset($_POST['id']) && !empty($_POST['id']) && !empty($_POST['nom']) && !empty($_POST['prix']))
    {
      $id = intval($_POST['id']);
      $nom = trim(htmlspecialchars($_POST['nom']));
      $prix = floatval($_POST['prix']);
      $quantite = floatval($_POST['quantite']);
      $categorie = intval($_POST['categorie']);
      $sous_categorie = intval($_POST['sous_categorie']);
      $bdd->select('*','produits',array('produit_id="'.$id.'"'));
      $rep = $bdd->rep->fetch();
      $illustration = $rep['produit_illustration'];

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
            if(!empty($illustration) && is_file($_SERVER['DOCUMENT_ROOT'].$illustration))
            {
              if(unlink($_SERVER['DOCUMENT_ROOT'].$illustration))
              {
                $illustration = '/img/produits/'.$new_name;
              }
            }
            elseif(empty($illustration))
            {
              $illustration = '/img/produits/'.$new_name;
            }
          }
        }
      }

      $bdd->update('produits',
                    array(
                      'produit_prix="'.$prix.'"',
                      'produit_nom="'.$nom.'"',
                      'produit_quantite="'.$quantite.'"',
                      'produit_illustration="'.$illustration.'"',
                      'produit_categorie="'.$categorie.'"',
                      'produit_sous_categorie="'.$sous_categorie.'"'),
                    array('produit_id="'.$id.'"')
                  );
      header('location:/admin/page=produits');
      exit;
    }
    else
    {
      $rooter->error = 'Merci de renseigner au minimum le nom et le prix';
    }
}
