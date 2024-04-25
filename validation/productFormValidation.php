<?php
include "../Controllers/product.php"

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
</head>

<body>
  <div class="container">
  <?php

include "../Views/base.php";

$errors = [];

function sanitize_input($input)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES['image']['tmp_name'])){
        $filename = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        $file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_extensions)) {
            $errors['image'] = "Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
        } else {
            $saved = move_uploaded_file($tmp_name, "../assets/images/{$filename}");
        }
    }else{
        $errors['image'] = "image is required";
    }
    $name = $_POST['name'];
    if (empty($name)) {
        $errors['name'] = "name is required";
    } 
    if (!empty($errors)) {
        $errors = json_encode($errors);
        header("Location: ../Views/productForm.php?errors={$errors}");
        exit;
    } else {
        $stock = $_POST['stock'];
        $category_id = $_POST['category'];
        $price = $_POST['price'];
        insertProduct($name, $price , $category_id ,$stock,$filename);
        header("Location: ../Views/productForm.php?errors={$errors}");
    }
} else {
        echo "Invalid request method.";
}

?>
  </div>
</body>

</html>



















