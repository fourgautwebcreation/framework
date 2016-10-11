<?php
class Autoloader{

    // Autoload des class
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
