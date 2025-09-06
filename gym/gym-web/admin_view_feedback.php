<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Check if feedback ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_feedback.php");
    exit;
}

$feedback_id = $_GET['id'];

// Fetch feedback data
$stmt = $conn->prepare("SELECT * FROM user_feedback WHERE sr_no = ?");
$stmt->bind_param("i", $feedback_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: admin_feedback.php");
    exit;
}

$feedback = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback - Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .container {
            padding: 20px;
        }
        .feedback-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .feedback-meta {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .feedback-content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            white-space: pre-wrap;
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
                    <li class="nav-item">
                        <a class="nav-link" href="admin_users.php">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_payments.php">Payments</a>
                    </li>
                    <li class="nav-item active">
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
            <h2>View Feedback</h2>
            <a href="admin_feedback.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Feedback</a>
        </div>
        
        <div class="feedback-container">
            <div class="feedback-meta">
                <h4>Feedback #<?php echo $feedback['sr_no']; ?></h4>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($feedback['name']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($feedback['email']); ?></p>
                    </div>
                </div>
            </div>
            
            <h5>Comment:</h5>
            <div class="feedback-content">
                <?php echo nl2br(htmlspecialchars($feedback['comment'])); ?>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="admin_feedback.php" class="btn btn-secondary"><i class="fas fa-list"></i> Back to List</a>
                <a href="admin_feedback.php?delete=<?php echo $feedback['sr_no']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this feedback?')"><i class="fas fa-trash"></i> Delete Feedback</a>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html> 