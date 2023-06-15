<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nom-contact']) && $_POST['nom-contact'] != "" && isset($_POST['prenom-contact']) && $_POST['prenom-contact'] != "" &&
        isset($_POST['email-contact']) && $_POST['email-contact'] != "" && isset($_POST['tel-contact']) && $_POST['tel-contact'] != "" &&
        isset($_POST['sujet-contact']) && $_POST['sujet-contact'] != "" && isset($_POST['message-contact']) && $_POST['message-contact'] != "" &&
        isset($_POST['sexe']))) {
        header('Location: ../contact.php?msgErreur=Veuillez remplir tous les champs !');
        exit;
    }

    $_SESSION['contact_values'] = $_POST;
    $nomContact = htmlspecialchars($_POST['nom-contact']);
    $prenomContact = htmlspecialchars($_POST['prenom-contact']);
    $emailContact = htmlentities($_POST['email-contact']);
    $telContact = htmlentities($_POST['tel-contact']);
    $sujetContact = htmlspecialchars($_POST['sujet-contact']);
    $messageContact = htmlentities($_POST['message-contact']);
    $sexeContact = htmlentities($_POST['sexe']);

    $secret = "6LfAWSQmAAAAAJr-goX-mMK06wd9Ym9f9ktyB4ER";
    $response = htmlentities($_POST['g-recaptcha-response']);
    $remoteIP = $_SERVER['REMOTE_ADDR'];
    $request = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteIP";

    $get = file_get_contents($request);
    $decode = json_decode($get, true);

    if (!$decode['success']) {
        header('Location: ../contact.php?msgErreur=Échec de validation du captcha.');
        exit;
    }

    if (!preg_match("#^[\p{L}'\-\s]+$#u", $nomContact)) {
        header('Location: ../contact.php?msgErreur=Vérifiez la saisie de votre nom.');
        exit;
    }

    if (!preg_match("#^[\p{L}'\-\s]+$#u", $prenomContact)) {
        header('Location: ../contact.php?msgErreur=Vérifiez la saisie de votre prénom.');
        exit;
    }

    if (!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $emailContact)) {
        header('Location: ../contact.php?msgErreur=Vérifiez la saisie de votre adresse mail.');
        exit;
    }

    if (!preg_match('#^0[0-9]{9}$#', $telContact)) {
        header('Location: ../contact.php?msgErreur=Vérifiez la saisie de votre téléphone.');
        exit;
    }

    if($sexeContact == "Femme") {
        $sexeRecup = "Mme";
    } else {
        $sexeRecup = "M.";
    }

    $message = "<p>Vous avez reçu un message de la part de <strong> $sexeRecup $nomContact $prenomContact : </strong></p>
                <p><strong>Téléphone : </strong>$telContact</p>
                <p><strong>Adresse mail : </strong>$emailContact</p>
                <p><strong>Message : </strong></p>
                <p>". nl2br($messageContact) ."</p>";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= 'From: Site web - RSSB <siteweb@reseausocialsolidaireblagnac.org>' . "\r\n";
    $headers .= 'Content-Type: text/html; charset="utf-8"' . "\r\n";

    if(mail("contact@reseausocialsolidaireblagnac.org", "Demande de contact - ".utf8_decode($sujetContact), $message, $headers)) {
        echo('<script language="JavaScript" type="text/javascript"> 
            alert("Mail envoyé. Vérifiez votre boite mail."); 
            location.href = "../index.php";
        </script>');
    } else {
        header('Location: ../contact.php?msgErreur=Une erreur est survenue...');
        exit;
    }

    unset($_SESSION['contact_values']);

?>