<?php
$permission=0;
require ('../includes/includes.php');
?>

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height:900px;">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Logs
          <small>Gestion des logs</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="?page=index"><i class="fa fa-dashboard"></i> Accueil</a></li>
          <li class="active">Logs</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">  
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Différents logs et leur état</h3>
          </div>
            <?php
            echo boutonSupprimerlogs();
            echo modalSupprimerLogs();
            if (isset($_POST['jours'])){
                validationSupprimerLogs();
            }
            if (isset($_GET['archivageOk'])) {
                echo '<div class="callout callout-success"><h4>Effectué !</h4> Les logs sélectionnés ont bien été <strong>archivés</strong> avec succès !</div>';
            }
            ?>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover datatable">
              <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom du service</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th width="20%">Temps de réponse (en ms)</th>
                        <th>Texte</th>
                        <th>Statut</th>
                        <th>Code HTTP</th>
                    </tr>
              </thead>
                <tbody>
                    <?php
                    
                    $permission=80;
                    if($_SESSION['groupe']<$permission){
                        $tableau=Connexion::query('select tests.id,service_id,date,heure,tests.trl,etat,codeHttp from tests,services,utilisateurs where tests.service_id=services.id and services.utilisateurs_id=utilisateurs.id and utilisateurs.id='.$_SESSION['id'].' order by 1 desc');
                    }else{
                        $tableau=Connexion::query('select id,service_id,date,heure,trl,etat,codeHttp from tests order by 1 desc');
                    }
                    foreach ($tableau as $ligne){
                        echo '<tr>
                                <td>'.$ligne[0].'</td>
                                <td>'.NomServices($ligne[1]).'</td>
                                <td>'.dateUS2FR($ligne[2]).'</td>
                                <td>'.$ligne[3].'</td>
                                <td>'.number_format($ligne[4]*1000,0,',','').'</td>
                                <td>'.verifTexte($ligne[5]).'</td>
                                <td>'.statut($ligne[0]).'</td>
                                <td>'.$ligne[6].'</td>
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
