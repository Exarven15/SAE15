<?php
session_start();
include('tools/base.php');

$nomFichier = $_POST['nom-fic'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Thalès</title>
</head>

<body>
    <nav>
        <ul>
            <li id="home"><a href="../index.php">Home</a></li>
            <li id="favoris"><a href="/php/config/config.php">Config</a></li>
        </ul>
    </nav>
    <div id="container">
        <form action="envoie.php" method="post">
            <div id="cont-test">
                <!--requête php -->
                <?php

                $sql_date = "SELECT dte FROM fichier WHERE nomFic=:nomFic GROUP BY dte;";
                $req_date = $db->prepare($sql_date);
                $req_date->bindParam(":nomFic", $nomFichier);
                $req_date->execute();
                $enr_date = $req_date->fetchAll();
                $req_date->closeCursor();

                ?>

                <?php
                echo "<input type='text' name='nom-fic' id='test' value={$nomFichier} readonly>";
                ?>


            </div>
            <div id="cont-date">
                <select name="date" id="date">
                    <?php
                    foreach ($enr_date as $val_date) {  
                        $val_date = str_replace(" ", "_", $val_date['dte']);
                        echo "<option value={$val_date}>{$val_date}</option>";
                    }
                    ?>
                </select>

            </div>
            <div id="env">
                <input type="submit" id="sub" value="ENVOYER">
            </div>
            <?php

            ?>
        </form>

    </div>
</body>

</html>
<script src="Js/script.js"></script>