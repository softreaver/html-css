<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./plugins/datatables/dataTables.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <?php
      //Création de la connexion à la base de données
      $connection = new PDO('mysql:host=localhost;dbname=testphpadmin', 'root', '');

      //Si on arrive sur la page suite au submit du forumlaire, je dois procéder aux vérifications des données
      if(!isset($_GET['display']))
      {
        $check_form['url'] = false;
        $check_form['pseudo'] = false;
        $check_form['password'] = false;
        $check_form['password-check'] = false;
        $check_form['cms'] = false;
        $check_form['statut'] = false;

        foreach($_POST as $key => $value){
            if($value !== 'default' && $value !== ''){
                $line[$key] = $value;
                $check_form[$key] = true;
            }
        }

        //On vérifie que tous les champs obligatoires du formulaire ont bien été remplis
        foreach($check_form as $key => $value){
            if($check_form[$key] == false){
                if(!isset($error))
                    $error = '?';
                else
                    $error .= "&";

                $error .= $key;
            }
        }

        //on vérifie que les deux passwords sont identique
        if($line['password'] !== $line['password-check']){
            if(isset($error)){
                $error .= '&password-different';
            }else{
                $error = '?password-different';
            }
        }

        if(isset($error)){
            //s'il y a au moins un champ obligatoire non rempli, alors renvoyer vers le formulaire
            header("location: general.php" . $error);
            exit;
        }else{
            //Sinon j'enregistre les données dans la base de données
            $requete = $connection->prepare("INSERT INTO websites VALUES (null, :url, :pseudo, :password, :cms, :statut, :description)");
            $requete->bindParam(':url', $line['url']);
            $requete->bindParam(':pseudo', $line['pseudo']);
            $requete->bindParam(':password', $line['password']);
            $requete->bindParam(':cms', $line['cms']);
            $requete->bindParam(':statut', $line['statut']);
            $requete->bindParam(':description', $line['messageArea']);

            if(!$requete->execute())
            {//Si la requête à échouée, récupérer le type d'erreur
              $errorDB = $requete->errorInfo()[2];
            }
        }
      }

      //Récupérer toute les données présentes en base de donnée
      $requete = $connection->prepare("SELECT url, pseudo, password, cms, statut, description FROM websites ORDER BY ID DESC");
      if($requete->execute())
      {//Ajouter toute la liste dans data
        $data = $requete->fetchAll(PDO::FETCH_ASSOC);
      }
      else
      {//Si la requête à échouée, récupérer le type d'erreur
        $errorDB = $requete->errorInfo()[2];
      }
    ?>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments-o"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fa fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

    <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="./index.html" class="nav-link active">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                Tableau de bord
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="./general.php" class="nav-link">
              <i class="nav-icon fa fa-edit"></i>
              <p>
                Ajouter un site
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="./data.php?display" class="nav-link">
              <i class="nav-icon fa fa-table"></i>
              <p>
                Liste des sites
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="./profile.html" class="nav-link">
              <i class="nav-icon fa fa-book"></i>
              <p>
                Profil
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./connect.php?disconnect" class="nav-link">
              <i class="nav-icon fa sign-out-alt"></i>
              <p>
                Se déconnecter
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Tables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Data Tables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Hover Data Table</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

            <?php if(!isset($_GET['display'])){ ?>
            <p class="col-xs-12">
              <?php 
                if(isset($errorDB))
                {//Une erreur est survenu lors de la comminication  avec la base de données
                  echo '<span style="color: red">ERREUR - La communication avec la base de données ne s\'est pas faite correctement!';
                  echo '<br/>';
                  echo $errorDB . '</span>';
                }
                else
                {// L'a jout des nouvelles données s'est bien passé
                  echo '<span style="color: green">Le site à bien été ajouté à la liste</span>';
                }
              ?>
            </p><?php
            }?>
            
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Adresse du site</th>
                        <th>Identifiant</th>
                        <th>Mot de passe</th>
                        <th>CMS</th>
                        <th>Statut</th>
                        <th>Déscription</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        //J'affiche les données ous forme de tableau
                        foreach($data as $one_line){?>                            
                            <tr>
                            <?php foreach($one_line as $key => $value){
                                if($key != 'password-check'){?>
                                <td>
                                    <?php echo $value; ?>
                                </td>
                                <?php }
                                }?>
                            </tr>
                        <?php }?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Adresse du site</th>
                        <th>Identifiant</th>
                        <th>Mot de passe</th>
                        <th>CMS</th>
                        <th>Statut</th>
                        <th>Déscription</th>
                    </tr>
                    </tfoot>
                </table>
                
            </div> <!-- /.card-body -->
          </div> <!-- /.card -->
        </div> <!-- /.col -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
  </div> <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.0-alpha
    </div>
    <strong>Copyright &copy; 2014-2018 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- SlimScroll -->
<script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
