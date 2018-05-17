<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page 3</title>
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
    $keys[] = "passion";
    $keys[] = "profession";

    //Liste des checkbox
    $checkboxes[] = "developpement";
    $checkboxes[] = "reseau";
    $checkboxes[] = "gestion";
    $checkboxes[] = "comptabilite";
    
    if(isset($_POST)){
        if($_POST['from'] === 'page2'){ //Si on provient de la page 2
        //On récupère toutes les données
        $erreur = false;
        //Je récupère toutes les données possible
        foreach($keys as $key){
            if(isset($_POST[$key])){
                if(trim($_POST[$key]) != '' && 
                        $_POST[$key] != null &&
                        $_POST[$key] != 'default')
                {
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
        }

        //S'il y a au moins une erreur je renvois l'utilisateur à la première page
        if($erreur){
            $param = '?callback';
            foreach($data as $key => $value){
                $param .= '&' . $key . '=' . $value;
            }

            header('location:page_2.php' . $param);
            exit;
        }

        //récupérer les index des checkbox cochées
        foreach($checkboxes as $index => $checkbox){
            if(isset($_POST[$checkbox])){
                $check[] = $index;
            }
        }
        if(isset($check)) {
            $data['checkboxes'] = $check;
        }

        //Affichage des données
        echo '<h2>Récapitulatif des données</h2>';
        foreach($data as $key => $value){
            if($key !== "checkboxes"){
                echo '<p>' . $key . ' : ' . $value . '</p>';
            }
        }

        ?>
            <div class="container">
                <form action="page_3.php" method="POST">
                    <input type="hidden" name="from" value="page3">

                    <button type="submit" class="btn btn-primary">Envoyer les données</button>
                </form>
            </div>
        <?php    
        }
        elseif($_POST['from'] === 'page3'){ //Si on clique sur envoyer les données?>

        <?php
        }
        else{
            header('location:page_1.php');
            exit;
        }
    }
    else{
        header('location:page_1.php');
        exit;
    }
    ?>
</body>
</html>