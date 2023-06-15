<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!isset($_SESSION['idMembre']) || $_SESSION['roleMembre'] != 'Admin') {
        header('Location: ../index.php');
        exit;
    }

    if (isset($_POST['idActualites'])) {
        $actualites = $_POST['idActualites'];

        // Récupérez le nom de l'image à partir de la base de données
        $reqActualites = $bdd->prepare("SELECT * FROM ACTUALITES WHERE IDACTUALITES = :pIDActualites");
        $reqActualites->execute(array(":pIDActualites" => $actualites));
        
        if($reqActualites->rowCount() > 0) {
            // On récupère les informations de l'image
            $donneesActualites = $reqActualites->fetch();

            if ($donneesActualites['NOMIMAGE'] !== null) {

                $filename = $donneesActualites['NOMIMAGE'];

                // Supprimez l'image du dossier /include/actualites
                $path = '../include/images/actualites/'.$filename;
                if (file_exists($path)) {
                    unlink($path);
                }

            }

            // Supprimez l'entrée de l'actualité de la base de données
            $reqDelete = $bdd->prepare("DELETE FROM ACTUALITES WHERE IDACTUALITES = :pIDActualites");
            $reqDelete->execute(array(":pIDActualites" => $actualites));

            // Redirigez l'utilisateur vers la page d'origine
            $reqDelete->closeCursor();
            echo('<script language="JavaScript" type="text/javascript"> 
                alert("Suppression effectuée."); 
                location.href = "../actualites.php";
            </script>');
        }

        $reqActualites->closeCursor();

    }

?>