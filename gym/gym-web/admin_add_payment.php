<?php
session_start();
include 'database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

$error = "";
$success = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $card_number = trim($_POST['card_number']);
    $expiry = trim($_POST['expiry']);
    $cvv = trim($_POST['cvv']);
    $plan_name = trim($_POST['plan_name']);
    $plan_price = trim($_POST['plan_price']);
    
    // Simple validation
    if (empty($name) || empty($checkin) || empty($checkout) || empty($card_number) || empty($expiry) || empty($cvv) || empty($plan_name) || empty($plan_price)) {
        $error = "All fields are required";
    } elseif (!is_numeric($card_number) || strlen($card_number) != 16) {
        $error = "Invalid card number";
    } elseif (!is_numeric($cvv) || strlen($cvv) != 3) {
        $error = "Invalid CVV";
    } elseif (!is_numeric($plan_price) || $plan_price <= 0) {
        $error = "Invalid plan price";
    } else {
        // Insert payment record
        $stmt = $conn->prepare("INSERT INTO payments (name, checkin, checkout, card_number, expiry, cvv, plan_name, plan_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssd", $name, $checkin, $checkout, $card_number, $expiry, $cvv, $plan_name, $plan_price);
        
        if ($stmt->execute()) {
            $success = "Payment added successfully!";
        } else {
            $error = "Error adding payment: " . $conn->error;
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
    <title>Add Payment - Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">GYM Admin</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Add Payment</h2>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"> <?php echo $success; ?> </div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"> <?php echo $error; ?> </div>
        <?php endif; ?>
        
        <form method="POST" action="admin_payment_process.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="checkin">Check-in Date</label>
                <input type="date" class="form-control" id="checkin" name="checkin" required>
            </div>
            <div class="form-group">
                <label for="checkout">Check-out Date</label>
                <input type="date" class="form-control" id="checkout" name="checkout" required>
            </div>
            <div class="form-group">
                <label for="card_number">Card Number</label>
                <input type="text" class="form-control" id="card_number" name="card_number" maxlength="16" required>
            </div>
            <div class="form-group">
                <label for="expiry">Expiry Date</label>
                <input type="month" class="form-control" id="expiry" name="expiry" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" required>
            </div>
            <div class="form-group">
                <label for="plan_name">Plan Name</label>
                <input type="text" class="form-control" id="plan_name" name="plan_name" required>
            </div>
            <div class="form-group">
                <label for="plan_price">Plan Price ($)</label>
                <input type="number" step="0.01" class="form-control" id="plan_price" name="plan_price" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
    </div>
</body>
</html>
