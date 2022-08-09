<?php
session_start();
include('../db/connect.php');
if(isset($_SESSION['admin'])) {
    if($_SESSION['admin']== true)
        header('Location: dashboard.php');
}else{
    if(!isset($_POST['submit-button'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-login</title>
    <link href="/orbs/stylesheet/bootstrap.min.css" rel="stylesheet">
    <script src="/orbs/script/jquery.min.js"></script>
    <link rel="stylesheet" href="/orbs/stylesheet/jquery-ui.css">
  <script src="/orbs/script/jquery-3.6.0.js"></script>
  <script src="/orbs/script/jquery-ui.js"></script>
  <link rel="stylesheet" href="/orbs/stylesheet/main.css"></link>

</head>
<body>
<nav class="navbar navbar-expand-sm sticky-top bg-warning navbar-light">
  <div class="container-fluid">
      <a href="#" class="navbar-brand">ORBS</a>
  </div>
</nav>
<div class="back">
    <div class="div-center-admin">
    <form method="post" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div> <br>
                    <br>
                    <button type="submit" class="btn btn-primary" name="submit-button">Login</button>
                    <hr>
                </form>
    </div>
</div>

</body>
</html>
<?php
    }else{
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = hash('md5', $_POST['password']);
        $query = "select * from admin where username='$username' and password='$password'";
        $res = mysqli_query($conn, $query);
        var_dump($res);
        if(mysqli_num_rows($res)>0) {
            $_SESSION['admin'] = true;
            header("Location: dashboard.php");
        }
       
    }
}
?>