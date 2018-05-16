<?php
    session_start();

    //Gérer une demande de déconnexion
    if(isset($_GET['disconnect'])){
        session_destroy();
        header("location: index.php");
        exit;
    }

    //Liste de toutes les données à récupérer
    $keys[] = 'email';
    $keys[] = 'password';

    $error = false;
    for($i = 0; $i < sizeof($keys); $i++){
        if(isset($_POST[$keys[$i]])){
            $data[$keys[$i]] = $_POST[$keys[$i]];
        }
        else
        {
            $error = true;
        }
    }

    if($error){
        echo '<p style="color: red">ERREUR - Les données transmisent à la page sont éronnées.</p>'; 
    }
    else
    {
        //Vérifier si les identifiant match
        //Création de la connexion avec la base de données
        $connection = new PDO('mysql:host=localhost;dbname=testphpadmin', 'root', '');

        //Vérifier si le mail et le nom de l'utilisateur n'est pas déjà enregistré en base de données
        $requete = $connection->prepare("SELECT fullName, email, password FROM users WHERE email = :email AND password = :password");
        $requete->bindParam(':email', $data['email']);
        $requete->bindParam(':password', $data['password']);
        $requete->execute();

        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
        if($resultat['email'] == $data['email'] && $resultat['password'] == $data['password']){
            //Si la case remind me est cochée
            if(isset($_POST['remindMe'])){
                //Se souvenir de la session
                $_SESSION['fullName'] = $resultat['fullName'];
                $_SESSION['email'] = $resultat['email'];
                $_SESSION['password'] = $resultat['password'];
            }
            else
            {
                session_destroy();
            }

            header("location: general.php");
            exit;
        }
        else
        {
            header("location: index.php?loginError");
            exit;
        }
    }
?>