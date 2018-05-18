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
    <div class="main-container">
        <div class="container">
            <form action="envoie.php" method="POST">
                <input type="hidden" name="from" value="creationArtcile">

                <label for="titre">Titre</label>
                <input type="text" name="titre" id="titre" placeholder="" required>

                <label for="auteur">Auteur</label>
                <input type="text" name="auteur" id="auteur" placeholder="" required>

                <label for="date">date</label>
                <input type="date" name="date" id="date" required>
                
                <label for="contenu">Contenu</label>
                <textarea name="" id="contenu" cols="30" rows="10" required></textarea>

                <input type="submit" value="Envoyer l'artcile">
            </form>
        </div>
    </div>
</body>
</html>
