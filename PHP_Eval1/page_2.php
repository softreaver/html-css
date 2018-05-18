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

    //Création de la connexion avec la base de données
    $connexion = new PDO('mysql:host=localhost;dbname=adrar_user;charset=utf8', 'root', '');

    //Récupération de la liste de toutes les compétences possibles depuis la base
    $requete = $connexion->prepare("SELECT ID, nom FROM competences");
    if($requete->execute()){// Si la requête à bien fonctionnée
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    }
    else{ //Si la requête n'a pas fonctionnée
        //Afficher la cause de l'echec
        echo 'ERREUR - ' . $requete->errorInfo()[2];
    }

    //Liste des checkbox
    if(isset($resultat)){
        foreach($resultat as $competence){
            $checkboxes[$competence['ID']] = $competence['nom'];
        }
    }

    //Si je proviens de la première page ou retour de la troisième page
    if(isset($_POST['from']) || isset($_GET['callback'])){
        if($_POST['from'] = "page1"){//Je viens de la première page

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
        elseif(!isset($_GET['callback'])){//Je ne proviens pas du formulaire de la première page ni de la troisième page
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
            </div>
            <div class="form-group">
                <label for="profession">Profession</label>
                <input type="text" class="form-control" name="profession" id="profession" placeholder="Entrez votre profession" required>
            </div>
            
            <div class="check-container">
                <h2>Compétences</h2>

                <?php
                    //Afficher tous les choix de compétences
                    foreach($checkboxes as $index => $value){ //Création d'une checkbox pour chaque compétences ?>
                        <div class="col-auto my-1">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" class="custom-control-input" id="<?php echo $index; ?>" name="<?php echo $index; ?>">
                                <label class="custom-control-label" for="<?php echo $index; ?>"><?php echo $value; ?></label>
                            </div>
                        </div>
                    <?php
                    }
                ?>
            </div>

            <div class="form-group">
                <label for="description">Example textarea</label>
                <textarea class="form-control" id="description" rows="3" name="description"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Suivant</button>
        </form>
    </div>

</body>
</html>