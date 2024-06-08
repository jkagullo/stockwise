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

// Fetch products for the logged-in user
$query = "SELECT * FROM product";
$result = $conn->query($query);

// Check if products are available
if ($result->num_rows > 0) {
    // Check if the buy form is submitted
    if (isset($_POST['buy'])) {
        $productId = $_POST['productID'];

        // Insert the order into the orders table
        $insertQuery = "INSERT INTO orders (UserID, ProductID) VALUES ($userId, $productId)";
        if ($conn->query($insertQuery) === TRUE) {
            // Set a session variable to indicate a successful order
            $_SESSION['order_placed'] = true;
            // Redirect to the same page to prevent form resubmission
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
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
    <link rel="stylesheet" href="css/shop.css">
    <title>SpeedOne | Shop</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <h1>SpeedOne</h1>
            </div>
            <p>Shop</p>
            <p>Purchased</p>
            <p><a href="index.php">Logout</a></p>
        </nav>
    </header>

    <main>
        <div class="container">
            <h2>Welcome, <?php echo $userName; ?></h2> <!-- Display the name of the user -->
            <h3>Available Cars</h3>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                <?php
                // Loop through each product and display it in a table row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ProductName"] . "</td>";
                    echo "<td>" . $row["Price"] . "</td>";
                    echo "<td><form method='POST' action=''>"; // No action attribute to submit to the same page
                    echo "<input type='hidden' name='productID' value='" . $row["ProductID"] . "'>";
                    echo "<button type='submit' name='buy'>Buy</button>";
                    echo "</form></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <?php
        // Check if an order was successfully placed and display the Snackbar
        if (isset($_SESSION['order_placed']) && $_SESSION['order_placed'] === true) {
            echo "<div id='snackbar'>Order placed successfully!</div>";
            // Reset the session variable
            $_SESSION['order_placed'] = false;
        }
        ?>
    </main>
</body>
<script>
    // Check if the snackbar element exists and if the "show" class is applied to it
    document.addEventListener("DOMContentLoaded", function() {
        var snackbar = document.getElementById("snackbar");
        if (snackbar && snackbar.classList.contains("show")) {
            // Hide the snackbar after 3 seconds
            setTimeout(function() {
                snackbar.classList.remove("show");
            }, 3000);
        }
    });
</script>


</html>
