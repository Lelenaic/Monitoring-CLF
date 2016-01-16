<?php
include ('../includes/class_connexion.php');
include ('../includes/fonctions/fonctions.php');

function deco(){
    logs('deconnexion','reussi');
    session_start();
    session_destroy();
}

echo deco();
header('Location: ?page=login');