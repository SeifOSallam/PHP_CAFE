<?php

require_once 'db_class.php';

$update = "quantity=".(int)$_GET['qty']+1;
$qty = (int)$_GET['qty']+1;
$role = $_GET['role'];

$product = $database->getProductById($_GET['product_id']);

if($qty > (int)$product[0]['stock'])
{
    if ($role === 'admin')
    {
        header("Location:../Views/admin_landing_page.php?error=Can not add more from this product");
        exit();
    }

    if ($role === 'user')
    {
        header("Location:../Views/home.php?error=Can not add more from this product");
        exit();
    }
}

$res = $database->updateQty('cart',$_GET['product_id'],$update);


if($role === 'user')
{
    header("Location:../Views/home.php");
    exit();
}
if($role === 'admin')
{
    header("Location:../Views/admin_landing_page.php");
    exit();
}
?>