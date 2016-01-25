<?php
include_once ('../includes/class_connexion.php');
include_once ('../includes/fonctions/fonctions_dates.php');
include_once ('../includes/fonctions/fonctions.php');
include_once ('../includes/fonctions/fonctions_mails.php');
include_once ('../includes/fonctions/fonctions_sms.php');

function ping ($url,$port,$texte,$trl){
    $url=url($url,$port);
    $texte=texte($url,$texte);
    if ($texte[0]===FALSE or $texte[1]!=200) {
        $resultat[]=false;
    }else{
        $resultat[]=true;        
    }
    $resultat[1]=$texte[1];
    $resultat[2]=$texte[2];
    //$res : 0 : texte trouvé ? true/false - 1 : code http - 2 : temps d'execution
    if ($resultat[0]==false or ($resultat[2]*1000)>$trl or $resultat[1]!='200') {
        sleep(10);
        $resultat=array();
        $url=url($url,$port);
        $texte=texte($url,$texte);
        if ($texte[0]===FALSE or $texte[1]!=200) {
            $resultat[]=false;
        }else{
            $resultat[]=true;        
        }
        $resultat[1]=$texte[1];
        $resultat[2]=$texte[2];  
    }
    return $resultat;
}

function texte($url,$texte){
    $premierTemps=microtime(true);
    $fichier=file($url);
    $dernierTemps=microtime(true);
    $temps=$dernierTemps-$premierTemps;
    $present[0]=false;
    for ($i=0;$i<count($fichier);$i++){
        if (strpos($fichier[$i],$texte)!==false){
            $present[0]=true;
            break;
        }
    }
    $present[]=substr($http_response_header[0],9,3);
    $present[]=$temps;
    return $present;
}

function url($url,$port){
    $parse=parse_url($url);
    $longueur=count($parse);
    if ($longueur==2){
        $res=$parse['scheme'].'://'.$parse['host'].':'.$port;
    }elseif($longueur==3){
        $res=$parse['scheme'].'://'.$parse['host'].':'.$port.$parse['path'];
    }elseif($longueur==4){
        $res=$parse['scheme'].'://'.$parse['host'].':'.$port.$parse['path'].'?'.$parse['query'];
    }
    return $res;
}

function test($serviceId){
    $tableau=Connexion::query('select url,port,texte,trl from services where id=\''.$serviceId.'\'');
    $url=$tableau[0][0];
    $port=$tableau[0][1];
    $texte=$tableau[0][2];
    $ping=ping($url,$port,$texte,$tableau[0][3]);
    $date=date('Y-m-d');
    $heure=date('H:i:s');
    $trl=$ping[2];
    $etat=$ping[0]==true ? 1:0;
    $codeHttp=strlen($ping[1])!=3 ? '500':$ping[1];
    Connexion::exec('insert into tests (service_id,date,heure,trl,etat,codeHttp) values (\''.$serviceId.'\',\''.$date.'\',\''.$heure.'\',\''.$trl.'\',\''.$etat.'\',\''.$codeHttp.'\')');
    if ($ping[0]==false or ($trl*1000)>$tableau[0][3] or $codeHttp!='200') {
        $res=false;
    }else{
        $res=true;
        validation($serviceId,$date,$heure);
    }
    if ($res==false) {
        notif($serviceId,$date,$heure);
        erreur($serviceId,$date,$heure);
    }
    return $res;
}

function difference($dernierTest){
    $date=date('Y-m-d H:i:s');
    $dernierTestCalcul=new DateTime($dernierTest);
    $dateCalcul=new DateTime($date);
    $difference=$dernierTestCalcul->diff($dateCalcul);
    $ans=($difference->format('%y'))*31536000;
    $mois=($difference->format('%m'))*2592000;
    $jours=($difference->format('%d'))*86400;
    $heures=($difference->format('%h'))*3600;
    $minutes=($difference->format('%i'))*60;
    $secondes=$difference->format('%s');
    $total=$ans+$mois+$jours+$heures+$minutes+$secondes;
    return $total;
}

function erreur($id,$date,$heure){
    $erreur=Connexion::query('select service_id,trl,etat,codeHttp from tests where service_id=\''.$id.'\' and date=\''.$date.'\' and heure=\''.$heure.'\''); 
    $service=Connexion::query('select texte,trl from services where id=\''.$erreur[0][0].'\'');
    if($erreur[0][3]!='200'){
        Connexion::exec('update services set statut=\'http\' where id=\''.$id.'\'');
    }elseif($erreur[0][2]!=1){
        Connexion::exec('update services set statut=\'texte\' where id=\''.$id.'\'');
    }elseif (($erreur[0][1]*1000)>($service[0][1])) {
        Connexion::exec('update services set statut=\'trl\' where id=\''.$id.'\'');
    }
}

function validation($id,$date,$heure){
    $service=Connexion::query('select statut from services where id=\''.$id.'\'');
    if ($service[0][0]!=1) {
        Connexion::exec('update services set statut=1 where id=\''.$id.'\'');
        $id=Connexion::query('select id from tests where service_id=\''.$id.'\' and date=\''.$date.'\' and heure=\''.$heure.'\'');
        mails($id[0][0],'ok');
        //sms($id[0][0],'ok');
    }
}

function notif($id,$date,$heure){
    $service=Connexion::query('select statut from services where id=\''.$id.'\'');
    $id=Connexion::query('select id from tests where service_id=\''.$id.'\' and date=\''.$date.'\' and heure=\''.$heure.'\'');
    Connexion::exec('update tests set erreur=1 where id=\''.$id[0][0].'\'');
    if ($service[0][0]==1) {
        var_dump($id[0][0]);
        mails($id[0][0]);
        //sms($id[0][0]);
    }
}

//echo url('https://www.lenaic.me/coucou?test',80);

//var_dump(parse_url('http://www.lenaic.me'));