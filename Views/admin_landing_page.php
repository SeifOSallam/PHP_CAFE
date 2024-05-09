<?php

require_once '../Controllers/db_class.php';
require '../Components/navbar.php';
session_start();

if(isset($_GET['page']))
{
    $products = $database->getProductsWithPage($_GET['page']); 
}

if(!isset($_GET['page']))
{
    $products = $database->getProductsWithPage(1); 
}

$user_id = $_SESSION['id'];
$role = $_SESSION['role'];

$cartItems = $database->getUserItems('cart',$user_id);

$rooms = $database->select('rooms');

$total= 0;

$users = $database->getAllUsers();

$count = $database->getCount('products');
$count = $count[0]['count'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php 
    require 'base.php';
    require '../Components/product_card.php';
    require '../Components/cart_item.php'
    ?>
    <link rel="stylesheet" href="../Components/style.css">
    <title>Document</title>
    
</head>
<body>
    
    <?php user_navbar($_SESSION['username'],$_SESSION['image'],$_SESSION['role']);?>
    <?php 

if(isset($_GET['error'])) 
{
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error !</strong> Can not order when cart is empty :)
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
if(isset($_GET['success'])) 
{
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success !</strong> Order Placed successfully !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
    ?>

    <div class="wrapper row">
        <div class="col-4">
            <div class="row text-center p-4">
                <!-- <h1 class='mt-5 text-ceneter'>Cart</h1> -->
                
                <?php
                echo '<div class="d-flex flex-column justify-content-center ">';
                if(!$cartItems)
                {
                    echo '<h3 class="text-danger"> No products to be ordered </h3>';
                }
                foreach ($cartItems as $Item)
                {
                    $total += (float)$Item['price']*(int)$Item['quantity'];
                    cart_item($user_id,$role,$Item['product_id'],$Item['name'],$Item['price'],$Item['image'],$Item['quantity']);
                }
                echo '</div>';
                ?>

<div>
    <?php
                    echo '<form class="form-inline" action="../Controllers/confirm_order.php?user_id='.$user_id.'&total='.$total.'" method="post">';

                    echo '<div class="d-flex flex-column">';
                    
                    echo '<label for="user">Choose user : </label>';

                    // Users
                    echo '<select class="form-select w-50 m-auto" id="user" name="user">';
                    foreach($users as $user)
                    {
                        echo'<option value="'.$user['id'].'">'.$user['username'].'</option>';
                    }
                    echo '</select>';

                    echo'
                    <input  class="form-control w-50 bg-white m-auto my-4" id="total" name="total"  value="Toatal : '.$total.'" class="my-4" disabled />
                    <label for="room_no">Room No:</label>
                    <select class="form-select w-50 m-auto" id="room_no" name="room_no">';
                    
                    // Rooms
                    foreach($rooms as $room)
                    {
                        echo'<option value="'.$room['id'].'">'.$room['room_number'].'</option>';
                    }
                    
                    echo'
                    </select>
                    <p class="mt-3">Notes</p>
                    <textarea  class="form-control" id="note" name="note" rows="4" cols="40" placeholder="Add note here"></textarea>
                    <button type="submit" class="btn btn-primary m-auto w-50 my-3">Confirm</button>';

                    echo '</div> </form>';
                    ?>
                </div>
            </div>
        </div>

        <div class="col-8">
            <div class='row'>
                <!-- Products -->
                <div class="row">
                    <?php 
                    foreach ($products as $product)
                    {
                    product_card($user_id,$role,$product['id'],$product['image'],$product['name'],$product['category'],$product['price']);
                    }
                    ?>
                </div>
                
                <!-- Pages Buttons -->
                <div class="inline-block text-center">
                <?php
                for ($i=1 ; $i <= ($count/6)+1; $i++)
                {
                    echo "<a href='?page=$i' class='btn btn-primary mx-2'>$i</a>";
                }
                ?>
                </div>
        </div>
        </div>
    </div>


<!--  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>