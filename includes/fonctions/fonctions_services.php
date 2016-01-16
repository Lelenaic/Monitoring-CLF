<?php


function boutonPingService($idService) {
    $html = '<a href="?page=services&ping='.$idService.'">  <i class="fa fa-toggle-right fa-2x"></i> </a>';
    return $html;
}


function statutServices($etat,$id) {
    if ($etat == 1) {
        $html = '<a href="?page=services&activate='.$id.'" class="label label-success">Oui</a>';
    } else {
        $html = '<a href="?page=services&activate='.$id.'" class="label label-danger">Non</a>';
    }
    return $html;
}

function boutonModifierService($idService) {
    $html = '<button type="button" style="background:none; border:0px;" data-toggle="modal" data-target="#modif' . $idService . '"class="fa fa-edit fa-2x"> </button>';
    return $html;
}
function boutonSupprimerService($idService) {
   $html =' <button type="button" style="background:none; border:0px;" data-toggle="modal" data-target="#suppr' . $idService . '"class="fa fa-trash fa-2x"></button>';
    return $html;
}



function modalModifierService($idService) {
    $html = '
<div class="modal fade" id="modif'.$idService.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modif">Modification Service</h4>
      </div>
      <div class="modal-body">';
    $html.=formulaireModifierService($idService);
      $html.='</div>
      
    </div>
  </div>
</div>';
    return $html;
}

function modalSupprimerService($idService){
    $html = '<div class="modal fade" id="suppr'.$idService.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="suppr">Supprimer Service</h4>
      </div>
      <div class="modal-body">';
        
        $html.=formulaireSupprimerService($idService);
        $html.='</div>
      
        </div>
      </div>
    </div>';
   return $html;
}


function formulaireSupprimerService($idService){
    
    $ligneModif = Connexion::query('SELECT * FROM services WHERE id ='.$idService);
    if($ligneModif[0][8]==1){
            $boutton=1;
        }
        if($ligneModif[0][8]==0){
            $boutton=0;
        }
        
        
    $html=' <form name ="formulaire" action=".?page=services" method="POST">
    <p>
    
    <input type="hidden" name="idServicesSuppr" value="'.$ligneModif[0][0].'" />
    <label style="margin-left:30px;">Pseudo :  '.nomPseudo($ligneModif[0][1]).'</label>';    
    
        
    $html.='</select><br/>
    <label style="margin-left:30px;">Nom du service :  '. $ligneModif[0][2] .' </label> <br/>
    <label style="margin-left:30px;">URL :  '. $ligneModif[0][3] .' </label><br/>
    <label style="margin-left:30px;">Port : '. $ligneModif[0][4] .'  </label><br/>
    <label style="margin-left:30px;">Texte important:  '. $ligneModif[0][5] .' </label><br/>
    <label style="margin-left:30px;">Adresse mail : '. $ligneModif[0][6] .' </label><br/>
    <label style="margin-left:30px;">Téléphone :  '. $ligneModif[0][7] .' </label> <br/>
    <label style="margin-left:30px;"> TRL :  '. $ligneModif[0][9] .'  ms  </label> <br/>
    <label style="margin-left:30px;">Fréquence de test :   '. $ligneModif[0][10] .'  minute(s) </label> <br/>
    <label style="margin-left:30px;">Suivi : '.statutServices($boutton,$ligneModif[0][0]).'  </label> <br/>
    
    
    </p> 
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Supprimer</button>
      </div>
   </form>';
    return $html;    
}




function formulaireModifierService($idService){
        $ligneModif = Connexion::query('SELECT id,utilisateurs_id,nom,url,port,texte,mail,tel,monitore,trl,frequence FROM services WHERE id ='.$idService);
        if($ligneModif[0][8]==1){
            $bouttonOui= 'checked';
            $bouttonNon='';
        }
        if($ligneModif[0][8]==0){
            $bouttonOui='';
            $bouttonNon='checked';
        }
        
    $html=' <form name ="formulaire" action=".?page=services" method="POST">
    <p>
    
    <input type="hidden" name="idServices" value="'.$ligneModif[0][0].'" />
    <label style="margin-left:30px;">Pseudo : </label>
    <select class="form-control" name="pseudo">';
        
        
        $tableauPseudo = pseudo();
        
         $html.= '<option value="'.$ligneModif[0][1].'">'.nomPseudo($ligneModif[0][1]).'</option>';
        for ($i = 0; $i < sizeof($tableauPseudo); $i++)
	{
            if($tableauPseudo[$i][0]!=$ligneModif[0][1]){
                    $html.= '<option value="'.$tableauPseudo[$i][0].'">'.$tableauPseudo[$i][1].'</option>';
            }
	}
        
    $html.='</select><br/>
    <label style="margin-left:30px;">Nom du service : </label> 
              <input class="form-control" type="text" name="nomService"placeholder="Nom du service " value="'. $ligneModif[0][2] .'" required ><br/>
    <label style="margin-left:30px;">URL : </label>
              <input class="form-control" type="text" name="urledit" placeholder="URL " value="'. $ligneModif[0][3] .'"required ><br/>
    <label style="margin-left:30px;">Port : </label>
              <input class="form-control" type="number" name="port" placeholder="Port" value="'. $ligneModif[0][4] .'" required ><br/>
    <label style="margin-left:30px;">Texte important: </label>
              <input class="form-control" type="text" name="texte" placeholder="Texte important " value="'. $ligneModif[0][5] .'" required ><br/>
    <label style="margin-left:30px;">Adresse mail : </label>
              <input class="form-control" type="email" name="mail" placeholder="Adresse mail " value="'. $ligneModif[0][6] .'" required><br/>
    <label style="margin-left:30px;">Téléphone : </label> 
    <input class="form-control" type="text" name="tel" placeholder="Téléphone" value="'. $ligneModif[0][7] .'" required ><br/>
    <label style="margin-left:30px;"> TRL : (ms) </label> 
            <input class="form-control" type="decimal" name="trl" placeholder="TRL" value="'. $ligneModif[0][9] .'" required ><br/>
    <label style="margin-left:30px;">Fréquence de test : (minutes) </label> 
    <input class="form-control" type="decimal" name="frequence" placeholder="Fréquence" value="'. $ligneModif[0][10] .'" required ><br/>
    <label style="margin-left:30px;">Suivi : </label> 
        <div class="form-group"  style="margin-left:50px;">
            <div class="radio"><label><input type= "radio" name="monitore" value="1"  '.$bouttonOui.'> oui<br/></div></label>
            <div class="radio"><label><input type= "radio" name="monitore" value="0" '.$bouttonNon.'> non<br/></div></label>
        </div>
    
    </p> 
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Modifier</button>
      </div>
   </form>';
    return $html;
}

function verifListe($url){
    $clientId=$_SESSION['id'];
    $liste=Connexion::query('select client_id,url,actif,domaine where');
    if ($liste[0]) {
        
    }
}

function verifSites($url){
    $clientId=$_SESSION['id'];
    $domaines=Connexion::query('select url,actif,domaine from sites where client_id='.$clientId.' or isnull(client_id)');
    foreach ($domaines as $ligne){
        if ($ligne[2]==1 and $ligne[1]==0){
            $parseDomaine=parse_url($ligne[0]);
            if (strpos($url, $parseDomaine['host'])==false) {
                $return=false; //si l'url du client est valide
            }else{
                $return=true;
                break;
            }
        }elseif ($ligne[1]==0){
            if ($ligne[0]==$url) {
                $return=true;
                break;
            }else{
                $return=false;
            }
        }else{
            $return=false;
        }
    }
    return $return;
}

function activer($id){
    $monitore=Connexion::query('select monitore from services where id='.$id);
    $monitore=1-$monitore[0][0];
    $exec=Connexion::exec ('update services set monitore='.$monitore.' where id='.$id);
    if (!$exec) {
        logs('activation du service n°'.$id,'echec');
    }else{
        logs('activation du service n°'.$id,'reussi');
    }
    echo '<META http-equiv="refresh" content="0; URL=?page=services&activationOk">';
}