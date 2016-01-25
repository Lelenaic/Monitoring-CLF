<?php
include ('../includes/class_connexion.php');
include ('../includes/fonctions/fonctions.php');

session_start();
$connexion=false;
$messagePseudo='Pseudo';
$messageMdp='Mot de passe';
if (isset($_POST['connexion']) AND $_POST['connexion'] != 'Connexion'){
    $pseudo=$_POST['pseudo'];
    $pass=trim($_POST['pass']);
    $pseudoVisiteur=Connexion::query('SELECT COUNT(id) FROM utilisateurs WHERE pseudo="'.$pseudo.'"');
    if($pseudoVisiteur[0][0] != 0){
        $infoVisiteur=Connexion::query('SELECT id,pseudo,mdp,groupes_id FROM utilisateurs WHERE pseudo="'.$pseudo.'"');
            if(password_verify($pass,$infoVisiteur[0][2])){
                $connexion=true;
                $_SESSION['id']=$infoVisiteur[0][0];
                $_SESSION['pseudo']=$infoVisiteur[0][1];
                $_SESSION['groupe']=$infoVisiteur[0][3];
                logs('connexion','reussi');
                header ('Location: ?page=index');
                die;
            }else{
                $messageMdp='Mot de passe invalide';
                $connexion=false;
                logs('connexion','echec');
            }
    }else{
        $messagePseudo='Pseudo invalide';
	$connexion=false;
        logs('connexion','echec');
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Monitoring-CLF | Connexion</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="?page=index"><b>Monitoring</b> CLF</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Ouvrir une session</p>
        <form action="?page=login" method="post">
          <div class="form-group has-feedback">
            <input type="texte" class="form-control" placeholder="<?php echo $messagePseudo; ?>" name="pseudo">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="<?php echo $messageMdp; ?>" name="pass">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat" name="connexion">Connexion</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
