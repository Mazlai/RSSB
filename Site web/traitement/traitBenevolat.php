<?php

    // on inclut le fichier de connexion à la base Oracle
    session_start();
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    use Dompdf\Dompdf;
    use Dompdf\Options;

    require_once("../include/dompdf/autoload.inc.php");
    require_once("../connect.inc.php");
    error_reporting(E_ALL);

    if(!(isset($_POST['valider']) && isset($_POST['date-benevolat']) && isset($_POST['public-benevolat']) && isset($_POST['nom-benevolat'])
       && isset($_POST['motif-benevolat']) && isset($_POST['hours']) && isset($_POST['minutes']))){
        header('Location: ../tempsbenevolat.php?msgErreur=Veuillez remplir tous les champs.');
        exit;
    }

    // Récupérer le nombre de lignes dupliquées
    $numRows = count($_POST['date-benevolat']);
    
    // Tableau pour stocker les données
    $donnees = array();
    
    // Parcourir chaque ligne dupliquée
    for ($i = 0; $i < $numRows; $i++) {

        $public = htmlspecialchars($_POST['public-benevolat'][$i]);
        $nom = htmlspecialchars($_POST['nom-benevolat'][$i]);
        $motif = htmlspecialchars($_POST['motif-benevolat'][$i]);

        // Vérifier les champs avec preg_match
        if (!preg_match("#^[\p{L}'\-\s]+$#u", $public)) {
            header('Location: ../tempsbenevolat.php?msgErreur=Vérifiez vos saisies sur le public.');
            exit;
        }

        if(!preg_match("#^[\p{L}'\-\s]+$#u", $nom)) {
            header('Location: ../tempsbenevolat.php?msgErreur=Vérifiez vos saisies concernant le nom du bénéficiaire.');
            exit;
        }

        if(!preg_match("#^[\p{L}'\-\s]+$#u", $motif)) {
            header('Location: ../tempsbenevolat.php?msgErreur=Vérifiez vos saisies sur le motif.');
            exit;
        }

        $row = array(
            'date' => htmlentities($_POST['date-benevolat'][$i]),
            'public' => htmlspecialchars($public),
            'nom' => htmlspecialchars($nom),
            'motif' => htmlspecialchars($motif),
            'hours' => htmlentities($_POST['hours'][$i]),
            'minutes' => htmlentities($_POST['minutes'][$i])
        );
        
        // Ajouter la ligne au tableau de données
        $donnees[] = $row;
    }

    $reqDeleteTps = $bdd->prepare("DELETE FROM BENEVOLAT
                                   WHERE IDBENEVOLE = :pIdMembre");

    $reqDeleteTps->execute(array(":pIdMembre" => $_SESSION['idMembre']));

    // Calcul du temps total de bénévolat
    $totalHours = 0;
    $totalMinutes = 0;

    // Créer une nouvelle instance de Dompdf et Options
    $dompdf = new Dompdf();
    $options = new Options();

    // Générer le contenu HTML du tableau
    $html = '<p style="font-weight: bold;">RSSB - BÉNÉVOLAT</p><br>
            <table style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px; background-color: yellow;" colspan="1">Nom du Bénévole :</th>
                    <th style="border: 1px solid black; padding: 8px; text-transform: uppercase; background-color: cyan;" colspan="4">Bénéficiaire</th>
                </tr>
                <tr>
                    <th style="border: 1px solid black; padding: 8px;" colspan="1">'.$_SESSION['nomMembre'].' '.$_SESSION['prenomMembre'].'</th>
                    <th style="border: 1px solid black; padding: 8px;" colspan="4"></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black; padding: 8px; text-transform: uppercase; text-decoration: underline;">Date intervention</th>
                    <th style="border: 1px solid black; padding: 8px; text-transform: uppercase; text-decoration: underline;">Public</th>
                    <th style="border: 1px solid black; padding: 8px; text-transform: uppercase; text-decoration: underline;">Nom</th>
                    <th style="border: 1px solid black; padding: 8px; text-transform: uppercase; text-decoration: underline;">Motif</th>
                    <th style="border: 1px solid black; padding: 8px; text-transform: uppercase; text-decoration: underline;">Temps</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($donnees as $row) {
        setlocale(LC_TIME, 'fr_FR.UTF-8');
        $formattedDate = strftime("%A %d %B %Y", strtotime($row['date']));
        $formattedDate = ucfirst(strftime("%A %d ", strtotime($row['date']))) . ucfirst(strftime("%B %Y", strtotime($row['date'])));
        $html .= '<tr>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">' . $formattedDate . '</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">' . $row['public'] . '</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">' . $row['nom'] . '</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">' . $row['motif'] . '</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">' . $row['hours'] . 'h' . $row['minutes'] . 'mn</td>
                </tr>';

        $hours = (int) $row['hours'];
        $minutes = (int) $row['minutes'];

        $totalHours += $hours;
        $totalMinutes += $minutes;

        // Ajouter les minutes supplémentaires aux heures si elles dépassent 60
        if ($totalMinutes >= 60) {
            $totalHours += floor($totalMinutes / 60);
            $totalMinutes = $totalMinutes % 60;
        }
    }

    $html .= '<tr>
                <td style="border: 1px solid black; padding: 8px; background-color: yellow;" colspan="5">
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: left; text-transform: uppercase; font-weight: bold;">Total</td>
                            <td style="text-align: right;">' . $totalHours . 'h' . $totalMinutes . 'mn</td>
                        </tr>
                    </table>
                </td>
             </tr>';

    $html .= "</tbody></table>";

    //Charger le contenu HTML dans Dompdf
    $dompdf->loadHtml($html);

    //Définir les options de rendu
    $options->set('defaultFont', 'Verdana');
    $options->set('isRemoteEnabled', true);

    $dompdf->setOptions($options);

    //Rendre le PDF
    $dompdf->render();

    // Obtenir le contenu PDF généré
    $pdfContent = $dompdf->output();

    $message = "Bonjour,\n\nVoici le temps de bénévolat pour cette saison.\n\nCordialement,\n\n{$_SESSION['nomMembre']} {$_SESSION['prenomMembre']}";

    // Créer une limite pour le contenu mixte
    $boundary = md5(time());

    // Headers du mail
    $headers = "";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= 'From: Site web - RSSB <siteweb@reseausocialsolidaireblagnac.org>' . "\r\n";
    $headers .= 'Cc: ' . $_SESSION['mailMembre'] . "\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Contenu du mail
    $body = "--" . $boundary . "\r\n";
    $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n";
    $body .= "\r\n";
    $body .= $message . "\r\n";

    $body .= "--" . $boundary . "\r\n";
    $body .= "Content-Type: application/pdf; name=\"tableau_benevolat.pdf\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment\r\n";
    $body .= "\r\n";
    $body .= chunk_split(base64_encode($pdfContent)) . "\r\n";

    $body .= "--" . $boundary . "--\r\n";

    if(mail("reseausocialsolidaire@gmail.com", utf8_decode("Temps de bénévolat - ").utf8_decode($_SESSION['nomMembre'])." ".utf8_decode($_SESSION['prenomMembre']), $body, $headers)) {
        echo('<script language="JavaScript" type="text/javascript"> 
            alert("Mail envoyé. Vérifiez votre boite mail."); 
            location.href = "../index.php";
        </script>');
    } else {
        header('Location: ../tempsbenevolat.php?msgErreur=Une erreur est survenue...');
        exit;
    }

?>