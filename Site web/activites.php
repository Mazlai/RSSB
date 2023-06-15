<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="./include/stylse.css">
    <link rel="icon" href="./include/images/site/rssb.ico">
    <title>RSSB - Nos activités</title>
</head>
<body>
    <?php include("./include/header.php"); ?>

    <?php

        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image" src="./include/images/site/personnages.png" alt="Logo RSSB">
                </div>
                <div class="title-container">
                    <h1>nos activités</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="body-content">

                <p>Afin de créer du lien social et de venir en aide aux Blagnacais, le RSSB propose des activités et accompagnements variés pour différents publics.</p>
                <br>

                <h4>Si vous souhaitez en savoir plus, veuillez cliquer sur la page concernant votre statut : </h4><br>
                
                <ul>
                    <li><p><a class="linkInfos" href="personnes-agees.php">Personnes âgées</a></p></li><br>
                    <li><p><a class="linkInfos" href="adultes-familles.php">Adultes et familles</a></p></li><br>
                    <li><p><a class="linkInfos" href="jeunes.php">Jeunes</a></p></li>
                <ul>

                <br><br>
                <h4>Vous avez besoin d\'aide, vous voulez nous aider, <a class="linkInfos" href="contact.php">contactez-nous !</a></h4>

            </div>

        </div>');

    ?>

    <?php include("./include/footer.php"); ?>

</body>
</html>