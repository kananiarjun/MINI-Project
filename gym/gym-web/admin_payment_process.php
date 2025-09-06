<?php
// process_payment.php - Payment Processing
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $card_number = $_POST['card_number'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];
    $plan_name = $_POST['plan_name'];
    $plan_price = $_POST['plan_price'];

    if (empty($name) || empty($checkin) || empty($checkout) || empty($card_number) || empty($expiry) || empty($cvv)) {
        die("All fields are required.");
    }

    // Dummy Card Validation (Basic)
    if (!preg_match('/^[0-9]{16}$/', $card_number) || !preg_match('/^[0-9]{3}$/', $cvv)) {
        die("Invalid card details.");
    }

    // Store Payment in DB
    $sql = "INSERT INTO payment (name, checkin, checkout, expiry, card_number, plan_name, plan_price) VALUES (?, ?, ? , ? , ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$name, $checkin, $checkout, $expiry, $card_number,$plan_name, $plan_price])) {
        echo "<script>alert('Payment Successful!'); window.location.href='admin_payment_success.php';</script>";
    } else {
        echo "<script>alert('Payment Failed! Try Again.'); window.location.href='admin_payments.php';</script>";
    }
}
?>