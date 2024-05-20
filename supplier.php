<?php
    include "invdb.php";

    $newSupplierID = 0;
    $message = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Find the highest current SupplierID
        $result = $conn->query("SELECT MAX(SupplierID) AS maxID FROM supplier");
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
        header("Location: supplier.php?message=" . urlencode($message));
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
    <link rel="stylesheet" href="css/supplier.css">
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
            <p class="header">Add Supplier</p>
            <a href="forms.php"><button class="back">Back</button></a>
            <form action="supplier.php" method="post">
                <p>Note: Supplier ID will be auto-generated</p><br>
                <?php
                    echo "<p> Supplier ID: " . $newSupplierID . "</p>";
                ?>
                <label for="supplier_name">Supplier Name:</label>
                <input type="text" id="supplier_name" name="supplier_name" required><br>
                <label for="contact_person">Contact Person:</label>
                <input type="text" id="contact_person" name="contact_person" required><br>
                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number" required><br>
                <button type="submit" class="card-button">Add Supplier</button>
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