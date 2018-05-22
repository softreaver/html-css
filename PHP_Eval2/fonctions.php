<?php
//Crée une connexion à la base de données
function connexionBD(){
    //Mes données
    $DBENGINE     = "mysql";
    $HOST         = "localhost";
    $DBNAME       = "eval_blog";
    $CHARSET      = "utf8";

    try{
        //Création de la connexion avec la base de données
        $connexion = new PDO($DBENGINE . ':host=' . $HOST . ';dbname=' . $DBNAME . ';charset=' . $CHARSET, 'root', '');
    }
    catch(Exception $e){
        echo '<h3 class="error-message">ERREUR - ' . $e->getMessage() . '</h3>';
        exit;
    }
    return $connexion;
}

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

//Converti une date au format yyyy-mm-dd en chaine de caraxtère au format yyyymmdd
function convertirDate($date){
    if(gettype($date) == "string" && strlen($date) == 10 ){
        $ret = '';
        for($i = 0; $i < strlen($date); $i++){
            if($date[$i] !== '-'){
                if($date[$i] >= 0 && $date[$i] <= 9){
                    $ret .= $date[$i];
                }
                else{
                    return 'ERREUR';
                }
            }
        }
        return $ret;
    }
    else{
        return 'ERREUR';
    }
}


//Afficher la liste des darticles
function afficherListe($liste){
    foreach($liste as $value){?>
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


//Envoyer un article sur la base de donnée
function publier($titre, $date, $auteur, $contenu){
    //Création de la connexion à la base de données
    $connexion = connexionBD();

    //Préparation de la requête
    $date = (int) convertirDate($date);
    $requete = $connexion->prepare("INSERT INTO articles VALUES (null, :titre, :date, :auteur, :contenu)");
    $requete->bindParam(":titre", $titre);
    $requete->bindParam(":date", $date);
    $requete->bindParam(":auteur", $auteur);
    $requete->bindParam(":contenu", $contenu);

    //Envoie de la requête
    if($requete->execute()){//La requête est un succès
        echo '<h3 class="message">L\'article a été ajouté avec succès.</h3>';
        header("refresh:3;url=index.php");
        exit;
    }
    else{//La requête échoue
        echo '<h3 class="error-message">ERREUR - ' . $requete->errorInfo()[2] . '</h3>';
        header("refresh:5;url=index.php");
        exit;
    }
}

//Vérifier qu'un utilisateur ne soit pas déjà enregistré dans la base de données
//renvoie un true si l'utilisateur n'est pas déjà enregistré sinon false
function verifierDispo($pseudo, $email){
    //Création de la connexion à la base de données
    $connexion = connexionBD();

    //Préparation de la requête
    $requete = $connexion->prepare("SELECT pseudo, email FROM users WHERE pseudo = :pseudo AND email = :email");
    $requete->bindParam(":pseudo", $pseudo);
    $requete->bindParam(":email", $email);

    //Envoie de la requête
    if($requete->execute()){//La requête est un succès
        //Récupération des données
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);

        if($resultat['pseudo'] === $pseudo && $resultat['email'] === $email){// si on trouve un homonyme dans la base
            return false;
        }
        else{ //sinon
            return true;
        }
    }
    else{//La requête échoue
        echo '<h3 class="error-message">ERREUR - ' . $requete->errorInfo()[2] . '</h3>';
        header("refresh:5;url=index.php");
        exit;
    }
}

//Enregistrer un utilisateur en base
function enregistrerUtilisateur($nom, $prenom, $email, $pseudo, $password){
    //Connexion à la base de données
    $connexion = connexionBD();

    //Préparation de la requête
    $requete = $connexion->prepare("INSERT INTO users VALUES (null, :nom, :prenom, :email, :pseudo, :password)");
    $requete -> bindParam(":nom", $nom);
    $requete -> bindParam(":prenom", $prenom);
    $requete -> bindParam(":email", $email);
    $requete -> bindParam(":pseudo", $pseudo);
    $requete -> bindParam(":password", $password);

    //Envoie de la requête
    if($requete->execute()){//La requête est un succès
        echo '<h3 class="message">L\'utilisateur a été enregistré avec succès.</h3>';
        connecterUtilisateur($pseudo, $password);
    }
    else{//La requête échoue
        echo '<h3 class="error-message">ERREUR - ' . $requete->errorInfo()[2] . '</h3>';
        header("refresh:5;url=index.php");
        exit;
    }
}

function connecterUtilisateur($pseudo, $password){
    //Connexion à la base de données
    $connexion = connexionBD();

    //Vérifier que le login est juste
    $requete = $connexion->prepare('SELECT * FROM users WHERE pseudo = :pseudo AND password = :password');
    $requete->bindParam(":pseudo", $pseudo);
    $requete->bindParam(":password", $password);

    if($requete->execute()){

        //Récupération du resultat de la requête
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
        
        if($pseudo == $resultat['pseudo'] && $password == $resultat['password']){ //Connexion réussi
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['email'] = $resultat['email'];
            $_SESSION['nom'] = $resultat['nom'];
            $_SESSION['prenom'] = $resultat['prenom'];
            echo '<h3 class="message">Vous êtes maintenant connecté. Bonjour '. $pseudo . '</h3>';
            header("refresh:3;url=index.php");
            exit;
        }
        else { //Connexion échouée
            echo '<h3 class="error-message">ERREUR - Le pseudo ou le mot de passe est incorrecte !</h3>';
            header("refresh:5;url=index.php");
            exit;
        }
        
    }
    else{
        echo '<h3 class="error-message">ERREUR - ' . $requete->errorInfo()[2] . '</h3>';
        header("refresh:5;url=index.php");
        exit;
    }
}
?>
