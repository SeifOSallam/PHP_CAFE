<?php

require_once 'db_class.php';

$update = "quantity=".(int)$_GET['qty']+1;

$res = $database->updateQty('cart',$_GET['product_id'],$update);

var_dump($res);

header("Location:../Views/home.php");
?>