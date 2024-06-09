<?php
session_start(); // Initialize session

include "invdb.php"; // Include the file for database connection

// Query to fetch all products
$sql = "SELECT * FROM product";
$result = $conn->query($sql); // Execute the query

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
            <p><a href="index.php">Login</a></p>
        </nav>
    </header>

    <main>
        <div class="container">
            <h2>Welcome,Guest</h2>
            <h3>Available Cars</h3>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                </tr>
                <?php
                // Loop through each product and display it in a table row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ProductName"] . "</td>";
                    echo "<td>" . $row["Price"] . "</td>";
                    echo "<input type='hidden' name='productID' value='" . $row["ProductID"] . "'>";
                    echo "</form></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <?php
        // Check if an order was successfully placed and display the Snackbar
        if (isset($_SESSION['order_placed']) && $_SESSION['order_placed'] === true) {
            echo "<div id='snackbar' class='show'>Order placed successfully!</div>";
            // Reset the session variable
            $_SESSION['order_placed'] = false;
        }
        ?>
    </main>
</body>
<script>
    // Check if the snackbar element exists and show it with the "show" class
    document.addEventListener("DOMContentLoaded", function() {
        var snackbar = document.getElementById("snackbar");
        if (snackbar) {
            // Add the "show" class to display the snackbar
            snackbar.classList.add("show");
            // Hide the snackbar after 3 seconds
            setTimeout(function() {
                snackbar.classList.remove("show");
            }, 3000);
        }
    });
</script>

</html>
