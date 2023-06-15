<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!isset($_SESSION['idMembre']) || $_SESSION['roleMembre'] != 'Admin') {
        header('Location: ../index.php');
        exit;
    }

    if (isset($_POST['idPDF'])) {
        $PDFId = $_POST['idPDF'];

        // Récupérez le nom du PDF à partir de la base de données
        $reqPDF = $bdd->prepare("SELECT FILENAMEPDF FROM PDF WHERE IDPDF = :pIdPDF");
        $reqPDF->execute(array(":pIdPDF" => $PDFId));
        
        if($reqPDF->rowCount() > 0) {
            // On récupère les informations du PDF
            $donneesPDF = $reqPDF->fetch();

            $filename = $donneesPDF['FILENAMEPDF'];

            // Supprimez le PDF du dossier /include/imagesrssb
            $path = '../include/pdf/docs-perms/'.$filename;
            if (file_exists($path)) {
                unlink($path);
            }

            // Supprimez l'entrée du PDF de la base de données
            $reqDelete = $bdd->prepare("DELETE FROM PDF WHERE IDPDF = :pIdPDF");
            $reqDelete->execute(array(":pIdPDF" => $PDFId));

            // Redirigez l'utilisateur vers la page d'origine
            $reqDelete->closeCursor();
            echo('<script language="JavaScript" type="text/javascript"> 
                alert("Suppression du PDF effectuée."); 
                location.href = "../docs-permanents.php";
            </script>');
        }

        $reqPDF->closeCursor();

    }

?>