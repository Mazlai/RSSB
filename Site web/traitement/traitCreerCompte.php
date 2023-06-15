<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    ini_set('display_errors', 1);
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!(isset($_POST['creer']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['sexe']) && isset($_POST['tel']) && isset($_POST['mail']) && isset($_POST['mdp']) && isset($_POST['mdp-conf']))) {
        header('Location: ../creercompte.php?msgErreur=Veuillez remplir les champs.');
        exit;
    }

    if(empty($_POST['roles'])) {
        header('Location: ../creercompte.php?msgErreur=Sélection incorrecte.');
        exit;
    }

    $nomMembre = htmlspecialchars($_POST['nom']);
    $prenomMembre = htmlspecialchars($_POST['prenom']);
    $sexeMembre = htmlentities($_POST['sexe']);
    $telMembre = htmlentities($_POST['tel']);
    $mailMembre = htmlentities($_POST['mail']);
    $mdpMembre = htmlentities($_POST['mdp']);
    $confmdpMembre = htmlentities($_POST['mdp-conf']);
    $roleMembre = htmlentities($_POST['roles']);

    $hashedMDP = password_hash($mdpMembre, PASSWORD_DEFAULT);

    if (!preg_match("#^[\p{L}'\-\s]+$#u", $prenomMembre)) {
        header('Location: ../creercompte.php?msgErreur=Vérifiez la saisie du prénom.');
        exit;
    }

    if (!preg_match("#^[\p{L}'\-\s]+$#u", $nomMembre)) {
        header('Location: ../creercompte.php?msgErreur=Vérifiez la saisie du nom.');
        exit;
    }

    if (!preg_match('#^0[0-9]{9}$#', $telMembre)) {
        header('Location: ../creercompte.php?msgErreur=Vérifiez la saisie du numéro de téléphone.');
        exit;
    }

    if (!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $mailMembre)) {
        header('Location: ../creercompte.php?msgErreur=Vérifiez la saisie de l\'adresse mail.');
        exit;
    }

    if (!preg_match('#^(?=.*?\d)(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[\#\?\!\\$%\^&\*\-]).{8,}$#', $mdpMembre)) {
        header('Location: ../creercompte.php?msgErreur=Vérifiez la saisie du mot de passe.');
        exit;
    }

    if($mdpMembre != $confmdpMembre){
        header('Location: ../creercompte.php?msgErreur=Les mots de passe sont différents.');
        exit;
    }

    $reqMembre = $bdd->prepare("SELECT * FROM MEMBRE WHERE MAILMEMBRE = :pMailMembre");
    $reqMembre->execute(array(":pMailMembre" => $mailMembre));

    if($reqMembre->rowCount() > 0) {
        $reqMembre->closeCursor();
        header('Location: ../creercompte.php?msgErreur=Adresse mail déjà existante.');
        exit;
    }

    $reqMembre->closeCursor();

    //On crée une requete paramétrée
    $reqMembre = $bdd->prepare("INSERT MEMBRE
    SET PRENOMMEMBRE = :pPrenomMembre,
    NOMMEMBRE = :pNomMembre,
    SEXEMEMBRE = :pSexeMembre,
    ROLEMEMBRE = :pRoleMembre,
    TELEPHONEMEMBRE = :pTelMembre,
    MAILMEMBRE = :pMailMembre,
    MDPMEMBRE = :pMdpMembre");

    $reqMembre->execute(array(":pPrenomMembre" => $prenomMembre, ":pNomMembre" => $nomMembre,
    ":pSexeMembre" => $sexeMembre, "pRoleMembre" => $roleMembre, ":pTelMembre" => $telMembre, 
    ":pMailMembre" => $mailMembre, "pMdpMembre" => $hashedMDP));

    $reqMembre->closeCursor();

    echo('<script language="JavaScript" type="text/javascript"> 
    alert("Inscription effectuée."); 
    location.href = "../compte.php";
    </script>');

?>