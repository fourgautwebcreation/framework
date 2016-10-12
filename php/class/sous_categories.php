<?php
/**
* php/class/sous_categories.php
*/

class sous_categories
{

  /**
  * @var array $list
  * La liste des sous catégories
  */
  public $list;


  /**
  * Fonction de construction automatique lorsque la class est instanciée
  *
  * Elle récupère en base de donnée, dans le table sous catégories, toutes les sous catégories renseignées
  *
  * @return array $list
  * Le nom, l'identifiant et l'attribut modifiable de chaque ligne
  */

  function __construct()
  {
    GLOBAL $bdd;
    $list = array();
    $i = 0;

    $bdd->select('*','sous_categories');
    while($rep = $bdd->rep->fetch())
    {
      $list[$i]['nom'] = ucfirst($rep['sous_categorie_nom']);
      $list[$i]['id'] = $rep['sous_categorie_id'];
      $list[$i]['modifiable'] = $rep['sous_categorie_modifiable'];
      $i++;
    }
    sort($list);
    $this->list = $list;
  }
}
?>
