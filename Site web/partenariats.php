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
    <title>RSSB - Partenariats</title>
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
                    <h1>partenariats</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>');

            $reqImage = $bdd->prepare("SELECT * FROM IMAGE");
            $reqImage->execute();

            echo('<div class="body2-content">');

                if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {

                    if(isset($_GET['msgErreur'])){
                        echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                    }

                    echo('<form class="formImage" action="./traitement/traitAddImagePart.php" method="post" enctype="multipart/form-data">
                        <input type="file" class="addFile" name="monImage"/>
                        <input type="submit" class="submit-ajouter" name="ajouter" value="Ajouter"/>
                    </form>');
                }

                echo('<div id="gridImagePart">');

                    foreach($reqImage as $image) {
                        $nomImage = $image['NOMIMAGE'];
                        $cheminImage = $image['CHEMINIMAGE'];
                        $cheminDesire = './include/images/partenariats/';

                        // Vérifier si le chemin de l'image correspond au chemin désiré
                        if ($cheminImage === $cheminDesire) {
                        
                            echo('<div>
                                <img class="imgspartenaires" src="'.$cheminImage.$nomImage.'" alt="imagebd"/>');

                                if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {
                                    echo('<form action="./traitement/traitSuppImagePart.php" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cette image ?\')">
                                        <input type="hidden" name="idImage" value="'.$image['IDIMAGE'].'" />
                                        <input type="submit" name="supprimer" value="Supprimer" class="submit-supp"/>
                                    </form>');
                                }

                            echo('</div>');

                        }
                    }

                echo('</div>
            </div>

        </div>');
    ?>

    <?php include("./include/footer.php"); ?>

</body>
</html>