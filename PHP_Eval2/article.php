<?php
    require('fonctions.php');

    //Création de la connexion à la base de données
    $connexion = connexionBD();
    
    //Récupération de l'ID de l'article
    if(isset($_GET['idarticle'])){
        //Récupération de l'article demandé
        $requete = $connexion->prepare('SELECT * FROM articles WHERE ID = :id');
        $requete->bindParam(':id', $_GET['idarticle']);

        //Envoie de la requete à la base
        if($requete->execute()){ //La requête est un succès
            //Récupération du résultat
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);
        }
        else{ //La requête a échouée
            echo '<span class="error-message">ERREUR - ' . $requete->errorInfo()[2] . '</span>';
        }
    }
    else{
        echo '<h3 class="error-message">ERREUR - l\'article n\'existe pas !</h3>';
        header("refresh:5;url=index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $resultat['titre']; ?></title>
</head>
<body>  
    <header>
        <h1>Mon mini blog</h1>
        <?php
        session_start();

        if(isset($_SESSION['pseudo'])){ ?>
            <div id="connexion" class="box">
                <h2 style="margin: 0">Bienvenu <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?></h2>
                <a class="red-button" href="envoie.php?disconnect">Se déconnecter</a>
            </div>
            
        <?php
        }
        else{
            echo "<p class=\"error-message\">ERREUR - Vous devez être connecté pour consulter un artcile !</p>";
            header("refresh:3;url=" . $_SERVER['HTTP_REFERER']);
            exit;
        }
        ?>
    </header>

    <div class="main-container">
        <div class="container">
            <a href="index.php" class="button">Revenir à la liste des articles</a>
        <?php
            //On vérifie que l'article existe vraiment
            if(!empty($resultat)){
                //Afficher l'article ?>
                <article id="single">
                    <h3 class="title"><?php echo $resultat['titre'] ?></h3>
                    <div class="infos">
                        <p class="auteur">Auteur : <?php echo $resultat['auteur']; ?></p>
                        <p class="date">Date : <?php echo afficherDate($resultat['date']); ?></p>
                    </div>
                    <div class="child-content">
                        <p class="p-content"><?php echo $resultat['contenu']; ?></p>
                    </div>
                    
                    <!-- Création du bouton de suppression de l'artcile -->
                    <form action="supprimer.php" method="POST">
                        <input type="hidden" name="from" value="article">
                        <input type="hidden" name="idarticle" value="<?php echo $_GET['idarticle']; ?>">
                        <input type="submit" class="red-button" value="Supprimer cet article">
                    </form>
                </article>
            <?php
            }
            else{//L'article n'existe pas
                echo "<p class=\"error-message\">ERREUR - L'article demandé n'existe pas!</p>";
            }
        ?>
        </div>
    </div>
</body>
</html>

