<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $resultat['titre']; ?></title>
</head>
<body>  
    <header>
    <h1><a href="index.php" style="color: black" title="Accueil du site">Mon mini blog</a></h1>
        <?php require('private_header.php'); ?>
    </header>

    <?php
        require('fonctions.php');

        //Création de la connexion à la base de données
        $connexion = connexionBD();
        
        //Récupération de l'ID de l'article
        if(isset($_GET['idarticle'])){
            //Récupération de l'article demandé
            $requete = $connexion->prepare('SELECT * FROM articles WHERE ID = :id');
            $requete->bindParam(':id', $_GET['idarticle']);

            //Envoie de la requete à la base
            if($requete->execute()){ //La requête est un succès
                //Récupération du résultat
                $GLOBAL['resultat'] = $requete->fetch(PDO::FETCH_ASSOC);
            }
            else{ //La requête a échouée
                echo '<span class="error-message">ERREUR - ' . $requete->errorInfo()[2] . '</span>';
            }
        }
        else{
            echo '<h3 class="error-message">ERREUR - l\'article n\'existe pas !</h3>';
            header("refresh:3;url=index.php");
            exit;
        }
    ?>

    <div class="main-container">
        <div class="container">
            <a href="index.php" class="button">Revenir à la liste des articles</a>
        <?php
            $resultat = $GLOBAL['resultat'];
            //On vérifie que l'article existe vraiment
            if(!empty($resultat)){
                //Afficher l'article ?>
                <article id="single">
                    <h3 class="title"><?php echo $resultat['titre'] ?></h3>
                    <div class="infos">
                        <p class="auteur">Auteur : <?php echo $resultat['auteur']; ?></p>
                        <p class="date">Date : <?php echo afficherDate($resultat['date']); ?></p>
                    </div>
                    <div class="child-content">
                        <p id="p-content"><?php echo $resultat['contenu']; ?></p>
                    </div>
                    
                    <!-- Création des boutons de suppression et de modification de l'article si l'utilisateur en est l'auteur -->
                    <?php
                    if($resultat['auteur'] == $_SESSION['pseudo'] || $_SESSION['admin']){ ?>
                        <form action="supprimer.php" method="POST">
                            <input type="hidden" name="from" value="article">
                            <input type="hidden" id="idarticle" name="idarticle" value="<?php echo $_GET['idarticle']; ?>">
                            <input type="submit" class="red-button" value="Supprimer cet article">
                        </form>
                        <button id="modifier" class="blue-button">Modifier l'article</button>
                    <?php } ?>
                </article>
            <?php
            }
            else{//L'article n'existe pas
                echo "<p class=\"error-message\">ERREUR - L'article demandé n'existe pas!</p>";
            }
        ?>
        </div>
    </div>

    <footer>
        <?php include('contact_form.php'); ?>
    </footer>
    
    <!-- Script permettant la gestion du click sur le bouton "modifier article" -->
    <script>
        //Récupération du bouton
        var boutonModifierElt = document.getElementById('modifier');

        //Récupération du paragraphe affichant le contenu de l'article
        var contenuElt = document.getElementById('p-content');

        //Récupération de l'objet conteneur
        var conteneurElt = contenuElt.parentNode;

        //Récupération du contenu de l'article
        var contenuArticle = contenuElt.innerHTML;

        //Création d'un textArea
        var textAreaElt = document.createElement('textArea');
        textAreaElt.innerHTML = contenuArticle;
        textAreaElt.setAttribute("rows", 10);
        textAreaElt.setAttribute("style", "width: 100%");
        textAreaElt.setAttribute("name", "message");
        textAreaElt.setAttribute("maxlength", 250);

        //Création du formulaire permettant d'envoyer les modifications
        formElt = document.createElement('form');
        inputFromElt = document.createElement('input');
        inputIdElt = document.createElement('input');
        inputSubmitElt = document.createElement('input');

        //Paramétrage des attributs de tous les éléments créés
        formElt.setAttribute("method", "POST");
        formElt.setAttribute("action", "envoie.php");
        inputFromElt.setAttribute("type", "hidden");
        inputIdElt.setAttribute("type", "hidden");
        inputSubmitElt.setAttribute("type", "submit");
        inputFromElt.setAttribute("name", "from");
        inputIdElt.setAttribute("name", "idarticle");
        inputSubmitElt.setAttribute("value", "Valider les modifications");
        inputFromElt.setAttribute("value", "modifierArticle");
        inputIdElt.setAttribute("value", document.getElementById('idarticle').getAttribute('value'));

        //Placer tous les élément créés dans le formulaire
        formElt.appendChild(inputFromElt);
        formElt.appendChild(inputIdElt);
        formElt.appendChild(textAreaElt);
        formElt.appendChild(inputSubmitElt);

        //Implémentation de la fonction gérant le click sur le bouton "Modifier article"
        boutonModifierElt.addEventListener("click", function(){
            //Remplacement de l'élément paragraphe par un textArea pour permettre à l'utilisateur de modifier le texte
            conteneurElt.replaceChild(formElt, contenuElt);

            //Le bouton "Modifier article" change de fonction
            boutonModifierElt.textContent = "Annuler les modifications";

            //Implémentation de la nouvelle fonction du bouton
            boutonModifierElt.addEventListener("click", function(){
                //Recharger la page
                document.location.reload();
            });
        });
    </script>
</body>
</html>

