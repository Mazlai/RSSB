<?php

    session_start();
    ini_set('display_errors', 1);
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if (!isset($_SESSION['idMembre'])) {
        header('Location: ../index.php');
        exit;
    }

    if (isset($_POST['enregistrer'])) {
        // Récupérer les valeurs des champs de texte existants
        $datesExistantes = count($_POST['date-benevolat']);

            // Préparation de la requête d'insertion
            $insertTps = $bdd->prepare("INSERT INTO BENEVOLAT (IDBENEVOLE, DATETPS, PUBLIC, BENEFICIAIRE, MOTIF, HEURESBENEVOLAT, MINUTESBENEVOLAT) VALUES (:pIdMembre, :pDateTps, :pPublic, :pBeneficiaire, :pMotif, :pHeuresBenevolat, :pMinutesBenevolat)");

            // Récupérer l'ID de l'utilisateur connecté
            $idMembre = $_SESSION['idMembre'];

            // Parcourir les valeurs des champs de texte existants et exécuter la requête pour chaque ligne
            for ($i = 0; $i < $datesExistantes; $i++) {
                $dateTps = htmlentities($_POST['date-benevolat'][$i]);
                $public = htmlspecialchars($_POST['public-benevolat'][$i]);
                $beneficiaire = htmlspecialchars($_POST['nom-benevolat'][$i]);
                $motif = htmlspecialchars($_POST['motif-benevolat'][$i]);
                $heures = htmlentities($_POST['hours'][$i]);
                $minutes = htmlentities($_POST['minutes'][$i]);

                $insertTps->execute(array(':pIdMembre' => $idMembre, 'pDateTps' => $dateTps, ':pPublic' => $public, ':pBeneficiaire' => $beneficiaire, ':pMotif' => $motif, ':pHeuresBenevolat' => $heures, ':pMinutesBenevolat' => $minutes));
            }

            $insertTps->closeCursor();

            // Redirection après l'enregistrement des données
            echo('<script language="JavaScript" type="text/javascript"> 
                alert("Enregistrement effectué."); 
                location.href = "../compte.php";
            </script>');
       
    } else {
        header('Location: ../tempsbenevolat.php?msgErreur=L\'enregistrement des données s\'est mal effectué.');
        exit;
    }
?>