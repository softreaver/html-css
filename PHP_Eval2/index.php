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
    <h1><a href="index.php" style="color: black" title="Accueil du site">Mon mini blog</a></h1>
        <?php include('public_header.php'); ?>
    </header>
    
    <div class="main-container">
        <div class="container center-content">
            <div id="connexion" class="box center-content">
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
        </div>
    </div>

    <footer>
        <?php include('contact_form.php'); ?>
    </footer>
</body>
</html>
