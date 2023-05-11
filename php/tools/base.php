<?php 
include 'function.php';
try {
    $db = new PDO ("mysql:host=localhost;dbname=base",
                   "root",$pass);
    $db->exec('SET NAMES utf8');
}
catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>