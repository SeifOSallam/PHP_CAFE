<?php 
    require './base.php';
    require '../Components/navbar.php';
    require '../Components/checksTable.php';
    require_once '../Controllers/checks.php';

    session_start();

    if(!is_null($_SESSION) && $_SESSION['role'] === 'user')
    {
        header('Location:home.php');
    }

    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    $image = $_SESSION['image'];
    user_navbar($username,$image,$role);
    $currPage = empty($_GET['page'])? 1 : $_GET['page'];
    $filters = array();
    if (!empty($_GET['date_from'])) {
        $filters['date_from'] = $_GET['date_from'];
    }
    if (!empty($_GET['date_to'])) {
        $filters['date_to'] = $_GET['date_to'];
    }
    if (!empty($_GET['user'])) {
        $filters['user'] = $_GET['user'];
    }
    $data = getChecks($currPage, $filters);
    $users = getUsers();
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
            displayChecksTable($data, $users, $currPage, ceil((count($data)+1)/6), $filters);
            if (!count($data)) {
                echo "
                <div class='container w-50 mx-auto mt-5'>
                    <h1 class='text-center'>THERE IS NO DATA</h1>
                </div>
                ";
            }
        ?>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>