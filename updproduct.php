<?php
    include "invdb.php";

    $message = "";
    $product = null;

    // Fetch Suppliers
    $suppliers = $conn->query("SELECT SupplierID, SupplierName FROM supplier");

    // Fetch Categories
    $categories = $conn->query("SELECT CategoryID, CategoryName FROM category");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_product'])) {
        $productID = $conn->real_escape_string($_POST['product_id']);
        $result = $conn->query("SELECT * FROM product WHERE ProductID = '$productID'");

        if ($result && $result->num_rows > 0) {
            $product = $result->fetch_assoc();
        } else {
            $message = "Product not found.";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
        $productID = $conn->real_escape_string($_POST['product_id']);
        $productName = $conn->real_escape_string($_POST['product_name']);
        $supplierID = $conn->real_escape_string($_POST['supplier_id']);
        $categoryID = $conn->real_escape_string($_POST['category_id']);
        $price = $conn->real_escape_string($_POST['price']);

        $sql = "UPDATE product SET ProductName='$productName', SupplierID='$supplierID', CategoryID='$categoryID', Price='$price' WHERE ProductID='$productID'";

        if ($conn->query($sql) === TRUE) {
            $message = "Product updated successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
        header("Location: updproduct.php?message=" . urlencode($message));
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/update.css">
    <title>stockwise.</title>
</head>
<body>
    <p class="title">stockwise.</p>
    <div class="buttons">
        <a href="forms.php"><button class="forms">Forms</button></a>
        <a href="reports.php"><button class="reports">Reports</button></a>
    </div>
    <div class="container">
        <div class="card">
            <p class="header">Update Product</p>
            <a href="forms.php"><button class="back">Back</button></a>
            <form action="updproduct.php" method="post">
                <label for="product_id">Product ID:</label>
                <input type="text" id="product_id" name="product_id" required><br>
                <button type="submit" name="search_product" class="card-button">Search Product ID</button>
            </form>
            <?php if ($product): ?>
                <form action="updproduct.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['ProductID']; ?>">
                    <label for="product_name">Product Name:</label>
                    <input type="text" id="product_name" name="product_name" value="<?php echo $product['ProductName']; ?>" required><br>
                    
                    <label for="supplier_id">Supplier ID:</label>
                    <select id="supplier_id" name="supplier_id" required>
                        <?php while ($supplier = $suppliers->fetch_assoc()): ?>
                            <option value="<?php echo $supplier['SupplierID']; ?>" <?php if ($supplier['SupplierID'] == $product['SupplierID']) echo 'selected'; ?>>
                                <?php echo $supplier['SupplierName']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select><br>

                    <label for="category_id">Category ID:</label>
                    <select id="category_id" name="category_id" required>
                        <?php while ($category = $categories->fetch_assoc()): ?>
                            <option value="<?php echo $category['CategoryID']; ?>" <?php if ($category['CategoryID'] == $product['CategoryID']) echo 'selected'; ?>>
                                <?php echo $category['CategoryName']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select><br>
                    
                    <label for="price">Price:</label>
                    <input type="number" step="0.01" id="price" name="price" value="<?php echo $product['Price']; ?>" required><br>
                    
                    <button type="submit" name="update_product" class="card-button">Update Product</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <div id="snackbar"></div>

    <script>
        function showSnackbar(message) {
            var snackbar = document.getElementById('snackbar');
            snackbar.innerText = message;
            snackbar.className = 'snackbar show';
            setTimeout(function() { snackbar.className = snackbar.className.replace('show', ''); }, 3000);
        }

        <?php if (isset($_GET['message'])): ?>
            window.onload = function() {
                showSnackbar("<?php echo $_GET['message']; ?>");
            };
        <?php endif; ?>
    </script>
</body>
</html>
