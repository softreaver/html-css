<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $resultat['titre']; ?></title>
</head>

<?php
    $resultat = null;
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
            $GLOBAL['resultat'] = $requete->fetch(PDO::FETCH_ASSOC);
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

<body>  
    <header>
        <h1>Mon mini blog</h1>
        <?php require('private_header.php'); ?>
    </header>

    <div class="main-container">
        <div class="container">
            <a href="index.php" class="button">Revenir à la liste des articles</a>
        <?php
            $resultat = $GLOBAL['resultat'];
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
                    
                    <!-- Création du bouton de suppression de l'artcile si l'utilisateur en est l'auteur -->
                    <?php
                    if($resultat['auteur'] == $_SESSION['pseudo'] || $_SESSION['admin']){ ?>
                        <form action="supprimer.php" method="POST">
                            <input type="hidden" name="from" value="article">
                            <input type="hidden" name="idarticle" value="<?php echo $_GET['idarticle']; ?>">
                            <input type="submit" class="red-button" value="Supprimer cet article">
                        </form>
                    <?php } ?>
                </article>
            <?php
            }
            else{//L'article n'existe pas
                echo "<p class=\"error-message\">ERREUR - L'article demandé n'existe pas!</p>";
            }
        ?>
        </div>
    </div>

    <footer>
        <?php include('contact_form.html'); ?>
    </footer>
    
</body>
</html>

