<?php

function cart_item($id,$name,$price,$image,$quantity)
{
echo '<div class="col-sm-12 mx-5 my-3">
              <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">

              <div class="d-flex justify-content-around  align-align-items-center ">
                <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                  <img src="../assets/'.$image.'" class="w-100" alt="Blue Jeans Jacket" />
                  <a href="#!">
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                  </a>
                </div>

                <div class="d-block">
                    <a type="button" class="btn btn-danger btn-sm me-1 mb-2  mx-2 text-center" href="../Controllers/remove_item.php?product_id='.$id.'"> X</a>
                </div>
                </div>
              </div>

              <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                <!-- Data -->
                <p class="fw-bold">'.$name.'</p>

                <p class="text-start text-md-center">
                  <strong>Price : '.$price.'$</strong>
                </p>

              </div>

              <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <!-- Quantity -->
                <div class="d-flex mb-4" style="max-width: 300px">
                  <a class="btn btn-success px-3 mx-2 text-center fw-bold " href="../Controllers/inc_item_qty.php?qty='.$quantity.'&product_id='.$id.'"> + </a>

                    <p class="mx-3">'.$quantity.'</p>

                  <a class="btn btn-warning px-3 mx-2 text-center fw-bold " href="../Controllers/dec_item_qty.php?qty='.$quantity.'&product_id='.$id.'"> - </a>
                </div>




              </div>

             
            </div>';
}
?>