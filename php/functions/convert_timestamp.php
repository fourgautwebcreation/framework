<?php

/**
* php/functions/convert_timestamp.php
*
* Cette fonction est utilisée dans le cadre de la messagerie instantanée
* Elle converti les timestamp de dernière connexion en minutes, heures ou date
* selon le delai passé depuis la dernière connexion
*
* @param int $timestamp Le timestamp de la dernière connexion
*
* @return string|date $connexion Le temps passé depuis la dernière connexion
*/

function convert_timestamp($timestamp)
{
 $today = date('d/m/Y',time());
 $day = date('d',time());
 $heure = date('H',time());
 $minutes = date('i',time());

  if(!empty($timestamp))
  {
   //Si la derniere connexion remonte à aujourd'hui
   if(date('d/m/Y',$timestamp) == $today)
   {
    if(date('H',$timestamp) == $heure)
    {
     $connexion = $minutes-date('i',$timestamp).' min';
    }
    else
    {
     $connexion = $heure-date('H',$timestamp).' h';
    }
   }

   //si la derniere connexion était avant aujourd'hui
   else
   {
    $connexion = date('d/m/Y',$timestamp);
   }
 }
 else
  {
    $connexion = '';
  }

 return $connexion;
}
