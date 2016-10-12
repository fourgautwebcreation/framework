<?php
/**
* php/class/categories.php
*
*/

class categories
{

  /**
  * @var array $list
  * La liste des catégories
  */
  public $list;

  /**
  * Fonction de construction automatique lorsque la class est instanciée
  *
  * Elle récupère en base de donnée dans le table catégories toutes les catégories renseignées
  *
  * @return array $list Le nom, l'identifiant et l'attribut modifiable de chaque ligne
  */

  function __construct()
  {
    GLOBAL $bdd;
    $list = array();
    $i = 0;

    $bdd->select('*','categories');
    while($rep = $bdd->rep->fetch())
    {
      $list[$i]['nom'] = ucfirst($rep['categorie_nom']);
      $list[$i]['id'] = $rep['categorie_id'];
      $list[$i]['modifiable'] = $rep['categorie_modifiable'];
      $i++;
    }
    sort($list);
    $this->list = $list;
  }
}
?>
