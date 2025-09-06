<?php
session_start();
include 'config.php';

// Create default admin if no admin exists
$result = $conn->query("SELECT COUNT(*) as count FROM admin_users");
$row = $result->fetch_assoc();
if ($row['count'] == 0) {
    $default_username = "admin";
    $default_email = "admin@example.com";
    $default_password = password_hash("admin123", PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO admin_users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $default_username, $default_email, $default_password);
    $stmt->execute();
    $stmt->close();
    
    echo "Default admin created! Username: admin, Password: admin123";
}

// Redirect if already logged in
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_dashboard.php");
    exit;
}

$error = "";
$success = "";

// Process registration form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT id FROM admin_users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Username or email already exists";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new admin
            $stmt = $conn->prepare("INSERT INTO admin_users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            
            if ($stmt->execute()) {
                $success = "Admin registered successfully! You can now login.";
            } else {
                $error = "Error registering admin: " . $conn->error;
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - Gym Management System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .register-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .error-message {
            color: #dc3545;
            margin-bottom: 15px;
        }
        .success-message {
            color: #28a745;
            margin-bottom: 15px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <h2 class="text-center mb-4">Admin Registration</h2>
            
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            
            <div class="text-center mt-3">
                <a href="admin_login.php">Already have an account? Login here</a>
            </div>
        </div>
    </div>
</body>
</html> 