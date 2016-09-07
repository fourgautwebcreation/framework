<?php
class sous_categories
{
  public $sous_categories;

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
