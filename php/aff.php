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

$json_data = file_get_contents('/home/thales/Documents/config.json');
$data = json_decode($json_data, true);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">

    <title>Thalès</title>
</head>

<body>
    <script>
        function changeColor(element) {
            var tdClass = element.getAttribute("class");
            var tds = document.getElementsByClassName(tdClass);

            // Vérifier si l'élément cliqué a déjà la classe "click"
            if (element.classList.contains("click")) {
                // Supprimer la classe "click" de l'élément cliqué
                element.classList.remove("click");
                // Parcourir tous les td ayant la même classe
                for (var i = 0; i < tds.length; i++) {
                    // Supprimer la classe "click" de tous les autres td
                    if (tds[i] !== element) {
                        tds[i].classList.remove("click");
                    }
                    // Recharger la page
                    window.location.reload();
                }
            } else {
                // Ajouter la classe "click" à l'élément cliqué
                element.classList.add("click");
                // Parcourir tous les td ayant la même classe
                for (var i = 0; i < tds.length; i++) {
                    // Ajouter la classe "click" à tous les autres td
                    if (tds[i] !== element) {
                        tds[i].classList.add("click");
                    }
                }
            }

            // Stocker l'état des éléments cliqués dans le localStorage
            var clickedElements = [];
            var allTds = document.getElementsByTagName("td");
            for (var i = 0; i < allTds.length; i++) {
                if (allTds[i].classList.contains("click")) {
                    clickedElements.push(allTds[i].getAttribute("class"));
                }
            }
            localStorage.setItem("clickedElements", JSON.stringify(clickedElements));

            var clickedElements = localStorage.getItem("clickedElements");
            if (clickedElements) {
                clickedElements = JSON.parse(clickedElements);
                for (var i = 0; i < clickedElements.length; i++) {
                    var tds = document.getElementsByClassName(clickedElements[i]);
                    for (var j = 0; j < tds.length; j++) {
                        tds[j].classList.add("click");
                    }
                }
            }

        }
        // Récupérer les éléments cliqués depuis le localStorage
    </script>

    <nav>
        <ul>
            <li id="home"><a href="../index.php">Home</a></li>
            <li id="headTrame">
                <table>
                    <thead>
                        <tr>
                            <th id="obsw"><?php echo $data['obsw']; ?></th>
                            <th id="bds"><?php echo $data['bds']; ?></th>
                            <th id="tv"><?php echo $data['tv']; ?></th>
                            <th id="dte"><?php echo $data['dte']; ?></th>
                            <th id="nomFic"><?php echo $data['nomFic']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            if ($obsw == "Unknown - .selected_conf_file missing Unknown - .selected_conf_file missing")
                                echo "<td>Unknown</td>";
                            else echo "<td>$obsw</td>";
                            if ($bds == "Unknown - .selected_conf_file missing")
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
            <li id="favoris"><a href="./config/config.php">Config</a></li>
        </ul>
    </nav>
        
    <?php
    $sql_total_trames = "SELECT COUNT(*) AS total FROM trames GROUP BY idFichier";
    $result_total_trames = $db->query($sql_total_trames);
    $total_trames = $result_total_trames->fetchColumn();
    # combien de trames affiché par page.
    $results_per_page = $data['maxPage'];

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
        <select id="paginationSelect">
    <?php foreach (range(1, $total_pages) as $page) : ?>
        <?php $first_trame = ($page - 1) * $results_per_page + 1; ?>
        <?php $url = "aff.php?page=" . $page; ?>
        <option value="<?php echo $url; ?>" <?php if ($current_page == $page) echo 'selected'; ?>>
            Trames <?php echo $first_trame; ?>-<?php echo $first_trame + $results_per_page - 1; ?>
        </option>
    <?php endforeach; ?>
</select>

<script>
    document.getElementById('paginationSelect').addEventListener('change', function() {
        var selectedValue = this.value;
        window.location.href = selectedValue;
    });
</script>
        
<!--
        <details>
        <summary id="sum-filtre">Filtre</summary>
        <div id="container-filtre">
        <form action="filtre.php" id="form-filt" method="post">
                <input type="checkbox" name="date">DATE</input>
                <input type="checkbox" name="b3">B3</input>
                <input type="checkbox" name="b5">B5</input>
                <input type="checkbox" name="size">SIZE</input>
                <input type="checkbox" name="md">Mac Destination</input>
                <input type="checkbox" name="ms">Mac Source</input>
                <input type="checkbox" name="f1">field1</input>
                <input type="checkbox" name="f2">field2</input>
                <input type="checkbox" name="f3">field3</input>
                <input type="checkbox" name="f4">field4</input>
                <input type="checkbox" name="f5">field5</input>
                <input type="checkbox" name="f6">field6</input>
                <input type="checkbox" name="f7">field7</input>
                <input type="checkbox" name="ips">Mac Source</input>
                <input type="checkbox" name="ipd">Mac Destination</input>
                <input type="checkbox" name="f9">field9</input>
                <input type="checkbox" name="f10">field10</input>
                <input type="checkbox" name="f11">field11</input>
                <input type="checkbox" name="f14">field14</input>
                <input type="checkbox" name="f16">field16</input>
                <input type="checkbox" name="f17">field17</input>
                <input type="checkbox" name="f18">field18</input>
                <input type="checkbox" name="f20">field20</input>
                <input type="checkbox" name="f21">field21</input>
                <input type="checkbox" name="f23">field23</input>
                <input type="checkbox" name="f25">field25</input>
                <input type="checkbox" name="f26">field26</input>
                <input type="checkbox" name="f28">field28</input>
                <input type="checkbox" name="f29">field29</input>
                <input type="checkbox" name="f30">field30</input>
                <input type="checkbox" name="f32">field32</input>
                <input type="checkbox" name="pkd">Packet date</input>
                <input type="checkbox" name="mt">Message Type</input>
                <input type="checkbox" name="msend">Mac Sender</input>
                <input type="checkbox" name="mtar">Mac Target</input>
                <input type="checkbox" name="ipsend">IP Sender</input>
                <input type="checkbox" name="iptar">IP Target</input>
        </form>
        </div>
        </details>
-->
        
        
        <?php
        foreach ($enr_aff_trames as $val_aff) {
            if ($val_aff['f1'] == '806') {
                echo "<div>";
                echo "<summary id='titre-trame'>Trame {$val_aff['idTrame']} du test n°{$idTrame}</summary>";
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th id='dte-trame'>" . $data['dteT'] . "</th>";
                echo "<th id='b3'>" . $data['bench3'] . "</th>";
                echo "<th id='b5'>" . $data['bench5'] . "</th>";
                echo "<th id='size'>" . $data['size'] . "</th>";
                echo "<th id='macDest'>" . $data['macDest'] . "</th>";
                echo "<th id='macSource'>" . $data['macSource'] . "</th>";
                echo "<th id='f1'>" . $data['field1'] . "</th>";
                echo "<th id='f2'>" . $data['field2'] . "</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='1' onclick='changeColor(this)'>{$val_aff['dteT']}</td>";
                echo "<td class='2' onclick='changeColor(this)'>{$val_aff['b3']}</td>";
                echo "<td class='3' onclick='changeColor(this)'>{$val_aff['b5']}</td>";
                echo "<td class='4' onclick='changeColor(this)'>{$val_aff['size']}</td>";
                echo "<td class='5' onclick='changeColor(this)'>{$val_aff['macDest']}</td>";
                echo "<td class='6' onclick='changeColor(this)'>{$val_aff['macSource']}</td>";
                echo "<td class='7' onclick='changeColor(this)'>0x{$val_aff['f1']}</td>";
                echo "<td class='8' onclick='changeColor(this)'>{$val_aff['f2']}</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th id='f3'>" . $data['field3'] . "</th>";
                echo "<th id='f4'>" . $data['field4'] . "</th>";
                echo "<th id='f5'>" . $data['field5'] . "</th>";
                echo "<th id='f6'>" . $data['field6'] . "</th>";
                echo "<th id='macSender'>" . $data['macSender'] . "</th>";
                echo "<th id='ipSender'>" . $data['ipSender'] . "</th>";
                echo "<th id='macTarget'>" . $data['macTarget'] . "</th>";
                echo "<th id='ipTarget'>" . $data['ipTarget'] . "</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='9' onclick='changeColor(this)'>{$val_aff['f3']}</td>";
                echo "<td class='10' onclick='changeColor(this)'>{$val_aff['f4']}</td>";
                echo "<td class='11' onclick='changeColor(this)'>{$val_aff['f5']}</td>";
                echo "<td class='12' onclick='changeColor(this)'>{$val_aff['f6']}</td>";
                echo "<td class='13' onclick='changeColor(this)'>{$val_aff['macSender']}</td>";
                echo "<td class='14' onclick='changeColor(this)'>{$val_aff['ipSender']}</td>";
                echo "<td class='15' onclick='changeColor(this)'>{$val_aff['macTarget']}</td>";
                echo "<td class='16' onclick='changeColor(this)'>{$val_aff['ipTarget']}</td>";
                echo "</tr>";
                echo "</table>";
                echo "</div>";
            } elseif ($val_aff['f1'] == '800') {

                echo "<div>";
                echo "<summary id='titre-trame'>Trame {$val_aff['idTrame']} du test n°{$idTrame} </summary>";
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th id='dte-trame'>" . $data['dteT'] . "</th>";
                echo "<th id='b3'>" . $data['bench3'] . "</th>";
                echo "<th id='b5'>" . $data['bench5'] . "</th>";
                echo "<th id='size'>" . $data['size'] . "</th>";
                echo "<th id='macDest'>" . $data['macDest'] . "</th>";
                echo "<th id='macSource'>" . $data['macSource'] . "</th>";
                echo "<th id='f1'>" . $data['field1'] . "</th>";
                echo "<th id='f2'>" . $data['field2'] . "</th>";
                echo "<th id='f3'>" . $data['field3'] . "</th>";
                echo "<th id='f4'>" . $data['field4'] . "</th>";
                echo "<th id='f5'>" . $data['field5'] . "</th>";
                echo "</tr>";

                echo "<tr>";
                echo "<td class='1' onclick='changeColor(this)'>{$val_aff['dteT']}</td>";
                echo "<td class='2' onclick='changeColor(this)'>{$val_aff['b3']}</td>";
                echo "<td class='3' onclick='changeColor(this)'>{$val_aff['b5']}</td>";
                echo "<td class='4' onclick='changeColor(this)'>{$val_aff['size']}</td>";
                echo "<td class='5' onclick='changeColor(this)'>{$val_aff['macDest']}</td>";
                echo "<td class='6' onclick='changeColor(this)'>{$val_aff['macSource']}</td>";
                echo "<td class='7' onclick='changeColor(this)'>0x{$val_aff['f1']}</td>";
                echo "<td class='8' onclick='changeColor(this)'>{$val_aff['f2']}</td>";
                echo "<td class='9' onclick='changeColor(this)'>{$val_aff['f3']}</td>";
                echo "<td class='10' onclick='changeColor(this)'>{$val_aff['f4']}</td>";
                echo "<td class='11' onclick='changeColor(this)'>{$val_aff['f5']}</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th id='f6'>" . $data['field6'] . "</th>";
                echo "<th id='f7'>" . $data['field7'] . "</th>";
                echo "<th id='ipSource'>" . $data['ipSource'] . "</th>";
                echo "<th id='ipDest'>" . $data['ipDest'] . "</th>";
                echo "<th id='f9'>" . $data['field9'] . "</th>";
                echo "<th id='f10'>" . $data['field10'] . "</th>";
                echo "<th id='f11'>" . $data['field11'] . "</th>";
                echo "<th id='f14'>" . $data['field14'] . "</th>";
                echo "<th id='f16'>" . $data['field16'] . "</th>";
                echo "<th id='f17'>" . $data['field17'] . "</th>";
                echo "<th id='f18'>" . $data['field18'] . "</th>";

                echo "</tr>";
                echo "<tr>";
                echo "<td class='12' onclick='changeColor(this)'>{$val_aff['f6']}</td>";
                echo "<td class='17' onclick='changeColor(this)'>{$val_aff['f7']}</td>";
                echo "<td class='18' onclick='changeColor(this)'>{$val_aff['ipSource']}</td>";
                echo "<td class='19' onclick='changeColor(this)'>{$val_aff['ipDest']}</td>";
                echo "<td class='20' onclick='changeColor(this)'>{$val_aff['f9']}</td>";
                echo "<td class='21' onclick='changeColor(this)'>{$val_aff['f10']}</td>";
                echo "<td class='22' onclick='changeColor(this)'>{$val_aff['f11']}</td>";
                echo "<td class='23' onclick='changeColor(this)'>{$val_aff['f14']}</td>";
                echo "<td class='24' onclick='changeColor(this)'>{$val_aff['f16']}</td>";
                echo "<td class='25' onclick='changeColor(this)'>{$val_aff['f17']}</td>";
                echo "<td class='26' onclick='changeColor(this)'>{$val_aff['f18']}</td>";

                echo "</tr>";
                echo "<tr>";
                echo "<th id='f20'>" . $data['field20'] . "</th>";
                echo "<th id='f21'>" . $data['field21'] . "</th>";
                echo "<th id='f23'>" . $data['field23'] . "</th>";
                echo "<th id='f25'>" . $data['field25'] . "</th>";
                echo "<th id='f26'>" . $data['field26'] . "</th>";
                echo "<th id='f28'>" . $data['field28'] . "</th>";
                echo "<th id='f29'>" . $data['field29'] . "</th>";
                echo "<th id='f30'>" . $data['field30'] . "</th>";
                echo "<th id='f32'>" . $data['field32'] . "</th>";
                echo "<th id='pkDte'>" . $data['packetDate'] . "</th>";
                echo "<th id='ft_6'>" . $data['MT'] . "</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class='27' onclick='changeColor(this)'>{$val_aff['f20']}</td>";
                echo "<td class='28' onclick='changeColor(this)'>{$val_aff['f21']}</td>";
                echo "<td class='29' onclick='changeColor(this)'>{$val_aff['f23']}</td>";
                echo "<td class='30' onclick='changeColor(this)'>{$val_aff['f25']}</td>";
                echo "<td class='31' onclick='changeColor(this)'>{$val_aff['f26']}</td>";
                echo "<td class='32' onclick='changeColor(this)'>{$val_aff['f28']}</td>";
                echo "<td class='33' onclick='changeColor(this)'>{$val_aff['f29']}</td>";
                echo "<td class='34' onclick='changeColor(this)'>{$val_aff['f30']}</td>";
                echo "<td class='35' onclick='changeColor(this)'>{$val_aff['f32']}</td>";
                echo "<td class='36' onclick='changeColor(this)'>{$val_aff['pkDte']}</td>";
                echo "<td class='37' onclick='changeColor(this)'>{$val_aff['ft_6']}</td>";
                echo "</tr>";
                echo "</table>";
                echo "</div>";
            }
        }
        ?>
    </section>
    <div id="aff-page">

        <!-- Afficher les liens de pagination -->
        <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
            <?php $first_trame = ($page - 1) * $results_per_page + 1; ?>
            <a id="aff-num" href="aff.php?page=<?php echo $page; ?>" title="Trames <?php echo $first_trame; ?>-<?php echo $first_trame + $results_per_page - 1; ?>">
                <?php echo $page; ?>
            </a>
        <?php endfor; ?>
        <?php
        $db = null;
        ?>
    </div>

    </section>
        
        <a href="#"><div id="up"></div></a><div id="blank"></div>
</body>

</html>
