<?php 
function product_card($user_id, $product_id, $img, $name, $category, $price)
{
  echo '
  <div class="col-4">
    <div class="page-inner">
      <div class="row">
        <div class="el-wrapper">
          <div class="box-up">
            <img class="img" src="../assets/'.$img.'" alt="">
            <div class="img-info">
              <div class="info-inner">
                <span class="p-name">'.$name.'</span>
                <span class="p-company">'.$category.'</span>
              </div>
            </div>
          </div>

          <div class="box-down">
            <div class="h-bg">
              <div class="h-bg-inner"></div>
            </div>

            <a class="cart" href="../Controllers/add_to_cart.php?product_id='.$product_id.'&user_id='.$user_id.'&product_price='.$price.'">
              <span class="price">'.$price.'$</span>
              <span class="add-to-cart">
                <span class="txt">Order Now</span>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>';
}
?>