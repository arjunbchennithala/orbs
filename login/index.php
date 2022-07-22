<?php
session_start();
include('../lib/header.php');
include('../db/connect.php');
?>
    <title>Login</title>
</head>
<?php
if(!isset($_POST['submit-button'])) {
?>
<body>
    Login page <br>
    <form method="post">
        <input type="text" name="username" placeholder="Email"> <br>
        <input type="text" name="password" placeholder="Password"> <br>
        <select name="account-type">
            <option value="customer">customer</option>
            <option value="restaurant">restaurant</option>
        </select> <br>
        <input type="submit" value="Login" name="submit-button">
    </form>
<?php
}else if(isset($_SESSION['userid'])) {
    include('../lib/footer.php');
    header("Location: /orbs");
}else {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $account_type = mysqli_real_escape_string($conn, $_POST['account-type']);
    
    if($account_type == "customer")
        $query = "select * from customer where email='" . $username . "' AND password='" . $password . "'";
    else if($account_type == "restaurant")
        $query = "select * from restaurant where email='" . $username . "' AND password='" . $password . "'";

    $res = mysqli_query($conn, $query);
    if(mysqli_num_rows($res)>0) {
        $res = mysqli_fetch_assoc($res);
        $userid = $res['id'];
        echo $userid;
        $_SESSION['userid'] = $userid;
        $_SESSION['account-type'] = $account_type;
        include('../lib/footer.php');
        header("Location: /orbs");
    }else {
        echo "<br>Failed to login";
        include('../lib/footer.php');
    }
}

?>