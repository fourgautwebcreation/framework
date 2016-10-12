<?php
/**
* php/class/site.php
*/

class site
{
  /**
  * @var string $titre
  * Le titre du site
  */
  public $titre;

  /**
  * @var string $desciption
  * La description du site
  */
  public $description;

  /**
  * @var string $illustration
  * L'image d'illustration du site
  */
  public $illustration;

  /**
  * @var int $cible
  * L'identifiant du pays cible se trouvant dans le table pays
  */
  public $cible;

  /**
  * @var string $href_lang
  * Le code alpha2 du pays cible pour la balise href_lang
  */
  public $href_lang;

  /**
  * @var string $facebook
  * La page facebook du propriétaire
  */
  public $facebook;

  /**
  * @var string $twitter
  * Le twitter du propriétaire
  */
  public $twitter;

  /**
  * @var int $maintenance
  * Activation de la maintenance (true | false).
  * Si true, une redirection est effectuée sur index.php
  */
  public $maintenance;

  /**
  * @var int $messagerie
  * L'activation de la messagerie dans l'administration (true | false)
  */
  public $messagerie;

  /**
  * Fonction de construction automatique lorsque la class est instanciée
  *
  * Elle récupère en base de donnée, dans le table options, tous les paramètres renseignés
  *
  * @return object $this
  * L'objet contenant les options du site
  */

  function __construct()
  {
  GLOBAL $bdd;
  $bdd->select('*','options INNER JOIN pays ON (options.option_cible = pays.id)');
  $rep = $bdd->rep->fetch();

  $this->titre = $rep['option_titre'];
  $this->description = $rep['option_description'];
  $this->illustration = $rep['option_illustration'];
  $this->cible = $rep['option_cible'];
  $this->href_lang = $rep['alpha2'];
  $this->facebook = $rep['option_facebook'];
  $this->twitter = $rep['option_twitter'];
  $this->maintenance = $rep['option_maintenance'];
  $this->messagerie = $rep['option_messagerie'];

  return $this;
  }

}
?>
