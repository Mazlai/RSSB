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
    <title>RSSB - Localisation et accès</title>
</head>
<body>
    <?php include('connect.inc.php'); ?>
    <?php include("./include/header.php"); ?>

    <?php

        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image" src="./include/images/site/personnages.png" alt="Logo RSSB">
                </div>
                <div class="title-container">
                    <h1>localisation et accès</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <br>

            <div class="body-content">
                <h3>Accueil Secrétariat :</h3>
                <br>');

                $reqHoraires = $bdd->prepare("SELECT * FROM HORAIRES");
                $reqHoraires->execute();

                if($reqHoraires->rowCount() > 0) {

                    $donneesHoraires = $reqHoraires->fetch();
                    
                    $idHoraires = $donneesHoraires['IDHORAIRES'];
                    $texteHoraires = $donneesHoraires['TEXTEHORAIRES'];

                    echo('<p>'.$texteHoraires.'</p>');

                    if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {
                        echo('<form action="./traitement/traitSuppTexteLocal.php" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cette image et sa description ?\')">
                            <input type="hidden" name="idHoraires" value="'.$idHoraires.'" />
                            <input type="submit" name="suppHoraires" value="Supprimer" class="submit-supp"/>
                        </form>');
                    }
                } else {

                    if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {

                        if(isset($_GET['msgErreur'])){
                            echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                        }
    
                        echo('<form class="formImageLocal" action="./traitement/traitAddTexteLocal.php" method="post" enctype="multipart/form-data">
    
                            <div class="subformImageLocal">
                                <textarea class="last-champ-contact" name="desc-horaires" maxlength="65535"></textarea>
                                <input type="submit" class="submit-ajouter" name="add-horaires" value="Ajouter"/>
                            </div>
                        </form>');
                    }

                    echo('<p>Aucune horaire n\'a été trouvée.</p>');
                }

                echo('<br>
            </div>');

            $reqImage = $bdd->prepare("SELECT * FROM IMAGE WHERE CHEMINIMAGE = :pCheminImage");
            $reqImage->execute(array(":pCheminImage" => "./include/images/localisation/"));

            if($reqImage->rowCount() > 0) {

                $donneesImage = $reqImage->fetch();

                $nomImage = $donneesImage['NOMIMAGE'];
                $cheminImage = $donneesImage['CHEMINIMAGE'];
                $idImage = $donneesImage['IDIMAGE'];
                $descriptionImage = $donneesImage['DESCRIPTIONIMAGE'];

                echo('<div class="location-container">
                    <img id="location-image" src="'.$cheminImage.$nomImage.'" alt="Maison de Quartier">
                    <div id="location-info">
                        <p><strong>'.$descriptionImage.'</strong></p>
                    </div>');

                if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {
                    echo('<form class="button-form" action="./traitement/traitSuppImageLocal.php" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cette image et sa description ?\')">
                        <input type="hidden" name="idImage" value="'.$idImage.'" />
                        <input type="submit" name="supprimer" value="Supprimer" class="submit-supp"/>
                    </form>');
                }

                echo('</div>');

            } else {

                if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {

                    if(isset($_GET['msgErreur'])){
                        echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                    }

                    echo('<form class="formImageLocal" action="./traitement/traitAddImageLocal.php" method="post" enctype="multipart/form-data">

                        <div class="subformImageLocal">
                            <input type="file" class="addFile" name="monImage"/>
                            <label class="description-label">Description :</label>
                            <textarea class="last-champ-contact" name="description" required maxlength="255"></textarea>
                            <input type="submit" class="submit-ajouter" name="ajouter" value="Ajouter"/>
                        </div>
                    </form>');
                }

                echo('<div class="body-content">
                    <p>Aucune image n\'a été trouvée.</p>
                </div>');

            }

            echo('<div class="body-content">
                <h3>Accès :</h3>
                <br>
                <p>Tramway T1 - Arrêt Patinoire Barradels</p>
                <br>
                <h3>Contact :</h3>
                <br>
                <p>07 80 39 87 43</p>
                <p><a class="linkInfos" href="contact.php">contact@reseausocialsolidaireblagnac.org</a></p>
            </div>

        </div>');

    ?>

    <?php include("./include/footer.php"); ?>

</body>
</html>