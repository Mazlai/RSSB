<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="./include/stylse.css">
    <link rel="icon" href="./include/images/site/rssb.ico">
    <title>RSSB - Contact</title>
</head>
<body>
    <?php include("./include/header.php"); ?>

    <?php
    
        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image" src="./include/images/site/personnages.png" alt="Logo RSSB">
                </div>
                <div class="title-container">
                    <h1>contact</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="form-container">

                <form method="post" id="form-contact" action="./traitement/traitContact.php">

                    <div id="subform-contact">');

                        if(isset($_GET['msgErreur'])) {
                            echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                        }

                        $nomContact = '';
                        $prenomContact = '';
                        $sexeContact = '';
                        $emailContact = '';
                        $telContact = '';
                        $sujetContact = '';
                        $messageContact = '';

                        if (isset($_SESSION['contact_values'])) {

                            $contactValues = $_SESSION['contact_values'];

                            // Récupérer les valeurs de la session
                            $nomContact = isset($contactValues['nom-contact']) ? $contactValues['nom-contact'] : '';
                            $prenomContact = isset($contactValues['prenom-contact']) ? $contactValues['prenom-contact'] : '';
                            $sexeContact = isset($contactValues['sexe']) ? $contactValues['sexe'] : '';
                            $emailContact = isset($contactValues['email-contact']) ? $contactValues['email-contact'] : '';
                            $telContact = isset($contactValues['tel-contact']) ? $contactValues['tel-contact'] : '';
                            $sujetContact = isset($contactValues['sujet-contact']) ? $contactValues['sujet-contact'] : '';
                            $messageContact = isset($contactValues['message-contact']) ? $contactValues['message-contact'] : '';

                            echo('<label class="contact-labels">Votre nom :</label>
                            <input type="text" class="contact-inputs" name="nom-contact" required minlength="2" value="'.$nomContact.'"/>

                            <label class="contact-labels">Votre prénom :</label>
                            <input type="text" class="contact-inputs" name="prenom-contact" required minlength="2" value="'.$prenomContact.'"/>

                            <label class="contact-labels">Votre sexe :</label>
                            <div id="sexe-contact">
                                <input type="radio" class="radio-contact" id="homme" name="sexe" value="Homme" required');
                                if ($sexeContact === 'Homme') {
                                    echo(' checked');
                                }
                                echo('>
                                <label for="homme" class="sexe">Homme</label><br>
                                <input type="radio" class="radio-contact" id="femme" name="sexe" value="Femme" required');
                                if ($sexeContact === 'Femme') {
                                    echo(' checked');
                                }
                                echo('>
                                <label for="femme" class="sexe">Femme</label><br>
                            </div>

                            <label class="contact-labels">Votre email :</label>
                            <input type="email" class="contact-inputs" name="email-contact" required minlength="5" value="'.$emailContact.'"/>

                            <label class="contact-labels">Votre téléphone :</label>
                            <input type="tel" class="contact-inputs" name="tel-contact" required maxlength="10" value="'.$telContact.'"/>

                            <label class="contact-labels">Votre objet :</label>
                            <input type="text" class="contact-inputs" name="sujet-contact" required minlength="2" value="'.$sujetContact.'"/>

                            <label class="contact-labels">Votre message :</label>
                            <textarea class="last-champ-contact" name="message-contact" required maxlength="65535">'.$messageContact.'</textarea>');

                        } else {

                            echo('<label class="contact-labels">Votre nom :</label>
                            <input type="text" class="contact-inputs" name="nom-contact" required minlength="2"/>

                            <label class="contact-labels">Votre prénom :</label>
                            <input type="text" class="contact-inputs" name="prenom-contact" required minlength="2"/>

                            <label class="contact-labels">Votre sexe :</label>
                            <div id="sexe-contact">
                                <input type="radio" class="radio-contact" id="homme" name="sexe" value="Homme" required>
                                <label for="homme" class="sexe">Homme</label><br>
                                <input type="radio" class="radio-contact" id="femme" name="sexe" value="Femme" required>
                                <label for="femme" class="sexe">Femme</label><br>
                            </div>

                            <label class="contact-labels">Votre email :</label>
                            <input type="email" class="contact-inputs" name="email-contact" required minlength="5"/>

                            <label class="contact-labels">Votre téléphone :</label>
                            <input type="tel" class="contact-inputs" name="tel-contact" required maxlength="10"/>

                            <label class="contact-labels">Votre objet :</label>
                            <input type="text" class="contact-inputs" name="sujet-contact" required minlength="2"/>

                            <label class="contact-labels">Votre message :</label>
                            <textarea class="last-champ-contact" name="message-contact" required maxlength="65535"></textarea>');
                        }    

                        echo('<div class="button-form">
                            <button type="submit" id="submit-contact" class="g-recaptcha"
                                    data-sitekey="6LfAWSQmAAAAAEjscfcCIfK5KTTx7wLETE2b1FjM" 
                                    data-callback="onSubmit"
                                    data-action="submit">Envoyer</button>
                        </div>

                    </div>

                </form>

                <script>
                    function onSubmit(token) {
                    document.getElementById("form-contact").submit();
                    }
                </script>
                <script src="https://www.google.com/recaptcha/api.js"></script>

            </div>

        </div>');

    ?>

    <?php include("./include/footer.php"); ?>

</body>
</html>