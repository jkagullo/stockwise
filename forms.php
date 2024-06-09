<?php
    include "invdb.php"; // Include the file for database connection
    $newCategoryID = 0;
    $newSupplierID = 0;
    $message = "";
    $product = null;

    // Fetch Suppliers
    $suppliers = $conn->query("SELECT SupplierID, SupplierName FROM supplier");

    // Fetch Categories
    $categories = $conn->query("SELECT CategoryID, CategoryName FROM category");

    // Fetch Products
    $products = $conn->query("SELECT ProductID, ProductName FROM product");

    // Assuming $conn is already defined and connected to the database
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle category addition
        if (isset($_POST['category_name'])) {
            // Handle category addition
            // Find the highest current CategoryID
            $result = $conn->query("SELECT MAX(CategoryID) AS maxID FROM category");
            if ($result) {
                $row = $result->fetch_assoc();
                $maxID = (int)$row['maxID'];
                $newCategoryID = $maxID + 1;

                // Retrieve form data
                $categoryName = $conn->real_escape_string($_POST['category_name']);

                // Insert new category with generated CategoryID
                $sql = "INSERT INTO category (CategoryID, CategoryName) VALUES ('$newCategoryID', '$categoryName')";
                
                if ($conn->query($sql) === TRUE) {
                    $message = "New category added successfully!";
                } else {
                    $message = "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
                header("Location: forms.php?message=" . urlencode($message));
                exit();
            } else {
                $message = "Error fetching max CategoryID: " . $conn->error;
                header("Location: forms.php?message=" . urlencode($message));
                exit();
            }
        } elseif (isset($_POST['supplier_name'])) {
            // Handle supplier addition
            // Find the highest current SupplierID
            $result = $conn->query("SELECT MAX(SupplierID) AS maxID FROM supplier");
            if ($result) {
                $row = $result->fetch_assoc();
                $maxID = (int)$row['maxID'];
                $newSupplierID = $maxID + 1;

                // Retrieve form data
                $supplierName = $conn->real_escape_string($_POST['supplier_name']);
                $contactPerson = $conn->real_escape_string($_POST['contact_person']);
                $contactNumber = $conn->real_escape_string($_POST['contact_number']);

                // Insert new supplier with generated SupplierID
                $sql = "INSERT INTO supplier (SupplierID, SupplierName, ContactPerson, ContactNumber) VALUES ('$newSupplierID', '$supplierName', '$contactPerson', '$contactNumber')";
                
                if ($conn->query($sql) === TRUE) {
                    $message = "New supplier added successfully!";
                } else {
                    $message = "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
                header("Location: forms.php?message=" . urlencode($message));
                exit();
            } else {
                $message = "Error fetching max SupplierID: " . $conn->error;
                header("Location: forms.php?message=" . urlencode($message));
                exit();
            }
        } elseif (isset($_POST['product_name']) && !isset($_POST['update_product'])) {
            // Handle product addition
            // Retrieve form data
            $productName = $conn->real_escape_string($_POST['product_name']);
            $supplierID = $conn->real_escape_string($_POST['supplier_id']);
            $categoryID = $conn->real_escape_string($_POST['category_id']);
            $price = $conn->real_escape_string($_POST['price']);

            // Insert new product
            $sql = "INSERT INTO product (ProductName, SupplierID, CategoryID, Price) VALUES ('$productName', '$supplierID', '$categoryID', '$price')";

            if ($conn->query($sql) === TRUE) {
                $message = "New product added successfully!";
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
            header("Location: forms.php?message=" . urlencode($message));
            exit();
        } elseif (isset($_POST['update_product'])) {
            // Handle product update
            // Retrieve form data
            $productID = $conn->real_escape_string($_POST['product_id']);
            $productName = $conn->real_escape_string($_POST['product_name']);
            $supplierID = $conn->real_escape_string($_POST['supplier_id']);
            $categoryID = $conn->real_escape_string($_POST['category_id']);
            $price = $conn->real_escape_string($_POST['price']);

            // Update existing product
            $sql = "UPDATE product SET ProductName='$productName', SupplierID='$supplierID', CategoryID='$categoryID', Price='$price' WHERE ProductID='$productID'";

            if ($conn->query($sql) === TRUE) {
                $message = "Product updated successfully!";
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
            header("Location: forms.php?message=" . urlencode($message));
            exit();
        } elseif (isset($_POST['delete_product'])) {
            // Handle product deletion
            $productID = $conn->real_escape_string($_POST['product_id']);
        
            // Delete the product
            $sql = "DELETE FROM product WHERE ProductID='$productID'";
        
            if ($conn->query($sql) === TRUE) {
                $message = "Product deleted successfully!";
            } else {
                $message = "Error deleting product: " . $conn->error;
            }
        
            $conn->close();
            header("Location: forms.php?message=" . urlencode($message));
            exit();
        }
    }

    // Fetch product details for updating
    $productDetails = [];
    if (isset($_GET['product_id'])) {
        $productID = $conn->real_escape_string($_GET['product_id']);
        $result = $conn->query("SELECT * FROM product WHERE ProductID='$productID'");
        if ($result) {
            $productDetails = $result->fetch_assoc();
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
    <link rel="stylesheet" href="css/forms.css">

    <title>SpeedOne | Forms</title>
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
        <h1 class="greet">Form Controls</h1>
        <div class="container">
            <div class="card card1">
                <p class="title">Add A Category</p>
                <form action="forms.php" method="post">
                    <p>Note: Category ID will be auto-generated</p><br>
                    <?php
                        echo "<p> Category ID: " . $newCategoryID . "</p>";
                    ?>
                    <label for="category_name">Category Name:</label>
                    <input type="text" id="category_name" name="category_name" required><br>
                    <button type="submit" class="card-button">Add Category</button>
                </form>
            </div>
            <div class="card card2">
                <p class="title">Add A Supplier</p>
                <form action="forms.php" method="post">
                    <p>Note: Supplier ID will be auto-generated</p><br>
                    <?php
                        echo "<p> Supplier ID: " . $newSupplierID . "</p>";
                    ?>
                    <label for="supplier_name">Supplier Name:</label>
                    <input type="text" id="supplier_name" name="supplier_name" required><br>
                    <label for="contact_person">Contact Person:</label>
                    <input type="text" id="contact_person" name="contact_person" required><br>
                    <label for="contact_number">Contact Num:</label>
                    <input type="text" id="contact_number" name="contact_number" required><br>
                    <button type="submit" class="card-button">Add Supplier</button>
                </form>
            </div>
            <div class="card card3">
                <p class="title">Add A Product</p>
                <form action="forms.php" method="post">
                    <label for="product_name">Product Name:</label>
                    <input type="text" id="product_name" name="product_name" required><br>
                    
                    <label for="supplier_id">Supplier ID:</label>
                    <select id="supplier_id" name="supplier_id" required>
                        <?php while ($supplier = $suppliers->fetch_assoc()): ?>
                            <option value="<?php echo $supplier['SupplierID']; ?>">
                                <?php echo $supplier['SupplierName']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select><br>

                    <label for="category_id">Category ID:</label>
                    <select id="category_id" name="category_id" required>
                        <?php while ($category = $categories->fetch_assoc()): ?>
                            <option value="<?php echo $category['CategoryID']; ?>">
                                <?php echo $category['CategoryName']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select><br>
                    
                    <label for="price">Price:</label>
                    <input type="number" step="0.01" id="price" name="price" required><br>
                    
                    <button type="submit" class="card-button">Add Product</button>
                </form>
            </div>
            <div class="card card4">
                <p class="title">Update A Product</p>
                <form action="forms.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo isset($productDetails['ProductID']) ? $productDetails['ProductID'] : ''; ?>">
                    <label for="product_name">Product Name:</label>
                    <input type="text" id="product_name" name="product_name" value="<?php echo isset($productDetails['ProductName']) ? $productDetails['ProductName'] : ''; ?>" required><br>
                    
                    <label for="supplier_id">Supplier ID:</label>
                    <select id="supplier_id" name="supplier_id" required>
                        <?php 
                            // Reset the internal pointer of $suppliers
                            mysqli_data_seek($suppliers, 0);
                            while ($supplier = $suppliers->fetch_assoc()): 
                        ?>
                            <option value="<?php echo $supplier['SupplierID']; ?>" <?php if (isset($productDetails['SupplierID']) && $supplier['SupplierID'] == $productDetails['SupplierID']) echo 'selected'; ?>>
                                <?php echo $supplier['SupplierName']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select><br>

                    <label for="category_id">Category ID:</label>
                    <select id="category_id" name="category_id" required>
                        <?php 
                            // Reset the internal pointer of $categories
                            mysqli_data_seek($categories, 0);
                            while ($category = $categories->fetch_assoc()): 
                        ?>
                            <option value="<?php echo $category['CategoryID']; ?>" <?php if (isset($productDetails['CategoryID']) && $category['CategoryID'] == $productDetails['CategoryID']) echo 'selected'; ?>>
                                <?php echo $category['CategoryName']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select><br>
                    
                    <label for="price">Price:</label>
                    <input type="number" step="0.01" id="price" name="price" value="<?php echo isset($productDetails['Price']) ? $productDetails['Price'] : ''; ?>" required><br>
                    
                    <button type="submit" name="update_product" class="card-button">Update Product</button>
                </form>
            </div>
            <div class="card card5">
                <p class="title">Delete A Product</p>
                <form action="forms.php" method="post">
                    <label for="product_id">Product ID:</label>
                    <input type="text" id="product_id" name="product_id" value="<?php echo isset($productDetails['ProductID']) ? $productDetails['ProductID'] : ''; ?>" required><br>
                    <p>Are you sure you want to delete this product?</p>
                    <button type="submit" name="delete_product" class="card-button">Delete Product</button>
                </form>
            </div>
        </div>
    </main>

    <!-- Snackbar -->
    <div id="snackbar"></div>

    <script>
        // Function to show snackbar
        function showSnackbar(message) {
            var snackbar = document.getElementById("snackbar");
            snackbar.textContent = message;
            snackbar.className = "show";
            setTimeout(function() {
                snackbar.className = snackbar.className.replace("show", "");
            }, 3000);
        }

        // Check if message exists in the URL
        window.onload = function() {
            var urlParams = new URLSearchParams(window.location.search);
            var message = urlParams.get('message');
                if (message) {
                    showSnackbar(message);

                    // Remove message parameter from URL
                    urlParams.delete('message');
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
            }
        </script>

    </body>
</html>


