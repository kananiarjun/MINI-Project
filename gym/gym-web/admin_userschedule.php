<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection and header
include 'database.php'; // This file must return a PDO connection in $conn
include 'header.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}

// Get the logged-in username
$uname = $_SESSION['admin_username'];

// Fetch user-defined timetable using PDO
$sql = "SELECT * FROM timetable WHERE user = :uname ORDER BY time ASC";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
$stmt->execute();
$user_timetable = $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns array of rows
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Timetable</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .class-timetable {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
        th, td {
            padding: 15px;
            border: 1px solid #ddd;
        }
        th {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            font-weight: 600;
        }
        td {
            background: #f9f9f9;
            transition: background 0.3s ease;
        }
        td:hover {
            background: #28a745;
            color: white;
            cursor: pointer;
        }
        .dark-bg {
            background: #ffd700;
            color: black;
        }
        .hover-bg:hover {
            background: #28a745 !important;
            color: white;
        }
        .primary-btn {
            display: inline-block;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            transition: background 0.3s ease;
        }
        .primary-btn:hover {
            background: linear-gradient(135deg, #0056b3, #007bff);
        }
        .text-center {
            text-align: center;
        }
        .mt-4 {
            margin-top: 1.5rem;
        }
        .mt-5 {
            margin-top: 3rem;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -10px;
        }
        .col-lg-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 10px;
        }
        .class-time {
            font-weight: 500;
            color: #007bff;
        }
        .fas {
            margin-right: 5px;
        }
        header, footer {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        header h1, footer p {
            margin: 0;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background-color: white !important;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
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
    </style>
</head>
<body>
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="admin_dashboard.php">
            <i class="fas fa-dumbbell me-2"></i> GYM Admin
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_users.php">
                        <i class="fas fa-users me-1"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="admin_userschedule.php">
                        <i class="fas fa-calendar-alt me-1"></i> Schedule
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_payments.php">
                        <i class="fas fa-credit-card me-1"></i> Payments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_feedback.php">
                        <i class="fas fa-comments me-1"></i> Feedback
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link logout-btn" href="admin_logout.php">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav> -->

    <div class="container mt-4">
        <h2>Default Timetable</h2>
        <!-- Default Timetable Section -->
        <?php include 'default_timetable.html'; ?>

        <!-- User Customized Schedule Section -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="class-timetable">
                    <h2>Customized Timetable - <?php echo htmlspecialchars($uname); ?></h2>
                    <?php if (!empty($user_timetable)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th><i class="fas fa-clock"></i>Time</th>
                                    <th><i class="fas fa-calendar-day"></i>Monday</th>
                                    <th><i class="fas fa-calendar-day"></i>Tuesday</th>
                                    <th><i class="fas fa-calendar-day"></i>Wednesday</th>
                                    <th><i class="fas fa-calendar-day"></i>Thursday</th>
                                    <th><i class="fas fa-calendar-day"></i>Friday</th>
                                    <th><i class="fas fa-calendar-day"></i>Saturday</th>
                                    <th><i class="fas fa-calendar-day"></i>Sunday</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_timetable as $row): ?>
                                    <tr>
                                        <td class="class-time"> <?php echo htmlspecialchars($row['time']); ?> </td>
                                        <td class="dark-bg hover-bg"> <?php echo htmlspecialchars($row['monday']); ?> </td>
                                        <td class="hover-bg"> <?php echo htmlspecialchars($row['tuesday']); ?> </td>
                                        <td class="dark-bg hover-bg"> <?php echo htmlspecialchars($row['wednesday']); ?> </td>
                                        <td class="hover-bg"> <?php echo htmlspecialchars($row['thursday']); ?> </td>
                                        <td class="dark-bg"> <?php echo htmlspecialchars($row['friday']); ?> </td>
                                        <td class="hover-bg"> <?php echo htmlspecialchars($row['saturday']); ?> </td>
                                        <td class="dark-bg"> <?php echo htmlspecialchars($row['sunday']); ?> </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-center">No customized timetable found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn = null; // Close PDO connection
?>
