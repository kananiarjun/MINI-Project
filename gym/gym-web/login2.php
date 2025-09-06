<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION["username"])) {
    // Redirect to index if already logged in
    header("location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gym_user";
    
    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
       
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        $uname = trim($_POST['username'] ?? '');
        $pass = $_POST['password'] ?? '';
        
        if (empty($uname) || empty($pass)) {
            throw new Exception("All fields are required!");
        }
        
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT uname, pass FROM user_data WHERE uname = ?");
        if (!$stmt) {
            throw new Exception("Preparation failed: " . $conn->error);
        }
        
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception("User not found! Please sign up first.");
        }
        
        $user = $result->fetch_assoc();
        
        if (!password_verify($pass, $user['pass'])) {
            throw new Exception("Incorrect password!");
        }
        
        // Login successful
        $_SESSION["username"] = $user['uname'];
        $_SESSION["logged_in"] = true;
        $_SESSION["last_activity"] = time();
        
        // Set cache control headers
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        
        echo json_encode([
            "success" => true, 
            "message" => "Login successful!",
            "redirect" => "index.php"
        ]);
        exit;
        
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
        exit;
    } finally {
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
}
?>

<!-- HTML form -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(150deg, rgb(6, 86, 146), rgba(240, 65, 12, 0.9));
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
    background: #fff;
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(128, 0, 128, 0.8); /* Purple Glow */
    width: 300px;
    text-align: center;
    transition: box-shadow 0.3s ease-in-out;
    animation: glow 2s infinite alternate;
}

.login-container:hover {
    box-shadow: 0 0 25px rgba(128, 0, 128, 1);
}


        .login-container h1 {
            color: rgb(6, 86, 146);
            margin-bottom: 20px;
            font-weight: bold;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: rgb(253, 87, 45);
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: rgb(218, 68, 32);
        }

        .forgot-password {
            margin-top: 10px;
        }

        .forgot-password a {
            text-decoration: none;
            color: rgb(6, 86, 146);
            font-weight: bold;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .gym-section {
            margin-top: 20px;
        }

        .gym-section a {
            text-decoration: none;
            color: rgb(6, 86, 146);
            font-weight: bold;
        }

        .gym-section a:hover {
            text-decoration: underline;
        }
        .toast {
            visibility: hidden;
            min-width: 250px;
            background-color: #4CAF50;
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
        @keyframes glow {
    0% { box-shadow: 0 0 15px rgba(128, 0, 128, 0.8); }
    50% { box-shadow: 0 0 25px rgba(255, 20, 147, 1); } /* Switch to Pink */
    100% { box-shadow: 0 0 15px rgba(128, 0, 128, 0.8); }
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
    <div class="login-container">
        <h1>Login</h1>
        <form method="post" id="loginForm">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        
        <div class="gym-section">
            <p>Not a member yet? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
    <div id="toast" class="toast">Login Successful!</div>
    <script>
    function showToast() {
            let toast = document.getElementById("toast");
            toast.classList.add("show");
            setTimeout(() => {
                toast.classList.remove("show");
            }, 3000);
        }

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch(window.location.href, {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast();
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 3000);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                alert('An error occurred. Please try again.');
            });
        });
    </script>
</body>
</html>