<?php

require_once 'db_class.php';

try
{
    $user_id = (int)$_GET['user_id'];
    $product_id = (int)$_GET['product_id'];
    $product_price = (float)$_GET['product_price'];
    $role = $_GET['role'];

    $status = $database->addToCart($user_id,$product_id,$product_price);
    if($role === 'user')
    {
        header('Location: ../Views/home.php');
    }
    else
    {
        header('Location: ../Views/admin_landing_page.php');
    }
}
catch (PDOException $e)
{
    echo $e->getMessage();
    header('Location: ../Views/home.php');
}




?>