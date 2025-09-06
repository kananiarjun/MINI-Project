<?php
// save_schedule.php

// Database configuration
$host = 'localhost'; // Your database host
$dbname = 'gym_user'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password
try {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['username'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    }

    // Get the logged-in username from session
    $uname = $_SESSION['username'];
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the JSON data from the request
    $data = json_decode(file_get_contents('php://input'), true);

    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO timetable (user,time, monday, tuesday, wednesday, thursday, friday, saturday, sunday) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");

    // Loop through the data and insert each row
    foreach ($data as $row) {
        $stmt->execute([
            $uname,
            $row['time'],
            $row['monday'],
            $row['tuesday'],
            $row['wednesday'],
            $row['thursday'],
            $row['friday'],
            $row['saturday'],
            $row['sunday']
        ]);
    }

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>