<?php
include "../Controllers/category.php";

$errors = [];
if (isset($_POST['categoryName'])) {
    $categoryName = trim($_POST['categoryName']);

    if (empty($categoryName)) {
        $errors['category'] = "Category name is required.";
    } 
} else {
    $errors['category'] = "Category name is required.";
}

if (!empty($errors)) {
    $errors = json_encode($errors);
    header("Location: ../Views/productForm.php?errors={$errors}");
    exit;
} else {
    insertCatgory($categoryName);
    header("Location: ../Views/productForm.php");
    exit; 
}

?>
