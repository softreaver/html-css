<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <?php
        $nom = 'MILAZZO';
        $prenom = 'Christopher';
        $email = 'milazzo.c@laposte.net';
        $age = 31;
        $classe = 'DL18-1';

        $connexion = new PDO('mysql:host=localhost;dbname=testphpadmin', 'root', '');
        $requete = $connexion->prepare("INSERT INTO eleves VALUES (null, :nom, :prenom, :email, :age, :classe)");
        $requete->bindParam(':nom', $nom);
        $requete->bindParam(':prenom', $prenom);
        $requete->bindParam(':email', $email);
        $requete->bindParam(':age', $age);
        $requete->bindParam(':classe', $classe);

        $requete->execute();

        $nom = 'FORGEOT';
        $prenom = 'Delphine';
        $email = 'mydel13@laposte.net';
        $age = 35;
        $classe = 'none';

        $requete->execute();

        //Vérifier si FORGEOT Delphine existe bien dans la base
        $requete = $connexion->prepare("SELECT nom, prenom FROM eleves WHERE nom = :nom AND prenom = :prenom");
        $requete->bindParam(':nom', $nom);
        $requete->bindParam(':prenom', $prenom);
        $requete->execute();

        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
        if($resultat['nom'] == $nom && $resultat['prenom'] == $prenom)
            echo $nom . ' ' . $prenom . ' existe bien dans la base.';
        else
            echo $nom . ' ' . $prenom . ' n\'a pas été trouvé dans la base.';
    ?>
</body>
</html>
