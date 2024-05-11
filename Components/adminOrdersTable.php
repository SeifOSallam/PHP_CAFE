<?php
require_once '../Controllers/order.php';
require_once 'pagination.php';
require 'filterBuilder.php';
require 'order_product.php';


function displayOrdersTable($data, $users, $currentPage, $totalPages, $filters){
    echo "<div class='container w-75 mx-auto' style='margin-top:2.5rem;'>";
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
            <input class='form-control' type='date' id='date_to' name='date_to' >
        </div>
        <div class='col-lg-3 col-sm-6 d-flex justify-content-center'>
            <input class='btn btn-info' type='submit' value='Filter'>
        </div>

    </form>";
    echo "<table class='table table-striped'>";
    echo 
    "<tr>
        <th class='text-center'>Order Date</th>
        <th class='text-center'>Name</th>
        <th class='text-center'>Room</th>
        <th class='text-center'>Total Amount</th>
        <th class='text-center'>Status</th>
        <th class='text-center'>Actions</th>
    </tr>";
    foreach ($data as $order) {
        echo "<tr>";
        echo "<td style='text-align: center;'>{$order['order_date']}</td>";
        echo "<td style='text-align: center;'>{$order['username']}</td>";
        echo "<td style='text-align: center;'>{$order['room_number']}</td>";
        echo "<td style='text-align: center;'>{$order['total_amount']}</td>";
        echo "<td style='text-align: center;'>";
        echo "<form action='../Controllers/order_status.php' method='GET'>";
        $userparam = empty($_GET['user'])? '' : $_GET['user'];
        $datefromparam = empty($_GET['date_from'])? '' : $_GET['date_from'];
        $datetoparam = empty($_GET['date_to'])? '' : $_GET['date_to'];
        echo "<input type='hidden' name='id' value='{$order['id']}'>";
        echo "<input type='hidden' name='page' value='{$currentPage}'>";
        echo "<input type='hidden' name='user' value='{$userparam}'>";
        echo "<input type='hidden' name='date_from' value='{$datefromparam}'>";
        echo "<input type='hidden' name='date_to' value='{$datetoparam}'>";
        if ($order['status'] == 'Cancelled') {
            echo "<span class='text-danger fw-bold'>Cancelled</span>";
        }
        else if ($order['status'] != 'Done') {
            echo "<input
            class='btn btn-success' 
            type='submit' name='status' value='Done'>";
        }
        else {
            echo "<span class='text-success fw-bold'>Delivered</span>";
        }
        echo "</form>";
        echo "</td>";
        echo 
        "<td style='text-align: center;'>
            <a class='btn btn-info' href='./showOrdersAdmin.php?page={$currentPage}&order={$order['id']}" . buildQueryString() . "'>Details</a>
        </td>";
        echo "</tr>";
        if(!empty($_GET['order']) && $_GET['order'] == $order['id']) {
            displayOrderItemsTable($order['id']);
        }
    }
    echo "</table>";
    paginate($currentPage, $totalPages, buildQueryString());

    echo "</div>";
}

function displayOrderItemsTable($orderId) {
    $ordersDetails = getOrderDetailsByOrderId($orderId);
    if (!count($ordersDetails)) return;
    echo "</table>
            </div>
            <div class='container'>
                <div class='row'>";
            foreach ($ordersDetails as $details) {
                echo "<div class='col-lg-3 col-md-6 col-sm-12'>";
                product_card($details['product_name'], $details['product_price'], $details['quantity'],"../assets/{$details['image']}");
                echo "</div>";
            }
            echo "</div>
            </div>
        <div class='container mx-auto mt-5'>
    <table class='table table-striped mx-auto text-center'>";
}
?>
