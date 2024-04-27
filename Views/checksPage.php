<?php 
    require './base.php';
    require '../Components/navbar.php';
    require '../Components/checksTable.php';
    require_once '../Controllers/checks.php';
    $currPage = empty($_GET['page'])? 0 : $_GET['page'];
    $data = getChecks($currPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checks</title>
</head>
<body>
        <?php 
            displayChecksTable($currPage, $data);
        ?>
    
</body>
</html>