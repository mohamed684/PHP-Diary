<?php 

try {
    $pdo = new PDO('mysql:host=localhost;dbname=diary', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch(PDOException $e) {
    echo 'A problem occured with the database connection...';
    die();
}