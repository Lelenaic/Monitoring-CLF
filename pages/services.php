<?php
$permission=0;
require ('../includes/includes.php');
?>

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height:900px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Services
          <small>Affichage des services </small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="?page=index"><i class="fa fa-dashboard"></i> Accueil</a></li>
          <li class="active">Services</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">  
        <?php
        if (isset($_GET['pingOk'])) {
            echo '<div class="callout callout-success"><h4>Effectué !</h4> Le <strong>ping</strong> vient d\'être effectué avec succès !</div>';
        }elseif (isset($_GET['modifOk'])) {
            echo '<div class="callout callout-success"><h4>Effectué !</h4> La <strong>modification</strong> vient d\'être effectuée avec succès !</div>';
        }elseif (isset($_GET['ajoutOk'])) {
            echo '<div class="callout callout-success"><h4>Effectué !</h4> L\'<strong>ajout</strong> vient d\'être effectué avec succès !</div>';
        }elseif (isset($_GET['supprOk'])) {
            echo '<div class="callout callout-success"><h4>Effectué !</h4> La <strong>suppression</strong> vient d\'être effectuée avec succès !</div>';
        }elseif (isset($_GET['activationOk'])) {
            echo '<div class="callout callout-success"><h4>Effectué !</h4> L\'<strong>activation de la surveillance du service</strong> vient d\'être effectuée avec succès !</div>';
        }elseif(isset($_GET['erreurUrl'])){
            echo '<div class="callout callout-danger"><h4>Erreur !</h4> Vous ne pouvez pas surveiller cet URL.<br>Merci de contacter un opérateur de Tridemark si vous pensez que c\'est une erreur.</div>';
        }
        if (isset($_GET['activate'])) {
            activer($_GET['activate']);
        }
        ?>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <?php
                
                $compteur = 0;
                include ('../includes/boutons/boutonAjoutFormulaireServices.php');
                echo quEstCe2();
                ?>

                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover datatable" style="font-size:1em;">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Pseudo</th>
                        <th>Nom du Service</th>
                        <th>Url</th>
                        <th>Port</th>
                        <th>Texte</th>
                        <th>Mail</th>
                        <th>Numéro Téléphone</th>
                        <th>Surveillé ?</th>
                        <th>Trl </th>
                        <th>Fréquence de test</th>
                        <th>Modification</th>
                        <th>Suppression</th>
                        <th>Ping</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($_POST['urlnew'])) {
                      $compteur = 1;
                      $nouveauServices = validationFormulaireAjoutServices();
                    }
                    if (isset($_POST['urledit'])) {
                      $nouveauServices = validationFormulaireModificationServices();
                    }
                    if (isset($_POST['idServicesSuppr'])){
                     $nouveauServices = validationFormulaireSuppressionServices();
                    }
                    $permission=80;
                    if($_SESSION['groupe']<$permission){
                        $tableauServices = Connexion::query('SELECT services.id,utilisateurs_id,nom,url,port,texte,mail,tel,monitore,trl,frequence,statut FROM services,utilisateurs WHERE services.utilisateurs_id=utilisateurs.id AND utilisateurs.id='.$_SESSION['id'].' ORDER BY id');
                    }else{
                        $tableauServices = Connexion::query('SELECT services.id,utilisateurs_id,nom,url,port,texte,mail,tel,monitore,trl,frequence,statut FROM services ORDER BY id');
                    }
                    for ($i = 0; $i < sizeof($tableauServices) - $compteur; $i++) {
                      if ($tableauServices[$i][11]!=1 and $tableauServices[$i][8]==1) {
                        $class=' class="danger"';
                      }elseif($tableauServices[$i][11]==1 and $tableauServices[$i][8]==1){
                        $class=' class="success"';
                      }else{
                        $class=' class="info"';
                      }
                      echo '<tr'.$class.'>';
                      for($j=0;$j<11;$j++){
                        if ($j == 8) {
                          echo '<td>', statutServices($tableauServices[$i][$j],$tableauServices[$i][0]), '</td>';
                        }elseif ($j == 1) {
                          echo '<td>', nomPseudo($tableauServices[$i][1]), '</td>';
                        }elseif ($j == 10) {
                          echo '<td>', $tableauServices[$i][$j], ' minute(s)</td>';
                        }elseif ($j == 9) {
                          echo '<td>', $tableauServices[$i][$j], ' ms</td>';
                        }else {
                          echo '<td>', $tableauServices[$i][$j], '</td>';
                        }
                      }
                      echo '<td>';
                      echo boutonModifierService($tableauServices[$i][0]);
                      echo '</td>';
                      echo '<td>';
                      echo boutonSupprimerService($tableauServices[$i][0]);
                      echo '</td>';
                      echo '<td>';
                      echo boutonPingService($tableauServices[$i][0]);
                      echo '</td>';
                      echo '</tr>';
                    }
                    echo '</tbody></table>';
                    for ($i = 0; $i < sizeof($tableauServices); $i++) {
                      echo modalModifierService($tableauServices[$i][0])   ;
                      echo modalSupprimerService($tableauServices[$i][0])   ;
                    }
                    if (isset($_GET['ping'])) {
                      $serviceId=$_GET['ping'];
                      include ('../ping/ping.php');
                    }
                    ?>
                    </tbody>
                  </table>
                <!-- /.box-body -->
                </div>
            <!-- /.box -->
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- modal -->
    <div class="modal fade" id="services" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title" id="myModalLabel">Informations</h3>
                </div>
                <div class="modal-body">
                    <h4>Significations</h4><br>
                    <p>
                       <strong>L'URL</strong> doit impérativement commencé par HTTP(s) pour qu'il soit valide.<br/> 
                       <strong>Le port</strong> est 80 pour les sites normaux (HTTP) et 443 pour les sites sécurisés (HTTPS).<br/>
                       <strong>Le texte</strong> correspond à un ou plusieurs mots que vous trouvez importants à tester.<br/>
                       <strong>Le mail</strong> et <strong>le numéro de téléphone</strong> servent à vous informer en cas de défaillance de vos services.<br/>
                       <strong>Le TRL</strong> est le temps de réponse maximum du service avant qu'il ne soit considéré comme défaillant.<br/>
                       <strong>La fréquence de test</strong> correspond à temps entre deux tests du service.
                    </p>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->
    
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
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
