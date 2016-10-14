----------------------

1. Documentation : http://yannfourgaut.com/framework

----------------------

2. Conventions

    1. Création d'une url

        1. 2 fichiers sont requis, le controleur et la vue

            1. Le controleur doit se trouver dans le dossier php/controleurs
               et posséder la syntaxe ctrl_\<nom\>.php, ou \<nom\> est égal au paramètre
               namespace définit dans le rooter.
               Exemple : pour l'url monsite.com/clients, le controleur relatif sera ctr_client.php
               S'il n'existe pas, il sera alors remplacé par ctrl_default.php
            2. La vue doit se trouver dans le dossier php/views
               et posséder la syntaxe view_<nom>.php, ou <nom> est égal au paramètre
               namespace définit dans le rooter.
               Exemple : pour l'url monsite.com/clients, la vue relative sera view_client.php   
               Si elle n'existe pas, elle sera alors remplacée par view_default.php

    2. Les fichiers relatifs au traitement POST   

        1. Ils doivent se trouver dans le dossier php/lib/post

            1. Leur syntaxe doit être de forme <type>.php, ou type représente la variable type du POST     
            2. Chaque fichier doit vérifier que la propriété $locked du rooter est égale à 0 avant de poursuivre.
            3. Pour que la propriété $locked soit définie à 0, le POST doit posséder une variable secure_key équivalente à la propriété $secure_key du rooter

3. Les class

    1. Le chargement des class est automatique dans l'index, n'importe quelle classe sera chargée
    2. pour une utilisation en API REST, se reporter au point 5

4. Les fonctions                

    1. Autoloader::loadFunctions couplé à Autoloader::callFunctions se chargeront de scanner le dossier php/functions et d'en charger tous les fichiers php trouvés. Il est donc possible d'organiser ce dossier à sa guise en sous dossiers.

5. Les impératifs et dépendances   

    1. Ordre d'inclusion de fichiers impératif et instanciation de class impératives
        1. php/includes/config.php contenant les constantes et le timezone
        2. php/class/rooter.php et instancier la class rooter
            1. new rooter(<GET>)
        3. php/class/autoload.php et instancier la class Autoloader
            1. new Autoloader
            2. Autoloader::register qui charge les class
            3. Autoloader::loadFunctions qui va sauvegarder toutes les fonctions
            4. Autoloader::callFunctions qui va inclure toutes les fonctions sauvegardées précédement
        4. Instancier la class bdd
            1. new bdd
            2. bdd::connect qui va se connecter à la base de données
        5. php/includes/post.php, fichier chargé de récupérer tout POST et de les traiter
        6. Intancier la class site
            1. new site               
