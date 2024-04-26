<?php

require_once '../db_info.php';
require_once '../db_connection.php';
require_once '../Controllers/db_class.php';

try
{
    $database = Database::getInstance();
    $email = $_POST['email'];
    $password = $_POST['password'];

    $res = $database->findOneUser($email,$password);

   if($res)
    {
        session_start(); 
        header('Location: ../admin/admin_home.php');
    }
    else
    {
        header("Location:login_form.php");
    }

}
catch(PODException $e)
{
    echo $e;
}
?>