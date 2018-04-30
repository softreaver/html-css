<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Résultat du formulaire</title>
</head>
<body>
    <?php
        foreach($_GET as $key => $value){
            switch($key){
                case "prenom":
                    $prenom = $value;
                break;
                case "nom":
                    $nom = $value;
                break;
                case "age":
                    $age = $value;
                break;
                case "email":
                    $email = $value;
                break;
            }
        }

        echo 'Le formulaire :<br/><br/>';
        echo 'Prénom = '; echo (isset($prenom))? $prenom : 'INCONNU'; echo '<br/>';
        echo 'Nom = '; echo (isset($nom))? $nom : 'INCONNU'; echo '<br/>';
        echo 'Age = '; echo (isset($age))? $age : 'INCONNU'; echo '<br/>';
        echo 'Mail = '; echo (isset($email))? $email : 'INCONNU'; echo '<br/>';
        echo 'Adresse page précédente = '; echo (isset($_SERVER['HTTP_REFERER']))? $_SERVER['HTTP_REFERER'] : 'INCONNU'; echo '<br/>';

        if(isset($email) && isset($_GET['mailing'])){
            $message = "Voici le formulaire :
            Prenom = ".$prenom."
            Nom = ".$nom."
            Age = ".$age;
            if(mail($email, "Mon formulaire", $message)){
                echo "Mail envoyé";
            }else{
                echo "erreur !";
            }
        }
    ?>
</body>
</html>