<?php
$permission=80;
include ('../includes/class_connexion.php');
require ('../includes/acces.php');
include ('../includes/fonctions/fonctions.php');

if(isset($_POST['annuler'])){
    header('Location:?page=utilisateurs');
}

if(isset($_POST['valider'])){
    Connexion::exec('INSERT INTO utilisateurs(pseudo,mdp,groupes_id) VALUES ("'.$_POST['uPseudo'].'","'.password_hash($_POST['uMdp'],PASSWORD_DEFAULT).'","'.$_POST['uGroupe'].'")');
    logs('ajout utilisateur ','reussi');
    header('Location:?page=utilisateurs');
    
}

if(isset($_POST['modifier'])){
    if($_POST['uMdp']==''){
        $mdp='';
    }else{
        $mdp=',mdp="'.password_hash($_POST['uMdp'],PASSWORD_DEFAULT).'" ';
    }
    echo $mdp;
    $requete='UPDATE utilisateurs SET pseudo="'.$_POST['uPseudo'].'"'.$mdp.',groupes_id='.$_POST['uGroupe'].' WHERE id='.$_POST['uId'].'';
    echo $requete;
    Connexion::exec($requete);    
    logs('modification utilisateur ','reussi');
    header('Location:?page=utilisateurs');
}

if(isset($_POST['supprimer'])){
    $verif=Connexion::query('SELECT id FROM services WHERE utilisateurs_id='.$_POST['uId']);
    if(!isset($verif[0][0])){
        Connexion::exec('DELETE FROM utilisateurs WHERE id="'.$_POST['uId'].'"');
        logs('suppression utilisateur','reussi');
    }else{
        logs('suppression utilisateur','echec');
    }
    header('Location:?page=utilisateurs');
}