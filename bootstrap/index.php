<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Document</title>
</head>
<body>
        <div class="container">
        <h2>Vertical (basic) form</h2>
        <form action="page2.php" methode="GET">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prenom:</label>
                <input type="text" class="form-control" id="prenom" placeholder="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" id="nom" placeholder="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" class="form-control" id="age" placeholder="age" name="age">
            </div>
            <div class="checkbox-group">
                <label for="mailing">Envoyer par mail</label>
                <input type="checkbox" name="mailing" id="mailing">
            </div>
            <button type="submit" class="btn btn-default">Envoyer</button>
        </form>
        </div>
</body>
</html>
