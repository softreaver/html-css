<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Création d'un article</title>
</head>
<body>
    <header>
        <h1>Mon mini blog</h1>
        <?php require('private_header.php'); ?>
    </header>

    <div class="main-container">
        <div class="container">
            <a href="index.php" class="button">Revenir à la liste des articles</a>
            <form action="envoie.php" method="POST">
                <input type="hidden" name="from" value="creationArtcile">

                <label for="titre">Titre</label>
                <input 
                    type="text"
                    name="titre" 
                    id="titre" 
                    class="<?php if(!isset($_GET['titre']) && isset($_GET['callback'])){ echo 'error'; } ?>"
                    placeholder="<?php if(!isset($_GET['titre']) && isset($_GET['callback'])){ echo 'Merci de renseigner ce champs.'; } ?>" 
                    value="<?php if(isset($_GET['titre'])){ echo $_GET['titre']; } ?>" 
                    required
                >

                <label for="auteur">Auteur</label>
                <input
                    type="text" 
                    name="auteur" 
                    id="auteur" 
                    value="<?php echo $_SESSION['pseudo']; ?>" 
                    disabled
                    required
                >

                <label for="date">date</label>
                <input
                    type="date" 
                    name="date" 
                    id="date"
                    class="<?php if(!isset($_GET['date']) && isset($_GET['callback'])){ echo 'error'; } ?>"
                    value="<?php if(isset($_GET['date'])){ echo $_GET['date']; } ?>"
                    required
                >
                
                <label for="contenu">Contenu</label>
                <?php 
                        if(!isset($_GET['contenu']) && isset($_GET['callback'])){
                            echo '<p class="error-message">Merci de renseigner ce champs</p>';
                        } 
                ?>
                <textarea 
                    name="contenu" 
                    id="contenu" 
                    cols="30" 
                    rows="10"
                    maxlength="250"
                    class="<?php if(!isset($_GET['contenu']) && isset($_GET['callback'])){ echo 'error'; } ?>"
                    required/><?php if(isset($_GET['contenu'])){ echo $_GET['contenu'];} ?></textarea>

                <input type="submit" value="Envoyer l'artcile">
            </form>
        </div>
    </div>

    <footer>
        <?php include('contact_form.html'); ?>
    </footer>

    <script>//Permet de récupérer la date du jour
        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
            return local.toJSON().slice(0, 10);
        });

        document.getElementById('date').value = new Date().toDateInputValue();
    </script>
</body>
</html>
