<?php 
    require_once 'db_class.php';
    require_once '../db_info.php';

    $database = Database::getInstance();

    $database->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    function getChecks($page, $filters) {
        global $database;
        return $database->getChecks($page, $filters);
    }
    function getUsers() {
        global $database;
        return $database->select('users');
    }
    function getOrdersCount() {
        global $database;
        return $database->getCount('orders');
    }
?>