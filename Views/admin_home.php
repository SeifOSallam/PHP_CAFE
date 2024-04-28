<?php
require_once '../Controllers/utils.php';
require_once '../Controllers/db_class.php';
require '../Components/navbar.php';

session_start();
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$image = $_SESSION['image'];
?>




<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>
    <style>
        
        .add-user-button {
            background-color: #007bff; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            margin-left: 900px; 
        }
        .container {
            margin: 0 auto;
            width: 80%; 
        }
    </style>
</head>
<body>
    <?php user_navbar($username,$image,$role)  ?>
    <div class="container my-5">
        <h1>All Users</h1>

        <button class="add-user-button" onclick="navigateToForm()">Add User</button>

        <?php
        $database = Database::getInstance();
        $rows = $database->getAllUsers();
        display_table($rows);
        ?>

    </div>

    <script>
        function navigateToForm() {
            window.location.href = '../Views/form.php';
        }
    </script>
</body>
</html>
