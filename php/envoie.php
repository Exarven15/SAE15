<?php
session_start();
include('base.php');
$nomFichier = $_POST['nom-fic'];
$date = $_POST['date'];
$date = str_replace('_', ' ', $date);

$sql_fic= "SELECT * FROM fichier WHERE dte=:dte;";
$req_fic = $db->prepare($sql_fic);
$req_fic->bindParam(":dte", $date);
$req_fic->execute();
$enr_fic = $req_fic->fetchAll();
$req_fic->closeCursor();

$sql_id_trames = "SELECT idFichier FROM trames ;";
$req_id_trames = $db->prepare($sql_id_trames);
$req_id_trames->execute();
$enr_id_trames = $req_id_trames->fetchAll();
$req_id_trames->closeCursor();

$sql_type_trame = "SELECT f1 FROM trames WHERE idFichier IN (SELECT id FROM fichier)";
$req_type_trame = $db->prepare($sql_type_trame);
$req_type_trame->execute();
$enr_type_trame = $req_type_trame->fetchAll();
$req_type_trame->closeCursor();

foreach($enr_id_trames as $val_idT) $idTrames = $val_idT['id'] ;

foreach($enr_type_trame as $val_type_trame) $typeTrames = $val_type_trame['f1'] ;

foreach ($enr_fic as $val){
    $id = $val['id'] . " ";  
    $obsw = $val['obsw'];
    $bds = $val['bds'];
    $tv = $val['tv'];
} 


if ($date != $date) {
    header('Location: nextForm.php?error=1');
    exit();
} else {
    # Ce sont les valeurs de l'entête du fichier choisis pour éviter de faire plusieurs requêtes j'en fais qu'une et je fais des sessions.
    $_SESSION['id'] = $id;
    $_SESSION['obsw'] = $obsw;
    $_SESSION['bds'] = $bds;
    $_SESSION['tv'] = $tv;
    $_SESSION['date'] = $date;
    $_SESSION['nomFic'] = $nomFichier;

    $_SESSION['type-trame'] = $typeTrames;
    $_SESSION['idTrames'] = $idTrames;

    
    header('Location: aff.php');
}
