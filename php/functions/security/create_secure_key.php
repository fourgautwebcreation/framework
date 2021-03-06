<?php

/**
* php/functions/create_secure_key.php
*
* Cette fonction créée une clé de sécurité aléatoire de 20 caractères encodée en md5
*
* @return string $key Le clé de sécurité
*/

function create_secure_key()
{
 $letters = 'aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789=+%ù';
 $length = strlen($letters);
 $key = '';

 for($i = 0; $i < 21; $i++)
 {
  $caractere = rand(0,$length-1);
  $key .= $letters[$caractere];
 }

 return md5($key);
}
