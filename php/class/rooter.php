<?php

class rooter
{
  public $rooter;

  function get_url($namespace='accueil')
  {
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
    $this->view = $this->dossier_root.'php/views/view_'.$this->current_view.'.php';
    $this->secure_key = md5('autHorisationToupdatEoRdeleTE18357436*');
    return $this;
  }

  function construct_head($admin)
  {
    GLOBAL $site;
    $this->head['google_analytics'] =
    '
    ';

    $this->error = '';

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

    return $this;
  }

  function get_head($admin=0)
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

  function get_footer($admin=0,$error=null)
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
            write_error(\''.addslashes($GLOBALS['error']).'\');
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
