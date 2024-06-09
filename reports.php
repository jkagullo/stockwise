<?php

    include "invdb.php";

    if(isset($_POST['report'])){
        $selected = $_POST['report'];
    }else {
        $selected = "Product";
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
    <link rel="stylesheet" href="css/reports.css">

    <title>SpeedOne | Reports</title>
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
        <h1 class="greet">Reports</h1>
        <div class="container">
            <div class="card card1">
                <h3>Select A Report</h3>
            <form method="post">
                <select name="report" onchange="this.form.submit()">
                    <?php
                        $options = array('Product', 'Category', 'Supplier', 'Most Expensive');
                        foreach($options as $option){
                            if($selected == $option){
                                echo "<option selected='selected' value='$option'>$option</option>";
                            }else {
                                echo "<option value='$option'>$option</option>";
                            }
                        }
                    ?>
                </select>
            </form>
            </div>
            <div class="card card2">
            <?php
                if($selected == "Product"){
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Supplier ID</th>
                        <th>Category ID</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM product";
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['ProductID'] . "</td>";
                                    echo "<td>" . $row['ProductName'] . "</td>";
                                    echo "<td>" . $row['SupplierID'] . "</td>";
                                    echo "<td>" . $row['CategoryID'] . "</td>";
                                    echo "<td>" . $row['Price'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
            <?php
                } else if($selected == "Category") {
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM category";
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['CategoryID'] . "</td>";
                                    echo "<td>" . $row['CategoryName'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
            <?php
                    } else if($selected == "Supplier"){
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>Contact Person</th>
                        <th>Contact Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM supplier";
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['SupplierID'] . "</td>";
                                    echo "<td>" . $row['SupplierName'] . "</td>";
                                    echo "<td>" . $row['ContactPerson'] . "</td>";
                                    echo "<td>" . $row['ContactNumber'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
            <?php
                    } else if($selected == 'Most Expensive'){
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT ProductID, ProductName, Price 
                        FROM product 
                        ORDER BY Price DESC 
                        LIMIT 1";
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['ProductID'] . "</td>";
                                    echo "<td>" . $row['ProductName'] . "</td>";
                                    echo "<td>" . $row['Price'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
            <?php
                    }
            ?>
            </div>
        </div>

    <!-- <div class="container">
        <div class="left-container">
            <p class="header">Select Report</p>
            <form method="post">
                <select name="report" onchange="this.form.submit()">
                    <?php
                        $options = array('Product', 'Category', 'Supplier', 'Most Expensive');
                        foreach($options as $option){
                            if($selected == $option){
                                echo "<option selected='selected' value='$option'>$option</option>";
                            }else {
                                echo "<option value='$option'>$option</option>";
                            }
                        }
                    ?>
                </select>
            </form>
        </div>
        <div class="right-container">
            <?php
                if($selected == "Product"){
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Supplier ID</th>
                        <th>Category ID</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM product";
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['ProductID'] . "</td>";
                                    echo "<td>" . $row['ProductName'] . "</td>";
                                    echo "<td>" . $row['SupplierID'] . "</td>";
                                    echo "<td>" . $row['CategoryID'] . "</td>";
                                    echo "<td>" . $row['Price'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
            <?php
                } else if($selected == "Category") {
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM category";
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['CategoryID'] . "</td>";
                                    echo "<td>" . $row['CategoryName'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
            <?php
                    } else if($selected == "Supplier"){
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>Contact Person</th>
                        <th>Contact Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM supplier";
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['SupplierID'] . "</td>";
                                    echo "<td>" . $row['SupplierName'] . "</td>";
                                    echo "<td>" . $row['ContactPerson'] . "</td>";
                                    echo "<td>" . $row['ContactNumber'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
            <?php
                    } else if($selected == 'Most Expensive'){
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT ProductID, ProductName, Price 
                        FROM product 
                        ORDER BY Price DESC 
                        LIMIT 1";
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['ProductID'] . "</td>";
                                    echo "<td>" . $row['ProductName'] . "</td>";
                                    echo "<td>" . $row['Price'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
            <?php
                    }
            ?>
        </div>
    </div> -->
    
</body>
</html>