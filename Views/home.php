<?php

require_once '../Controllers/db_class.php';


if(isset($_GET['page']))
{
    $products = $database->getProductsWithPage($_GET['page']); 
}

if(!isset($_GET['page']))
{
    $products = $database->getProductsWithPage(1); 
}


$cartItems = $database->getUserItems('cart',1);

$total= 0;

$user_id = 1;
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

<?php require '../Components/navbar.php';?>

<div class="wrapper row">

        <div class="col-4">
            <div class="row text-center">
                <h1 class='mt-5 text-ceneter'>Orders</h1>
                <?php
                if(!$cartItems)
                {
                    echo '<h3 class="text-danger"> No products to be ordered </h3>';
                }
                foreach ($cartItems as $Item)
                {
                    $total += (float)$Item['price']*(int)$Item['quantity'];
                    // user id needed here --------------------------------------------------------
                    cart_item($user_id,$Item['product_id'],$Item['name'],$Item['price'],$Item['image'],$Item['quantity']);
                }
                ?>

<div>
    <!-- // user id needed here -------------------------------------------------------- -->
    <?php
                    echo '<form action="../Controllers/confirm_order.php?user_id='.$user_id.'&total='.$total.'" method="post">
                    
                    <input id="total" name="total"  value="       Toatal : '.$total.'" class="my-4" disabled />
                    
                    <label for="room_no">Room No:</label>
                    <select id="room_no" name="room_no">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    </select>
                    
                    <p>Notes</p>
                    
                    <textarea id="note" name="note" rows="4" cols="40" placeholder="Add note here"></textarea>


                    <button type="submit" class="btn btn-primary">Confirm</button>
                    </form>'
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
                    product_card(1,$product['id'],$product['image'],$product['name'],'Drinks',$product['price']);
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