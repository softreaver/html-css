<?php
    // Variable à afficher dans le label resultat
    $resultat = "";

    // Vérifier si l'utilisateur a cliqué sur le bouton "calculer"
    if(isset($_POST['calculer'])){
        $resultat = "ERREUR";
        //Vérifier que tous les champs sont bien définie
        if(
            (!is_null($_POST['num1']) || $_POST['num1'] == 0) &&
            (!is_null($_POST['num2']) || $_POST['num2'] == 0) &&
            (!is_null($_POST['operateur']) || $_POST['operateur'] == 0)
        ){ // Si toutes les valeurs nécessaires sont bien présentes
            $operateur  = $_POST['operateur'];
            $num1       = $_POST['num1'];
            $num2       = $_POST['num2'];

            //Appeler la fonction correspondant à l'opérateur selectionné
            switch($operateur){
                case "addition":
                    $resultat = additionner($num1, $num2);
                    break;
                case "soustraction":
                    $resultat = soustraire($num1, $num2);
                    break;
                case "division":
                    $resultat = diviser($num1, $num2);
                    break;
                case "multiplication":
                    $resultat = multiplier($num1, $num2);
                    break;
                case "modulo":
                    $resultat = modulo($num1, $num2);
                    break;
            }
            if(gettype($resultat) === 'double'){
                //Si le resultat est un nombre réel, on le limite à deux chiffres après la virgule
                $resultat = number_format($resultat, 2, ',', ' ');
            }
        }
    }
?>

<div id="calculette" class="box">
    <h3 style="margin:0">Mini calculatrice</h3>
    <!-- On met le contenu de la barre d'adresse du navigateur dans l'attribu action du formulaire -->
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']; ?>" method="POST">
        <input type="hidden" name="calculer">
        <input type="number" id="num1" name="num1" value="<?php if(isset($_POST['num1'])){ echo $_POST['num1']; } ?>" required>
        <select name="operateur" id="operateur">
            <option value="addition" <?php if(isset($_POST['operateur'])){
                    if($_POST['operateur'] == 'addition'){// Si l'opération demandé était une addition alors on selectionne l'opérateur +
                        echo 'selected';
                    }
                }else{ echo 'selected'; } ?>>+</option>
            <option value="soustraction" <?php if(isset($_POST['operateur'])){
                    if($_POST['operateur'] == 'soustraction'){ //idem que pour l'addition
                        echo 'selected';
                    }
                } ?>>-</option>
            <option value="division" <?php if(isset($_POST['operateur'])){
                    if($_POST['operateur'] == 'division'){ //idem que pour l'addition
                        echo 'selected';
                    }
                } ?>>/</option>
            <option value="multiplication" <?php if(isset($_POST['operateur'])){
                    if($_POST['operateur'] == 'multiplication'){ //idem que pour l'addition
                        echo 'selected';
                    }
                } ?>>x</option>
            <option value="modulo" <?php if(isset($_POST['operateur'])){
                    if($_POST['operateur'] == 'modulo'){ //idem que pour l'addition
                        echo 'selected';
                    }
                } ?>>mod</option>
        </select>
        <input type="number" id="num2" name="num2" value="<?php if(isset($_POST['num2'])){ echo $_POST['num2']; } ?>" required>
        <input type="submit" value="calcul">
        <label id="resultat">Resultat : <?php if(isset($resultat)){ echo $resultat; } ?></label>
    </form>
</div>

<?php // --------------------- LES FONCTIONS DE LA CALCULETTE ----------------------
    /*************************************
    *             ADDITION               *
    *************************************/
    function additionner($num1, $num2){
        return $num1 + $num2;
    }

    /*************************************
    *             SOUSTRACTION           *
    *************************************/
    function soustraire($num1, $num2){
        return $num1 - $num2;
    }

    /*************************************
    *             DIVISION               *
    *************************************/
    function diviser($num1, $num2){
        if($num2 == 0){
            return 'ERREUR';
        }
        else{
            return $num1 / $num2;
        }
    }

    /*************************************
    *          MULTIPLICATION            *
    *************************************/
    function multiplier($num1, $num2){
        return $num1 * $num2;
    }

    /*************************************
    *             MODULO                 *
    *************************************/
    function modulo($num1, $num2){
        if($num2 == 0){
            return 'ERREUR';
        }
        else{
            return $num1 % $num2;
        }
    }
?>
