<?php
function pure_link($lien)
{
  $lien = trim(pure_characters($lien));
  $lien = mb_strtolower($lien,'UTF-8');
  $lien = str_replace(' ','-',$lien);
  return $lien;
}
?>
