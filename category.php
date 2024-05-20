<?php
    include "invdb.php";

    $newCategoryID = 0;
    $message = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Find the highest current CategoryID
        $result = $conn->query("SELECT MAX(CategoryID) AS maxID FROM category");
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
        header("Location: category.php?message=" . urlencode($message));
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
    <link rel="stylesheet" href="css/category.css">
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
            <p class="header">Add Category</p>
            <form action="category.php" method="post">
                <p>Note: Category ID will be auto-generated</p><br>
                <?php
                    echo "<p> Category ID: " . $newCategoryID . "</p>";
                ?>
                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" name="category_name" required><br>
                <button type="submit" class="card-button">Add Category</button>
            </form>
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
