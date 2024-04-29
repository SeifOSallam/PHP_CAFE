<?php

require_once '../db_info.php';
require_once './db_class.php';

$errors = [];

if (empty($_POST['username'])) {
    $errors['username'] = 'Username is required';
}

if (empty($_POST['email'])) {
    $errors['email'] = 'Email is required';
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Email is not correct';
}

if (count($errors)) {
    $errors = json_encode($errors);
    header("Location: ../Views/form.php?errors={$errors}");
    exit();
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
        }
    }
}

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
        $values .= "'$uploadedFilePath',";

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

if (!empty($errors)) {
    $errors = json_encode($errors);
    header("Location: ../Views/form.php?errors={$errors}");
    exit();
}

?>
