<?php session_start();

    if(!isset($_SESSION['idMembre'])) {
        header('Location: ./');
        exit;
    } else {

        echo('<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
            <link rel="stylesheet" href="./include/stylse.css">
            <link rel="icon" href="./include/images/site/rssb.ico">
            <title>RSSB - Modifier votre mot de passe</title>
        </head>
        <body>');

        include("./include/header.php");
    
        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image" src="./include/images/site/personnages.png" alt="Logo RSSB">
                </div>
                <div class="title-container">
                    <h1>modifier mon mot de passe</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="form-container">

                <form class="form-info" method="post" action="./traitement/traitModifMdp.php">

                    <div class="subform-info">');

                        if(isset($_GET['msgErreur'])){
                            echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                        }

                        echo('<label class="modif-labels">Votre nouveau mot de passe :</label>
                        <p id="mdp-text">- au minimum 8 caractères<br>- au moins un caractère majuscule<br>- au moins un caractère minuscule<br>- au moins un chiffre<br>- au moins un caractère spécial [#?!@$%^&*-]</p>
                        <input type="password" class="modif-inputs" name="new-mdp-modif" required minlength="8"/>

                        <label class="modif-labels">Confirmez votre mot de passe :</label>
                        <input type="password" class="modif-inputs" name="conf-mdp-modif" required minlength="8"/>

                        <div class="button-form">
                            <input type="submit" name="modifier" value="Modifier" id="submit-modif"/>
                        </div>

                    </div>

                </form>

            </div>

        </div>');

        include("./include/footer.php");

        echo('</body>
        </html>');
    }

?>