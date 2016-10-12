<?php
/**
* php/class/pays.php
*/

class pays
{
  /**
  * @var array $list
  * La liste des pays 
  */
  public $list;

  /**
  * Fonction de construction automaique lorsque la class est instanciée
  *
  * Elle récupère en base de données dans le table pays tous les pays renseignés
  *
  * @return array $list L'identifiant, le code alpha3, le nom et l'extension de domaine des pays
  */

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
