<?php
session_start();
include 'config.php';
include 'header.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Handle user deletion
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM user_data WHERE sr_no = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $success = "User deleted successfully!";
    } else {
        $error = "Error deleting user!";
    }
    $stmt->close();
}

// Fetch all users
$result = $conn->query("SELECT * FROM user_data ORDER BY sr_no DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .container {
            padding: 30px 15px;
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background-color: white !important;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        .page-header {
            background: linear-gradient(135deg, #2980b9, #6dd5fa);
            color: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-header h2 {
            margin-bottom: 0;
            font-weight: 600;
        }
        
        .table-responsive {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .action-btns .btn {
            margin-right: 5px;
            border-radius: 20px;
            padding: 0.25rem 0.8rem;
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 25px;
            padding: 15px 20px;
        }
        
        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            border-color: rgba(40, 167, 69, 0.2);
            color: var(--success-color);
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border-color: rgba(220, 53, 69, 0.2);
            color: var(--danger-color);
        }
        
        .btn-add {
            background-color: var(--success-color);
            border-color: var(--success-color);
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-add:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(40, 167, 69, 0.4);
        }
        
        .btn-info {
            background-color: var(--info-color);
            border-color: var(--info-color);
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .nav-link {
            border-radius: 5px;
            padding: 0.5rem 1rem;
            color: var(--dark-color) !important;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background-color: rgba(0,123,255,0.1);
            color: var(--primary-color) !important;
        }
        
        .nav-link.active {
            background-color: rgba(0,123,255,0.1);
            color: var(--primary-color) !important;
            font-weight: 600;
        }
        
        .logout-btn {
            color: var(--danger-color) !important;
        }
        
        .logout-btn:hover {
            background-color: rgba(220,53,69,0.1);
            color: var(--danger-color) !important;
        }
        
        .table {
            white-space: nowrap;
        }
        
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }
        
        .table tr:hover {
            background-color: rgba(0,123,255,0.03);
        }
        
        .empty-table-message {
            padding: 40px 0;
            text-align: center;
            color: var(--secondary-color);
        }
        
        .empty-table-message i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.6;
        }
    </style>
</head>
<body>
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">
                <i class="fas fa-dumbbell mr-2"></i> GYM Admin
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_users.php">
                            <i class="fas fa-users mr-1"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_userschedule.php">
                            <i class="fas fa-users mr-1"></i> Schedule
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_payments.php">
                            <i class="fas fa-credit-card mr-1"></i> Payments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_feedback.php">
                            <i class="fas fa-comments mr-1"></i> Feedback
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn" href="admin_logout.php">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> -->

    <div class="container">
        <div class="page-header">
            <h2><i class="fas fa-users mr-2"></i> Manage Users</h2>
            <a href="admin_add_user.php" class="btn btn-add">
                <i class="fas fa-plus mr-1"></i> Add New User
            </a>
        </div>
        
        <?php if(isset($success)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle mr-2"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Birth Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                     $result = $conn->query("SELECT * FROM user_data ORDER BY sr_no ASC");
                     if($result->num_rows > 0): ?>
                        <?php while($user = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $user['sr_no']; ?></td>
                                <td><?php echo htmlspecialchars($user['uname']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo $user['b_date']; ?></td>
                                <td class="action-btns">
                                    <a href="admin_edit_user.php?id=<?php echo $user['sr_no']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="admin_users.php?delete=<?php echo $user['sr_no']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-table-message">
                                    <i class="fas fa-users"></i>
                                    <h4>No users found</h4>
                                    <p>Start by adding a new user using the button above.</p>
                                </div>
                            </td>
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