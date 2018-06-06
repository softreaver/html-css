<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Profil d'un utilisateur'</title>
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
            
            //Récupération de l'ID de l'utilisateur
            if(isset($_GET['iduser'])){
                //Récupération de l'utilisateur demandé
                $requete = $connexion->prepare('SELECT pseudo, nom, prenom, email, admin FROM users WHERE ID = :id');
                $requete->bindParam(':id', $_GET['iduser']);

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
                echo '<h3 class="error-message">ERREUR - l\'utilisateur n\'existe pas !</h3>';
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
                        <h3 id="pseudo" class="title"><?php echo $resultat['pseudo'] ?></h3>
                        <div class="infos">
                            <p id="nom">Nom : <?php echo $resultat['nom']; ?></p>
                            <p id="prenom">Prénom : <?php echo $resultat['prenom']; ?></p>
                            <p>Email : <a id="email" class="exept" href="mailto:<?php echo $resultat['email']; ?>"><?php echo $resultat['email']; ?></a></p>
                            <p>Est un admin : <?php echo ($resultat['admin']) ? 'oui' : 'non'; ?></p>
                        </div>
                        
                        <!-- Création du bouton de suppression de l'utilisateur -->
                        <form action="supprimer_utilisateur.php" method="POST">
                            <input type="hidden" name="from" value="utilisateur">
                            <input type="hidden" id="iduser" name="iduser" value="<?php echo $_GET['iduser']; ?>">
                            <input type="submit" class="red-button" value="Supprimer cet utilisateur">
                        </form>
                            
                        <!-- Création du formulaire de modification de droit si l'utilisateur est lui même un admin -->
                        <?php
                        if($_SESSION['admin']){ ?>
                            <div class="box" style="width: 10em; margin: 0 auto">
                                <h3 style="margin: 0">Modification des droits</h3>
                                <form action="envoie.php" method="POST">
                                    <input type="hidden" name="from" value="changerDroit">
                                    <input type="hidden" name="iduser" value="<?php echo $_GET['iduser']; ?>">
                                    <select style="width:10em" name="statut">
                                        <option value="1" <?php echo ($resultat['admin']) ? 'selected' : ''; ?>>admin</option>
                                        <option value="0" <?php echo ($resultat['admin']) ? '' : 'selected'; ?>>standart</option>
                                    </select>
                                    <input type="submit" class="blue-button" value="Valider">
                                </form>
                            </div>
                        <?php } ?>
                    </article>

                    <!-- Bouton modifier utilisateur (si admin)-->
                    <?php if($_SESSION['admin']){ ?>
                        <button id="modifier" class="blue-button">Modifier l'utilisateur</button>
                    <?php }
                }
                else{//L'utilisateur n'existe pas
                    echo "<p class=\"error-message\">ERREUR - L'utilisateur demandé n'existe pas!</p>";
                }
            ?>
            </div>
        </div>

        <footer>
            <?php include('contact_form.php'); ?>
        </footer>

        <script>
            //Ajouter le pseudo du profil dans le titre de la page
            document.title = 'profil de ' + document.getElementById('pseudo').textContent;

            if(document.getElementById('modifier')){
                //Récupération de l'élément "Modifier l'utilisateur"
                var boutonModifierElt = document.getElementById('modifier');

                //Récupération de l'élément conteneur
                var conteneurElt = document.getElementById('single');

                //Création des input permettant les modifications
                var inputFromElt = document.createElement('input');
                var inputIdUserElt = document.createElement('input');
                var labelPseudoElt = document.createElement('label');
                var inputPseudoElt = document.createElement('input');
                var labelNomElt = document.createElement('label');
                var inputNomElt = document.createElement('input');
                var labelPrenomElt = document.createElement('label');
                var inputPrenomElt = document.createElement('input');
                var labelEmailElt = document.createElement('label');
                var inputEmailElt = document.createElement('input');
                var inputSubmitElt = document.createElement('input');
                var brElt = document.createElement('br');

                //Paramétrage des attributs
                inputFromElt.setAttribute("type", "hidden");
                inputFromElt.setAttribute("name", "from");
                inputFromElt.setAttribute("value", "modifierUtilisateur");

                inputIdUserElt.setAttribute("type", "hidden");
                inputIdUserElt.setAttribute("name", "iduser");
                inputIdUserElt.setAttribute("value", document.getElementById('iduser').getAttribute('value'));

                labelPseudoElt.setAttribute("for", "i-pseudo");
                labelPseudoElt.textContent = "Pseudo : ";
                inputPseudoElt.setAttribute("type", "text");
                inputPseudoElt.setAttribute("required", "true");
                inputPseudoElt.setAttribute("name", "pseudo");
                inputPseudoElt.setAttribute("id", "i-pseudo");    
                inputPseudoElt.setAttribute("value", document.getElementById('pseudo').textContent.substring(0));

                labelNomElt.setAttribute("for", "i-nom");
                labelNomElt.textContent = "Nom : ";
                inputNomElt.setAttribute("type", "text");
                inputNomElt.setAttribute("required", "true");
                inputNomElt.setAttribute("name", "nom");
                inputNomElt.setAttribute("id", "i-nom");    
                inputNomElt.setAttribute("value", document.getElementById('nom').textContent.substring(6));

                labelPrenomElt.setAttribute("for", "i-prenom");
                labelPrenomElt.textContent = "Prénom : ";
                inputPrenomElt.setAttribute("type", "text");
                inputPrenomElt.setAttribute("required", "true");
                inputPrenomElt.setAttribute("name", "prenom");
                inputPrenomElt.setAttribute("id", "i-prenom");    
                inputPrenomElt.setAttribute("value", document.getElementById('prenom').textContent.substring(9));

                labelEmailElt.setAttribute("for", "i-email");
                labelEmailElt.textContent = "Email : ";
                inputEmailElt.setAttribute("type", "text");
                inputEmailElt.setAttribute("required", "true");
                inputEmailElt.setAttribute("name", "email");
                inputEmailElt.setAttribute("id", "i-email");    
                inputEmailElt.setAttribute("value", document.getElementById('email').textContent.substring(0));

                inputSubmitElt.setAttribute("type", "submit");
                inputSubmitElt.setAttribute("value", "Valider les modifications");

                //Avant d'envoyer le formulaire on s'assure qu'il n'y a pas de champ remplit uniquement avec des espaces
                inputSubmitElt.addEventListener("click", function(){
                    document.getElementById('modifForm').childNodes.forEach(
                        function(elem){
                            if(elem.tagName == 'INPUT'){
                                elem.setAttribute('value', elem.getAttribute('value').replace(/^\s+|\s+$/gm,''));
                            }
                        }
                    );
                });

                //Création du formulaire de modification d'un utilisateur
                var formElt = document.createElement('form');
                formElt.setAttribute("action", "envoie.php");
                formElt.setAttribute("method", "POST");
                formElt.setAttribute("action", "envoie.php");
                formElt.setAttribute("id", "modifForm");

                formElt.appendChild(inputFromElt);
                formElt.appendChild(inputIdUserElt);
                formElt.appendChild(labelPseudoElt);
                formElt.appendChild(inputPseudoElt);
                formElt.appendChild(brElt);
                formElt.appendChild(labelNomElt);
                formElt.appendChild(inputNomElt);
                formElt.appendChild(brElt);
                formElt.appendChild(labelPrenomElt);
                formElt.appendChild(inputPrenomElt);
                formElt.appendChild(brElt);
                formElt.appendChild(labelEmailElt);
                formElt.appendChild(inputEmailElt);
                formElt.appendChild(brElt);
                formElt.appendChild(inputSubmitElt);

                //Fonction gérant le click sur le bouton "Modifier un utilisateur"
                boutonModifierElt.addEventListener("click", function(){
                    // Remplacer tous les champs par le formulaire de modification d'un utilisateur
                    conteneurElt.innerHTML = '';
                    conteneurElt.appendChild(formElt);

                    //Le bouton "Modifier utilisateur" change de fonction
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
