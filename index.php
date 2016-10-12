<?php
session_start();

// Appel de la configuration
require 'php/includes/config.php';

// Appel de la class autoload
require 'php/class/autoload.php';
$autoloader = new Autoloader();

// Autoload des class
$autoloader->register();

// Connection à la base de données
$bdd = new bdd;
$bdd->connect();
include_once 'php/includes/sql.php';

// Construction des $_GET transmis au rooter
$namespace = 'accueil';
if(isset($_GET['namespace']) && !empty($_GET['namespace']))
{
  $namespace = explode('/',$_GET['namespace']);
  unset($_GET['namespace']);
}

// Appel du rooter
$rooter = new rooter;
$rooter->get_url($namespace);

// Autoload des fonctions
$autoloader->autoloadFunctions();

// Construction des détails du site
$site = new site;

// Redirection si site en maintenance
if($site->maintenance == 1 && $rooter->current_view!=='admin' && $rooter->current_view!=='maintenance')
{
  header('location:/maintenance');
  exit;
}

// Construction des autres objets
$pays = new pays;
$categories = new categories;
$sous_categories = new sous_categories;
$produits = new produits;

// Inclusion du controller transmis par le rooter
if(file_exists($rooter->controleur))
{
  $inc = include $rooter->controleur;
}
else
{
  echo 'Le controlleur '.$rooter->controleur.' est introuvable';
}
?>
