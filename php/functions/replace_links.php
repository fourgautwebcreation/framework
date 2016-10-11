<?php

/**
* Cette fonction est utilisée dans le cadre de la messagerie instantanée
* Elle remplace les liens des messages par les vidéos ou les og:image des liens en question
*
* @param string $text Le texte transmis
*
* @param int $id_message L'identifiant du message dans lequel se trouve le texte (utilisé par jQuery)
*
* @return string $text Le html à retourner
*/

ini_set('user_agent','Mozilla/5.0 (Windows NT x.y; rv:10.0) Gecko/20100101 Firefox/10.0');
function replace_links($text,$id_message)
{
 $text = htmlspecialchars_decode($text);

 //si un lien est detecté
 if(preg_match_all('#(http(s)?\:\/\/(www\.)?|(www\.)|(ftp(s)?\:\/\/))[a-zA-Z0-9-\--\_]+\.[a-zA-Z0-9-\#-\&-\.-\/-=-\?-\_]+#i',$text,$matchs))
 {
  foreach($matchs[0] as $key=>$match)
  {

    //défition du nom de domaine
    preg_match('#(http(s)?\:\/\/(www\.)?|(www\.)|(ftp(s)?\:\/\/))[a-zA-Z0-9-\--\_]+\.[a-z]+#i',$match,$d);

    $domaine = $d[0];

    $titre = '';
    $img = '';
    $description = '';
    $data_plateforme = '';
    $data_iframe = '';

    if(preg_match('#youtube.com\/watch\?v\=#',$match,$youtube))
    {
      $explode = explode('watch?v=',$match);
      $id = $explode[1];
      $id = explode('&',$id);
      $id = $id[0];

      $get = file_get_contents('https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v='.$id.'&format=json');
      $infos = json_decode($get);

      $img = $infos->thumbnail_url;
      $titre = $infos->author_name.' - '.$infos->title;
      $data_plateforme = 'youtube';
      $data_iframe = 'https://www.youtube.com/embed/'.$id.'?autoplay=1';
    }

    /* Fin youtube */

    /* Dailymotion */
    elseif(preg_match('#dailymotion.com\/video\/#',$match,$dailymotion))
    {
      $explode = explode('video/',$match);
      $id = $explode[1];
      $id = explode('_',$id);
      $id = $id[0];

      $get = file_get_contents('https://api.dailymotion.com/video/'.$id.'?fields=description,title,thumbnail_url');
      $infos = json_decode($get);

      $titre = $infos->title;
      $description = $infos->description;
      $img = $infos->thumbnail_url;
      $data_plateforme = 'dailymotion';
      $data_iframe = '//www.dailymotion.com/embed/video/'.$id.'?autoplay=1';
    }

    /* Fin dailymotion */

    /* Rutube */
    elseif(preg_match('#rutube.ru\/video\/#',$match,$rutube))
    {
      $explode = explode('video/',$match);
      $id = $explode[1];
      $id = explode('/',$id);
      $id = $id[0];

      $get = file_get_contents('http://rutube.ru/api/video/'.$id);
      $infos = json_decode($get);

      $titre = $infos->title;
      $img = $infos->thumbnail_url;
      $description = $infos->description;
      $data_plateforme = 'rutube';
      $data_iframe= $infos->embed_url;
    }

    /* Fin rutube */

    /* Si ce n'est pas une plateforme */

    else
    {
      $lien = file_get_contents($match);
      if(preg_match('#<meta property\=[\"\']og\:image[\"\'] content\=[\"\']([^\"\']*)#',$lien,$img))
      {
        //si le lien de l'image est relatif, on ajoute le nom de domaine devant
        if(substr($img[1],0,4) !== 'http' && substr($img[1],0,4) !== 'www.')
        {
          $img[1] = $domaine.$img[1];
        }
        $img = $img[1];
      }

      if(preg_match('#<meta name\=[\"\']description[\"\'] content\=[\"\'](.*)#i',$lien,$desc))
      {
        $in = array('"/>','" />',"'/>","' />");
        $desc[1] = str_replace($in,'',$desc[1]);
        $description = $desc[1];
      }
    }

    //execution du remplacement

    if(empty($titre))
    {
      $replace =
      '
      <a href="'.$match.'" target="_blank">
        <span class="link">'.$match.'</span>
      ';
    }
    else
    {
      $replace =
      '
      <a href="'.$match.'" target="_blank">
        <span class="link">'.$titre.'</span>
      ';
    }

    if(!empty($img))
    {
      $replace .= '<div data-key="'.$key.'"><img src="'.$img.'" data-key="'.$key.'" data-id="'.$id_message.'" data-plateforme="'.$data_plateforme.'" data-iframe="'.$data_iframe.'" alt="" class="img-responsive"/></div>';
    }
    if(!empty($description))
    {
      $replace .= '<div class="description"><span>'.htmlspecialchars($description,ENT_QUOTES).'</span></div>';
    }

    $replace .= '</a>';
    $text = str_replace($match,$replace,$text);
  }
 }

 return $text;
}
