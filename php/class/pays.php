<?php
class pays
{
  public $pays;

  function __construct()
  {
    GLOBAL $bdd;
    $list = array();
    $i = 0;

    $bdd->select('*','pays');
    while($p = $bdd->rep->fetch())
    {
      $list[$i]['id'] = $p['id'];
      $list[$i]['href_lang'] = $p['alpha3'];
      $list[$i]['nom'] = $p['nom_fr_fr'];
      $list[$i]['extension'] = mb_strtolower($p['alpha2'],'UTF-8');
      $i++;
    }

    $this->list = $list;
  }
}
?>
