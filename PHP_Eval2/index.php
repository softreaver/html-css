<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
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
        else{ ?>
            <div id="connexion" class="box">
                <h2 style="margin: 0">Se connecter</h2>
                <form action="envoie.php" method="POST">
                    <input type="hidden" name="from" value="connexion">
                    <input type="text" name="pseudo" placeholder="Entrez votre pseudo" required>
                    <input type="password" name="password" placeholder="Entrez votre mot de passe" required>
                    <input type="submit" value="Se connecter">
                </form>
                <div>
                    ou <a href="enregistrement.php">s'enregistrer</a>
                </div>
            </div>
        <?php
        }
        ?>
    </header>
    
    <div class="main-container">
        <div class="container">
            <a href="form.php" class="button">Créer un nouvel article</a>
            <section class="articles">
                <?php
                    require('fonctions.php');
                    
                    //Création de la connexion à la base de données
                    $connexion = connexionBD();

                    //Récupérer la liste de tous les articles de la base de données
                    $requete = $connexion->prepare("SELECT ID, titre, date FROM articles ORDER BY ID DESC");
                    if($requete->execute()){//La requête a fonctionnée
                        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
                    }
                    else{//La requête a échouée
                        echo '<span class="error-message">ERREUR - ' . $requete->errorInfo() . '</span>';
                    }

                    if(isset($resultat)){
                        if(sizeof($resultat) > 0){//S'il y a au moins un article
                            //Afficher la liste des article
                            afficherListe($resultat);
                        }
                        else{
                            echo '<h3>Aucun article à afficher.</h3>';
                        }
                        
                    }
                ?>
            </section>
        </div>
    </div>
</body>
</html>
