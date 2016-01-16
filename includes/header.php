<?php $debut=microtime(true); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Monitoring Tridemark</title>
    <link rel="icon" type="image/png" href="../images/favicon.png" />
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
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini" style>
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="?page=index" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>M</b>T</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg" style="font-size:18px;"><b>Monitoring</b>Tridemark <span style="font-size:11px;">v.4</span></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <p class="user-panel" style="color:white;margin-right:20px;font-weight:bold;"><?php
                    $date=date('Y-m-d');
                    $heure=date('H:i:s');
                    echo dateUS2FR($date).'   '.$heure;        
                    ?></p></li>
              <!-- Control Sidebar Toggle Button -->
            </ul>
            <ul class="nav navbar-nav">
              <li><a href="?page=logout"><i class="fa fa-power-off"></i></a></li>
              <!-- Control Sidebar Toggle Button -->
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">   
          <!-- Sidebar user panel -->
            <div class="user-panel" style="padding-bottom:80px">
              <div class="pull-left info" style="left:0px;">
                <p style="font-size:18px;"><?php echo $_SESSION['pseudo'] ?></p>
                <p><?php $nomGroupe=Connexion::query('SELECT libelle FROM groupes WHERE id='.$_SESSION['groupe'].''); echo $nomGroupe[0][0]; ?></p>
                <i class="fa fa-circle text-success"></i> En ligne
              </div>
            </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" >
            <li class="header">Menu</li>
            <?php
            $page=isset($_GET['page']) ? $_GET['page']:'index';
            if($page=='index'){
                echo '<li class="active">
                    <a href="?page=index"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <li><a href="?page=services"><i class="fa fa-file-text-o"></i> <span>Services</span></a></li>
                <li><a href="?page=logs"><i class="fa  fa-hourglass-2"></i> <span>Logs</span></a></li>
                <li><a href="?page=utilisateurs"><i class="fa fa-users"></i> <span>Gestion utilisateurs</span></a></li>
                <li><a href="?page=sites"><i class="fa fa-globe"></i> <span>Gestion des sites</span></a></li>';
            }
            if($page=='services'){
                echo '<li><a href="?page=index"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                <li class="active">
                    <a href="?page=services"><i class="fa fa-file-text-o"></i> <span>Services</span></a>
                </li>
                <li><a href="?page=logs"><i class="fa  fa-hourglass-2"></i> <span>Logs</span></a></li>
                <li><a href="?page=utilisateurs"><i class="fa fa-users"></i> <span>Gestion utilisateurs</span></a></li>
                <li><a href="?page=sites"><i class="fa fa-globe"></i> <span>Gestion des sites</span></a></li>';
            }
            if($page=='logs'){
                echo '<li><a href="?page=index"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                <li><a href="?page=services"><i class="fa fa-file-text-o"></i> <span>Services</span></a></li>    
                <li class="active">
                    <a href="?page=logs"><i class="fa fa-hourglass-2"></i> <span>Logs</span></a>
                </li>
                <li><a href="?page=utilisateurs"><i class="fa fa-users"></i> <span>Gestion utilisateurs</span></a></li>
                <li><a href="?page=sites"><i class="fa fa-globe"></i> <span>Gestion des sites</span></a></li>';
            }
            if($page=='utilisateurs'){
                echo '<li><a href="?page=index"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                <li><a href="?page=services"><i class="fa fa-file-text-o"></i> <span>Services</span></a></li>
                <li><a href="?page=logs"><i class="fa  fa-hourglass-2"></i> <span>Logs</span></a></li>
                <li class="active">
                    <a href="?page=utilisateurs"><i class="fa fa-users"></i> <span>Gestion utilisateurs</span></a>
                </li>
                <li><a href="?page=sites"><i class="fa fa-globe"></i> <span>Gestion des sites</span></a></li>';
            }
            if($page=='sites'){
                echo '<li><a href="?page=index"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                <li><a href="?page=services"><i class="fa fa-file-text-o"></i> <span>Services</span></a></li>
                <li><a href="?page=logs"><i class="fa  fa-hourglass-2"></i> <span>Logs</span></a></li>
                <li><a href="?page=utilisateurs"><i class="fa fa-users"></i> <span>Gestion utilisateurs</span></a></li>            
                <li class="active">
                    <a href="?page=sites"><i class="fa fa-globe"></i> <span>Gestion des sites</span></a>
                </li>';
            }
            if($page=='accesRefuse'){
                echo '<li><a href="?page=index"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                <li><a href="?page=services"><i class="fa fa-file-text-o"></i> <span>Services</span></a></li>
                <li><a href="?page=logs"><i class="fa  fa-hourglass-2"></i> <span>Logs</span></a></li>
                <li><a href="?page=utilisateurs"><i class="fa fa-users"></i> <span>Gestion utilisateurs</span></a></li>            
                <li><a href="?page=sites"><i class="fa fa-globe"></i> <span>Gestion des sites</span></a></li>';
            }
            
            ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
