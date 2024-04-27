<?php

require_once './db_class.php';
var_dump($_GET);
$res = $database->deleteItem('cart',$_GET['product_id'],$_GET['user_id']);

// var_dump($res);
header('Location:../Views/home.php');

?>
