<?php
session_start();
$username = $_SESSION['username'];
require('db.php');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br />";
    die();
}

$sql = "UPDATE customers SET losses = losses + 1 WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":username",$username);
$stmt->execute();

?>
