<?php

function cart_item($user_id,$role,$product_id,$name,$price,$image,$quantity)
{
echo '<div class="col-sm-12 m-auto position-relative">
              <div class="col-lg-3 col-md-12 m-auto">

              <div class="d-flex justify-content-around  align-align-items-center">
                <div class="bg-image rounded" data-mdb-ripple-color="light">
                  <img src="../assets/'.$image.'" class="w-100 h-100 mt-2" alt="img" />
                  <a href="#!">
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                  </a>
                </div>
                
                <div class="position-absolute top-0 end-0 ">
                    <a type="button" class="btn btn-danger btn-sm me-1 mb-2  mx-2 text-center" href="../Controllers/remove_item.php?product_id='.$product_id.'&user_id='.$user_id.'&role='.$role.'">&times;</a>
                </div>
                </div>
              </div>

              <div class="col-lg-5 col-md-6 mb-4 mb-lg-0 m-auto">
                <!-- Data -->
                <p class="fw-bold mt-3">'.$name.'</p>

                <p class="text-start text-md-center mt-3">
                  <strong>Price : '.$price.'$</strong>
                </p>

              </div>

              <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 m-auto">
                <!-- Quantity -->
                <div class="d-flex mb-4" style="max-width: 300px">

                  <a class="btn btn-warning px-3 mx-2 text-center fw-bold " href="../Controllers/dec_item_qty.php?qty='.$quantity.'&product_id='.$product_id.'&role='.$role.'"> - </a>

                    <p class="mx-3">'.$quantity.'</p>

                  <a class="btn btn-success px-3 mx-2 text-center fw-bold " href="../Controllers/inc_item_qty.php?qty='.$quantity.'&product_id='.$product_id.'&role='.$role.'"> + </a>
                </div>




              </div>

             
            </div>';
}
?>