<?php
function remove_spaces($chaine)
{

  $chaine = nl2br(html_entity_decode($chaine));
  $returns = array('<br>','<br/>','<br />',"\n","\t","\r","\0","\x0B",'&#13;');
  $spaces = array('',' ',' ',' ',' ',' ',' ',' ',' ');
  $chaine = str_replace($returns,$spaces,$chaine);
  return $chaine;
}
function hide_spaces($chaine)
{

  $chaine = nl2br(html_entity_decode($chaine));
  $returns = array('<br>','<br/>','<br />');
  $spaces = array('','','');
  $chaine = str_replace($returns,$spaces,$chaine);
  return $chaine;
}
function convert_spaces($chaine)
{
  $chaine = htmlspecialchars_decode($chaine);
  return $chaine;
}
?>
