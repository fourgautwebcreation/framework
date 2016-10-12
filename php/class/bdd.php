<?php

/**
* php/class/bdd.php
*
* Class de gestion de connexion et requêtes en base de donnée
*/

class bdd
{

  /**
  * @var object $connected
  * La connexion PDO
  */
  private $connected;

  /**
  * @var array $debug
  * Le tableau d'erreurs de la dernière opération
  */
  public $debug;

  /**
  * @var string $failed_request
  * La requête qui a échoué
  */
  public $failed_request;

  /**
  * @var int $result
  * L'éxécution de la requête true | false
  */
  public $result;

  /**
  * @var mixed $rep
  * La réponse transmise par la requête
  */
  public $rep;
  /**
  * Fonction de connexion PDO à la base de donnée
  *
  * Possibilité de renseigner les arguments globaux et locaux
  */

  function connect()
  {
    if($_SERVER['REMOTE_ADDR']=="127.0.0.1")
    {
      $host = 'localhost';
      $db_name = 'developpement';
      $db_user = 'root';
      $db_pass = 'root';
    }
    else
    {
      $host = '';
      $db_name = '';
      $db_user = '';
      $db_pass = '';
    }
    try
    {
      $this->connected = new PDO('mysql:host='.$host.';dbname='.$db_name, $db_user, $db_pass);
      $this->connected->exec("set names utf8");
    }
    catch (Exception $e)
    {
      echo $e->getMessage();
    }
  return $this;
  }

  /**
  * Fonction de débug de requête sql
  *
  * Pour l'affichage du débug, se reporter aux uses
  *
  * Cette fonction définit les variables $debug et $failed_request de l'objet $bdd
  *
  * @uses rooter::get_head
  * Pour l'affichage du débug
  *
  * @uses php/includes/config.php
  * Concernant la constante environnement
  *
  * @param object $req
  * La requête à traiter
  */

  function debug($req)
  {
    if(ENVIRONNEMENT == 'dev')
    {
        $this->debug = $req->errorInfo();
        $this->failed_request = $req->queryString;
    }
  }

  /**
  * Fonction de préparation et d'éxécution de requête SQL
  *
  * Utilisée dans le cadre d'une requête SQL déjà formatée
  *
  * @param object $req
  * La requête à traiter
  *
  * @return int $result
  * L'éxécution de la requête true | false
  */

  function executeRequest($req)
  {
      $req = $this->connected->prepare($req);
      $this->result = $req->execute();

      if($this->result==0)
      {
        bdd::debug($req);
      }
      return $this;
  }

  /**
  * Fonction de séléction SQL
  *
  * Définit la variable $result de l'objet. Succés de l'insertion true | false
  *
  * Définit la variable $rep de l'objet. La réponse de la séléction
  *
  * @param string $select
  * Les champs à séléctionner
  *
  * @param string $from
  * Le table à séléctionner
  *
  * @param array $where
  * Les conditions where de forme 'foo="bar"'
  *
  * @param string $order
  * L'ordre de tri
  *
  * @param int $type
  * Le type (0 pour un select, 1 pour un count)
  *
  *
  * @return object $this
  * L'objet $bdd
  */

  function select($select,$from,$where=null,$order=null,$debug=null,$type=0)
  {

    $where_content = '';
    if(is_array($where))
    {
      $i = 0;
      foreach($where as $w)
      {
        if($i==0)
        {
          $where_content .= ' WHERE '.$w;
        }
        else
        {
          $where_content .= ' AND '.$w;
        }
        $i++;
      }
    }

    $order_by = '';
    if($order!==null){$order_by = $order;}

    $req = $this->connected->prepare('SELECT '.$select.' FROM '.$from.$where_content.' '.$order);
    $this->result = $req->execute();
    //Si la demande concerne une while / fetch
    if($type==0)
    {
      $array = $req;
    }
    //Si la demande concerne un count
    else
    {
      $array = $req->rowCount();
    }

    if($this->result==0)
    {
      bdd::debug($req);
    }

    $this->rep = $array;
    return $this;
  }

  /**
  * Fonction d'insertion SQL
  *
  * @param string $table
  * Le table dans lequel le champ doit être inséré
  *
  * @param array $columns
  * Les champs ciblés
  *
  * @param array $values
  * Les valeurs à insérer
  *
  * @return int $result
  * Succés de l'insertion true | false
  *
  */

  function insert($table,$columns,$values,$debug=null)
  {
    $list_columns = '';
    if(is_array($columns))
    {
      $i = 0;
      $count = count($columns);
      $list_columns .= '(';
      foreach($columns as $c)
      {
        if($c==end($columns) && $i==$count-1)
        {
          $list_columns .= $c;
        }
        else
        {
          $list_columns .= $c.',';
        }
        $i++;
      }
      $list_columns .= ')';
    }

    $list_values = ' VALUES (';
    if(is_array($values))
    {
      $i = 0;
      $count = count($values);
      foreach($values as $v)
      {
        if($v==end($values) && $i==$count-1)
        {
          $list_values .= $v;
        }
        else
        {
          $list_values .= $v.',';
        }
        $i++;
      }
    }
    $list_values .= ')';

      $req = $this->connected->prepare('INSERT INTO '.$table.$list_columns.$list_values);
      $this->result = $req->execute();

      if($this->result==0)
      {
        bdd::debug($req);
      }
      return $this;
  }

  /**
  * Fonction d'update SQL
  *
  * @param string $table
  * Le table où se trouvent les champs à update
  *
  * @param array $updates
  * Les noms des champs et leurs nouvelles valeurs de type 'foo="bar"'
  *
  * @param array $where
  * Les conditions where de forme 'foo="bar"'
  *
  * @return int $result
  * Le succès de la requête true | false
  *
  */

  function update($table,$updates,$where,$debug=null)
  {
    $i = 0;
    $up = '';
    $count = count($updates);
    foreach($updates as $update)
    {
      if($update==end($updates) && $i==$count-1)
      {
        $up .= $update;
      }
      else
      {
        $up .= $update.',';
      }
      $i++;
    }

    $i = 0;
    $where_content = '';
    if(is_array($where))
    {
      foreach($where as $w)
      {
        if($i==0)
        {
          $where_content .= ' WHERE '.$w;
        }
        else
        {
          $where_content .= ' AND '.$w;
        }
        $i++;
      }
    }

    $req = $this->connected->prepare('UPDATE '.$table.' SET '.$up.$where_content);
    $this->result = $req->execute();

    if($this->result==0)
    {
      bdd::debug($req);
    }
    return $this;
  }

  /**
  * Fonction de delete SQL
  *
  * @param string $table
  * Le table ou se trouve la ligne à delete
  *
  * @param array $where
  * Les conditions à remplir de type 'foo="bar"'
  *
  * @return int $result
  * Le succès de la requête true | false
  */

  function delete($table,$where=null,$debug=0)
  {
    $i = 0;
    $up = '';

    $i = 0;
    $where_content = '';
    foreach($where as $w)
    {
      if($i==0)
      {
        $where_content .= ' WHERE '.$w;
      }
      else
      {
        $where_content .= ' AND '.$w;
      }
      $i++;
    }

    $req = $this->connected->prepare('DELETE FROM '.$table.' '.$where_content);
    $this->result = $req->execute();

    if($this->result==0)
    {
      bdd::debug($req);
    }
    return $this;
  }

  /**
  * Fonction de récupération du dernier champ ajouté
  *
  * @param string $name
  * Le nom du champ identifiant du type "user_id"
  *
  * @return int $lastInsertId
  * L'identifiant du dernier champs ajouté
  */

  function lastInsertId($name)
  {
    $last = $this->connected->lastInsertId($name);
    $this->lastInsertId = $last;
  }

}
