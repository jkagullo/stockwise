<?php
    include "invdb.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['signup'])) {
            // Get username and password from the form
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Insert new user into the database
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();

            // Close statement
            $stmt->close();

            // Display snackbar
            echo "<div class='snackbar'>Account created!</div>";

            // Redirect to login page after a short delay
            header("refresh:2; url=index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/signup.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <title>SpeedOne</title>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="card card1">
                <p class="title">Welcome to SpeedOne!</p>
                <p class="description">Please Signup</p>
            </div>
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
                    <button type="submit" name="signup" class="buttons button2">Signup</button>
                    <a href="guest.php" class="buttons button3">Continue as Guest</a>
                </div>
            </form>
        </div>
    </div>
    <div id="snackbar" class="snackbar"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var snackbar = document.getElementById('snackbar');
        <?php
        if (isset($_POST['signup'])) {
            echo "snackbar.innerText = 'Account created!';";
            echo "snackbar.classList.add('show');";
            echo "setTimeout(function(){ snackbar.classList.remove('show'); }, 3000);"; // After 3 seconds, remove the show class from DIV
        }
        ?>
    });
</script>
</body>
</html>
