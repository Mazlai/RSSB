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
    <title>RSSB - RSSB en images</title>
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
                    <h1>rssb en images</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>');

            $reqImage = $bdd->prepare("SELECT * FROM IMAGE WHERE CHEMINIMAGE = :pCheminImage ORDER BY IDIMAGE DESC");
            $reqImage->execute(array(':pCheminImage' => "./include/images/imagesrssb/"));

            echo('<div class="body2-content">');

                if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {

                    if(isset($_GET['msgErreur'])){
                        echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                    }

                    echo('<form class="formImageLocal" action="./traitement/traitAddImageRSSB.php" method="post" enctype="multipart/form-data">
                        <div class="subformImageLocal">
                            <input type="file" class="addFile" name="monImage"/>
                            <label class="description-label">Description :</label>
                            <textarea class="last-champ-contact" name="description" required maxlength="255" placeholder="255 caractères max."></textarea>
                            <input type="submit" class="submit-ajouter" name="ajouter" value="Ajouter"/>
                        </div>
                    </form>');
                }

                echo('<div id="gridImage">');

                        foreach($reqImage as $image) {
                            $nomImage = $image['NOMIMAGE'];
                            $cheminImage = $image['CHEMINIMAGE'];
                            $descriptionImage = $image['DESCRIPTIONIMAGE'];
                            
                            echo('<div id="containerImage">
                                <a href="'.$cheminImage.$nomImage.'">
                                    <img class="imgsRSSB" src="'.$cheminImage.$nomImage.'" alt="imagebd"/>
                                </a>
                                <p><i>'.$descriptionImage.'</i></p>');

                                if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {
                                    echo('<form action="./traitement/traitSuppImageRSSB.php" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cette image ?\')">
                                        <input type="hidden" name="idImage" value="'.$image['IDIMAGE'].'" />
                                        <input type="submit" name="supprimer" value="Supprimer" class="submit-supp"/>
                                    </form>');
                                }

                            echo('</div>');
                        }

                echo('</div>
            </div>
        
        </div>');

    ?>

    <?php include("./include/footer.php"); ?>

</body>
</html>