<?php
session_start();
include('../lib/header.php');
include('../db/connect.php');
?>
    <link rel="stylesheet" href="../stylesheet/main.css">
    <script src="../script/login.js"></script>
    <title>Login</title>
</head>
<?php
if(isset($_SESSION['userid'])) {
    header("Location: /orbs");
}else if(!isset($_POST['submit-button'])) {
?>
<body>
    <nav class="navbar navbar-expand-sm bg-warning navbar-light">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">ORBS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="../register" class="nav-link">Signup</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--<div class="back">-->
        <?php 
            if(isset($_GET['status'])){
                if($_GET['status']=='success') {
                    echo "<p>Successfully registered, Login Now</p>";
                }else if($_GET['status']=='failed'){
                    echo "<p>Failed to Login</p>";
                }else if($_GET['status'] == 'resetfailed') {
                    echo "<p>Failed to reset password</p>";
                }else if($_GET['status'] == 'resetsuccess') {
                    echo "<p>Password successfully reset, Login Now</p>";
                }
            }
        ?>
        <div class="div-center">
            <div class="content">
                <h3>Login</h3>
                <hr>
                <form method="post" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="username" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div> <br>
                    <div class="form-group">
                        <label for="selection">Select type of the account</label>
                        <select class="form-select" id="selection" name="account-type" aria-label="Default select example">
                            <option value="customer">customer</option>
                            <option value="restaurant">restaurant</option>
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="submit-button">Login</button>
                    <hr>
                    <a href="../register">Signup</a>
                    &nbsp;&nbsp;
                    <a href="../reset">Reset Password</a>
                </form>
            </div>
        </div>
    <!--</div> -->
<?php
}else {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = hash('md5',$_POST['password']);
    //$password = mysqli_real_escape_string($conn, $_POST['password']);
    $account_type = mysqli_real_escape_string($conn, $_POST['account-type']);
    
    if($account_type == "customer")
        $query = "select * from customer where email='$username' AND password='$password' AND active=1";
    else if($account_type == "restaurant")
        $query = "select * from restaurant where email='$username' AND password='$password' AND active=1";

    $res = mysqli_query($conn, $query);
    if(mysqli_num_rows($res)>0) {
        $res = mysqli_fetch_assoc($res);
        $userid = $res['id'];
        $_SESSION['userid'] = $userid;
        $_SESSION['account-type'] = $account_type;
        header("Location: /orbs");
    }else {
        echo "<br>Failed to login";
        header("Location: /orbs/login?status=failed");
    }
}

include('../lib/footer.php');
mysqli_close($conn);
?>