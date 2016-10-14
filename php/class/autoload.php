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

    /**
    * @var array $subfolders Le tableau des sous dossiers trouvés
    */
    public $subfolders;

    /**
    * @var array $functions Le tableau des fonctions chargées
    */
    public $functions;

    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */

    static function autoload($class){
        GLOBAL $rooter;
        include_once($rooter->dossier_root.'php/class/' . $class . '.php');
    }

    /**
    * Effectue un scan des fichiers et dossiers présents dans le dossier passé en paramètre.
    *
    * Enregistre les fichiers .php dans le tableau des fonctions
    * Enregistre les sous dossiers dans le tableau des sous dossiers
    * Celà permets une organisation personelle des fonctions dans le dossier php/functions
    * Permet également d'accéder à la liste des fonctions appelées ainsi qu'à leur chemins
    * respectifs via la propriété $functions de l'objet
    *
    * @param string $folder Le chemin du dossier à scanner
    */

    public function loadFunctions($folder = 'php/functions'){
        $all = scandir($folder); // scan du dossier
        /*
        * Préparation du tableau des sous dossiers
        */
        if(!is_array($this->subfolders))
        {
            $this->subfolders = array();
        }
        /*
        * Si le folder en cours est présent dans le tableau de sous dossiers, on le supprime
        * afin d'éviter les doublons (dossier scanné 2 fois)
        */
        else
        {
            $key = array_search($folder,$this->subfolders);
            if($key !== false){
                unset($this->subfolders[$key]);
            }
        }

        /*
        * Récupération du tableau contenant les fonctions chargées
        */

        if(is_array($this->functions))
        {
            $count_loaded = count($this->functions)-1;
        }
        // Si inéxistant, on le crée
        else
        {
            $this->functions = array();
            $count_loaded = 0;
        }

        // Passage en revue du scan du dossier
        foreach($all as $function)
        {
            if($function !== '.' && $function !== '..')
            {
                // Si la ligne du pointeur équivaut à un dossier, on l'enregistre en sous dossier
                if(is_dir($folder.'/'.$function))
                {
                    $this->subfolders[] = $folder.'/'.$function;
                }
                // Si c'est un fichier
                else
                {
                    $length = strlen($function);
                    // On vérifie l'extension php du fichier
                    if(substr($function,($length-4),4) == '.php')
                    {
                        include_once($folder.'/'.$function);
                        $this->functions[$count_loaded]['function_file'] = $function;
                        $this->functions[$count_loaded]['function_link'] = $folder.'/'.$function;
                        $count_loaded++;
                    }
                }
            }
        }

        //passage en revue des sous dossiers enregistrés
        if(is_array($this->subfolders) && !empty($this->subfolders))
        {
            self::loadSubFolders();
        }
    }

    /**
    * Cette fonction passe en revue les sous dossiers enregistrés
    * et appele la fonction loadFunctions en lui passant en paramètre le sous dossier
    */

    private function loadSubFolders()
    {
        foreach($this->subfolders as $folder)
        {
            self::loadFunctions($folder);
        }
    }

    /**
    * Cette fonction est appelée depuis l'index, une fois toutes les fonctions sauvegardées,
    * elle inclue les fichiers correspondants
    */

    public function callFunctions()
    {
        foreach($this->functions as $function)
        {
            include_once($function['function_link']);
        }
    }
}
