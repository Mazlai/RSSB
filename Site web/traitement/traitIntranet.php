<?php
    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(isset($_POST['Connexion'])) {

        // Vérifier que les champs de texte ont été soumis
        if(isset($_POST['mail-intranet']) && isset($_POST['mdp-intranet'])) {

            //On récupère les valeurs renseignées par l'utilisateur dans les champs de texte
            $mailMembre = htmlentities($_POST['mail-intranet']);
            $mdpMembre = htmlentities($_POST['mdp-intranet']);

            if(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $mailMembre)) {
                header('Location: ../intranet.php?msgErreur=Vérifiez la saisie de votre adresse mail.');
                exit;
            }

            // On crée une requête paramétrée pour récupérer les informations de l'utilisateur à partir de son adresse mail
            $reqMembre = $bdd->prepare("SELECT * FROM MEMBRE WHERE MAILMEMBRE = :pMailMembre");
            $reqMembre->execute(array(":pMailMembre" => $mailMembre));

            // Vérifier s'il y a des lignes correspondantes dans la base de données
            if($reqMembre->rowCount() > 0) {
                // On récupère les informations de l'utilisateur
                $donneesMembre = $reqMembre->fetch();

                // On vérifie que le mot de passe coïncide
                if(password_verify($mdpMembre, $donneesMembre['MDPMEMBRE'])) {
                    // Le mot de passe est correct, on peut connecter l'utilisateur
                    // On enregistre les informations de l'utilisateur dans la session
                    $_SESSION['idMembre'] = $donneesMembre['IDMEMBRE'];
                    $_SESSION['nomMembre'] = $donneesMembre['NOMMEMBRE'];
                    $_SESSION['prenomMembre'] = $donneesMembre['PRENOMMEMBRE'];
                    $_SESSION['sexeMembre'] = $donneesMembre['SEXEMEMBRE'];
                    $_SESSION['roleMembre'] = $donneesMembre['ROLEMEMBRE'];
                    $_SESSION['telephoneMembre'] = $donneesMembre['TELEPHONEMEMBRE'];
                    $_SESSION['mailMembre'] = $donneesMembre['MAILMEMBRE'];
                    $_SESSION['mdpMembre'] = $donneesMembre['MDPMEMBRE'];

                    if(isset($_POST['checkCookie'])) {
                        setcookie('cookieID', $mailMembre, time()+3600, '/');
                    } else {
                        setcookie('cookieID', false, -1);
                    }

                    // On redirige l'utilisateur vers la page d'accueil de l'intranet
                    $reqMembre->closeCursor();
                    header('Location: ../');
                    exit;
                } else {
                    // Le mot de passe est incorrect, on affiche un message d'erreur
                    $reqMembre->closeCursor();
                    header('Location: ../intranet.php?msgErreur=Le mot de passe est incorrect.');
                    exit;
                }

            } else {
                // Il n'y a pas de lignes correspondantes dans la base de données, on affiche un message d'erreur
                $reqMembre->closeCursor();
                header('Location: ../intranet.php?msgErreur=L\'adresse mail n\'est pas enregistrée dans la base de données.');
                exit;
            }

        } else {
            // Les champs de texte ne sont pas corrects
            header('Location: ../intranet.php?msgErreur=Veuillez remplir les champs.');
            exit;

        }

    }

?>