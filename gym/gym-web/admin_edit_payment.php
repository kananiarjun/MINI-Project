<?php
// admin_edit_payment.php
session_start();

// Check admin login
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: login2.php");
    exit;
}

// Include DB connection
require_once 'database.php';

// Initialize variables
$errors = [];
$success_msg = "";

// Handle update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_payment'])) {
    $payment_id = intval($_POST['payment_id']);
    $name = trim($_POST['name']);
    $checkin = trim($_POST['checkin']);
    $checkout = trim($_POST['checkout']);
    $card_number = trim($_POST['card_number']);
    $expiry = trim($_POST['expiry']);
    $plan_name = trim($_POST['plan_name']);
    $plan_price = floatval($_POST['plan_price']);

    // Basic validation
    if ($name === '') $errors[] = "Name is required.";
    if ($checkin === '') $errors[] = "Check-in date is required.";
    if ($checkout === '') $errors[] = "Check-out date is required.";
    if (!preg_match('/^\d{16}$/', $card_number)) $errors[] = "Card number must be exactly 16 digits.";
    if ($expiry === '') $errors[] = "Expiry is required.";
    if ($plan_name === '') $errors[] = "Plan name is required.";
    if ($plan_price <= 0) $errors[] = "Plan price must be greater than zero.";

    if (empty($errors)) {
        // Update query
        $stmt = $conn->prepare("UPDATE payment SET name = ?, checkin = ?, checkout = ?, card_number = ?, expiry = ?, plan_name = ?, plan_price = ? WHERE id = ?");
        $stmt->bind_param("ssssssdi", $name, $checkin, $checkout, $card_number, $expiry, $plan_name, $plan_price, $payment_id);
        
        if ($stmt->execute()) {
            $success_msg = "Payment record updated successfully.";
        } else {
            $errors[] = "Failed to update payment record: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch a payment record if edit ID passed via GET
$edit_payment = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $stmt = $conn->prepare("SELECT id, name, checkin, checkout, card_number, expiry, plan_name, plan_price FROM payment WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_payment = $result->fetch_assoc();
    $stmt->close();
}

// Fetch all payments for display
$payments = [];
$result = $conn->query("SELECT id, name, checkin, checkout, card_number, expiry, plan_name, plan_price FROM payment ORDER BY id DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Edit Payments</title>
    <style>
      body { font-family: Arial, sans-serif; padding: 1rem; background: #f4f6f8; }
      h1 { color: #007bff; }
      table { border-collapse: collapse; width: 100%; margin-bottom: 2rem; }
      th, td { border: 1px solid #ddd; padding: 0.5rem; text-align: left; }
      th { background-color: #007bff; color: white; }
      a.button {
          display: inline-block;
          padding: 0.4rem 0.8rem;
          background-color: #28a745;
          color: white;
          text-decoration: none;
          border-radius: 4px;
      }
      a.button.edit {
          background-color: #007bff;
      }
      form { max-width: 600px; background: white; padding: 1rem 2rem; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.2); }
      label { display: block; margin-top: 1rem; font-weight: bold; }
      input[type=text], input[type=date], input[type=number] {
          width: 100%; padding: 0.5rem; margin-top: 0.3rem; border: 1px solid #ccc; border-radius: 4px;
          box-sizing: border-box;
      }
      .errors { background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
      .success { background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
      button.submit-btn {
          margin-top: 1.5rem;
          background: #007bff;
          border: none;
          padding: 0.7rem 1.5rem;
          color: white;
          font-size: 1rem;
          border-radius: 6px;
          cursor: pointer;
      }
      button.submit-btn:hover {
          background: #0056b3;
      }
      .nav-link {
          margin-bottom: 1rem;
          display: inline-block;
          font-size: 1rem;
          color: #007bff;
          text-decoration: none;
      }
      .nav-link:hover {
          text-decoration: underline;
      }
    </style>
</head>
<body>
    <h1>Admin Panel - Manage Payments</h1>
    <a href="admin_dashboard.php" class="nav-link">&laquo; Back to Dashboard</a>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?=htmlspecialchars($e)?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif ($success_msg): ?>
        <div class="success"><?=htmlspecialchars($success_msg)?></div>
    <?php endif; ?>

    <?php if ($edit_payment): ?>
        <h2>Edit Payment #<?=htmlspecialchars($edit_payment['id'])?></h2>
        <form method="post" action="admin_edit_payment.php">
            <input type="hidden" name="payment_id" value="<?=htmlspecialchars($edit_payment['id'])?>" />
            
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required value="<?=htmlspecialchars($edit_payment['name'])?>" />

            <label for="checkin">Check-in Date</label>
            <input type="date" id="checkin" name="checkin" required value="<?=htmlspecialchars($edit_payment['checkin'])?>" />

            <label for="checkout">Check-out Date</label>
            <input type="date" id="checkout" name="checkout" required value="<?=htmlspecialchars($edit_payment['checkout'])?>" />

            <label for="card_number">Card Number</label>
            <input type="text" id="card_number" name="card_number" pattern="\d{16}" maxlength="16" required value="<?=htmlspecialchars($edit_payment['card_number'])?>" />

            <label for="expiry">Expiry (MM/YY or YYYY-MM-DD)</label>
            <input type="text" id="expiry" name="expiry" required value="<?=htmlspecialchars($edit_payment['expiry'])?>" />

            <label for="plan_name">Plan Name</label>
            <input type="text" id="plan_name" name="plan_name" required value="<?=htmlspecialchars($edit_payment['plan_name'])?>" />

            <label for="plan_price">Plan Price (₹)</label>
            <input type="number" id="plan_price" name="plan_price" min="0" step="0.01" required value="<?=htmlspecialchars($edit_payment['plan_price'])?>" />

            <button type="submit" name="update_payment" class="submit-btn">Update Payment</button>
        </form>
        <hr />
    <?php endif; ?>

    <h2>All Payment Records</h2>
    <?php if (empty($payments)): ?>
        <p>No payment records found.</p>
    <?php else: ?>
        <table aria-label="Payment Records Table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Card Number</th>
                    <th>Expiry</th>
                    <th>Plan Name</th>
                    <th>Plan Price (₹)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $pay): ?>
                    <tr>
                        <td><?=htmlspecialchars($pay['id'])?></td>
                        <td><?=htmlspecialchars($pay['name'])?></td>
                        <td><?=htmlspecialchars($pay['checkin'])?></td>
                        <td><?=htmlspecialchars($pay['checkout'])?></td>
                        <td>**** **** **** <?=substr(htmlspecialchars($pay['card_number']), -4)?></td>
                        <td><?=htmlspecialchars($pay['expiry'])?></td>
                        <td><?=htmlspecialchars($pay['plan_name'])?></td>
                        <td><?=htmlspecialchars(number_format($pay['plan_price'], 2))?></td>
                        <td>
                            <a href="admin_edit_payment.php?edit_id=<?=urlencode($pay['id'])?>" class="button edit">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>
