<?php
session_start();
include_once('base.php');
$idFic = $_SESSION['id'];
$obsw = $_SESSION['obsw'];
$bds = $_SESSION['bds'];
$tv = $_SESSION['tv'];
$dteFic = $_SESSION['date'];
$nomFic = $_SESSION['nomFic'];

$idTrame = $_SESSION['idTrames'];
$typeTrame = $_SESSION['type-trame'];
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
    <nav class="nav">

    </nav>

    <nav>
        <ul>
            <li id="home"><a href="../index.php">Home</a></li>
            <li id="favoris"><a href="">Config</a></li>
        </ul>
    </nav>
    <section id="aff-trames">
        <table>
            <thead>
                <tr>
                    <th id="obsw">OBSW</th>
                    <th id="bds">VERSION BDS</th>
                    <th id="tv">TYPE VERSION</th>
                    <th id="dte">DATE</th>
                    <th id="nomFic">NOM DU FICHIER</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    echo "<td>{$obsw}</td>";
                    echo "<td>{$bds}</td>";
                    echo "<td>{$tv}</td>";
                    echo "<td>{$dteFic}</td>";
                    echo "<td>{$nomFic}</td>";
                    ?>
                </tr>
            </tbody>
        </table>
        <?php
        $sql_aff_trames = "SELECT * 
                            FROM trames 
                            JOIN fichier ON trames.idFichier = fichier.id 
                            WHERE fichier.id = :idFichier ORDER BY trames.idTrame ASC LIMIT 50;";
        $req_aff_trames = $db->prepare($sql_aff_trames);
        $req_aff_trames -> bindParam(":idFichier",$idFic);
        $req_aff_trames->execute();
        $enr_aff_trames = $req_aff_trames->fetchAll();
        $req_aff_trames->closeCursor();
        
        foreach ($enr_aff_trames as $val_aff){
            
            echo "<div>";
            echo "<summary>Trame n°{$val_aff['idTrame']} </summary>";
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th id='dte-trame'>DATE</th>";
            echo "<th id='b3'>bench3</th>";
            echo"<th id='b5'>bench5</th>";
            echo "<th id='size'>SIZE</th>";
            echo "<th id='macDest'>MAC DESTINATION</th>";
            echo "<th id='macSource'>MAC SOURCE</th>";
            echo "<th id='f1'>field 1</th>";
            echo "<th id='f2'>field 2</th>";
            echo "<th id='f3'>field 3</th>";
            echo "<th id='f4'>field 4</th>";
            echo "<th id='f5'>field 5</th>";
            echo "<th id='f6'>field 6</th>";
            echo "<th id='f7'>field 7</th>";
            echo "<th id='ipSource'>IP SOURCE</th>";
            echo "<th id='ipDest'>IP DESTINATION</th>";
            echo "<th id='f9'>field 9</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>{$val_aff['dteT']}</td>";
            echo "<td>{$val_aff['b3']}</td>";
            echo "<td>{$val_aff['b5']}</td>";
            echo "<td>{$val_aff['size']}</td>";
            echo "<td>{$val_aff['macDest']}</td>";
            echo "<td>{$val_aff['macSource']}</td>";
            echo "<td>{$val_aff['f1']}</td>";
            echo "<td>{$val_aff['f2']}</td>";
            echo "<td>{$val_aff['f3']}</td>";
            echo "<td>{$val_aff['f4']}</td>";
            echo "<td>{$val_aff['f5']}</td>";
            echo "<td>{$val_aff['f6']}</td>";
            echo "<td>{$val_aff['f7']}</td>";
            echo "<td>{$val_aff['ipSource']}</td>";
            echo "<td>{$val_aff['ipDest']}</td>";
            echo "<td>{$val_aff['f9']}</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th id='f10'>field 10</th>";
            echo "<th id='f11'>field 11</th>";
            echo "<th id='f14'>field 14</th>";
            echo "<th id='f16'>field 16</th>";
            echo "<th id='f17'>field 17</th>";
            echo "<th id='f18'>field 18</th>";
            echo "<th id='f20'>field 20</th>";
            echo "<th id='f21'>field 21</th>";
            echo "<th id='f23'>field 23</th>";
            echo "<th id='f25'>field 25</th>";
            echo "<th id='f26'>field 26</th>";
            echo "<th id='f28'>field 28</th>";
            echo "<th id='f29'>field 29</th>";
            echo "<th id='f30'>field 30</th>";
            echo "<th id='f32'>field 32</th>";
            echo "<th id='pkDte'>Packet Date</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>{$val_aff['f10']}</td>";
            echo "<td>{$val_aff['f11']}</td>";
            echo "<td>{$val_aff['f14']}</td>";
            echo "<td>{$val_aff['f16']}</td>";
            echo "<td>{$val_aff['f17']}</td>";
            echo "<td>{$val_aff['f18']}</td>";
            echo "<td>{$val_aff['f20']}</td>";
            echo "<td>{$val_aff['f21']}</td>";
            echo "<td>{$val_aff['f23']}</td>";
            echo "<td>{$val_aff['f25']}</td>";
            echo "<td>{$val_aff['f26']}</td>";
            echo "<td>{$val_aff['f28']}</td>";
            echo "<td>{$val_aff['f29']}</td>";
            echo "<td>{$val_aff['f30']}</td>";
            echo "<td>{$val_aff['f32']}</td>";
            echo "<td>{$val_aff['pkDte']}</td>";
            echo "</tr>";
            echo "</table>";
            echo "</div>";
            
        }

        ?>
        
    </section>


</body>

</html>
<script src="Script/script.js"></script>