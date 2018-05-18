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
    <?php
        //Mes données
        const $DBENGINE     = "mysql";
        const $HOST         = "localhost";
        const $DBNAME       = "eval_blog";
        const $CHARSET      = "utf8";

        if(isset($_POST['from'])){
            if($_POST['from'] == 'creationArtcile'){//Je proviens du formulaire de création d'artcile
                //Liste de tous les champs du formulaire création d'artcile
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

                    header('location:form.php' . $param);
                    exit;
                }
                else{ //Il n'y a pas d'erreur, je peut envoyer les données à la base
                    //Création de la connexion avec la base de données
                    $connexion = new PDO($DBENGINE . ':host=' . $HOST . ';dbname=' . $DBNAME . ';charset=' . $CHARSET, 'root', '');

                    //Préparation de la requête
                    $requete = $connexion->prepare("INSERT INTO articles VALUES (null, :titre, :date, :auteur, :contenu)");
                    $requete->bindParam(":titre", $data['titre']);
                    $requete->bindParam(":date", $data['date']);
                    $requete->bindParam(":auteur", $data['auteur']);
                    $requete->bindParam(":contenu", $data['contenu']);

                    //Envoie de la requête
                    if($requete->execute()){//La requête est un succès
                        echo '<h3 style="color: green">L\'artcile a été ajouté avec succès.</h3>';
                        header("refresh:5;url=index.php");
                        exit;
                    }
                    else{//La requête échoue
                        echo '<h3 style="color: red">ERREUR - ' . $requete->errorInfo()[2] . '</h3>';
                        header("refresh:5;url=index.php");
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
        else{//Si post n'existe pas
            echo '<h3 class="error">ERREUR - Aucune donnée recu !</h3>';
        }
    ?>
</body>
</html>