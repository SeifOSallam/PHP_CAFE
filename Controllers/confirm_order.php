<?php

require_once 'db_class.php';


$user_id = (int)$_GET['user_id'];
$room_id = (int)$_POST['room_no'];
$total_amount = (float)$_GET['total'];
$note = $_POST['note'];
$date = date("Y-m-d");

// create order 
$order_id = $database->insert('orders','user_id,total_amount,notes,room_id,order_date,status',"'$user_id',$total_amount,'$note',$room_id,'$date','Processing'");

// add cart items to order_items
$cartItems = $database->getUserItems('cart',$user_id);

foreach ($cartItems as $item)
{
    $product_id = (int)$item['product_id'];
    $quantity = $item['quantity'];
    $product_price = (float)$item['product_price'];

    $database->insert('order_items','product_id,order_id,quantity,product_price',"$product_id,$order_id,$quantity,$product_price");
    $database->deleteItem('cart',$product_id,$user_id);
}

header("Location:../Views/home.php");

?>