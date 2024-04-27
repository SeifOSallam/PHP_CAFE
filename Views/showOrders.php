<?php 
include "../Controllers/order.php";

if (isset($_GET['cancelled'])) {
    $cancelledOrderId = $_GET['cancelled'];
    CancelOrder($cancelledOrderId);
}

if (isset($_POST['start_date']) && isset($_POST['end_date'])) {

    $orders = getOrdersForUserDate("2", $_POST['start_date'], $_POST['end_date']);
} else {

    $orders = getOrdersForUser("2");
}

$totalPrice = 0;

$combinedOrders = array();

foreach ($orders as $order) {
    $orderId = $order['order_id'];
    if (!isset($combinedOrders[$orderId])) {
        $combinedOrders[$orderId] = array(
            "order_id" => $orderId,
            "order_date" => $order['order_date'],
            "total_amount" => $order['total_amount'],
            "notes" => $order['notes'],
            "room_id" => $order['room_id'],
            "status" => $order['status'],
            "items" => array()
        );
    }
    $combinedOrders[$orderId]['items'][] = array(
        "product_name" => $order['product_name'],
        "product_price" => $order['product_price'],
        "quantity" => $order['quantity'],
        "image" => $order['image']
    );
    $orderTotalPrice = 0;
    foreach ($combinedOrders[$orderId]['items'] as $item) {
        $orderTotalPrice += $item['product_price'] * $item['quantity'];
    }

    $combinedOrders[$orderId]['orderTotalPrice'] = $orderTotalPrice;
    $totalPrice += $orderTotalPrice; 
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

<div class="container text-center container-margin-top"> 
    <form method="post" action="showOrders.php">
        <label for="start">From:</label>
        <input type="date" id="start" name="start_date" value="<?php echo date('Y-m-d'); ?>"  placeholder="YYYY-MM-DD" required>
        <label for="end">To:</label>
        <input type="date" id="end" name="end_date" value="<?php echo date('Y-m-d'); ?>"  placeholder="YYYY-MM-DD" required>
        <input type="submit" value="Filter">
    </form>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Order Date</th>
                <th scope="col">Total Price</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($combinedOrders as $order): ?>
            <tr>
                <td><?php echo $order['order_date']; ?></td>
                <td><?php echo $order['total_amount'].'$'; ?></td>
                <td><?php echo $order['status']; ?></td>
                <td>
                    <?php if ($order['status'] === 'Processing'): ?>
                        <button class="btn btn-danger cancel-btn" data-order-id="<?php echo $order['order_id']; ?>">
                            <a href="../Controllers/order.php?cancelled=<?php echo $order['order_id']; ?>"  style="text-decoration: none; color: white;">Cancel</a>
                        </button>
                    <?php endif; ?>
                    <button class="btn btn-info details-btn" data-order-id="<?php echo $order['order_id']; ?>" onclick="toggleOrderDetails(<?php echo $order['order_id']; ?>)">Show Details</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="container">
    <div class="row">
        <?php foreach ($combinedOrders as $order): ?>
            <div class="order-details" id="order-details-<?php echo $order['order_id']; ?>" style="display: none;">
                <div class="col-12">
                    <h3><?php echo   'Order ID: '.$order["order_id"]; ?></h3>
                    <div class="row">
                        <?php $count = 0; ?>
                        <?php foreach ($order['items'] as $item): ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card">
                                    <img src="../assets/images/<?php echo $item['image']; ?>" alt="<?php echo $item['product_name']; ?>" style="width:100%; height: 200px;">
                                    <div class="container">
                                        <h4><b><?php echo $item['product_name']; ?></b></h4>
                                        <p><strong>Quantity:</strong> <?php echo $item['quantity']; ?></p>
                                        <p><strong>Price:</strong> $<?php echo $item['product_price'].'$'; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $count++;
                            if ($count % 4 === 0) {
                                echo '</div><div class="row">';
                            }
                            ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="total-price">
                            <h5>Total Price:</h5>
                            <p>$<?php echo   $order['orderTotalPrice'].'$'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function toggleOrderDetails(orderId) {
        var orderDetails = document.getElementById("order-details-" + orderId);
        if (orderDetails.style.display === "none") {
            orderDetails.style.display = "block";
        } else {
            orderDetails.style.display = "none";
        }
    }
</script>

</body>
</html>