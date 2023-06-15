<?php session_start();
    

    if(isset($_SESSION['idMembre'])) {
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
            <title>RSSB - Mot de passe oublié</title>
        </head>
        <body>');

        include("./include/header.php");

        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image" src="./include/images/site/personnages.png" alt="Logo RSSB">
                </div>
                <div class="title-container">
                    <h1>mot de passe oublié</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="form-container">

                <form method="post" class="form-mdp" action="./traitement/traitMdpOublie.php">

                    <div class="subform-mdp">

                        <div class="mdp-container">
                            <label class="mdp-title">vérification</label>
                        </div>');

                        if(isset($_GET['msgErreur'])) {
                            echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                        }

                        echo('<label class="contact-labels">Votre adresse mail :</label>
                        <input type="text" class="mdp-input" name="mail" required/>

                        <div class="button-form">
                            <input type="submit" class="submit-mdp" name="Envoyer" value="Envoyer">
                        </div>

                    </div>

                </form>

            </div>

        </div>');

        include("./include/footer.php");
    }

?>

</body>
</html>