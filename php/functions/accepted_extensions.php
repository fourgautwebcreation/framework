<?php
function accepted_extensions($extension)
{
  $accepted = array('jpg','jpeg','gif','png');
  $ok = 0;
  foreach($accepted as $a)
  {
    if($a == $extension)
    {
      $ok = 1;
    }
  }
  return $ok;
}
?>
