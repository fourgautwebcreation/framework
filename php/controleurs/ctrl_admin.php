<?php

//Déconnexion
if(isset($_GET['page']) && $_GET['page']=='deconnexion')
{
  $bdd->update('administrateurs',array('admin_deconnexion="'.time().'"'),array('admin_id="'.$_SESSION['admin'].'"'));
  session_unset();
  session_destroy();
  header('location:/admin');
  exit;
}

$rooter->get_head(1);
$rooter->get_footer(1,$error);
$session_id = verif_session('admin');

include $rooter->view;
?>
