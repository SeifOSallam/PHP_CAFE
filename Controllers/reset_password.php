<?php
require_once '../db_info.php';
require_once './db_class.php';

$message = '';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['username'])) {
        $errors['username'] = 'Username is required';
    }
    else {
        if ($_POST['new_password'] == $_POST['confirm_password']) {
            try {
                $database = Database::getInstance();
                $username = $_POST['username'];
                $newPassword = $_POST['new_password'];
                $result = $database->resetPassword($username, $newPassword);
                if ($result) {
                    $message = "Password updated successfully!";
                } else {
                    $message = "Error updating password. Please try again later.";
                }
            } catch(PDOException $e) {
                $message = "Error updating password: " . $e->getMessage();
            }
        } else {
            $message = "Passwords do not match!";
        }
    }
}

// Load view
require_once '../Views/reset_password_form.php'; 
?>
