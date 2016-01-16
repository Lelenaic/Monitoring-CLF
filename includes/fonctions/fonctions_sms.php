<?php

function sms($id,$erreur=''){
    $infoServices=Connexion::query('SELECT services.id,services.nom,services.tel,tests.date,tests.heure,tests.trl,tests.codeHttp FROM tests,services WHERE tests.service_id=services.id AND tests.id='.$id.''); 
    $tel=$infoServices[0][2];
    if($erreur!=''){
        $sms='http://www.sms-lowcost.com/cgi-bin/?keyid=&num='.$tel.'&sms='.urlencode('[Monitoring Tridemark] Le service '.$infoServices[0][1].' est maintenant rétabli (id:'.$infoServices[0][0].')');
    }else{
        $sms='http://www.sms-lowcost.com/cgi-bin/?keyid=&num='.$tel.'&sms='.urlencode('[Monitoring Tridemark] Erreur sur le service '.$infoServices[0][1].' (id:'.$infoServices[0][0].')');
    }
    $fichier=file($sms);
    if (substr($fichier[0],55,1)==0){
        logs('envoi de sms, erreur pour le service '.$id,'reussi');
    }else{
        logs('envoi de sms, erreur pour le service '.$id,'echec');
    }
    
}
