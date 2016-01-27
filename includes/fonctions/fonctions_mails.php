<?php

function mails($id,$erreur=''){
$infoServices=Connexion::query('SELECT services.nom,services.url,services.port,services.mail,tests.date,tests.heure,tests.trl,tests.codeHttp FROM tests,services WHERE tests.service_id=services.id AND tests.id='.$id.'');       
$adresse = $infoServices[0][3]; // Déclaration de l'adresse de destination.
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $adresse)) // On filtre les serveurs qui rencontrent des bogues.
{
	$passage_ligne = "\r\n";
}
else
{
	$passage_ligne = "\n";
}
//=====Déclaration des messages au format texte et au format HTML.
if($erreur!=''){
    $message_txt = 'Bonjour, votre service '.$infoServices[0][0].' disponible à l\'adresse '.$infoServices[0][1].' ayant le port '.$infoServices[0][2].' est maintenant rétabli.';
    $message_html = '<html><head></head><body><p style="text-align:center;font-size:30px;"><b>Monitoring</b> CLF</p>Bonjour, votre service '.$infoServices[0][0].' disponible à l\'adresse <a href="'.$infoServices[0][1].'">'.$infoServices[0][1].'</a> ayant le port '.$infoServices[0][2].' est maintenant rétabli.</body></html>';
}else{
    $message_txt = 'Bonjour, une erreur est survenue sur votre service '.$infoServices[0][0].' disponible à l\'adresse '.$infoServices[0][1].' ayant le port '.$infoServices[0][2].'. Elle est survenue le '.dateUS2FR($infoServices[0][4]).' à '.$infoServices[0][5].'. Le temps de réponse (TRL) était de '.floor(($infoServices[0][6])*1000).' ms et le code HTTP était le '.$infoServices[0][7];
    $message_html = '<html><head></head><body><p style="text-align:center;font-size:30px;"><b>Monitoring</b> CLF</p>Bonjour, une erreur est survenue sur votre service '.$infoServices[0][0].' disponible à l\'adresse <a href="'.$infoServices[0][1].'">'.$infoServices[0][1].'</a> ayant le port '.$infoServices[0][2].'. Elle est survenue le '.dateUS2FR($infoServices[0][4]).' à '.$infoServices[0][5].'. Le temps de réponse (TRL) était de '.floor(($infoServices[0][6])*1000).' ms et le code HTTP était le '.$infoServices[0][7].'</body></html>';
}
//==========

//=====Création de la boundary
$boundary = "-----=".md5(rand());
//==========

//=====Définition du sujet.
if($erreur!=''){
    $sujet = '[Monitoring Tradmark] Service retabli';
}else{
    $sujet = '[Monitoring Tradmark] Erreur de service';
}
//=========
//no-reply@lenaic.me
//=====Création du header de l'e-mail.
$header = 'From: Monitoring Tridemark<no-reply@lenaic.me>'.$passage_ligne;
$header.= 'Reply-to: Monitoring Tridemark<no-reply@lenaic.me>'.$passage_ligne;
$header.= 'MIME-Version: 1.0'.$passage_ligne;
$header.= 'Content-Type: multipart/alternative;'.$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========

//=====Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========

//=====Envoi de l'e-mail.
$mail=mail($adresse,$sujet,$message,$header);
return $mail;
}
?>
