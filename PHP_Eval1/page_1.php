<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page 1</title>
    <link rel="stylesheet" href="inc/bootstrap.css">
    <link rel="stylesheet" href="inc/bootstrap-theme.css">
    <link rel="stylesheet" href="inc/form.css">
</head>
<body>

    <div class="container">
        <form action="page_2.php" method="POST">
            <input type="hidden" name="from" value="page1">

            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control <?php if(!isset($_GET['nom']) && isset($_GET['callback'])) { echo 'error'; } ?>" name="nom" id="nom" placeholder="Entrez votre nom" value="<?php if(isset($_GET['nom'])){ echo $_GET['nom']; } ?>" required>
                <?php //J'affiche un message d'erreur si l'utilisateur n'a pas rempli ce champ
                    if(!isset($_GET['nom']) && isset($_GET['callback'])) { echo '<div class="error-feedback">Merci de renseigner ce champs</div>'; }
                ?>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control <?php if(!isset($_GET['prenom']) && isset($_GET['callback'])) { echo 'error'; } ?>" name="prenom" id="prenom" placeholder="Entrez votre nom" value="<?php if(isset($_GET['prenom'])){ echo $_GET['prenom']; } ?>" required>
                <?php //J'affiche un message d'erreur si l'utilisateur n'a pas rempli ce champ
                    if(!isset($_GET['prenom']) && isset($_GET['callback'])) { echo '<div class="error-feedback">Merci de renseigner ce champs</div>'; }
                ?>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" name="age" class="form-control <?php if(!isset($_GET['age']) && isset($_GET['callback'])) { echo 'error'; } ?>" id="age" value="<?php if(isset($_GET['age'])){ echo $_GET['age']; } ?>">
                <?php //J'affiche un message d'erreur si l'utilisateur n'a pas rempli ce champ
                    if(!isset($_GET['age']) && isset($_GET['callback'])) { echo '<div class="error-feedback">Merci de renseigner ce champs</div>'; 
                    }elseif(isset($_GET['age'])){
                        if($_GET['age'] < 1){// Si l'age est inférieur à 1
                            echo '<div class="error-feedback">Merci d\'entrer une valeur positive</div>';
                        }
                    }
                ?>
            </div>
            <div class="form-group">
                <label for="sexe">Sexe</label>
                <select class="form-control <?php if(!isset($_GET['sexe']) && isset($_GET['callback'])) { echo 'error'; } ?>" id="sexe" name="sexe" value="<?php if(isset($_GET['sexe'])){ echo $_GET['sexe']; } ?>">
                    <option value="default">CHOISISSEZ</option>
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                </select>
                <?php //J'affiche un message d'erreur si l'utilisateur n'a pas rempli ce champ
                    if(!isset($_GET['sexe']) && isset($_GET['callback'])) { echo '<div class="error-feedback">Merci de sélectionner un élément</div>'; }
                ?>
            </div>
            <button type="submit" class="btn btn-primary">Suivant</button>
        </form>
    </div>

</body>
</html>
