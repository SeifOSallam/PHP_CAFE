<?php
require_once '../Controllers/utils.php';
require_once '../db_info.php';
require_once '../Controllers/db_class.php';

$user_id = $_GET['id'];

try{

    $database = Database::getInstance();

    $res = $database->delete(DB_TABLE,$user_id);

    header("Location:../Views/admin_home.php");
    
}catch(PDOException $e){
    echo $e->getMessage();

}