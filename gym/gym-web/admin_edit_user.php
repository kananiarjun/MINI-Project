<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Check if user ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_users.php");
    exit;
}

$user_id = $_GET['id'];
$error = "";
$success = "";

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM user_data WHERE sr_no = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: admin_users.php");
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// Process edit form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $birth_date = $_POST['birth_date'];
    
    // Check if password is being updated
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE user_data SET uname = ?, email = ?, b_date = ?, pass = ? WHERE sr_no = ?");
        $stmt->bind_param("ssssi", $username, $email, $birth_date, $password, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE user_data SET uname = ?, email = ?, b_date = ? WHERE sr_no = ?");
        $stmt->bind_param("sssi", $username, $email, $birth_date, $user_id);
    }
    
    if ($stmt->execute()) {
        $success = "User updated successfully!";
    } else {
        $error = "Error updating user: " . $conn->error;
    }
    $stmt->close();
    
    // Refresh user data after update
    $stmt = $conn->prepare("SELECT * FROM user_data WHERE sr_no = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .container {
            padding: 20px;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">Gym Management System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="admin_users.php">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_payments.php">Payments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_feedback.php">Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn" href="admin_logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h2>Edit User</h2>
            <a href="admin_users.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Users</a>
        </div>
        
        <?php if(!empty($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if(!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['uname']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="birth_date">Birth Date:</label>
                    <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?php echo $user['b_date']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">New Password (leave blank to keep current):</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update User</button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html> 