<?php session_start(); 

    if(!isset($_SESSION['idMembre'])) {
        header('Location: ./index.php');
        exit;
    } else {

        echo('<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
            <link rel="stylesheet" href="./include/stylse.css">
            <link rel="icon" href="./include/images/site/rssb.ico">
            <title>RSSB - Actualités</title>
        </head>
        <script>
            function afficherTextarea(event, idActualites) {
                event.preventDefault(); // Empêche le comportement par défaut du formulaire
            
                // Masquer les boutons "Supprimer" et "Modifier"
                var supprimerButton = document.querySelector("#supprimer-" + idActualites);
                var modifierButton = document.querySelector("#modifier-" + idActualites);
                supprimerButton.style.display = "none";
                modifierButton.style.display = "none";
            
                // Récupérer l\'élément paragraphe existant
                var paragraphe = document.getElementById("texte-" + idActualites);
            
                // Récupérer le texte existant
                var texteExistants = paragraphe.innerHTML;
            
                // Créer le formulaire
                var form = document.createElement("form");
                form.action = "./traitement/traitModifActualites.php";
                form.method = "post";
                form.onsubmit = function () {
                return confirm("Êtes-vous sûr de vouloir enregistrer les modifications ?");
                };
            
                // Créer une div pour centrer les boutons séparément
                var buttonDiv = document.createElement("div");
                buttonDiv.className = "center-button";

                // Créer le bouton "Enregistrer"
                var enregistrerButton = document.createElement("input");
                enregistrerButton.type = "submit";
                enregistrerButton.name = "enregistrer";
                enregistrerButton.value = "Enregistrer";
                enregistrerButton.className = "submit-actu";
                enregistrerButton.id = "enregistrer-" + idActualites;
                buttonDiv.appendChild(enregistrerButton);
            
                // Créer un champ d\'entrée caché avec l\'ID de l\'actualité
                var hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "idActualites";
                hiddenInput.value = idActualites;
                form.appendChild(hiddenInput);
            
                // Créer une textarea avec le texte existant
                var textarea = document.createElement("textarea");
                textarea.name = "texteActualites";
                textarea.className = "champ-actualites";
                textarea.value = texteExistants.trim().replace(/<br>/g, "");
            
                // Ajouter la textarea au formulaire
                form.appendChild(textarea);

                // Ajouter la div contenant le bouton au formulaire
                form.appendChild(buttonDiv);
            
                // Remplacer le paragraphe par le formulaire
                paragraphe.parentNode.replaceChild(form, paragraphe);

                // Ajouter le bouton "Annuler" après le formulaire
                var annulerButton = document.createElement("input");
                annulerButton.type = "button";
                annulerButton.value = "Annuler";
                annulerButton.className = "submit-actu";
                annulerButton.onclick = function () {
                    window.location.reload(); // Recharger la page pour annuler les modifications
                };

                var containerDiv = document.createElement("div");
                containerDiv.className = "center-second-button";
                containerDiv.appendChild(annulerButton);

                form.parentNode.insertBefore(containerDiv, form.nextSibling);

            }
        </script>
        <body>');

        include('connect.inc.php');
        include("./include/header.php");

        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image" src="./include/images/site/personnages.png" alt="Logo RSSB">
                </div>
                <div class="title-container">
                    <h1>actualités</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>

            <div class="body-content">

                <div class="actualites-content">');

                $reqActualites = $bdd->prepare("SELECT * FROM ACTUALITES ORDER BY IDACTUALITES DESC");
                $reqActualites->execute();

                if($reqActualites->rowCount() == 0) {
                    echo('<p>Aucune actualité n\'est disponible.</p>');
                } else {
                    foreach ($reqActualites as $donneesActualites) {
                        
                        $idActualites = $donneesActualites['IDACTUALITES'];
                        $texteActualites = $donneesActualites['TEXTEACTUALITES'];

                        if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {

                            if(isset($_GET['msgErreur'])){
                                echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                            }

                            echo('<div class="actualites-container">

                                <div class="actualites-buttons">');

                                    if ($texteActualites !== null) {
                                        echo('<input type="submit" name="modifier" value="Modifier" class="submit-actu" onclick="afficherTextarea(event, '.$idActualites.')" id="modifier-'.$idActualites.'"/>');
                                    }

                                    echo('<form action="./traitement/traitSuppActualites.php" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer l\'actualité ?\')">
                                        <input type="hidden" name="idActualites" value="'.$idActualites.'" />
                                        <input type="submit" name="supprimer" value="Supprimer" class="submit-actu" id="supprimer-'.$idActualites.'"/>
                                    </form>
                                </div>');
                        }
                        echo('<br><br><p class="texte-actualites" id="texte-'.$idActualites.'">'.$texteActualites.'</p><br>');

                        if ($donneesActualites['NOMIMAGEACTUALITES'] !== null) {
                            $nomImageActualites = $donneesActualites['NOMIMAGEACTUALITES'];
                            $cheminImageActualites = $donneesActualites['CHEMINIMAGEACTUALITES'];

                            echo('<div class="images-actualites-container">
                                <img class="images-actualites" src="'.$cheminImageActualites.$nomImageActualites.'" alt="imagebd"/><br>
                            </div>');
                        }

                        echo('<hr class="separator-actualites">');

                        if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {
                            echo('</div>');
                        }
                    }
                }

                if(isset($_SESSION['idMembre']) && $_SESSION['roleMembre'] == 'Admin') {

                    if(isset($_GET['msgErreur'])){
                        echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                    }

                    echo('<form class="formImageLocal" action="./traitement/traitAddActualites.php" method="post" enctype="multipart/form-data">
                        <div class="subformImageLocal">
                            <input type="file" class="addFile" name="monImage"/>
                            <label class="description-label">Description :</label>
                            <textarea class="last-champ-contact" name="actualites" maxlength="65535"></textarea>
                            <input type="submit" class="submit-ajouter" name="ajouter" value="Ajouter"/>
                        </div>
                    </form>');
                }

                echo('</div>

            </div>
        
        </div>');

        include("./include/footer.php");

        echo('</body>
        </html>');

    }

?>