<div>
    <div id="contact" class="grey-box center-content">
        <h2 style="margin-top: 0; margin-bottom: 0; align-self: center">Nous contacter</h2>

        <?php if(isset($_GET['callbackContact'])){
            echo '<p class="error-message">Vous devez renseigner tous les champs !</p>';
        } ?>

        <form action="envoie.php" method="POST">
            <input type="hidden" name="from" value="contact">
            <label for="emailFrom">Email</label>
            <input 
                type="email" 
                id="emailFrom" 
                name="email" 
                placeholder="Entrez votre mail"
                value="<?php if(isset($_GET['email'])){ echo $_GET['email']; } ?>"
                required>
            <label for="sujet">Sujet</label>
            <input 
                type="text" 
                id="sujet" 
                name="sujet" 
                placeholder="Entrez le sujet" 
                value="<?php if(isset($_GET['sujet'])){ echo $_GET['sujet']; } ?>"
                required>
            <label for="message">Entrez votre message (max 250 caractères) :</label>
            <textarea 
                name="message" 
                id="message" 
                rows="5" 
                maxlength="250"><?php if(isset($_GET['message'])){ echo $_GET['message']; } ?></textarea>
            <input id="envoyerMail" type="submit" value="Envoyer">
        </form>
    </div>
</div>

<!-- Script permetant d'éviter l'envoie multiple du même mail -->
<script>
    window.addEventListener("load", function(){
        var clicked = false;
        var bouton = document.getElementById('envoyerMail')

        bouton.addEventListener("click", function(e){
            if(!clicked){
                clicked = true;
            }
            else{
                e.preventDefault();
            }
        });
    });
</script>