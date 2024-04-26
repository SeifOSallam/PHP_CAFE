<?php
require_once  '../db_connection.php';
require_once  '../db_info.php';
require_once '../Controllers/db_class.php';

$errors = [];

if(isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
} else {
    $errors['id'] = 'User ID is missing';
}

if(empty($_POST['username'])) {
    $errors['username'] = 'Username is required';
}

if(empty($_POST['email'])) {
    $errors['email'] = 'Email is required';
}

if (!isset($errors['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Email is not correct';
}


if(count($errors)) {
    $errors = json_encode($errors);
    $old_data = json_encode($_POST);
    header("Location:update_form.php?errors={$errors}&old_data={$old_data}");
    exit();
}

try {
    $updates = '';

    foreach($_POST as $key => $value) {
        if ($key === 'roomnumber') $key = 'room_id';
        $updates .= $key . "='" . $value . "',";
    }

    if (isset($_FILES['image']['tmp_name'])) {
        $filename = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $allowed = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'JPEG', 'JPG', 'PNG', 'GIF', 'BMP');

        if (!in_array($extension, $allowed)) {
            $errors['image'] = 'Wrong file format';
        } else {
            $uploadDir = '../assets/images/';
            $uploadedFilePath = $uploadDir . $filename;
            $saved = move_uploaded_file($tmp_name, $uploadedFilePath);
            if (!$saved) {
                $errors['image'] = 'Failed to save image';
            } else {
                $updates .= "image='" . $uploadedFilePath . "',";
            }
        }
    }

    $updates = rtrim($updates, ',');

    $database = Database::getInstance();
    $res = $database->update(DB_TABLE, $user_id, $updates);

    if($res) {
        header("Location:admin_home.php");
    }

} catch(PDOException $e) {
    header('Location:update_form.php');
}
?>
