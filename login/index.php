<?php
session_start();
include('../lib/header.php');
include('../db/connect.php');
?>
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
        <div class="div-center">
            <div class="content">
                <h3>Login</h3>
                <hr>
                <form method="post">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="username" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
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
        $query = "select * from customer where email='$username' AND password='$password'";
    else if($account_type == "restaurant")
        $query = "select * from restaurant where email='$username' AND password='$password'";

    $res = mysqli_query($conn, $query);
    if(mysqli_num_rows($res)>0) {
        $res = mysqli_fetch_assoc($res);
        $userid = $res['id'];
        $_SESSION['userid'] = $userid;
        $_SESSION['account-type'] = $account_type;
        header("Location: /orbs");
    }else {
        echo "<br>Failed to login";
    }
}

include('../lib/footer.php');
mysqli_close($conn);
?>