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
            <title>RSSB - Modifier vos informations</title>
        </head>
        <body>');

        include("./include/header.php");
    
        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image" src="./include/images/site/personnages.png" alt="Logo RSSB">
                </div>
                <div class="title-container">
                    <h1>modifier mes informations</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="form-container">

                <form class="form-info" method="post" action="./traitement/traitModifInfo.php">

                    <div class="subform-info">');

                        if(isset($_GET['msgErreur'])){
                            echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                        }

                        if($_SESSION['roleMembre'] == 'Admin') {
                            
                            echo('<label class="modif-labels">Votre nom :</label>
                            <input type="text" class="modif-inputs" name="nom-modif" value="'.$_SESSION['nomMembre'].'" required/>

                            <label class="modif-labels">Votre prénom :</label>
                            <input type="text" class="modif-inputs" name="prenom-modif" value="'.$_SESSION['prenomMembre'].'" required/>');

                            // Tableau associatif pour mapper les valeurs de genre aux labels correspondants
                            $labelsGenre = array(
                            'Homme' => 'homme',
                            'Femme' => 'femme'
                            );
                            
                            echo('<label class="modif-labels">Votre sexe :</label>
                            <div id="sexe-modif">');
                            
                            if ($_SESSION['sexeMembre'] == 'Homme') {
                                echo('<input type="radio" class="radio-modif" id="homme" name="sexe" value="Homme" checked/>
                                    <label for="homme" class="sexe">Homme</label><br>
                                    <input type="radio" class="radio-modif" id="femme" name="sexe" value="Femme"/>
                                    <label for="femme" class="sexe">Femme</label><br>');
                            } else {
                                echo('<input type="radio" class="radio-modif" id="homme" name="sexe" value="Homme"/>
                                    <label for="homme" class="sexe">Homme</label><br>
                                    <input type="radio" class="radio-modif" id="femme" name="sexe" value="Femme" checked/>
                                    <label for="femme" class="sexe">Femme</label><br>');
                            }
                            
                            echo('</div>

                            <label class="modif-labels">Votre rôle :</label>
                            <input type="text" class="unmodif-inputs" name="role-modif" value="'.$_SESSION['roleMembre'].'" disabled/>

                            <label class="modif-labels">Votre téléphone :</label>
                            <input type="text" class="modif-inputs" name="tel-modif" value="'.$_SESSION['telephoneMembre'].'" required maxlength="10"/>

                            <label class="modif-labels">Votre mail :</label>
                            <input type="text" class="modif-inputs" name="mail-modif" value="'.$_SESSION['mailMembre'].'" required/>');

                        } else {

                            echo('<label class="modif-labels">Votre nom* :</label>
                            <input type="text" class="unmodif-inputs" name="nom-modif" value="'.$_SESSION['nomMembre'].'" disabled/>

                            <label class="modif-labels">Votre prénom* :</label>
                            <input type="text" class="unmodif-inputs" name="prenom-modif" value="'.$_SESSION['prenomMembre'].'" disabled/>');

                            // Tableau associatif pour mapper les valeurs de genre aux labels correspondants
                            $labelsGenre = array(
                            'Homme' => 'homme',
                            'Femme' => 'femme'
                            );
                            
                            echo('<label class="modif-labels">Votre sexe* :</label>
                            <div id="sexe-modif">');
                            
                            if ($_SESSION['sexeMembre'] == 'Homme') {
                                echo('<input type="radio" class="unradio-modif" id="homme" name="sexe" checked disabled/>
                                    <label for="homme" class="sexe">Homme</label><br>
                                    <input type="radio" class="unradio-modif" id="femme" name="sexe" disabled/>
                                    <label for="femme" class="sexe">Femme</label><br>');
                            } else {
                                echo('<input type="radio" class="unradio-modif" id="homme" name="sexe" disabled/>
                                    <label for="homme" class="sexe">Homme</label><br>
                                    <input type="radio" class="unradio-modif" id="femme" name="sexe" checked disabled/>
                                    <label for="femme" class="sexe">Femme</label><br>');
                            }
                            
                            echo('</div>

                            <label class="modif-labels">Votre rôle* :</label>
                            <input type="text" class="unmodif-inputs" name="role-modif" value="'.$_SESSION['roleMembre'].'" disabled/>

                            <label class="modif-labels">Votre téléphone :</label>
                            <input type="text" class="modif-inputs" name="tel-modif" value="'.$_SESSION['telephoneMembre'].'" required maxlength="10"/>

                            <label class="modif-labels">Votre mail :</label>
                            <input type="text" class="modif-inputs" name="mail-modif" value="'.$_SESSION['mailMembre'].'" required/>

                            <p id="rule-info">* Ces informations sont uniquement modifiables par l\'administrateur. <br> Veuillez le contacter pour toute incohérence ou erreur constatée dans vos informations.</p>');

                        }

                        echo('<div class="button-form">
                            <input type="submit" name="sauvegarder" value="Sauvegarder" id="submit-modif"/>
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