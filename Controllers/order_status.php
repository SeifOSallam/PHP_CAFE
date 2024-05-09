<?php
    require "order.php";
    
    updateOrder($_GET['id'], $_GET['status']);

    header('Location: ../Views/showOrdersAdmin.php');

?>