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
  <?php
  if (!empty($errors)) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo '<strong>' . $errors . '</strong>';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
  }
  ?>
  <div class="container">
    <div class="d-flex justify-content-end mb-3">
      <a href="../Views/productForm.php" class="btn btn-primary">Add Product</a>
    </div>
    <h2 class="text-center mb-4">All Products</h2> 
    <div class="table-responsive">
      <?php
      
        display_table($products,$currPage, ceil(($count+1)/6),$errors);
       
      ?>
    </div>
  </div>

<script>
    document.getElementById("closeErrorAlert").addEventListener("click", function() {
        document.getElementById("errorAlert").remove();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
