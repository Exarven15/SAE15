<?php
session_start();
include('tools/base.php');
$nomFichier = $_POST['nom-fic'];
$date = $_POST['date'];
$date = str_replace('_', ' ', $date);
$supp = $_POST['suppri'];

$sql_fic = "SELECT * FROM fichier WHERE dte=:dte;";
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

$sql_i = "SELECT idTrame FROM trames;";
$req_i = $db->prepare($sql_i);
$req_i -> execute();
$enr_i = $req_i->fetchAll();
$req_i->closeCursor();

$sql_type_trame = "SELECT f1 FROM trames WHERE idFichier IN (SELECT id FROM fichier)";
$req_type_trame = $db->prepare($sql_type_trame);
$req_type_trame->execute();
$enr_type_trame = $req_type_trame->fetchAll();
$req_type_trame->closeCursor();

foreach ($enr_id_trames as $val_idT) $idTrames = $val_idT['idFichier'];
foreach ($enr_i as $val_i ) $i = $val_i['idTrame'];
foreach ($enr_type_trame as $val_type_trame) $typeTrames = $val_type_trame['f1'];

foreach ($enr_fic as $val) {
    $id = $val['id']. " " ;
    $obsw = $val['obsw'];
    $bds = $val['bds'];
    $tv = $val['tv'];
}

if ($supp == "SUPPRIMER") {
    
    // Suppression de l'enregistrement dans la table fichier et 
    // de tous les enregistrements correspondants dans la table trames
    $sql_suppression1 = "DELETE FROM trames WHERE idFichier = :idFichier;";
    $req_suppression1 = $db->prepare($sql_suppression1);
    $req_suppression1->bindParam(':idFichier', $id);
    $req_suppression1->execute();
    $req_suppression1->closeCursor();

    $sql_suppression = "DELETE FROM fichier WHERE nomFic = :nomFic AND dte = :dte;";
    $req_suppression = $db->prepare($sql_suppression);
    $req_suppression->bindParam(':nomFic', $nomFichier);
    $req_suppression->bindParam(':dte', $date);
    $req_suppression->execute();
    $req_suppression->closeCursor();
    header("Location: ../index.php?suppr=150");
    
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
    $_SESSION['i'] = $i ;

    header('Location: aff.php');
}
