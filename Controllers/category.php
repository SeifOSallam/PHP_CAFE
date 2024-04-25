<?php
require_once "db_class.php";
require_once "../db_info.php";

$database = Database::getInstance();

$database->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

function insertCatgory($name){
    global $database;
    $database->insert("categories","name", "'$name'");
}

function selectCategories(){
    global $database;
    return $database->select("categories");
}

?>