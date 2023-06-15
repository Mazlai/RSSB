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
    <title>RSSB - Documents permanents</title>
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
                    <h1>documents permanents</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="body-content">
                <h4>Vous trouverez ci-dessous, la liste des documents permanents de l\'association.</h4>
                <br><br>

                <ul>');

                $reqPDF = $bdd->prepare("SELECT * FROM PDF WHERE FILEPATHPDF = :pFilePathPDF");
                $reqPDF->execute(array(":pFilePathPDF" => "./include/pdf/docs-perms/"));

                foreach($reqPDF as $pdfs) {

                    $nomPDF = $pdfs['FILENAMEPDF'];
                    $cheminPDF = $pdfs['FILEPATHPDF'];
                    $idPDF = $pdfs['IDPDF'];
                    $description = $pdfs['DESCRIPTIONPDF'];

                    echo('<li><p>'.$description.' : <a class="linkInfos" href="'.$cheminPDF.$nomPDF.'" target="_blank" type="application/pdf">cliquer ici</a></p>');

                        if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {
                            echo('<form action="./traitement/traitSuppPDFDocs.php" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cette image ?\')">
                                <input type="hidden" name="idPDF" value="'.$pdfs['IDPDF'].'" />
                                <input type="submit" name="supprimer" value="Supprimer" class="submit-supp"/>
                            </form>');
                        }
                    
                    echo('</li><br>');

                }

                if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {

                    if(isset($_GET['msgErreur'])){
                        echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                    }

                    echo('<form class="formImageLocal" action="./traitement/traitAddPDFDocs.php" method="post" enctype="multipart/form-data">

                        <div class="subformImageLocal">
                            <input type="file" class="addFile" name="monPDF" accept=".pdf"/>
                            <label class="description-label">Description :</label>
                            <textarea class="last-champ-contact" name="description" required maxlength="255" placeholder="255 caractères max."></textarea>
                            <input type="submit" class="submit-ajouter" name="ajouter" value="Ajouter"/>
                        </div>
                    </form>');

                }

            echo('</div>
        </div>');

    ?>

    <?php include("./include/footer.php"); ?>

</body>
</html>