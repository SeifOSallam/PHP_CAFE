<?php

require_once 'db_class.php';

$update = "quantity=".(int)$_GET['qty']+1;
$role = $_GET['role'];

$res = $database->updateQty('cart',$_GET['product_id'],$update);

var_dump($res);

if($role === 'user')
{
    header("Location:../Views/home.php");
}
else
{
    header("Location:../Views/admin_landing_page.php");
}
?>