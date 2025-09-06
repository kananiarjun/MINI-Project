<?php
session_start();
include 'config.php';
include 'header.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Handle feedback deletion
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM user_feedback WHERE sr_no = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $success = "Feedback deleted successfully!";
    } else {
        $error = "Error deleting feedback!";
    }
    $stmt->close();
}

// Fetch all feedback
$result = $conn->query("SELECT * FROM user_feedback ORDER BY sr_no DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Feedback - Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .container {
            padding: 20px;
        }
        .table-responsive {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .action-btns .btn {
            margin-right: 5px;
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
        .comment-text {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
                        <a class="nav-link" href="admin_userschedule.php">
                             Schedule
                        </a>
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
    </nav> -->

    <div class="container">
        <div class="page-header">
            <h2>Manage Feedback</h2>
        </div>
        
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Comment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($feedback = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $feedback['sr_no']; ?></td>
                                <td><?php echo htmlspecialchars($feedback['name']); ?></td>
                                <td><?php echo htmlspecialchars($feedback['email']); ?></td>
                                <td class="comment-text">
                                    <span title="<?php echo htmlspecialchars($feedback['comment']); ?>">
                                        <?php echo htmlspecialchars($feedback['comment']); ?>
                                    </span>
                                </td>
                                <td class="action-btns">
                                    <a href="admin_view_feedback.php?id=<?php echo $feedback['sr_no']; ?>" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> View</a>
                                    <a href="admin_feedback.php?delete=<?php echo $feedback['sr_no']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this feedback?')"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No feedback found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html> 