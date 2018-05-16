<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="./plugins/iCheck/square/blue.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
<?php
    session_start();

    //Vérifier si une session est déjà ouverte
    if(isset($_SESSION['fullName'])){
        header("location: general.php");
        exit;
    }

    if(isset($_GET['loginError'])){
        echo '<p style="color: red">ERREUR - Les identifiants entrés ne correspondent à aucun utilisateurs</p>'; 
    }

    $keys[] = 'fullName';
    $keys[] = 'email';
    $keys[] = 'password';
    //Vérifier s'il y a des donnée d'enregistrement qui ont été envoyées
    if(isset($_POST)){
        $error = false;
        //récupérer les infos de la requête
        for($i = 0; $i < sizeof($keys); $i++){
            if(isset($_POST[$keys[$i]])){
                $data[$keys[$i]] = $_POST[$keys[$i]];
            }
            else
            {
                $error = true;
            }
        }

        if(!$error){
            //Création de la connexion avec la base de données
            $connection = new PDO('mysql:host=localhost;dbname=testphpadmin', 'root', '');

            //Vérifier si le mail et le nom de l'utilisateur n'est pas déjà enregistré en base de données
            $requete = $connection->prepare("SELECT fullName, email FROM users WHERE fullName = :fullName AND email = :email");
            $requete->bindParam(':fullName', $data['fullName']);
            $requete->bindParam(':email', $data['email']);
            $requete->execute();

            $resultat = $requete->fetch(PDO::FETCH_ASSOC);
            if($resultat['fullName'] == $data['fullName'] || $resultat['email'] == $data['email']){
                echo '<p style="color: red">ERREUR - Le nom ou le mail renseigné est déjà utilisé.</p>'; 
            }
            else
            {
                //Enregistrement dans la base de donnée
                $requete = $connection->prepare('INSERT INTO users VALUES (null, :fullName, :email, :password)');
                $requete->bindParam(':fullName', $data['fullName']);
                $requete->bindParam(':email', $data['email']);
                $requete->bindParam(':password', $data['password']);

                if($requete->execute()){
                    echo '<p style="color: green">SUCCES - l\'utilisateur a bien été enregistré. Vous pouvez vous conecter dès maintenant.</p>';
                }
                else
                {
                    echo '<p style="color: red">ERREUR - l\'enregistrement a échoué !<br/>';
                    echo $requete->errorInfo().'</p>';
                }
            }            
        }
    }
?>

<div class="login-box">
  <div class="login-logo">
    <a href="./index.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <form action="./connect.php" method="POST">
        <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <span class="fa fa-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <span class="fa fa-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" name="remindMe"> Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
      <p class="mb-0">
        <a href="./register.php" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass   : 'iradio_square-blue',
      increaseArea : '20%' // optional
    })
  })
</script>
</body>
</html>
