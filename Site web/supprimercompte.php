<?php session_start();

    if(!isset($_SESSION['idMembre']) || $_SESSION['roleMembre'] != 'Admin') {
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
            <title>RSSB - Supprimer un compte</title>
        </head>
        <body>');

        include('connect.inc.php');
        include("./include/header.php");

        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image" src="./include/images/site/personnages.png" alt="Logo RSSB">
                </div>
                <div class="title-container">
                    <h1>supprimer un compte</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="form-container">

                <form class="form-info" method="post" action="./traitement/traitSupprimerCompte.php">

                    <div class="subform-info">');

                        if(isset($_GET['msgErreur'])){
                            echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                        }

                        echo('<label class="modif-labels">Compte à supprimer : </label>
                        <select name="comptes" id="selectCompte">');

                        $reqMembre = $bdd->prepare("SELECT * FROM MEMBRE");
                        $reqMembre->execute();

                        foreach($reqMembre as $membre) {
                            echo('<option value="'.$membre['IDMEMBRE'].'">'.$membre['NOMMEMBRE'].' '.$membre['PRENOMMEMBRE'].'</option>');
                        }

                        echo('</select>

                        <div class="button-form">
                            <input onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce compte ?\')" type="submit" name="supprimer" value="Supprimer" class="submit-supp"/>
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