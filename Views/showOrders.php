<?php 
include "../Controllers/order.php";
session_start();
if(isset($_SESSION) && !is_null($_SESSION)){
    $userID = $_SESSION['id'];
}
if (isset($_GET['cancelled'])) {
    $cancelledOrderId = $_GET['cancelled'];
    CancelOrder($cancelledOrderId);
}

if(!is_null($_SESSION) && $_SESSION['role'] === 'admin')
{
    header('Location:admin_landing_page.php');
}

if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $orders = getOrdersOnlyForUserDate($userID, $_POST['start_date'], $_POST['end_date']);
} else {
    if(isset($_GET['page']))
    {
        $orders = getOrdersOnlyForUserWithPage($userID,$_GET['page']);
    }
    
    if(!isset($_GET['page']))
    {
        $orders = getOrdersOnlyForUserWithPage($userID,1);
    }
    if (isset($_GET['details']) && $_GET['details'] === 'true' && isset($_GET['orderId'])) {
        $orderId = $_GET['orderId'];
        $orderDetails = getOrderDetailsByOrderId($orderId);
    }
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
<?php require '../Components/navbar.php';
      user_navbar($_SESSION['username'],$_SESSION['image'],$_SESSION['role']);
?>

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
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['order_date']; ?></td>
                    <td><?php echo $order['total_amount']; ?></td>
                    <td><?php echo $order['status']; ?></td>
                    <td>
                        <?php if ($order['status'] === 'Processing'): ?>
                            <button class="btn btn-danger cancel-btn" data-order-id="<?php echo $order['id']; ?>">
                                <a href="../Controllers/order.php?cancelled=<?php echo $order['id']; ?>" style="text-decoration: none; color: white;">Cancel</a>
                            </button>
                        <?php endif; ?>
                        <a class="btn btn-info details-btn" href="?details=true&orderId=<?php echo $order['id']; ?>">Show Details</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<div class="container">
    <div class="row">
        <?php if (!empty($orderDetails)): ?>
            <?php foreach ($orderDetails as $detail): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="../assets/images/<?php echo $detail['image']; ?>" alt="<?php echo $detail['product_name']; ?>" style="width:100%; height: 200px;">
                        <div class="container">
                            <h4><b><?php echo $detail['product_name']; ?></b></h4>
                            <p><strong>Quantity:</strong> <?php echo $detail['quantity']; ?></p>
                            <p><strong>Price:</strong> $<?php echo $detail['product_price']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="total-price">
                            <h5>Total Price:</h5>
                            <p>$<?php echo  $detail["total_amount"].'$'; ?></p>
                        </div>
            </div>
        <?php endif; ?>
      
    </div>
    <div class="inline-block text-center">
                <?php
                for ($i=1 ; $i <= (20/6)+1; $i++)
                {
                    echo "<a href='?page=$i' class='btn btn-primary mx-2'>$i</a>";
                }
                ?>
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
