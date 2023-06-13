<?php 
session_start();
include_once('tools/base.php');
$fitlre = $_POST['filtre'];

$sql_fil = "SELECT f1 FROM trames WHERE f1=:filtre;";
$req_fil = $db->prepare($sql_fil);
$req_fil->bindParam(":filtre", $fitlre);
$req_fil->execute();
$enr_fil = $req_fil->fetchAll();
$req_fil->closeCursor();

foreach ($enr_fil as $val_fil) $resFiltre = $val_fil['f1'];

header("Location: aff.php");
?>