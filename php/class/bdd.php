<?php
class bdd
{
  public $bdd;

  //fonction de connexion à la base de données
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
  * @param object $req La requête à traiter
  *
  * @return array $debug Le tableau contenant les erreurs
  *
  * @return string $failed_request L'indication sur l'erreur
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
  * Fonction d'éxécution de requête sql
  *
  * @param object $req La requête à traiter
  *
  * @return int $result L'éxécution de la requête. 0 pour non, 1 pour oui
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

  //fonction de select sql
  function select($select,$from,$where=null,$order=null,$debug=null,$type=0)
  {
    // $type = 0 : select sql_sql
    //$type = 1 : count sql_sql

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

  //fonction update sql
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

  //fonction delete sql
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

  //last insert id
  function lastInsertId($name)
  {
    $last = $this->connected->lastInsertId($name);
    $this->lastInsertId = $last;
  }

}
