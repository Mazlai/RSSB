<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!isset($_SESSION['idMembre']) || $_SESSION['roleMembre'] != 'Admin') {
        header('Location: ../index.php');
        exit;
    }

    if (isset($_POST['idHoraires'])) {
        $idHoraires = $_POST['idHoraires'];

        // Récupérez le nom de l'image à partir de la base de données
        $reqHoraires = $bdd->prepare("SELECT * FROM HORAIRES WHERE IDHORAIRES = :pIdHoraires");
        $reqHoraires->execute(array(":pIdHoraires" => $idHoraires));
        
        if($reqHoraires->rowCount() > 0) {
            // On récupère les informations de l'image
            $donneesImage = $reqHoraires->fetch();

            // Supprimez l'entrée de l'image de la base de données
            $reqDelete = $bdd->prepare("DELETE FROM HORAIRES WHERE IDHORAIRES = :pIdHoraires");
            $reqDelete->execute(array(":pIdHoraires" => $idHoraires));

            // Redirigez l'utilisateur vers la page d'origine
            $reqDelete->closeCursor();
            echo('<script language="JavaScript" type="text/javascript"> 
                alert("Suppression effectuée."); 
                location.href = "../localisation.php";
            </script>');
        }

        $reqImage->closeCursor();

    }

?>