<?php

require_once '../Controllers/db_class.php';

$database = Database::getInstance();

if(isset($_GET['page']))
{
    $products = $database->getProductsWithPage($_GET['page']); 
}

if(!isset($_GET['page']))
{
    $products = $database->getProductsWithPage(1); 
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'base.php';
    require '../Components/product_card.php';?>
    <link rel="stylesheet" href="../Components/style.css">
    <title>Document</title>

</head>
<body>

<?php require '../Components/navbar.php';?>

<div class="wrapper row">

        <div class="col-4">
        <h1 class='mt-5'>Order</h1>
        </div>

        <div class="col-8">
            <div class='row mt-5'>
                <!-- Products -->
                <div class="row">
                    <?php 
                    foreach ($products as $product)
                    {
                    product_card($product['image'],$product['name'],'Drinks',$product['price']);
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