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
            <title>RSSB - Compte</title>
        </head>
        <body>');

        include("./include/header.php");

        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image" src="./include/images/site/personnages.png" alt="Logo RSSB">
                </div>
                <div class="title-container">
                    <h1>mon compte</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div id="compte-container">

                <div id="compte-subcontainer">

                    <div id="head-title">

                        <div id="title-frame">
                            <img id="imageProfile" src="./include/images/site/customer.png" alt="compte"/>
                        </div>

                        <div id="title-info">
                            <h2>Bonjour '.$_SESSION['prenomMembre'].' '.$_SESSION['nomMembre'].'.</h2><br>
                            <h2>Vous êtes '.$_SESSION['roleMembre'].'.<h2>
                        </div>

                    </div>

                    <div id="infos-compte">');

                        if($_SESSION['roleMembre'] == 'Benevole' || $_SESSION['roleMembre'] == 'Admin') {
                            echo('<h2><a class="options-compte" href="tempsbenevolat.php">&#x279C; Temps de bénévolat</a></h2><br>
                            <h2><a class="options-compte" href="actualites.php">&#x279C; Actualités</a></h2><br>');
                        }

                        echo('<h2><a class="options-compte" href="modifinfo.php">&#x279C; Modifier vos informations</a></h2><br>
                        <h2><a class="options-compte" href="modifmdp.php">&#x279C; Modifier votre mot de passe</a></h2><br>');

                        if($_SESSION['roleMembre'] == 'Admin') {
                            echo('<h2><a class="options-compte" href="creercompte.php">&#x279C; Créer un compte</a></h2><br>
                            <h2><a class="options-compte" href="supprimercompte.php">&#x279C; Supprimer un compte</a></h2><br>
                            <h2><a class="options-compte" href="modifcompte.php">&#x279C; Modifier un compte</a></h2>');
                        }

                    echo('</div>

                    <form method="POST" class="button-form" action="./traitement/deconnexion.php">
                        <input type="submit" id="deconnexion" name="Deconnexion" value="Déconnexion">
                    </form>

                </div>

            </div>

        </div>');

        include("./include/footer.php");

        echo('</body>
        </html>');
    }

?>