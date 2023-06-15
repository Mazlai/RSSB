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
            <title>RSSB - Modifier un compte</title>
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
                    <h1>modifier un compte</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="form-container">

                <div class="form-info">

                    <form method="post">

                        <div class="subform-info">');

                            if(isset($_GET['msgErreur'])){
                                echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                            }

                            echo('<label class="modif-labels">Compte à modifier : </label>
                            <select name="comptes" id="selectCompte">');

                            $reqMembre = $bdd->prepare("SELECT * FROM MEMBRE WHERE IDMEMBRE <> :pIdMembre");
                            $reqMembre->execute(array(":pIdMembre" => $_SESSION['idMembre']));

                            foreach($reqMembre as $membre) {
                                echo('<option ');
                                if(isset($_POST['choisir']) && $membre['IDMEMBRE'] == $_POST['comptes']) {
                                    echo('selected="selected"');
                                } 
                                echo('value="'.$membre['IDMEMBRE'].'">'.$membre['NOMMEMBRE'].' '.$membre['PRENOMMEMBRE'].'</option>');
                            }

                            echo('</select>

                            <div class="button-form">
                                <input type="submit" name="choisir" value="Choisir" id="submit-choix"/>
                            </div>

                        </div>

                    </form>');

                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comptes'])) {

                        $idCompte = $_POST['comptes'];

                        $reqMembre = $bdd->prepare("SELECT * FROM MEMBRE WHERE IDMEMBRE = :pIdCompte");
                        $reqMembre->execute(array(":pIdCompte" => $idCompte));

                        $donneesMembre = $reqMembre->fetch();

                        $idMembre = $donneesMembre['IDMEMBRE'];
                        $nomMembre = $donneesMembre['NOMMEMBRE'];
                        $prenomMembre = $donneesMembre['PRENOMMEMBRE'];
                        $sexeMembre = $donneesMembre['SEXEMEMBRE'];
                        $roleMembre = $donneesMembre['ROLEMEMBRE'];

                        // On redirige l'utilisateur vers la page d'accueil de l'intranet
                        $reqMembre->closeCursor();

                        echo('<form method="post" action="./traitement/traitModifCompte.php">

                            <div class="subform-info">');

                                echo('<label class="modif-labels">Nom :</label>
                                <input type="text" class="modif-inputs" name="nom-modif" value="'.$nomMembre.'" required/>

                                <label class="modif-labels">Prénom :</label>
                                <input type="text" class="modif-inputs" name="prenom-modif" value="'.$prenomMembre.'" required/>
                            
                                <label class="modif-labels">Sexe :</label>
                                <div id="sexe-modif">');

                                    if ($sexeMembre == 'Homme') {
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

                                echo('</div>');

                                if($roleMembre == 'Admin') {

                                    echo('<label class="modif-labels">Rôle :</label>
                                    <select name="roles" id="selectRoles">
                                        <option class="optionRoles" value="Admin" selected>Admin</option>
                                        <option class="optionRoles" value="Enseignant">Enseignant</option>
                                        <option class="optionRoles" value="Benevole">Benevole</option>
                                        <option class="optionRoles" value="Adherent">Adherent</option>
                                    </select>');

                                } else if($roleMembre == 'Benevole') {

                                    echo('<label class="modif-labels">Rôle :</label>
                                    <select name="roles" id="selectRoles">
                                        <option class="optionRoles" value="Admin">Admin</option>
                                        <option class="optionRoles" value="Enseignant">Enseignant</option>
                                        <option class="optionRoles" value="Benevole" selected>Benevole</option>
                                        <option class="optionRoles" value="Adherent">Adherent</option>
                                    </select>');

                                } else if($roleMembre == 'Enseignant') {

                                    echo('<label class="modif-labels">Rôle :</label>
                                    <select name="roles" id="selectRoles">
                                        <option class="optionRoles" value="Admin">Admin</option>
                                        <option class="optionRoles" value="Enseignant" selected>Enseignant</option>
                                        <option class="optionRoles" value="Benevole">Benevole</option>
                                        <option class="optionRoles" value="Adherent">Adherent</option>
                                    </select>');


                                } else {

                                    echo('<label class="modif-labels">Rôle :</label>
                                    <select name="roles" id="selectRoles">
                                        <option class="optionRoles" value="Admin">Admin</option>
                                        <option class="optionRoles" value="Enseignant">Enseignant</option>
                                        <option class="optionRoles" value="Benevole">Benevole</option>
                                        <option class="optionRoles" value="Adherent" selected>Adherent</option>
                                    </select>');

                                }

                                echo('<input type="hidden" name="idmembre" value="'.$idMembre.'"/>');
                                
                                echo('<div class="button-form">
                                    <input type="submit" name="modifier" value="Modifier" id="submit-modif"/>
                                </div>

                            </div>

                        </form>');

                    }
                
                echo('</div>

            </div>

        </div>');

        include("./include/footer.php");

        echo('</body>
        </html>');
    }

?>        