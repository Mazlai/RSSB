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
            <title>RSSB - Créer un compte</title>
        </head>
        <body>');

        include("./include/header.php");

        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image" src="./include/images/site/personnages.png" alt="Logo RSSB">
                </div>
                <div class="title-container">
                    <h1>créer un compte</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="form-container">

                <form class="form-info" method="post" action="./traitement/traitCreerCompte.php">

                    <div class="subform-info">');

                        if(isset($_GET['msgErreur'])){
                            echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                        }

                        echo('<label class="modif-labels">Nom :</label>
                            <input type="text" class="modif-inputs" name="nom" required/>

                            <label class="modif-labels">Prénom :</label>
                            <input type="text" class="modif-inputs" name="prenom" required/>

                            <label class="modif-labels">Sexe :</label>
                            <div id="sexe-modif">
                                <input type="radio" class="radio-modif" id="homme" name="sexe" value="Homme"/>
                                <label for="homme" class="sexe">Homme</label><br>
                                <input type="radio" class="radio-modif" id="femme" name="sexe" value="Femme"/>
                                <label for="femme" class="sexe">Femme</label><br>
                            </div>

                            <label class="modif-labels">Rôle :</label>
                            <select name="roles" id="selectRoles">
                                <option class="optionRoles" value="Admin">Admin</option>
                                <option class="optionRoles" value="Enseignant">Enseignant</option>
                                <option class="optionRoles" value="Benevole">Benevole</option>
                                <option class="optionRoles" value="Adherent">Adherent</option>
                            </select>

                            <label class="modif-labels">Téléphone :</label>
                            <input type="text" class="modif-inputs" name="tel" required maxlength="10"/>

                            <label class="modif-labels">Mail :</label>
                            <input type="text" class="modif-inputs" name="mail" required/>

                            <label class="modif-labels">Mot de passe (provisoire) :</label>
                            <p id="mdp-text">- au minimum 8 caractères<br>- au moins un caractère majuscule<br>- au moins un caractère minuscule<br>- au moins un chiffre<br>- au moins un caractère spécial [#?!@$%^&*-]</p>
                            <input type="password" class="modif-inputs" name="mdp" required/>

                            <label class="modif-labels">Confirmez le mot de passe :</label>
                            <input type="password" class="modif-inputs" name="mdp-conf" required/>

                            <div class="button-form">
                                <input type="submit" name="creer" value="Créer" id="submit-creer"/>
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