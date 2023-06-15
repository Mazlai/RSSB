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
    <title>RSSB - Plan du site</title>
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
                    <h1>plan du site</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>
        
            <img id="arborescence" src="./include/images/site/Arborescence RSSB.png" alt="Arborescence">

        </div>');

    ?>

    <?php include("./include/footer.php"); ?>

</body>
</html>