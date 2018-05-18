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
    $keys[] = "description";

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
    
    if(isset($_POST)){
        //On récupère toutes les données
        $erreur = false;
        //Je récupère toutes les données possible
        foreach($keys as $key){
            if(isset($_POST[$key])){
                $data[$key] = $_POST[$key];              
            }
        }

        //récupérer les index des checkbox cochées
        foreach($checkboxes as $index => $checkbox){
            if(isset($_POST[$index])){
                $check[$index] = $checkbox;
            }
        }
        if(isset($check)) {
            $data['checkboxes'] = $check;
        }

        if($_POST['from'] === 'page2'){ //Si on provient de la page 2 ----------------------------------------

            //Affichage des données
            ?>
                <div class="container">
                <form action="page_3.php" method="POST">
                    <input type="hidden" name="from" value="page3">
                    <h2>Récapitulatif des données</h2>
            <?php
            foreach($data as $key => $value){
                if($key !== "checkboxes"){
                    echo '<p>' . $key . ' : ' . $value . '</p>';
                    echo '<input type="hidden" name="' . $key . '" value="' . $value . '">';
                }
            }

            //Afficher les compétences
            ?>
                <h3>Les compétences :</h3>
            <?php
            if(isset($data['checkboxes'])){
                foreach($data['checkboxes'] as $index => $value){
                    echo '<p>' . $value . '</p>';
                    echo '<input type="hidden" name="' . $index . '" value="' . $value . '">';
                }
            }

            ?>
                    

                        <button type="submit" class="btn btn-primary">Envoyer les données</button>
                    </form>
                </div> <!-- /DIV Class container -->
            <?php    
        }
        elseif($_POST['from'] === 'page3'){ //Si on clique sur envoyer les données -------------------------------------?>
            <?php
            //Préparations de la liste des colonnes à renseigner
            foreach($keys as $key){
                if(!isset($colonnes)){
                    $colonnes = $key;
                    $values = '"' . $_POST[$key] . '"';
                }
                else{
                    $colonnes .= ', ' . $key;
                    $values .= ', "' . $_POST[$key] . '"';
                }
            }

            //Préparer la requête d'envois des données à la base de données
            $requete = $connexion->prepare("INSERT INTO users (" . $colonnes . ") VALUES (" . $values . ")");

            //Execution de la requête
            if($requete->execute()){ //La requête à bien fonctionnée
                echo '<h3 style="color: green">Les données on bien étés envoyées</h3>';
            }
            else{ //La requête  n'a pas fonctionnée
                echo '<h3 style="color: red">ERREUR - ' . $requete->errorInfo()[2] . '</h3>';
            }

            $requete = $connexion->prepare("SELECT last_insert_id() FROM users");
            $requete->execute();
            $idUser = $requete->fetch();
            settype($idUser[0], "integer");
            
            //Renseigner la table d'association 
            foreach($data['checkboxes'] as $idCompetences => $value){
                settype($idCompetences, "integer");
                $requete = $connexion->prepare("INSERT INTO users_competences VALUES (" . $idUser[0] . ", " . $idCompetences . ")");
                if(!$requete->execute()){
                    echo '<h3 style="color: red">ERREUR - Les données n\'ont pas pu êtres envoyés !<br/>' . $requete->errorInfo()[2] . '</h3>';
                }
            }

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
