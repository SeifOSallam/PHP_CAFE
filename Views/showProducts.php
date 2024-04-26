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
 
  <style>
    .center-content {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 90vh;
    }
  </style>
</head>
<body>

<?php require '../Components/navbar.php';?>
<div class="container-fluid center-content">
  <div class="container">
    <div class="bg-image"></div>
    <div class="d-flex justify-content-end mb-1">
    <a href="../Views/productForm.php" class="btn btn-primary">Add Product</a>
    </div>
    <h2 class="text-center mb-4">All Products</h2> 
    <div class="table-responsive">
      <?php
        display_in_table($products, $columnNames, 3, $filterKeys,"../Controllers/product.php","productForm.php");
      ?>
    </div>
  </div>
</div>



</body>
</html>
