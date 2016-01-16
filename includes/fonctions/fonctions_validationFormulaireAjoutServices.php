<?php
   
  
function validationFormulaireAjoutServices(){
    $idPseudo = $_POST['pseudo'];
    $nomService =$_POST['nomService'];
    $url =$_POST['urlnew'];
    $port =$_POST['port'];
    $texte =$_POST['texte'];
    $mail =$_POST['mail'];
    $tel =$_POST['tel'];
    $monitore =$_POST['monitore'];
    $trl =$_POST['trl'];
    $frequence =$_POST['frequence'];
    if (verifSites($url)==false){
        $requete='INSERT INTO services (utilisateurs_id,nom,url,port,texte,mail,tel,monitore,trl,frequence) VALUES ("'.$idPseudo.'","'.$nomService.'","'.$url.'","'.$port.'","'.$texte.'","'.$mail.'","'.$tel.'","'.$monitore.'","'.$trl.'","'.$frequence.'")';
        Connexion::exec($requete);
        echo '<meta http-equiv="refresh" content="0; URL=?page=services&ajoutOk">';
    }else{
        echo '<META http-equiv="refresh" content="0; URL=?page=services&erreurUrl">';
    }
}

function verifHttp($url,$port){
    if (strpos($url,'http://')==false) {
        if (strpos($url,'https://')==false) {
            if ($port=='80') {
                $return='http://'.$url;
            }else{
                $return='https://'.$url;
            }
        }else{
            $return=$url;
        }
    }else{
        $return=$url;
    }
    return $return;
}

function validationFormulaireModificationServices(){
   
    $idPseudo = $_POST['pseudo'];
    $port =$_POST['port'];
    $nomService =$_POST['nomService'];
    $url =verifHttp($_POST['urledit'],$port);
    $texte =$_POST['texte'];
    $mail =$_POST['mail'];
    $tel =$_POST['tel'];
    $monitore =$_POST['monitore'];
    $trl =$_POST['trl'];
    $frequence =$_POST['frequence'];

    $id=$_POST['idServices'];
    
    $requete='SELECT id,nom,url,port,texte,mail,tel,monitore,trl,frequence FROM services WHERE url = \''.$url.'\'';
    $nouveauService = Connexion::query($requete);
    if (verifSites($url)==false){
        $requete='Update services SET utilisateurs_id = \''.$idPseudo.'\', nom = \''.$nomService.'\', url = \''.$url.'\', port = \''.$port.'\', texte = \''.$texte.'\', mail =\''.$mail.'\', tel = \''.$tel.'\', monitore= \''.$monitore.'\', trl =  \''.$trl.'\', frequence = \''.$frequence.'\' Where id = '.$id.'';
        Connexion::exec($requete);
        echo '<meta http-equiv="refresh" content="0; URL=?page=services&modifOk">';
    }else{
        echo '<META http-equiv="refresh" content="0; URL=?page=services&erreurUrl">';
    }
    return $nouveauService ;
}

function validationFormulaireSuppressionServices(){
    $id=$_POST['idServicesSuppr'];
    $requete='Delete From services Where id = '.$id.'';
    Connexion::exec($requete);
    echo '<META http-equiv="refresh" content="0; URL=?page=services&supprOk">';
}

