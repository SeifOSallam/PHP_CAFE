<?php
require_once '../db_info.php';
require_once '../Controllers/db_class.php';

$errors = [];

if(isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
} else {
    $errors['id'] = 'User ID is missing';
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    if(empty($_POST['username'])) {
        $errors['username'] = 'Username is required';
    }

    if(empty($_POST['email'])) {
        $errors['email'] = 'Email is required';
    }

    if (!isset($errors['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email is not correct';
    }

    // File validation for image format
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedFormats = ['jpg', 'jpeg', 'png', 'gif']; // Add more if needed
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        
        if(!in_array(strtolower($fileExtension), $allowedFormats)) {
            $errors['image'] = 'Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.';
        }
    }

    if(count($errors) === 0) {
        try {
            $database = Database::getInstance();
            $existingUser = $database->getUserById($user_id)[0];

            // Check if the new username already exists
            $newUsername = $_POST['username'];
            $existingUserByUsername = $database->getUserByUsername($newUsername);

            if ($existingUserByUsername && $existingUserByUsername['id'] != $user_id) {
                // If the username exists for another user, show an error
                $errors['username'] = 'Username already exists';
            }

            // Check if the new email already exists
            $newEmail = $_POST['email'];
            $existingUserByEmail = $database->getUserByEmail($newEmail);
            
            if ($existingUserByEmail && $existingUserByEmail['id'] != $user_id) {
                // If the email exists for another user, show an error
                $errors['email'] = 'Email already exists';
            }

            if(empty($errors)) {
                $updates = '';

                foreach($_POST as $key => $value) {
                    // Exclude the 'submit' field from the update process
                    if ($key !== 'submit' && $key !== 'image') {
                        if ($key === 'roomnumber') $key = 'room_id';
                        $updates .= $key . "='" . $value . "',";
                    }
                }

                // Handle image upload
                if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $targetDir = "../assets/";
                    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
                    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
                    $updates .= "image='" . $targetFile . "',";
                }

                // Remove trailing comma
                $updates = rtrim($updates, ',');

                $res = $database->update(DB_TABLE, $user_id, $updates);

                if($res) {
                    header("Location:../Views/admin_home.php");
                }
            }

        } catch(PDOException $e) {
            header('Location:../Views/update_form.php');
        }
    }
}

// Fetch existing user data
try {
    $database = Database::getInstance();
    $existing_room_numbers = $database->getRoomNumbers();
    $old_data = $database->getUserById($user_id)[0];
} catch(PDOException $e) {
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar-brand {
            color: #fff;
        }

        .form-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-top: 20px;
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
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-weight: bold;
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
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="form-container">
                    <h2 class="text-center mb-4">Update User</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="username">Name</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $old_data['username']; ?>">
                            <p class="error-message">
                                <?php echo isset($errors['username']) ? $errors['username'] : ''; ?>
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $old_data['email']; ?>">
                            <p class="error-message">
                                <?php echo isset($errors['email']) ? $errors['email'] : ''; ?>
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $old_data['password']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="room_id">Room Number</label>
                            <select class="form-control" id="room_id" name="room_id" required>
                                <?php foreach ($existing_room_numbers as $room_number): ?>
                                    <option value="<?php echo $room_number['id']; ?>" <?php echo ($old_data['room_id'] == $room_number['id']) ? 'selected' : ''; ?>><?php echo $room_number['id']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="error-message">
                                <?php echo isset($errors['room_id']) ? $errors['room_id'] : ''; ?>
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="image">Profile Picture</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                            <p class="error-message">
                                <?php echo isset($errors['image']) ? $errors['image'] : ''; ?>
                            </p>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" name="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
