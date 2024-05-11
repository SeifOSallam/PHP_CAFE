<?php

require_once 'db_class.php';


$update = "quantity=".(int)$_GET['qty']-1;

$res = $database->updateQty('cart',$_GET['product_id'],$update);
$role = $_GET['role'];

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