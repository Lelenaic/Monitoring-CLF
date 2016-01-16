<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="margin:0px 0px 15px 50px;">Ajouter un service </button>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nouveau Service</h4>
      </div>
      <div class="modal-body">     
          <?php   
         include ('../includes/fonctions/fonctions_formulaireAjoutServices.php');
          ?>
      </div>
    </div>
  </div>
</div>



