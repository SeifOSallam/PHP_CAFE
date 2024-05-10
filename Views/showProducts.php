<?php
include "../Controllers/product.php";
include "base.php";
include "../Components/Table.php";
require_once '../Controllers/db_class.php';

session_start();

if(!is_null($_SESSION) && $_SESSION['role'] === 'user')
{
    header('Location:home.php');
}
$errors='';
if(isset($_GET['errors'])){
  $errors =  $_GET['errors'];
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
$image = $_SESSION['image'];
$currPage = empty($_GET['page'])? 1 : $_GET['page'];
$products = selectProduct($currPage);
$filterKeys = ['id', 'category_id'];

$columnNames = array('Product', 'Price', 'Image','stock');
$count = getProductsCount();
$count = $count[0]['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    
<?php require '../Components/navbar.php';
      user_navbar($username,$image,$role);
?>
  <div class="container">
    <div class="d-flex justify-content-end mb-3">
      <a href="../Views/productForm.php" class="btn btn-primary">Add Product</a>
    </div>
    <h2 class="text-center mb-4">All Products</h2> 
    <div class="table-responsive">
      <?php
          if ($errors){
            echo "<div style='color: red;'>".$errors."</div>";
          }
        display_table($products,$currPage, ceil(($count+1)/6),$errors);
       
      ?>
    </div>
  </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
