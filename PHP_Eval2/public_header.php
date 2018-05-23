<?php
    session_start();

    if(isset($_SESSION['pseudo'])){
        header('location:liste_articles.php');
        exit;
    }
?>