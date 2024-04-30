<?php

require_once '../Controllers/db_class.php';
require '../Components/navbar.php';
session_start();

if(is_null($_SESSION['id']))
{
    header('Location:login_form.php');
}

if(isset($_GET['page']))
{
    $products = $database->getProductsWithPage($_GET['page']); 
}

if(!isset($_GET['page']))
{
    $products = $database->getProductsWithPage(1); 
}

$cartItems = $database->getUserItems('cart',$_SESSION['id']);

$rooms = $database->select('rooms');

$total= 0;

$user_id = $_SESSION['id'];
$role = $_SESSION['role'];

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

<?php user_navbar($_SESSION['username'],$_SESSION['image'],$_SESSION['role']) ?>

<div class="wrapper row">
        <div class="col-4">
            <div class="row text-center p-4">
                <h1 class='mt-5 text-ceneter'>Orders</h1>
                <?php
                if(!$cartItems)
                {
                    echo '<h3 class="text-danger"> No products to be ordered </h3>';
                }
                echo '<div class="d-flex flex-column">';
                foreach ($cartItems as $Item)
                {
                    $total += (float)$Item['price']*(int)$Item['quantity'];
                    cart_item($user_id,$role,$Item['product_id'],$Item['name'],$Item['price'],$Item['image'],$Item['quantity']);
                }
                echo '</div>';
                ?>

<div>
    <?php
                    echo '<form action="../Controllers/confirm_order.php?user_id='.$user_id.'&total='.$total.'" method="post">';
                    
                    echo '<div class="d-flex flex-column">';

                    echo '<input id="total" name="total"  value="       Toatal : '.$total.'" class="my-4" disabled />
                    
                    <label for="room_no">Room No:</label>
                    <select id="room_no" name="room_no">';

                    foreach($rooms as $room)
                    {
                        echo'<option value="'.$room['id'].'">'.$room['room_number'].'</option>';
                    }
                    
                    echo'
                    </select>
                    <p>Notes</p>
                    <textarea id="note" name="note" rows="4" cols="40" placeholder="Add note here"></textarea>
                    <button type="submit" class="btn btn-primary">Confirm</button>';
                    echo '</div></form>'
                    ?>
                </div>
            </div>
        </div>

        <div class="col-8">
            <div class='row mt-5'>
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
                for ($i=1 ; $i <= (20/6)+1; $i++)
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