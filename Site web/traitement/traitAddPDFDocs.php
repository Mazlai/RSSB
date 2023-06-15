<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!isset($_SESSION['idMembre']) || $_SESSION['roleMembre'] != 'Admin') {
        header('Location: ../index.php');
        exit;
    }

    if (isset($_POST['ajouter']) && isset($_FILES['monPDF'])) {
        $dossierPDF = '../include/pdf/docs-perms/';
        $nomFichier = $_FILES['monPDF']['name'];
        $descriptionPDF = htmlentities($_POST['description']);
        $extensionFichier = strtolower(pathinfo($nomFichier, PATHINFO_EXTENSION));

        $reqVerif = $bdd->prepare("SELECT * FROM PDF WHERE FILENAMEPDF = :pFileNamePDF");
        $reqVerif->execute(array(':pFileNamePDF' => $nomFichier));

        if($reqVerif->rowCount() > 0) {
            $reqVerif->closeCursor();
            header('Location: ../docs-permanents.php?msgErreur=PDF déjà existante.');
            exit;
        }

        $reqVerif->closeCursor();
    
        if ($extensionFichier == 'pdf') {
            $nouveauNomFichier = $nomFichier; // Utilisez le nom de fichier d'origine avec l'extension
            $cheminFichier = $dossierPDF.$nouveauNomFichier;
    
            if (move_uploaded_file($_FILES['monPDF']['tmp_name'], $cheminFichier)) {

                // ... exécutez votre requête d'insertion ici
                $requeteInsert = $bdd->prepare("INSERT PDF 
                                                SET FILENAMEPDF = :pFileNamePDF,
                                                FILEPATHPDF = :pFilePathPDF,
                                                DESCRIPTIONPDF = :pDescriptionPDF");
                $requeteInsert->execute(array(':pFileNamePDF' => $nomFichier, ':pFilePathPDF' => "./include/pdf/docs-perms/", ':pDescriptionPDF' => $descriptionPDF));
                $requeteInsert->closeCursor();

                echo('<script language="JavaScript" type="text/javascript"> 
                    alert("Ajout du PDF effectué."); 
                    location.href = "../docs-permanents.php";
                </script>');
                exit;

            } else {
                header('Location: ../docs-permanents.php?msgErreur=Une erreur s\'est produite lors du téléchargement du PDF.');
                exit;
            }
        } else {
            header('Location: ../docs-permanents.php?msgErreur=Seuls les fichiers PDFs sont autorisés.');
            exit;
        }
    }

?>