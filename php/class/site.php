<?php
class site
{

public $site;

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
