<?php
session_start();
include_once('tools/base.php');
$idFic = $_SESSION['id'];
$obsw = $_SESSION['obsw'];
$bds = $_SESSION['bds'];
$tv = $_SESSION['tv'];
$dteFic = $_SESSION['date'];
$nomFic = $_SESSION['nomFic'];

$idTrame = $_SESSION['idTrames'];
$typeTrame = $_SESSION['type-trame'];


$json_data = file_get_contents('/home/exarven/Documents/config.json');
$data = json_decode($json_data, true);

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
            <li id="headTrame">
                <table>
                    <thead>
                        <tr>
                            <th id="obsw"><?php echo $data['obsw']; ?></th>
                            <th id="bds"><?php echo $data['bds'];?></th>
                            <th id="tv"><?php echo $data['tv'];?></th>
                            <th id="dte"><?php echo $data['dte'];?></th>
                            <th id="nomFic"><?php echo $data['nomFic'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            if($obsw == "Unknown - .selected_conf_file missing Unknown - .selected_conf_file missing")
                                echo "<td>Unknown</td>";
                            else echo "<td>$obsw</td>";
                            if($bds == "Unknown - .selected_conf_file missing")
                                echo "<td>Unknown</td>";
                            else echo "<td>$bds</td>";
                            echo "<td>{$tv}</td>";
                            echo "<td>{$dteFic}</td>";
                            echo "<td>{$nomFic}</td>";
                            ?>
                        </tr>
                    </tbody>
                </table>
            </li>
            <li id="favoris"><a href="/php/config/config.php">Config</a></li>
        </ul>
    </nav>

    <?php
    $sql_total_trames = "SELECT COUNT(*) AS total FROM trames GROUP BY idFichier";
    $result_total_trames = $db->query($sql_total_trames);
    $total_trames = $result_total_trames->fetchColumn();
    $results_per_page = 100;

    # calculer le nombre de page néccessaire
    $total_pages = ceil($total_trames / $results_per_page);

    // Récupérer la page courante
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $current_page = $_GET['page'];
    } else {
        $current_page = 1;
    }
    # calculer le numéro de départ pour la requête LIMIT
    $offset = ($current_page - 1) * $results_per_page;

    $sql_aff_trames = "SELECT * 
                            FROM trames 
                            JOIN fichier ON trames.idFichier = fichier.id 
                            WHERE fichier.id = :idFichier ORDER BY trames.idTrame ASC LIMIT $offset,$results_per_page;";
    $req_aff_trames = $db->prepare($sql_aff_trames);
    $req_aff_trames->bindParam(":idFichier", $idFic);
    $req_aff_trames->execute();
    $enr_aff_trames = $req_aff_trames->fetchAll();
    $req_aff_trames->closeCursor();
    ?>
    <section id="aff-trames">
        <?php
        
        foreach ($enr_aff_trames as $val_aff) {
            if ($typeTrame == '800') {
                $idFichier = $val_aff['idTrame'];
                echo "<div>";
                echo "<summary id='titre-trame'>Trame n°{$val_aff['idTrame']} </summary>";
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th id='dte-trame'>".$data['dteT']."</th>";
                echo "<th id='b3'>".$data['bench3']."</th>";
                echo "<th id='b5'>".$data['bench5']."</th>";
                echo "<th id='size'>".$data['size']."</th>";
                echo "<th id='macDest'>".$data['macDest']."</th>";
                echo "<th id='macSource'>".$data['macSource']."</th>";
                echo "<th id='f1'>".$data['field1']."</th>";
                echo "<th id='f2'>".$data['field2']."</th>";
                echo "<th id='f3'>".$data['field3']."</th>";
                echo "<th id='f4'>".$data['field4']."</th>";
                echo "<th id='f5'>".$data['field5']."</th>";
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
                echo "</tr>";
                echo "<tr>";
                echo "<th id='f6'>".$data['field6']."</th>";
                echo "<th id='f7'>".$data['field7']."</th>";
                echo "<th id='ipSource'>".$data['ipSource']."</th>";
                echo "<th id='ipDest'>".$data['ipDest']."</th>";
                echo "<th id='f9'>".$data['field9']."</th>";
                echo "<th id='f10'>".$data['field10']."</th>";
                echo "<th id='f11'>".$data['field11']."</th>";
                echo "<th id='f14'>".$data['field14']."</th>";
                echo "<th id='f16'>".$data['field16']."</th>";
                echo "<th id='f17'>".$data['field17']."</th>";
                echo "<th id='f18'>".$data['field18']."</th>";
                
                echo "</tr>";
                echo "<tr>";
                echo "<td>{$val_aff['f6']}</td>";
                echo "<td>{$val_aff['f7']}</td>";
                echo "<td>{$val_aff['ipSource']}</td>";
                echo "<td>{$val_aff['ipDest']}</td>";
                echo "<td>{$val_aff['f9']}</td>";
                echo "<td>{$val_aff['f10']}</td>";
                echo "<td>{$val_aff['f11']}</td>";
                echo "<td>{$val_aff['f14']}</td>";
                echo "<td>{$val_aff['f16']}</td>";
                echo "<td>{$val_aff['f17']}</td>";
                echo "<td>{$val_aff['f18']}</td>";
                
                echo "</tr>";
                echo "<tr>";
                echo "<th id='f20'>".$data['field20']."</th>";
                echo "<th id='f21'>".$data['field21']."</th>";
                echo "<th id='f23'>".$data['field23']."</th>";
                echo "<th id='f25'>".$data['field25']."</th>";
                echo "<th id='f26'>".$data['field26']."</th>";
                echo "<th id='f28'>".$data['field28']."</th>";
                echo "<th id='f29'>".$data['field29']."</th>";
                echo "<th id='f30'>".$data['field30']."</th>";
                echo "<th id='f32'>".$data['field32']."</th>";
                echo "<th id='pkDte'>".$data['packetDate']."</th>";
                echo "<th id='ft_6'>".$data['fonction de transfert 6']."</th>";
                echo "</tr>";
                echo "<tr>";
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
                echo "<td>{$val_aff['ft_6']}</td>";
                echo "</tr>";
                echo "</table>";
                echo "</div>";
            } elseif ($typeTrame == '806') {
                echo "<div>";
                echo "<summary id='titre-trame'>Trame n°{$val_aff['idTrame']} </summary>";
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th id='dte-trame'>DATE</th>";
                echo "<th id='b3'>bench3</th>";
                echo "<th id='b5'>bench5</th>";
                echo "<th id='size'>SIZE</th>";
                echo "<th id='macDest'>MAC DESTINATION</th>";
                echo "<th id='macSource'>MAC SOURCE</th>";
                echo "<th id='f1'>field 1</th>";
                echo "<th id='f2'>field 2</th>";
                echo "<th id='f3'>field 3</th>";
                echo "<th id='f4'>field 4</th>";
                echo "<th id='f5'>field 5</th>";
                echo "<th id='f6'>field 6</th>";
                echo "<th id='f7'>MAC SENDER</th>";
                echo "<th id='ipSource'>IP SENDER</th>";
                echo "<th id='ipDest'>MAC TARGET</th>";
                echo "<th id='f9'>IP TARGET</th>";
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
                echo "<td>{$val_aff['macSender']}</td>";
                echo "<td>{$val_aff['ipSender']}</td>";
                echo "<td>{$val_aff['macTarget']}</td>";
                echo "<td>{$val_aff['ipTarget']}</td>";
                echo "</tr>";
                echo "</table>";
                echo "</div>";
            }
        }
        ?>
    </section>
    <div id="aff-page">
        
        <!-- Afficher les liens de pagination -->
        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
            <?php $first_trame = ($page - 1) * $results_per_page + 1; ?>
            <a id="aff-num" href="aff.php?page=<?php echo $page; ?>"
               title="Trames <?php echo $first_trame; ?>-<?php echo $first_trame + $results_per_page - 1; ?>">
                <?php echo $page; ?>
            </a>
        <?php endfor; ?>
        <?php 
        $db = null;
        ?>
    </div>

    </section>


</body>

</html>
<script src="Js/script.js"></script>