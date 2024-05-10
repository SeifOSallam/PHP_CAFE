<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../Views/admin_home.php">All Users</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <?php 
    session_start();

    require_once '../Controllers/utils.php';
    require_once '../db_info.php';
    require_once '../Controllers/db_class.php';

    $error_message = ""; 

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $user_id = $_GET['id'];

        if (isset($_SESSION['id']) && $_SESSION['id'] == $user_id) {
            $error_message = "You cannot delete yourself.";
        } else {
            $database = Database::getInstance();

            $database->deleteOrdersForUser($user_id); 

            $result = $database->delete("users", $user_id);

            if ($result) {
                header("Location: ../Views/admin_home.php");
                echo "User deleted successfully.";
            } else {
                $error_message = "Error deleting user.";
            }
        }
    }
    ?>

    <?php if (!empty($error_message)) : ?>
        <div class="container mt-5">
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
