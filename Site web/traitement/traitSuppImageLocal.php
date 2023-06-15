<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!isset($_SESSION['idMembre']) || $_SESSION['roleMembre'] != 'Admin') {
        header('Location: ../index.php');
        exit;
    }

    if (isset($_POST['idImage'])) {
        $imageId = $_POST['idImage'];

        // Récupérez le nom de l'image à partir de la base de données
        $reqImage = $bdd->prepare("SELECT * FROM IMAGE WHERE IDIMAGE = :pImageId");
        $reqImage->execute(array(":pImageId" => $imageId));
        
        if($reqImage->rowCount() > 0) {
            // On récupère les informations de l'image
            $donneesImage = $reqImage->fetch();

            $filename = $donneesImage['NOMIMAGE'];

            // Supprimez l'image du dossier /include/imagesrssb
            $path = '../include/images/localisation/'.$filename;
            if (file_exists($path)) {
                unlink($path);
            }

            // Supprimez l'entrée de l'image de la base de données
            $reqDelete = $bdd->prepare("DELETE FROM IMAGE WHERE IDIMAGE = :pImageId");
            $reqDelete->execute(array(":pImageId" => $imageId));

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