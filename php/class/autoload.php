<?php
/**
* php/class/autoload.php
*
* Une fois instanciée, cette class permet d'inclure la totalité des class et fonctions
* en une seule fois
*
*/

class Autoloader{

    /**
    * @see http://php.net/manual/fr/function.spl-autoload-register.php
    */

    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */

    static function autoload($class){
        require 'php/class/' . $class . '.php';
    }

    /**
    * Effectue un scan des fichiers présents dans le dossier php/functions.
    * Inclue tous les fichiers présents dans ce dossier
    */

    public function autoloadFunctions(){
        $all = scandir('php/functions/');
        foreach($all as $function)
        {
            if($function !== '.' && $function !== '..')
            {
                require 'php/functions/' . $function;
            }
        }
    }

}
