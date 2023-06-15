<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if($_SESSION['roleMembre'] == 'Admin') {

        if (!(isset($_POST['sauvegarder']) && isset($_POST['nom-modif']) && isset($_POST['prenom-modif']) && isset($_POST['sexe']) && isset($_POST['tel-modif']) && isset($_POST['mail-modif']))) {
            header('Location: ../modifinfo.php?msgErreur=Veuillez remplir les champs.');
            exit;
        }
    
        $_SESSION['prenomMembre'] = htmlspecialchars($_POST['prenom-modif']);
        $_SESSION['nomMembre'] = htmlspecialchars($_POST['nom-modif']);
        $_SESSION['sexeMembre'] = htmlentities($_POST['sexe']);
        $_SESSION['telephoneMembre'] = htmlentities($_POST['tel-modif']);
        $_SESSION['mailMembre'] = htmlentities($_POST['mail-modif']);

        if (!preg_match("#^[\p{L}'\-\s]+$#u", $_SESSION['prenomMembre'])) {
            header('Location: ../modifinfo.php?msgErreur=Vérifiez la saisie de votre prénom.');
            exit;
        }

        if (!preg_match("#^[\p{L}'\-\s]+$#u", $_SESSION['nomMembre'])) {
            header('Location: ../modifinfo.php?msgErreur=Vérifiez la saisie de votre nom.');
            exit;
        }
    
        if (!preg_match('#^0[0-9]{9}$#', $_SESSION['telephoneMembre'])) {
            header('Location: ../modifinfo.php?msgErreur=Vérifiez la saisie de votre téléphone.');
            exit;
        }
    
        if (!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_SESSION['mailMembre'])) {
            header('Location: ../modifinfo.php?msgErreur=Vérifiez la saisie de votre adresse mail.');
            exit;
        }
    
        $id = $_SESSION['idMembre'];

        $reqMembre = $bdd->prepare("SELECT * FROM MEMBRE WHERE MAILMEMBRE = :pMailMembre AND IDMEMBRE <> '$id'");
        $reqMembre->execute(array(":pMailMembre" => $_SESSION['mailMembre']));

        if($reqMembre->rowCount() > 0) {
            $reqMembre->closeCursor();
            header('Location: ../modifinfo.php?msgErreur=Adresse mail déjà existante.');
            exit;
        }

        $reqMembre->closeCursor();

        //On crée une requete paramétrée
        $reqMembre = $bdd->prepare("UPDATE MEMBRE
                                    SET PRENOMMEMBRE = :pPrenomMembre,
                                    NOMMEMBRE = :pNomMembre,
                                    SEXEMEMBRE = :pSexeMembre,
                                    TELEPHONEMEMBRE = :pTelMembre,
                                    MAILMEMBRE = :pMailMembre
                                    WHERE IDMEMBRE='$id'");
    
        $reqMembre->execute(array(":pPrenomMembre" => $_SESSION['prenomMembre'], ":pNomMembre" => $_SESSION['nomMembre'],
        ":pSexeMembre" => $_SESSION['sexeMembre'],  ":pTelMembre" => $_SESSION['telephoneMembre'], ":pMailMembre" => $_SESSION['mailMembre']));
    
        $reqMembre->closeCursor();

        if($_SESSION['sexeMembre'] == "Femme") {
            $sexeRecup = "Mme";
        } else {
            $sexeRecup = "M.";
        }

        $message = "<p>Des modifications de la part de <strong> $sexeRecup {$_SESSION['nomMembre']} {$_SESSION['prenomMembre']}</strong> ont été réalisées sur le site web.</p>
                    <p><strong>Téléphone : </strong>{$_SESSION['telephoneMembre']}</p>
                    <p><strong>Adresse mail : </strong>{$_SESSION['mailMembre']}</p>";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= 'From: Site web - RSSB <siteweb@reseausocialsolidaireblagnac.org>' . "\r\n";
        $headers .= 'Content-Type: text/html; charset="utf-8"' . "\r\n";

        if(mail("reseausocialsolidaire@gmail.com", "Modification de compte - ".$_SESSION['nomMembre']." ".$_SESSION['prenomMembre'], $message, $headers)) {
            echo('<script language="JavaScript" type="text/javascript"> 
                    alert("Modification effectuée."); 
                    location.href = "../compte.php";
                </script>');
        } else {
            header('Location: ../modifinfo.php?msgErreur=Une erreur est survenue...');
            exit;
        }

    } else {

        if (!(isset($_POST['sauvegarder']) && isset($_POST['tel-modif']) && isset($_POST['mail-modif']))) {
            header('Location: ../modifinfo.php?msgErreur=Veuillez remplir les champs.');
            exit;
        }
    
        $_SESSION['telephoneMembre'] = htmlentities($_POST['tel-modif']);
        $_SESSION['mailMembre'] = htmlentities($_POST['mail-modif']);
    
        if (!preg_match('#^0[0-9]{9}$#', $_SESSION['telephoneMembre'])) {
            header('Location: ../modifinfo.php?msgErreur=Vérifiez la saisie de votre téléphone.');
            exit;
        }
    
        if (!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_SESSION['mailMembre'])) {
            header('Location: ../modifinfo.php?msgErreur=Vérifiez la saisie de votre adresse mail.');
            exit;
        }
    
        $id = $_SESSION['idMembre'];
    
        //On crée une requete paramétrée
        $reqMembre = $bdd->prepare("UPDATE MEMBRE
                                    SET TELEPHONEMEMBRE = :pTelMembre,
                                    MAILMEMBRE = :pMailMembre
                                    WHERE IDMEMBRE='$id'");
    
        $reqMembre->execute(array(":pTelMembre" => $_SESSION['telephoneMembre'], ":pMailMembre" => $_SESSION['mailMembre']));
    
        $reqMembre->closeCursor();

        if($_SESSION['sexeMembre'] == "Femme") {
            $sexeRecup = "Mme";
        } else {
            $sexeRecup = "M.";
        }

        $message = "<p>Des modifications de la part de <strong> $sexeRecup {$_SESSION['nomMembre']} {$_SESSION['prenomMembre']}</strong> ont été réalisées sur le site web.</p>
                    <p><strong>Téléphone : </strong>{$_SESSION['telephoneMembre']}</p>
                    <p><strong>Adresse mail : </strong>{$_SESSION['mailMembre']}</p>";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= 'From: Site web - RSSB <siteweb@reseausocialsolidaireblagnac.org>' . "\r\n";
        $headers .= 'Content-Type: text/html; charset="utf-8"' . "\r\n";

        if(mail("reseausocialsolidaire@gmail.com", "Modification de compte - ".$_SESSION['nomMembre']." ".$_SESSION['prenomMembre'], $message, $headers)) {
            echo('<script language="JavaScript" type="text/javascript"> 
                    alert("Modification effectuée."); 
                    location.href = "../compte.php";
                </script>');
        } else {
            header('Location: ../modifinfo.php?msgErreur=Une erreur est survenue...');
            exit;
        }

    }  

?>