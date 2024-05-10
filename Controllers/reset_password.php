<?php
require_once '../db_info.php';
require_once './db_class.php';

$message = '';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['email'])) {
        $errors['email'] = 'email is required';
    }
    else {
        try {
            $database = Database::getInstance();
            $email = $_POST['email'];
            $userExists = $database->checkEmailExists($email);
            if (!$userExists) {
                $errors['email'] = 'email does not exist';
            } else {
                $currentPassword = $database->getCurrentPassword($email);

                if ($_POST['new_password'] == $_POST['confirm_password']) {
                    if ($_POST['new_password'] === $currentPassword) {
                        $errors['new_password'] = 'New password must be different from the current password';
                    } else {
                        $newPassword = $_POST['new_password'];
                        $result = $database->resetPassword($email, $newPassword);
                        if ($result) {
                            $message = "Password updated successfully!";
                        } else {
                            $message = "Error updating password. Please try again later.";
                        }
                    }
                } else {
                    $message = "Passwords do not match!";
                }
            }
        } catch(PDOException $e) {
            $message = "Error checking username: " . $e->getMessage();
        }
    }
}

require_once '../Views/reset_password_form.php'; 
?>
