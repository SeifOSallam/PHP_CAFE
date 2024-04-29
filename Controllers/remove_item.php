<?php

require_once './db_class.php';

$res = $database->deleteItem('cart',$_GET['product_id'],$_GET['user_id']);
$role = $_GET['role'];

if($role === 'user')
{
    header('Location:../Views/home.php');
}
else
{
    header('Location:../Views/admin_landing_page.php');
}

?>
