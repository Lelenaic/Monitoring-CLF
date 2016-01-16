<?php
 
include ('class_connexion.php');
$test=Connexion::query("SELECT * FROM utilisateurs");

var_dump($test);

?>
