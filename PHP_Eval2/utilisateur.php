<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Profil de <?php echo $resultat['pseudo']; ?></title>
</head>

<body>
    <header>
        <h1><a href="index.php" style="color: black" title="Accueil du site">Mon mini blog</a></h1>
            <?php require('private_header.php'); ?>
        </header>

        <?php
            require('fonctions.php');

            //Création de la connexion à la base de données
            $connexion = connexionBD();
            
            //Récupération de l'ID de l'utilisateur
            if(isset($_GET['iduser'])){
                //Récupération de l'utilisateur demandé
                $requete = $connexion->prepare('SELECT pseudo, nom, prenom, email, admin FROM users WHERE ID = :id');
                $requete->bindParam(':id', $_GET['iduser']);

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
                echo '<h3 class="error-message">ERREUR - l\'utilisateur n\'existe pas !</h3>';
                header("refresh:3;url=index.php");
                exit;
            }
        ?>

        <div class="main-container">
            <div class="container">
                <a href="index.php" class="button">Revenir à la liste des articles</a>
            <?php
                $resultat = $GLOBAL['resultat'];
                //On vérifie que l'article existe vraiment
                if(!empty($resultat)){
                    //Afficher l'article ?>
                    <article id="single">
                        <h3 class="title"><?php echo $resultat['pseudo'] ?></h3>
                        <div class="infos">
                            <p>Nom : <?php echo $resultat['nom']; ?></p>
                            <p>Prénom : <?php echo $resultat['prenom']; ?></p>
                            <p>Email : <a class="exept" href="mailto:<?php echo $resultat['email']; ?>"><?php echo $resultat['email']; ?></a></p>
                            <p>Est un admin : <?php echo ($resultat['admin']) ? 'oui' : 'non'; ?></p>
                        </div>
                        
                        <!-- Création du bouton de suppression de l'utilisateur -->
                        <form action="supprimer_utilisateur.php" method="POST">
                            <input type="hidden" name="from" value="utilisateur">
                            <input type="hidden" name="iduser" value="<?php echo $_GET['iduser']; ?>">
                            <input type="submit" class="red-button" value="Supprimer cet utilisateur">
                        </form>
                            
                        <!-- Création du formulaire de modification de droit si l'utilisateur est lui même un admin -->
                        <?php
                        if($_SESSION['admin']){ ?>
                            <div class="box" style="width: 10em; margin: 0 auto">
                                <h3 style="margin: 0">Modification des droits</h3>
                                <form action="envoie.php" method="POST">
                                    <input type="hidden" name="from" value="changerDroit">
                                    <input type="hidden" name="iduser" value="<?php echo $_GET['iduser']; ?>">
                                    <select style="width:10em" name="statut">
                                        <option value="1" <?php echo ($resultat['admin']) ? 'selected' : ''; ?>>admin</option>
                                        <option value="0" <?php echo ($resultat['admin']) ? '' : 'selected'; ?>>standart</option>
                                    </select>
                                    <input type="submit" class="blue-button" value="Valider">
                                </form>
                            </div>
                        <?php } ?>
                    </article>
                <?php
                }
                else{//L'utilisateur n'existe pas
                    echo "<p class=\"error-message\">ERREUR - L'utilisateur demandé n'existe pas!</p>";
                }
            ?>
            </div>
        </div>

        <footer>
            <?php include('contact_form.php'); ?>
        </footer>
    </body>
</html>