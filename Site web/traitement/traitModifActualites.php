<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!isset($_SESSION['idMembre']) || $_SESSION['roleMembre'] != 'Admin') {
        header('Location: ../index.php');
        exit;
    }

    if(!(isset($_POST['enregistrer']) && isset($_POST['texteActualites']))) {
        header('Location: ../actualites.php?msgErreur=Veuillez saisir du texte dans le champ.');
        exit;
    }

    $idActualites = $_POST['idActualites'];
    $newTexteActualites = nl2br($_POST['texteActualites']);

    //On crée une requete paramétrée
    $reqUpdate = $bdd->prepare("UPDATE ACTUALITES
                                SET TEXTEACTUALITES = :pTexteActualites
                                WHERE IDACTUALITES= :pIdActualites");

    $reqUpdate->execute(array(":pTexteActualites" => $newTexteActualites, ":pIdActualites" => $idActualites));

    $reqUpdate->closeCursor();

    echo('<script language="JavaScript" type="text/javascript"> 
            alert("Modification du texte effectuée."); 
            location.href = "../actualites.php";
        </script>');

?>