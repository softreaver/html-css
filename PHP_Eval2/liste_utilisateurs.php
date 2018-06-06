<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Liste des utilisateurs</title>
</head>
<body>
    <header>
        <h1><a href="index.php" style="color: black" title="Accueil du site">Mon mini blog</a></h1>
        <?php require('private_header.php'); ?>
    </header>
    
    <div class="main-container">
        <div class="container">
            <a href="index.php" class="button" style="margin-bottom: 0.5em">Revenir à la liste des articles</a>
            <a href="enregistrement.php" class="button">Enregistrer un nouvel utilisateur</a>
            <table id="utilisateurs">
                <thead>
                    <tr class="exep">
                        <th style="text-align: left">Pseudo</th>
                        <th style="text-align: left">Admin</th>
                    </tr>
                </thead>
                <?php
                    require('fonctions.php');
                    
                    //Création de la connexion à la base de données
                    $connexion = connexionBD();

                    //Récupérer la liste de tous les utilisateurs (sauf l'utilisateur connecté) de la base de données
                    $requete = $connexion->prepare("SELECT ID, pseudo, admin FROM users WHERE pseudo != :pseudo ORDER BY pseudo ASC");
                    $requete->bindParam(":pseudo", $_SESSION['pseudo']);
                    if($requete->execute()){//La requête a fonctionnée
                        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
                    }
                    else{//La requête a échouée
                        echo '<span class="error-message">ERREUR - ' . $requete->errorInfo() . '</span>';
                    }

                    if(isset($resultat)){
                        if(sizeof($resultat) > 0){//S'il y a au moins un utilisateur
                            //Afficher la liste des utilisateurs
                            afficherListeUtilisateurs($resultat);
                        }
                        else{
                            echo '<tr colspan=2><td><h3>Aucun autre utilisateur enregistré.</h3></td></tr>';
                        }
                        
                    }
                ?>
            </table>
        </div>
    </div>

    <footer>
        <?php include('contact_form.php'); ?>
    </footer>
</body>
</html>