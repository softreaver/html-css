<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Enregistrement</title>
</head>
<body>
    <header>
        <h1><a href="index.php" style="color: black" title="Accueil du site">Mon mini blog</a></h1>
        <?php
        session_start();

        if(isset($_SESSION['pseudo'])){
            include('calculette.php'); ?>
            <div id="user-box" class="box">
                <h2 style="margin: 0">Bienvenue <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?></h2>
                <a class="blue-button" href="liste_utilisateurs.php">Liste des utilisateurs</a>
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
            <?php
            //Afficher le liens vers la liste des articles si l'utilisateur est connecté
            if(isset($_SESSION['pseudo'])){ ?>
                <a href="index.php" class="button">Revenir à la liste des articles</a>
            <?php
            } ?>
            <h2>Formulaire d'enregistrement</h2>
            <?php
                    //Afficher les erreurs lorsqu'un homonyme existe déjà dans la base de données
                    if(isset($_GET['doublonPseudo'])){
                        echo '<h3 class="error-message">ERREUR - Le pseudo est déjà utilisé !</h3>';
                    }

                    if(isset($_GET['doublonEmail'])){
                        echo '<h3 class="error-message">ERREUR - Le mail est déjà utilisé !</h3>';
                    }

                    if(isset($_GET['passwordDiff'])){
                        echo '<h3 class="error-message">Les deux mots de passe ne sont pas identiques</h3>';
                    }
            ?>
            <form action="envoie.php" method="POST">
                <input type="hidden" name="from" value="enregistrement">

                <label for="nom">Nom</label>
                <input 
                    type="text"
                    name="nom" 
                    id="nom"
                    maxlength="20"
                    class="<?php if(!isset($_GET['nom']) && isset($_GET['callback'])){ echo 'error'; } ?>"
                    placeholder="<?php if(!isset($_GET['nom']) && isset($_GET['callback'])){ echo 'Merci de renseigner ce champs.'; } ?>" 
                    value="<?php if(isset($_GET['nom'])){ echo $_GET['nom']; } ?>" 
                    required
                >

                <label for="prenom">prenom</label>
                <input
                    type="text" 
                    name="prenom" 
                    id="prenom" 
                    maxlength="20"
                    class="<?php if(!isset($_GET['prenom']) && isset($_GET['callback'])){ echo 'error'; } ?>"
                    placeholder="<?php if(!isset($_GET['prenom']) && isset($_GET['callback'])){ echo 'Merci de renseigner ce champs.'; } ?>" 
                    value="<?php if(isset($_GET['prenom'])){ echo $_GET['prenom']; } ?>" 
                    required
                >

                <label for="pseudo">Pseudo</label>
                <input 
                    type="text"
                    name="pseudo" 
                    id="pseudo" 
                    maxlength="50"
                    class="<?php if(!isset($_GET['pseudo']) && isset($_GET['callback'])){ echo 'error'; } ?>"
                    placeholder="<?php if(!isset($_GET['pseudo']) && isset($_GET['callback'])){ echo 'Merci de renseigner ce champs.'; } ?>" 
                    value="<?php if(isset($_GET['pseudo'])){ echo $_GET['pseudo']; } ?>" 
                    required
                >

                <label for="email">Adresse mail</label>
                <input 
                    type="email"
                    name="email" 
                    id="email" 
                    maxlength="50"
                    class="<?php if(!isset($_GET['email']) && isset($_GET['callback'])){ echo 'error'; } ?>"
                    placeholder="<?php if(!isset($_GET['email']) && isset($_GET['callback'])){ echo 'Merci de renseigner ce champs.'; } ?>" 
                    value="<?php if(isset($_GET['email'])){ echo $_GET['email']; } ?>" 
                    required
                >

                <label for="password">Mot de passe</label>
                <input
                    type="password" 
                    name="password" 
                    id="password" 
                    maxlength="50"
                    class="<?php if(!isset($_GET['password']) && isset($_GET['callback'])){ echo 'error'; } ?>"
                    placeholder="<?php if(!isset($_GET['password']) && isset($_GET['callback'])){ echo 'Merci de renseigner ce champs.'; } ?>" 
                    required
                >

                <label for="password-confirm">Retapez le mot de passe</label>
                <input
                    type="password" 
                    name="password-confirm" 
                    id="password-confirm" 
                    maxlength="50"
                    class="<?php if(!isset($_GET['password-confirm']) && isset($_GET['callback'])){ echo 'error'; } ?>"
                    placeholder="<?php if(!isset($_GET['password-confirm']) && isset($_GET['callback'])){ echo 'Merci de renseigner ce champs.'; } ?>" 
                    required
                >

                <input type="submit" value="s'enregistrer">
            </form>
        </div>
    </div>

    <footer>
        <?php include('contact_form.php'); ?>
    </footer>
</body>
</html>
