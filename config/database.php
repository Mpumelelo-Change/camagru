<?php
$servername = 'localhost';
$username = 'root';
$password = 'kannon';
$db_name = "camagru_db";

try{
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    $conn->exec($sql);
    
    $conn = new PDO("mysql:host={$servername};dbname={$db_name}",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE TABLE IF NOT EXISTS $db_name.`users` (
        user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_mail VARCHAR(100) NOT NULL,
        user_name VARCHAR(20) NOT NULL,
        user_pass VARCHAR(100) NOT NULL,
        user_token VARCHAR(100) NOT NULL,
        `user_stat` enum('Y', 'N') NOT NULL DEFAULT 'N'
    )";
    $conn->query($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS $db_name.`images` (
        `image_id` INT(16) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `title` TEXT(250000) NOT NULL,
        `user_id` INT UNSIGNED,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
    )";
    $conn->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS $db_name.`comments` (
    `comment` VARCHAR(1000) NOT NULL PRIMARY KEY,
    `image_id` INT(16) UNSIGNED,
    FOREIGN KEY (`image_id`) REFERENCES `images`(`image_id`) ON DELETE CASCADE ON UPDATE CASCADE

    )";
    $conn->query($sql);
}
catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
?>