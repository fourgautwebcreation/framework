<?php
session_start();

include_once 'php/class/rooter.php';
include_once 'php/class/bdd.php';
include_once 'php/class/pays.php';
include_once 'php/class/site.php';
include_once 'php/class/categories.php';
include_once 'php/class/sous_categories.php';
include_once 'php/class/produits.php';

$namespace = 'accueil';
if(isset($_GET['namespace']) && !empty($_GET['namespace']))
{
  $namespace = explode('/',$_GET['namespace']);
  unset($_GET['namespace']);
}

$bdd = new bdd;
$bdd->connect();
include_once 'php/includes/sql.php';

$site = new site;
$site->__construct();

$rooter = new rooter;
$rooter->get_url($namespace);
if($site->maintenance == 1 && $rooter->current_view!=='admin' && $rooter->current_view!=='maintenance')
{
  header('location:/maintenance');
  exit;
}

include 'php/includes/autoload.php';

$pays = new pays;
$categories = new categories;
$sous_categories = new sous_categories;
$produits = new produits;

if(file_exists($rooter->controleur))
{
  $inc = include $rooter->controleur;
}
else
{
  echo 'Le controlleur '.$rooter->controleur.' est introuvable';
}
?>
