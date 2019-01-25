<?php
$servername = 'localhost';
$username = 'root';
$password = 'kannon';
$db_name = "camagru_db";

try{
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS camagru_db";
    $conn->exec($sql);

    $conn = new PDO("mysql:host={$servername};dbname={$db_name}",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE TABLE IF NOT EXISTS users (
        user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_mail VARCHAR(100) NOT NULL,
        user_pass VARCHAR(100) NOT NULL,
        user_token VARCHAR(100) NOT NULL
    )";
    $conn->query($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS images (
        image_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(250) NOT NULL,
        'user_id' INT FOREIGN KEY REFERENCES users('user_id')
    )";
    $conn-qeury($sql);

    $sql = "CREATE TABLE IF NOT EXISTS comments (
        comment VARCHAR(1000) NOT NULL,
        image_id INT FOREIGN KEY REFERENCES images('image_id')
    )";
    $conn->query($sql);
}
catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
?>