<?php session_start();

    if(isset($_SESSION['idMembre'])) {
        header('Location: ./index.php');
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
            <title>RSSB - Intranet</title>
        </head>
        <body>');

        include("./include/header.php");

        if(isset($_COOKIE['cookieID'])) {
            $login = $_COOKIE['cookieID'];
        } else {
            $login = "";
        }

        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image" src="./include/images/site/personnages.png" alt="Logo RSSB">
                </div>
                <div class="title-container">
                    <h1>formulaire de connexion</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="form-container">

                <form method="post" id="form-intranet" action="./traitement/traitIntranet.php">

                    <div id="subform-intranet">

                        <div id="intranet-title">
                            <label id="intranet-label">s\'identifier</label>
                        </div>');

                        if(isset($_GET['msgErreur'])) {
                            echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                        }

                        echo('<label class="contact-labels">Votre adresse mail :</label>
                        <input type="text" class="intranet-inputs" name="mail-intranet" value="'.$login.'" required/>

                        <label class="contact-labels">Votre mot de passe :</label>
                        <input type="password" class="intranet-inputs" name="mdp-intranet" required/>');

                        if(isset($_COOKIE['cookieFrom'])) {

                            echo('<label id="cookieLabel">Se souvenir de moi ?</label>
                            <label id="checkboxLabel">
                                <input type="checkbox" id="checkboxInput" name="checkCookie"/>
                                <svg id="checkboxCheck">
                                    <polyline points="17 6 9 17 4 12"></polyline>
                                </svg>
                            </label>
                            <br>');
            
                        }

                        echo('<div class="button-form">
                            <input type="submit" id="submit-intranet" name="Connexion" value="Connexion">
                        </div>

                        <div id="intranet-mdp">
                            <a id="mdpoublie" href="mdpoublie.php">Mot de passe oublié ?</a>
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