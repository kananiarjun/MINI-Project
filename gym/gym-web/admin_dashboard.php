<?php
session_start();
include 'config.php';
include'header.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Fetch statistics
$stats = array();

// Total users
$result = $conn->query("SELECT COUNT(*) as total FROM user_data");
$stats['total_users'] = $result->fetch_assoc()['total'];

// Total payments
$result = $conn->query("SELECT COUNT(*) as total FROM payment");
$stats['total_payments'] = $result->fetch_assoc()['total'];

// Total feedback
$result = $conn->query("SELECT COUNT(*) as total FROM user_feedback");
$stats['total_feedback'] = $result->fetch_assoc()['total'];

// Recent users
$recent_users = $conn->query("SELECT * FROM user_data ORDER BY sr_no DESC LIMIT 5");

// Calculate total revenue
$result = $conn->query("SELECT SUM(CAST(REPLACE(REPLACE(REPLACE(plan_price, '₹', ''), '$', ''), ',', '') AS DECIMAL(10,2))) as total_revenue FROM payment WHERE plan_price != ''");
$revenue = $result->fetch_assoc()['total_revenue'];
$stats['total_revenue'] = $revenue ? "₹" . number_format($revenue, 2) : "₹0.00";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gym Management System</title>
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
        
        .dashboard-container {
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
        
        .welcome-section {
            background: linear-gradient(135deg, #2980b9, #6dd5fa);
            color: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .welcome-section h2 {
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .welcome-section p {
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .stats-card {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border-left: 5px solid transparent;
        }
        
        .stats-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .stats-card.users-card {
            border-left-color: var(--primary-color);
        }
        
        .stats-card.payments-card {
            border-left-color: var(--success-color);
        }
        
        .stats-card.feedback-card {
            border-left-color: var(--info-color);
        }
        
        .stats-card.revenue-card {
            border-left-color: var(--warning-color);
        }
        
        .stats-card i {
            font-size: 2.5em;
            margin-bottom: 15px;
            opacity: 0.8;
        }
        
        .stats-card h3 {
            font-size: 2em;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stats-card p {
            color: var(--secondary-color);
            margin-bottom: 0;
            font-weight: 500;
        }
        
        .recent-users {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-top: 10px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        
        .section-header h3 {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        .table {
            white-space: nowrap;
        }
        
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }
        
        .btn-sm {
            border-radius: 20px;
            padding: 0.25rem 0.8rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .nav-item {
            margin-left: 5px;
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
        
        @media (max-width: 768px) {
            .stats-card {
                margin-bottom: 20px;
            }
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
                        <a class="nav-link active" href="admin_dashboard.php">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_users.php">
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

    <div class="container dashboard-container">
        <div class="welcome-section">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h2>
            <p>Here's an overview of your gym management system.</p>
        </div>
        
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <a href="admin_users.php" class="text-decoration-none">
                    <div class="stats-card users-card text-center">
                        <i class="fas fa-users text-primary"></i>
                        <h3><?php echo $stats['total_users']; ?></h3>
                        <p>Total Users</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="admin_payments.php" class="text-decoration-none">
                    <div class="stats-card payments-card text-center">
                        <i class="fas fa-credit-card text-success"></i>
                        <h3><?php echo $stats['total_payments']; ?></h3>
                        <p>Total Payments</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="admin_feedback.php" class="text-decoration-none">
                    <div class="stats-card feedback-card text-center">
                        <i class="fas fa-comments text-info"></i>
                        <h3><?php echo $stats['total_feedback']; ?></h3>
                        <p>Total Feedback</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="admin_payments.php" class="text-decoration-none">
                    <div class="stats-card revenue-card text-center">
                        <i class="fas fa-rupee-sign text-warning"></i>
                        <h3><?php echo $stats['total_revenue']; ?></h3>
                        <p>Total Revenue</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="recent-users">
                    <div class="section-header">
                        <h3><i class="fas fa-users mr-2"></i> Recent Users</h3>
                        <a href="admin_users.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye mr-1"></i> View All
                        </a>
                    </div>
                    <div class="table-container">
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
                                $recent_users = $conn->query("SELECT * FROM user_data ORDER BY sr_no ASC");
                                if($recent_users->num_rows > 0): ?>
                                    <?php while($user = $recent_users->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $user['sr_no']; ?></td>
                                        <td><?php echo htmlspecialchars($user['uname']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo $user['b_date']; ?></td>
                                        <td>
                                            <a href="admin_edit_user.php?id=<?php echo $user['sr_no']; ?>" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="admin_users.php?delete=<?php echo $user['sr_no']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No users found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html> 