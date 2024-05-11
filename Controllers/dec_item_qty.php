<?php

require_once 'db_class.php';


$update = "quantity=".(int)$_GET['qty']-1;

$role = $_GET['role'];
$qty = (int)$_GET['qty']-1;
$product_id = $_GET['product_id'];
$user_id = $_SESSION['id'];

if ($qty === 0)
{
    $database->deleteItem('cart',$product_id,$user_id);

    if ($role === 'admin')
    {
        header("Location:../Views/admin_landing_page.php?error=can not be zero");
        exit();
    }
    
    if ($role === 'user')
    {
        header("Location:../Views/home.php?error=can not be zero");
        exit();
    }
}

$res = $database->updateQty('cart',$_GET['product_id'],$update);

if ($role === 'user')
{
    header("Location:../Views/home.php");
    exit();
}

if ($role === 'admin')
{
    header("Location:../Views/admin_landing_page.php");
    exit();
}

?>