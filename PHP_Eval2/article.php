<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Détail d'un article</title>
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
                    <h3 id="titre" class="title"><?php echo $resultat['titre'] ?></h3>
                    <div class="infos">
                        <p>Auteur : <?php echo $resultat['auteur']; ?></p>
                        <p>Date : <?php echo afficherDate($resultat['date']); ?></p>
                        <?php
                            if($resultat['dateModif'] != 0){ //Si l'article à été modifié au moins une fois
                                echo '<p>Modifié le : ' . afficherDate($resultat['dateModif']) . ' par ' . $resultat['auteurModif'];
                            }
                        ?>
                    </div>
                    <div class="child-content" style="margin-top: 2em">
                        <?php
                            require_once '/htmlpurifier/library/HTMLPurifier.auto.php';

                            $config = HTMLPurifier_Config::createDefault();
                            $purifier = new HTMLPurifier($config);
                            //On enlève tous les tags interdit afin d'éviter les failles XSS
                            $clean_html = $purifier->purify($resultat['contenu']);
                        ?>
                        <div style="" id="p-content"><?php echo $clean_html; ?></div>
                    </div>
                    
                    <!-- Création des boutons de suppression et de modification de l'article si l'utilisateur en est l'auteur ou s'il est un admin-->
                    <?php
                    if($resultat['auteur'] == $_SESSION['pseudo'] || $_SESSION['admin']){ ?>
                        <form action="supprimer.php" method="POST">
                            <input type="hidden" name="from" value="article">
                            <input type="hidden" id="idarticle" name="idarticle" value="<?php echo $_GET['idarticle']; ?>">
                            <input type="hidden" id="date" name="date">
                            <input type="hidden" name="auteur" value="<?php echo $_SESSION['pseudo']; ?>">
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
    
    <script src="ckeditor/ckeditor.js"></script>
    <!-- Script permettant la gestion du click sur le bouton "modifier article" -->
    <script>
        //Ajouter le titre de l'article dans le titre de la page
        document.title = document.getElementById('titre').textContent;

        //Date du jour :
        //Ajout de la méthode toDateInputValue au prototype de la classe Date
        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
            return local.toJSON().slice(0, 10);
        });

        if(document.getElementById('date')){
            // Inscrire la date du jour dans le input
            document.getElementById('date').value = new Date().toDateInputValue();
        }

        if(document.getElementById('modifier')){
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
            textAreaElt.className = "ckeditor";
            textAreaElt.setAttribute("maxlength", 65530);
            textAreaElt.setAttribute("id", "textArea");
            textAreaElt.setAttribute("required", "true");

            //Création du formulaire permettant d'envoyer les modifications
            formElt = document.createElement('form');
            inputFromElt = document.createElement('input');
            inputIdElt = document.createElement('input');
            inputDateElt = document.createElement('input');
            inputSubmitElt = document.createElement('input');

            //Avant d'envoyer le formulaire on s'assure qu'il n'y a pas de champ remplit uniquement avec des espaces
            inputSubmitElt.addEventListener("click", function(){
                document.getElementById('textArea').innerHTML = document.getElementById('textArea').innerHTML.trim();
            });

            //Paramétrage des attributs de tous les éléments créés
            formElt.setAttribute("method", "POST");
            formElt.setAttribute("action", "envoie.php");
            inputFromElt.setAttribute("type", "hidden");
            inputIdElt.setAttribute("type", "hidden");
            inputDateElt.setAttribute("type", "hidden");
            inputSubmitElt.setAttribute("type", "submit");
            inputFromElt.setAttribute("name", "from");
            inputDateElt.setAttribute("name", "date");
            inputIdElt.setAttribute("name", "idarticle");
            inputSubmitElt.setAttribute("value", "Valider les modifications");
            inputDateElt.setAttribute("id", "date");
            inputDateElt.setAttribute("value", new Date().toDateInputValue());
            inputFromElt.setAttribute("value", "modifierArticle");
            inputIdElt.setAttribute("value", document.getElementById('idarticle').getAttribute('value'));

            //Placer tous les éléments créés dans le formulaire
            formElt.appendChild(inputFromElt);
            formElt.appendChild(inputIdElt);
            formElt.appendChild(inputDateElt);
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
        }        
    </script>
    
</body>
</html>

