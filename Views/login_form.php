<?php
require_once '../db_info.php';
require_once '../Controllers/db_class.php';

session_start();

if (!is_null($_SESSION['id'])) {
    header("location: ./home.php");
    exit(); 
}

$error_messages = []; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error_messages[] = "Please enter both email and password.";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_messages[] = "Invalid email address.";
        } else {
            try {
                $database = Database::getInstance();

                $user = $database->findOneUserByEmail($email);
                 //var_dump($user);
                if ($user === false || !isset($user['email'])) {
                    $error_messages[] = "User not found.";
                } else {
                    if (!$database->comparePassword($email, $password)) {
                      //  var_dump($password);
                      //  var_dump($user['password']);
                        $error_messages[] = "Incorrect password. Please enter the correct password.";
                    } else {
                        session_start();
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['image'] = $user['image'];
                        $_SESSION['role'] = $user['role'];

                        if ($user['role'] == 'admin') {
                            header('Location: ../Views/admin_landing_page.php');
                            exit(); 
                        } elseif ($user['role'] == 'user') {
                            header('Location: ../Views/home.php');
                            exit(); 
                        } else {
                            $error_messages[] = "Invalid role.";
                        }
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage(); 
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafetria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 4px;
            border: 1px solid #ced4da;
        }
        .btn-primary {
            border-radius: 4px;
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Cafetria</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <?php if (!empty($error_messages)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($error_messages as $error_message) : ?>
                        <p><?php echo $error_message; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="email">Email address</label>
                <input class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="form-group mt-3">
                <a href="reset_password_form.php">Forgot your password? Reset it here.</a>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
