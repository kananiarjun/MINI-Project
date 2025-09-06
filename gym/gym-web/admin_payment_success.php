<?php
// success.php - Payment Success Page
session_start();
include 'database.php';

$payments = $conn->query("SELECT * FROM payment ORDER BY SR_NO DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

// Format dates for better readability
$checkin_date = date('F j, Y', strtotime($payments['checkin']));
$checkout_date = date('F j, Y', strtotime($payments['checkout']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .success-card {
            max-width: 600px;
            margin: 80px auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .success-header {
            background-color: #28a745;
            color: white;
            padding: 25px;
            text-align: center;
        }
        .success-icon {
            font-size: 60px;
            margin-bottom: 15px;
        }
        .success-body {
            padding: 30px;
        }
        .plan-details {
            background-color: #f1f8ff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .detail-item {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .detail-icon {
            margin-right: 12px;
            color: #28a745;
            width: 20px;
        }
        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #218838;
            border-color: #218838;
            transform: translateY(-2px);
        }
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #f00;
            animation: confetti-fall 3s ease-in-out infinite;
        }
        @keyframes confetti-fall {
            0% { transform: translateY(-100px) rotate(0deg); opacity: 1; }
            100% { transform: translateY(600px) rotate(360deg); opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-card">
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2>Payment Successful!</h2>
                <p class="mb-0">Your transaction has been completed</p>
            </div>
            <div class="success-body">
                <div class="plan-details">
                    <h4 class="mb-3">Plan Details</h4>
                    <div class="detail-item">
                        <span class="detail-icon"><i class="fas fa-user"></i></span>
                        <span>Name: <strong><?php echo htmlspecialchars($payments['name']); ?></strong></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon"><i class="fas fa-tag"></i></span>
                        <span>Plan: <strong><?php echo htmlspecialchars($payments['plan_name']); ?></strong></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon"><i class="fas fa-calendar-alt"></i></span>
                        <span>Valid From: <strong><?php echo $checkin_date; ?></strong></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon"><i class="fas fa-calendar-check"></i></span>
                        <span>Valid Until: <strong><?php echo $checkout_date; ?></strong></span>
                    </div>
                </div>
                <div class="text-center">
                    <a href="admin_payments.php" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Go Back
                    </a>
                </div>
                <div class="text-center mt-4">
                    <p class="text-muted">Leap Into Fitness..!</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Confetti animation -->
    <script>
        $(document).ready(function() {
            createConfetti();
            setTimeout(fadeOutConfetti, 3000);
        });
        
        function createConfetti() {
            const colors = ['#f00', '#0f0', '#00f', '#ff0', '#f0f', '#0ff'];
            const confettiCount = 50;
            
            for (let i = 0; i < confettiCount; i++) {
                const confetti = $('<div class="confetti"></div>');
                confetti.css({
                    'left': Math.random() * 100 + '%',
                    'top': -10,
                    'background-color': colors[Math.floor(Math.random() * colors.length)],
                    'width': Math.random() * 10 + 5 + 'px',
                    'height': Math.random() * 10 + 5 + 'px',
                    'animation-delay': Math.random() * 2 + 's',
                    'animation-duration': Math.random() * 3 + 2 + 's'
                });
                $('body').append(confetti);
            }
        }
        
        function fadeOutConfetti() {
            $('.confetti').fadeOut(1000, function() {
                $(this).remove();
            });
        }
    </script>
</body>
</html>