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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forget Password</h2>
        <?php if (!empty($message)) : ?>
            <div class="message <?= strpos($message, 'successfully') !== false ? 'success' : '' ?>"><?= $message ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" required>
            </div>
            <div>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" required>
            </div>
            <div>
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>
