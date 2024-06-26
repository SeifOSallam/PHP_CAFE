<?php
require_once '../Controllers/utils.php';
require_once '../Controllers/db_class.php';
require '../Components/navbar.php';

session_start();
$error='';
if(isset($_GET['error'])){
    $error =  $_GET['error'];
  }

if(!is_null($_SESSION) && $_SESSION['role'] === 'user')
{
    header('Location:home.php');
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
$image = $_SESSION['image'];

$records_per_page = 5; 
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

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
    <?php
  if (!empty($error)) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo '<strong>' . $error . '</strong>';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
  }?>
    <div class="container my-5">
        <h1>All Users</h1>

        <button class="add-user-button" onclick="navigateToForm()">Add User</button>

        <?php
        $database = Database::getInstance();
        $total_rows = $database->countAllUsers();
        $total_pages = ceil($total_rows / $records_per_page);

        $rows = $database->getAllUsersPaginated($offset, $records_per_page);
        display_table($rows);

        echo "<ul class='pagination'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li class='page-item'><a class='page-link' href='?page={$i}'>{$i}</a></li>";
        }
        echo "</ul>";
        ?>

    </div>

    <script>
        function navigateToForm() {
            window.location.href = '../Views/form.php';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
