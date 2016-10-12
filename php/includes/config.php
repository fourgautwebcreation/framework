<?php
date_default_timezone_set('Europe/Paris');
/**
* php/includes/config.php
*
* Si défini sur dev ou prod, php affichera les erreurs et le debug
* de la class bdd.php sera pris en compte
*
* Si défini sur public, les erreurs ne seront pas affichées
*
* @see php/class/bdd.php
* @see php/class/rooter.php
*
*/
define('ENVIRONNEMENT','dev'); // dev | prod | public

if(ENVIRONNEMENT == 'dev' || ENVIRONNEMENT == 'prod')
{
    ini_set('display_errors','on');
    ini_set('error_reporting',E_ALL);
}

elseif (ENVIRONNEMENT == 'public')
{
    ini_set('display_errors','off');
    ini_set('error_reporting',0);
}
