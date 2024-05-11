<?php 
    include "../Controllers/order.php";
    require "../Components/adminOrdersTable.php";
    require '../Components/navbar.php';
    session_start();

    user_navbar($_SESSION['username'],$_SESSION['image'],$_SESSION['role']);
    
    $currPage = empty($_GET['page'])? 1 : $_GET['page'];
    $filters = array();
    if (!empty($_GET['date_from'])) {
        $filters['date_from'] = $_GET['date_from'];
    }
    if (!empty($_GET['date_to'])) {
        $filters['date_to'] = $_GET['date_to'];
    }
    if (!empty($_GET['user'])) {
        $filters['user'] = $_GET['user'];
    }
    $orders = getAllOrders($currPage, $filters);
    $totalPages = floor(getOrdersCount($filters)[0]['count']/6)+1;
    $users = getUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <style>
        .container-margin-top {
            margin-top: 80px;
        }

        .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
        .container {
        padding: 2px 16px;
        }
        .card {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        border-radius: 5px; 
        }
        img {
        border-radius: 5px 5px 0 0;
        }
        .total-price {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<?php 
    if (empty($orders)) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
        echo '<strong>' . "No orders found" . '</strong>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
    displayOrdersTable($orders, $users, $currPage, $totalPages, $filters);
?>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
</html>
