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

function selectProduct(){
    global $database;
    return $database->select("products");
}
function editProduct($id,$fields){
    global $database;
    var_dump($fields);
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

if(!empty($_GET['id'])){
    $std_id = $_GET['id'];
    deleteProduct($std_id);
    header("Location: ../Views/showProducts.php");
}
?>