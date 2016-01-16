<?php
$permission = 80;
require ('../includes/includes.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height:900px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gestions utilisateurs
            <small>Ajout/Modification/Suppression</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?page=index"><i class="fa fa-dashboard"></i> Accueil</a></li>
            <li class="active">Gestions utilisateurs</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">  
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <?php echo '<form action="" method="post"><input type="submit" value="Ajouter un utilisateur" name="ajouter" class="btn btn-block btn-primary btn-lg" style="width:200px;margin:20px;"/><input type="hidden" name="groupeModif" value="-1"/></form>'; ?>
                    <table id="#example1" class="table table-bordered table-striped datatable">
                        <thead>
                            <tr style="height:20px;">
                                <th style="width:50px;">#</th>
                                <th>Pseudo</th>
                                <th>Mot de passe</th>
                                <th>Groupe</th>
                                <th style="width:150px;">Modifier</th>
                                <th style="width:150px;">Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $listeUtilisateurs = Connexion::query('SELECT utilisateurs.id,pseudo,mdp,groupes.libelle FROM utilisateurs,groupes WHERE utilisateurs.groupes_id=groupes.id');
                            $listeGroupes = Connexion::query('SELECT groupes.id,libelle FROM groupes');
                            $tailleListe = sizeof($listeUtilisateurs);
                            $tailleGroupes = sizeof($listeGroupes);
                            if (isset($_POST['modifierForm']) OR isset($_POST['ajouter'])) {
                                $groupes = '<select name="uGroupe">';
                                for ($i = 0; $i < $tailleGroupes; $i++) {
                                    if ($_POST['groupeModif'] == $listeGroupes[$i][1]) {
                                        $groupes.='<option value="' . $listeGroupes[$i][0] . '" selected>' . $listeGroupes[$i][1] . '</option>';
                                    } else {
                                        $groupes.='<option value="' . $listeGroupes[$i][0] . '">' . $listeGroupes[$i][1] . '</option>';
                                    }
                                }
                                $groupes.='</select>';
                            }
                            for ($i = 0; $i < $tailleListe; $i++) {
                                if (isset($_POST['modifierForm']) AND $listeUtilisateurs[$i][0] == $_POST['uId']) {
                                    echo '<form action="?page=traitementUtilisateurs" method="post">
                            <tr style="height:20px;">
                                <td><input hidden name="uId" value="' . $listeUtilisateurs[$i][0] . '"/>' . $listeUtilisateurs[$i][0] . '</td>
                                <td><input name="uPseudo" value="' . $listeUtilisateurs[$i][1] . '"/></td>
                                <td><input name="uMdp" type="password"/></td>
                                <td>' . $groupes . '</td>
                                <td><button type="submit" name="modifier" class="btn btn-app"><i class="fa fa-check"></i> Valider</button></td>
                                <td><button type="submit" name="annuler" class="btn btn-app"><i class="fa fa-remove"></i> Annuler</button></td>
                              </tr>
                              </form>';
                                } elseif (isset($_POST['supprimerForm']) AND $listeUtilisateurs[$i][0] == $_POST['uId']) {
                                    echo '<form action="?page=traitementUtilisateurs" method="post">
                            <tr style="height:20px;">
                                <td><input hidden name="uId" value="' . $listeUtilisateurs[$i][0] . '"/>' . $listeUtilisateurs[$i][0] . '</td>
                                <td>' . $listeUtilisateurs[$i][1] . '</td>
                                <td>●●●●●</td>
                                <td>' . $listeUtilisateurs[$i][3] . '</td>
                                <td><button type="submit" name="supprimer" class="btn btn-app"><i class="fa fa-check"></i> Valider</button></td>
                                <td><button type="submit" name="annuler" class="btn btn-app"><i class="fa fa-remove"></i> Annuler</button></td>
                              </tr>
                              </form>';
                                } else {
                                    echo '<tr style="height:20px;">
                          <td>' . $listeUtilisateurs[$i][0] . '</td>
                          <td>' . $listeUtilisateurs[$i][1] . '</td>
                          <td>●●●●●</td>
                          <td>' . $listeUtilisateurs[$i][3] . '</td>
                          <td><form action="" method="post"><input hidden name="uId" value="' . $listeUtilisateurs[$i][0] . '"/><button type="submit" name="modifierForm" class="btn btn-app"><input type="hidden" name="groupeModif" value="' . $listeUtilisateurs[$i][3] . '"/><i class="fa fa-edit"></i> Modifier</button></form></td>
                          <td><form action="" method="post"><input hidden name="uId" value="' . $listeUtilisateurs[$i][0] . '"/><button type="submit" name="supprimerForm" class="btn btn-app"><i class="fa fa-trash"></i> Supprimer</button></form></td>
                        </tr>';
                                }
                            }
                            if (isset($_POST['ajouter']) AND ! isset($_POST['annuler'])) {
                                echo '<tr>
                            <form action="?page=traitementUtilisateurs" method="post">
                            <td></td>
                            <td><input name="uPseudo"/></td>
                            <td><input name="uMdp" type="password"/></td>
                            <td>' . $groupes . '</td>
                            <td><button type="submit" name="valider" class="btn btn-app"><i class="fa fa-check"></i> Valider</button></td>
                            <td><button type="submit" name="annuler" class="btn btn-app"><i class="fa fa-remove"></i> Annuler</button></td>
                            </form>
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

<?php footer() ?>



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
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
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


<!--<script>
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
</script>-->

</body>
</html>
