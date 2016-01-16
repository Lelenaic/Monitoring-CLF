<?php
    $permission=80;
    include ('../includes/includes.php');
?>

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height:900px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Sites
          <small>Gestion des sites</small>
        </h1><br>
          <?php
        if (isset($_GET['supprOk'])) {
            echo '<div class="callout callout-success"><h4>Effectué !</h4> La <strong>suppression</strong> vient d\'être effectuée avec succès !</div>';
        }elseif(isset($_GET['modifOk'])){
            echo '<div class="callout callout-success"><h4>Effectué !</h4> La <strong>modification</strong> vient d\'être effectuée avec succès !</div>';
        }elseif(isset($_GET['ajoutOk'])){
            echo '<div class="callout callout-success"><h4>Effectué !</h4> L\'<strong>ajout</strong> vient d\'être effectué avec succès !</div>';
        }
        ?>
        <ol class="breadcrumb">
          <li><a href="?page=index"><i class="fa fa-dashboard"></i> Accueil</a></li>
          <li class="active">Gestion des sites</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">  
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Gestion des sites autorisés et refusés</h3>
          </div>
            
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
              <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ajoutSite" style="margin:0px 0px 15px 50px;">Ajouter un site</button>
              <?= quEstCe(); ?>
            <table class="table table-hover datatable">
              <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ajouté par</th>
                        <th>S'applique à</th>
                        <th>URL</th>
                        <th>Liste</th>
                        <th>Restriction par domaine</th>
                        <th>Modification</th>
                        <th>Suppression</th>
                    </tr>
              </thead>
                <tbody>
                    <?php
                    $tableau=Connexion::query('select id,client_id,user_id,url,actif,domaine from sites order by 1');
                    foreach ($tableau as $ligne){
                        echo '<tr>
                                <td>'.$ligne[0].'</td>
                                <td>'.user($ligne[2]).'</td>
                                <td>'.user($ligne[1]).'</td>
                                <td>'.$ligne[3].'</td>';
                                echo '<td>'.label($ligne[4]).'</td>';
                                echo '<td>'.domaine($ligne[5]).'</td>';
                                echo '<td><button type="button" style="background:none; border:0px;" class="fa fa-edit fa-2x" data-toggle="modal" data-target="#modifSite'.$ligne[0].'"></button></td>
                                <td><button type="button" style="background:none; border:0px;" class="fa fa-trash-o fa-2x" data-toggle="modal" data-target="#supprSite'.$ligne[0].'"></button></td>
                                </tr>';
                    }
                    ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <!-- modals -->
    <!-- Button trigger modal -->


<!-- Modals -->

<div class="modal fade" id="ajoutSite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Ajout d'un site</h4>
    </div>
    <div class="modal-body">
        <form action="?page=traitementSites" method="POST">
            <input type="text" name="ajout" hidden />
            <div class="form-group">
                <label>ID :</label>
                <input class="form-control" type="text" value="Automatique" disabled />
            </div>
            <div class="form-group">
                <label>Ajouté par :</label>
                <input class="form-control" type="text" value="<?= pseudoConnecte() ?>" disabled />
            </div>
            <div class="form-group">
                <label>S'applique à :</label>
                <select class="form-control" name="user" required><?= utilisateurs(null) ?></select>
            </div>
            <div class="form-group">
                <label>URL :</label>
                <input class="form-control" type="text" name="url" required />
            </div>
            <div class="form-group">
                <label>Liste :</label><br>
                <div class="radio"><label><input type="radio" name="liste" value="1" required /> Whitelist</label></div>
                <div class="radio"><label><input type="radio" name="liste" value="0" required /> Blacklist</label></div>
            </div>
            <div class="form-group">
                <label>Restriction par domaine :</label>
                <div class="radio"><label><input type="radio" name="domaine" value="1" required /> Oui</label></div>
                <div class="radio"><label><input type="radio" name="domaine" value="0" required /> Non</label></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
              <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="restriction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title" id="myModalLabel">Restriction par domaine</h3>
        </div>
        <div class="modal-body">
            <h4>Comment cela fonctionne ?</h4><br>
            <p>La restriction par domaine utilise uniquement le domaine pour restreindre l'utilisateur.<br>
                Par exemple, le lien <strong>https://google.fr/test</strong> a pour domaine <strong>google.fr</strong>.<br>
                Par conséquent, si la restriction par domaine est sélectionnée, tous les liens ayant pour domaine <strong>google.fr</strong> (sous-domaines compris) seront refusés aux utilisateurs.</p>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
        </div>
        </div>
      </div>
    </div>
</div>

<?php
foreach ($tableau as $ligne){
    $admin=user($ligne[2]);
    $user=user($ligne[1]);
    echo '<div class="modal fade" id="modifSite'.$ligne[0].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Edition du site n°'.$ligne[0].'</h4>
                </div>
                <div class="modal-body">
                    <form action="?page=traitementSites" method="POST">
                        <input type="text" name="id" value="'.$ligne[0].'" hidden />
                        <div class="form-group">
                            <label>ID :</label>
                            <input class="form-control" type="text" value="'.$ligne[0].'" disabled />
                        </div>
                        <div class="form-group">
                            <label>Ajouté par :</label>
                            <input class="form-control" type="text" value="'.$admin.'" disabled />
                        </div>
                        <div class="form-group">
                            <label>S\'applique à :</label>
                            <select class="form-control" name="user">'.utilisateurs($ligne[1]).'</select>
                        </div>
                        <div class="form-group">
                            <label>URL :</label>
                            <input class="form-control" type="text" name="url" value='.$ligne[3].' />
                        </div>
                        <div class="form-group">
                            <label>Liste :</label><br>'
                            .liste($ligne[0]).
                        '</div>
                        <div class="form-group">
                            <label>Restriction par domaine :</label>'
                            .domaineRestriction($ligne[0]).
                        '</div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                          <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>';
    echo '<div class="modal fade" id="supprSite'.$ligne[0].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Supprimer le site n° '.$ligne[0].'</h4>
                </div>
                <div class="modal-body">
                  <label style="margin-left:30px;">ID : '.$ligne[0].'</label><br>
                  <label style="margin-left:30px;">Ajouté par : '.user($ligne[2]).'</label><br>
                  <label style="margin-left:30px;">S\'applique à : '.user($ligne[1]).'</label><br>
                  <label style="margin-left:30px;">URL : <a href="'.$ligne[3].'" target="_blank">'.$ligne[3].'</a></label><br>
                  <label style="margin-left:30px;">Liste : '.label($ligne[4]).'</label><br>
                  <label style="margin-left:30px;">Restriction par domaine : '.domaine($ligne[5]).'</label><br>
                </div>
                <div class="modal-footer">
                  <form action="?page=traitementSites" method="POST">
                    <input hidden name="supprId" value="'.$ligne[0].'" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Supprimer</button>
                  </form>
                </div>
              </div>
            </div>
          </div>';
}
?>
      <!-- ./Modals -->
      
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>

    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script>
    $(document).ready(function () {
        $(".datatable").DataTable({
             "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.10/i18n/French.json"
            }
        });
        $('table').each(function(){
            var thead = $(this).find('thead').html();            
            $(this).append('<tfoot>'+thead+'</tfoot>');
        });
    });
    </script>
    
  </body>
  <?php footer() ?>
</html>
