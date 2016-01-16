<?php
                     
function label($actif){
    if ($actif==1) {
        $html='<span class="label label-success">Whitelist</span>';
    }else{
        $html='<span class="label label-danger">Blacklist</span>';
    }
    return $html;
}

function user($id=null){
    if (is_null($id)) {
        $return='Tous les utilisateurs';
    }elseif(!is_null($id)){
        $user=Connexion::query('select pseudo from utilisateurs where id='.$id);
        $return=$user[0][0];
    }else{
        $user=Connexion::query('select pseudo from utilisateurs');
    }
    return $return;
}

function domaine($statut){
    if ($statut==1) {
        $html='<span class="label label-info">Oui</span>';
    }else{
        $html='<span class="label label-warning">Non</span>';
    }
    return $html;
}

function utilisateurs($clientId){
    $users=Connexion::query('select id,pseudo from utilisateurs');
    if ($clientId==null) {
        $html='<option value="all" selected>Tous les utilisateurs</option>';
    }else{
        $html='<option value="all">Tous les utilisateurs</option>';
    }
    foreach ($users as $ligne){
        if ($ligne[0]==$clientId) {
            $html.='<option value="'.$ligne[0].'" selected>'.$ligne[1].'</option>';
        }else{
            $html.='<option value="'.$ligne[0].'">'.$ligne[1].'</option>';
        }
    }
    return $html;
}

function liste($id){
    $liste=Connexion::query('select actif from sites where id='.$id.'');
    if ($liste[0][0]==1) {
        $html='<div class="radio"><label><input type="radio" name="liste" value="1" checked /> Whitelist</label></div>
               <div class="radio"><label><input type="radio" name="liste" value="0" /> Blacklist</label></div>';
    }else{
        $html='<div class="radio"><label><input type="radio" name="liste" value="1" /> Whitelist</label></div>
               <div class="radio"><label><input type="radio" name="liste" value="0" checked /> Blacklist</label></div>';
    }
    return $html;
}

function domaineRestriction($id){
    $liste=Connexion::query('select domaine from sites where id='.$id.'');
    if ($liste[0][0]==1) {
        $html='<div class="radio"><label><input type="radio" name="domaine" value="1" checked /> Oui</label></div>
               <div class="radio"><label><input type="radio" name="domaine" value="0" /> Non</label></div>';
    }else{
        $html='<div class="radio"><label><input type="radio" name="domaine" value="1" /> Oui</label></div>
               <div class="radio"><label><input type="radio" name="domaine" value="0" checked /> Non</label></div>';
    }
    return $html;
}

function pseudoConnecte(){
    $id=$_SESSION['id'];
    $user=Connexion::query('select pseudo from utilisateurs where id='.$id);
    return $user[0][0];
}

function quEstCe(){
    return '<small><button type="button" class="btn btn-default" data-toggle="modal" data-target="#restriction" style="margin:0px 0px 15px 50px;">Qu\'est-ce que <strong>la restriction par domaine</strong> ?</button></small>';
}

function quEstCe2(){
    return '<small><button type="button" class="btn btn-default" data-toggle="modal" data-target="#services" style="margin:0px 0px 15px 50px;">Quelles sont les <strong>informations importantes</strong>?</button></small>';
}