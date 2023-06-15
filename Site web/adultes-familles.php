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
    <title>RSSB - Adultes et familles</title>
</head>
<body>
    <?php include('connect.inc.php'); ?>
    <?php include("./include/header.php"); ?>

    <?php

        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image-single" src="./include/images/site/adultesfamilles.png" alt="Logo Adultes">
                </div>
                <div class="title-container">
                    <h1 id="head-title1">adultes et familles</h1>
                </div>
                <div class="separator-container">
                    <hr id="head-separator1">
                </div>
            </div>');

            $reqPDF = $bdd->prepare("SELECT * FROM PDF WHERE FILEPATHPDF = :pFilePathPDF");
            $reqPDF->execute(array(":pFilePathPDF" => "./include/pdf/adultes/"));

            if($reqPDF->rowCount() > 0) {

                $donneesPDF = $reqPDF->fetch();

                $nomPDF = $donneesPDF['FILENAMEPDF'];
                $cheminPDF = $donneesPDF['FILEPATHPDF'];
                $idPDF = $donneesPDF['IDPDF'];

                if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {
                    echo('<form class="button-form" action="./traitement/traitSuppPDFAdultes.php" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer ce PDF ?\')">
                        <input type="hidden" name="idPDF" value="'.$idPDF.'" />
                        <input type="submit" name="supprimer" value="Supprimer" class="submit-supp"/>
                    </form>');
                }

                echo('<div class="container-pdf">
                    <embed class="pdf-embed" src="'.$cheminPDF.$nomPDF.'" type="application/pdf">
                </div>');

                echo('<div class="download-pdf">
                    <a class="button-pdf" href="'.$cheminPDF.$nomPDF.'" target="_blank" type="application/pdf">Visualiser ici</a>
                </div>');

            } else {

                if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {

                    if(isset($_GET['msgErreur'])){
                        echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                    }

                    echo('<div class="body2-content">
                        <form class="formImage" action="./traitement/traitAddPDFAdultes.php" method="post" enctype="multipart/form-data">
                            <input type="file" class="addFile" name="pdfFile" accept=".pdf"/>
                            <input type="submit" class="submit-ajouter" name="ajouter" value="Ajouter"/>
                        </form>
                    </div>');
                }

                echo('<div class="body-content">
                    <p>Aucun PDF n\'a été trouvé.</p>
                </div>');

            }

        echo('</div>');

    ?>

    <?php include("./include/footer.php"); ?>

</body>
</html>