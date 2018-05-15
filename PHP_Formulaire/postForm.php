<?php
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);

    if($nom == '' || $prenom == '' || $email == '')
    {
        echo '<span style="color: red">ERREUR - Vous n\'avez pas renseigné tous les champs convenablement !</span>';
    }
    else
    {
        $connection = new PDO("mysql:host=localhost;dbname=testphpadmin", "root", "");
        $req = $connection->prepare("SELECT nom, prenom FROM personnes WHERE nom = :nom AND prenom = :prenom");
        $req->bindParam(":nom", $nom);
        $req->bindParam(":prenom", $prenom);
        $req->execute();
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        $req = $connection->prepare("SELECT email FROM personnes WHERE email = :email");
        $req->bindParam(":email", $email);
        $req->execute();
        $resultat2 = $req->fetch(PDO::FETCH_ASSOC);

        if(isset($resultat['nom'])) //Si la personne est déjà présente dans la base de donnée
        {
            echo '<span style="color: red">ERREUR : La personne est déjà présente dans la base<br/>';
        }
        elseif(isset($resultat2['email'])) //Si le mail est déjà enrefgistré dans la base de données
        {
            echo '<span style="color: red">ERREUR : L\'Email est déjà présente dans la base<br/>';
        }
        else //Sinon on peut ajouter les données à la base
        {
            $req = $connection->prepare("INSERT INTO personnes VALUES (null, :nom, :prenom, :email)");
            $req->bindValue(":nom", $nom);
            $req->bindValue(":prenom", $prenom);
            $req->bindValue(":email", $email);

            if($req->execute())
            {
                echo '<span style="color: green">La personne à été ajoutée avec succès à la base de donnée.</span>';
            }
            else
            {
                echo '<span style="color: red">Une erreur s\'est produite, la personne n\'a pas été correctement ajoutée à la base de donnée !<br/>';
                echo $req->errorInfo()[2].'</span>';
            }
        }
    }
?>
