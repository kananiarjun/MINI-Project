<?php

// database.php - Database Connection
$host = 'localhost';
$dbname = 'gym_user';
$username = 'root'; // Change as per your DB
$password = ''; // Change as per your DB

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>