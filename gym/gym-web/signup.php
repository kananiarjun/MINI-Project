<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, rgb(25, 128, 207), rgba(240, 65, 12, 0.9));
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .signup-container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .signup-container h1 {
            color: rgb(25, 128, 207);
            margin-bottom: 20px;
            font-weight: bold;
        }

        .signup-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .signup-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: rgb(253, 87, 45);
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .signup-container button:hover {
            background-color: rgb(218, 68, 32);
        }

        .gym-section {
            margin-top: 20px;
        }

        .gym-section a {
            text-decoration: none;
            color: rgb(25, 128, 207);
            font-weight: bold;
        }

        .gym-section a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <div class="signup-container">
        <h1>Sign Up</h1>
        <form method="post" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="uname" placeholder="Username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="pass" placeholder="Create New Password" required minlength="6">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>

            <label for="date">Birth Date</label>
            <input type="date" id="date" name="b_date" required>

            <button type="submit">Sign Up</button>
        </form>
        <div class="gym-section">
            <p>Already a member? <a href="login2.php">Login</a></p>
        </div>
    </div>

    <?php
// Process form only when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";  // Change if needed
    $password = "";  // Change if you have a password
    $dbname = "gym_user";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("<script>alert('Database connection failed!');</script>");
    }

    // Retrieve form data safely
    $uname = isset($_POST['uname']) ? $_POST['uname'] : '';
    $pass = isset($_POST['pass']) ? $_POST['pass'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $b_date = isset($_POST['b_date']) ? $_POST['b_date'] : '';

    // Ensure fields are not empty
    if (!empty($uname) && !empty($pass) && !empty($email) && !empty($b_date)) {
        // Hash the password for security
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // SQL Query to insert data
        $sql = "INSERT INTO user_data (uname, pass, email, b_date) VALUES (?, ?, ?, ?)";

        // Prepare and bind statement
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssss", $uname, $hashed_password, $email, $b_date);
            if ($stmt->execute()) {
                // Show success alert and redirect to login page
                echo "<script>
                        alert('Registration successful! Redirecting to login page...');
                        window.location.href = 'login2.php';
                      </script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing statement!');</script>";
        }
    } else {
        echo "<script>alert('All fields are required!');</script>";
    }

    // Close connection
    $conn->close();
}
?>

</body>
</html>
