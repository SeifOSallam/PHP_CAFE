<?php
include "../Controllers/category.php";
include "base.php";

if(isset($_GET['errors'])){
    $errors = json_decode($_GET["errors"], true);
}

if(isset($_GET['old_data'])){
    $old_data = json_decode($_GET["old_data"], true);
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
      padding: 30px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
    }
    .form-container h2 {
      text-align: center;
    }
    .bg-image {
      background-image: url('your-image.jpg');
      background-size: cover;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      filter: blur(5px); 
    }
    .modal-dialog.modal-dialog-centered {
        display: flex;
        align-items: center;
        min-height: calc(100% - 3.5rem); 
    }

    .modal-content {
        margin: auto;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="bg-image"></div>
  <div class="form-container">
    <h2>Product Form</h2>
    <form action="../validation/productFormValidation.php" method="post" enctype="multipart/form-data">
      <div class="form-group ">
        <label for="productName">Product:</label>
        <input type="text" class="form-control" id="productName" placeholder="Enter product name" name="name">
        <?php if (!empty($errors['name'])) echo "<div class='text-danger'>{$errors['name']}</div>"; ?>
      </div>
      <div class="form-group">
        <label for="quantity">Price:</label>
        <input type="text" id="quantity" name="price" >
      </div>
     <div class="form-group row">
        <label for="productCategory" class="col-sm-3 col-form-label">Category:</label>
        <div class="col-sm-7">
            <select class="form-control" id="productCategory" name="category">
              <?php foreach ($categories as $category): ?>
                  <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
              <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm-2">
          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addCategoryModal">Add Category</button>
       </div>
    </div>
    <div class="form-group">
        <label for="quantity">Stock:</label>
        <input type="number" id="quantity" name="stock" min="0">
    </div>
      <div class="form-group">
        <label for="productImage">Product Picture:</label>
        <input type="file" class="form-control-file" id="productImage" name="image">
        <?php if (!empty($errors['image'])) echo "<div class='text-danger'>{$errors['image']}</div>"; ?>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
      <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
  </div>
</div>
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                        <?php if (!empty($errors['category'])): ?>
                            <div class="text-danger"><?php echo $errors['category']; ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>

            </div>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
