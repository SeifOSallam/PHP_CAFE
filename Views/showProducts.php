<?php
include "../Controllers/product.php";
include "base.php";
include "../Components/Table.php";

$products = selectProduct();
$filterKeys = ['id', 'category_id', 'stock'];

$columnNames = array('Product', 'Price', 'Image');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Custom CSS for centering elements */
    .center-content {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 80vh;
    }
  </style>
</head>
<body>

<?php require '../Components/navbar.php';?>

<div class="container-fluid center-content">
  <div class="container">
    <div class="bg-image"></div>
    <h2 class="text-center mb-4">All Products</h2> 
    <div class="table-responsive">
      <?php
        display_in_table($products, $columnNames, 3, $filterKeys,"delete_user.php","update_user.php");
      ?>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
