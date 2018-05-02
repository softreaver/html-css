<!--Récupération des données du formulaire HTML-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="styles/bootstrap.css">
        <title>Document</title>

        <?php
        $check_form['url'] = false;
        $check_form['password'] = false;
        $check_form['password-check'] = false;
        $check_form['cms'] = false;
        $check_form['statut'] = false;

        foreach($_POST as $key => $value){
            if($value !== 'default' && $value !== ''){
                $line[$key] = $value;
                $check_form[$key] = true;
            }
        }

        //On vérifie que tous les champs obligatoires du formulaire ont bien été remplis
        foreach($check_form as $key => $value){
            if($check_form[$key] == false){
                if(!isset($error))
                    $error = '?';
                else
                    $error .= "&";

                $error .= $key;
            }
        }

        //on vérifie que les deux passwords sont identique
        if($line['password'] !== $line['password-check']){
            if(isset($error)){
                $error .= '&password-different';
            }else{
                $error = '?password-different';
            }
        }

        if(isset($error)){
            //s'il y a au moins un champ obligatoire non rempli, alors renvoyer vers le formulaire
            header("location: index.php" . $error);
            exit;
        }else{
            //Sinon j'enregistre les données
            $data[] = $line;
        } ?>
    </head>

    <body>
        <?php
        //J'affiche les données ous forme de tableau
        foreach($data as $one_line){?>
            <table class="table">
                <thead>
                    <tr class="row">
                        <th class="col-xs-5">Donnée</th>
                        <th class="col-xs-5">Valeur</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($one_line as $key => $value){?>
                    
                        <tr class="row">
                            <td class="col-xs-5">
                                <?php echo $key; ?>
                            </td>
                            <td class="col-xs-5">
                                <?php echo $value; ?>
                            </td>
                        </tr>

                    <?php }?>
                </tbody>
            </table>
        <?php }

        ?>
    </body>
</html>

    
