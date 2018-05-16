<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Registration Page</title>
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
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index2.html"><b>Admin</b>LTE</a>
  </div>

  <div id="mainContent" class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="index.php" method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Full name" name="fullName">
          <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <span class="fa fa-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input id="pass1" type="password" class="form-control" placeholder="Password" name="password">
          <span class="fa fa-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input id="pass2" type="password" class="form-control" placeholder="Retype password">
          <span class="fa fa-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="login.html" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

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
  

  var buttonElt = document.getElementsByTagName("button");
  buttonElt[0].addEventListener("click", function(e){
      //Supprimer les éventuels message d'erreur déjà présents
      if(document.getElementById("inputError")){
        document.getElementById("mainContent").removeChild(document.getElementById("inputError"));
      }
      if(document.getElementById("passwordError")){
        document.getElementById("mainContent").removeChild(document.getElementById("passwordError"));
      }
      if(document.getElementById("checkError")){
        document.getElementById("mainContent").removeChild(document.getElementById("checkError"));
      }
      var inputElt = document.getElementsByTagName("input");

      for(var i = 0; i < inputElt.length; i++){
        inputElt[i].classList.remove("error");
      }

      //Vérifier si tous les champs on bien été remplis
      var inputError = false;

      for(var i = 0; i < inputElt.length; i++){
        if(inputElt[i].value.trim().length == 0){
              inputError = true;
              inputElt[i].classList.add("error");
          }
      }

      //vérifier que les deux mots de passes sont bien identique
      var passwordError = false;
      var password1Elt = document.getElementById("pass1");
      var password2Elt = document.getElementById("pass2");

      if(!(password1Elt.value === password2Elt.value)){
          password1Elt.classList.add("error");
          password2Elt.classList.add("error");
          passwordError = true;
      }

      //Vérifier que les termes on bien été acceptés
      var checkElt = document.querySelector('input[type=checkbox]');
      var checkError = false;
      if(!checkElt.checked){
        checkError = true;
      }

      //S'il y a au moins une erreur, on n'envoi pas le formulaire au serveur
      if(inputError || passwordError || checkError){
          e.preventDefault();

          if(inputError){
              var message1Elt = document.createElement('p')
              message1Elt.className = "error-top";
              message1Elt.id = "inputError";
              message1Elt.textContent = "Veuillez remplir les champs en rouge.";
              document.getElementById("mainContent").insertAdjacentElement("afterbegin", message1Elt);
          }

          if(passwordError){
            var message2Elt = document.createElement('p')
            message2Elt.className = "error-top";
            message2Elt.id = "passwordError";
            message2Elt.textContent = "ERREUR - Les deux mots de passes ne sont pas identiques !";
            document.getElementById("mainContent").insertAdjacentElement("afterbegin", message2Elt);
          }

          if(checkError){
            var message3Elt = document.createElement('p')
            message3Elt.className = "error-top";
            message3Elt.id = "checkError";
            message3Elt.textContent = "Vous devez accépeter les termes en cochant la case au bas du formulaire.";
            document.getElementById("mainContent").insertAdjacentElement("afterbegin", message3Elt);
          }
      }
  });
</script>
<style type="text/css">
    .error{
        border-color: red;
    }

    .error-top{
        text-align: center;
        color: red;
    }
</style>
</body>
</html>
