<?php
session_start(); // Initialize session
include "invdb.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Get username and password from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the user exists in the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User exists, fetch user data
            $user = $result->fetch_assoc();
            
            // Store user ID in session
            $_SESSION['user_id'] = $user['user_id'];

            // Redirect to shop.php
            header("Location: shop.php");
            exit(); // Terminate script after redirection
        } else {
            $error_message = "Invalid username or password.";
        }

        $stmt->close();
    } elseif (isset($_POST['signup'])) {
        // Redirect to signup page
        header("Location: signup.php");
        exit(); // Terminate script after redirection
    } elseif (isset($_POST['guest'])) {
        // Redirect to guest page
        header("Location: guest.php");
        exit(); // Terminate script after redirection
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <title>SpeedOne</title>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="card card1">
                <p class="title">Welcome to SpeedOne!</p>
                <p class="description">Please Login or Signup</p>
            </div>
            <?php
                if (isset($error_message)) {
                    echo "<p style='color: red; text-align: center;'>$error_message</p>";
                }
            ?>
            <form method="POST" action="">
                <div class="card card2">
                    <div class="input-container">
                        <p class="username-label">Username</p>
                        <i class='bx bxs-user'></i>
                        <input type="text" name="username" placeholder="Enter your username">
                    </div>
                    <div class="input-container">
                        <p class="password-label">Password</p>
                        <i class='bx bxs-lock'></i>
                        <input type="password" name="password" placeholder="Enter your password">
                    </div>
                </div>
                <div class="card card3">
                    <button type="submit" name="login" class="buttons button1">Login</button>
                    <button type="submit" name="signup" class="buttons button2">Signup</button>
                    <button type="submit" name="guest" class="buttons button3">Continue as Guest</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
