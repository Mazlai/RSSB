<?php session_start();?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <link rel="stylesheet" href="./include/stylse.css">
    <link rel="icon" href="./include/images/site/rssb.ico">
    <title>RSSB - Accueil</title>
    <script src="script.js" defer></script>
</head>
<body>
    <?php include("./include/header.php"); ?>

    <?php
    
        echo('<div class="container">

            <div id="subcontainer-carrousel">

                <div id="container-carrousel">
                    <img class="images-carrousel" src="./include/images/site/nuage-de-mots.png" alt="wordcloud">
                    <img class="images-carrousel" src="./include/images/site/old-carrousel.jpg" alt="old">
                    <img class="images-carrousel" src="./include/images/site/ecriture-carrousel.png" alt="plume">
                    <img class="images-carrousel" src="./include/images/site/generations-carrousel.jpg" alt="family">
                    <img class="images-carrousel" src="./include/images/site/pools-carrousel.jpg" alt="pool">
                    <img class="images-carrousel" src="./include/images/site/together-carrousel.jpg" alt="together">
                    <img class="images-carrousel" src="./include/images/site/demarches-carrousel.jpg" alt="demarches">
                    <img class="images-carrousel" src="./include/images/site/expos-carrousel.jpg" alt="expo">
                    <img class="images-carrousel" src="./include/images/site/devoir-carrousel.jpg" alt="devoirs">
                    <img class="images-carrousel" src="./include/images/site/langues-carrousel.jpg" alt="langues">
                    <img class="images-carrousel" src="./include/images/site/jeux-carrousel.jpg" alt="jeux">
                </div>
            
            </div>');

            //<span id="counter"></span>

        echo('</div>
        
        <div id="cookContainer">
            <div id="cookieTitle">
                <i class="bx bx-cookie"></i>
                <h3>Consentement aux cookies</h3>
            </div>

            <div id="dataCookie">
                <p>Ce site web utilise des cookies pour vous aider à avoir une expérience de navigation supérieure et plus pertinente sur le site web.</p><br>
                <p><a href="confidentialite.php">En savoir plus...</a></p>
            </div>

            <div id="buttonsContainer">
                <button class="buttonCookie" id="acceptBtn">Accepter</button>
                <button class="buttonCookie" id="declineBtn">Décliner</button>
            </div>
        </div>');

    ?>

    <?php include("./include/footer.php"); ?>

    <script>
        // Sélectionnez les images du carrousel
        const images = document.querySelectorAll('.images-carrousel');

        // Durée d'affichage en millisecondes pour chaque image
        const displayDuration = 1500;

        // Index de l'image actuellement visible
        let currentIndex = 0;

        // Fonction pour afficher l'image suivante
        function afficherImageSuivante() {
            // Masquez l'image actuelle en réduisant progressivement l'opacité
            let opacity = 1;
            const fadeOutInterval = setInterval(() => {
                opacity -= 0.01;
                images[currentIndex].style.opacity = opacity;
                if (opacity <= 0) {
                    clearInterval(fadeOutInterval);
                    images[currentIndex].style.display = 'none';

                    // Calculer l'index de l'image suivante
                    currentIndex = (currentIndex + 1) % images.length;

                    // Affichez l'image suivante en augmentant progressivement l'opacité
                    let opacity = 0;
                    images[currentIndex].style.display = 'block';
                    images[currentIndex].style.opacity = opacity;
                    const fadeInInterval = setInterval(() => {
                        opacity += 0.01;
                        images[currentIndex].style.opacity = opacity;
                        if (opacity >= 1) {
                            clearInterval(fadeInInterval);
                            // Planifiez l'affichage de l'image suivante après la durée spécifiée
                            setTimeout(afficherImageSuivante, displayDuration);
                        }
                    }, displayDuration / 100);
                }
            }, displayDuration / 100);
        }

        // Attendez que le DOM soit chargé avant d'exécuter le code
        document.addEventListener('DOMContentLoaded', function() {
            // Masquez toutes les images sauf la première
            for (let i = 1; i < images.length; i++) {
                images[i].style.display = 'none';
            }

            // Afficher instantanément la première image en définissant l'opacité à 1
            images[0].style.opacity = 1;

            // Planifiez l'affichage de l'image suivante après la durée spécifiée
            setTimeout(afficherImageSuivante, displayDuration);
        });

        // Fonction pour réinitialiser le compteur de visites à chaque fin de mois
        /*function resetCounterAtEndOfMonth() {
        var now = new Date();
        var currentMonth = now.getMonth();
        var currentYear = now.getFullYear();

        // Vérifie si la date actuelle est le dernier jour du mois
        if (now.getDate() === new Date(currentYear, currentMonth + 1, 0).getDate()) {
            // Réinitialise le compteur de visites à 0
            localStorage.setItem("visits", 0);
        }
        }

        // Vérifie si le cookie de visite unique existe
        if (!document.cookie.includes("visited=true")) {
        // Si le cookie n'existe pas, incrémente le compteur de visites
        if (localStorage.getItem("visits")) {
            var visits = parseInt(localStorage.getItem("visits")) + 1;
            localStorage.setItem("visits", visits);
        } else {
            localStorage.setItem("visits", 1);
        }

        // Définit le cookie de visite unique avec une expiration d'une journée
        var now = new Date();
        now.setTime(now.getTime() + 24 * 60 * 60 * 1000); // 1 jour en millisecondes
        document.cookie = "visited=true; expires=" + now.toUTCString() + "; path=/";
        }

        // Réinitialise le compteur de visites à chaque fin de mois
        setInterval(resetCounterAtEndOfMonth, 1000 * 60 * 60 * 24); // Vérification quotidienne

        // Récupère la valeur du compteur de visites depuis le localStorage
        var visitsCount = localStorage.getItem("visits");

        // Affiche le compteur de visites
        var counterElement = document.getElementById("counter");
        counterElement.innerHTML = "Nombre de visites : " + visitsCount;*/
    </script>

</body>
</html>