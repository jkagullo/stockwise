<?php
session_start(); // Initialize session

include "invdb.php"; // Include the file for database connection

// Check if user is logged in and if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: index.php");
    exit(); // Terminate script to prevent further execution
}

// Fetch admin name
$stmt = $conn->prepare("SELECT username FROM users WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$admin_name = $admin['username'];
$stmt->close();

// Fetch total products
$product_query = "SELECT COUNT(*) AS total_products FROM product";
$product_result = $conn->query($product_query);
$product_data = $product_result->fetch_assoc();
$total_products = $product_data['total_products'];

// Fetch total suppliers
$supplier_query = "SELECT COUNT(*) AS total_suppliers FROM supplier";
$supplier_result = $conn->query($supplier_query);
$supplier_data = $supplier_result->fetch_assoc();
$total_suppliers = $supplier_data['total_suppliers'];

// Fetch total orders
$order_query = "SELECT COUNT(*) AS total_orders FROM orders";
$order_result = $conn->query($order_query);
$order_data = $order_result->fetch_assoc();
$total_orders = $order_data['total_orders'];

// Fetch total customers
$customer_query = "SELECT COUNT(*) AS total_customers FROM users WHERE user_id IN (SELECT DISTINCT UserID FROM orders)";
$customer_result = $conn->query($customer_query);
$customer_data = $customer_result->fetch_assoc();
$total_customers = $customer_data['total_customers'];

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
    <link rel="stylesheet" href="css/admin.css">
    <title>SpeedOne | Admin</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <h1>SpeedOne</h1>
            </div>
            <p><a href="forms.php">Forms</a></p>
            <p><a href="reports.php">Reports</a></p>
            <p><a href="index.php">Logout</a></p>
        </nav>
    </header>

    <main>
        <h1 class="greet">Welcome, <?php echo htmlspecialchars($admin_name); ?></h1>
        <div class="container">
            <h1>Dashboard</h1>
            <table>
                <tr>
                    <th>Total Products</th>
                </tr>
                <tr>
                    <td><?php echo $total_products; ?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <th>Total Suppliers</th>
                </tr>
                <tr>
                    <td><?php echo $total_suppliers; ?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <th>Total Orders</th>
                </tr>
                <tr>
                    <td><?php echo $total_orders; ?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <th>Total Customers</th>
                </tr>
                <tr>
                    <td><?php echo $total_customers; ?></td>
                </tr>
            </table>
        </div>
    </main>

</body>
</html>
