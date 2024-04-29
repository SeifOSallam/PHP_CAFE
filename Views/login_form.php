<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<?php

session_start();

if(isset($_SESSION['id']) && !is_null($_SESSION['id'])){
    header("location: ./home.php");
    exit(); 
}
?>
<form class="p-5" action='../Controllers/login.php' method='POST'>
    <div class="mb-3">
        <label for="email" class="">Email address</label>
        <input type="email" class="form-control" id="email" name='email' aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="">Password</label>
    <input type="password" class="form-control" name='password' id="password">
  </div>
  <div class="mt-3">
    <a href="reset_password_form.php">Forgot your password? Reset it here.</a>
</div>
<br>
    <button type="submit" class="btn btn-primary">Submit</button>


</form>
