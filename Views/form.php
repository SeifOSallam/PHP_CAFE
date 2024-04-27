<?php
$errors = isset($_GET['errors']) ? json_decode($_GET['errors']) : (object)[];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Add User</h2>
        <form method="POST" action="../Controllers/add_user.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Name</label>
                <input type="text" class="form-control" id="username" name="username">
                <p class='text-danger fw-bold '>
                    <?php echo isset($errors->username) ? $errors->username : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email">
                <p class="text-danger fw-bold ">
                    <?php echo isset($errors->email) ? $errors->email : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            </div>

            <div class="form-group">
                <label for="room_id">Room Number</label>
                <input type="number" class="form-control" id="room_id" name="room_id" >
            </div>

            <div class="form-group">
                <label for="image">Profile Picture</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
