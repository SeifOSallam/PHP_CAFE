<?php
    require "order.php";
    require_once '../Components/filterBuilder.php';
    updateOrder($_GET['id'], $_GET['status']);
    $page = empty($_GET['page'])? 1 : $_GET['page'];
    header("Location: ../Views/showOrdersAdmin.php?page={$page}" . buildQueryString());

?>