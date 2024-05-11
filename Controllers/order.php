<?php
require_once "db_class.php";
require_once "../db_info.php";
require_once "../Views/base.php";
$database = Database::getInstance();

$database->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

function getOrdersOnlyForUserWithPage($id,$page){
    global $database;
    return $database->getOrdersOnlyForUserWithPage($id,$page);
}

function getOrdersOnlyForUserDate($userId, $startDate, $endDate){
    global $database;
    return $database->getOrdersOnlyForUserDate($userId, $startDate, $endDate);
}

function getAllOrders($page, $filters) {
    global $database;
    return $database->getAllOrders($page, $filters);
}

function getUsers() {
    global $database;
    return $database->select('users');
}
function updateOrder($id, $status) {
    global $database;
    $database->update("orders", $id, "status='{$status}'");
}
function CancelOrder($id){
    global $database;
    $database->update("orders", $id, "status='Cancelled'");
    $database->restockProducts($id);
}
function getOrderDetailsByOrderId($orderId){
    global $database;
    return $database->getOrderDetailsByOrderId($orderId);
}
function getOrdersCount($filters) {
    global $database;
    return $database->getOrdersCount($filters);
}
if (isset($_GET['cancelled'])) {
    $cancelledOrderId = $_GET['cancelled'];
    CancelOrder($cancelledOrderId);
    header("Location: ../Views/showOrders.php");
}


?>