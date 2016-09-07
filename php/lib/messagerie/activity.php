<?php
set_time_limit(5);
include_once '../../class/bdd.php';
$bdd = new bdd;
$bdd->connect();

$id = intval($_POST['id']);
$key = trim($_POST['key']);

$bdd->update('administrateurs',array('admin_connexion="'.time().'"'),array('admin_id="'.$id.'"','admin_key="'.$key.'"'));

?>
