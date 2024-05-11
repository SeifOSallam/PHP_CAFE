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
            if (empty($data)) {
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '<strong>' . "No checks found" . '</strong>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            }
            displayChecksTable($data, $users, $currPage, floor((count($data)/6)+1), $filters);
            
        ?>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>