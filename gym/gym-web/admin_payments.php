<?php
session_start();
include 'config.php';
include 'header.php';
// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Handle payment deletion
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM payment WHERE SR_NO = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $success = "Payment deleted successfully!";
    } else {
        $error = "Error deleting payment!";
    }
    $stmt->close();
}
//Handle Edit
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM payment WHERE SR_NO = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $paymentData = $result->fetch_assoc();
        // Now $paymentData contains the current data, which you can use
        // to pre-fill your edit form inputs.
    } else {
        $error = "Payment record not found!";
    }
    $stmt->close();
}

if (isset($_POST['update']) && isset($_POST['id'])) {
    $id = $_POST['id']; // SR_NO of payment to update

    // Collect and sanitize your input fields, e.g.:
    $name = $_POST['name'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $card_number = $_POST['card_number'];
    $expiry = $_POST['expiry'];
    $plan_name = $_POST['plan_name'];
    $plan_price = $_POST['plan_price'];

    // Prepare update statement — adjust the fields as per your table schema
    $stmt = $conn->prepare("UPDATE payment SET name = ?, checkin = ?, checkout = ?, card_number = ?, expiry = ?, plan_name = ?, plan_price = ? WHERE SR_NO = ?");
    $stmt->bind_param("ssssssdi", $name, $checkin, $checkout, $card_number, $expiry, $plan_name, $plan_price, $id);

    if ($stmt->execute()) {
        $success = "Payment updated successfully!";
    } else {
        $error = "Error updating payment!";
    }
    $stmt->close();
}


// Fetch all payments
$result = $conn->query("SELECT * FROM payment ORDER BY SR_NO DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments - Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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

    <div class="container">
        <div class="page-header">
            <h2>Manage Payments</h2>
            <a href="admin_add_payment.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Payment</a>
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
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Plan Name</th>
                        <th>Plan Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($payment = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $payment['SR_NO']; ?></td>
                                <td><?php echo htmlspecialchars($payment['name']); ?></td>
                                <td><?php echo $payment['checkin']; ?></td>
                                <td><?php echo $payment['checkout']; ?></td>
                                <td><?php echo htmlspecialchars($payment['plan_name']); ?></td>
                                <td><?php echo htmlspecialchars($payment['plan_price']); ?></td>
                                <td class="action-btns">
                                    <a href="admin_edit_payment.php?id=<?php echo $payment['SR_NO']; ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="admin_payments.php?delete=<?php echo $payment['SR_NO']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this payment?')"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No payments found</td>
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