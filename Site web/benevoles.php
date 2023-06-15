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
    <title>RSSB - Bénévoles</title>
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
                    <h1>bénévoles</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="body-content">

                <div class="footer-content">

                    <p>Vous êtes intéressé(e) par notre projet et nos actions, vous souhaitez rejoindre notre équipe de bénévoles, <a class="linkInfos" href="contact.php">contactez-nous !</a></p><br>

                    <p>Vous serez reçu(e) par les membres du Bureau qui vous présenteront notre activité de manière détaillée et vous pourrez leur faire part de vos motivations et disponibilités pour devenir bénévole au sein de l’association.</p><br>

                    <p>Les interventions peuvent être ponctuelles ou récurrentes, auprès des différents publics que nous accompagnons. Vos compétences et votre intérêt sont les bienvenus ! 
                    Vous pouvez consulter la page « <a class="linkInfos" href="activites.php">Nos activités</a> » pour en savoir un peu plus …. Un temps d’observation et/ou d’intervention en binôme avec un bénévole expérimenté est toujours possible, avant de prendre un engagement définitif.</p><br>

                    <p>Votre action en tant que bénévole s’inscrira dans un projet et un travail d’équipe et se réalisera dans le respect de la « charte » conforme aux valeurs du RSSB. Voir <a class="linkInfos" href="docs-permanents.php">chartes</a>.</p><br>

                    <p>Après une période de 3 mois d’engagement, vous recevrez une carte de bénévole qui vous permettra de vous identifier si besoin sur vos lieux d’intervention.</p><br>

                    <p>Vous aurez par ailleurs la possibilité au cours de votre engagement de vous former, ou d’approfondir vos connaissances dans votre domaine de compétences. 
                    Le RSSB propose régulièrement à ses bénévoles des formations de plusieurs types, ainsi que des rencontres plus informelles qui favorisent les échanges. Pour plus d’information voir le <a class="linkInfos" href="formations.php">tableau des formations</a> proposées ces dernières années.</p>
                
                </div>

            </div>

        </div>');

    ?>

    <?php include("./include/footer.php"); ?>

</body>
</html>