<?php
session_start(); // Initialize session

include "invdb.php"; // Include the file for database connection

// Check if user is logged in and if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: index.php");
    exit(); // Terminate script to prevent further execution
}

// Fetch the name of the logged-in user
$userId = $_SESSION['user_id'];
$query = "SELECT username FROM users WHERE user_id = $userId";
$userResult = $conn->query($query);
$userRow = $userResult->fetch_assoc();
$userName = $userRow['username'];

// Fetch purchased products for the logged-in user
$query = "SELECT p.ProductName, p.Price FROM orders o
          JOIN product p ON o.ProductID = p.ProductID
          WHERE o.UserID = $userId";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/purchased.css">
    <title>SpeedOne | Purchased</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <h1>SpeedOne</h1>
            </div>
            <p><a href="shop.php">Shop</a></p>
            <p><a href="purchased.php">Purchased</a></p>
            <p><a href="index.php">Logout</a></p>
        </nav>
    </header>

    <main>
        <div class="container">
            <h2>Customer:  <?php echo $userName; ?></h2> <!-- Display the name of the user -->
            <h3>Purchased Cars</h3>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                </tr>
                <?php
                // Loop through each purchased product and display it in a table row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ProductName"] . "</td>";
                    echo "<td>" . $row["Price"] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </main>
</body>

</html>