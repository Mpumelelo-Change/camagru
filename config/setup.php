<?php
session_start();

$db_host = "localhost";
$db_user = "root";
$db_pass = "kannon";
$db_naam = "camagru_db";

try {
    $conn = new PDO("mysql:host={$db_host};db_name={$db_naam}", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

include_once 'class.user.php';
$user = new USER($conn);
?>