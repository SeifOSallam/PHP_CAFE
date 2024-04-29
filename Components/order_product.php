<?php 
function product_card($name, $price, $quantity, $img){
  echo "
      <div class='card' style='width:18rem;'>
      <img src='$img' class='card-img-top' alt='...'>
      <div class='card-body'>
        <h5 class='card-title text-center'>$name</h5>
        <h4 class='card-text text-center text-warning fw-bold'>$quantity</h4>
        <p class='card-text text-center text-success'>$$price</p>
      </div>
    </div>
  ";
}
?>