<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
</head>
<body>
    <div class="main-container">
        <section class="articles container">
            <a href="form.php" class="button">Créer un nouvel article</a>
            <?php
                //Création de la connexion à la base de données
                $connexion = new PDO('mysql:host=localhost;dbname=eval_blog;charset=utf8', 'root', '');

                //Récupérer la liste de tous les articles de la base de données
                $requete = $connexion->prepare("SELECT * FROM articles");
                if($requete->execute()){//La requête a fonctionnée
                    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
                }
                else{//La requête a échouée
                    echo 'ERREUR - ' . $requete->errorInfo();
                }

                if(isset($resultat)){
                    if(sizeof($resultat) > 0){//S'il y a au moins un article
                        //Afficher la liste des article
                        foreach($resultat as $value){?>
                            <article>
                                <a href="article.php?idarticle=<?php echo $value['ID']; ?>">
                                    <h3 class="titre">
                                        <?php echo $resultat['titre']; ?>
                                    </h3>
                                </a>
                                <div>
                                    <?php afficherDate($resultat['date']); ?>
                                </div>
                            </article>
                        <?php
                        }
                    }
                    else{
                        echo '<h3>Aucun artcile à afficher.</h3>';
                    }
                    
                }
            ?>
        </section>
    </div>
</body>
</html>

<?php 
    //Converti une date au format yyyymmdd en chaine de caractère au format dd/mm/yyyy
    function afficherDate($date){
        if(gettype($date) == "string" && strlen($date) == 8 ){
            $ret = substr($date, 6) . '/' . substr($date, 4, 5) . '/' . substr($date, 0, 3);
            return $ret;
        }
        else{
            return 'ERREUR';
        }
    }
?>
