<?php
session_start();
if(!isset($_SESSION['pseudo'])){
    header('Location: ?page=login');
    die;
}elseif($_SESSION['groupe']<$permission){
    header('Location: ?page=accesRefuse');
}else{
    $id=$_SESSION['id'];
    $verif=Connexion::query('select id from utilisateurs where id=\''.$id.'\'');
    if (!isset($verif[0][0])) {
        header('Location: ?page=login');
    }
}