<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!(isset($_POST['Envoyer']) && isset($_POST['mail']))) {
        header('Location: ../mdpoublie.php?msgErreur=Veuillez renseigner votre adresse mail.');
        exit;
    }

    $mailRecup = htmlentities($_POST['mail']);

    if(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $mailRecup)) {
        header('Location: ../mdpoublie.php?msgErreur=Vérifiez la saisie de votre adresse mail.');
        exit;
    }

    // On crée une requête paramétrée pour récupérer les informations de l'utilisateur à partir de son adresse mail
    $reqMembre = $bdd->prepare("SELECT * FROM MEMBRE WHERE MAILMEMBRE = :pMailMembre");
    $reqMembre->execute(array(":pMailMembre" => $mailRecup));

    // Vérifier s'il y a des lignes correspondantes dans la base de données
    if($reqMembre->rowCount() > 0) {
        // On récupère les informations de l'utilisateur
        $donneesMembre = $reqMembre->fetch();

        $mailMembre = $donneesMembre['MAILMEMBRE'];

        $token = uniqid();
        $_SESSION['token'] = $token;
        $url = "https://reseausocialsolidaireblagnac.org/token?token=$token";

        $message = "Bonjour, voici votre lien pour la réinitialisation du mot de passe : $url";
        $headers = 'From: Site web - RSSB <siteweb@reseausocialsolidaireblagnac.org>' . "\r\n";
        $headers .= 'Content-Type: text/plain; charset="utf-8"'." ";

        if(mail($mailMembre, 'Mot de passe oublié', $message, $headers)) {
            $reqSQL = $bdd->prepare("UPDATE MEMBRE SET TOKENMEMBRE = :pTokenMembre WHERE MAILMEMBRE = :pMailMembre");
            $reqSQL->execute(array(":pTokenMembre" => $token, ":pMailMembre" => $mailMembre));

            $reqSQL->closeCursor();

            echo('<script language="JavaScript" type="text/javascript"> 
                    alert("Mail envoyé. Vérifiez votre boite mail."); 
                    location.href = "../intranet.php";
                </script>');
        } else {
            header('Location: ../mdpoublie.php?msgErreur=Une erreur est survenue...');
            exit;
        }

        // On redirige l'utilisateur vers la page d'accueil de l'intranet
        $reqMembre->closeCursor();
        header('Location: ../index.php');
        exit;

    } else {
        // Il n'y a pas de lignes correspondantes dans la base de données, on affiche un message d'erreur
        $reqMembre->closeCursor();
        header('Location: ../mdpoublie.php?msgErreur=L\'adresse mail n\'est pas enregistrée dans la base de données.');
        exit;
    }

?>