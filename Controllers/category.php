<?php
require_once "db_class.php";
require_once "../db_info.php";

echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$database = Database::getInstance();

$database->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

function insertCatgory($name){
    echo "here";
    global $database;
    $database->insert("categories","name", "'$name'");
}

function selectCategories(){
    global $database;
    return $database->select("categories");
}
// insertCatgory("test");
?>