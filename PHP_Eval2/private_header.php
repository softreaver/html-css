<?php
    session_start();

    if(isset($_SESSION['pseudo'])){ 
        include('calculette.php'); ?>
        <div id="user-box" class="box">
            <h2 style="margin: 0">Bienvenue <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?></h2>
            <a class="blue-button" href="liste_utilisateurs.php">Liste des utilisateurs</a>
            <a class="red-button" href="envoie.php?disconnect">Se déconnecter</a>
        </div>
        
    <?php
    }
    else{ 
        echo "<p class=\"error-message\">ERREUR - Vous devez être connecté pour consulter cet page !</p>";
        header("refresh:3;url=index.php");
        exit;
    }
?>
