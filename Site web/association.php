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
    <title>RSSB - Notre association</title>
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
                    <h1>notre association</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="body-content">

                <p>Le Réseau Social Solidaire de Blagnac est une association créée le 18 décembre 2012, composée exclusivement de bénévoles bénéficiant régulièrement de formations.</p>
                <br>
                <p>Le Réseau, soutenu par la Mairie de Blagnac et par le Conseil Département de la Haute-Garonne, a pour objectifs :</p>
                <br>

                <ul>
                    <li><p>De créer du lien social,</p></li>
                    <li><p>De venir en aide aux Blagnacais de tous âges, isolés et/ou en situation de fragilité,</p></li>
                    <li><p>De développer le "vivre ensemble".</p></li>
                </ul>
                <br>

                <h4>Pour en savoir plus, vous trouverez ci-dessous, les différentes pages associées au RSSB : </h4><br>
                
                <ul>
                    <li><p><a class="linkInfos" href="organigramme.php">Organigramme</a></p></li><br>
                    <li><p><a class="linkInfos" href="docs-permanents.php">Documents permanents</a></p></li><br>
                    <li><p><a class="linkInfos" href="partenariats.php">Partenariats</a></p></li>
                <ul>

            </div>

        </div>');
                        
    ?>

    <?php include("./include/footer.php"); ?>

</body>
</html>