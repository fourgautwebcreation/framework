<?php
class categories
{
  public $categories;

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
