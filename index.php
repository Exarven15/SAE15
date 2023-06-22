<?php
session_start();
include('php/tools/base.php');
$sup = $_GET['suppr'];
if ($sup == "150"){
    $message = "Enregistrement supprimé avec succès";
    echo '<script>alert("'.$message.'");</script>';
}
$sel = $_GET['sel'];
if ($sel == "50"){
    $message = "Veuillez choisir un test.";
    echo '<script>alert("'.$message.'");</script>';
    }

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Thalès</title>
</head>

<body>

    <nav>
        <ul>
            <li id="home"><a href="index.php">Home</a></li>
            <li id="favoris"><a href="/php/config/config.php">Config</a></li>
        </ul>
    </nav>
    <div id="container">
        <form action="php/nextForm.php" method="post">
            <div id="cont-test">
                <!--requête php -->
                <?php
                $sql_name = "SELECT nomFic FROM fichier GROUP BY nomFic;";
                $req_name = $db->prepare($sql_name);
                $req_name->execute();
                $enr_name = $req_name->fetchAll();
                $req_name->closeCursor();
                ?>
                
                <select name="nom-fic" id="test">
                    <?php
                    echo '<option value="">--Veuillez choisir un test--</option>';
                    
                    foreach ($enr_name as $val_name) {
                        echo "<option name='nom-fic' value={$val_name['nomFic']}>{$val_name['nomFic']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div id="env">
                <input type="submit" id="sub" value="SELECTIONNER">
            </div>
            
        </form>

    </div>
    <div id="img">
    <img src="./logo-thales.png" alt="logo-thales"> 
    </div>
</body>

</html>
<script src="Js/script.js"></script>
