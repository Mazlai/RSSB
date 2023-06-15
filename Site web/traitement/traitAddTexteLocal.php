<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!isset($_SESSION['idMembre']) || $_SESSION['roleMembre'] != 'Admin') {
        header('Location: ../index.php');
        exit;
    }

    if(!isset($_POST['desc-horaires'])) {
        header('Location: ../localisation.php?msgErreur=Veuillez ajouter les horaires.');
        exit;
    }

    if (isset($_POST['add-horaires'])) {
        $descriptionHoraires = nl2br($_POST['desc-horaires']);
    
        // ... exécutez votre requête d'insertion ici
        $requeteInsert = $bdd->prepare("INSERT HORAIRES 
                                        SET TEXTEHORAIRES = :pTexteHoraires");
        $requeteInsert->execute(array(':pTexteHoraires' => $descriptionHoraires));
        $requeteInsert->closeCursor();

        echo('<script language="JavaScript" type="text/javascript"> 
            alert("Ajout effectué."); 
            location.href = "../localisation.php";
        </script>');
        exit;
    }

?>