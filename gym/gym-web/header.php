<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* CSS */
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --danger-color: #dc3545;
            --dark-color: #343a40;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 30px 15px;
        }

        /* Navbar styles */
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background-color: white !important;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
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

        /* Logout button */
        .logout-btn {
            color: var(--danger-color) !important;
        }

        .logout-btn:hover {
            background-color: rgba(220,53,69,0.1);
            color: var(--danger-color) !important;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .stats-card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">
                <i class="fas fa-dumbbell mr-2"></i> GYM Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">
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
                            <i class="fas fa-calendar-alt mr-1"></i> Schedule
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
    </nav>

    <!-- Page Header Section -->
   



    <!-- Optional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
