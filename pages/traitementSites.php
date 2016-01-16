<?php
$permission=80;
include ('../includes/class_connexion.php');
require ('../includes/acces.php');
include ('../includes/fonctions/fonctions.php');

if (isset($_POST['supprId'])) {
    $id=$_POST['supprId'];
    $suppr=Connexion::exec('delete from sites where id='.$id.'');
    if (!$suppr) {
        logs('suppression du site n°'.$id,'echec');
    }else{
        logs('suppression du site n°'.$id,'reussi');
    }
    echo '<META http-equiv="refresh" content="0; URL=?page=sites&supprOk">';
}

if (isset($_POST['id'])) {
    $id=$_POST['id'];
    $user=$_POST['user']=='all' ? 'null':$_POST['user'];
    $url=$_POST['url'];
    $liste=$_POST['liste'];
    $domaine=$_POST['domaine'];
    $update=Connexion::exec('update sites set client_id='.$user.', url=\''.$url.'\', actif='.$liste.', domaine='.$domaine.' where id='.$id);
    if (!$update) {
        logs('mise à jour du site n°'.$id,'echec');
    }else{
        logs('mise à jour du site n°'.$id,'reussi');
    }
    echo '<META http-equiv="refresh" content="0; URL=?page=sites&modifOk">';
}

if (isset($_POST['ajout'])) {
    $admin=$_SESSION['id'];
    $user=$_POST['user']=='all' ? 'null':$_POST['user'];
    $url=$_POST['url'];
    $liste=$_POST['liste'];
    $domaine=$_POST['domaine'];
    $insert=Connexion::exec('insert into sites (client_id,user_id,url,actif,domaine) values ('.$user.',\''.$admin.'\',\''.$url.'\',\''.$liste.'\',\''.$domaine.'\')');
    if (!$insert) {
        logs('ajout : un nouveau site','echec');
    }else{
        logs('ajout : un nouveau site','reussi');
    }
    echo '<META http-equiv="refresh" content="0; URL=?page=sites&ajoutOk">';
}