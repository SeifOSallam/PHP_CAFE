<?php
include "../Controllers/category.php";
include "../Controllers/product.php";
include "../Views/base.php";

session_start();
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$image = $_SESSION['image'];
if(isset($_GET['errors'])){
    $errors = json_decode($_GET["errors"], true);
}

if(isset($_GET['old_data'])){
    $old_data = json_decode($_GET["old_data"], true);
}
if(isset($_GET['action']) && $_GET['action'] === "edit"){
  $product_id=$_GET['id'];
  $product = getOneProduct($_GET['id']) ;
}
$categories = selectCategories();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Form</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
  <style>
      
  .container {
    position: relative;
    margin-top: 50px;
  }
  
  .form-container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
  }

  .form-container h2 {
    text-align: center;
    margin-bottom: 30px;
  }

  .form-group label {
    font-weight: bold;
  }

  .form-group input[type="text"],
  .form-group input[type="number"],
  .form-group select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    height: 50px;
    border: 1px solid #ced4da;
    border-radius: 5px;
  }

  .form-group input[type="file"] {
    border: none;
    margin-bottom: 10px;
  }

  .form-group button[type="submit"],
  .form-group button[type="reset"] {
    width: 49%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .form-group button[type="submit"] {
    background-color: #007bff;
    color: #fff;
  }

  .form-group button[type="reset"] {
    background-color: #6c757d;
    color: #fff;
  }

  .form-group .text-danger {
    margin-top: 5px;
  }

  .form-group input[type="text"][name="price"],
  .form-group input[type="number"][name="stock"] {
    width: 30%; 
  }
</style>


 
</head>
<body>
<?php require '../Components/navbar.php';
      user_navbar($username,$image,$role);
?>
<div class="container">
  <div class="bg-image"></div>
  <div class="form-container">
    <h2>Product Form</h2>
    <form action="../validation/productFormValidation.php" method="post" enctype="multipart/form-data">
      <div class="form-group ">
        <label for="productName">Product:</label>
        <input type="text" class="form-control" id="productName" placeholder="Enter product name" name="name" <?php if(!empty($product)){echo 'value="'.$product[0]["name"].'"';}?>>
        <?php if (!empty($errors['name'])) echo "<div class='text-danger'>{$errors['name']}</div>"; ?> 
      </div>
      <div class="form-group">
        <label for="quantity">Price:</label>
        <input type="text" id="quantity" name="price" <?php if(!empty($product)){echo 'value="'.$product[0]["price"].'"';}?>>
        <?php if (!empty($errors['price'])) echo "<div class='text-danger'>{$errors['price']}</div>"; ?> 
      </div>
     <div class="form-group row">
        <label for="productCategory" class="col-sm-3 col-form-label">Category:</label>
        <div class="col-sm-7">
            <select class="form-control" id="productCategory" name="category" <?php if(!empty($product)){echo 'default="'.$product[0]["price"].'"';}?>default=>
            <?php foreach ($categories as $category): ?>
              <?php if (!empty($product) && $category['id'] == $product[0]['category_id']): ?>
                  <option value="<?php echo $category['id']; ?>" selected><?php echo $category['name']; ?></option>
              <?php else: ?>
                  <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
              <?php endif; ?>
           <?php endforeach; ?>
            </select>
          <?php if (!empty($errors['category'])) echo "<div class='text-danger'>{$errors['category']}</div>"; ?> 
        </div>
        <div class="col-sm-2">
          <button type="button" class="btn btn-primary  btn-sm" data-toggle="modal" data-target="#addCategoryModal">Add Category</button>
       </div>
    </div>
    <div class="form-group">
        <label for="quantity">Stock:</label>
        <input type="number" id="quantity" name="stock" min="0" <?php if(!empty($product)){echo 'value="'.$product[0]["stock"].'"';}?>>
        <?php if (!empty($errors['stock'])) echo "<div class='text-danger'>{$errors['stock']}</div>"; ?> 
    </div>
      <div class="form-group">
        <label for="productImage">Product Picture:</label>
        <?php if (!empty($product)): ?>
          <p id="image"><?php echo $product[0]["image"]; ?></p>
          <input type="hidden" id="hiddenImageName" name="hiddenImage" value="<?php echo $product[0]["image"]; ?>">
        <?php endif; ?>
        <input type="file" class="form-control-file" id="productImage" name="image" onchange="displayFileName(this)" >
        <?php if (!empty($errors['image'])) echo "<div class='text-danger'>{$errors['image']}</div>"; ?>
      </div>
      <button type="submit" class="btn btn-primary"> <?php if(!empty($product)){echo "Edit";}else {echo "Save";} ?></button>
      <button type="reset" class="btn btn-secondary">Reset</button>
      <?php if (!empty($product)): ?>
        <input type="hidden" id="hiddenImageName" name="id" value="<?php echo $product[0]["id"]; ?>">
    <?php endif; ?>
    </form>
  </div>
</div>
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm" action="../validation/category.php" method="post">
                    <div class="form-group">
                        <label for="categoryName">Category Name:</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName">
                        <input type="hidden" id="hiddenImageName" name="product_id" value="<?php if(!empty($product)){echo  $product_id;} ?>">
                        <?php if (!empty($errors['category'])): ?>
                            <div class="text-danger"><?php echo $errors['category']; ?></div>
                        <?php endif; ?>
                       
                    </div>
                    
                    <button type="submit" class="btn btn-primary"> Add</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function(){
  <?php if (!empty($errors['category'])): ?>
    $('#addCategoryModal').modal('show');
  <?php endif; ?>
});

function displayFileName(input) {
    var fileName = input.files[0].name;
    document.getElementById('image').style.display =  'none';
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
