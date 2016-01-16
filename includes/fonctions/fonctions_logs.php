<?php

function verifTexte($etat){
    if ($etat==1){
        $html='<span class="label label-info">Trouvé</span>';
    }else{
        $html='<span class="label label-warning">Absent</span>';
    }
    return $html;
}

function statut($id){
    $statut=Connexion::query('select erreur from tests where id='.$id);
    if ($statut[0][0]!=0) {
        $html='<span class="label label-danger">Échec</span>';
    }else{
        $html='<span class="label label-success">Réussi</span>';
    }
    return $html;
}

function NomServices($idService){
    $nom = Connexion::query("select nom from services where id = $idService  ");
    return $nom[0][0];
}

function boutonSupprimerlogs() {
    $html = '<button type="button"   class="btn btn-primary btn-lg" data-toggle="modal" data-target="#logs" style="margin:0px 0px 15px 50px;">Archiver Logs </button>';
    return $html;
}

function modalSupprimerLogs() {
    $html = '
<div class="modal fade" id="logs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modif">Archivage des Logs</h4>
      </div>
      <div class="modal-body">';
    
    
    
    $html.=formulaireSupprimerLogs();
    
    
    
      $html.='</div>
      
    </div>
  </div>
</div>';
    return $html;
}





function formulaireSupprimerLogs(){
    
    $nomService = Connexion::query("SELECT id,nom FROM services");
        
    $html=' <form name ="formulaire" action=".?page=logs" method="POST">
    <p>
    <label style="margin-left:30px;">Nom de votre service : </label>
    <select class="form-control" name="nomService">';
    for ($i = 0; $i < sizeof($nomService); $i++)
	{
            $html.= '<option value="'.$nomService[$i][0].'">'.$nomService[$i][1].'</option>';
	}
   $html.='</select>
       <div class="form-group">
           <label style="margin-left:30px;">Combien de jours voulez-vous archiver ? </label>
           <input class="form-control" type="number" name="jours" placeholder="Jours de Suppression "required >
           </div>
           <label style="margin-left:30px;">Logs à Archiver : </label> 
           <div class="form-group"  style="margin-left:50px;">
            <div class="checkbox"><label><input type= "checkbox" name="erreur0" value="0" / > Reussi</div></label>
            <div class="checkbox"><label><input type= "checkbox" name="erreur1" value="1" /> Echec</div></label>
        </div>
           </p> 
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Archiver</button>
      </div>
   </form>';
    return $html;    
}


function validationSupprimerLogs(){
    $nbjours = $_POST['jours'];
    $idService = $_POST['nomService'];
   if (isset($_POST['erreur0'])){
    $erreur0 = $_POST['erreur0'];
    }
    else{
      $erreur0 =2;  
    }
   if (isset($_POST['erreur1'])){
    $erreur1 = $_POST['erreur1'];
    }
   else{
      $erreur1 =2;  
    }
    ;
    for($i=0;$i<$nbjours;$i++){
        
        $date ='select min(date) from tests
          WHERE service_id = '.$idService.'
                        And (erreur = '.$erreur1.'
                        OR erreur = '.$erreur0.')';
   $dateMin=Connexion::query($date);
   $requete='INSERT INTO archivagesTest(id,service_id,date,heure,trl,etat,codeHttp,erreur)
			SELECT id,service_id,date,heure,trl,etat,codeHttp,erreur
                        FROM tests
                        WHERE service_id = '.$idService.'
                        AND date = "'.$dateMin[0][0].'"
                        And ( erreur = '.$erreur1.'
                        OR erreur = '.$erreur0.')   
           ';
      Connexion::exec($requete);
       $requete='DELETE FROM tests
            WHERE service_id = '.$idService.'
                        AND date = "'.$dateMin[0][0].'"
                        And ( erreur = '.$erreur1.'
                        OR erreur = '.$erreur0.' )  ';
        
        Connexion::exec($requete); 
    }
    echo '<META http-equiv="refresh" content="0; URL=?page=logs&archivageOk">';
}