<?php

function user_navbar($username,$image,$role)
{

echo '<nav class="navbar navbar-expand-lg fixed-top navbar-scroll">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
        data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">';

      if($role === 'user')
      {
        echo '<ul class="navbar-nav me-auto">
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="showOrders.php">My Orders</a>
        </li>
        </ul>';
      }

      if($role === 'admin')
      {
        echo '<ul class="navbar-nav me-auto">
        
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="admin_landing_page.php">Home</a>
        </li>
        
        <li class="nav-item">
        <a class="nav-link" href="showProducts.php">Products</a>
        </li>
        
        <li class="nav-item">
        <a class="nav-link" href="admin_home.php">Users</a>
        </li>        
        
        <li class="nav-item">
        <a class="nav-link" href="showOrders.php">Manual Order</a>
        </li>

        <li class="nav-item">
        <a class="nav-link" href="checksPage.php">Checks</a>
        </li>
        </ul>';
      }

      echo'  <ul class="navbar-nav d-flex flex-row">
          <li class="nav-item me-3 me-lg-0">
            <a class="nav-link" href="#!">
              <i class="fas fa-shopping-cart"></i>
            </a>
          </li>
          <li class="nav-item me-3 me-lg-0">
            <a class="nav-link" href="#!">
              <i class="fab fa-twitter"></i>
            </a>
          </li>
          <li class="nav-item me-3 me-lg-0">
            <a class="nav-link" href="#!">
              <i class="fab fa-instagram"></i>
            </a>
          </li>
        </ul>

        
        <div class="position-relative end ">
        '.$username.'
        ';
        if (!$image)
        {
          echo'<img src="../assets/default_user.jpg" class="rounded-circle" style="width:50px;" alt="user image"/>';
        }
        else
        {
          echo'<img src="../assets/'.$image.'" class="rounded-circle" style="width:50px;" alt="user image"/>';
        }

        echo '
        </div>
        <a class="btn btn-dark btn-sm mx-3" href="../Controllers/logout.php">Logout</a>
      </div>
    </div>
  </nav>
  <!-- Navbar -->';


}