<?php

echo $rooter->head;

if(empty($session_id)):
  include $rooter->dossier_root.'php/lib/admin/mods/connexion.php';
else:
  include $rooter->dossier_root.'php/lib/admin/mods/home/index.php';
endif;
echo $rooter->footer;
?>
