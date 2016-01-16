<?php

function logs($action,$resultat){
    $id=isset($_SESSION['id']) ? $_SESSION['id']:0;
    $date=date('Y-m-d');
    $heure=date('H:i:s');
    $ip=$_SERVER['REMOTE_ADDR'];
    Connexion::exec('insert into logs (utilisateurs_id,action,resultat,date,heure,ip) values (\''.$id.'\',\''.$action.'\',\''.$resultat.'\',\''.$date.'\',\''.$heure.'\',\''.$ip.'\')');
}
