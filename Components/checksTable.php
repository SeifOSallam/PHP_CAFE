<?php
require_once '../Controllers/checks.php';
require 'order_product.php';


function buildQueryString() {
    $queryString = "";
    if (isset($_GET['user'])) {
        $queryString .= "&user=" . $_GET['user'];
    }
    if (isset($_GET['date_from'])) {
        $queryString .= "&date_from=" . $_GET['date_from'];
    }
    if (isset($_GET['date_to'])) {
        $queryString .= "&date_to=" . $_GET['date_to'];
    }
    return $queryString;
}
function buildQueryStringWithCheck() {
    $queryString = "";
    if (isset($_GET['user'])) {
        $queryString .= "&user=" . $_GET['user'];
    }
    if (isset($_GET['date_from'])) {
        $queryString .= "&date_from=" . $_GET['date_from'];
    }
    if (isset($_GET['date_to'])) {
        $queryString .= "&date_to=" . $_GET['date_to'];
    }
    if (isset($_GET['check'])) {
        $queryString .= "&check=" . $_GET['check'];
    }
    return $queryString;
}
function displayChecksTable($data, $users, $currentPage, $totalPages, $filters){
    echo "<div class='container w-75 mx-auto' style='margin-top:10rem;'>";
    echo 
    "<form class='row'>
        <div class='col-lg-3 col-sm-6'>
            <select name='user' id='user' class='form-select'>
                <option selected value=''>All</option>";
                foreach($users as $user) {
                    echo "<option>{$user['username']}</option>";
                }
                echo "
            </select>
        </div>
        <div class='col-lg-3 col-sm-6 d-flex justify-content-center align-items-center'>
            <label for='date_from'>From: </label>
            <input class='form-control' type='date' id='date_from' name='date_from'>
        </div>
        <div class='col-lg-3 col-sm-6 d-flex justify-content-center align-items-center'>
            <label for='date_to'>To: </label>
            <input class='form-control' type='date' id='date_to' name='date_to'>
        </div>
        <div class='col-lg-3 col-sm-6 d-flex justify-content-center'>
            <input class='btn btn-info' type='submit' value='Filter'>
        </div>

    </form>";
    echo "<table class='table table-striped'>";
    echo 
    "<tr>
        <th style='text-align: center;'>Name</th>
        <th style='text-align: center;'>Total Amount</th>
        <th></th>
    </tr>";
    foreach ($data as $check) {
        echo "<tr>";
        echo "<td style='text-align: center;'>{$check['username']}</td>";
        echo "<td style='text-align: center;'>{$check['total_amount']}</td>";
        echo 
        "<td style='text-align: center;'>
            <a class='btn btn-info' href='./checksPage.php?check={$check['id']}" . buildQueryString() . "'>Details</a>
        </td>";
        echo "</tr>";
        if(!empty($_GET['check']) && $_GET['check'] == $check['id']) {
            displayUserOrdersTable($check['id'], $filters);
        }
    }
    echo "</table>";

    echo "<nav aria-label='Page navigation example' class='d-flex justify-content-center'>
        <ul class='pagination'>";
        if ($currentPage > 1) {
            $firstLink = "?page=1" . buildQueryString();
            echo "<li class='page-item'><a class='page-link' href='$firstLink'>First</a></li>";
            $prevLink = "?page=".($currentPage - 1) . buildQueryString();
            echo "<li class='page-item'><a class='page-link' href='$prevLink'>Previous</a></li>";
        }
        
        for ($i = 1; $i <= $totalPages; $i++) {
            $pageLink = "?page=".$i . buildQueryString();
            echo "<li class='page-item ".($currentPage == $i ? 'active' : '')."'><a class='page-link' href='$pageLink'>".$i."</a></li>";
        }
        
        if ($currentPage < $totalPages) {
            $nextLink = "?page=".($currentPage + 1) . buildQueryString();
            echo "<li class='page-item'><a class='page-link' href='$nextLink'>Next</a></li>";
            $lastLink = "?page=".$totalPages . buildQueryString();
            echo "<li class='page-item'><a class='page-link' href='$lastLink'>Last</a></li>";
        }
    echo "</ul>
    </nav>";
    echo "</div>";
}

function displayUserOrdersTable($userId, $filters) {
    $orders = getUserCheckOrders($userId, $filters);
    echo 
    "</table>
        <table class='table table-striped w-75 mx-auto text-center'>
            <tr>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th></th>
            </tr>
            ";
            foreach ($orders as $order) {
                echo 
                "<tr>
                    <td>{$order['order_date']}</td>
                    <td>{$order['total_amount']}</td>
                    <td>
                        <a class='btn btn-info' href='./checksPage.php?order={$order['id']}"
                         . buildQueryStringWithCheck() . "'>Details</a>
                    </td>
                </tr>";
                if (!empty($_GET['order']) && $_GET['order'] == $order['id']) {
                    displayOrderItemsTable($order['id']);
                }
            }
            echo "
        </table>
    <table class='table table-striped'>";
}

function displayOrderItemsTable($orderId) {
    $ordersDetails = getOrderDetailsByOrderId($orderId);
    if (!count($ordersDetails)) return;
    echo "</table>
            </div>
            <div class='container'>
                <div class='row row-cols-1 row-cols-md-3 g-4'>";
            foreach ($ordersDetails as $details) {
                echo "<div class='col'>";
                product_card($details['product_name'], $details['product_price'], $details['quantity'],"../assets/{$details['image']}");
                echo "</div>";
            }
            echo "</div>
            </div>
        <div class='container w-75 mx-auto mt-5'>
    <table class='table table-striped w-75 mx-auto text-center'>";
}
?>
