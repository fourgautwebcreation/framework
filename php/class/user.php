<?php
/**
* php/class/user.php
*/

class user
{

  /**
  * @var string $ip
  * L'adresse IP de l'utilisateur
  */
  public $ip;

  /**
  * @var string $useragent
  * L'user agent du navigateur de l'utilisateur
  */
  public $useragent;

  /**
  * Fonction récupérant l'ip
  *
  * @return string $ip
  */

  function ip()
  {
    $this->ip = $_SERVER['REMOTE_ADDR'];
    return $this;
  }

  /**
  * Fonction récupérant l'user agent
  *
  * @return string $useragent
  */
  function useragent()
  {
    $this->useragent = $_SERVER['HTTP_USER_AGENT'];
    return $this;
  }

  /**
  * Fonction de construction automatique lorsque la class est instanciée
  *
  */

  function __construct()
  {
    $this->ip();
    $this->useragent();
    return $this;
  }
}
?>
