<?php

function pseudo(){
    $requete = 'SELECT id,pseudo FROM utilisateurs';
    $tableauPseudo = Connexion::query("$requete");
    return $tableauPseudo;
}

function nomPseudo($id){
    $requete = 'SELECT pseudo FROM utilisateurs WHERE id ='.$id.' ';
    $tableauPseudo = Connexion::query("$requete");
    return $tableauPseudo[0][0];
}