<?php
session_start();
// Récupération des valeurs du formulaire
if (isset($_POST)) {
    // Récupération du contenu du fichier JSON
    $jsonData = file_get_contents('/home/exarven/Documents/config.json');

    // Conversion du JSON en objet PHP
    $data = json_decode($jsonData);

    // Vérification si le formulaire a été envoyé et si des données ont été modifiées
    if (isset($_POST)) {
        $formData = array();
        $formDataChanged = false;

        // Récupération des valeurs envoyées par le formulaire
        foreach ($data as $key => $value) {
            if (isset($_POST[$key])&& !empty($_POST[$key])) {
                $formData[$key] = $_POST[$key];
                $formDataChanged = true;
            } else {
                $formData[$key] = $value;
            }
        }

        // Mise à jour du JSON avec les nouvelles valeurs
        if ($formDataChanged) {
            $jsonData = json_encode($formData);
            file_put_contents('/home/exarven/Documents/config.json', $jsonData);
            // Si vous voulez également mettre à jour les variables PHP avec les nouvelles valeurs, vous pouvez faire :
            $data = json_decode($jsonData, true); // true pour récupérer un tableau associatif plutôt qu'un objet
            header("Location: " . $_SERVER['PHP_SELF']); // Recharge la page
            exit;
        }
    }
}

header("Location: config.php?ok=100");
exit();
?>