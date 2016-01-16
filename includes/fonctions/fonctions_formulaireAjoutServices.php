

   <form name ="formulaire" action=".?page=services" method="POST">

    <p>
    <label style="margin-left:30px;">Pseudo : </label>
    <select class="form-control" name="pseudo">
        <?php 
        
        $tableauPseudo = pseudo();
        
        for ($i = 0; $i < sizeof($tableauPseudo); $i++)
	{
		echo '<option value="'.$tableauPseudo[$i][0].'">'.$tableauPseudo[$i][1].'</option>';
	}
        ?>
    </select><br/>
    <label style="margin-left:30px;">Nom du service : </label> 
    <input class="form-control" type="text" name="nomService"placeholder="Nom du service" required ><br/>
    <label style="margin-left:30px;">URL : </label>
    <input class="form-control" type="text" name="urlnew" placeholder="URL"required ><br/>
    <label style="margin-left:30px;">Port : </label>
     <input class="form-control" type="number" name="port" placeholder="Port" required ><br/>
    <label style="margin-left:30px;">Texte important: </label>
    <input class="form-control" type="text" name="texte" placeholder="Texte important" required ><br/>
    <label style="margin-left:30px;">Adresse mail : </label>
    <input class="form-control" type="email" name="mail" placeholder="Adresse mail" required><br/>
    <label style="margin-left:30px;">Téléphone : </label> 
    <input class="form-control" type="text" name="tel" placeholder="Téléphone" required ><br/>
    <label style="margin-left:30px;"> TRL : (ms) </label> 
    <input class="form-control" type="decimal" name="trl" placeholder="TRL" required ><br/>
    <label style="margin-left:30px;">Fréquence de test : (minutes) </label> 
    <input class="form-control" type="decimal" name="frequence" placeholder="Fréquence" required ><br/>
    <label style="margin-left:30px;">Suivi : </label> 
    <div class="form-group"  style="margin-left:50px;">
        <div class="radio"><label><input type="radio" name="monitore" value="1" checked> oui<br/></div></label>
       <div class="radio"><label><input type="radio" name="monitore" value="0"> non<br/></div></label>
    </div>
    </p> 
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </div>
   </form>

                 
                