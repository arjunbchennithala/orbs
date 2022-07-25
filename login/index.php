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
    Login page <br>

    <form method="post">
        <input type="email" name="username" placeholder="Email id" required>  <br>
        <input type="password" name="password" placeholder="Password" required> <br>
        <select name="account-type" required>
            <option value="customer">customer</option>
            <option value="restaurant">restaurant</option>
        </select> <br>
        <input type="submit" name="submit-button" value="Login">  <br>
    </form>

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