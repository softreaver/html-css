<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page 2</title>
    <link rel="stylesheet" href="inc/bootstrap.css">
    <link rel="stylesheet" href="inc/bootstrap-theme.css">
    <link rel="stylesheet" href="inc/form.css">
</head>
<body>

<?php
    //Liste des données de mon formulaire
    $keys[] = "nom";
    $keys[] = "prenom";
    $keys[] = "age";
    $keys[] = "sexe";

    //Si je proviens de la première page je récupère les données
    if(isset($_POST['from'])){
        if($_POST['from'] = "page1"){

            $erreur = false;
            //Je récupère toutes les données possible
            foreach($keys as $key){
                if(isset($_POST[$key])){
                    if(sizeof(trim( $_POST[$key])) > 0 && 
                                    $_POST[$key] != null && 
                                    $_POST[$key] != 'default'){
                        $data[$key] = $_POST[$key];
                    }
                    else{
                        $erreur = true;
                    }
                }
                else
                {
                    $erreur = true;
                }
                //Vérifier que l'age entré est bien une valeur positive
                if($key === 'age' && $_POST[$key] < 1){
                    $erreur = true;
                }
            }

            //S'il y a au moins une erreur je renvois l'utilisateur à la première page
            if($erreur){
                $param = '?callback';
                foreach($data as $key => $value){
                    $param .= '&' . $key . '=' . $value;
                }

                header('location:page_1.php' . $param);
                exit;
            }
        }
        else
        {//Je ne proviens pas du formulaire de la première page
            //Je renvois l'utilisateur sur la première page
            header('location: page_1.php');
            exit;
        }
    }
    else
    {//J'accède directement à la page
        //Je renvois directement sur la première page
        header('location: page_1.php');
        exit;
    }
?>
    
    <div class="container">
        <form action="page_3.php" method="POST">
            <!-- Données cachés qui devront être envoyés à la page suivante -->
            <input type="hidden" name="nom" value="<?php echo $data['nom']; ?>">
            <input type="hidden" name="prenom" value="<?php echo $data['prenom']; ?>">
            <input type="hidden" name="age" value="<?php echo $data['age']; ?>">
            <input type="hidden" name="sexe" value="<?php echo $data['sexe']; ?>">
            <input type="hidden" name="from" value="page2">

            <div class="form-group">
                <label for="passion">Passion</label>
                <input type="text" class="form-control" name="passion" id="passion" placeholder="Entrez votre passion" required>
                <?php //J'affiche un message d'erreur si l'utilisateur n'a pas rempli ce champ
                    if(!isset($_POST['passion']) && isset($_POST['callback'])) { echo '<div class="error-feedback">Merci de renseigner ce champs</div>'; }
                ?>
            </div>
            <div class="form-group">
                <label for="profession">Profession</label>
                <input type="text" class="form-control" name="profession" id="profession" placeholder="Entrez votre profession" required>
                <?php //J'affiche un message d'erreur si l'utilisateur n'a pas rempli ce champ
                    if(!isset($_POST['profession']) && isset($_POST['callback'])) { echo '<div class="error-feedback">Merci de renseigner ce champs</div>'; }
                ?>
            </div>
            
            <div class="check-container">
                <h2>Compétences</h2>
                <div class="col-auto my-1">
                    <div class="custom-control custom-checkbox mr-sm-2">
                        <input type="checkbox" class="custom-control-input" id="developpement" name="developpement">
                        <label class="custom-control-label" for="developpement">Développement</label>
                    </div>
                </div>
                <div class="col-auto my-1">
                    <div class="custom-control custom-checkbox mr-sm-2">
                        <input type="checkbox" class="custom-control-input" id="reseau" name="reseau">
                        <label class="custom-control-label" for="reseau">Réseau</label>
                    </div>
                </div>
                <div class="col-auto my-1">
                    <div class="custom-control custom-checkbox mr-sm-2">
                        <input type="checkbox" class="custom-control-input" id="gestion" name="gestion">
                        <label class="custom-control-label" for="gestion">Géstion</label>
                    </div>
                </div>
                <div class="col-auto my-1">
                    <div class="custom-control custom-checkbox mr-sm-2">
                        <input type="checkbox" class="custom-control-input" id="comptabilite" name="comptabilite">
                        <label class="custom-control-label" for="comptabilite">Comptabilité</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Suivant</button>
        </form>
    </div>

</body>
</html>