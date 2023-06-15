<?php
    session_start();;

    if(!isset($_SESSION['idMembre'])) {
        header('Location: ./');
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
            <title>RSSB - Temps de bénévolat</title>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var addButton = document.getElementById("add-row");
                    addButton.addEventListener("click", function() {
                        var gridContainer = document.getElementById("gridBenevolat");
                        var newInputs = gridContainer.cloneNode(true);

                        // Supprimer les labels des nouveaux inputs
                        var labels = newInputs.querySelectorAll("label");
                        labels.forEach(function(label) {
                            label.remove();
                        });

                        // Supprimer les valeurs des nouveaux inputs
                        var inputs = newInputs.querySelectorAll("input[type=\'date\'], input[type=\'text\'], select");
                        inputs.forEach(function(input) {
                            input.value = "";
                        });

                        var newDiv = document.createElement("div");
                        newDiv.className = "supp-ligne-container";

                        var deleteButton = document.createElement("button");
                        deleteButton.className = "supp-ligne";
                        deleteButton.textContent = "Supprimer";
                        deleteButton.addEventListener("click", function() {
                            newInputs.remove();
                        });
                        newDiv.appendChild(deleteButton);
                        newInputs.appendChild(newDiv);

                        gridContainer.insertAdjacentElement(\'afterend\', newInputs);
                    });
                });

                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("submit-contact").addEventListener("click", function(event) {
                        var target = event.target;
                        if (target && target.name === "valider") {
                            var form = document.getElementById("benevolat-form");
                            // Ajouter l\'attribut "required" aux champs de texte et soumettre le formulaire
                            var inputs = form.querySelectorAll("input[type=\'date\'], input[type=\'text\'], select");

                            inputs.forEach(function(input) {
                                input.setAttribute("required", "");
                            });

                            // Vérifier si les champs sont remplis avant d\'afficher la confirmBox
                            var hasEmptyFields = false;
                            inputs.forEach(function(input) {
                                if (input.value.trim() === "") {
                                    hasEmptyFields = true;
                                    input.reportValidity();
                                }
                            });

                            if (hasEmptyFields) {
                                event.preventDefault();
                                return;
                            }

                            var confirmMessage = "Êtes-vous sûr de confirmer votre temps de bénévolat ? Vous ne pourrez pas revenir en arrière.";
                            if (confirm(confirmMessage)) {
                                var form = document.getElementById("benevolat-form");
                                form.action = "./traitement/traitBenevolat.php";
                                form.submit();
                            } else {
                                event.preventDefault();
                            }
                        } 
                    });
                });

                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("submit-enregistrer-tps").addEventListener("click", function(event) {
                        var target = event.target;
                        if (target && target.name === "enregistrer") {
                            var form = document.getElementById("benevolat-form"); // Déplacer cette ligne ici
                            // Ajouter l\'attribut "required" aux champs de texte
                            var inputs = form.querySelectorAll("input[type=\'date\'], input[type=\'text\'], select");

                            inputs.forEach(function(input) {
                                input.setAttribute("required", "");
                            });

                            // Vérifier si les champs sont remplis avant d\'afficher la confirmBox
                            var hasEmptyFields = false;
                            inputs.forEach(function(input) {
                                if (input.value.trim() === "") {
                                    hasEmptyFields = true;
                                    input.reportValidity();
                                }
                            });

                            if (hasEmptyFields) {
                                event.preventDefault();
                                return;
                            }
                        }
                    });
                });

                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("submit-recup").addEventListener("click", function(event) {
                        var target = event.target;
                        if (target && target.name === "recuperer") {
                            var form = document.getElementById("benevolat-form");
                            var inputs = form.querySelectorAll("input[type=\'date\'], input[type=\'text\'], select");
                            
                            // Vérifier si tous les champs ont l\'attribut "required"
                            var allFieldsRequired = true;
                            inputs.forEach(function(input) {
                                if (!input.hasAttribute("required")) {
                                    allFieldsRequired = false;
                                }
                            });
                
                            // Si tous les champs ont l\'attribut "required", les supprimer
                            if (allFieldsRequired) {
                                inputs.forEach(function(input) {
                                    input.removeAttribute("required");
                                });
                            }
                        }
                    });
                });
            </script>
        </head>
        <body>');

        include('connect.inc.php');
        include("./include/header.php"); 

        echo('<div class="container">

            <div class="head-container">
                <div class="image-title-container">
                    <img class="head-image" src="./include/images/site/personnages.png" alt="Logo RSSB">
                </div>
                <div class="title-container">
                    <h1>temps de bénévolat</h1>
                </div>
                <div class="separator-container">
                    <hr>
                </div>
            </div>
            
            <div class="form-container">

                <div id="form-benevolat">

                    <div class="subform-benevolat">
                    
                        <div id="text-tps">
                            <p>Pour effectuer votre temps de bénévolat, veuillez remplir les champs de texte suivants : </p> 
                        </div>');

                        echo('<form method="post" id="benevolat-form">');

                            if(isset($_GET['msgErreur'])){
                                echo("<h3 class='errorDatabase'>".$_GET['msgErreur']."</h3>");
                            }

                            echo('<div id="gridBenevolat">
                                <label class="benevolat-labels">date intervention</label>
                                <label class="benevolat-labels">public</label>
                                <label class="benevolat-labels">nom bénéficiaire</label>
                                <label class="benevolat-labels">motif</label>
                                <label class="benevolat-labels">temps</label>');

                                if(!isset($_POST['recuperer'])) {

                                    echo('<div class="columnBenevolat">
                                        <input type="date" name="date-benevolat[]" class="benevolat-inputs"/>
                                    </div>
                                        
                                    <div class="columnBenevolat">
                                        <input type="text" placeholder="Sénior, Enfant, ..." name="public-benevolat[]" class="benevolat-inputs"/>
                                    </div>

                                    <div class="columnBenevolat">
                                        <input type="text" name="nom-benevolat[]" class="benevolat-inputs"/>
                                    </div>

                                    <div class="columnBenevolat">
                                        <input type="text" name="motif-benevolat[]" class="benevolat-inputs"/>
                                    </div>

                                    <div class="columnBenevolat">
                                        <select name="hours[]" class="selectTime">');
                                            // Générer les options pour les heures (0 à 24)
                                            for ($i = 0; $i <= 24; $i++) {
                                                echo "<option value=\"$i\">$i h</option>";
                                            }
                                        echo('</select>
                                        <select name="minutes[]" class="selectTime">');
                                            // Générer les options pour les minutes (0 à 59)
                                            for ($i = 0; $i <= 59; $i++) {
                                                echo "<option value=\"$i\">$i mn</option>";
                                            }
                                        echo('</select>
                                    </div>
                                </div>
                            
                                <div class="separator-benevole">
                                    <hr><br>
                                </div>
                        
                                <div class="button-form">
                                    <button id="add-row" class="submit-ligne" type="button">Ajouter une ligne</button>
                                </div>

                                <br>
                                <div id="benevolat-text">
                                    <h3 style="color:red;">1</h3>
                                    <h4><i>&bull; Remplissez entièrement votre temps de bénévolat ou enregistrez vos données à chaque ligne complète.</i></h4>
                                </div>

                                <br>
                                <div id="benevolat-text">
                                    <h3 style="color:red;">2</h3>
                                    <h4><i>&bull; Récupérez et visualisez vos données depuis le bouton associé.</i></h4>
                                </div>

                                <br>
                                <div id="benevolat-text">
                                    <h3 style="color:red;">3</h3>
                                    <h4><i>&bull; Envoyez votre temps de bénévolat si vous estimez qu\'il est complet.</i></h4>
                                </div>

                                <br><br>
                                <div id="benevolat-text">
                                    <h1 style="color:blue">&#8505;</h1>
                                    <h4 style="color:white"><i>&bull; Vous effectuerez votre envoi <u>fin décembre</u> et <u>fin juin</u>.</i></h4>
                                </div>
                                <br>

                                <div class="button-benevolat">
                                    <div class="button-form">
                                        <input type="submit" name="enregistrer" value="Enregistrer les données" formaction="./traitement/traitEnregistrerTps.php" class="submit-tps" id="submit-enregistrer-tps"/>
                                    </div>

                                    <div class="button-form">
                                        <input type="submit" name="recuperer" value="Récupérer les données" class="submit-tps" id="submit-recup"/>
                                    </div>

                                    <div class="button-form">
                                        <input type="submit" name="valider" value="Envoyer" id="submit-contact"/>
                                    </div>
                                </div>');

                                } else {

                                    // Récupère l'ID du bénévole à partir de la session
                                    $idBenevole = $_SESSION['idMembre'];

                                    // Effectue une requête SELECT pour récupérer les données du bénévole
                                    $recupLignes = $bdd->prepare("SELECT * FROM BENEVOLAT WHERE IDBENEVOLE = :pIdBenevole ORDER BY DATETPS DESC");
                                    $recupLignes->execute(array(":pIdBenevole" => $idBenevole));

                                    // Vérifie s'il y a des résultats
                                    if ($recupLignes->rowCount() > 0) {
                                        
                                        $rowCount = 0;

                                        echo('</div>');
                                        // Parcourt les lignes de résultats
                                        foreach ($recupLignes as $tpsBenevolat) {

                                            $rowCount++;
                                            echo('<div id="gridBenevolat">
                                        
                                                <div class="columnBenevolat">
                                                    <input type="date" name="date-benevolat[]" class="benevolat-inputs" required value="'.$tpsBenevolat['DATETPS'].'" />
                                                </div>
                                    
                                                <div class="columnBenevolat">
                                                    <input type="text" placeholder="Sénior, Enfant, ..." name="public-benevolat[]" class="benevolat-inputs" required value="'.$tpsBenevolat['PUBLIC'].'" />
                                                </div>
                                    
                                                <div class="columnBenevolat">
                                                    <input type="text" name="nom-benevolat[]" class="benevolat-inputs" required value="'.$tpsBenevolat['BENEFICIAIRE'].'" />
                                                </div>
                                    
                                                <div class="columnBenevolat">
                                                    <input type="text" name="motif-benevolat[]" class="benevolat-inputs" required value="'.$tpsBenevolat['MOTIF'].'" />
                                                </div>
                                    
                                                <div class="columnBenevolat">
                                                    <select name="hours[]" class="selectTime" required>');
                                                    //Génère les options pour les heures (0 à 24) et sélectionne la valeur correspondante
                                                    for ($i = 0; $i <= 24; $i++) {
                                                        if ($i == $tpsBenevolat['HEURESBENEVOLAT']) {
                                                            echo('<option value="'.$i.'" selected>'.$i.' h</option>');
                                                        } else {
                                                            echo('<option value="'.$i.'">'.$i.' h</option>');
                                                        }
                                                    }
                                                    echo('</select>
                                                    <select name="minutes[]" class="selectTime" required>');
                                                    //Génère les options pour les minutes (0 à 59) et sélectionne la valeur correspondante
                                                    for ($i = 0; $i <= 59; $i++) {
                                                        if ($i == $tpsBenevolat['MINUTESBENEVOLAT']) {
                                                            echo('<option value="'.$i.'" selected>'.$i.' mn</option>');
                                                        } else {
                                                            echo('<option value="'.$i.'">'.$i.' mn</option>');
                                                        }
                                                    }
                                                    echo('</select>
                                                </div>
                                            </div>');
                                        }

                                        echo('<div class="separator-benevole">
                                            <hr><br>
                                        </div>

                                        <div class="button-form">
                                            <input type="submit" name="valider" value="Envoyer" id="submit-contact"/>
                                        </div>');

                                    } else {
                                        echo('<script language="JavaScript" type="text/javascript"> 
                                            alert("Vous n\'avez jamais enregistré vos données. Vous êtes redirigé sur votre page de compte."); 
                                            location.href = "./compte.php";
                                        </script>');
                                    }

                                }

                        echo('</form>');
                        
                        if(isset($_POST['recuperer'])) {
                            echo('<div class="center-second-button"><input type="button" value="Annuler" id="submit-contact" onclick="history.back();" /></div>');
                        }

                    echo('</div>
                </div>
            </div>
        </div>');

        include("./include/footer.php");

        echo('</body>
        </html>');
    
    }

?>