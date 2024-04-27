<?php

require_once 'db_class.php';

try
{
    $user_id = (int)$_GET['user_id'];
    $product_id = (int)$_GET['product_id'];
    $product_price = (float)$_GET['product_price'];

    $status = $database->addToCart($user_id,$product_id,$product_price);
    header('Location: ../Views/home.php');
}
catch (PDOException $e)
{
    echo $e->getMessage();
    header('Location: ../Views/home.php');
}




?>