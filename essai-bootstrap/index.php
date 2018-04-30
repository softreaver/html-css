<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/base.css">
    <title>Boostrat powa!</title>
</head>
<body>
    <?php
        $paragraphes[] = "Mon premier paragraphe";
        $paragraphes[] = "Mon deuxième paragraphe";
        $paragraphes[] = "Mon troisième paragraphe";
        $paragraphes[] = "Mon quatrième paragraphe";
        $paragraphes2[] = "Mon cinquième paragraphe";
        $paragraphes2[] = "Mon sixième paragraphe";
        $paragraphes2[] = "Mon septième paragraphe";
        
        for($i = 0; $i < 7; $i++){
            $texteOk[$i] = true;
        }
        $i = 0;
        $texteOk[2] = false;
        
    ?>
    <div class="container">
        <header class="row">
            <div id="logo" class="col-sm-2">
                <a href="index.html" title="Accueil du site">
                    <img src="images/eve-logo.png" alt="Logo du site">
                </a>
            </div>
            <nav id="nav-menu" class="col-sm-10">
                <ul>
                    <li><a href="#">MENU1</a></li>
                    <li><a href="#">MENU2</a></li>
                    <li><a href="#">MENU3</a></li>
                </ul>
            </nav>
        </header>

        <figure class="row">
            <img id="banner" class="col-md-12" src="images/banniere.jpg" alt="Illustration représentant une attaque massive de vaisseaux spatiaux">
        </figure>

        <section id="articles" class="row">
            <?php
                foreach($paragraphes as $value){
                    echo '<article class="col-md-3">';
                        echo '<p>';
                            if($texteOk[$i]){
                                echo $value;
                            }
                        echo '</p>';
                    echo '</article>';
                    $i++;
                }
            ?>
        </section>

        <section id="videos" class="row">
            <div class="col-lg-6 col-md-12">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/0bjTrPutt4k" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
            
            <div class="col-lg-6 col-md-12">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/-GGzLJ6OtVY" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </section>

        <section id="images" class="row">
            <div class="col-md-6">
                <img src="images/ext1.jpg" alt="Image de l'extention 1">
            </div>
            <div class="col-md-6">
                <img src="images/ext2.jpg" alt="Image de l'extention 2">
            </div>
            
        </section>

        <section id="textes" class="row">
            <?php
                foreach($paragraphes2 as $value){
                    echo '<article class="col-md-4">';
                        echo '<p>';
                            if($texteOk[$i]){
                                echo $value;
                            }
                        echo '</p>';
                    echo '</article>';
                    $i++;
                }
            ?>
        </section>

        <footer class="row">
            <img src="images/footer.jpg" alt="" id="foot" class="col-md-12">
        </footer>
    </div>
</body>
</html>
