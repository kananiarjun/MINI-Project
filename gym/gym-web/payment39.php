<?php
    include 'database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <style>
        * {
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(145deg, #000000, #1a1a1a);
            color: #ffffff;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            margin: 0;
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            background: rgba(0, 0, 0, 0.4);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        h2 {
            margin: 0 0 30px 0;
            font-size: 28px;
            font-weight: 600;
            background: linear-gradient(90deg, #ffffff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #ffffff;
        }

        input {
            width: 100%;
            padding: 15px;
            margin-top: 8px;
            background: rgba(26, 26, 26, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border-radius: 10px;
            font-size: 16px;
            outline: none;
        }

        input:focus {
            border-color: #ffffff;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.2);
            background: rgba(26, 26, 26, 0.95);
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .card-details {
            display: flex;
            gap: 15px;
        }

        .card-details input {
            width: calc(50% - 7.5px);
        }

        .plan-details {
            background: linear-gradient(145deg, rgba(26, 26, 26, 0.9), rgba(13, 13, 13, 0.9));
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .price {
            font-size: 32px;
            font-weight: bold;
            margin: 20px 0;
            color: #ffffff;
        }

        .button {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .button:hover {
            transform: translateY(-2px);
        }

        .cancel {
            background-color: transparent;
            color: #ffffff;
            border: 2px solid #ffffff;
        }

        .cancel:hover {
            background-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
        }

        .subscribe {
            background: linear-gradient(90deg, #ffffff, #e0e0e0);
            color: black;
            float: right;
        }

        .subscribe:hover {
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.4);
        }

        .plan-info {
            padding: 20px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 20px;
        }

        .change-plan {
            float: right;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            opacity: 0.8;
        }

        .change-plan:hover {
            opacity: 1;
        }

        p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                padding: 20px;
            }
        }
        input[readonly] {
            background-color: rgba(255, 255, 255, 0.1);
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="payment-form">
            <h2>Payment details</h2>
            <form action="payment_process.php" method="post">
            <div class="form-group">
                <label>Full name</label>
                <input type="text" name="name" placeholder="Enter your full name">
            </div>
            <div class="form-group">
                <label>Check-in Date</label>
                <input type="date" name="checkin" required>
            </div>
            <div class="form-group">
                <label>Check-out Date</label>
                <input type="date" name="checkout" required>
            </div>
            <div class="form-group">
                <label>Card Details</label>
                <input type="number" name="card_number" maxlength="16" placeholder="0000 0000 0000 0000">
                
                <div class="card-details">
                    <input type="month" name="expiry" placeholder="MM/YY">
                    <input type="password" maxlength="3" name="cvv" placeholder="CVV">
                </div>
            </div>
          
            <div class="form-group">
                <label>Plan Name</label>
                <input type="text" name="plan_name" value="3 Months" readonly>
            </div>
            <div class="form-group">
                <label>Plan Price</label>
                <input type="text" name="plan_price" value="₹3500" readonly>
            </div>
        </div>

        <div class="plan-details">
            <h2>3 Months</h2>
            <div class="price">₹3500.00</div>
            <p>Unlimited Access • Month</p>
            
            <div class="plan-info">
                <h3>Updates</h3>
                <p>Frequent updates for all current and new products.</p>
            </div>
            
            

            <a href="services.html" ><button class="button cancel">Cancel</button></a>
            <a href="payment_process.php"><button class="button subscribe">Subscribe</button></a>
    </form>
        </div>
    </div>

    
</body>
</html>

