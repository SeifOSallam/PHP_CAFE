<?php
require_once "db_class.php";
require_once "../db_info.php";

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

?>