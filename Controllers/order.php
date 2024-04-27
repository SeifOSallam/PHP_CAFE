<?php
require_once "db_class.php";
require_once "../db_info.php";
require_once "../Views/base.php";
$database = Database::getInstance();

$database->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

function getOrdersForUser($id){
    global $database;
    return $database->getOrdersForUser($id);
}

function getOrdersForUserDate($userId, $startDate, $endDate){
    global $database;
    return $database->getOrdersForUserDate($userId, $startDate, $endDate);
}
function CancelOrder($id){
    global $database;
    $database->update("orders", $id, "status='Cancelled'");
}
if (isset($_GET['cancelled'])) {
    $cancelledOrderId = $_GET['cancelled'];
    CancelOrder($cancelledOrderId);
    header("Location: ../Views/showOrders.php");
}

// getOrdersForUser("2");
?>