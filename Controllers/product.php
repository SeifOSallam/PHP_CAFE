<?php
require_once "db_class.php";
require_once "../db_info.php";
include "../Views/base.php";
$database = Database::getInstance();

$database->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

function insertProduct($name,$price,$category_id,$stock,$image){
    global $database;
    $database->insert("products","category_id,name,price,stock,image", "'$category_id','$name','$price','$stock','$image'");
}

function selectProduct($page){
    global $database;
    return $database->selectProducts($page);
}
function editProduct($id,$fields){
    global $database;
    return $database->update("products",$id,$fields);
}
function deleteProduct($id){
    global $database;
    return $database->delete("products",$id);
}
function getOneProduct($id){
    global $database;
    return $database->getProductById($id);
}

if(!empty($_GET['id']) && ($_GET['action']=="delete")){
    $std_id = $_GET['id'];
    $error = [];
    if(!deleteProduct($std_id)){
        $error = "I can't delete this product because there are orders associated with it.";
        header("Location: ../Views/showProducts.php?error={$error}");
    }else{
        $success = "I can't delete this product because there are orders associated with it.";
       header("Location: ../Views/showProducts.php?success={ $success}");
    }
}

function getProductsCount(){
    global $database;
    return $database->getCount('products');
}
?>