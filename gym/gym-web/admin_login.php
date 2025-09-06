<?php
session_start();
include 'config.php';

// Redirect if already logged in
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_dashboard.php");
    exit;
}

$error = "";

// Process login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password";
    } else {
        // Check against admin_users table
        $stmt = $conn->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password, $row['password'])) {
                // Set session variables
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $row['username'];
                
                // Redirect to dashboard
                header("Location: admin_dashboard.php");
                exit;
            } else {
                $error = "Invalid username or password ";
            }
        } else {
            $error = "Admin not found";
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
    <title>Admin Login - Gym Management System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h2 {
            color: #333;
            font-weight: 600;
        }
        .login-header img {
            max-width: 80px;
            margin-bottom: 20px;
        }
        .error-message {
            color: #dc3545;
            margin-bottom: 15px;
            padding: 10px;
            background-color: rgba(220, 53, 69, 0.1);
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 5px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
        }
        .btn-primary {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            background-color: #007bff;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0069d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 105, 217, 0.3);
        }
        .footer-link {
            text-align: center;
            margin-top: 20px;
        }
        .footer-link a {
            color: #007bff;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .footer-link a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="img/logo.png" alt="Gym Logo" onerror="this.src='https://via.placeholder.com/80x80?text=GYM'">
            <h2>Admin Login</h2>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>
            </div>
            
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="footer-link">
            <a href="admin_register.php">Need an account? Register here</a>
        </div>
        
        <div class="footer-link">
            <a href="index.php"><i class="fas fa-home"></i> Back to Website</a>
        </div>
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html> 