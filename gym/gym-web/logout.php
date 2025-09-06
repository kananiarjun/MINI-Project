<?php
session_start(); // Start session

// Destroy all session data
session_unset(); 
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        .toast {
            visibility: hidden;
            min-width: 250px;
            background-color: #f44336;
            color: white;
            text-align: center;
            border-radius: 5px;
            padding: 10px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .show {
            visibility: visible;
            animation: fadeInOut 3s ease-in-out;
        }
        @keyframes fadeInOut {
            0% { opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>
</head>
<body>
    <div id="toast" class="toast">Logout Successful!</div>
    <script>
        function showToast() {
            let toast = document.getElementById("toast");
            toast.classList.add("show");
            setTimeout(() => {
                toast.classList.remove("show");
                window.location.href = 'login2.php'; // Redirect after showing toast
            }, 3000);
        }
        showToast();
    </script>
</body>
</html>