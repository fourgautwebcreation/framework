<?php
function build_link($titre,$id)
{
	$explode = explode('/',$titre);
  $count = count($explode);
  $titre = str_replace('.php','',$explode[$count-1]);
  $titre = pure_link($titre);
  $lien = '/'.$id.'-'.$titre.'.html';
  return $lien;
}
?>
