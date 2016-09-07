<?php
if(!isset($GLOBALS['rooter']))
{
  $bdd = new bdd;
  $bdd->connect();
}

GLOBAL $rooter;
GLOBAL $bdd;



//Variable provenant du formulaire de connexion à l'extranet
if(isset($_POST['connexion_extranet']))
{
  if(isset($_POST['pseudo']) && !empty($_POST['pseudo']) && isset($_POST['pass']) && !empty($_POST['pass']))
  {
    $pseudo = trim($_POST['pseudo']);
    $pass = md5(trim($_POST['pass']));

    $key = create_secure_key();
    $_SESSION['secure_key'] = $key;

    $bdd->select('*','administrateurs',array('admin_pseudo="'.$pseudo.'"','admin_pass="'.$pass.'"'));
    $count = $bdd->rep->rowCount();
    if(!empty($count))
    {
      $rep = $bdd->rep->fetch();
      $_SESSION['admin'] = $rep['admin_id'];
      $_SESSION['admin_pseudo'] = $rep['admin_pseudo'];
      $_SESSION['admin_pass'] = $rep['admin_pass'];
      $bdd->update('administrateurs',array('admin_connexion="'.time().'"','admin_key="'.$key.'"'),array('admin_id="'.$rep['admin_id'].'"'));

      header('location:'.$rooter->dossier.'admin');
      exit;
    }
    else
    {
      $error = 'Ce compte n\'est pas reconnu';
    }
  }
}

//Toute modification effectuée depuis l'admin
elseif(isset($_POST['secure']) && $_POST['secure']==$rooter->secure_key && isset($_POST['type']) && !empty($_POST['type']))
{

  $type = trim($_POST['type']);

  //page options
  if($type == 'options')
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

  //ajout d'une catégorie
  elseif($type == 'add-categorie')
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
        $error = 'Ce nom est déjà utilisé';
      }
    }
    else
    {
      $error = 'Le nom de la catégorie est vide';
    }
  }

  //update d'une catégorie
  elseif($type == 'update-categorie')
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
        $error = 'Ce nom est déjà utilisé';
      }
    }
    else
    {
      $error = 'Le nom de la catégorie est vide';
    }
  }

  //delete d'une catégorie
  elseif($type == 'delete-categorie')
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
      $error = 'L\'identifiant de la catégorie est vide';
    }
  }

  //ajout d'une sous catégorie
  elseif($type == 'add-sous-categorie')
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
        $error = 'Ce nom est déjà utilisé';
      }
    }
    else
    {
      $error = 'Le nom de la sous catégorie est vide';
    }
  }

  //update d'une catégorie
  elseif($type == 'update-sous-categorie')
  {
    if(!empty($_POST['nom']))
    {
      $id = intval($_POST['id']);
      $nom = trim(htmlspecialchars($_POST['nom']));
      $bdd->select('*','sous_categories',array('sous_categorie_nom="'.$nom.'"'));
      $count = $bdd->rep->rowCount();
      if(empty($count))
      {
        $bdd->update('sous_categories',array('sous_categorie_nom="'.$nom.'"'),array('sous_categorie_id="'.$id.'"'));
        header('location:/admin/page=sous_categories');
        exit;
      }
      else
      {
        $error = 'Ce nom est déjà utilisé';
      }
    }
    else
    {
      $error = 'Le nom de la sous catégorie est vide';
    }
  }

  //delete d'une catégorie
  elseif($type == 'delete-sous-categorie')
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
      $error = 'L\'identifiant de la sous catégorie est vide';
    }
  }

  //ajout d'un produit
  elseif($type == 'add-produit')
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
      $error = 'Merci de renseigner au minimum le nom et le prix';
    }
  }

  //update d'un produit
  elseif($type == 'update-produit')
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
      $error = 'Merci de renseigner au minimum le nom et le prix';
    }
  }
}
?>
