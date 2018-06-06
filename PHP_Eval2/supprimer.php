<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Suppression</title>
</head>
<body>
    <header>
        <h1>Mon mini blog</h1>
    </header>

    <?php
    require('fonctions.php');

        if(isset($_POST['from'])){
            $connexion = connexionBD();
            
            if($_POST['from'] == 'article'){
                
                if(isset($_POST['idarticle'])){
                    //Récupération de l'article demandé
                    $requete = $connexion->prepare('SELECT * FROM articles WHERE ID = :id');
                    $requete->bindParam(':id', $_POST['idarticle']);

                    //Envoie de la requete à la base
                    if($requete->execute()){ //La requête est un succès
                        //Récupération du résultat
                        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
                    }
                    else{ //La requête a échouée
                        echo '<h3 style="color: red">ERREUR - ' . $requete->errorInfo()[2] . '</h3>';
                        //Redirection automatique sur la page précédente au bout de 3 secondes
                        header("refresh:3;url=" . $_SERVER['HTTP_REFERER']);
                        exit;
                    }
                }
                else{
                    echo '<h3 class="error-message">ERREUR - l\'article a déjà été supprimé !</h3>';
                    header("refresh:3;url=index.php");
                    exit;
                }
            }
            elseif($_POST['from'] == 'this'){// l'utilisateur à cliqué sur OUI pour supprimer l'article
                //Préparation de la requête
                $requete = $connexion->prepare('DELETE FROM articles WHERE ID = :id');
                $requete->bindParam(':id', $_POST['idarticle']);

                //Envoie de la requete à la base
                if($requete->execute()){ //La requête est un succès
                    //Confirmer la suppression
                    echo '<h3 class="message">L\'article a bien été supprimé</h3>';
                    //Redirection automatique sur la liste des articles
                    header("refresh:3;url=liste_articles.php");
                    exit;
                }
                else{ //La requête a échouée
                    echo '<h3 class="error-message">ERREUR - ' . $requete->errorInfo()[2] . '</h3>';
                    //Redirection automatique sur la page précédente au bout de 5 secondes
                    header("refresh:3;url=" . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }
            else{
                header('location:index.php');
                exit;
            }
        }
        else{
            header('location:index.php');
            exit;
        }
    ?>

    <div class="main-container">
        <div class="container">
            <h3>Voulez-vous vraiment supprimer l'article : <?php echo $resultat['titre']; ?> ?</h3>
            <form action="supprimer.php" method="POST">
                <input type="hidden" name="from" value="this">
                <input type="hidden" name="idarticle" value="<?php echo $resultat['ID']; ?>">
                <input class="red-button" type="submit" value="OUI">
                <a class="button" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">NON</a>
            </form>
        </div>
    </div>
</body>
</html>

