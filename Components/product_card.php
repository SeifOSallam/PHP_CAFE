<?php 
function product_card($img,$name,$category,$price)
{
echo'
<div class="col-4">
  <div class="page-inner">
    <div class="row">
      <div class="el-wrapper">
        <div class="box-up">
          <img class="img" src="./assets/'.$img.'" alt="">
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

          <a class="cart" href="#">
            <span class="price">'.$price.'$</span>
            <span class="add-to-cart">
              <span class="txt">Add in cart</span>
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>';
}
?>