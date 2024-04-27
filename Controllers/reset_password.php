 <?php
require_once  '../db_info.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['new_password'] == $_POST['confirm_password']) {
        try {

            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASSWORD);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("UPDATE users SET password = :new_password WHERE username = :username");
            
            $stmt->bindParam(':new_password', $_POST['new_password']);
            $stmt->bindParam(':username', $_POST['username']);
            
            $stmt->execute();
            
            $message = "Password updated successfully!";
        } catch(PDOException $e) {
            $message = "Error updating password: " . $e->getMessage();
        }
    } else {
        $message = "Passwords do not match!";
    }
}

// Load view
require_once '../Views/reset_password_form.php'; 
?> 
