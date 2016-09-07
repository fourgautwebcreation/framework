<?php
class produits
{
  public $produits;

  function __construct($admin=null)
  {
    GLOBAL $bdd;
    $list = array();
    $categories_saved = array();
    $i = 0;

    //selection des produits possédant une quantité
    if($admin == null)
    {
      $bdd->select('*','produits AS p INNER JOIN categories AS c ON (p.produit_categorie=c.categorie_id) INNER JOIN sous_categories AS sc ON (p.produit_sous_categorie=sc.sous_categorie_id)',array('produit_quantite<>"0"'));
    }
    else
    {
      $bdd->select('*','produits AS p INNER JOIN categories AS c ON (p.produit_categorie=c.categorie_id) INNER JOIN sous_categories AS sc ON (p.produit_sous_categorie=sc.sous_categorie_id)');
    }


    while($rep = $bdd->rep->fetch())
    {

      $list[$i]['timestamp'] = $rep['produit_timestamp'];
      $list[$i]['id'] = $rep['produit_id'];
      $list[$i]['nom'] = $rep['produit_nom'];
      $list[$i]['prix'] = $rep['produit_prix'];
      $list[$i]['quantite'] = $rep['produit_quantite'];
      $list[$i]['illustration'] = $rep['produit_illustration'];
      $list[$i]['categorie'] = $rep['produit_categorie'];
      $list[$i]['sous_categorie'] = $rep['produit_sous_categorie'];
      $list[$i]['nom_categorie'] = $rep['categorie_nom'];
      $list[$i]['nom_sous_categorie'] = $rep['sous_categorie_nom'];


      //enregistrement de la catégorie du produit
      $categorie_renseignee = 0;
      $sous_categorie_renseignee = 0;
      $count = count($categories_saved);
      $cle = 0;

      //parcours des categories renseignees
      if(!empty($categories_saved))
      {
        foreach($categories_saved as $key=>$categorie_save)
        {
          if($categorie_save['id'] == $rep['produit_categorie'])
          {
            $categorie_renseignee = 1;
            $cle = $key;
          }

          //parcours des sous_categories de la categorie
          if(isset($categorie_save['sous_categories']) && !empty($categorie_save[$key]['sous_categories']))
          {
            foreach($categorie_save['sous_categories'] as $sous_categorie)
            {
              if($sous_categorie['id'] == $rep['produit_sous_categorie'])
              {
                $sous_categorie_renseignee = 1;
              }
            }
          }
        }
      }

      //si la categorie n'a jamais été renseignée
      if($categorie_renseignee == 0)
      {
        $cle = $count;
        $categories_saved[$count]['id'] = $rep['produit_categorie'];
        $categories_saved[$count]['nom'] = $rep['categorie_nom'];
        $categories_saved[$count]['sous_categories'] = array();
      }

      if($sous_categorie_renseignee == 0)
      {
        //aucune sous catégorie de renseignée
        if(!isset($categories_saved[$cle]['sous_categories']) OR (isset($categories_saved[$cle]['sous_categories']) && empty($categories_saved[$cle]['sous_categories'])))
        {
          $categories_saved[$cle]['sous_categories'][0] = array('id'=>$rep['produit_sous_categorie'],'nom'=>$rep['sous_categorie_nom']);
        }
        else
        {
          $key2 = count($categories_saved[$cle]['sous_categories']);
          $categories_saved[$cle]['sous_categories'][$key2] = array('id'=>$rep['produit_sous_categorie'],'nom'=>$rep['sous_categorie_nom']);
        }
      }
      $i++;
    }
    arsort($list);

    $this->list = $list;
    $this->categories = $categories_saved;
  }
}
?>
