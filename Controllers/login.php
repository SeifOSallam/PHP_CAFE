<?php
require_once '../db_info.php';
require_once '../db_connection.php';
require_once './db_class.php';

try {
    $database = Database::getInstance();
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $database->findOneUser($email, $password);
    var_dump($user[0]['role']);

    if ($user[0]) {
        session_start();

        if ($user[0]['role'] == 'admin') {
            
            header('Location: ../Views/admin_home.php');
            exit(); 
        } elseif ($user[0]['role'] == 'user') {
            header('Location: ../Views/home.php');
            exit(); 
    } else {
        header("Location: ../Views/login_form.php");
        exit();
     }
    }
} catch(PDOException $e) {
    echo $e->getMessage(); 
}
?>
