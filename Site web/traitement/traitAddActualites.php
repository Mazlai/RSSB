<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!isset($_SESSION['idMembre']) || $_SESSION['roleMembre'] != 'Admin') {
        header('Location: ../index.php');
        exit;
    }

    if(isset($_POST['ajouter'])) {

        // Condition 1: Si l'utilisateur souhaite ajouter à la fois une image et une actualité
        if (isset($_POST['actualites']) && $_POST['actualites'] !== "" && isset($_FILES['monImage']) && $_FILES['monImage']['name'] !== "") {

            $texteActualites = nl2br($_POST['actualites']);
            $extensionsAutorisees = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG');
            $dossierImages = '../include/images/actualites/';
            $nomFichier = $_FILES['monImage']['name'];
            $extensionFichier = strtolower(pathinfo($nomFichier, PATHINFO_EXTENSION));
    
            $reqVerif = $bdd->prepare("SELECT * FROM ACTUALITES WHERE NOMIMAGEACTUALITES = :pNomImageActualites");
            $reqVerif->execute(array(':pNomImageActualites' => $nomFichier));
    
            if($reqVerif->rowCount() > 0) {
                $reqVerif->closeCursor();
                header('Location: ../actualites.php?msgErreur=Image déjà existante.');
                exit;
            }
    
            $reqVerif->closeCursor();
        
            if (in_array($extensionFichier, $extensionsAutorisees)) {
                $nouveauNomFichier = $nomFichier; // Utilisez le nom de fichier d'origine avec l'extension
                $cheminFichier = $dossierImages.$nouveauNomFichier;
        
                if (move_uploaded_file($_FILES['monImage']['tmp_name'], $cheminFichier)) {
    
                    // ... exécutez votre requête d'insertion ici
                    $requeteInsert = $bdd->prepare("INSERT INTO ACTUALITES 
                                                    SET NOMIMAGEACTUALITES = :pNomImageActualites,
                                                    CHEMINIMAGEACTUALITES = :pCheminImageActualites,
                                                    TEXTEACTUALITES = :pTexteActualites");
                    $requeteInsert->execute(array(':pNomImageActualites' => $nomFichier, ':pCheminImageActualites' => "./include/images/actualites/", ':pTexteActualites' => $texteActualites));
                    $requeteInsert->closeCursor();
    
                    echo('<script language="JavaScript" type="text/javascript"> 
                        alert("Ajout effectué."); 
                        location.href = "../actualites.php";
                    </script>');
                    exit;
    
                } else {
                    header('Location: ../actualites.php?msgErreur=Une erreur s\'est produite lors du téléchargement de l\'image.');
                    exit;
                }
            } else {
                header('Location: ../actualites.php?msgErreur=Seuls les fichiers JPG, JPEG et PNG sont autorisés.');
                exit;
            }

        // Condition 2: Si l'utilisateur a renseigné uniquement l'actualité
        } elseif (isset($_POST['actualites']) && $_POST['actualites'] !== "" && $_FILES['monImage']['name'] === "") {
            $texteActualites = nl2br($_POST['actualites']);

            // ... exécutez votre requête d'insertion ici
            $requeteInsert = $bdd->prepare("INSERT INTO ACTUALITES 
                                            SET TEXTEACTUALITES = :pTexteActualites");
            $requeteInsert->execute(array(':pTexteActualites' => $texteActualites));
            $requeteInsert->closeCursor();

            echo('<script language="JavaScript" type="text/javascript"> 
            alert("Ajout effectué."); 
            location.href = "../actualites.php";
            </script>');
            exit;

        // Condition 3: Si l'utilisateur souhaite ajouter seulement une image    
        } elseif (empty($_POST['actualites']) && isset($_FILES['monImage']) && $_FILES['monImage']['name'] !== "") {

            $extensionsAutorisees = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG');
            $dossierImages = '../include/images/actualites/';
            $nomFichier = $_FILES['monImage']['name'];
            $extensionFichier = strtolower(pathinfo($nomFichier, PATHINFO_EXTENSION));
    
            $reqVerif = $bdd->prepare("SELECT * FROM ACTUALITES WHERE NOMIMAGEACTUALITES = :pNomImageActualites");
            $reqVerif->execute(array(':pNomImageActualites' => $nomFichier));
    
            if($reqVerif->rowCount() > 0) {
                $reqVerif->closeCursor();
                header('Location: ../actualites.php?msgErreur=Image déjà existante.');
                exit;
            }
    
            $reqVerif->closeCursor();
        
            if (in_array($extensionFichier, $extensionsAutorisees)) {
                $nouveauNomFichier = $nomFichier; // Utilisez le nom de fichier d'origine avec l'extension
                $cheminFichier = $dossierImages.$nouveauNomFichier;
        
                if (move_uploaded_file($_FILES['monImage']['tmp_name'], $cheminFichier)) {
    
                    // ... exécutez votre requête d'insertion ici
                    $requeteInsert = $bdd->prepare("INSERT INTO ACTUALITES 
                                                    SET NOMIMAGEACTUALITES = :pNomImageActualites,
                                                    CHEMINIMAGEACTUALITES = :pCheminImageActualites");
                    $requeteInsert->execute(array(':pNomImageActualites' => $nomFichier, ':pCheminImageActualites' => "./include/images/actualites/"));
                    $requeteInsert->closeCursor();
    
                    echo('<script language="JavaScript" type="text/javascript"> 
                        alert("Ajout effectué."); 
                        location.href = "../actualites.php";
                    </script>');
                    exit;
    
                } else {
                    header('Location: ../actualites.php?msgErreur=Une erreur s\'est produite lors du téléchargement de l\'image.');
                    exit;
                }
            } else {
                header('Location: ../actualites.php?msgErreur=Seuls les fichiers JPG, JPEG et PNG sont autorisés.');
                exit;
            }

        // Aucune condition correspondante, affichez un message d'erreur
        } else {
            header('Location: ../actualites.php?msgErreur=Aucune action valide effectuée.');
            exit;
        }

    }

?>