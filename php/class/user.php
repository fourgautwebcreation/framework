<?php
class user
{
  public $user;

  //Fonction récupérant l'ip
  function ip()
  {
    $this->ip = $_SERVER['REMOTE_ADDR'];
    return $this;
  }

  //Fonction récupérant l'user agent
  function useragent()
  {
    $this->useragent = $_SERVER['HTTP_USER_AGENT'];
    return $this;
  }

  //Fonction appelant toutes les autres de la classe
  function bat()
  {
    $this->ip();
    $this->useragent();
    return $this;
  }
}
?>
