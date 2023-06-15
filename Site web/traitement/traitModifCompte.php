<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if (!(isset($_POST['modifier']) && isset($_POST['nom-modif']) && isset($_POST['prenom-modif']) && isset($_POST['sexe']))) {
        header('Location: ../modifcompte.php?msgErreur=Veuillez remplir les champs.');
        exit;
    }

    if(empty($_POST['roles'])) {
        header('Location: ../modifcompte.php?msgErreur=Sélection incorrecte.');
        exit;
    }

    $nomMembre = htmlspecialchars($_POST['nom-modif']);
    $prenomMembre = htmlspecialchars($_POST['prenom-modif']);
    $sexeMembre = htmlentities($_POST['sexe']);
    $roleMembre = htmlentities($_POST['roles']);
    $idMembre = htmlentities($_POST['idmembre']);

    if (!preg_match("#^[\p{L}'\-\s]+$#u", $prenomMembre)) {
        header('Location: ../modifcompte.php?msgErreur=Vérifiez la saisie du prénom.');
        exit;
    }

    if (!preg_match("#^[\p{L}'\-\s]+$#u", $nomMembre)) {
        header('Location: ../modifcompte.php?msgErreur=Vérifiez la saisie du nom.');
        exit;
    }

    //On crée une requete paramétrée
    $reqMembre = $bdd->prepare("UPDATE MEMBRE
                                SET PRENOMMEMBRE = :pPrenomMembre,
                                NOMMEMBRE = :pNomMembre,
                                SEXEMEMBRE = :pSexeMembre,
                                ROLEMEMBRE = :pRoleMembre
                                WHERE IDMEMBRE= :pIdMembre");

    $reqMembre->execute(array(":pPrenomMembre" => $prenomMembre, ":pNomMembre" => $nomMembre,
    ":pSexeMembre" => $sexeMembre,  ":pRoleMembre" => $roleMembre, ":pIdMembre" => $idMembre));

    $reqMembre->closeCursor();

    echo('<script language="JavaScript" type="text/javascript"> 
            alert("Modification du compte effectuée."); 
            location.href = "../compte.php";
        </script>');

?>