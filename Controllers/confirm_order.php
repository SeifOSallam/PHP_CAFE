<?php

require_once 'db_class.php';

$user_id = (int)$_GET['user_id'];
$room_id = (int)$_POST['room_no'];
$total_amount = (float)$_GET['total'];
$note = $_POST['note'];
$date = date("Y-m-d");

if(!is_null($_POST['user']))
{
$another_user = (int)$_POST['user'];

// check if cart is empty

if ($total_amount == 0 )
{
    header('Location:../Views/admin_landing_page.php?error="Your cart is empty"');
    exit();
}

// create order 
$order_id = $database->insert('orders','user_id,total_amount,notes,room_id,order_date,status',"'$another_user',$total_amount,'$note',$room_id,'$date','Processing'");

// add cart items to order_items
$cartItems = $database->getUserItems('cart',$user_id);

foreach ($cartItems as $item)
{
    $product_id = (int)$item['product_id'];
    $quantity = (int)$item['quantity'];
    $product_price = (float)$item['product_price'];

    $database->insert('order_items','product_id,order_id,quantity,product_price',"$product_id,$order_id,$quantity,$product_price");

    $product = $database->getProductById($product_id);

    $quantity = $product[0]['stock'] - $quantity;
    $quantity = (string)$quantity;

    $database->update('products',$product[0]['id'],'stock='.$quantity);

    $database->deleteItem('cart',$product_id,$user_id);
}

header('Location:../Views/admin_landing_page.php?success=Order placed successfully');
}

else
{

// check if cart is empty

if ($total_amount == 0 )
{
    header('Location:../Views/home.php?error=Your cart is empty');
    exit();
}

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
   
    $product = $database->getProductById($product_id);

    $quantity = $product[0]['stock'] - $quantity;
    $quantity = (string)$quantity;

    $database->update('products',$product[0]['id'],'stock='.$quantity);

    $database->insert('order_items','product_id,order_id,quantity,product_price',"$product_id,$order_id,$quantity,$product_price");

    $database->deleteItem('cart',$product_id,$user_id);
}

header('Location:../Views/home.php?success=Order placed successfully');
}



?>