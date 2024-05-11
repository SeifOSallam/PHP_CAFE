<?php 
function product_card($user_id,$role,$product_id, $img, $name, $category, $price , $stock)
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
                <span class="p-company">'.$category.'</span>';

    if((int)$stock > 0)
    echo'<span class="p-company">In stock</span>';
    else
    echo'<span class="p-company">Out of stock</span>';

    echo'   </div>
            </div>
          </div>

          <div class="box-down">
            <div class="h-bg">
              <div class="h-bg-inner"></div>
            </div>';

    if((int)$stock > 0)
    echo'    <a class="cart" href="../Controllers/add_to_cart.php?product_id='.$product_id.'&user_id='.$user_id.'&product_price='.$price.'&role='.$role.'">
              <span class="price">'.$price.'$</span>
              <span class="add-to-cart">
                <span class="txt">Order Now</span>
              </span>
            </a>';
    else if ((int)$stock == 0 && $role === 'user')
    echo'    <a class="cart" href="../Views/home.php?error=Can not add out of stock item">
              <span class="price">'.$price.'$</span>
              <span class="add-to-cart">
                <span class="txt">Order Now</span>
              </span>
            </a>';   
    else if ((int)$stock == 0 && $role === 'admin')
    echo'    <a class="cart" href="../Views/admin_landing_page.php?error=Can not add out of stock item">
              <span class="price">'.$price.'$</span>
              <span class="add-to-cart">
                <span class="txt">Order Now</span>
              </span>
            </a>'; 
    echo'
          </div>
        </div>
      </div>
    </div>
  </div>';
}
?>