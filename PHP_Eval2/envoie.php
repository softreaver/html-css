<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Envoie des données</title>
</head>
<body>
    <header>
        <h1>Mon mini blog</h1>
    </header>

    <?php
        session_start();
        require('fonctions.php');

        if(isset($_POST['from'])){
            if($_POST['from'] == 'creationArtcile'){//Je proviens du formulaire de création d'artcile
                //Liste de tous les champs du formulaire création d'article
                $keys[] = "titre";
                //$keys[] = "auteur"; //Valeur remplie automatiquement
                $keys[] = "date";
                $keys[] = "contenu";

                //Vérifier que tous les champs on bien été remplis
                $erreur = false;
                //Je récupère toutes les données possible
                foreach($keys as $key){
                    if(isset($_POST[$key])){
                        if(trim($_POST[$key]) != '' && $_POST[$key] != null)
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

                //Récupèration du pseudo de l'auteur connecté
                $data['auteur'] = $_SESSION['pseudo'];

                //S'il y a au moins une erreur je renvois l'utilisateur à la première page
                if($erreur){
                    $param = '?callback';
                    foreach($data as $key => $value){
                        $param .= '&' . $key . '=' . $value;
                    }

                    header('location:form.php' . $param);
                    exit;
                }
                else{ //Il n'y a pas d'erreur, je peut envoyer les données à la base
                    publier($data['titre'], $data['date'], $data['auteur'], $data['contenu']);
                }

            }
            elseif($_POST['from'] == 'enregistrement'){ //Je proviens du formulaire d'enregistrement d'utilisateur
                //Liste de tous les champs du formulaire enregistrement
                $keys[] = "nom";
                $keys[] = "prenom";
                $keys[] = "pseudo";
                $keys[] = "email";
                $keys[] = "password";
                $keys[] = "password-confirm";

                //Vérifier que tous les champs on bien été remplis
                $erreur = false;
                //Je récupère toutes les données possible
                foreach($keys as $key){
                    if(isset($_POST[$key])){
                        if(trim($_POST[$key]) != '' && $_POST[$key] != null)
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

                //Je vérifie que les deux mots de passe entré soit identique
                $erreurPassword = false;
                if(isset($data['password']) && isset($data['password-confirm'])){
                    if($data['password'] != $data['password-confirm']){
                        $erreurPassword = true;
                    }
                }

                //Je vérifie que le pseudo et l'adresse mail ne soit pas déjà enregistrés dans la base
                $erreurDoublonPseudo = false;
                $erreurDoublonEmail = false;
                if(isset($data['pseudo'])){
                    if(!verifierDispoPseudo($data['pseudo'])){
                        $erreurDoublonPseudo = true;
                        $erreur = true;
                    }
                }
                if(isset($data['email'])){
                    if(!verifierDispoEmail($data['email'])){
                        $erreurDoublonEmail = true;
                        $erreur = true;
                    }
                }

                //S'il y a au moins une erreur je renvois l'utilisateur à la première page
                if($erreur){
                    $param = '?callback';
                    if($erreurPassword){
                        $param .= '&passwordDiff';
                    }
                    if($erreurDoublonPseudo){
                        $param .= '&doublonPseudo';
                    }
                    if($erreurDoublonEmail){
                        $param .= '&doublonEmail';
                    }

                    foreach($data as $key => $value){
                        if($key != 'password' && $key != 'password-confirm'){
                            $param .= '&' . $key . '=' . $value;
                        }
                    }

                    header('location:enregistrement.php' . $param);
                    exit;
                }
                else{ //Il n'y a pas d'erreur, je peut envoyer les données à la base
                    enregistrerUtilisateur($data['nom'], $data['prenom'], $data['email'], $data['pseudo'], $data['password']);
                }
            }
            elseif($_POST['from'] == 'connexion'){ //Je proviens du formulaire de connexion
                connecterUtilisateur($_POST['pseudo'], $_POST['password']);
            }
            elseif($_POST['from'] == 'contact'){ //Je proviens du formulaire de contact
                //Liste de tous les champs du formulaire enregistrement
                $keys[] = "email";
                $keys[] = "sujet";
                $keys[] = "message";

                //Vérifier que tous les champs on bien été remplis
                $erreur = false;
                //Je récupère toutes les données possible
                foreach($keys as $key){
                    if(isset($_POST[$key])){
                        if(trim($_POST[$key]) != '' && $_POST[$key] != null)
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

                //S'il y a au moins une erreur je renvois l'utilisateur à la page précédente ou la page d'accueil si pas de page précédente
                if($erreur){
                    $param = '?callback';
                    if($erreurPassword){
                        $param .= '&passwordDiff';
                    }

                    foreach($data as $key => $value){
                        if($key != 'password' && $key != 'password-confirm'){
                            $param .= '&' . $key . '=' . $value;
                        }
                    }

                    if(isset($_SERVER['HTTP_REFERER'])){
                        header('location:' . $_SERVER['HTTP_REFERER'] . $param);
                        exit;
                    }
                    else{
                        header('location:enregistrement.php' . $param);
                        exit;
                    }
                    
                }
                else{ //Il n'y a pas d'erreur, je peut envoyer le mail
                    $to = 'softreaver.dev@gmail.com';
                    $sujet = $data['sujet'];
                    $header = 'from: ' . $data['email'];
                    $message = $header . '<br/>' . $data['message'];

                    if(mail($to, $sujet, $message, "content-type: text/html")){ //Le mail a bien été envoyé
                        echo "<p class=\"message\">Le mail a bien été envoyé.</p>";
                    }
                    else{ //Le mail n'a pas été envoyé
                        echo "<p class=\"error-message\">ERREUR - Le mail n'a pas pu être envoyé !</p>";
                    }

                    //Redirection de l'utilisateur
                    if(isset($_SERVER['HTTP_REFERER'])){ //Sur la page d'où il a envoyé le mail
                        header("refresh:3;url=" . $_SERVER['HTTP_REFERER']);
                        exit;
                    }
                    else{ //Sinon sur la page d'accueil
                        header("refresh:3;url=index.php");
                        exit;
                    }
                }
            }
            else{//Je ne proviens d'aucun formulaire connu
                //Redirection vers la page d'accueil
                header('location:index.php');
                exit;
            }
        }
        else{//Si $_POST n'existe pas
            if(isset($_GET['disconnect'])){// Si l'utilisateur à cliqué sur se déconnecter
                session_destroy();
                header('location:index.php');
                exit;
            }
            echo '<h3 class="error">ERREUR - Aucune donnée recu !</h3>';
        }
    ?>
</body>
</html>

