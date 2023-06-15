<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!isset($_POST['supprimer'])) {
        header('Location: ../supprimercompte.php?msgErreur=Veuillez confirmer la suppression.');
        exit;
    }

    if(empty($_POST['comptes'])) {
        header('Location: ../supprimercompte.php?msgErreur=Sélection incorrecte.');
        exit;
    }

    $compte = htmlentities($_POST['comptes']);

    $reqMembre = $bdd->prepare("DELETE FROM MEMBRE
                                WHERE IDMEMBRE = :pIdCompte");

    $reqMembre->execute(array(":pIdCompte" => $compte));

    $reqMembre->closeCursor();

    echo('<script language="JavaScript" type="text/javascript"> 
                alert("Suppression effectuée."); 
                location.href = "../compte.php";
            </script>');

?>