<?php
include "../Controllers/product.php";
include "../Views/base.php";
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

if ($_SERVER["REQUEST_METHOD"] === "POST"&& empty($_POST['id'])) {
    $filename = $_FILES['image']['name'];
    if(!empty($_FILES['image']['tmp_name']))
    {
        if (isset($_FILES['image']['tmp_name'])){
            $filename = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
            $file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_extensions)) {
                $errors['image'] = "Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
            } else {
                $saved = move_uploaded_file($tmp_name, "../assets/{$filename}");
            }
        }
    }else{
        $errors['image'] = "image is required";
    }
    $name = $_POST['name'];
    if (empty($_POST['name'])) {
        $errors['name'] = "name is required";
    } 
    $price = $_POST['price'];
    if (empty($_POST['price'])) {
        $errors['price'] = "price is required";
    } elseif ($_POST['price'] < 0) {
        $errors['price'] = "Price cannot be negative.";
    }
    $stock = $_POST['stock'];

    if (empty($_POST['stock'])&$_POST['stock']!=0) {
        $errors['stock'] = "stock is required";
    } elseif ($_POST['stock '] < 0) {
        $errors['stock '] = "Stock cannot be negative.";
    }
    if (!empty($errors)) {
        $errors = json_encode($errors);
        header("Location: ../Views/productForm.php?errors={$errors}");
        exit;
    }else if (empty($_POST['id'])) {
        $stock = $_POST['stock'];
        $category_id = $_POST['category'];
        $price = $_POST['price'];
        insertProduct($name, $price, $category_id, $stock, $filename);
        header("Location: ../Views/showProducts.php");
    } 
} else if($_SERVER["REQUEST_METHOD"] === "POST"&& !empty($_POST['id'])){
    $id=$_POST['id'];
    $filename = $_FILES['image']['name'];
    if(!empty($_FILES['image']['tmp_name']))
    {
        if (isset($_FILES['image']['tmp_name'])){
            $filename = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
            $file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_extensions)) {
                $errors['image'] = "Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
            } else {
                $saved = move_uploaded_file($tmp_name, "../assets/{$filename}");
            }
        }else{
            $errors['image'] = "image is required";
        }
    }
    $name = $_POST['name'];
    if (empty($_POST['name'])) {
        $errors['name'] = "name is required";
    } 
    $price = $_POST['price'];
    if (empty($_POST['price'])) {
        $errors['price'] = "price is required";
    } elseif ($_POST['price'] < 0) {
        $errors['price'] = "Price cannot be negative.";
    }

    $stock = $_POST['stock'];

    if (empty($_POST['stock'])&$_POST['stock']!=0) {
        $errors['stock'] = "stock is required";
    }  elseif ($_POST['stock '] < 0) {
        $errors['stock '] = "Stock cannot be negative.";
    }

    if (!empty($errors)) {
        $errors = json_encode($errors);
        header("Location: ../Views/productForm.php?id={$id}&action=edit&errors={$errors}");
        exit;
    }else{
        $id = $_POST['id'];
        $existing_product = getOneProduct($id); 
        $fields_to_update = array();
        $name = $_POST['name'];
        
            if ($name != $existing_product[0]['name']) {
                $fields_to_update['name'] = $name;
            }
    
            if ($_POST['stock'] != $existing_product[0]['stock']) {
                $fields_to_update['stock'] = $_POST['stock'];
            }
            if ($_POST['category'] != $existing_product[0]['category_id']) {
                $fields_to_update['category_id'] = $_POST['category'];
            }
            if ($_POST['price'] != $existing_product[0]['price']) {
                $fields_to_update['price'] = $_POST['price'];
            }
            if (!empty($filename) && $filename != $existing_product[0]['image']) {
                $fields_to_update['image'] = $filename;
            }
        
            if (!empty($fields_to_update)) {
                $update_fields = '';
                foreach ($fields_to_update as $field => $value) {
                    $update_fields .= "$field='$value',";
                }
                $update_fields = rtrim($update_fields, ','); 
        
                editProduct($id, $update_fields);
            } else {
                $errors['fields'] = "No changes to update";
            }
        
            header("Location: ../Views/showProducts.php");
    }
   
    }
else {
        echo "Invalid request method.";
}

?>
  </div>
</body>

</html>


















