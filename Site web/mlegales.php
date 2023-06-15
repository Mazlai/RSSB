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
    <title>RSSB - Mentions légales</title>
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
                    <h1>mentions légales</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="body-content">

                <div class="footer-content">

                    <h3>Éditeur·rice·s</h3><br>

                    <p>Le site internet <a class="linkInfos" href="https://reseausocialsolidaireblagnac.org">www.reseausocialsolidaireblagnac.org</a> est la propriété du Réseau Social Solidaire de Blagnac, Association loi 1901, reconnue d\'utilité publique.</p><br>
                    <p>Tél : 07 80 39 87 43</p><br>
                    <p>Courriel : <a class="linkInfos" href="mailto:contact@reseausocialsolidaireblagnac.org">contact@reseausocialsolidaireblagnac.org</a></p><br>

                    <h3>Hébergement</h3><br>

                    <p>IONOS <br>
                    7, place de la Gare, <br>
                    BP 70109, <br>
                    57200 Sarreguemines Cedex. <br>
                    FRANCE <br> <br>
                    <a class="linkInfos" href="https://ionos.fr">www.ionos.fr</a></p><br>

                    <h3>Développements</h3><br>

                    <p>L\'ensemble des administrateurs du Réseau Social Solidaire de Blagnac.</p>

                </div>

            </div>

        </div>');

    ?>

    <?php include("./include/footer.php"); ?>

</body>
</html>