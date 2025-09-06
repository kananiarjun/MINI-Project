<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "gym_user";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['comment'];
    
    // Insert into database
    $sql = "INSERT INTO user_feedback (name, email, comment) VALUES ('$name', '$email', '$comment')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Feedback submitted successfully!";
        header("location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
    ?>