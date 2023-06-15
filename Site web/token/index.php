<?php session_start(); ?>
<?php

    if(isset($_SESSION['idMembre']) || !isset($_SESSION['token'])) {
        header('Location: ../');
        exit;
    } else {
        include('../connect.inc.php');

        if(isset($_GET['token']) && $_GET['token'] != '') {
            $reqSQL = $bdd->prepare("SELECT MAILMEMBRE FROM MEMBRE WHERE TOKENMEMBRE = :pTokenMembre");
            $reqSQL->execute(array(":pTokenMembre" => $_GET['token']));

            $email = $reqSQL->fetchColumn();

            $reqSQL->closeCursor();

            if($email) {

                echo('<!DOCTYPE html>
                <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
                    <link rel="stylesheet" href="../include/stylse.css">
                    <link rel="icon" href="../include/images/site/rssb.ico">
                    <title>RSSB - Token</title>
                </head>
                <body>');

                    include("../include/header.php");

                    echo('<div class="container">

                        <div class="head-container">
                            <div class="image-title-container">
                                <img class="head-image" src="../include/images/site/personnages.png" alt="Logo RSSB">
                            </div>
                            <div class="title-container">
                                <h1>réinitialisation du mot de passe</h1>
                            </div>
                            <div class="separator-container">
                                <hr>
                            </div>
                        </div>

                        <div class="form-container">

                            <form method="post" class="form-mdp">

                                <div class="subform-mdp">

                                    <div class="mdp-container">
                                        <label class="mdp-title">mot de passe à définir</label>
                                    </div>');

                                    if(isset($_GET['msgErreur'])) {
                                        echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                                    }

                                    echo('<label class="modif-labels">Votre nouveau mot de passe :</label>
                                    <p id="mdp-text">- au minimum 8 caractères<br>- au moins un caractère majuscule<br>- au moins un caractère minuscule<br>- au moins un chiffre<br>- au moins un caractère spécial [#?!@$%^&*-]</p>
                                    <input type="password" class="modif-inputs" name="new-mdp-modif" required minlength="8"/>

                                    <label class="modif-labels">Confirmez votre mot de passe :</label>
                                    <input type="password" class="modif-inputs" name="conf-mdp-modif" required minlength="8"/>

                                    <div class="button-form">
                                        <input type="submit" class="submit-mdp" name="modifier" value="Modifier">
                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>');

                    include("../include/footer.php");

                echo('</body>
                </html>');

                if(!(isset($_POST['modifier']) && isset($_POST['new-mdp-modif']) && isset($_POST['conf-mdp-modif']))) {
                    header('Location: ./index.php?msgErreur=Veuillez remplir les champs');
                    exit;
                }

                $mdpMembre = htmlentities($_POST['new-mdp-modif']);
                $confMDP = htmlentities($_POST['conf-mdp-modif']);

                $hashedMDP = password_hash($mdpMembre, PASSWORD_DEFAULT);

                if (!preg_match('#^(?=.*?\d)(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[\#\?\!\\$%\^&\*\-]).{8,}$#', $mdpMembre)) {
                    header('Location: ./index.php?msgErreur=Vérifiez la saisie de votre mot de passe');
                    exit;
                }
            
                if($mdpMembre != $confMDP){
                    header('Location: ./index.php?msgErreur=Les mots de passe sont différents');
                    exit;
                }

                $reqMembre = $bdd->prepare("UPDATE MEMBRE
                                SET MDPMEMBRE = :pMDP,
                                TOKENMEMBRE = NULL
                                WHERE MAILMEMBRE = :pMailMembre");

                $reqMembre->execute(array(":pMDP" => $hashedMDP, ":pMailMembre" => $email));

                $reqMembre->closeCursor();

                unset($_SESSION['token']);

                echo('<script language="JavaScript" type="text/javascript"> 
                    alert("Modification réussie. Veuillez-vous connecter."); 
                    location.href = "../intranet.php";
                </script>');

            }
        } 
    }

?>
