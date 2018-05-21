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
        <h1>Mon blog</h1>
    </header>
    
    <div class="main-container">
        <div class="container">
            <a href="form.php" class="button">Créer un nouvel article</a>
            <section class="articles">
                <?php
                    //Mes données
                    $DBENGINE     = "mysql";
                    $HOST         = "localhost";
                    $DBNAME       = "eval_blog";
                    $CHARSET      = "utf8";

                    try{
                        //Création de la connexion à la base de données
                        $connexion = new PDO($DBENGINE . ':host=' . $HOST . ';dbname=' . $DBNAME . ';charset=' . $CHARSET, 'root', '');
                    }
                    catch(Exception $e){
                        echo '<h3 class="error-message">ERREUR - ' . $e->getMessage() . '</h3>';
                        exit;
                    }
                    

                    //Récupérer la liste de tous les articles de la base de données
                    $requete = $connexion->prepare("SELECT ID, titre, date FROM articles ORDER BY ID DESC");
                    if($requete->execute()){//La requête a fonctionnée
                        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
                    }
                    else{//La requête a échouée
                        echo '<span class="error-message">ERREUR - ' . $requete->errorInfo() . '</span>';
                    }

                    if(isset($resultat)){
                        if(sizeof($resultat) > 0){//S'il y a au moins un article
                            //Afficher la liste des article
                            foreach($resultat as $value){?>
                                <article>
                                    <a href="article.php?idarticle=<?php echo $value['ID']; ?>">
                                        <h3 class="titre">
                                            <?php echo $value['titre']; ?>
                                        </h3>
                                    </a>
                                    <div>
                                        Créé le : <?php echo afficherDate($value['date']); ?>
                                    </div>
                                </article>
                            <?php
                            }
                        }
                        else{
                            echo '<h3>Aucun article à afficher.</h3>';
                        }
                        
                    }
                ?>
            </section>
        </div>
    </div>
</body>
</html>

<?php 
    //Converti une date au format yyyymmdd en chaine de caractère au format dd/mm/yyyy
    function afficherDate($date){
        if(gettype($date) == "string" && strlen($date) == 8 ){
            $ret = substr($date, 6) . '/' . substr($date, 4, 2) . '/' . substr($date, 0, 4);
            return $ret;
        }
        else{
            return 'Date inconnue';
        }
    }
?>
