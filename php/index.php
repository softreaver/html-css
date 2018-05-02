<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/bootstrap.css">
    <link rel="stylesheet" href="styles/base.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <?php
            if(sizeof($_GET) > 1 && isset($_GET['password-different']))
            {
                echo '<div class="row">';
                    echo '<div class="col-xs-12 error" style="text-align: center; color: red">';
                        echo 'Les champs en rouge sont à remplir obligatoirement!';
                    echo '</div>';
                echo '</div>';
                echo '<div class="row">';
                    echo '<div class="col-xs-12 error" style="text-align: center; color: red">';
                        echo 'Les mots de passes ne sont pas identiques!';
                    echo '</div>';
                echo '</div>';
            }
            elseif(isset($_GET['password-different']))
            {
                echo '<div class="row">';
                    echo '<div class="col-xs-12 error" style="text-align: center; color: red">';
                        echo 'Les mots de passes ne sont pas identiques!';
                    echo '</div>';
                echo '</div>';
            }
            elseif(sizeof($_GET) > 0)
            {
                echo '<div class="row">';
                    echo '<div class="col-xs-12 error" style="text-align: center; color: red">';
                        echo 'Les champs en rouge sont à remplir obligatoirement!';
                    echo '</div>';
                echo '</div>';
            }
        ?>
        
        <form action="page2.php" method="POST">
            <div class="row">
                <label class="col-xs-12 col-sm-5" for="url">Site Web : </label>
                <input class="col-xs-12 col-sm-5 <?php if(isset($_GET['url'])) echo 'error';?>" type="url" name="url" id="url">
            </div>

            <div class="row">
                <label class="col-xs-12 col-sm-5" for="password">Mot de passe : </label>
                <input class="col-xs-12 col-sm-5 <?php if(isset($_GET['password'])) echo 'error';?>" type="password" name="password" id="password">
            </div>

            <div class="row">
                <label class="col-xs-12 col-sm-5" for="password-check">Confirmer mot de passe : </label>
                <input class="col-xs-12 col-sm-5 <?php if(isset($_GET['password-check'])) echo 'error';?>" type="password" name="password-check" id="password-check">
            </div>

            <div class="row">
                <label class="col-xs-12 col-sm-5">CMS :</label>
                <select  class="col-xs-12 col-sm-5 <?php if(isset($_GET['cms'])) echo 'error';?>" name="cms" id="cms">
                    <option value="default" selected>CHOISISSEZ UN CMS</option>
                    <option value="joomla">Joomla</option>
                    <option value="wordpress">Wordpress</option>
                    <option value="dropal">Dropal</option>
                    <option value="prestasheep">Prestasheep</option>
                    <option value="macento">Maçento</option>
                    <option value="html-css">HTML/CSS</option>
                    <option value="autre">Autre</option>
                </select>

            </div>

            <div class="row">
                <label class="col-xs-12 col-sm-5">Statut :</label>
                <select class="col-xs-12 col-sm-5 <?php if(isset($_GET['statut'])) echo 'error';?>" name="statut" id="statut">
                    <option value="default" selected>CHOISISSEZ UN STATUT</option>
                    <option value="dev">Dev</option>
                    <option value="prod">Prod</option>
                    <option value="desactive">Désactivé</option>
                </select>
            </div>

            <div class="row">
                <label class="col-xs-12 col-sm-12" for="desc" style="text-align: left">Déscription : </label>
                <textarea class="col-xs-12 form-control ckeditor" name="messageArea" id="messageArea" cols="30" rows="10">
                </textarea>
            </div>

            <div class="row">
                <input class="col-xs-offset-5 col-xs-2" type="submit" value="submit">
            </div>

        </form>
    </div>

    <script src="ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
            CKEDITOR.replace( 'messageArea',
            {
            customConfig : 'ckeditor/config.js',
            toolbar : 'simple'
            })
    </script> 
</body>

</html>