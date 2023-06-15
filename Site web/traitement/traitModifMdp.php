<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!(isset($_POST['modifier']) && isset($_POST['new-mdp-modif']) && isset($_POST['conf-mdp-modif']))) {
        header('Location: ../modifmdp.php?msgErreur=Veuillez remplir les champs.');
        exit;
    }

    $mdpMembre = htmlentities($_POST['new-mdp-modif']);
    $confMDP = htmlentities($_POST['conf-mdp-modif']);

    $hashedMDP = password_hash($mdpMembre, PASSWORD_DEFAULT);

    if (!preg_match('#^(?=.*?\d)(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[\#\?\!\\$%\^&\*\-]).{8,}$#', $mdpMembre)) {
        header('Location: ../modifmdp.php?msgErreur=Vérifiez la saisie de votre mot de passe.');
        exit;
    }

    if($mdpMembre != $confMDP){
        header('Location: ../modifmdp.php?msgErreur=Les mots de passe sont différents.');
        exit;
    }

    $idMembre = $_SESSION['idMembre'];

    $reqMembre = $bdd->prepare("UPDATE MEMBRE
                                SET MDPMEMBRE = :pMDP
                                WHERE IDMEMBRE='$idMembre'");

    $reqMembre->execute(array(":pMDP" => $hashedMDP));

    $reqMembre->closeCursor();

    session_destroy();
    
    echo('<script language="JavaScript" type="text/javascript"> 
            alert("Modification réussie. Veuillez-vous reconnecter."); 
            location.href = "../intranet.php";
        </script>');


?>