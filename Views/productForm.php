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
  </style>
</head>
<body>

<div class="container">
  <div class="bg-image"></div>
  <div class="form-container">
    <h2>Product Form</h2>
    <form action="../Controllers/productForm.php" method="post" enctype="multipart/form-data">
      <div class="form-group ">
        <label for="productName">Product:</label>
        <input type="text" class="form-control" id="productName" placeholder="Enter product name" name="name">
      </div>
      <div class="form-group">
        <label for="quantity">Price:</label>
        <input type="number" id="quantity" name="quantity" min="1" max="5">
      </div>
     <div class="form-group row">
        <label for="productCategory" class="col-sm-3 col-form-label">Category:</label>
        <div class="col-sm-7">
            <select class="form-control" id="productCategory" name="category">
            <option value="category1">Category 1</option>
            <option value="category2">Category 2</option>
            <option value="category3">Category 3</option>
            </select>
        </div>
        <div class="col-sm-2">
           <a href="#" class="btn btn-info btn-sm">Add Category</a>
        </div>
    </div>
      <div class="form-group">
        <label for="productImage">Product Picture:</label>
        <input type="file" class="form-control-file" id="productImage" name="profile">
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
      <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
