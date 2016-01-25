#!/usr/bin/php
<?php
include ('fonctions.php');
$service=Connexion::query('select id,frequence,trl from services where monitore=1');

foreach ($service as $ligne){
    $date=Connexion::query('select max(date) from tests where service_id=\''.$ligne[0].'\'');
    $heure=Connexion::query('select max(heure) from tests where date=\''.$date[0][0].'\' and service_id=\''.$ligne[0].'\'');
    $dernierTest=$date[0][0].' '.$heure[0][0];
    $difference=difference($dernierTest);
    if ($difference>=(($ligne[1])*60) or $difference==0) {
        test($ligne[0]);
    }
}