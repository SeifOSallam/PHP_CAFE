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

function getAllOrdersWithPage($page){
    global $database;
    return $database->getAllOrdersWithPage($page);
}

function getAllOrdersWithDate($startDate, $endDate){
    global $database;
    return $database->getAllOrdersWithDate($startDate, $endDate);
}

function CancelOrder($id){
    global $database;
    $database->update("orders", $id, "status='Cancelled'");
}
function getOrderDetailsByOrderId($orderId){
    global $database;
    return $database->getOrderDetailsByOrderId($orderId);
}

if (isset($_GET['cancelled'])) {
    $cancelledOrderId = $_GET['cancelled'];
    CancelOrder($cancelledOrderId);
    header("Location: ../Views/showOrdersAdmin.php");
}


?>