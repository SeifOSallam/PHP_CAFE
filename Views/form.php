<?php

require_once '../db_info.php';
require_once '../Controllers/db_class.php';
require_once '../Views/base.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['username'])) {
        $errors['username'] = 'Username is required';
    } else {
        $username = $_POST['username'];
        $database = Database::getInstance();
        $existingUser = $database->selectOne(DB_TABLE, '*', "username = '$username'");
        if ($existingUser) {
            $errors['username'] = 'Username already exists';
        }
    }

    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required';
    } else {
        $email = $_POST['email'];
        $existingEmail = $database->selectOne(DB_TABLE, '*', "email = '$email'");
        if ($existingEmail) {
            $errors['email'] = 'Email already exists';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email is not correct';
        }
    }

    if ($_POST['password'] !== $_POST['confirm_password']) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    if (!empty($_FILES['image']['tmp_name'])) {
        $filename = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        $file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_extensions)) {
            $errors['image'] = "Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
        } else {
            $saved = move_uploaded_file($tmp_name, "../assets/{$filename}");
        }
    } else {
        $errors['image'] = "Image is required";
    }

// Check if the room number exists
// $room_id = $_POST['room_id'];
// if (!empty($room_id)) {
//     $existingRoom = $database->selectOne('rooms', '*', "id = $room_id");
//     if (!$existingRoom) {
//         $errors['room_id'] = 'Room does not exist';
//     }
// } else {
//     $errors['room_id'] = 'Room number is required';
// }
// if (empty($_POST['room_id'])) {
//     $errors['room_id'] = 'Room number is required';
// } else {
//     // Check if the room number exists in the database
//     $room_id = $_POST['room_id'];
//     $existingRoom = $database->selectOne('rooms', '*', "id = $room_id");
//     if (!$existingRoom) {
//         $errors['room_id'] = 'Selected room does not exist';
//     }
// }

if (empty($errors)) {
    try {
        $database = Database::getInstance();
        $columns = '';
        $values = '';
        foreach ($_POST as $key => $value) {
            if ($key === 'confirm_password') continue;
            if ($key === 'roomnumber') $key = 'room_id';
            $columns .= "$key,";
            $values .= "'$value',";
        }
        $columns .= "image";
        $values .= "'$filename',";

        $columns = rtrim($columns, ',');
        $values = rtrim($values, ',');

        $res = $database->insert(DB_TABLE, $columns, $values);

        if ($res) {
            header("Location: ../Views/admin_home.php");
            exit();
        } else {
            $errors['database'] = 'Failed to insert into database';
        }
    } catch (PDOException $e) {
        $errors['database'] = $e->getMessage();
    }
}

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 500px;
            margin: 50px auto;
            border-radius: 10px;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
        }

        .btn-primary {
            border-radius: 5px;
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar-brand {
            color: #fff;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../Views/admin_home.php">All Users</a>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Add User</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username">Name</label>
                    <input type="text" class="form-control" id="username" name="username">
                    <p class="error-message">
                        <?php echo isset($errors['username']) ? $errors['username'] : ''; ?>
                    </p>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                    <p class="error-message">
                        <?php echo isset($errors['email']) ? $errors['email'] : ''; ?>
                    </p>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    <p class="error-message">
                        <?php echo isset($errors['confirm_password']) ? $errors['confirm_password'] : ''; ?>
                    </p>
                </div>

                <div class="form-group">
    <label for="room_id">Room Number</label>
    <select class="form-control" id="room_id" name="room_id">
        <?php
        try {
            $room_numbers = $database->selectAllRooms();
            foreach ($room_numbers as $room) {
                echo "<option value='{$room['id']}'>{$room['room_number']}</option>";
            }
        } catch (Exception $e) {
            echo "<option value=''>Error fetching room numbers</option>";
        }
        ?>
    </select>
</div>
                <div class="form-group">
                    <label for="image">Profile Picture</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    <p class="error-message">
                        <?php echo isset($errors['image']) ? $errors['image'] : ''; ?>
                    </p>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Save</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>