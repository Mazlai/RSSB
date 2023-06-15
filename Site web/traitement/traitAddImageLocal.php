<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!isset($_SESSION['idMembre']) || $_SESSION['roleMembre'] != 'Admin') {
        header('Location: ../index.php');
        exit;
    }

    if(!isset($_POST['description'])) {
        header('Location: ../localisation.php?msgErreur=Veuillez ajouter une description pour l\'image.');
        exit;
    }

    if (isset($_POST['ajouter']) && isset($_FILES['monImage'])) {
        $extensionsAutorisees = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG');
        $dossierImages = '../include/images/localisation/';
        $nomFichier = $_FILES['monImage']['name'];
        $descriptionImage = nl2br($_POST['description']);
        $extensionFichier = strtolower(pathinfo($nomFichier, PATHINFO_EXTENSION));

        $reqVerif = $bdd->prepare("SELECT * FROM IMAGE WHERE NOMIMAGE = :pNomImage");
        $reqVerif->execute(array(':pNomImage' => $nomFichier));

        if($reqVerif->rowCount() > 0) {
            $reqVerif->closeCursor();
            header('Location: ../localisation.php?msgErreur=Image déjà existante.');
            exit;
        }

        $reqVerif->closeCursor();
    
        if (in_array($extensionFichier, $extensionsAutorisees)) {
            $nouveauNomFichier = $nomFichier; // Utilisez le nom de fichier d'origine avec l'extension
            $cheminFichier = $dossierImages.$nouveauNomFichier;
    
            if (move_uploaded_file($_FILES['monImage']['tmp_name'], $cheminFichier)) {

                // ... exécutez votre requête d'insertion ici
                $requeteInsert = $bdd->prepare("INSERT IMAGE 
                                                SET NOMIMAGE = :pNomImage,
                                                CHEMINIMAGE = :pCheminImage,
                                                DESCRIPTIONIMAGE = :pDescriptionImage");
                $requeteInsert->execute(array(':pNomImage' => $nomFichier, ':pCheminImage' => "./include/images/localisation/", ':pDescriptionImage' => $descriptionImage));
                $requeteInsert->closeCursor();

                echo('<script language="JavaScript" type="text/javascript"> 
                    alert("Ajout effectué."); 
                    location.href = "../localisation.php";
                </script>');
                exit;

            } else {
                header('Location: ../localisation.php?msgErreur=Une erreur s\'est produite lors du téléchargement de l\'image.');
                exit;
            }
        } else {
            header('Location: ../localisation.php?msgErreur=Seuls les fichiers JPG, JPEG et PNG sont autorisés.');
            exit;
        }
    }


?>