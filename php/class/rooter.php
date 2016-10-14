<?php

/**
* php/class/rooter.php
*
* @uses php/class/pays.php
* @uses php/class/site.php
* @uses php/includes/config.php
*
*/

class rooter
{

  /**
  * @var string $error
  * L'indication de l'erreur à afficher. Variable appelée dans la fonction get_footer
  */
  public $error = '';

  /**
  * @var string $dossier
  * Le préfix utilisé pour l'inclusion html depuis la racine
  */
  public $dossier;

  /**
  * @var string $dossier_root
  * Le préfix utilisé pour l'inclusion php depuis la racine
  */
  public $dossier_root;

  /**
  * @var string $current_view
  * Le nom de la vue courante
  */
  public $current_view;

  /**
  * @var string $controleur
  * L'url du controleur correspondant à la vue courante sous la forme "php/controleurs/ctrl_<current_view>.php"
  * Cette url est inclue dans l'index.php
  */
  public $controleur;

  /**
  * @var string $view
  * L'url de la vue correspondante à la vue courante sous la forme "php/views/view_<current_view>.php"
  * Cette url est inclue dans le controleur correspondant
  */
  public $view;


  /**
  * @var string $secure_key
  * La clé de sécurité transmise en paramètre et vérifiée à chaque modification dans le panneau d'administration
  */
  public $secure_key;

  /**
  * @var bool $locked
  * Autorisation de modification sur base de donnée true | false
  */
  public $locked = 1;

  /**
  * @var string|array $head
  * Array lors de la fonction construct_head, string au format html lors de la fonction get_head
  */
  public $head;

  /**
  * @var string $footer
  * Le footer au format html
  */
  public $footer;

  /**
  * Fonction essentielle au rooting
  *
  * Cette fonction  définit le namespace url utilisé pour inclure le controleur et la vue correspondants
  * et passe en paramètre les $_GET fournis sous la forme foo=bar/bar=foo dans l'url.
  *
  * Attention ! Le terme namespace ici ne représente pas le namespace php, il n'est qu'un simple nom de variable
  *
  * @param string|array $namespace
  *         Le tableau fourni par un explode des "/" sur le $_GET['namespace'] effectué
  *         dans l'index et transmis au préalable par l'url rewriting du htaccess.
  *
  * Exemple d'url : http://monsite.com/accueil/foo=bar/toto=foo
  *
  * accueil est retourné en array[0] = "acceuil", il est donc définit en tant que namespace
  *
  * foo est retourné en array[1] = "foo=bar", la fonction le transforme en $_GET['foo'] = "bar"
  *
  * toto est retourné en array[2] = "toto=foo", la fonction le transforme en $_GET['toto'] = "foo"
  *
  * @return array $this
 */

  public function __construct($get = null)
  {
      // Construction des $_GET transmis au rooter
      if(is_array($get) && isset($get['namespace']))
      {
        $namespace = explode('/',$get['namespace']);
        unset($_GET);
      }
      else
      {
        $namespace = 'accueil';
      }
    $this->dossier = '/';
    $this->dossier_root = $_SERVER['DOCUMENT_ROOT'].$this->dossier;
    $this->current_view = $namespace;
    if(is_array($namespace))
    {
      $this->current_view = $namespace[0];
      foreach($namespace as $get)
      {
        if(strpos($get,'='))
        {
          if($get!==$namespace[0])
          {
            $get = explode('=',$get);
            $_GET[$get[0]] = $get[1];
          }
        }
      }
    }

    if(empty($this->current_view))
    {
      $this->current_view = 'accueil';
    }

    $this->controleur = $this->dossier_root.'php/controleurs/ctrl_'.$this->current_view.'.php';
    if(!file_exists($this->controleur))
    {
        $this->controleur = $this->dossier_root.'php/controleurs/ctrl_default.php';
    }
    $this->view = $this->dossier_root.'php/views/view_'.$this->current_view.'.php';
    if(!file_exists($this->view))
    {
        $this->view = $this->dossier_root.'php/views/view_default.php';
    }
    $this->secure_key = md5('autHorisationToupdatEoRdeleTE18357436*');
    return $this;
  }

  /**
  * Fonction de construction du contenu de la balise head
  *
  * Elle définit les lignes google analytics, css, charset, titre_site, favicon, description,
  * href_lang, og_description, og_image, og_title, robots, js, jquery, bootstrap, viewport ...
  *
  * @param int $admin
  * true | False. Origine de l'appel (public ou administration), transmis par la fonction get_head
  *
  * @uses php/class/pays.php
  * @uses php/class/site.php
  */

  private function construct_head($admin)
  {
    GLOBAL $site;
    $this->head['google_analytics'] =
    '
    ';

    $this->head['charset'] = '<meta charset="utf-8" />';
    $this->head['titre_site'] = '<title>'.ucfirst($this->current_view).' | '.$site->titre.'</title>';
    $this->head['favicon'] = '<link rel="icon" type="image/favicon" href="'.$this->dossier.'img/tools/favicon.png" />';
    $this->head['description'] = '<meta name="description" content="'.$site->description.'" />';
    $this->head['href_lang'] = '<link rel="alternate" href="'.$_SERVER['REQUEST_URI'].'" hreflang="'.$site->href_lang.'"/>';

    $this->head['og_description'] = '<meta property="og:description" content="'.$site->description.'" />';
    $this->head['og_image'] = '<meta property="og:image" content="'.$this->dossier.'img/tools/logo.jpg" />';
    $this->head['og_title'] = '<meta property="og:title" content="'.ucfirst($this->current_view).' | '.$site->titre.'" />';

    $this->head['css'] = '<link rel="stylesheet" type="text/css" href="'.$this->dossier.'css/style.css?'.time().'" />';
    $this->head['css'] .= '<link rel="stylesheet" type="text/css" href="'.$this->dossier.'css/font-awesome/css/font-awesome.css?'.time().'" />';
    $this->head['jquery'] = '<script src="'.$this->dossier.'js/jquery.js"></script>';
    $this->head['jquery'] .= '<script type="text/javascript" src="'.$this->dossier.'js/jquery-migrate.js"></script>';
    $this->head['jquery'] .= '<script src="'.$this->dossier.'js/jquery-ui.js"></script>';
    $this->head['js'] = '<script type="text/javascript" src="'.$this->dossier.'js/script.js?'.time().'"></script>';
    $this->head['js'] .= '<script type="text/javascript" src="'.$this->dossier.'js/yf_captcha/yf_captcha.js?'.time().'"></script>';

    $this->head['bootstrap'] = '<link rel="stylesheet" type="text/css" href="'.$this->dossier.'css/bootstrap/css/bootstrap.css" />';
    $this->head['bootstrap'] .= '<script type="text/javascript" src="'.$this->dossier.'css/bootstrap/js/bootstrap.js"></script>';

    $this->head['viewport'] = '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';

    if($admin==0)
    {
      $this->head['robots'] = '<meta name="robots" content="index,follow" />';
    }
    elseif($admin==1)
    {
      $this->head['robots'] = '<meta name="robots" content="noindex,nofollow" />';

      //Ajoutez ici les scripts à appeler côté administrateur
      if(isset($_SESSION) && !empty($_SESSION) && $site->messagerie == 1)
      {
        $this->head['css'] .= '<link href="/css/messagerie.css" rel="stylesheet" type="text/css" />';
        $this->head['css'] .= '<link rel="stylesheet" type="text/css" href="/css/emoji.css?'.time().'" />';
        $this->head['js'] .= '<script type="text/javascript" src="/js/messagerie.js?'.time().'"></script>';
      }

      $this->head['css'] .= '<link rel="stylesheet" type="text/css" href="'.$this->dossier.'css/admin/style.css?'.time().'" />';
      $this->head['js'] .= '<script type="text/javascript" src="'.$this->dossier.'js/admin/script.js?'.time().'"></script>';
      $this->head['js'] .= '<script type="text/javascript" src="'.$this->dossier.'js/admin/ckeditor/ckeditor.js?'.time().'"></script>';
      $this->head['js'] .= '<script type="text/javascript" src="'.$this->dossier.'js/admin/references.js?'.time().'"></script>';
    }
  }

  /**
  * Fonction de construction du doctype et de la balise head
  *
  * Cette fonction fait appel à la fonction construct_head et fait echo de son contenu
  * dans la balise html <head></head>. Elle ouvre également les balises <html> et <body>
  * qui seront fermées par la fonction get_footer. C'est également cette fonction qui gère l'affichage
  * du débug de la class bdd.
  * Cette fonction doit être appelée dans le controleur
  *
  * @param int $admin True | false. Origine de l'appel (public ou administration)
  *
  * @return string $head Le head au format html <html><head></head><body>
  */

  public function get_head($admin=0)
  {
    GLOBAL $bdd;
    rooter::construct_head($admin);
    $head =
    '
    <!DOCTYPE HTML>
      <html>
        <head>
          '.$this->head['charset'].'
          '.$this->head['href_lang'].'
          '.$this->head['robots'].'
          '.$this->head['titre_site'].'
          '.$this->head['favicon'].'
          '.$this->head['description'].'
          '.$this->head['og_title'].'
          '.$this->head['og_description'].'
          '.$this->head['og_image'].'
          '.$this->head['viewport'].'
          '.$this->head['css'].'
          '.$this->head['jquery'].'
          '.$this->head['js'].'
          '.$this->head['bootstrap'].'
        </head>
        <body>
    ';
    if(!empty($bdd->debug))
    {
        $head .= '<div class="debug">';
            $head .= '<span class="red">Erreur Sql</span> : '.$bdd->debug[2];
            $head .= '<br /> <span class="red">Requête</span> : <br />';
            $head .= $bdd->failed_request;
        $head .= '</div>';
        $head .= '<i class="fa fa-remove close-debug"></i>';
    }
    $this->head = $head;
    return $this;
  }

  /**
  * Fonction qui construit le footer
  *
  * Cette fonction doit être appelée dans le controleur
  *
  * @uses php/includes/config.php
  *
  * @param int $admin True | false. Origine de l'appel (public ou administration)
  *
  * @param string $error La variable $rooter->error, si non vide, un appel à une fonction
  * javascript affichant l'erreur est effectué
  *
  *@return string $footer Le footer au format html
  */

  public function get_footer($admin=0,$error=null)
  {
    $footer =
    '
      </body>
    </html>
    ';
    if($admin==1)
    {
      if(isset($error) && !empty($error))
      {
        $footer =
        '
          <script type="text/javascript">
            write_error(\''.addslashes($error).'\');
          </script>
          </body>
        </html>
      ';
      }
      else
      {
        $footer =
        '
          </body>
        </html>
        ';
      }
    }
    $this->footer = $footer;
    return $this;
  }

}

?>
