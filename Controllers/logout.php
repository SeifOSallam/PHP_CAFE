<?php

session_start(); 

unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['image']);
unset($_SESSION['role']);

setcookie("PHPSESSID", "", time() - 3600, "/" , "", 0);
session_destroy(); 

echo "logged out successfully";

echo "<a href='../Views/login_form.php' class='btn btn-primary'> login  </a>";

?>