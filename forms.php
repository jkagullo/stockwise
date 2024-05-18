<?php

    include "invdb.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/forms.css">

    <title>stockwise.</title>
</head>
<body>
    
    <p class="title"> stockwise. </p>
        <div class="buttons">
            <a href="forms.php"><button class="forms">Forms</button></a>
            <a href="reports.php"><button class="reports">Reports</button></a>
        </div>
    <div class="container">
        <div class="card-container">
            <div class="card1">
                <p class="header">Add A Category</p>
                <p class="text">Should we add another category?</p>
                <a href="category.php"><button class="card-button">Add Category</button></a>
            </div>

            <div class="card2">
                <p class="header">Add A Supplier</p>
                <p class="text">Need a new supplier?</p>
                <a href="supplier.php"><button class="card-button">Add Supplier</button></a>

            </div>

            <div class="card3">
                <p class="header">Add A Product</p>
                <p class="text">Wow, new product!</p>
                <a href="product.php"><button class="card-button">Add Product</button></a>

            </div>

            <div class="card4">
                <p class="header">Update A Product</p>
                <p class="text">Is there anything wrong?</p>
                <a href="updproduct.php"><button class="card-button">Update Product</button>

            </div>
        </div>
    </div>
    
</body>
</html>