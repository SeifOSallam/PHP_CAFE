<?php
// require_once '../db_info.php';
// require_once '../Controllers/db_class.php';

// session_start();

// if (!is_null($_SESSION['id'])) {
//     header("location: ./home.php");
//     exit(); 
// }

// $error_messages = []; 

// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//     if (empty($_POST['email']) || empty($_POST['password'])) {
//         $error_messages[] = "Please enter both email and password.";
//     } else {
//         $email = $_POST['email'];
//         $password = $_POST['password'];

//         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             $error_messages[] = "Invalid email address.";
//         } else {
//             try {
//                 $database = Database::getInstance();

//                 $user = $database->findOneUserByEmail($email);
//                  //var_dump($user);
//                 if ($user === false || !isset($user['email'])) {
//                     $error_messages[] = "User not found.";
//                 } else {
//                     if (!$database->comparePassword($email, $password)) {
//                       //  var_dump($password);
//                       //  var_dump($user['password']);
//                         $error_messages[] = "Incorrect password. Please enter the correct password.";
//                     } else {
//                         session_start();
//                         $_SESSION['id'] = $user['id'];
//                         $_SESSION['username'] = $user['username'];
//                         $_SESSION['image'] = $user['image'];
//                         $_SESSION['role'] = $user['role'];

//                         if ($user['role'] == 'admin') {
//                             header('Location: ../Views/admin_landing_page.php');
//                             exit(); 
//                         } elseif ($user['role'] == 'user') {
//                             header('Location: ../Views/home.php');
//                             exit(); 
//                         } else {
//                             $error_messages[] = "Invalid role.";
//                         }
//                     }
//                 }
//             } catch(PDOException $e) {
//                 echo $e->getMessage(); 
//             }
//         }
//     }
// }
?>
