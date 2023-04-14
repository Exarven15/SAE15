<?php 
try {
    $db = new PDO ("mysql:host=localhost;dbname=base",
                   "root","Rionoir2111*");
    $db->exec('SET NAMES utf8');
}
catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>