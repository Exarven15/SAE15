<?php
session_start();
include('base.php');
$rep = $_GET['ok'];

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
            <li id="home"><a href="../../index.php">Home</a></li>
            <li id="favoris"><a href="">Config</a></li>
        </ul>
    </nav>
    <div id="container-conf">
        <?php
        $json_data = file_get_contents('/home/exarven/Documents/config.json');
        $data = json_decode($json_data, true);
        ?>
        <form action="modif.php" id="form-conf" method="post">
            <div id="parent">
                <div id="f-child">
                    <label for="obsw"><?php echo $data['obsw'] ?> :</label>
                    <input type="text" id="obsw" name="obsw" value="<?php echo $data->obsw; ?>"><br>

                    <label for="bds"><?php echo $data['bds'] ?> :</label>
                    <input type="text" id="bds" name="bds" value="<?php echo $data->bds; ?>"><br>

                    <label for="tv"><?php echo $data['tv'] ?> :</label>
                    <input type="text" id="tv" name="tv" value="<?php echo $data->tv; ?>"><br>

                    <label for="dte"><?php echo $data['dte'] ?> :</label>
                    <input type="text" id="dte" name="dte" value="<?php echo $data->dte; ?>"><br>

                    <label for="nomFic"><?php echo $data['nomFic'] ?> :</label>
                    <input type="text" id="nomFic" name="nomFic" value="<?php echo $data->nomFic; ?>"><br>

                    <label for="dteT"><?php echo $data['dteT'] ?> :</label>
                    <input type="text" id="dteT" name="dteT" value="<?php echo $data->dteT; ?>"><br>

                    <label for="size"><?php echo $data['size'] ?> :</label>
                    <input type="text" id="size" name="size" value="<?php echo $data->size; ?>"><br>

                    <label for="macSource"><?php echo $data['macSource'] ?> :</label>
                    <input type="text" id="macSource" name="macSource" value="<?php echo $data->macSource; ?>"><br>

                    <label for="macDest"><?php echo $data['macDest'] ?> :</label>
                    <input type="text" id="macDest" name="macDest" value="<?php echo $data->macDest; ?>"><br>

                    <label for="macSender"><?php echo $data['macSender'] ?> :</label>
                    <input type="text" id="macSender" name="macSender" value="<?php echo $data->macSender; ?>"><br>

                    <label for="ipSender"><?php echo $data['ipSender'] ?> :</label>
                    <input type="text" id="ipSender" name="ipSender" value="<?php echo $data->ipSender; ?>"><br>
                </div>

                <div id="s-child">
                    <label for="macTarget"><?php echo $data['macTarget'] ?> :</label>
                    <input type="text" id="macTarget" name="macTarget" value="<?php echo $data->macTarget; ?>"><br>

                    <label for="ipTarget"><?php echo $data['ipTarget'] ?> :</label>
                    <input type="text" id="ipTarget" name="ipTarget" value="<?php echo $data->ipTarget; ?>"><br>

                    <label for="ipSource"><?php echo $data['ipSource'] ?> :</label>
                    <input type="text" id="ipSource" name="ipSource" value="<?php echo $data->ipSource; ?>"><br>

                    <label for="ipDest"><?php echo $data['ipDest'] ?> :</label>
                    <input type="text" id="ipDest" name="ipDest" value="<?php echo $data->ipDest; ?>"><br>

                    <label for="bench3"><?php echo $data['bench3'] ?> :</label>
                    <input type="text" id="bench3" name="bench3" value="<?php echo $data->bench3; ?>"><br>

                    <label for="bench5"><?php echo $data['bench5'] ?> :</label>
                    <input type="text" id="bench5" name="bench5" value="<?php echo $data->bench5; ?>"><br>

                    <label for="field1"><?php echo $data['field1'] ?> :</label>
                    <input type="text" id="field1" name="field1" value="<?php echo $data->field1; ?>"><br>

                    <label for="field2"><?php echo $data['field2'] ?> :</label>
                    <input type="text" id="field2" name="field2" value="<?php echo $data->field2; ?>"><br>

                    <label for="field3"><?php echo $data['field3'] ?> :</label>
                    <input type="text" id="field3" name="field3" value="<?php echo $data->field3; ?>"><br>

                    <label for="field4"><?php echo $data['field4'] ?> :</label>
                    <input type="text" id="field4" name="field4" value="<?php echo $data->field4; ?>"><br>

                    <label for="field5"><?php echo $data['field5'] ?> :</label>
                    <input type="text" id="field5" name="field5" value="<?php echo $data->field5; ?>"><br>
                </div>
                <div id="t-child">

                    <label for="field6"><?php echo $data['field6'] ?> :</label>
                    <input type="text" id="field6" name="field6" value="<?php echo $data->field6; ?>"><br>

                    <label for="field7"><?php echo $data['field7'] ?> :</label>
                    <input type="text" id="field7" name="field7" value="<?php echo $data->field7; ?>"><br>

                    <label for="field9"><?php echo $data['field9'] ?> :</label>
                    <input type="text" id="field9" name="field9" value="<?php echo $data->field9; ?>"><br>

                    <label for="field10"><?php echo $data['field10'] ?> :</label>
                    <input type="text" id="field10" name="field10" value="<?php echo $data->field10; ?>"><br>

                    <label for="field11"><?php echo $data['field11'] ?> :</label>
                    <input type="text" id="field11" name="field11" value="<?php echo $data->field11; ?>"><br>

                    <label for="field12"><?php echo $data['field12'] ?> :</label>
                    <input type="text" id="field12" name="field12" value="<?php echo $data->field12; ?>"><br>

                    <label for="field14"><?php echo $data['field14'] ?> :</label>
                    <input type="text" id="field14" name="field14" value="<?php echo $data->field14; ?>"><br>

                    <label for="field16"><?php echo $data['field16'] ?> :</label>
                    <input type="text" id="field16" name="field16" value="<?php echo $data->field16; ?>"><br>

                    <label for="field17"><?php echo $data['field17'] ?> :</label>
                    <input type="text" id="field17" name="field17" value="<?php echo $data->field17; ?>"><br>

                    <label for="field18"><?php echo $data['field18'] ?> :</label>
                    <input type="text" id="field18" name="field18" value="<?php echo $data->field18; ?>"><br>

                    <label for="field20"><?php echo $data['field20'] ?> :</label>
                    <input type="text" id="field20" name="field20" value="<?php echo $data->field20; ?>"><br>
                </div>

                <div id="fo-child">
                    <label for="field21"><?php echo $data['field21'] ?> :</label>
                    <input type="text" id="field21" name="field21" value="<?php echo $data->field21; ?>"><br>

                    <label for="field23"><?php echo $data['field23'] ?> :</label>
                    <input type="text" id="field23" name="field23" value="<?php echo $data->field23; ?>"><br>

                    <label for="field25"><?php echo $data['field25'] ?> :</label>
                    <input type="text" id="field25" name="field25" value="<?php echo $data->field25; ?>"><br>

                    <label for="field26"><?php echo $data['field26'] ?> :</label>
                    <input type="text" name="field26" value="<?php echo $data->field26; ?>">

                    <label for="field27"><?php echo $data['field27'] ?> :</label>
                    <input type="text" name="field27" value="<?php echo $data->field27; ?>">

                    <label for="field28"><?php echo $data['field28'] ?> :</label>
                    <input type="text" name="field28" value="<?php echo $data->field28; ?>">

                    <label for="field29"><?php echo $data['field29'] ?> :</label>
                    <input type="text" name="field29" value="<?php echo $data->field29; ?>">

                    <label for="field30"><?php echo $data['field30'] ?> :</label>
                    <input type="text" name="field30" value="<?php echo $data->field30; ?>">

                    <label for="field32"><?php echo $data['field32'] ?> :</label>
                    <input type="text" name="field32" value="<?php echo $data->field32; ?>">

                    <label for="packetDate"><?php echo $data['packetDate'] ?> :</label>
                    <input type="text" name="packetDate" value="<?php echo $data->packetDate; ?>">

                    <label for="ft_6"><?php echo $data['MT'] ?> :</label>
                    <input type="text" name="ft_6" value="<?php echo $data->MT; ?>">

                    <label for="maxPage">range page = <?php echo $data['maxPage'] ?> :</label>
                    <input type="number" name="maxPage" value="<?php echo $data->maxPage; ?>">
                </div>
            </div>
            <div id="env-conf">
                <input type="submit" id="sub" value="MODIFIER">
            </div>

            <?php
                if ($rep == "100"){
                    $message = "La ou les modifications ont été effectuer avec succès";
                    echo '<script>alert("'.$message.'");</script>';
                }
            ?>
        </form>

    </div>
</body>

</html>
<script src="JS/script.js"></script>