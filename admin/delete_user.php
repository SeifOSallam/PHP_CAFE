<?php
require_once  '../db_connection.php';
require_once './utils.php';
require_once '../db_info.php';
require_once '../Controllers/db_class.php';

var_dump($_GET);
$user_id = $_GET['id'];

try{

    $database = Database::getInstance();

    $res = $database->delete(DB_TABLE,$user_id);

    header("Location:admin_home.php");
    
}catch(PDOException $e){
    echo $e->getMessage();

}