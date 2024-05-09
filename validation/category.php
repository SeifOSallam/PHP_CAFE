<?php
include "../Controllers/category.php";

$errors = [];
if (isset($_POST['categoryName'])) {
    $categoryName = trim($_POST['categoryName']);

    if (empty($categoryName)) {
        $errors['category'] = "You enter a empty for the category, please try to add again with data.";
    } 
} 


if (!empty($errors)) {
    $errors = json_encode($errors);
    header("Location: ../Views/productForm.php?errors={$errors}");
    exit;
} else {
    insertCatgory($categoryName);
    if(isset($_POST['product_id'])){
        $id=$_POST['product_id'];
       header("Location: ../Views/productForm.php?id={$id}&action=edit");
    }else{
        header("Location: ../Views/productForm.php");
    }
    exit; 
}

?>
