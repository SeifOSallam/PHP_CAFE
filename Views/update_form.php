<?php
require_once '../db_connection.php';
require_once '../db_info.php';
require_once '../Controllers/db_class.php';

$user_id = $_GET['id'];
$errors = (isset($_GET['errors'])) ? json_decode($_GET['errors']) : (object)[];

$old_data = [];

if (isset($_GET['old_data'])) {
    $old_data = json_decode($_GET['old_data'], true);
} else {
    try {
        $database = Database::getInstance();
        $old_data = $database->getUserById($_GET['id'])[0];
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Update User</h2>
        <form method="POST" action=<?php echo "../Controllers/update_user.php?id={$user_id}";?> enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Name</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $old_data['username']; ?>">
                <p class='text-danger fw-bold '>
                    <?php echo isset($errors->username) ? $errors->username : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $old_data['email']; ?>">
                <p class="text-danger fw-bold ">
                    <?php echo isset($errors->email) ? $errors->email : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo $old_data['password']; ?>">
            </div>

            <div class="form-group">
                <label for="room_id">Room Number</label>
                <input type="number" class="form-control" id="room_id" name="room_id" value="<?php echo $old_data['room_id']; ?>" required>
            </div>

            <div class="form-group">
                <label for="image">Profile Picture</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
