<?php
session_start();

// Appel de la configuration
require 'php/includes/config.php';

// Appel du rooter
require 'php/class/rooter.php';
$rooter = new rooter($_GET);

// Appel de la class autoload des class
require 'php/class/autoload.php';
$autoloader = new Autoloader();
// Autoload des class
$autoloader->register();
// Enregistrement des fonctions
$autoloader->loadFunctions();
// Appel des fonctions
$autoloader->callFunctions();

// Connection à la base de données
$bdd = new bdd;
$bdd->connect();
// Inclusion des éxécutions automatiques sur la bdd
include_once 'php/includes/sql.php';


// Inclusion des éxécutions si POST envoyés
include_once 'php/includes/post.php';

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
include $rooter->controleur;
// Inclusion de la vue transmise par le rooter
include $rooter->view;
?>
