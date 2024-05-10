<?php

require_once 'db_class.php';

$qty = 1;

$product = $database->getProductById(1);
$qty = $product[0]['stock'] - $qty;
$qty = (string)$qty;
echo $qty;
var_dump('stock='.$qty);
$database->update('products',1,'stock='.$qty);

var_dump($product['stock']);

// var_dump($product[0]['stock']);

?>