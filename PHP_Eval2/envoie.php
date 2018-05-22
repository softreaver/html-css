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
                $keys[] = "auteur";
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

                //S'il y a au moins une erreur je renvois l'utilisateur à la première page
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
            else{//Je ne proviens d'aucun formulaire connu
                //Redirection vers la page d'accueil
                header('location:index.php');
                exit;
            }
        }
        else{//Si post n'existe pas
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

