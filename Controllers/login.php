<?php
require_once '../db_info.php';
require_once './db_class.php';

try {
    $database = Database::getInstance();

    if(empty($_POST['email']) || empty($_POST['password'])) {
        header("Location: ../Views/login_form.php?error=empty");
        exit();
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $database->findOneUser($email, $password);
    var_dump($user);
    if ($user[0]) {
        session_start();
        $_SESSION['id'] = $user[0]['id'];
        $_SESSION['username'] = $user[0]['username'];
        $_SESSION['image'] = $user[0]['image'];
        if ($user[0]['role'] == 'admin') {
            header('Location: ../Views/admin_home.php');
            exit(); 
        } elseif ($user[0]['role'] == 'user') {
            header('Location: ../Views/home.php');
            exit(); 
        } else {
            header("Location: ../Views/login_form.php?error=invalid_credentials");
            exit();
        }
    } else {
        header("Location: ../Views/login_form.php?error=invalid_credentials");
        exit();
    }
} catch(PDOException $e) {
    echo $e->getMessage(); 
}
?>